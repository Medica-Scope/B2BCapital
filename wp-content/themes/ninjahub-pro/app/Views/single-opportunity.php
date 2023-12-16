<?php

    /**
     * @Filename: single.php
     * @Description:
     * @User: Mustafa Shaaban
     * @Date: 9/21/2023
     */

    use NH\APP\CLASSES\Nh_Init;
    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Acquisition;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Bid;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Investments;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
    use NH\Nh;

    global $user_ID, $post;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-single-opportunity', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/single-opportunity');

    $opportunity_obj             = new Nh_Opportunity();
    $opportunity_bids_obj        = new Nh_Opportunity_Bid();
    $opportunity_acquisition_obj = new Nh_Opportunity_Acquisition();
    $opportunity_investments_obj = new Nh_Opportunity_Investments();
    $opportunity                 = $opportunity_obj->get_by_id($post->ID);
    $business_model              = isset($opportunity->taxonomy['business-model']) ? implode(' + ', array_map(function($single) {
        return $single->name;
    }, $opportunity->taxonomy['business-model'])) : '';
    $opportunity_type            = isset($opportunity->taxonomy['opportunity-type']) ? $opportunity->taxonomy['opportunity-type'][0]->term_id : '';
    $unique_type_name            = get_term_meta($opportunity_type, 'unique_type_name', TRUE);
    $opportunity_bids            = $opportunity_obj->get_opportunity_bids($opportunity->ID, TRUE);
    $opportunity_acquisitions    = $opportunity_obj->get_opportunity_acquisitions($opportunity->ID, TRUE);
    $opportunity_investments     = $opportunity_obj->get_opportunity_investments($opportunity->ID, TRUE);
    $fav_chk                     = FALSE;
    $ignore_chk                  = FALSE;
    $fav_class                   = '';
    $ignore_class                = '';
    $fav_text                    = '';
    $ignore_text                 = '';
    if ($user_ID) {
        $fav_chk = $opportunity_obj->is_opportunity_in_user_favorites($opportunity->ID);
        if ($fav_chk) {
            $fav_class = 'bbc-star';
            $fav_text  = __('Unfavored', 'ninja');
        } else {
            $fav_class = 'bbc-star-o';
            $fav_text  = __('Favorite', 'ninja');
        }
        $ignore_chk = $opportunity_obj->is_opportunity_in_user_ignored($opportunity->ID);
        if ($ignore_chk) {
            $ignore_class = 'controll-icon bbc-thumbs-up text-success';
            $ignore_text  = __('Ignored', 'ninja');

        } else {
            $ignore_class = 'controll-icon bbc-thumbs-down text-danger';
            $ignore_text  = __('Ignore', 'ninja');
        }
    }
?>

    <main class="container container-xxl">
        <div class="row align-items-end">
            <div class="col-8">
                <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('dashboard'))) ?>"
                   class="btn btn-light text-uppercase mb-2"><i class="bbc-chevron-left"></i>
                    <?= __('Back', 'ninja'); ?>
                </a>
                <h3 class="mb-4">
                    <?= $opportunity->title; ?>
                </h3>

                <h3 class="text-warning">
                    <?= __('Business Type', 'ninja'); ?>
                </h3>

                <p>
                    <?= $opportunity->taxonomy['business-type'][0]->name ?>
                </p>
            </div>
            <div class="col-4 actions">
                <?php

                    echo Nh_Forms::get_instance()
                                 ->create_form([
                                     'opp_id'                    => [
                                         'type'   => 'hidden',
                                         'name'   => 'opp_id',
                                         'before' => '',
                                         'after'  => '',
                                         'value'  => $opportunity->ID,
                                         'order'  => 0
                                     ],
                                     'add_to_fav_nonce'          => [
                                         'class' => '',
                                         'type'  => 'nonce',
                                         'name'  => 'add_to_fav_nonce_nonce',
                                         'value' => Nh::_DOMAIN_NAME . "_add_to_fav_nonce_form",
                                         'order' => 5
                                     ],
                                     'submit_add_to_fav_request' => [
                                         'class'               => 'btn-success',
                                         'id'                  => 'submit_add_to_fav_request',
                                         'type'                => 'submit',
                                         'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
                                         'recaptcha_form_name' => 'frontend_add_to_fav',
                                         'order'               => 10
                                     ],
                                 ], [
                                     'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
                                     'id'    => Nh::_DOMAIN_NAME . '_add_to_fav_form'
                                 ]);


                    echo Nh_Forms::get_instance()
                                 ->create_form([
                                     'opp_id'                   => [
                                         'type'   => 'hidden',
                                         'name'   => 'opp_id',
                                         'before' => '',
                                         'after'  => '',
                                         'value'  => $opportunity->ID,
                                         'order'  => 0
                                     ],
                                     'ignore_opportunity_nonce' => [
                                         'class' => '',
                                         'type'  => 'nonce',
                                         'name'  => 'ignore_opportunity_nonce',
                                         'value' => Nh::_DOMAIN_NAME . "_ignore_opportunity_nonce_form",
                                         'order' => 5
                                     ],
                                     'submit_ignore'            => [
                                         'class'               => 'btn-light bg-white',
                                         'id'                  => 'submit_submit_ignore',
                                         'type'                => 'submit',
                                         'value'               => '<i class="' . $ignore_class . ' ignore-star"></i>',
                                         'recaptcha_form_name' => 'frontend_ignore',
                                         'order'               => 10
                                     ],
                                 ], [
                                     'class' => Nh::_DOMAIN_NAME . '-create-ignore-opportunity-form',
                                     'id'    => Nh::_DOMAIN_NAME . '_create_ignore_opportunity_form'
                                 ]);

                    if ($opportunity->meta_data['opportunity_stage'] === 'publish') {

                        if (Nh_User::get_user_role() === Nh_User::INVESTOR) {
                            if ($unique_type_name === 'bidding') {
                                if ($opportunity_bids_obj->user_can_bid($user_ID, $opportunity->ID)) {
                                    ?>
                                    <div class="bidding-modal">
                                        <!-- Button trigger modal -->
                                        <button type="button" id="addBidModalBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBidModal">
                                            <?= __('Add Bid', 'ninja') ?>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="addBidModal" tabindex="-1" aria-labelledby="addBidModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="addBidModalLabel">
                                                            <?= __('Add Bid', 'ninja') ?>
                                                        </h1>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div>
                                                            <div>
                                                                <p>
                                                                    <?= __('Start bidding amount', 'ninja') ?>
                                                                </p>
                                                                <span> $
															<?= $opportunity->meta_data['start_bidding_amount'] ?>
														</span>
                                                            </div>
                                                            <div>
                                                                <p>
                                                                    <?= __('Target amount', 'ninja') ?>
                                                                </p>
                                                                <span> $
															<?= $opportunity->meta_data['target_amount'] ?>
														</span>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <?= Nh_Forms::get_instance()
                                                                        ->create_form([
                                                                            'bid_amount'    => [
                                                                                'class'       => '',
                                                                                'type'        => 'number',
                                                                                'name'        => 'bid_amount',
                                                                                'placeholder' => __('Add Bid', 'ninja'),
                                                                                'before'      => '',
                                                                                'order'       => 0,
                                                                            ],
                                                                            'opp_id'        => [
                                                                                'type'   => 'hidden',
                                                                                'name'   => 'opp_id',
                                                                                'before' => '',
                                                                                'after'  => '',
                                                                                'value'  => $opportunity->ID,
                                                                                'order'  => 5
                                                                            ],
                                                                            'start_bid'     => [
                                                                                'type'  => 'hidden',
                                                                                'id'    => Nh::_DOMAIN_NAME . '_start_bid',
                                                                                'name'  => 'start_bid',
                                                                                'value' => (int)$opportunity->meta_data['start_bidding_amount'],
                                                                                'order' => 10
                                                                            ],
                                                                            'add_bid_nonce' => [
                                                                                'class' => '',
                                                                                'type'  => 'nonce',
                                                                                'name'  => 'add_bid_nonce',
                                                                                'value' => Nh::_DOMAIN_NAME . "_add_bid_nonce_form",
                                                                                'order' => 15
                                                                            ],
                                                                            'submit_bid'    => [
                                                                                'class'               => 'btn',
                                                                                'id'                  => 'submit_bid',
                                                                                'type'                => 'submit',
                                                                                'value'               => __('Start Bidding', 'ninja'),
                                                                                'recaptcha_form_name' => 'frontend_add_bid',
                                                                                'order'               => 20
                                                                            ],
                                                                        ], [
                                                                            'class' => Nh::_DOMAIN_NAME . '-add-bid-form',
                                                                            'id'    => Nh::_DOMAIN_NAME . '_add_bid_form'
                                                                        ]); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    $bids = $opportunity_bids_obj->get_bid_by_user($user_ID, $opportunity->ID);
                                    if ($bids) {
                                        ?>
                                        <button type="button" class="btn btn-primary">
                                            <?= sprintf(__("Your bid status is %s", 'ninja'), $bids->meta_data['bidding_stage']) ?>
                                        </button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="button" class="btn btn-primary">
                                            <?= __('Bid Sent', 'ninja') ?>
                                        </button>
                                        <?php
                                    }
                                }
                            }

                            if ($unique_type_name === 'acquisition') {
                                if ($opportunity_acquisition_obj->user_can_acquire($user_ID, $opportunity->ID)) {
                                    ?>
                                    <!-- Button trigger modal -->
                                    <button type="button" id="createAcquisitionBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAcquisitionModal">
                                        <?= __('Acquisition', 'ninja') ?>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="createAcquisitionModal" tabindex="-1" aria-labelledby="createAcquisitionLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="createAcquisitionLabel">
                                                        <?= __('Acquisition', 'ninja') ?>
                                                    </h1>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?= __('Are you sure you want to send this request?', 'ninja') ?></p>
                                                    <?php
                                                        echo Nh_Forms::get_instance()
                                                                     ->create_form([
                                                                         'opp_id'                      => [
                                                                             'type'   => 'hidden',
                                                                             'name'   => 'opp_id',
                                                                             'before' => '',
                                                                             'after'  => '',
                                                                             'value'  => $opportunity->ID,
                                                                             'order'  => 0
                                                                         ],
                                                                         'create_acquisitions_nonce'   => [
                                                                             'class' => '',
                                                                             'type'  => 'nonce',
                                                                             'name'  => 'create_acquisitions_nonce',
                                                                             'value' => Nh::_DOMAIN_NAME . "_create_acquisitions_nonce_form",
                                                                             'order' => 5
                                                                         ],
                                                                         'submit_acquisitions_request' => [
                                                                             'class'               => 'btn nh-hidden',
                                                                             'id'                  => 'submit_acquisitions_request',
                                                                             'type'                => 'submit',
                                                                             'value'               => __('Acquisition', 'ninja'),
                                                                             'recaptcha_form_name' => 'frontend_create_acquisitions',
                                                                             'order'               => 15
                                                                         ],
                                                                     ], [
                                                                         'class' => Nh::_DOMAIN_NAME . '-create-acquisition-form',
                                                                         'id'    => Nh::_DOMAIN_NAME . '_create_acquisition_form'
                                                                     ]);
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-dismiss" data-bs-dismiss="modal"><?= __('Cancel', 'ninja') ?></button>
                                                    <button type="button" class="btn btn-primary" id="modalFormSubmit"
                                                            data-target="submit_acquisitions_request"><?= __('Acquisition', 'ninja') ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                } else {
                                    $acquisition = $opportunity_acquisition_obj->get_acquisition_by_user($user_ID, $opportunity->ID);
                                    if ($acquisition) {
                                        ?>
                                        <button type="button" class="btn btn-primary">
                                            <?= sprintf(__("Your request is %s", 'ninja'), $acquisition->meta_data['acquisitions_stage']) ?>
                                        </button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="button" class="btn btn-primary">
                                            <?= __('Acquisition Request Sent', 'ninja') ?>
                                        </button>
                                        <?php
                                    }
                                }
                            }

                            if ($unique_type_name === 'regular') {
                                if ($opportunity_investments_obj->user_can_invest($user_ID, $opportunity->ID)) {
                                    ?>
                                    <!-- Button trigger modal -->
                                    <button type="button" id="createInvestBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createInvestModal">
                                        <?= __('Invest Request', 'ninja') ?>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="createInvestModal" tabindex="-1" aria-labelledby="createInvestLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="createInvestLabel">
                                                        <?= __('Invest Request', 'ninja') ?>
                                                    </h1>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?= __('Are you sure you want to send this request?', 'ninja') ?></p>
                                                    <?php
                                                        echo Nh_Forms::get_instance()
                                                                     ->create_form([
                                                                         'opp_id'                     => [
                                                                             'type'   => 'hidden',
                                                                             'name'   => 'opp_id',
                                                                             'before' => '',
                                                                             'after'  => '',
                                                                             'value'  => $opportunity->ID,
                                                                             'order'  => 0
                                                                         ],
                                                                         'create_investments_nonce'   => [
                                                                             'class' => '',
                                                                             'type'  => 'nonce',
                                                                             'name'  => 'create_investments_nonce',
                                                                             'value' => Nh::_DOMAIN_NAME . "_create_investments_nonce_form",
                                                                             'order' => 5
                                                                         ],
                                                                         'submit_investments_request' => [
                                                                             'class'               => 'btn nh-hidden',
                                                                             'id'                  => 'submit_investments_request',
                                                                             'type'                => 'submit',
                                                                             'value'               => __('Invest Request', 'ninja'),
                                                                             'recaptcha_form_name' => 'frontend_create_investments',
                                                                             'order'               => 15
                                                                         ],
                                                                     ], [
                                                                         'class' => Nh::_DOMAIN_NAME . '-create-investment-form',
                                                                         'id'    => Nh::_DOMAIN_NAME . '_create_investment_form'
                                                                     ]);
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-dismiss" data-bs-dismiss="modal"><?= __('Cancel', 'ninja') ?></button>
                                                    <button type="button" class="btn btn-primary" id="modalFormSubmit"
                                                            data-target="submit_investments_request"><?= __('Invest Request', 'ninja') ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    $investment = $opportunity_investments_obj->get_investment_by_user($user_ID, $opportunity->ID);
                                    if ($investment) {
                                        ?>
                                        <button type="button" class="btn btn-primary">
                                            <?= sprintf(__("Your request is %s", 'ninja'), $investment->meta_data['investments_stage']) ?>
                                        </button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="button" class="btn btn-primary">
                                            <?= __('Investment Request Sent', 'ninja') ?>
                                        </button>
                                        <?php
                                    }
                                }
                            }
                        }

                        if (Nh_User::get_user_role() === Nh_User::OWNER) {
                            if ($unique_type_name === 'bidding') {
                                ?>
                                <span class="text-dark">
                                    <?= sprintf(_n('%s Bid', '%s Bids', $opportunity_bids, 'ninja'), "<span class='bids-numbers'>" . $opportunity_bids . "</span>") ?>
                                </span>
                                <?php
                            }

                            if ($unique_type_name === 'acquisition') {
                                ?>
                                <span class="text-dark">
                                    <?= sprintf(_n('%s Request', '%s Requests', $opportunity_acquisitions, 'ninja'), "<span class='acquisitions-numbers'>" . $opportunity_acquisitions . "</span>") ?>
                                </span>
                                <?php
                            }

                            if ($unique_type_name === 'regular') {
                                ?>
                                <span class="text-dark">
                                    <?= sprintf(_n('%s Request', '%s Requests', $opportunity_investments, 'ninja'), "<span class='regular-numbers'>" . $opportunity_investments . "</span>") ?>
                                </span>
                                <?php
                            }
                        }

                    } else {
                        if (Nh_User::get_user_role() !== Nh_User::INVESTOR) {
                            if ($opportunity->meta_data['opportunity_stage'] === 'cancel') {
                                _ex('<p>Opportunity is canceled..</p>', 'ninja');
                            } elseif ($opportunity->meta_data['opportunity_stage'] === 'hold') {
                                _ex('<p>Opportunity is on hold..</p>', 'ninja');
                            } else {
                                _ex('<p>Opportunity is under reviewing..</p>', 'ninja');
                            }
                        }
                    }
                ?>
            </div>
        </div>

        <div class="opportunity-details row row-cols-1 row-cols-md-2 g-4 mt-2">
            <div class="col details-items">
                <div class="card shadow">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= $opportunity->thumbnail ?>" class="img-fluid rounded-start"
                                 alt="<?= esc_attr($opportunity->title); ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <?= __('About', 'ninja') ?>
                                </h5>
                                <div class="card-text">
                                    <?= wp_html_excerpt($opportunity->meta_data['short_description'], 140, '...'); ?>
                                </div>
                                <div class="card-extra-info">

                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_date_founded'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Date Founded', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold">
                                                <?php
                                                    if ((int)$opportunity->meta_data['date_founded_group_appearance'] === 1) {
                                                        echo date('F j, Y', strtotime($opportunity->meta_data['date_founded_group_date_founded']));
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>

                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_asking_price_in_usd'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('$ Asked Price', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold text-success">
                                                <?php
                                                    if ((int)$opportunity->meta_data['asking_price_in_usd_group_appearance'] === 1) {
                                                        echo '$ ' . $opportunity->meta_data['asking_price_in_usd_group_asking_price_in_usd'];
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>

                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_number_of_customers'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Customers', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold">
                                                <?php
                                                    if ((int)$opportunity->meta_data['number_of_customers_group_appearance'] === 1) {
                                                        echo $opportunity->meta_data['number_of_customers_group_number_of_customers'];
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>

                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_business_team_size'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Team size', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold">
                                                <?php
                                                    if ((int)$opportunity->meta_data['business_team_size_group_appearance'] === 1) {
                                                        echo $opportunity->meta_data['business_team_size_group_business_team_size'];
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col details-items">
                <div class="card shadow">
                    <div class="row g-0">
                        <div class="col-12">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <?= __('Financial Details', 'ninja') ?>
                                </h5>
                                <div class="card-extra-info">

                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_net_profit'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Net Profit', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold text-success">
                                                <?php
                                                    if ((int)$opportunity->meta_data['net_profit_group_appearance'] === 1) {
                                                        echo '$ ' . $opportunity->meta_data['net_profit_group_net_profit'];
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>

                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_valuation_in_usd'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Valuation', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold text-success">
                                                <?php
                                                    if ((int)$opportunity->meta_data['valuation_in_usd_group_appearance'] === 1) {
                                                        echo '$ ' . $opportunity->meta_data['valuation_in_usd_group_valuation_in_usd'];
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>

                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_stake_to_be_sold_percentage'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Stake to be sold', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold">
                                                <?php
                                                    if ((int)$opportunity->meta_data['stake_to_be_sold_percentage_group_appearance'] === 1) {
                                                        echo $opportunity->meta_data['stake_to_be_sold_percentage_group_stake_to_be_sold_percentage'] . '%';
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>


                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_usd_exchange_rate_used_in_conversion'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Conversion rate in $', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold">
                                                <?php
                                                    if ((int)$opportunity->meta_data['usd_exchange_rate_used_in_conversion_group_appearance'] === 1) {
                                                        echo $opportunity->meta_data['usd_exchange_rate_used_in_conversion_group_usd_exchange_rate_used_in_conversion'];
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>

                                            </p>
                                        </div>
                                    <?php } ?>

                                </div>
                                <div class="card-extra-info">

                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_annual_accounting_revenue'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Annual Accounting Revenue', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold text-success">
                                                <?php
                                                    if ((int)$opportunity->meta_data['annual_accounting_revenue_group_appearance'] === 1) {
                                                        echo '$ ' . $opportunity->meta_data['annual_accounting_revenue_group_annual_accounting_revenue'];
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>


                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_annual_growth_rate_percentage'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Annual Growth Rate', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold">
                                                <?php
                                                    if ((int)$opportunity->meta_data['annual_growth_rate_percentage_group_appearance'] === 1) {
                                                        echo $opportunity->meta_data['annual_growth_rate_percentage_group_annual_growth_rate_percentage'] . '%';
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>

                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_annual_growth_rate'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Annual Growth Rate', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold text-success">
                                                <?php
                                                    if ((int)$opportunity->meta_data['annual_growth_rate_group_appearance'] === 1) {
                                                        echo '$ ' . $opportunity->meta_data['annual_growth_rate_group_annual_growth_rate'];
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col details-items">
                <div class="card shadow">
                    <div class="row g-0">
                        <div class="col-12">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <?= __('Business Overview', 'ninja') ?>
                                </h5>

                                <div class="card-extra-info">
                                    <div class="card-info-item">
                                        <small class="text-body-secondary">
                                            <?= __('Business model', 'ninja') ?>
                                        </small>
                                        <p class="card-text fw-bold">
                                            <?= $business_model ?>
                                        </p>
                                    </div>

                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_tech_stack_this_product_is_built_on'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Tech stack', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold">
                                                <?php
                                                    if ((int)$opportunity->meta_data['tech_stack_this_product_is_built_on_group_appearance'] === 1) {
                                                        echo $opportunity->meta_data['tech_stack_this_product_is_built_on_group_tech_stack_this_product_is_built_on'];
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>


                                    <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_product_competitors'] === 1) { ?>
                                        <div class="card-info-item">
                                            <small class="text-body-secondary">
                                                <?= __('Product competitors', 'ninja') ?>
                                            </small>
                                            <p class="card-text fw-bold">
                                                <?php
                                                    if ((int)$opportunity->meta_data['product_competitors_group_appearance'] === 1) {
                                                        echo $opportunity->meta_data['product_competitors_group_product_competitors'];
                                                    } else {
                                                        _ex('<span class="">HIDDEN</span>', 'ninja');
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>

                                </div>

                                <?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_extra_details'] === 1) { ?>
                                    <div class="extra-info">
                                        <?php
                                            if ((int)$opportunity->meta_data['extra_details_group_appearance'] === 1) {
                                                echo $opportunity->meta_data['extra_details_group_extra_details'];
                                            } else {
                                                _ex('<span class="">BUSINESS INFORMATION ARE HIDDEN</span>', 'ninja');
                                            }
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col details-items">
                <?php get_template_part('app/Views/template-parts/cards/faq-help-card', NULL, []); ?>
            </div>
        </div>

        <div class="related-opportunities mb-4">
            <h3>
                <?= __('Related Opportunities', 'ninja'); ?>
            </h3>
            <?php
                $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
                $profile_obj = new Nh_Profile();
                $profile     = $profile_obj->get_by_id((int)$profile_id);
                if (!is_wp_error($profile) && isset($profile->meta_data['preferred_opportunities_cat_list']) && !empty($profile->meta_data['preferred_opportunities_cat_list'])) {
                    $related_opportunities = $opportunity_obj->get_all_custom([ 'publish' ], -1, 'date', 'desc', [], [
                        'taxonomy' => 'opportunity-category',
                        'terms'    => $profile->meta_data['preferred_opportunities_cat_list'],
                        'field'    => 'term_id'
                    ], $user_ID, 1, [], [], 'ids');
                    if (!empty($related_opportunities['posts'])) {
                        get_template_part('app/Views/template-parts/related-opportunities-slider', NULL, [ 'related_opportunities' => $related_opportunities['posts'] ]);
                    } else {
                        get_template_part('app/Views/template-parts/related-opportunities-slider', NULL, [ 'related_opportunities' => $opportunity->meta_data['related_opportunities'] ]);
                    }
                } else {
                    get_template_part('app/Views/template-parts/related-opportunities-slider', NULL, [ 'related_opportunities' => $opportunity->meta_data['related_opportunities'] ]);
                }
            ?>
        </div>
    </main><!-- #main -->

<?php get_template_part('app/Views/js-templates/horizontal-scroll', NULL, [ 'scrollable_container' => '.related-opportunities-slider .overflow-x-auto' ]); ?>

<?php
    get_footer();
