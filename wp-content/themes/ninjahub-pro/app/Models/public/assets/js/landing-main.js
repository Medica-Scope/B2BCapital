/* Imports */
// import '../../../../../node_modules/';
console.log('landing-main.js');
/* Functions Declaration */
/* Handle Show/Hide Next & Prev Buttons Based On Active Carousel Item */
const handleCarouselAnimation = () => {
	const landingPageCarousel = document.getElementById('landingPageCarousel');
	if (landingPageCarousel) {
		landingPageCarousel.addEventListener('slid.bs.carousel', () => {
			const carouselControls = document.querySelectorAll('.carousel-control');
			carouselControls.forEach(carouselControl => {
				carouselControl.classList.remove('d-none');
				carouselControl.classList.add('d-block');
			});
			const carouselInner = document.querySelector('.carousel-inner');
			const firstSlide = carouselInner.firstElementChild;
			const lastSlide = carouselInner.lastElementChild;
			const prevCarouselControl = document.querySelector('.carousel-control.prev');
			const nextCarouselControl = document.querySelector('.carousel-control.next');
			if (firstSlide.classList.contains('active')) {
				prevCarouselControl.classList.add('d-none');
			}
			if (lastSlide.classList.contains('active')) {
				nextCarouselControl.classList.add('d-none');
				prevCarouselControl.classList.remove('d-none');
				prevCarouselControl.classList.add('d-block');
			}
		});
	}
};

/* Validate Form */
const validateForm = formName => {
	const form = document.querySelector(`.${formName}`);
	// Check Contact Form Validity
	if (form) {
		const submitButton = form.children.item(5);
		const formFields = form.querySelectorAll('.form-control');
		const formFieldsStatus = {};
		formFields.forEach(formField => {
			const fieldName = formField.getAttribute('id');
			const inputFieldParent = formField.parentNode;
			formFieldsStatus[fieldName] = false;
			formField.addEventListener('blur', event => {
				const inputValue = event.target.value.trim();
				// Set Field Status
				formFieldsStatus[fieldName] = !!inputValue;
				// Handle Field Validation
				if (!inputValue) {
					inputFieldParent.classList.remove('filled');
					inputFieldParent.classList.add('has-error');
				} else {
					inputFieldParent.classList.remove('has-error');
					inputFieldParent.classList.add('filled');
				}
				// Handle Time Slot
				let timeSlot = true;
				// Handle Service Subscription Form Validation
				if (formName === 'service-subscription-form') {
					const selectedTimeSlot = document.querySelector('input[type="radio"]:checked');
					if (selectedTimeSlot) {
						timeSlot = selectedTimeSlot.getAttribute('id');
						console.log(timeSlot);
					} else {
						timeSlot = false;
					}
				}
				// Check If All Fields Are Valid And Enable Submit Button
				toggleSubmitButton(formFieldsStatus, timeSlot, submitButton);
			});
		});
		/**/
		const timeSlots = document.querySelectorAll('input[type="radio"]');
		timeSlots.forEach(timeSlot => {
			timeSlot.addEventListener('change', event => {
				// console.log(timeSlot);
				toggleSubmitButton(formFieldsStatus, timeSlot, submitButton);
			});
		});
	}
};

/* Check If All Fields Are Valid And Enable Submit Button */
const toggleSubmitButton = (formFieldsStatus, selectedTimeSlot, submitButton) => {
	// Check If All Fields Are Valid And Enable Submit Button
	if (Object.values(formFieldsStatus).every(value => value) && selectedTimeSlot) {
		console.log('All Is Valid');
		submitButton.removeAttribute('disabled');
	} else {
		console.log('Some Invalid Fields');
		submitButton.setAttribute('disabled', '');
	}
};

/* Handle Submit Form */
const onSubmit = event => {
	event.preventDefault();
	const form = event.target;
	const formData = new FormData(form);
	const body = Object.fromEntries(formData);
	// Call API Here
	console.log(body);
	// Reset Form After Submission
	form.reset();
	// Disable Form Submit Button
	const submitButton = form.children.item(5);
	submitButton.setAttribute('disabled', '');
};
// Enable Accessing Function Globally
window.onSubmit = onSubmit;

// Calling Functions
handleCarouselAnimation();
validateForm('contact-us-form');
// validateForm('service-subscription-form');
