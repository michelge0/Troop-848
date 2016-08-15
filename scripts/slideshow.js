var counter = -1;
var images = ["img1.jpg", "img2.jpg"];

function nextSlide() {
	if (counter < images.length - 1) {
		counter++;
	} else {
		counter = 0;
	}

	// smooth transition into next image
	// EXAMPLE:
	// document.body.background = [next image];
}

$(document).ready(function() {
	window.setInterval("bgSlide()", 3000);
});