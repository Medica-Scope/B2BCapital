<?php global $post;

use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\Nh;

/// to be reviewed with mostafa
if ( is_singular( 'post' ) ) {
	$post_obj = new Nh_Blog();
	$post_obj->increment_read_count( get_the_ID() );
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="ScreenOrientation" content="autoRotate:disabled">

		<link rel="profile" href="https://gmpg.org/xfn/11">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<?php wp_body_open(); ?>

		<div id="page" class="site">

			<?php

			$landing = [ 
				'contact-us',
				'about',
				'choose-type',
				'investor',
				'opportunity-provider',
			];

			$dashboard = [ 
				'blogs',
				'my-account',
				'change-password',
				'my-opportunities',
				'my-widgets',
				'my-notifications',
				'my-favorite-opportunities',
				'my-ignored-opportunities',
				'my-favorite-articles',
				'my-ignored-articles',
				'dashboard',
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

			if ( is_front_page() || is_page( $landing ) || is_post_type_archive( 'service' ) || is_singular( 'service' ) || is_tax( 'service-category' ) ) {
				get_template_part( 'app/Views/headers/landing' );
			} elseif ( is_page( $dashboard ) || ( isset( $post ) && $post->post_type === 'post' ) || is_post_type_archive( 'faq' ) || is_search() || is_singular( [ 'opportunity' ] ) ) {
				get_template_part( 'app/Views/headers/dashboard' );
			} elseif ( is_page( $my_account ) ) {
				get_template_part( 'app/Views/headers/my-account' );
			} else {
				// TODO:: Will be used for Blogs later..
				get_template_part( 'app/Views/headers/default' );
			}
			?>
