<?php
/**
 * @Filename: single-service.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 4/26/2023
 */

use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home' );
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-service-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/service' );

?>


<!-- Page Content -->
<section class="page-content">
	<!-- Service Content -->
	<div class="service-content-wrapper">
		<div class="service-banner-wrapper">
			<div class="service-banner">
				<a href="#" onclick="history.back()" class="back-link">
					<i class="icon bbc-previous-circle"></i> Bak To Services
				</a>
				<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/services/service-banner.webp"
					alt="Service Banner" class="banner">
			</div>
		</div>
		<div class="service-content">
			<div class="service-details">
				<h1 class="service-title">
					<span class="title-icon">
						<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/services/agreement.webp"
							alt="Agreement" class="img-fluid">
					</span>
					<span class="splitter"></span>
					<span class="title">Merge Opportunities</span>
				</h1>
				<h3 class="service-subtitle">Description of the service</h3>
				<p class="service-description">
					B2BCP is a platform where project owners can put them projects in a well-defined structure and have
					a
					professional team to handle and justify the project content and introduce the project as Opportunity
					in a
					perfect.
				</p>
				<p class="service-description">
					Clarified and meaningful content to the Investor so the project owner (Owner) can have the suitable
					investment
					package to the project and the investor will get the suitable Opportunity to invest in.
				</p>
				<h3 class="service-subtitle">Important features of the service:</h3>
				<ul class="service-features">
					<li class="service-feature">
						<span class="service-features-number">1</span>
						<span class="service-feature-text">We research, analyze data, survey the market and prepare
							feasibility
							studies and investment reports.</span>
					</li>
					<li class="service-feature">
						<span class="service-features-number">2</span>
						<span class="service-feature-text">We navigate companies through their investment expansion
							plan, as well as
							matching them with potential investors.</span>
					</li>
					<li class="service-feature">
						<span class="service-features-number">3</span>
						<span class="service-feature-text">We study the inputs, form the most efficient investment tool,
							and
							guarantee you the most.</span>
					</li>
					<li class="service-feature">
						<span class="service-features-number">4</span>
						<span class="service-feature-text">We do research, data analysis, market investigation,
							feasibility study
							preparation, and investment reports.</span>
					</li>
					<li class="service-feature">
						<span class="service-features-number">5</span>
						<span class="service-feature-text">We navigate companies through their investment expansion
							plan, as well as
							matching them with potential investors.</span>
					</li>
				</ul>
			</div>
			<form class="service-subscription-form" onsubmit="onSubmit(event)">
				<h3 class="form-title">Subscribe Now!</h3>
				<div class="form-field">
					<input type="text" id="name" name="name" class="form-control">
					<label for="name" class="form-control-label">Name</label>
					<span class="error-message">Please write valid full name</span>
				</div>
				<div class="form-field">
					<input type="email" id="email" name="email" class="form-control">
					<label for="email" class="form-control-label">Email</label>
					<span class="error-message">Please write valid email address</span>
				</div>
				<div class="form-field">
					<input type="text" id="mobile" name="mobile" class="form-control">
					<label for="mobile" class="form-control-label">Mobile</label>
					<span class="error-message">Please write valid mobile number</span>
				</div>
				<div class="time-slots">
					<h4 class="time-slots-title">Select Your Slot</h4>
					<div class="time-slots-group">
						<div class="time-slot">
							<input type="radio" name="timeslot" value="slot1" id="slot1" class="form-check-input">
							<label class="time-slot-details" for="slot1">
								<span class="date">Today</span>
								<span class="time from">03:00 PM</span>
								<span class="time to">04:00 PM</span>
							</label>
						</div>
						<div class="time-slot">
							<input type="radio" name="timeslot" value="slot2" id="slot2" class="form-check-input">
							<label class="time-slot-details" for="slot2">
								<span class="date">Today</span>
								<span class="time from">06:00 PM</span>
								<span class="time to">07:00 PM</span>
							</label>
						</div>
						<div class="time-slot">
							<input type="radio" name="timeslot" value="slot3" id="slot3" class="form-check-input">
							<label class="time-slot-details" for="slot3">
								<span class="date">Mon 07-11</span>
								<span class="time from">06:00 PM</span>
								<span class="time to">07:00 PM</span>
							</label>
						</div>
						<div class="time-slot">
							<input type="radio" name="timeslot" value="slot4" id="slot4" class="form-check-input">
							<label class="time-slot-details" for="slot4">
								<span class="date">Today</span>
								<span class="time from">03:00 PM</span>
								<span class="time to">04:00 PM</span>
							</label>
						</div>
					</div>
					<div class="time-slots-group">
						<div class="time-slot">
							<input type="radio" name="timeslot" value="slot5" id="slot5" class="form-check-input">
							<label class="time-slot-details" for="slot5">
								<span class="date">Today</span>
								<span class="time from">03:00 PM</span>
								<span class="time to">04:00 PM</span>
							</label>
						</div>
						<div class="time-slot">
							<input type="radio" name="timeslot" value="slot6" id="slot6" class="form-check-input">
							<label class="time-slot-details" for="slot6">
								<span class="date">Today</span>
								<span class="time from">06:00 PM</span>
								<span class="time to">07:00 PM</span>
							</label>
						</div>
						<div class="time-slot">
							<input type="radio" name="timeslot" value="slot7" id="slot7" class="form-check-input">
							<label class="time-slot-details" for="slot7">
								<span class="date">Mon 07-11</span>
								<span class="time from">06:00 PM</span>
								<span class="time to">07:00 PM</span>
							</label>
						</div>
						<div class="time-slot">
							<input type="radio" name="timeslot" value="slot8" id="slot8" class="form-check-input">
							<label class="time-slot-details" for="slot8">
								<span class="date">Today</span>
								<span class="time from">03:00 PM</span>
								<span class="time to">04:00 PM</span>
							</label>
						</div>
					</div>
				</div>
				<button type="submit" class="form-action bbc-btn large apply" disabled>Checkout Now</button>
			</form>
		</div>
	</div>
</section>
</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php get_footer();
