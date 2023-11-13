<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NinjaHub
 */

global $post;

$dashboard = [
	'my-account',
	'dashboard',
	'authentication',
	'change-password',
	'my-favorite-articles',
	'my-favorite-opportunities',
	'my-ignored-articles',
	'my-ignored-opportunities',
	'my-notifications',
	'my-opportunities',
	'my-widgets',
	'create-opportunity',
	'create-opportunity-step-2',
];

$my_account = [
	'login',
	'industry',
	'reset-password',
	'forgot-password',
	'registration',
	'verification',
	'authentication',
];

if ( is_page( $dashboard ) || ( isset( $post ) && $post->post_type === 'post' ) || is_post_type_archive( 'faq' ) || is_search() || is_singular( [ 'opportunity' ] )) {
	get_template_part( 'app/Views/footers/dashboard' );
} elseif ( is_page( $my_account ) ) {
	get_template_part( 'app/Views/footers/my-account' );
}
//  else {
// 	// TODO:: Will be used for Blogs later..
// 	get_template_part( 'app/Views/footers/default' );
// }


wp_body_close();

wp_footer();

?>
<script>
screen.addEventListener("orientationchange", () => {
	console.log(`The orientation of the screen is: ${ screen.orientation }`);
	screen.orientation.lock();
});
</script>
</body>

</html>
