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

	// handling post request to register user
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$firstName = get_form('firstName');
		$lastName = get_form('lastName');
		$email = get_form('email');
		$language = get_form('language');
		$password = get_form('password');
		if ($firstName == "" || $lastName == "" || $email == "" || $password == "") {
			header("Location: /root?formErr=no blank fields");
			exit();
		}
		$user = new User();
		$user->firstName = $firstName;
		$user->lastName = $lastName;
		$user->email = $email;
		$user->language = $language;
		$user->password = password_hash($password, PASSWORD_DEFAULT);
		$err = db_insert($mysqli, $user);
		if ($err != null) {
			server_error($err);
			exit();
		}
		header("Location: /root?formSuccess=".$user->firstName." ".$user->lastName." created successfully");
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
                <a href='/root' class='bg-black text-white rounded-full px-6 py-2 text-xs'>Home</a>
            </li>
			<li>
                <a href='/root/users' class='bg-white border border-black text-black rounded-full px-6 py-2 text-xs'>Users</a>
            </li>
            <li>
                <a href='/logout' class='bg-white border border-black rounded-full px-6 py-2 text-xs'>Logout</a>
            </li>
        </ul>
    </nav>

	<!-- register users form -->
    <form id='register-user-form' method='POST' class='fade-in flex flex-col gap-2 p-6'>
        <h2 class='text-lg mb-2'>Register Users</h2>
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
				<button id='english-button' type='button' class='border bg-black border-gray text-white rounded-full px-6 py-2 text-xs'>English</button>
				<button id='spanish-button' type='button' class='bg-white border border-black rounded-full px-6 py-2 text-xs'>Spanish</button>
			</div>
		</div>
		<label for='firstName' class='text-xs'>first name</label>
        <input name='firstName' type='text' class='border rounded-full text-xs px-4 py-2 focus:outline-none focus:border-b-4' />
		<label for='lastName' class='text-xs'>last name</label>
        <input name='lastName' type='text' class='border rounded-full text-xs px-4 py-2 focus:outline-none focus:border-b-4' />
        <label for='email' class='text-xs'>email</label>
        <input name='email' type='text' class='border rounded-full text-xs px-4 py-2 focus:outline-none focus:border-b-4' />
        <label for='password' class='text-xs'>password</label>
        <input name='password' type='password' class='border rounded-full text-xs px-4 py-2 focus:outline-none focus:border-b-4' />
		<input id='language-input' name='language' type='text' value='english' class='hidden' />
        <input type='submit' value='Register' class='bg-black text-white text-xs p-2 rounded-full mt-4' />
    </form>

	<!-- tide image -->
	<div class="fade-in flex flex-grow items-center justify-center m-8">
        <img src="./public/img/tide.jpg" alt="Swoop" class="w-full h-full object-cover">
    </div>

	<script src='/public/js/index.js'></script>

	


</body>
</html>




