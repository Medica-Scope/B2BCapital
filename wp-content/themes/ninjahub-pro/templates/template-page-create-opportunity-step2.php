<?php
/**
 * @Filename: template-page-create-opportunity-step2
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Create Opportunity - Step 2 Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */


use NH\APP\HELPERS\Nh_Cryptor;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;


//        status_header(404);
//        get_template_part('404');
//        exit();


if ( ! session_id() ) {
	session_start();
}

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account' );
?>

<main class="create-opportunity">
	<div class="container container-xxl">
		<?php Nh_Public::breadcrumbs(); ?>

		<nav class="dashboard-submenus mt-3 mb-5">
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', null, [ 'active_link' => 'opportunities' ] ); ?>
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', null, [ 'active_link' => 'create_new_opportunity' ] ); ?>
		</nav>

		<?php
		if ( isset( $_GET['q'] ) && ! empty( unserialize( Nh_Cryptor::Decrypt( $_GET['q'] ) ) ) && isset( $_SESSION['step_two'] ) && is_array( $_SESSION['step_two'] ) && isset
		( $_SESSION['step_two']['status'] ) && $_SESSION['step_two']['status'] === TRUE ) {
			$data = unserialize( Nh_Cryptor::Decrypt( $_GET['q'] ) );
			?>
			<h1>
				<?= __( 'Create a New Opportunity - Step 2', 'ninja' ) ?>
			</h1>
			<?php
			acf_form( [ 
				'post_id'      => $data['opp_id'],
				// Use the post ID where ACF fields are saved
				'field_groups' => [ $data['ID'] ],
				// Replace with your ACF Field Group ID
				'form'         => TRUE,
				// Set to false so ACF doesn't output a <form> tag, as this will be nested in your custom form
			] );
		} else {
			get_template_part( '404' );
		}
		?>
	</div>
</main><!-- #main -->

<?php get_footer();
