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

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-industry', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/industry' );

get_header();
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
				<div class="row justify-content-between">
					<h1 class="section-title col-8 display-4 mb-2">
						<?php echo __( 'Choose which industry you are interested in:', 'ninja' ); ?>
					</h1>
					<div class="steps col-2">
						<div class="steps-circle">
							<div class="steps-circle-fill"></div>
							<div class="steps-number">1/2</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			$terms = $opportunity_obj->get_taxonomy_terms( 'industry' );

			$form_fields = [ 
				'custom-html-1'    => [ 
					'type'    => 'html',
					'content' => "<div class='d-flex justify-content-between align-items-center'><span class='available text-muted'>" . sprintf( __( '(%s Industry Available)', 'ninja' ), count
					( $terms ) ) . "</span><span class='industries-selected'>" . sprintf( __( '(%s Selected)', 'ninja' ), '<span class="selected-number">0</span>' ) . "</span></div>",
					'order'   => 0
				],
				'industries'       => [ 
					'class'   => 'container',
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
				$icon_id                                = get_term_meta( $term->term_id, 'icon', TRUE );
				$icon_link                              = (int) $icon_id > 0 ? wp_get_attachment_image_url( $icon_id ) : '';
				$hidden_class                           = $key > 4 ? 'hidden-tag' : '';
				$form_fields['industries']['choices'][] = [ 
					'class' => 'industries-tags col-auto ' . $hidden_class,
					'label' => ! empty( $icon_link ) ? '<img src="' . $icon_link . '" alt="Industry Icon"/> ' . $term->name : $term->name,
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

		<?php get_template_part( 'app/Views/template-parts/login-slider-part' ); ?>
	</div>
</main><!-- #main -->

<?php get_footer();
