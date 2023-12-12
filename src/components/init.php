<?php

function meta($title) {
	return "
		<meta charset='UTF-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<script defer src=\"https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js\"></script>
		<script src='https://unpkg.com/htmx.org@1.9.9'></script>
		<script src='https://unpkg.com/hyperscript.org@0.9.12'></script>
		<link rel='stylesheet' href='/public/css/output.css'>
		<link rel='stylesheet' href='/public/css/animate.css'>
		<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
		<link rel=\"preconnect' href=\"https://fonts.gstatic.com\" crossorigin>
		<link href=\"https://fonts.googleapis.com/css2?family=Chelsea+Market&display=swap\" rel=\"stylesheet\">
		<title>$title</title>
	";
}

function banner(bool $hasMenu) {
	$icons = "";
	if ($hasMenu) {
		$icons = "
			<img _='on click toggle .hidden on .nav-group then toggle .fade-in on #nav' src=\"/public/svg/bars.svg\" alt=\"Logo\" class=\"nav-group h-6 w-auto\">
			<img _='on click toggle .hidden on .nav-group then toggle .fade-in on #nav' src=\"/public/svg/x.svg\" alt=\"Logo\" class=\"nav-group hidden h-6 w-auto\">
		";
	};
	return "
		<div class=\"bg-white flex items-center justify-between p-6\">
			<img src=\"/public/svg/logo.svg\" alt=\"Logo\" class=\"h-8 w-auto mr-4\">
			$icons
		</div>
	";
}


?>