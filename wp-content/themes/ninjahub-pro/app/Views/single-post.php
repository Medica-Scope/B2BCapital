<?php

    /**
     * @Filename: single.php
     * @Description:
     * @User: Ahmed Gamal
     * @Date: 9/21/2023
     */

    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\Nh;

    get_header();
    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home');
    global $user_ID, $post;
    $post_obj        = new Nh_Blog();
    $opportunity_obj = new Nh_Opportunity();
    $single_post     = $post_obj->convert($post);
    $opportunity     = "";
    
    if (($single_post->meta_data['opportunity'])) {
        $opportunity = $opportunity_obj->get_by_id($single_post->meta_data['opportunity']);
    }
    if ($user_ID) {
        $fav_chk     = $post_obj->is_post_in_user_favorites($single_post->ID, $user_ID);
        $ignore_chk  = $post_obj->is_post_in_user_ignored_articles($single_post->ID, $user_ID);

    }
?>
    <div class="single-blog">
        <a href="<?= home_url() ?>"><?= __("Back to home", "ninja") ?></a>
        <div class="cover-image">
            <img src="<?= wp_get_attachment_url($single_post->meta_data['cover']); ?>" alt="B2B"/>
        </div>
        <div class="date">
            <p><?= date('F d, Y', strtotime($single_post->created_date)); ?></p>
        </div>

        <?php if (!empty($user_ID)): ?>
            <div class="ninja-fav-con">
                <button class="ninja-add-to-fav btn <?= ($fav_chk) ? 'btn-dark' : '' ?>" id="addToFav" data-uID="<?= $user_ID ?>" data-id="<?= $single_post->ID ?>"
                        data-type="<?= $single_post->type ?>" type="button">FAV
                </button>
            </div>
        <?php endif; ?>


        <?php if (!empty($user_ID)): ?>
            <div class="ninja-ignore-con">
                <button class="ninja-add-to-ignore btn <?= ($ignore_chk) ? 'btn-outline-dark' : '' ?>" id="addToIgnore" data-uID="<?= $user_ID ?>" data-id="<?= $single_post->ID ?>"
                        data-type="<?= $single_post->type ?>" type="button">X
                </button>
            </div>
        <?php endif; ?>


        <div class="title">
            <?= $single_post->title ?>
        </div>


        <?php if (!empty($single_post->taxonomy['category'])): ?>
            <div class="category">
                <?= $single_post->taxonomy['category'][0]->name ?>
            </div>
        <?php endif; ?>


        <?php if (!empty($opportunity)): ?>
            <div class="opportunity">
                <a href="<?= $opportunity->link ?>"><?= $opportunity->name; ?></a>
            </div>
            <div class="opportunity-short-description">
                <p><?= $opportunity->meta_data['short_description']; ?></p>
            </div>
        <?php endif; ?>


        <div class="date">
            <img src="<?= get_avatar_url($single_post->author) ?>" alt="B2B"/>
            <p><?= __('on', 'ninja') ?> <?= date('F d, Y', strtotime($single_post->created_date)) ?></p>
        </div>
        <div class="short-description">
            <?= $single_post->excerpt ?>
        </div>
        <div class="content">
            <?= $single_post->content ?>
        </div>
        <div class="related slick-slider">
            <h3><?= __("Other blogs", "ninja") ?></h3>
            <?php
                $related = $post_obj->get_all([ 'publish' ], 10, 'rand', 'ASC', [ $single_post->ID ]);
                if (!empty($related)) {
                    foreach ($related['posts'] as $single_related) {
                        ?>
                        <div class="related-card">
                            <a class="blog-item" href="<?= $single_related->link ?>">
                                <div class="img">
                                    <img src="<?= $single_related->thumbnail ?>" alt="B2B"/>
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
