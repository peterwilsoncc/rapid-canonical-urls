=== Rapid Canonical URLs ===
Contributors: peterwilsoncc
Tags: canonical urls, history api, html5
Requires at least: 2.3.0
Tested up to: 3.9.1
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Reduce 301 redirects and HTTP requests by using HTML5’s history API to show visitors the correct, canonical URL.

== Description ==

WordPress uses 301 redirects to redirect URLs to their canonical version.

In cases where the non-canonical version will show the correct content, it is possible to use the HTML5 history API to show visitors the correct URL without the additional HTTP request.

This reduces HTTP requests, speeding up access for visitors and reducing the load on your server. 

It is *strongly recommended* you use this plugin in association with an SEO plugin that adds canonical URL meta tags.

== Installation ==

1. Upload the rapid-canonical-urls folder to the /wp-content/plugins/ directory
2. Activate the Rapid Canonical URLs plugin through the 'Plugins' menu in WordPress
