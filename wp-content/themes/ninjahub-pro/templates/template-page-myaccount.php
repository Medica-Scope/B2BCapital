<?php
/**
 * @Filename: template-page-myaccount.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: My Account Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */

use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
	use NH\APP\MODELS\FRONT\MODULES\Nh_Profile_Widget;
	use NH\APP\MODELS\FRONT\Nh_Public;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account' );

$user_obj = new Nh_User();
$user     = $user_obj::get_current_user();
?>

<main class="my-account">
	<div class="container">
		<!-- TODO: breadcrumb -->
		<nav class="dashboard-submenus mt-3 mb-5">
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', null, [ 'active_link' => 'my_account' ] ); ?>
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/sub-nav', null, [ 'active_link' => 'profile_data' ] ); ?>
		</nav>
		<?php
		$form_fields = [
			'custom-html-1'                    => [
				'type'    => 'html',
				'content' => '<div class="d-flex flex-row flex-wrap col-12">',
				'order'   => 0,
			],
			'first_name'                       => [
				'class'       => 'form-field form-field-has-icon col-6 pr-3',
				'type'        => 'text',
				'label'       => __( 'First name', 'ninja' ),
				'name'        => 'first_name',
				'value'       => $user->first_name,
				'required'    => TRUE,
				'placeholder' => __( 'Enter your first name', 'ninja' ),
				'order'       => 5,
			],
			'last_name'                        => [
				'class'       => 'form-field form-field-has-icon col-6 pl-3',
				'type'        => 'text',
				'label'       => __( 'Last name', 'ninja' ),
				'name'        => 'last_name',
				'value'       => $user->last_name,
				'required'    => TRUE,
				'placeholder' => __( 'Enter your last name', 'ninja' ),
				'order'       => 10,
			],
			'phone_number'                     => [
				'class'       => 'form-field form-field-has-icon col-6 pr-3',
				'type'        => 'text',
				'label'       => __( 'Phone number', 'ninja' ),
				'name'        => 'phone_number',
				'value'       => $user->user_meta['phone_number'],
				'required'    => TRUE,
				'placeholder' => __( 'Enter your phone number', 'ninja' ),
				'extra_attr'  => [ 'disabled' => 'disable' ],
				'order'       => 15,
			],
			'user_email'                       => [
				'class'       => 'form-field form-field-has-icon col-6 pl-3',
				'type'        => 'email',
				'label'       => __( 'Email', 'ninja' ),
				'name'        => 'user_email',
				'value'       => $user->email,
				'required'    => TRUE,
				'placeholder' => __( 'Enter your email', 'ninja' ),
				'order'       => 20,
			],
			'site_language'                    => [
				'class'          => 'form-field form-field-has-icon col-6 pr-3',
				'type'           => 'select',
				'label'          => __( 'Profile language', 'ninja' ),
				'name'           => 'site_language',
				'placeholder'    => __( 'Select your language', 'ninja' ),
				'options'        => [],
				'default_option' => '',
				'select_option'  => [ $user->user_meta['site_language'] ],
				'before'         => '',
				'order'          => 25,
			],
			'widget_list'                      => [
				'class'          => 'form-field form-field-has-icon col-6 pl-3',
				'type'           => 'select',
				'label'          => __( 'Widget list categories', 'ninja' ),
				'name'           => 'widget_list',
				'multiple'       => 'multiple',
				'placeholder'    => __( 'Select your widget', 'ninja' ),
				'options'        => [],
				'default_option' => '',
				'select_option'  => $user->profile->meta_data['widget_list'],
				'before'         => '',
				'order'          => 30,
			],
			'preferred_opportunities_cat_list' => [
				'class'          => 'form-field form-field-has-icon col-6 pr-3',
				'type'           => 'select',
				'label'          => __( 'Preferred categories list for opportunities', 'ninja' ),
				'name'           => 'preferred_opportunities_cat_list',
				'multiple'       => 'multiple',
				'placeholder'    => __( 'Select your preferred', 'ninja' ),
				'options'        => [],
				'default_option' => '',
				'select_option'  => $user->profile->meta_data['preferred_opportunities_cat_list'],
				'before'         => '',
				'order'          => 35,
			],
			'preferred_articles_cat_list'      => [
				'class'          => 'form-field form-field-has-icon col-6 pl-3',
				'type'           => 'select',
				'label'          => __( 'preferred categories list for articles', 'ninja' ),
				'name'           => 'preferred_articles_cat_list',
				'multiple'       => 'multiple',
				'placeholder'    => __( 'Select your preferred', 'ninja' ),
				'options'        => [],
				'default_option' => '',
				'select_option'  => $user->profile->meta_data['preferred_articles_cat_list'],
				'before'         => '',
				'order'          => 40,
			],
			'custom-html-3'                    => [
				'type'    => 'html',
				'content' => '</div>',
				'order'   => 45,
			],
			'edit_profile_nonce'               => [
				'class' => '',
				'type'  => 'nonce',
				'name'  => 'edit_profile_nonce',
				'value' => Nh::_DOMAIN_NAME . "_edit_profile_form",
				'order' => 50
			],
			'submit'                           => [
				'class'               => 'form-action bbc-btn btn-primary large apply',
				'type'                => 'submit',
				'id'                  => Nh::_DOMAIN_NAME . '_edit_profile_submit',
				'value'               => __( 'Save', 'ninja' ),
				'before'              => '',
				'after'               => '',
				'recaptcha_form_name' => 'frontend_edit_profile',
				'order'               => 55
			],
		];
		$form_tags   = [
			'class' => Nh::_DOMAIN_NAME . '-edit-profile-form',
			'id'    => Nh::_DOMAIN_NAME . '_edit_profile_form'
		];

		$languages = Nh_Public::get_available_languages();

		foreach ( $languages as $lang ) {
			$form_fields['site_language']['options'][ $lang['code'] ] = $lang['name'];
		}


		$widgets_obj       = new Nh_Profile_Widget();
		$widgets = $widgets_obj->get_all(['publish'], -1, 'ID','ASC');

		foreach ( $widgets as $key => $value ) {
			$form_fields['widget_list']['options'][ $value->ID ] = $value->title;
		}


		$opportunities_obj       = new Nh_Opportunity();
		$opportunities_tax_terms = $opportunities_obj->get_taxonomy_terms( 'opportunity-category' );

		foreach ( $opportunities_tax_terms as $key => $term ) {
			$form_fields['preferred_opportunities_cat_list']['options'][ $term->term_id ] = $term->name;
		}

		$blogs_obj           = new Nh_Blog();
		$blogs_obj_tax_terms = $opportunities_obj->get_taxonomy_terms( 'category' );

		foreach ( $blogs_obj_tax_terms as $key => $term ) {
			$form_fields['preferred_articles_cat_list']['options'][ $term->term_id ] = $term->name;
		}

		echo Nh_Forms::get_instance()
			->create_form( $form_fields, $form_tags );

		?>

	</div>
</main><!-- #main -->

<?php get_footer();
