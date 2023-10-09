<?php

    /**
     * @Filename: single.php
     * @Description:
     * @User: Mustafa Shaaban
     * @Date: 9/21/2023
     */

    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
    use NH\Nh;

    global $post;

    get_header();

?>
    <main class="container-fluid ">
        <h1><?= __('General Information', 'ninja') ?></h1>
       <h1><?= $post->post_title ?></h1>
       <p><?= $post->post_content ?></p>
    </main><!-- #main -->

<?php
    get_footer();
