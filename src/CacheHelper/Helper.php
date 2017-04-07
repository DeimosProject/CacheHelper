<?php

namespace Deimos\CacheHelper;

abstract class Helper
{

    protected $extension;

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
     * @param string $data
     *
     * @return string
     */
    abstract protected function hash($data);

    /**
     * @param string $original
     * @param string $cache
     *
     * @return bool
     */
    abstract protected function compare($original, $cache);

    /**
     * @param $originalPath
     *
     * @return mixed
     * @throws Exceptions\PermissionDenied
     */
    public function getCachePath($originalData)
    {
        $basename    = crc32($originalData) . '.' . ($this->extension ?? 'deimos');
        $hash        = $this->hash($originalData);
        $directories = str_split($hash, 2);

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

        return $this->compare($originalPath, $cachePath);
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
