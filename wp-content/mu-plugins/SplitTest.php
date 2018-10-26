<?php
/*
Plugin Name: Split Test
Description: Creates a simple split test on WordPress front page. Define this (with your id's) in wp-config: define('SPLIT_TEST_PAGE_IDS', array(129, 697));.
Version:     1.0
Author:      Sebastian Thulin, Helsingborg Stad
*/

namespace SplitTest;

class SplitTest
{
    private $_postIds = array();
    private $_postType = "page";
    private $_Ttl = 60*60*60*24;
    private $_cookieName = "split_test";
    private $_selectedPostId = null;

    /**
     * Init plugin
     *
     * @return void
     */
    public function __construct()
    {
        if (defined('SPLIT_TEST_PAGE_IDS') && is_array(SPLIT_TEST_PAGE_IDS) && !empty(SPLIT_TEST_PAGE_IDS)) {

            $this->_postIds = SPLIT_TEST_PAGE_IDS; // Adds post id array to object

            //Run filters
            add_filter('pre_get_posts', array($this, 'alterPostId'), 1);
            add_action('send_headers', array($this, 'bypassCache'), 1);
            add_action('wp_head', array($this, 'fixSeoIssues'), 1);
        }
    }

    /**
     * Print canonical if it's not the default frontpage
     *
     * @return void
     */
    public function fixSeoIssues()
    {
        //Check if front page
        if (!is_front_page()) {
            return;
        }

        //Check it's not default front page
        if ($this->_getPostId() == get_option('page_on_front')) {
            return;
        }

        //Print canonical url
        echo '<meta name="robots" content="noindex" />' . "\n";
        echo '<link rel="canonical" href="' . get_permalink($this->_getPostId()). '" />' . "\n";
    }

    /**
     * Send "do not cache" headers on frontpage
     *
     * @return void
     */
    public function bypassCache()
    {
        //Check if front page
        if (!is_front_page()) {
            return;
        }

        header('Pragma: no-cache');
        header('Cache-Control: private, no-cache, no-store, max-age=0, must-revalidate, proxy-revalidate');
    }

    /**
     * Manipulate front page id's
     *
     * @param object $query The query object for WordPress page fetch
     *
     * @return void
     */
    public function alterPostId($query)
    {

        //Check if main query
        if (!$query->is_main_query()) {
            return;
        }

        //Check if front page
        if (!is_front_page()) {
            return;
        }

        //Check if prevview
        if (is_preview()) {
            return;
        }

        //Set random page
        $query->set('post_type', $this->_postType);
        $query->set('page_id', $this->_getPostID());
    }

    /**
     * Add custom post types to Post submenu. (need Nested Pages plugin)
     *
     * @return int
     */
    private function _getPostId() : int
    {
        //Get stored page
        if (isset($_COOKIE[$this->_cookieName])) {
            return $_COOKIE[$this->_cookieName];
        }

        //Get id stored for this instance
        if (!is_null($this->_selectedPostId)) {
            return $this->_selectedPostId;
        }

        //Randomize a new page
        $randomPage = $this->_postIds[array_rand($this->_postIds)];

        //Store to instance of object
        $this->_selectedPostId = $randomPage;

        //Store as future cookie
        setcookie($this->_cookieName, $randomPage, time()+$this->_Ttl, "/");

        return $randomPage;
    }
}

new \SplitTest\SplitTest();
