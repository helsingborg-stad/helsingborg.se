<?php

/*
Plugin Name: Nginx Helper Extra Cache Clear
Description: Hooks into Nginx Helper plugin and Modularity to do a more complete cache clear, query strings etc.
Version:     1.0
Author:      Joel Bernerman, Helsingborg Stad
*/

namespace NginxExtraCacheClear;

class NginxExtraCacheClear
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Only run if nginx helper local file delete constant is set.
        if (defined('RT_WP_NGINX_HELPER_CACHE_PATH')) {
            add_filter('rt_nginx_helper_purge_url', [$this, 'queryStringCacheClear'], 10, 1);
            add_action('wp_loaded', [$this, 'modularityModuleSavePurge']);
        }
    }

    /**
     * Purge post urls on Modularity module save.
     *
     * @return void
     */
    public function modularityModuleSavePurge()
    {
        if ($this->isValidPostSave() && isset($_REQUEST['id'])) {
            $url = get_permalink($_REQUEST['id']);
            
            // Purge cache file.
            $cacheFile = $this->getNginxCacheFilePath($url);
            if (file_exists($cacheFile)) {
                unlink($cacheFile);
            }

            // Purge query string cached files as well.
            $this->queryStringCacheClear($url);
        }
    }

    /**
     * Get nginx cached file name and path by url.
     * @param string $url Url to saved post.
     *
     * @return string File path to nginx cached file.
     */
    public function getNginxCacheFilePath($url)
    {
        // Build a hash of the URL.
        $hash = md5($url);

        // Ensure trailing slash.
        $cache_path = RT_WP_NGINX_HELPER_CACHE_PATH;
        $cache_path = ('/' === substr($cache_path, -1)) ? $cache_path : $cache_path . '/';

        // Set path to cached file.
        return $cache_path . substr($hash, -1) . '/' . substr($hash, -3, 2) . '/' . $hash;
    }

    /**
     * Check if request is a post module save request.
     *
     * @return bool It is post module save or not.
     */
    public function isValidPostSave()
    {
        return isset($_POST['modularity-action']) && $_POST['modularity-action'] == 'modularity-options' && wp_verify_nonce($_POST['_wpnonce'], 'modularity-options');
    }

    /**
     * Cache clear query string versions based on url.
     * @param string $url Url sent in filter.
     *
     * @return string Return url untouched.
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

new \NginxExtraCacheClear\NginxExtraCacheClear();
