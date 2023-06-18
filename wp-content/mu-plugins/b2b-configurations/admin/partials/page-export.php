<?php
    /**
     * Filename: page-export.php
     * Description:
     * User: NINJA MASTER - Mustafa Shaaban
     * Date: 1/18/2022
     */

    use B2B\B2b;
    use B2B\Helpers\B2b_Forms;

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
                    <h4><?= __('Edit export settings', 'b2b') ?></h4>
                </header>

                <?php include_once PLUGIN_PATH . 'admin/partials/header.php'; ?>

                <div class="tab-content">
                    <div class="tab-pane b2b-admin-page-body active">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        <?= __('Post Types', 'b2b'); ?>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <?= \B2B\APP\HELPERS\B2b_Forms::get_instance()
                                                     ->create_form([
                                                             'post_type' => [
                                                                     'class'          => 'mb-4',
                                                                     'type'           => 'select',
                                                                     'label'          => __('Post types', 'b2b'),
                                                                     'name'           => B2b::_DOMAIN_NAME . '_post_type',
//                                                                     'value'          => B2B_CONFIGURATION['export'][B2b::_DOMAIN_NAME . '_post_type'],
                                                                     'required'       => TRUE,
                                                                     'options'        => [
//                                                                             'post'       => 'Post',
                                                                             'application' => 'Applications'
                                                                     ],
                                                                     'default_option' => 'post',
                                                                     'hint'           => __("Select post type that you want to export.", 'b2b'),
                                                                     'before'         => '',
                                                                     'after'          => '',
                                                                     'inline'         => TRUE,
                                                                     'order'          => 0,
                                                             ],
                                                             'file_type' => [
                                                                     'class'          => 'mb-4',
                                                                     'type'           => 'select',
                                                                     'label'          => __('File Types', 'b2b'),
                                                                     'name'           => B2b::_DOMAIN_NAME . '_file_type',
//                                                                     'value'          => B2B_CONFIGURATION['export'][B2b::_DOMAIN_NAME . '_file_type'],
                                                                     'required'       => TRUE,
                                                                     'options'        => [
                                                                             'csv'       => 'CSV',
//                                                                             'xls' => 'XLS'
                                                                     ],
                                                                     'default_option' => 'csv',
                                                                     'hint'           => __("Select type that you want your to be exported in.", 'b2b'),
                                                                     'before'         => '',
                                                                     'after'          => '',
                                                                     'inline'         => TRUE,
                                                                     'order'          => 5,
                                                             ],
                                                             'application_status' => [
                                                                'class'          => 'mb-4',
                                                                'type'           => 'select',
                                                                'label'          => __('Application Status', 'b2b'),
                                                                'name'           => B2b::_DOMAIN_NAME . '_application_status',
                                                                'required'       => TRUE,
                                                                'options'        => [
                                                                        'pending'       => 'Pending',
                                                                        'shortlisted' => 'Shortlisted',
                                                                        'accepted' => 'Accepted',
                                                                        'rejected' => 'Rejected',
                                                                ],
                                                                'default_option' => 'pending',
                                                                'hint'           => __("Select type that you want your to be exported in.", 'b2b'),
                                                                'before'         => '',
                                                                'after'          => '',
                                                                'inline'         => TRUE,
                                                                'order'          => 6,
                                                        ],
                                                             'limit'      => [
                                                                     'class'         => 'mb-4',
                                                                     'type'          => 'number',
                                                                     'label'         => __('Limit Rows', 'b2b'),
                                                                     'name'          => B2b::_DOMAIN_NAME . '_limit',
//                                                                     'value'         => B2B_CONFIGURATION['export'][B2b::_DOMAIN_NAME . '_limit'],
                                                                     'default_value' => 100,
                                                                     'extra_attr'    => [
                                                                             'min' => -1,
                                                                     ],
                                                                     'required'      => TRUE,
                                                                     'placeholder'   => __('Limit', 'b2b'),
                                                                     'hint'          => __("How many rows you need to export default is 100, to export all rows use -1", 'b2b'),
                                                                     'before'        => '',
                                                                     'after'         => '',
                                                                     'inline'        => TRUE,
                                                                     'order'         => 10,
                                                             ],
                                                             'submit'     => [
                                                                     'class'  => 'col-lg-2 col-md-2 offset-lg-10 offset-md-10 mb-2',
                                                                     'type'   => 'submit',
                                                                     'value'  => __('Export', 'b2b'),
                                                                     'before' => '',
                                                                     'after'  => '',
                                                                     'order'  => 15,
                                                             ]
                                                     ], [
                                                             'attr'       => 'novalidate',
                                                             'class'      => B2b::_DOMAIN_NAME . '-export-form',
                                                             'form_class' => 'needs-validation',
                                                             'id'         => B2b::_DOMAIN_NAME . '_export_form'
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
