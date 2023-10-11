<?php
    /**
     * @Filename: single-service.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */

    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Service;
    use NH\Nh;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home');
    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-service-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/service');

    global $post;

    $services_obj    = new Nh_Service();
    $service         = $services_obj->convert($post);
    $available_slots = array_chunk($service->available_slots, 4);
?>


    <!-- Page Content -->
    <section class="page-content">
        <!-- Service Content -->
        <div class="service-content-wrapper">
            <div class="service-banner-wrapper">
                <div class="service-banner">
                    <a href="<?php echo get_post_type_archive_link('service'); ?>" class="back-link">
                        <i class="icon bbc-previous-circle"></i> <?= __('Bak To Services', 'ninja') ?>
                    </a>
                    <img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/services/service-banner.webp"
                         alt="Service Banner" class="banner">
                </div>
            </div>
            <div class="service-content">
                <div class="service-details">
                    <h1 class="service-title">
					<span class="title-icon">
						<img src="<?php echo wp_get_attachment_image_url((int)$service->meta_data['service_icon']) ?>"
                             alt="<?= $service->title ?>" class="img-fluid">
					</span>
                        <span class="splitter"></span>
                        <span class="title"><?= $service->title ?></span>
                    </h1>
                    <h3 class="service-subtitle"><?= __('Description of the service', 'ninja') ?></h3>
                    <div class="service-description">
                        <?= $service->content ?>
                    </div>
                    <?php
                        if (!empty($service->meta_data['features'])) {
                            ?>
                            <h3 class="service-subtitle"><?= __('Important features of the service:', 'ninja') ?></h3>
                            <ul class="service-features">
                                <?php
                                    $features = get_field('features', $service->ID);
                                    foreach ($features as $key => $feature) {
                                        ?>
                                        <li class="service-feature">
                                            <span class="service-features-number"><?= $key + 1 ?></span>
                                            <span class="service-feature-text"><?= $feature['feature'] ?></span>
                                        </li>
                                        <?php
                                    }
                                ?>

                            </ul>
                            <?php
                        }
                    ?>
                </div>

                <form class="service-subscription-form">
                    <h3 class="form-title"><?= __('Subscribe Now!', 'ninja') ?></h3>
                    <div class="form-field">
                        <input type="text" id="name" name="name" class="form-control">
                        <label for="name" class="form-control-label"><?= __('Name', 'ninja') ?></label>
                    </div>
                    <div class="form-field">
                        <input type="email" id="email" name="email" class="form-control">
                        <label for="email" class="form-control-label"><?= __('Email', 'ninja') ?></label>
                    </div>
                    <div class="form-field">
                        <input type="text" id="mobile" name="mobile" class="form-control">
                        <label for="mobile" class="form-control-label"><?= __('Mobile', 'ninja') ?></label>
                    </div>
                    <div class="time-slots">
                        <h4 class="time-slots-title"><?= __('Select Your Slot', 'ninja') ?></h4>
                        <?php
                            foreach ($available_slots as $slot) {
                                ?>
                                <div class="time-slots-group">
                                    <?php
                                        foreach ($slot as $key => $single_slot) {
                                            ?>
                                            <div class="time-slot">
                                                <input type="radio" name="timeslot" value="slot<?= $key ?>" id="slot<?= $key ?>" class="form-check-input">
                                                <label class="time-slot-details" for="slot<?= $key ?>">
                                                    <span class="date"><?= $single_slot['day_name'] ?></span>
                                                    <div>
                                                        <?php
                                                            foreach ($single_slot['slots'] as $time_slot) {
                                                                ?><span class="time from d-block"><?= $time_slot ?></span><?php
                                                            }
                                                        ?>
                                                    </div>
                                                </label>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                    <button type="submit" class="form-action bbc-btn large apply"><?= __('Checkout Now', 'ninja') ?></button>
                </form>

            </div>
        </div>
    </section>
    </div> <!-- </layout> -->
    </main>
    </div> <!-- </landing-page> -->

<?php get_footer();
