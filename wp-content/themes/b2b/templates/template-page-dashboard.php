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
     * @package b2b
     * @since 1.0
     *
     */


    use B2B\APP\MODELS\FRONT\MODULES\B2b_Notification;
    use B2B\APP\MODELS\FRONT\MODULES\B2b_Opportunity;

    global $user_ID;

    get_header();
?>

    <main id="" class="site-home">
        <h1>Dashboard</h1>

        <h3>Overview</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque illo laudantium magnam magni vel! Alias aliquam amet assumenda commodi consequatur corporis delectus dignissimos, eum facilis laboriosam maxime nostrum odit perferendis perspiciatis quasi quod ratione repellendus reprehenderit repudiandae sequi sit ullam vero. Blanditiis dolorum esse hic id ipsam officiis, sit veniam.</p>


        <h3>Latest Opportunities</h3>
        <?php

//            $notifications_obj = new B2b_Notification();
//            $notifications_obj->send(12,$user_ID,'bidding', ['project_id' => 157]);


            $opportunities_obj = new B2b_Opportunity();
            $opportunities = $opportunities_obj->get_all();

            foreach ($opportunities as $opportunity) {
                echo "<p>".$opportunity->title."</p>";
            }
        ?>
    </main><!-- #main -->

<?php get_footer();

