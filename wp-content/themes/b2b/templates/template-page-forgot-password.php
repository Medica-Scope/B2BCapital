<?php
    /**
     * @Filename: template-page-forgot-password.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Forgot Password Page
     * Template Post Type: page
     *
     * @package b2b
     * @since 1.0
     *
     */
    use B2B\APP\HELPERS\B2b_Forms;
    use B2B\B2b;

    get_header();
?>

    <main id="" class="">
        <?php
            echo B2b_Forms::get_instance()
                            ->create_form([
                                'user_email'   => [
                                    'class'       => 'has-header',
                                    'type'        => 'email',
                                    'label'       => __('Email Address', 'b2b'),
                                    'name'        => 'user_email',
                                    'required'    => TRUE,
                                    'placeholder' => __('Ex. email@gmail.com', 'b2b'),
                                    // 'hint'        => __("Lorem ipsum dolor sit amet.", 'b2b'),
                                    'before'      => "<h3 class='page-head'> <?= __('Forget Password', 'b2b') ?></h3>",
                                    'after'       => '',
                                    'order'       => 0,
                                ],
                                'forgot_nonce' => [
                                    'class' => '',
                                    'type'  => 'nonce',
                                    'name'  => 'forgot_nonce',
                                    'value' => B2b::_DOMAIN_NAME . "_forgot_form",
                                    'order' => 15
                                ],
                                'submit'       => [
                                    'class'  => 'button_state',
                                    'type'   => 'submit',
                                    'value'  => __('Send', 'b2b'),
                                    'before' => '',
                                    'after'  => '',
                                    'order'  => 20
                                ]
                            ], [
                                'class' => B2b::_DOMAIN_NAME . '-forgot-form',
                                'id'    => B2b::_DOMAIN_NAME . '_forgot_form'
                            ]);

        ?>
    </main><!-- #main -->

<?php get_footer();

