<?php
namespace PWCC\RapidCanonicalUrls;

/**
 * Bootstrap plugin.
 */
function bootstrap() {
	add_filter( 'redirect_canonical', __NAMESPACE__ . '\\redirect_destination', PHP_INT_MIN );
	add_filter( 'redirect_canonical', __NAMESPACE__ . '\\maybe_switch_out_redirect', PHP_INT_MAX, 2 );
}

/**
 * Get or set the initial redirect URL before any plugins filter it.
 *
 * Runs on `redirect_canonical` at PHP_INT_MIN (hopefully first).
 *
 * @param  string $set_destination Set intended destination.
 * @return false|string            Initial URL. False on failure.
 */
function redirect_destination( $set_destination = null ) {
	static $redirect_to = false;

	if ( $set_destination ) {
		$redirect_to = $set_destination;
	}

	return $redirect_to;
}

/**
 * Switch out the 301 canonical redirect with JS History replace.
 *
 * Runs on `redirect_canonical` at PHP_INT_MAX (hopefully last).
 *
 * @param string|bool $redirect_url The redirect destination. False if none.
 * @param string      $requested_url The URL requested by the visitor.
 * @return string|bool 301 redirect destination, false if none required.
 */
function maybe_switch_out_redirect( $redirect_url, $requested_url ) {
	if ( false === $redirect_url ) {
		// No redirect required.
		return false;
	}

	$redirect_parsed = wp_parse_url( $redirect_url );
	$requested_parsed = wp_parse_url( $requested_url );

	if (
		( redirect_destination() !== $redirect_url ) ||
		( $redirect_parsed['scheme'] !== $requested_parsed['scheme'] ) ||
		( $redirect_parsed['host'] !== $requested_parsed['host'] ) ||
		( is_404() )
	) {
		/*
		 * Modified, cross domain and  404 recovery redirects all
		 * require a real - 301 - redirect.
		 */
		return $redirect_url;
	}

	// Use the history API.
	add_action( 'wp_head', __NAMESPACE__ . '\\history_replace', 1 );
	return false;
}

/**
 * Output the JavaScript required for `history.replaceState()`.
 *
 * Runs on `wp_head`.
 */
function history_replace() {
	if ( ! redirect_destination() ) {
		// No destination to redirect to.
		return;
	}
	?>
	<script>
		(function( p, w, c, C ){
			c = p.history;
			if ( c.replaceState ) {
				c.replaceState( { u: w }, '', w+p.location.hash );
			}
		}( window, <?php echo wp_json_encode( redirect_destination() ); ?> ) );
	</script>
	<?php
}
