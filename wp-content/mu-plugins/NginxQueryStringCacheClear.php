<?php

/*
Plugin Name: Nginx Helper Query String Cache Clear
Description: Hooks into Nginx Helper plugin when url purge to also clear cached versions with query strings.
Version:     1.0
Author:      Joel Bernerman, Helsingborg Stad
*/

namespace NginxQueryStringCacheClear;

class NginxQueryStringCacheClear
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Only run if nginx helper local file delete constant is set.
        if (defined('RT_WP_NGINX_HELPER_CACHE_PATH')) {
            add_filter('rt_nginx_helper_purge_url', [$this, 'queryStringCacheClear'], 10, 1);
        }
    }

    /**
     * Cache clear query string versions based on url.
     * @param string $url Url sent in filter.
     *
     * @return string $url Return url untouched.
     */
    public function queryStringCacheClear($url)
    {
        // Skip home url so we dont purge everything all the time.
        if ($url !== get_home_url() . '/') {
            // Build the cache key and add wildcard * in the end.
            $urlData = wp_parse_url($url);
            $cacheKey = $urlData['scheme'] . 'GET' . $urlData['host'] . $urlData['path'] . '\?.*';

            // Command to grep for key in cache files.
            $command = 'find ' . RT_WP_NGINX_HELPER_CACHE_PATH . ' -type f | ' .
                       'xargs --no-run-if-empty -n1000 grep -El -m 1 ' .
                       '"^KEY: ' . $cacheKey . '"';

            // Get recursive files and nuke em!
            $cacheFiles = [];
            exec($command, $cacheFiles);
            foreach ($cacheFiles as $cacheFile) {
                if (file_exists($cacheFile)) {
                    unlink($cacheFile);
                }
            }
        }
        return $url;
    }
}

new \NginxQueryStringCacheClear\NginxQueryStringCacheClear();
