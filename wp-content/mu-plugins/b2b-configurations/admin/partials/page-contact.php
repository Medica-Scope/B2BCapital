<?php
    /**
     * Filename: page-contact.php
     * Description:
     * User: NINJA MASTER - Mustafa Shaaban
     * Date: 1/18/2022
     */

    use B2B\APP\HELPERS\B2b_Forms;
    use B2B\B2b;

?>
<main>
    <div class="b2b-admin-page">
        <div class="container-fluid">

            <header class="b2b-admin-page-header">
                <h5><img src="<?= PLUGIN_URL . 'admin/img/icon.png' ?>" class="rounded me-2" alt="<?= __('B2B Logo', 'b2b') ?>">B2B Configuration</h5>
            </header>

            <section class="b2b-notices mt-4"></section>

            <div class="page-content">

                <header class="b2b-admin-page-header">
                    <h4><?= __('Edit contact information settings', 'b2b') ?></h4>
                </header>

                <?php include_once PLUGIN_PATH . 'admin/partials/header.php'; ?>

                <div class="tab-content">
                    <div class="tab-pane b2b-admin-page-body active">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        <?= __('Find Us', 'b2b'); ?>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <?=
                                        B2b_Forms::get_instance()
                                                     ->create_form([
                                                             'contact_address_en' => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('Address in english', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_contact_address_en',
                                                                     'value'       => B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_address_en'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, velit.', 'b2b'),
                                                                     'hint'        => __("This info will be used in contact us page.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 0,
                                                             ],
                                                             'contact_address_ar' => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('Address in arabic', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_contact_address_ar',
                                                                     'value'       => B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_address_ar'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, velit.', 'b2b'),
                                                                     'hint'        => __("This info will be used in contact us page.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 0,
                                                             ],
                                                             'contact_email'      => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'email',
                                                                     'label'       => __('Email', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_contact_email',
                                                                     'value'       => B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_email'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('info@b2b.org', 'b2b'),
                                                                     'hint'        => __("This info will be used in contact us page.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 5,
                                                             ],
                                                             'contact_phone'      => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('Phone', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_contact_phone',
                                                                     'value'       => B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_phone'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('+2 15057', 'b2b'),
                                                                     'hint'        => __("This info will be used in contact us page.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 10,
                                                             ],
                                                             'contact_mobile'      => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('Mobile', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_contact_mobile',
                                                                     'value'       => B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_mobile'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('+20 0111545057', 'b2b'),
                                                                     'hint'        => __("This info will be used in contact us page.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 10,
                                                             ],
                                                             'submit'             => [
                                                                     'class'  => 'col-lg-2 col-md-2 offset-lg-10 offset-md-10 mb-2',
                                                                     'type'   => 'submit',
                                                                     'value'  => __('Save', 'b2b'),
                                                                     'before' => '',
                                                                     'after'  => '',
                                                                     'order'  => 20,
                                                             ]
                                                     ], [
                                                             'attr'       => 'novalidate',
                                                             'class'      => B2b::_DOMAIN_NAME . '-contact-form',
                                                             'form_class' => 'needs-validation',
                                                             'id'         => B2b::_DOMAIN_NAME . '_contact_form'
                                                     ]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                        <?= __('Social Media Links', 'b2b'); ?>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                                    <div class="accordion-body">
                                        <?= B2b_Forms::get_instance()
                                                     ->create_form([
                                                             'social_fb'  => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('Facebook', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_social_fb',
                                                                     'value'       => B2B_CONFIGURATION['social'][B2b::_DOMAIN_NAME . '_social_fb'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('https://www.example.com', 'b2b'),
                                                                     'hint'        => __("This link will be used globally in the website.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 0,
                                                             ],
                                                             'social_tw'  => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('Twitter', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_social_tw',
                                                                     'value'       => B2B_CONFIGURATION['social'][B2b::_DOMAIN_NAME . '_social_tw'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('https://www.example.com', 'b2b'),
                                                                     'hint'        => __("This link will be used globally in the website.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 5,
                                                             ],
                                                             'social_yt'  => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('Youtube', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_social_yt',
                                                                     'value'       => B2B_CONFIGURATION['social'][B2b::_DOMAIN_NAME . '_social_yt'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('https://www.example.com', 'b2b'),
                                                                     'hint'        => __("This link will be used globally in the website.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 10,
                                                             ],
                                                             'social_ig'  => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('Instagram', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_social_ig',
                                                                     'value'       => B2B_CONFIGURATION['social'][B2b::_DOMAIN_NAME . '_social_ig'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('https://www.example.com', 'b2b'),
                                                                     'hint'        => __("This link will be used globally in the website.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 15,
                                                             ],
                                                             'social_pin' => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('Pinterest', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_social_pin',
                                                                     'value'       => B2B_CONFIGURATION['social'][B2b::_DOMAIN_NAME . '_social_pin'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('https://www.example.com', 'b2b'),
                                                                     'hint'        => __("This link will be used globally in the website.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 20,
                                                             ],
                                                             'social_in' => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('Linked In', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_social_in',
                                                                     'value'       => B2B_CONFIGURATION['social'][B2b::_DOMAIN_NAME . '_social_in'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('https://www.example.com', 'b2b'),
                                                                     'hint'        => __("This link will be used globally in the website.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 25,
                                                             ],
                                                             'submit'     => [
                                                                     'class'  => 'col-lg-2 col-md-2 offset-lg-10 offset-md-10 mb-2',
                                                                     'type'   => 'submit',
                                                                     'value'  => __('Save', 'b2b'),
                                                                     'before' => '',
                                                                     'after'  => '',
                                                                     'order'  => 30,
                                                             ]
                                                     ], [
                                                             'attr'       => 'novalidate',
                                                             'class'      => B2b::_DOMAIN_NAME . '-social-form',
                                                             'form_class' => 'needs-validation',
                                                             'id'         => B2b::_DOMAIN_NAME . '_social_form'
                                                     ]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                        <?= __('Applications Links', 'b2b'); ?>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                                    <div class="accordion-body">
                                        <?= B2b_Forms::get_instance()
                                                     ->create_form([
                                                             'apps_ios' => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('App Store (IOS)', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_apps_ios',
                                                                     'value'       => B2B_CONFIGURATION['apps'][B2b::_DOMAIN_NAME . '_apps_ios'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('https://www.example.com', 'b2b'),
                                                                     'hint'        => __("This link will be used globally in the website.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 0,
                                                             ],
                                                             'apps_apk' => [
                                                                     'class'       => 'mb-4',
                                                                     'type'        => 'text',
                                                                     'label'       => __('Google Play (Android)', 'b2b'),
                                                                     'name'        => B2b::_DOMAIN_NAME . '_apps_apk',
                                                                     'value'       => B2B_CONFIGURATION['apps'][B2b::_DOMAIN_NAME . '_apps_apk'],
                                                                     'required'    => TRUE,
                                                                     'placeholder' => __('https://www.example.com', 'b2b'),
                                                                     'hint'        => __("This link will be used globally in the website.", 'b2b'),
                                                                     'before'      => '',
                                                                     'after'       => '',
                                                                     'inline'      => TRUE,
                                                                     'order'       => 5,
                                                             ],
                                                             'submit'   => [
                                                                     'class'  => 'col-lg-2 col-md-2 offset-lg-10 offset-md-10 mb-2',
                                                                     'type'   => 'submit',
                                                                     'value'  => __('Save', 'b2b'),
                                                                     'before' => '',
                                                                     'after'  => '',
                                                                     'order'  => 25,
                                                             ]
                                                     ], [
                                                             'attr'       => 'novalidate',
                                                             'class'      => B2b::_DOMAIN_NAME . '-apps-form',
                                                             'form_class' => 'needs-validation',
                                                             'id'         => B2b::_DOMAIN_NAME . '_apps_form'
                                                     ]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>
