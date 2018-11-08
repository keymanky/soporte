function detectBrowser(argument) {
	// body...
	var browser = navigator.userAgent;
	var browserL = navigator.language;
	var browserV = navigator.vendor;
	var browserOs = navigator.platform;

	console.log(browser);
	console.log(browserL);
	console.log(browserV);
	console.log(browserOs);

	document.getElementById("trabajando").style.visibility = "hidden";

}

