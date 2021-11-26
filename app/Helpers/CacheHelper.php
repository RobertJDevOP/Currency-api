<?php

namespace App\Helpers;

class CacheHelper
{
    private $cachable = FALSE;

    private $cacheFolder;

    private $cacheTimeout;

    public function __construct($cache = TRUE, $folder = 'dcf', $cacheTimeout = 7200)
    {

        $this->cacheFolder = ($folder == 'dcf') ?  dirname(__FILE__).'/JsonCurrencys/': $folder;

        if (is_writable($this->cacheFolder) && $cache == TRUE) {
            $this->cachable     = TRUE;
            $this->cacheTimeout = $cacheTimeout;
        }
    }

    public function newCache($file, $rate,$endpoint)
    {
        if ($this->cachable) {
            $file = strtoupper($file).$endpoint.'.json';
            file_put_contents($this->cacheFolder.$file, json_encode($rate));
        }
    }

    public function getCache($file,$endpoint) {

        if ($this->cachable && file_exists($this->cacheFolder.strtoupper($file).$endpoint.'.json')) {
            $file = file($this->cacheFolder.strtoupper($file).$endpoint.'.json');

            $array= json_decode($file[0]);


            if ($array->cacheTime < (time() - $this->cacheTimeout)) {
                return false;
            }
            return $array;
        }
        return false;
    }

    public function clearCache()
    {
        $files = glob($this->cacheFolder.'*.json');

        if (!empty($files)) {
            array_map('unlink', $files);
        }

    }
}
