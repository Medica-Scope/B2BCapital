<?php
/**
 * @Filename: template-page-change-password.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Change Password Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */

use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account' );

$user_obj = new Nh_User();
$user     = $user_obj::get_current_user();
?>

<main class="my-account change-password">
	<div class="container">

		<!-- TODO: breadcrumb -->
		<?php Nh_Public::breadcrumbs(); ?>
		<nav class="dashboard-submenus mt-3 mb-5">
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', null, [ 'active_link' => 'my_account' ] ); ?>
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/sub-nav', null, [ 'active_link' => 'change_password' ] ); ?>
		</nav>

		<?php
		echo Nh_Forms::get_instance()
			->create_form( [
				'custom-html-1'        => [
					'type'    => 'html',
					'content' => '<div class="row">',
					'order'   => 0,
				],
				'current_password'     => [
					'class'       => 'col-12',
					'type'        => 'password',
					'label'       => __( 'Current password', 'ninja' ),
					'name'        => 'current_password',
					'required'    => TRUE,
					'placeholder' => __( 'Enter your current password', 'ninja' ),
					'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_current_password"></i>',
					'order'       => 5,
				],
				'new_password'         => [
					'class'       => 'col-12',
					'type'        => 'password',
					'label'       => __( 'New password', 'ninja' ),
					'name'        => 'new_password',
					'required'    => TRUE,
					'placeholder' => __( 'Enter your new password', 'ninja' ),
					'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_new_password"></i>',
					'order'       => 10,
				],
				'confirm_new_password' => [
					'class'       => 'col-12',
					'type'        => 'password',
					'label'       => __( 'Confirm new password', 'ninja' ),
					'name'        => 'confirm_new_password',
					'required'    => TRUE,
					'placeholder' => __( 'Re-enter your new password', 'ninja' ),
					'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_confirm_new_password"></i>',
					'order'       => 15,
				],
				'edit_password_nonce'  => [
					'class' => '',
					'type'  => 'nonce',
					'name'  => 'edit_password_nonce',
					'value' => Nh::_DOMAIN_NAME . "_edit_password_form",
					'order' => 20
				],
				'submit'               => [
					'class'               => 'btn-lg text-uppercase',
					'type'                => 'submit',
					'id'                  => Nh::_DOMAIN_NAME . '_edit_password_submit',
					'value'               => '<i class="bbc-save pe-1"></i> ' . __( 'Save', 'ninja' ),
					'before'              => '',
					'after'               => '',
					'recaptcha_form_name' => 'frontend_edit_profile',
					'order'               => 25
				],
			], [
				'class' => Nh::_DOMAIN_NAME . '-edit-password-form',
				'id'    => Nh::_DOMAIN_NAME . '_edit_password_form'
			] );
		?>
	</div>
</main><!-- #main -->

<?php get_footer();
