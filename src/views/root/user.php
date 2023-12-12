<?php 


	// connecting to db and running auth
	[$mysqli, $err] = connect_db();
	if ($err != null) {
		server_error($err);
	}

	// auth
	$isRoot = is_root_user();
	if (!$isRoot) {
		header("Location: /");
		exit();
	}

	// loading in the specific user
	$user = new User();
	$err = db_get_by_id($mysqli, $user, query_param('userId'));
	if ($err != null) {
		header('Location: /root/users');
		exit();
	}
	

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?= meta("CFA Suite - Root Home") ?>
</head>
<body hx-boost='true' class="flex flex-col min-h-screen">

    <?= banner(true) ?>

	<!-- nav menu -->
	<nav id='nav' class='nav-group p-6 hidden opacity-0'>
        <ul class='flex flex-wrap gap-4'>
            <li>
				<a href='/root' class='bg-white border border-black text-black rounded-full px-6 py-2 text-xs'>Home</a>
			</li>
			<li>
				<a href='/root/users' class='bg-black text-white rounded-full px-6 py-2 text-xs'>Users</a>
            </li>
            <li>
                <a href='/logout' class='bg-white border border-black rounded-full px-6 py-2 text-xs'>Logout</a>
            </li>
        </ul>
    </nav>

	<!-- update user section -->
    <form id='register-user-form' method='POST' class='fade-in flex flex-col gap-2 p-6'>
        <h2 class='text-lg mb-2'>Update User | <?php echo $user->firstName . " " . $user->lastName ?></h2>
		<?php 
			if (query_param("formSuccess") !== "") {
				?>
				<p class='text-blue text-xs'><?= query_param("formSuccess") ?></p>
				<?php
			}
		?>
        <p class='text-red text-xs mb-2'><?= query_param('formErr') ?></p>
		<div class='flex flex-col'>
			<label class='text-xs'>language selection</label>
			<div class='flex flex-row gap-2 py-4 text-xs'>
				<?php
					if ($user->language == "english") {
				?>
						<button id='english-button' type='button' class='border bg-black border-gray text-white rounded-full px-6 py-2 text-xs'>English</button>
						<button id='spanish-button' type='button' class='bg-white border border-black rounded-full px-6 py-2 text-xs'>Spanish</button>
				<?php
					} else {
				?>
						<button id='english-button' type='button' class='bg-white border border-black rounded-full px-6 py-2 text-xs'>English</button>
						<button id='spanish-button' type='button' class='border bg-black border-gray text-white rounded-full px-6 py-2 text-xs'>Spanish</button>
				<?php } ?>
				
			</div>
		</div>
		<label for='firstName' class='text-xs'>first name</label>
        <input name='firstName' value='<?= $user->firstName ?>' type='text' class='border rounded-full text-xs px-4 py-2 focus:outline-none focus:border-b-4' />
		<label for='lastName' class='text-xs'>last name</label>
        <input name='lastName' value="<?= $user->lastName ?>" type='text' class='border rounded-full text-xs px-4 py-2 focus:outline-none focus:border-b-4' />
        <label for='email' class='text-xs'>email</label>
        <input name='email' value='<?= $user->email ?>' type='text' class='border rounded-full text-xs px-4 py-2 focus:outline-none focus:border-b-4' />
		<input id='language-input' name='language' type='text' value='english' class='hidden' />
        <input type='submit' value='Register' class='bg-black text-white text-xs p-2 rounded-full mt-4' />
    </form>

	<!-- javascript bundle -->
	<script src='/public/js/index.js'></script>

	


</body>
</html>




