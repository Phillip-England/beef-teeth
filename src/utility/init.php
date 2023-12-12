
<?php

//===================================================
// validation
//===================================================

function blacklist_string($someString, $hasUppercase = true, $hasLowercase = true, $hasNumbers = true, $hasBasicSymbols = true) {
    $uppercaseChars = $hasUppercase ? 'A-Z' : '';
    $lowercaseChars = $hasLowercase ? 'a-z' : '';
    $numberChars = $hasNumbers ? '0-9' : '';
    $basicSymbolChars = $hasBasicSymbols ? '_-.,;:!?()[]{}\'"`~@$%^&*+=/\\|<>' : '';
    $pattern = '/^[' . $uppercaseChars . $lowercaseChars . $numberChars . $basicSymbolChars . ']+$/';
    return preg_match($pattern, $someString) === 1;
}

//===================================================
// http
//===================================================

function get_request_path() {
    $uri = $_SERVER["REQUEST_URI"];
    $parsedUrl = parse_url($uri);
    return $parsedUrl['path'];
}

function serve_public_file($filename) {
    $publicPath = __DIR__ . '/public/' . $filename;
    if (file_exists($publicPath)) {
        header('Content-Type: ' . mime_content_type($publicPath));
        readfile($publicPath);
    } else {
        include("./src/pages/404.php");
    }
}

function server_error(Exception $err) {
    $message = $err->getMessage();
    header("Location: /500?message=$message");
}

function get_query_param_or_set($key, $defaultValue) {
    if (!isset($_GET[$key])) {
        $_GET[$key] = $defaultValue;
    }
    return htmlspecialchars($_GET[$key], ENT_QUOTES, 'UTF-8');
}

function count_path_segments($path) {
    $segments = explode(DIRECTORY_SEPARATOR, $path);
    return count($segments);
}

//===================================================
// security
//===================================================

function query_param($input) {
    if (isset($_GET[$input])) {
        return htmlspecialchars($_GET[$input], ENT_QUOTES, "UTF-8");
    }
    return "";
}

function get_form($value) {
    if (isset($_POST[$value])) {
        return htmlspecialchars($_POST[$value], ENT_QUOTES, "UTF-8");
    }
    return '';
}

function is_root_user() {
    $sessionToken = "";
    if (isset($_COOKIE['session-token'])) {
        $sessionToken = $_COOKIE['session-token'];
    }
    if ($sessionToken == $_ENV['ROOT_SESSION_TOKEN']) {
        return true;
    }
    return false;
}

?>