<?php
/**
 * @Filename: template-page-industry.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Industry Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */

use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-industry', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/industry' );

global $user_ID;

$user            = Nh_User::get_current_user();
$opportunity_obj = new Nh_Opportunity();
?>
<main class="container-fluid h-100">

	<div class="row h-100">

		<section class="login-section container-xl col-12 col-md-6 py-5 px-5 px-xl-6">
			<!-- App Brand -->

			<a href="<?php echo home_url(); ?>" class="app-brand mb-6"><img src="<?php echo Nh::get_site_logo(); ?>"
					alt="Nh Site Logo" class="img-fluid" /></a>
			<div class="section-header">
				<div class="row">
					<h1 class="section-title display-2 text-center mb-2">
						<?= __( 'Choose which industry you are interested in:' ) ?>
					</h1>
				</div>
			</div>
			<?php
			$terms = $opportunity_obj->get_taxonomy_terms( 'industry' );

			$form_fields = [ 
				'custom-html-1'    => [ 
					'type'    => 'html',
					'content' => "<div class='d-flex justify-content-between align-items-center'><span class='available'>" . sprintf( __( '(%s Industry Available)', 'ninja' ), count
					( $terms ) ) . "</span><span class='industries-selected'>" . sprintf( __( '(%s Selected)', 'ninja' ), '<span class="selected-number">0</span>' ) . "</span></div>",
					'order'   => 0
				],
				'industries'       => [ 
					'class'   => 'col-6',
					'type'    => 'checkbox',
					'choices' => [],
					'order'   => 5,
				],
				'industries_nonce' => [ 
					'class' => '',
					'type'  => 'nonce',
					'name'  => 'industries_nonce',
					'value' => Nh::_DOMAIN_NAME . "_industries_form",
					'order' => 15
				],
				'submit'           => [ 
					'class'               => '',
					'type'                => 'submit',
					'value'               => __( 'Continue', 'ninja' ),
					'before'              => '',
					'after'               => '',
					'recaptcha_form_name' => 'frontend_industries',
					'order'               => 20
				],
			];
			$form_tags   = [ 
				'class' => Nh::_DOMAIN_NAME . '-industries-form',
				'id'    => Nh::_DOMAIN_NAME . '_industries_form'
			];


			foreach ( $terms as $key => $term ) {
				$hidden_class                           = $key > 4 ? 'hidden-tag' : '';
				$form_fields['industries']['choices'][] = [ 
					'class' => 'industries-tags ' . $hidden_class,
					'label' => $term->name,
					'name'  => 'industries',
					'value' => $term->term_id,
					'order' => $key
				];
				if ( count( $terms ) > 4 && count( $terms ) - 1 === $key ) {
					$rest                            = count( $terms ) - 5;
					$form_fields['custom-html-last'] = [ 
						'type'    => 'html',
						'content' => "<a href='javascript:(0);' class='show-tags'>" . sprintf( __( '%s more..', 'ninja' ), $rest ) . "</a>",
						'order'   => 10
					];
				}
			}
			echo Nh_Forms::get_instance()
				->create_form( $form_fields, $form_tags );
			?>

			<div class="section-footer">
				<p>
					<?= __( 'Copyright © 2023 B2B All rights reserved.', 'ninja' ); ?>
				</p>
			</div>
		</section>

		<?php get_template_part( 'template-parts/login-slider-part' ); ?>
	</div>
</main><!-- #main -->

<?php get_footer();
