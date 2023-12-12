<?php 

// handling POST from login_form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = get_form('email');
    $password = get_form('password');
    if ($email == $_ENV["ROOT_USERNAME"] && $password == $_ENV["ROOT_PASSWORD"]) {
        $rootToken = $_ENV["ROOT_SESSION_TOKEN"];
        setcookie("session-token", $rootToken, time() + 3600, "/", "", false, true);
        header("Location: /root");
        exit();
    }
    header("Location: /?formErr=Invalid credentials");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?= meta("CFA Suite - Login") ?>
</head>
<body hx-boost='true' class="flex flex-col min-h-screen">
    
    <?= banner(false) ?>

    <!-- login form -->
    <form method='POST' class='fade-in flex flex-col gap-2 p-6'>
        <h2 class='text-lg mb-2'>Login</h2>
        <p class='text-red text-xs mb-2'><?= query_param('formErr') ?></p>
        <label for='email' class='text-xs'>email</label>
        <input name='email' type='text' class='border rounded-full text-xs px-4 py-2 focus:outline-none focus:border-b-4' />
        <label for='password' class='text-xs'>password</label>
        <input name='password' type='password' class='border rounded-full text-xs px-4 py-2 focus:outline-none focus:border-b-4' />
        <input type='submit' class='bg-black text-white text-xs p-2 rounded-full mt-4' />
    </form>

    <!-- Image taking up remaining space -->
    <div class="fade-in flex flex-grow items-center justify-center">
        <img src="./public/img/swoop.jpg" alt="Swoop" class="w-full h-full object-cover">
    </div>

    <!-- <footer class='mt-4 bg-white flex justify-end items-center p-6 text-white'>
        <a href='' class='bg-black rounded-full px-6 py-2 text-xs'>Espanol</a>
    </footer> -->

    <script src='/public/js/index.js'></script>


</body>
</html>
