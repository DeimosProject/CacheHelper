<?php

include_once dirname(__DIR__) . '/vendor/autoload.php';

$fileHelper = new \Deimos\CacheHelper\FileHelper(__DIR__ . '/cache');

if ($fileHelper->valid(__FILE__))
{
    include_once $fileHelper->getCachePath(__FILE__);
    die;
}

echo 'First run! Without cache!';

$fileHelper->save(__FILE__, <<<html
<?php echo 'Have fun code!' ?>
html
);
