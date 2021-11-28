<?php

namespace App\CacheApi;

class CacheFile
{
    private bool $cacheable= false;
    private string $cacheFolder;
    private int $cacheTimeout;

    public function __construct($cache = TRUE, $folder = 'dcf', $cacheTimeout = 7200)
    {

        $this->cacheFolder = ($folder == 'dcf') ?  dirname(__FILE__).'/JsonCurrencies/': $folder;

        if (is_writable($this->cacheFolder) && $cache == TRUE) {
            $this->cacheable     = TRUE;
            $this->cacheTimeout = $cacheTimeout;
        }
    }

    public function newCache($file, $rate,$endpoint): void
    {
        if ($this->cacheable) {
            $file = strtoupper($file).$endpoint.'.json';
            file_put_contents($this->cacheFolder.$file, json_encode($rate));
        }
    }

    public function getCache($file,$endpoint): bool|object
    {

        if ($this->cacheable && file_exists($this->cacheFolder.strtoupper($file).$endpoint.'.json')) {
            $file = file($this->cacheFolder.strtoupper($file).$endpoint.'.json');

            $array= json_decode($file[0]);

            if ($array->cacheTime < (time() - $this->cacheTimeout)) {
                return false;
            }
            return $array;
        }
        return false;
    }

    public function clearCache(): void
    {
        $files = glob($this->cacheFolder.'*.json');

        if (!empty($files)) {
            array_map('unlink', $files);
        }
    }
}
