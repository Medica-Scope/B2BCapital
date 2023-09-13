<?php
    /**
     * Filename: page-export.php
     * Description:
     * User: NINJA MASTER - Mustafa Shaaban
     * Date: 1/18/2022
     */

    use NH\Nh;
    use NH\Helpers\Nh_Forms;

?>
<main>
    <div class="nh-admin-page">
        <div class="container-fluid">

            <header class="nh-admin-page-header">
                <h5><img src="<?= PLUGIN_URL . 'admin/img/icon.png' ?>" class="rounded me-2" alt="<?= __('NH Logo', 'ninja') ?>">NH Configuration</h5>
            </header>

            <section class="nh-notices mt-4"></section>

            <div class="page-content">

                <header class="nh-admin-page-header">
                    <h4><?= __('Edit export settings', 'ninja') ?></h4>
                </header>

                <?php include_once PLUGIN_PATH . 'admin/partials/header.php'; ?>

                <div class="tab-content">
                    <div class="tab-pane nh-admin-page-body active">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        <?= __('Post Types', 'ninja'); ?>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <?= \NH\APP\HELPERS\Nh_Forms::get_instance()
                                                                    ->create_form([
                                                                        'post_type'   => [
                                                                            'class'          => 'mb-4',
                                                                            'type'           => 'select',
                                                                            'label'          => __('Post types', 'ninja'),
                                                                            'name'           => Nh::_DOMAIN_NAME . '_post_type',
                                                                            //                                                                     'value'          => NH_CONFIGURATION['export'][Nh::_DOMAIN_NAME . '_post_type'],
                                                                            'required'       => TRUE,
                                                                            'options'        => [
                                                                                //                                                                             'post'       => 'Post',
                                                                                'lesson' => 'Lessons'
                                                                            ],
                                                                            'default_option' => 'post',
                                                                            'hint'           => __("Select post type that you want to export.", 'ninja'),
                                                                            'before'         => '',
                                                                            'after'          => '',
                                                                            'inline'         => TRUE,
                                                                            'order'          => 0,
                                                                        ],
                                                                        'file_type'   => [
                                                                            'class'          => 'mb-4',
                                                                            'type'           => 'select',
                                                                            'label'          => __('File Types', 'ninja'),
                                                                            'name'           => Nh::_DOMAIN_NAME . '_file_type',
                                                                            //                                                                     'value'          => NH_CONFIGURATION['export'][Nh::_DOMAIN_NAME . '_file_type'],
                                                                            'required'       => TRUE,
                                                                            'options'        => [
                                                                                'csv' => 'CSV',
                                                                                //                                                                             'xls' => 'XLS'
                                                                            ],
                                                                            'default_option' => 'csv',
                                                                            'hint'           => __("Select type that you want your to be exported in.", 'ninja'),
                                                                            'before'         => '',
                                                                            'after'          => '',
                                                                            'inline'         => TRUE,
                                                                            'order'          => 5,
                                                                        ],
                                                                        'post_status' => [
                                                                            'class'          => 'mb-4',
                                                                            'type'           => 'select',
                                                                            'label'          => __('Post Status', 'ninja'),
                                                                            'name'           => Nh::_DOMAIN_NAME . '_post_status',
                                                                            'required'       => TRUE,
                                                                            'options'        => [
                                                                                'any'     => 'All',
                                                                                'publish' => 'Publish'
                                                                            ],
                                                                            'default_option' => 'publish',
                                                                            'hint'           => __("Select type that you want your to be exported in.", 'ninja'),
                                                                            'before'         => '',
                                                                            'after'          => '',
                                                                            'inline'         => TRUE,
                                                                            'order'          => 6,
                                                                        ],
                                                                        'limit'       => [
                                                                            'class'         => 'mb-4',
                                                                            'type'          => 'number',
                                                                            'label'         => __('Limit Rows', 'ninja'),
                                                                            'name'          => Nh::_DOMAIN_NAME . '_limit',
                                                                            //                                                                     'value'         => NH_CONFIGURATION['export'][Nh::_DOMAIN_NAME . '_limit'],
                                                                            'default_value' => 100,
                                                                            'extra_attr'    => [
                                                                                'min' => -1,
                                                                            ],
                                                                            'required'      => TRUE,
                                                                            'placeholder'   => __('Limit', 'ninja'),
                                                                            'hint'          => __("How many rows you need to export default is 100, to export all rows use -1", 'ninja'),
                                                                            'before'        => '',
                                                                            'after'         => '',
                                                                            'inline'        => TRUE,
                                                                            'order'         => 10,
                                                                        ],
                                                                        'submit'      => [
                                                                            'class'  => 'col-lg-2 col-md-2 offset-lg-10 offset-md-10 mb-2',
                                                                            'type'   => 'submit',
                                                                            'value'  => __('Export', 'ninja'),
                                                                            'before' => '',
                                                                            'after'  => '',
                                                                            'order'  => 15,
                                                                        ]
                                                                    ], [
                                                                        'attr'       => 'novalidate',
                                                                        'class'      => Nh::_DOMAIN_NAME . '-export-form',
                                                                        'form_class' => 'needs-validation',
                                                                        'id'         => Nh::_DOMAIN_NAME . '_export_form'
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
