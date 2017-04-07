<?php

namespace Deimos\CacheHelper;

class FileHelper extends Helper
{

    protected $extension = 'deimos-file';

    /**
     * @inheritdoc
     */
    protected function hash($data)
    {
        return filemtime($data);
    }

    /**
     * @inheritdoc
     */
    protected function compare($original, $cache)
    {
        return filemtime($original) < filemtime($cache);
    }

}