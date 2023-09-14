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
     * @package b2b
     * @since 1.0
     *
     */

    use B2B\APP\CLASSES\B2b_User;
    use B2B\APP\HELPERS\B2b_Forms;
    use B2B\APP\MODELS\FRONT\MODULES\B2b_Opportunity;
    use B2B\APP\MODELS\FRONT\MODULES\B2b_Profile;
    use B2B\B2b;

    get_header();
    global $user_ID;
    $user            = B2b_User::get_current_user();
    $opportunity_obj = new B2b_Opportunity();
?>

    <main id="" class="">

        <h3><?= __('Choose which industry you are interested in:') ?></h3>
        <?php
            $terms = $opportunity_obj->get_taxonomy_terms('industry');

            $form_fields = [
                'custom-html-1'    => [
                    'type'    => 'html',
                    'content' => "<div class='d-flex justify-content-between align-items-center'><span class='available'>".sprintf(__('(%s Industry Available)', 'b2b'),count
                        ($terms))."</span><span class='industries-selected'>".sprintf(__('(%s Selected)', 'b2b'), '<span class="selected-number">0</span>')."</span></div>",
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
                    'value' => B2b::_DOMAIN_NAME . "_industries_form",
                    'order' => 15
                ],
                'submit'           => [
                    'class'               => '',
                    'type'                => 'submit',
                    'value'               => __('Continue', 'b2b'),
                    'before'              => '',
                    'after'               => '',
                    'recaptcha_form_name' => 'frontend_industries',
                    'order'               => 20
                ],
            ];
            $form_tags   = [
                'class' => B2b::_DOMAIN_NAME . '-industries-form',
                'id'    => B2b::_DOMAIN_NAME . '_industries_form'
            ];


            foreach ($terms as $key => $term) {
                $hidden_class = $key > 4 ? 'hidden-tag' : '';
                $form_fields['industries']['choices'][] = [
                    'class' => 'industries-tags ' . $hidden_class,
                    'label' => $term->name,
                    'name'  => 'industries',
                    'value' => $term->term_id,
                    'order' => $key
                ];
                if (count($terms) > 4 && count($terms) -1 === $key ) {
                    $rest = count($terms) - 5;
                    $form_fields['custom-html-last'] = [
                        'type'    => 'html',
                        'content' => "<a href='javascript:(0);' class='show-tags'>".sprintf(__('%s more..', 'b2b'),$rest) ."</a>",
                        'order'   => 10
                    ];
                }
            }
            echo B2b_Forms::get_instance()
                          ->create_form($form_fields, $form_tags);
        ?>
    </main><!-- #main -->

<?php get_footer();

