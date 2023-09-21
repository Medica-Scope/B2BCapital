<?php

/**
 * @Filename: single.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */

use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home');
global $post;
$blog_obj = new Nh_Blog();
$single = $blog_obj->convert($post);
?>
<div class="single-blog">
    <div class="cover-image">
        <img src="<?= $single->thumbnail ?>" alt="B2B" />
    </div>
    <div class="date">
        <p><?= date('F d, Y', strtotime($single->created_date)); ?></p>
    </div>
    <div class="content">
        <?= $single->content ?>
    </div>
    <div class="related slick-slider">
        <h3><?= _e("Other blogs", "ninja") ?></h3>
        <?php
        $related = $blog_obj->get_all(['publish'], 10, 'rand', 'ASC', [$single->ID]);
        if (!empty($related)) {
            foreach ($related as $single_related) {
        ?>
                <div class="related-card">
                    <a class="blog-item" href="<?= $single_related->link ?>">
                        <div class="img">
                            <img src="<?= $single_related->thumbnail ?>" alt="B2B" />
                            <span class="dots"></span>
                        </div>
                        <div class="date">
                            <p><?= date('F d, Y', strtotime($single_related->created_date)) ?></p>
                        </div>
                        <div class="content">
                            <?= $single_related->excerpt ?>
                        </div>
                    </a>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>

</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php get_footer();
