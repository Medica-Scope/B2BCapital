<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package NinjaHub
 */


	use NH\APP\CLASSES\Nh_Post;
	use NH\APP\HELPERS\Nh_Hooks;
	use NH\APP\MODELS\FRONT\Nh_Public;
	use NH\Nh;

get_header();
?>

<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

<main id="" class="">
	<section class="error-404 not-found d-flex flex-column justify-content-center align-items-center">
		<dotlottie-player src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/lottiefiles/animation_404.lottie"
			background="transparent" speed="1" style="width: 950px; height:500px; margin:0 auto;" direction="1" mode="normal"
			loop autoplay>
		</dotlottie-player>
		<a href="<?php echo home_url(); ?>" class="btn-link text-secondary"><i class="bbc-home2"></i> Back to
			Homepage</a>
	</section><!-- .error-404 -->
</main><!-- #main -->

<?php
get_footer();
