<?php

namespace Deimos\CacheHelper;

class SliceHelper extends Helper
{

    protected $extension = 'deimos-slice';

    /**
     * @inheritdoc
     */
    protected function hash($data)
    {
        return crc32(serialize($data));
    }

    /**
     * @inheritdoc
     */
    protected function compare($original, $cache)
    {
        return crc32($original) . '.deimos' !== $cache;
    }

    /**
     * @param string          $originalPath
     * @param resource|string $data
     *
     * @return bool|int
     * @throws Exceptions\PermissionDenied
     */
    public function save($originalPath, $data)
    {
        $cachePath = $this->getCachePath($originalPath);

        return file_put_contents(
            $cachePath,
            '<?php return unserialize(\'' . serialize($data) . '\');'
        );
    }

}