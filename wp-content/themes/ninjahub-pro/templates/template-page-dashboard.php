<?php
    /**
     * @Filename: template-page-dashboard.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Dashboard Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */


    use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\Nh_Public;

    global $user_ID;

    get_header();
?>

    <main id="" class="site-dashboard-home">
        <?php Nh_Public::breadcrumbs(); ?>

        <div class="container-fluid">
            <div class="nh-dashboard-overview">
                <h3><?= __('Overview', 'ninja') ?></h3>
                <div class="widget-list">
                    <div class="single-widget">
                        widget 1
                    </div>
                </div>
            </div>

            <hr>

            <section class="dashboard-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="dashboard-opportunity-list-container">
                            <header class="opportunity-list-header d-flex justify-content-between align-items-center">
                                <div class="opportunity-title">
                                    <h3><?= __('Latest Opportunities', 'ninja') ?></h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab asperiores eaque eos fuga neque, pariatur.</p>
                                </div>
                                <div class="opportunity-filters d-flex justify-content-center">
                                    <div class="opportunity-list-style">Style</div>
                                    <div class="opportunity-list-filter">Filter</div>
                                </div>
                            </header>
                            <div class="opportunity-list">
                                <div class="row">
                                    <?php

                                        $opportunities_obj = new Nh_Opportunity();
                                        $opportunities     = $opportunities_obj->get_all();

                                        foreach ($opportunities as $opportunity) {
                                            ?>
                                            <div class="col-md-6">
                                                <div class="opportunity-item">
                                                    <div class="thumbnail">
                                                        <a href="<?= $opportunity->link ?>"><img src="<?= $opportunity->thumbnail ?>" alt="<?= $opportunity->title ?>"></a>
                                                        <div class="item-controllers">
                                                            <button class="btn opportunity-to-favorite">Fav Icon</button>
                                                            <button class="btn">:</button>
                                                        </div>
                                                    </div>
                                                    <div class="opportunity-content">
                                                        <a href="<?= $opportunity->link ?>">
                                                            <h5><?= $opportunity->title ?></h5>
                                                            <h6><?= __('Business Type', 'ninja') ?></h6>
                                                            <p>test, test2</p>
                                                            <h6><?= $opportunity->created_date ?></h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="side-bar-container">
                            <div class="sidebar-create-opportunity">
                                <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('dashboard/create-opportunity'))) ?>"><?= __('Create New Opportunity', 'ninja') ?></a>
                                <span><?= __('Please Note You Can Add Only One Opportunity In Month', 'ninja') ?></span>
                            </div>
                            <div class="sidebar-my-opportunities">
                                <h3><?= __('My Opportunities', 'ninja') ?></h3>
                            </div>
                            <div class="sidebar-latest-acquisitions">
                                <h3><?= __('Latest acquisitions', 'ninja') ?></h3>
                            </div>
                            <div class="sidebar-faq">
                                <h3><?= __('Help and Modules', 'ninja') ?></h3>
                                <p><?= __('Our help and module screens are here to make your life easier', 'ninja') ?></p>
                                <a href="<?= apply_filters( 'nhml_permalink', get_post_type_archive_link('faq') ) ?>"><?= __('Go', 'ninja') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </main><!-- #main -->

<?php get_footer();

