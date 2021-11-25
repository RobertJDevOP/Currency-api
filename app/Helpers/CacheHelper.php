<?php

namespace App\Helpers;

class CacheHelper
{
    private $cachable = FALSE;

    private $cacheFolder;

    private $cacheTimeout;

    public function __construct($cache = TRUE, $folder = 'dcf', $cacheTimeout = 7200)
    {
        $this->cacheFolder = ($folder == 'dcf') ? dirname(__FILE__).'/convert/' : $folder;

        if (is_writable($this->cacheFolder) && $cache == TRUE) {
            $this->cachable     = TRUE;
            $this->cacheTimeout = $cacheTimeout;
        }
    }

    protected function newCache($file, $rate)
    {

        if ($this->cachable) {
            $file = strtoupper($file).'.convertcache';

            $data = time().PHP_EOL.$rate;
            file_put_contents($this->cacheFolder.$file, $data);
        }

    }



    protected function getCache($file) {

        if ($this->cachable && file_exists($this->cacheFolder.strtoupper($file).'.convertcache')) {
            $file = file($this->cacheFolder.$file.'.convertcache');

            if ($file[0] < (time() - $this->cacheTimeout)) {
                return FALSE;
            }

            return $file[1];
        }

        return FALSE;

    }



    public function clearCache()
    {
        $files = glob($this->cacheFolder.'*.convertcache');

        if (!empty($files)) {
            array_map('unlink', $files);
        }

    }
}
