<?php

namespace Deimos\CacheHelper;

class FileHelper extends Helper
{

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