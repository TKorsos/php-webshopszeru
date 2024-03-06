<?php

session_start();

spl_autoload_register( function( $file ) {
  include("$file.php");
});

use controllers\UserController;

$page = new UserController;

if(!$_GET["page"]) {
  $page->homeView();
}
else {
  $getpage = $_GET["page"];
  $page->$getpage();
}

// ami kell még session, helyezd ide, error, success, sendig_data
unset($_SESSION["alert"], $_SESSION["post_user"]);