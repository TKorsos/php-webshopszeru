<?php

session_start();

spl_autoload_register( function( $file ) {
  include("$file.php");
});

use controllers\UserController;

$page = new UserController;

if(!isset($_GET["page"])) {
  $page->homeView();
}
else {
  $getpage = $_GET["page"];
  $page->$getpage();
}

// sendig_data
// $_SESSION["post_user"] - regisztrációnál hiba esetén bent maradjanak az adatok
unset($_SESSION["post_user"], $_SESSION["success"], $_SESSION["errors"], $_SESSION["clear"]);