<?php
// التوجيه إلى splash إذا كان الطلب للموقع الرئيسي
if (empty($_GET['request_site']) && empty($_SERVER['QUERY_STRING'])) {
  header("Location: /Face/resources/pages/splash.php");
  exit();
}

require_once __DIR__ . "/database/database_connection.php";
require_once __DIR__ . "/resources/lib/php_functions.php";

$request_site = $_GET['request_site'] ?? 'home';

session_start();

if ($request_site === "logout") {
  session_destroy();
  header("Location:login");
  exit();
}

$logged_in = user();

if (!$logged_in && $request_site !== "login") {
  header("Location: login");
  exit();
}

$path = __DIR__ . "/resources/pages/";
$page_path = $logged_in ? $path . "$logged_in->role/$request_site.php" : $path . "$request_site.php";

if (file_exists($page_path)) {
  require $page_path;
} else {
  require $path . "404.php";
}

if (isset($_SESSION['errors'])) {
  unset($_SESSION['errors']);
}
