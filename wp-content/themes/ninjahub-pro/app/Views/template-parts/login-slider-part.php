<?php
/**
 * Part name: login slider
 */
use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

?>

<section class="login-animation col-12 col-md-6">
	<div id="loginCarousel" class="carousel slide w-100 h-100">
		<div class="carousel-navigation">
			<button class="carousel-control-prev" type="button" data-bs-target="#loginCarousel" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>

			<div class="carousel-indicators">
				<button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="0" class="active" aria-current="true"
					aria-label="Slide 1"></button>
				<button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
				<button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
			</div>

			<button class="carousel-control-next" type="button" data-bs-target="#loginCarousel" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>

		<div class="carousel-inner">
			<div class="carousel-item active">
				<dotlottie-player
					src="<?= Nh_Hooks::PATHS['public']['vendors']; ?>/css/lottiefiles/money-investment.json"
					background="transparent" speed="1" style="width: 300px; height: 300px" direction="1" mode="normal" loop
					autoplay>
				</dotlottie-player>
				<div class="carousel-caption d-none d-md-block">
					<h5>First slide label</h5>
					<p>Some representative placeholder content for the first slide.</p>
				</div>
			</div>
			<div class="carousel-item">
				<dotlottie-player
					src="<?= Nh_Hooks::PATHS['public']['vendors']; ?>/css/lottiefiles/money-investment.json"
					background="transparent" speed="1" style="width: 300px; height: 300px" direction="1" mode="normal" loop
					autoplay>
				</dotlottie-player>
				<div class="carousel-caption d-none d-md-block">
					<h5>Second slide label</h5>
					<p>Some representative placeholder content for the second slide.</p>
				</div>
			</div>
			<div class="carousel-item">
				<dotlottie-player
					src="<?= Nh_Hooks::PATHS['public']['vendors']; ?>/css/lottiefiles/money-investment.json"
					background="transparent" speed="1" style="width: 300px; height: 300px" direction="1" mode="normal" loop
					autoplay>
				</dotlottie-player>
				<div class="carousel-caption d-none d-md-block">
					<h5>Third slide label</h5>
					<p>Some representative placeholder content for the third slide.</p>
				</div>
			</div>
		</div>
	</div>
</section>
