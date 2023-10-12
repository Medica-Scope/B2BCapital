<?php
    /**
     * @Filename: single-service.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */

    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Appointment;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Service;
    use NH\Nh;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home');
    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-service-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/service');

    global $post;

    $services_obj    = new Nh_Service();
    $appointments    = new Nh_Appointment();
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

                <div class="ninja_form_container service-subscription-form ninja-appointment-form-container">
                    <form class="ninja_form ninja-appointment-form" id="ninja_appointment_form">
                        <h3 class="form-title"><?= __('Subscribe Now!', 'ninja') ?></h3>
                        <div class="form-field">
                            <input type="text" id="name" name="name" class="form-control" required>
                            <label for="name" class="form-control-label"><?= __('Name', 'ninja') ?></label>
                        </div>
                        <div class="form-field">
                            <input type="email" id="email" name="email" class="form-control" required>
                            <label for="email" class="form-control-label"><?= __('Email', 'ninja') ?></label>
                        </div>
                        <div class="form-field">
                            <input type="text" id="mobile" name="mobile" class="form-control" required>
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
                                                    <input type="radio" name="timeslot" value="slot<?= $key ?>" class="form-check-input" required>
                                                    <div class="time-slot-details">
                                                        <span class="date"><?= $single_slot['full_data_format'] ?></span>
                                                        <?php
                                                            foreach ($single_slot['slots'] as $time_slot) {

                                                                if ($appointments->check_appointment_slot([
                                                                    'day'  => $single_slot['data']['day'],
                                                                    'date' => $single_slot['data']['date'],
                                                                    'time' => $time_slot
                                                                ])) {
                                                                    continue;
                                                                }

                                                                ?><span class="time ninja-single-time d-block" data-day="<?= $single_slot['data']['day'] ?>"
                                                                        data-date="<?= $single_slot['data']['date'] ?>" data-time="<?= $time_slot ?>" >
                                                                <?= $time_slot ?>
                                                                </span><?php
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>

                        <?php
                            if ( is_plugin_active( 'google-captcha/google-captcha.php' ) && function_exists( 'gglcptch_display_custom' ) ) {
                                echo apply_filters( 'gglcptch_display_recaptcha', '', 'frontend_create_appointment' );
                            }
                            echo wp_nonce_field( Nh::_DOMAIN_NAME . "_create_appointment_form", "create_appointment_form", TRUE, FALSE );
                        ?>

                        <input type="hidden" name="service_id" value="<?= $post->ID ?>">
                        <input type="hidden" name="service_title" value="<?= $post->post_title ?>">

                        <button type="submit" class="form-action bbc-btn large apply"><?= __('Checkout Now', 'ninja') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    </div> <!-- </layout> -->
    </main>
    </div> <!-- </landing-page> -->

<?php get_footer();
