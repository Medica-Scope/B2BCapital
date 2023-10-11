<?php

/**
 * @Filename: single.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */

global $post;

get_header();
echo $post->post_title;
echo $post->post_content;
get_footer();