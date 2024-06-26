<?php
/**
 * @Filename: template-my-widgets.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: My Widgets Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */


use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

get_header();
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account' );
?>
<main class="my-widgets">
	<div class="container container-xxl">
		<?php Nh_Public::breadcrumbs(); ?>

		<nav class="dashboard-submenus mt-3 mb-5">
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', null, [ 'active_link' => 'my_widgets' ] ); ?>
		</nav>
	</div>
</main><!-- #main -->

<?php get_footer();
