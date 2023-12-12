

<?php

function get_server_router() {


    $router = array();

    // serving static assets at /public
    $router['/public'] = function() {
        $file = ltrim(get_request_path(), '/public/');
        serve_public_file($file);
    };

    // login page
    $router['/'] = function() {
        include('./src/views/guest/login.php');
    };

    // root home
    $router['/root'] = function() {
        include('./src/views/root/home.php');
    };

    // create users page
    $router['/root/users'] = function() {
        include('./src/views/root/users.php');
    };

    // view a specific users details
    $router['/root/user'] = function() {
        include('./src/views/root/user.php');
    };

    // logout page
    $router['/logout'] = function() {
        setcookie("session-token", "", time() - 3600, "/", "", false, true);
        header("Location: /");
        exit();
    };

    // 500 server error
    $router['/500'] = function() {
        include('./src/views/error/500.php');
    };

    // easy way to call dev functionaliy
    $router['/dev'] = function() {
        [$mysqli, $err] = connect_db();
        if ($err != null) {
            exit($err);
        }
        $err = delete_all_tables($mysqli);
        if ($err != null) {
            exit($err);
        }
        $err = create_user_table($mysqli);
        if ($err != null) {
            exit($err);
        }
    };


    return $router;
}

?>