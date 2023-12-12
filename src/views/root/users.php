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

	// loading in users
	$userRepository = new UserRepository();
	[$users, $err] = db_load_all($mysqli, $userRepository);
	if ($err != null) {
		server_error($err);
		exit();
	}
	$numberOfUsers = count($users);

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

<!-- user details section -->
<section class='fade-in p-6 flex flex-col'>

	<div>
		<h2 class='text-lg'>User Details</h2>
		<p class='text-xs mb-4'>user count: <?= $numberOfUsers ?></p>
	</div>
    
    <?php foreach ($users as $user): ?>
        <div class="flex flex-col rounded text-sm">
			<a href='/root/user?userId=<?= $user->id ?>' class='underline' ><?= $user->firstName ?> <?= $user->lastName ?></a>
		</div>
    <?php endforeach; ?>

</section>

	<!-- javascript bundle -->
	<script src='/public/js/index.js'></script>

	


</body>
</html>




