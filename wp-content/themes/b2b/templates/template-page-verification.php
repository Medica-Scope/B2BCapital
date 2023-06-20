<?php
    /**
     * @Filename: template-page-verification.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Verification Page
     * Template Post Type: page
     *
     * @package b2b
     * @since 1.0
     *
     */

    use B2B\APP\CLASSES\B2b_User;
    use B2B\APP\HELPERS\B2b_Forms;
    use B2B\B2b;

    get_header();
?>

    <main id="" class="">
        <h1>VERIFICATION</h1>
        <?php

            echo B2b_Forms::get_instance()
                          ->create_form([
                              'custom-html-1'      => [
                                  'type'    => 'html',
                                  'content' => '<div class="d-flex justify-content-center align-items-center">',
                                  'order'   => 0,
                              ],
                              'code1'              => [
                                  'class'       => '',
                                  'type'        => 'text',
                                  'name'        => 'code1',
                                  'required'    => TRUE,
                                  'placeholder' => __('0', 'b2b'),
                                  'extra_attr'  => [
                                      'maxlength' => '1',
                                  ],
                                  'order'       => 5,
                              ],
                              'code2'              => [
                                  'class'       => '',
                                  'type'        => 'text',
                                  'name'        => 'code2',
                                  'required'    => TRUE,
                                  'placeholder' => __('0', 'b2b'),
                                  'extra_attr'  => [
                                      'maxlength' => '1',
                                  ],
                                  'order'       => 10,
                              ],
                              'code3'              => [
                                  'class'       => '',
                                  'type'        => 'text',
                                  'name'        => 'code3',
                                  'required'    => TRUE,
                                  'placeholder' => __('0', 'b2b'),
                                  'extra_attr'  => [
                                      'maxlength' => '1',
                                  ],
                                  'order'       => 15,
                              ],
                              'code4'              => [
                                  'class'       => '',
                                  'type'        => 'text',
                                  'name'        => 'code4',
                                  'required'    => TRUE,
                                  'placeholder' => __('0', 'b2b'),
                                  'extra_attr'  => [
                                      'maxlength' => '1',
                                  ],
                                  'order'       => 20,
                              ],
                              'custom-html-2'      => [
                                  'type'    => 'html',
                                  'content' => '</div>',
                                  'order'   => 25,
                              ],
                              'verification_nonce' => [
                                  'class' => '',
                                  'type'  => 'nonce',
                                  'name'  => 'verification_nonce',
                                  'value' => B2b::_DOMAIN_NAME . "_verification_form",
                                  'order' => 30
                              ],
                              'custom-html-3'      => [
                                  'type'    => 'html',
                                  'content' => '<div class="d-flex justify-content-between align-items-center">',
                                  'order'   => 35,
                              ],
                              'custom-html-4'      => [
                                  'type'    => 'html',
                                  'content' => '<div class=""><p>' . __("It may take a minute to receive your code. <br> Haven't received it ? <a href='javascript:(0)' class='b2b-resend-code'>Resend a new code.</a>") . '</p></div>',
                                  'order'   => 40,
                              ],
                              'submit'             => [
                                  'class'               => 'btn',
                                  'type'                => 'submit',
                                  'value'               => __('Verify', 'b2b'),
                                  'recaptcha_form_name' => 'frontend_verification',
                                  'order'               => 45
                              ],
                              'custom-html-5'      => [
                                  'type'    => 'html',
                                  'content' => '</div>',
                                  'order'   => 50,
                              ],
                          ], [
                              'class' => B2b::_DOMAIN_NAME . '-verification-form',
                              'id'    => B2b::_DOMAIN_NAME . '_verification_form'
                          ]);

        ?>
    </main><!-- #main -->

<?php get_footer();

