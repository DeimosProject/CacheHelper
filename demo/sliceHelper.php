<?php

include_once dirname(__DIR__) . '/vendor/autoload.php';

$sliceHelper = new \Deimos\CacheHelper\SliceHelper(__DIR__ . '/cache');

$builder = new \Deimos\Builder\Builder();
$helper = new \Deimos\Helper\Helper($builder);
$slice = new \Deimos\Slice\Slice($helper, [
    'message' => 'Have fun code!'
]);

if ($sliceHelper->valid($slice))
{
    $newSlice = include $sliceHelper->getCachePath($slice);
    var_dump($slice, $newSlice);
    die;
}

echo 'First run! Without cache!';

$newSlice = clone $slice;
$newSlice['hello'] = 'world';

$sliceHelper->save($slice, $newSlice);
