<?php

    /**
     * @Filename: index.php
     * @Description: Blog Page
     * @User: Ahmed Gamal
     * @Date: 26/9/2023
     *
     * @package NinjaHub
     * @since 1.0
     *
     */
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Faq;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

get_header();
global $wp_query, $post, $user_ID;
?>

<main id="" class="">
<?php global $post; ?>
    <?php Nh_Public::breadcrumbs(); ?>

    <h1 class="page-title"><?= __("Blogs", "ninja") ?></h1>

    <div class="blogs-list">
        <?= get_template_part('app/Views/blogs-list') ?>
    </div>

</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
