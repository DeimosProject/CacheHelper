<?php

namespace Deimos\CacheHelper;

class FileHelper
{

    /**
     * @var string
     */
    protected $cacheDirectory;

    /**
     * FileHelper constructor.
     *
     * @param $cacheDirectory
     */
    public function __construct($cacheDirectory)
    {
        $this->cacheDirectory = rtrim($cacheDirectory, '\\/') . '/';
    }

    /**
     * @param $originalPath
     *
     * @return string
     * @throws Exceptions\PermissionDenied
     */
    public function getCachePath($originalPath)
    {
        $basename    = crc32($originalPath) . '.deimos';
        $time        = filemtime($originalPath);
        $directories = str_split($time, 2);

        array_shift($directories);
        array_shift($directories);

        $fullPath =
            $this->cacheDirectory .
            implode('/', $directories);

        if (!@mkdir($fullPath, 0777, true) && !is_dir($fullPath))
        {
            throw new Exceptions\PermissionDenied($fullPath);
        }

        return $fullPath . '/' . $basename;
    }

    /**
     * @param string $originalPath
     *
     * @return bool
     * @throws Exceptions\PermissionDenied
     */
    public function valid($originalPath)
    {
        $cachePath = $this->getCachePath($originalPath);

        if (!file_exists($cachePath))
        {
            return false;
        }

        return filemtime($originalPath) < filemtime($cachePath);
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

        return file_put_contents($cachePath, $data);
    }

}