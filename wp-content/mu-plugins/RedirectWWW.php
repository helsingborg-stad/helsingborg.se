<?php

/*
Plugin Name: Redirect subdomain www
Description: Redirects www.example.com to example.com
Version:     1.0
Author:      Joel Bernerman, Helsingborg Stad
*/

namespace RedirectSubdomainWWW;

class RedirectSubdomainWWW
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        if (!defined('WP_CLI')) {
            $this->redirect();
        }
    }
    /**
     * Redirect if domain starts with www.
     *
     * @return void
     */
    public function redirect()
    {
        if (strpos($_SERVER['HTTP_HOST'], 'www.') === 0) {
            $host = substr($_SERVER['HTTP_HOST'], 4);
            if (
                isset($_SERVER['HTTPS']) &&
                ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
                isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
                $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
            ) {
                $protocol = 'https://';
            } else {
                $protocol = 'http://';
            }

            header('Location: ' . $protocol . $host . $_SERVER['REQUEST_URI']);
            exit;
        }
    }
}

new \RedirectSubdomainWWW\RedirectSubdomainWWW();
