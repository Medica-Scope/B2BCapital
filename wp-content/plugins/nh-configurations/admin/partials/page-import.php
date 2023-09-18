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

            <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    <?= __('Please be advised that importing data into the database is a critical operation. Utilizing this tool does not replace existing data; instead, it appends new data. Once the data is added, the action cannot be reversed. Ensure you utilize the provided sample CSV file as a reference to maintain the appropriate file structure.',
                        'ninja') ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="page-content">

                <header class="nh-admin-page-header">
                    <h4><?= __('Edit Import settings', 'ninja') ?></h4>
                </header>

                <?php include_once PLUGIN_PATH . 'admin/partials/header.php'; ?>

                <div class="tab-content">
                    <div class="tab-pane nh-admin-page-body active">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        <?= __('Lessons', 'ninja'); ?>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body">

                                        <div class="sample-file">
                                            <a href="<?= PLUGIN_URL . 'admin/imports/sample-file.csv' ?>"><?= __('Download Sample File', 'ninja') ?></a>
                                        </div>

                                        <?= \NH\APP\HELPERS\Nh_Forms::get_instance()
                                                                    ->create_form([
                                                                        'csv_file' => [
                                                                            'class'       => 'mb-4',
                                                                            'type'        => 'file',
                                                                            'label'       => __('CSV File', 'ninja'),
                                                                            'name'        => Nh::_DOMAIN_NAME . '_csv_file',
                                                                            'required'    => TRUE,
                                                                            'placeholder' => __('', 'ninja'),
                                                                            'hint'        => __("Select your CSV File", 'ninja'),
                                                                            'before'      => '',
                                                                            'after'       => '',
                                                                            'inline'      => TRUE,
                                                                            'order'       => 0,
                                                                        ],
                                                                        'batches'  => [
                                                                            'class'         => 'mb-4',
                                                                            'type'          => 'number',
                                                                            'label'         => __('Batches', 'ninja'),
                                                                            'name'          => Nh::_DOMAIN_NAME . '_batches',
                                                                            'default_value' => 10,
                                                                            'extra_attr'    => [
                                                                                'min' => 5,
                                                                            ],
                                                                            'required'      => TRUE,
                                                                            'placeholder'   => __('Batches', 'ninja'),
                                                                            'hint'          => __("How many rows will be added to DB by once", 'ninja'),
                                                                            'before'        => '',
                                                                            'after'         => '',
                                                                            'inline'        => TRUE,
                                                                            'order'         => 10,
                                                                        ],
                                                                        'submit'   => [
                                                                            'class'  => 'col-lg-2 col-md-2 offset-lg-10 offset-md-10 mb-2',
                                                                            'type'   => 'submit',
                                                                            'value'  => __('Start', 'ninja'),
                                                                            'before' => '',
                                                                            'after'  => '',
                                                                            'order'  => 15,
                                                                        ]
                                                                    ], [
                                                                        'attr'       => 'novalidate enctype="multipart/form-data"',
                                                                        'class'      => Nh::_DOMAIN_NAME . '-import-form',
                                                                        'form_class' => 'needs-validation',
                                                                        'id'         => Nh::_DOMAIN_NAME . '_import_form'
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
