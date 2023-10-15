<?php
$opportunity_link = ! empty( $args['scrollable_container'] ) ? $args['scrollable_container'] : false;

?>

<script>
// Script reference:
// https://alvarotrigo.com/blog/scroll-horizontally-with-mouse-wheel-vanilla-java/
// https://codepen.io/toddwebdev/pen/yExKoj
const scrollContainer = document.querySelector('<?= $opportunity_link; ?>');

scrollContainer.addEventListener('wheel', (evt) => {
	evt.preventDefault();
	scrollContainer.scrollLeft += evt.deltaY;
});

const slider = document.querySelector('<?= $opportunity_link; ?>');
let isDown = false;
let startX;
let scrollLeft;

slider.addEventListener('mousedown', (e) => {
	isDown = true;
	slider.classList.add('active');
	startX = e.pageX - slider.offsetLeft;
	scrollLeft = slider.scrollLeft;
});
slider.addEventListener('mouseleave', () => {
	isDown = false;
	slider.classList.remove('active');
});
slider.addEventListener('mouseup', () => {
	isDown = false;
	slider.classList.remove('active');
});
slider.addEventListener('mousemove', (e) => {
	if (!isDown) return;
	e.preventDefault();
	const x = e.pageX - slider.offsetLeft;
	const walk = (x - startX) * 3; //scroll-fast
	slider.scrollLeft = scrollLeft - walk;
	// console.log( walk );
});
</script>
