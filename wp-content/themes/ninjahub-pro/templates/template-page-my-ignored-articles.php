<?php

/**
 * @Filename: template-my-fav-articles.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: My Ignored Articles Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */


use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Acquisition;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account');

global $user_ID;
$Blog_obj  = new Nh_Blog();
$blogs    = $Blog_obj->get_profile_ignored_articles();
$user_obj         = Nh_User::get_current_user();
?>

<main class="my-fav-opportunities">
    <div class="container container-xxl">
        <?php Nh_Public::breadcrumbs(); ?>

        <nav class="dashboard-submenus mt-3 mb-5">
            <?php get_template_part('app/Views/template-parts/dashboard-submenus/main-nav', NULL, ['active_link' => 'my_favorite_article']); ?>
            <?php get_template_part('app/Views/template-parts/dashboard-submenus/articles-sub-nav', NULL, ['active_link' => 'my_ignored_article']); ?>
        </nav>
    </div>

    <section class="page-content opportunity-content">
        <?php

        foreach ($blogs as $single_post) {
            $ignore_chk = $Blog_obj->is_post_in_user_ignored($single_post->ID);
            ?>
            <div class="blog-item card">

                <a href="<?= $single_post->link ?>" class="img">
                    <img src="<?= $single_post->thumbnail ?>" alt="B2B" />
                    <span class="dots"></span>
                </a>

                    <div class="card-image">
                        <div class="opportunity-item-controllers">
                            <?php
                            if ($ignore_chk) {
                                $fav_class = 'bbc-star';
                            } else {
                                $fav_class = 'bbc-star-o';
                            }
                            echo Nh_Forms::get_instance()
                                ->create_form([
                                    'post_id'                      => [
                                        'type'   => 'hidden',
                                        'name'   => 'post_id',
                                        'before' => '',
                                        'after'  => '',
                                        'value'  => $single_post->ID,
                                        'order'  => 0
                                    ],
                                    'add_to_fav_nonce'               => [
                                        'class' => '',
                                        'type'  => 'nonce',
                                        'name'  => 'add_to_fav_nonce_nonce',
                                        'value' => Nh::_DOMAIN_NAME . "_add_to_fav_nonce_form",
                                        'order' => 5
                                    ],
                                    'submit_add_to_fav_request' => [
                                        'class'               => 'btn btn-light bg-white article-to-favorite ninja-add-to-fav',
                                        'id'                  => 'submit_add_to_fav_request',
                                        'type'                => 'submit',
                                        'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
                                        'recaptcha_form_name' => 'frontend_add_to_fav',
                                        'order'               => 10
                                    ],
                                ], [
                                    'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
                                ]);
                            ?>
                        </div>
                    </div>


                    <div class="card-image">
                        <div class="opportunity-item-controllers">
                            <?php
                            if ($ignore_chk) {
                                $fav_class = 'bbc-star';
                            } else {
                                $fav_class = 'bbc-star-o';
                            }
                            echo Nh_Forms::get_instance()
                                ->create_form([
                                    'post_id'                      => [
                                        'type'   => 'hidden',
                                        'name'   => 'post_id',
                                        'before' => '',
                                        'after'  => '',
                                        'value'  => $single_post->ID,
                                        'order'  => 0
                                    ],
                                    'ignore_article_nonce'               => [
                                        'class' => '',
                                        'type'  => 'nonce',
                                        'name'  => 'ignore_article_nonce',
                                        'value' => Nh::_DOMAIN_NAME . "_ignore_article_nonce_form",
                                        'order' => 5
                                    ],
                                    'submit_ignore' => [
                                        'class'               => 'btn',
                                        'id'                  => 'submit_submit_ignore',
                                        'type'                => 'submit',
                                        'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
                                        'recaptcha_form_name' => 'frontend_ignore',
                                        'order'               => 10
                                    ],
                                ], [
                                    'class' => Nh::_DOMAIN_NAME . '-create-ignore-article-form',
                                ]); ?>
                        </div>
                    </div>


                <div class="title">
                    <a href="<?= $single_post->link ?>"><?= $single_post->title ?></a>
                </div>


                <?php if (!empty($single_post->taxonomy['category'])) : ?>
                    <div class="category">
                        <?= $single_post->taxonomy['category'][0]->name ?>
                    </div>
                <?php endif; ?>


                <?php if (!empty($opportunity)) : ?>
                    <div class="opportunity">
                        <a href="<?= $opportunity->link ?>"><?= $opportunity->name; ?></a>
                    </div>
                <?php endif; ?>


                <div class="date">
                    <img src="<?= get_avatar_url($single_post->author) ?>" alt="B2B" />
                    <p><?= __('on', 'ninja') ?> <?= date('F d, Y', strtotime($single_post->created_date)) ?></p>
                </div>
                <div class="short-description">
                    <?= $single_post->excerpt ?>
                </div>
            </div>
        <?php
        }

        ?>
    </section>
</main><!-- #main -->

<?php get_footer();
