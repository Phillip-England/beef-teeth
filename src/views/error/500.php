
<!DOCTYPE html>
<html lang="en">
<head>
	<?= meta("CFA Suite - 500 Internal Server Error") ?>
</head>
<body hx-boost='true'>
	<?= banner(true, get_request_path(), "/nav") ?>
	<main class='p-6 flex gap-2'>
		<?=  query_param('message') ?>
	</main>
</body>
</html>