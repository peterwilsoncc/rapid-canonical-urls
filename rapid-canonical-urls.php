<?php
/*
Plugin Name: Rapid Canonical URLs
Version: 1.0
Author: Peter Wilson
Author URI: http://peterwilson.cc/
Description: Reduce 301 redirects and HTTP requests by using HTML5’s history API to show visitors the correct, canonical URL.
License: GPLv2 or later
*/

require __DIR__ . '/inc/namespace.php';

add_action( 'plugins_loaded', 'PWCC\\RapidCanonicalUrls\\bootstrap' );
