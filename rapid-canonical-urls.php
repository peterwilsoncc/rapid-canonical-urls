<?php
/*
Plugin Name: Rapid Canonical URLs
Version: 0.1
Author: Peter Wilson
Author URI: http://peterwilson.cc/
Description: Reduce 301 redirects and HTTP requests by using HTML5’s history API to show visitors the correct, canonical URL.
License: GPLv2 or later
*/

$pwcc_hrs_canonical_url = false;

	
function pwcc_hrs_filter_redirect_canonical( $redirect_url, $requested_url )	{
	global $pwcc_hrs_canonical_url, $wp_query, $wp_the_query;
	
	$redirect_parsed = parse_url( $redirect_url );
	$requested_parsed = parse_url( $requested_url );
	
	if (
		( $redirect_parsed['scheme'] == $requested_parsed['scheme'] ) &&
		( $redirect_parsed['host'] == $requested_parsed['host'] ) &&
		( !is_404() )
	   ) {
		$via_js = true;
	}
	else {
		$via_js = false;
	}
	
	if ( true == $via_js ) {
		$pwcc_hrs_canonical_url = $redirect_url;
		add_action( 'wp_head', 'pwcc_hrs_action_history_replace', 1 );
		return false;
	} else {
		return $redirect_url;
	}
	
}
add_filter( 'redirect_canonical', 'pwcc_hrs_filter_redirect_canonical', 10, 2 );


function pwcc_hrs_action_history_replace() {
	global $pwcc_hrs_canonical_url;
	echo '<script>';
	echo "(function(w,u,h){";
	echo "h=w.history;";
	echo "if(h.replaceState){";
	echo "h.replaceState({u:u},'',u+w.location.hash);";
	echo "}";
	echo "}(this,'$pwcc_hrs_canonical_url'))";
	echo '</script>' . "\n";
}

