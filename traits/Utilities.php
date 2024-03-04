<?php

namespace traits;

trait Utilities {
    function getViewFile( $file ) {
        include(__DIR__."/../views/".$file.".php");
    }
    
    // assets mappába vagy azon kívül?
    // bootstrap linkek ( css, js, icons ) is hasonlóképp
    function getCssFile() {
        return "./assets/css/style.css";
    }

    // assets mappába vagy azon kívül?
    function getJsFile() {
        return "./assets/js/scripts.js";
    }

    function pageTitle() {
        $pages = ["Termékek" => "termekekView", "Kosár" => "kosarView", "Rendelés" => "rendelesView" ];
        $getpage = $_GET["page"];
        foreach($pages as $key => $page) {
            if($page === $getpage) {
                return "PC Shop - $key";
            }
            elseif($getpage === "termekView") {
                $termekek = mysqli_query($this->connectProcess(), "select * from products where id = '" . $_GET["id"] . "'");
                $getId = $_GET["id"];
                while ($termek = mysqli_fetch_array($termekek)) {
                    if($getId === $termek["id"]) {
                        return "PC Shop - ".$termek["name"]."";
                    }
                }
            }
            elseif($getpage === "profileView") {
                if (isset($_SESSION["user"])) {
                    $user_update = mysqli_query($this->connectProcess(), "select * from users where id = '" . $_SESSION["user"]["id"] . "' ");
                    $getId = $_GET["id"];
                    while($user = mysqli_fetch_assoc($user_update)) {
                        if($getId === $user["id"]) {
                            return "PC Shop -".$user["first_name"]." ".$user["last_name"]."";
                        }
                    }
                }
                else {
                    return "PC Shop - Profil";
                }
            }
            elseif(!isset($getpage)) {
                return "PC Shop - Minden ami számítástechnika";
            }
        }
    }

    function landingUrl() {
        // profileView?
        // ideiglenesen amíg a lentebbi rész nem működik
        return "location: ?page=termekekView";

        // mindig a loginProcess-nél köt ki
        $pages = ["termekekView", "kosarView", "rendelesView" ];
        $getpage = $_GET["page"];
        foreach($pages as $page) {
            if($page === $getpage) {
                return "location: ?page=$page";
            }
            elseif($getpage === "termekView") {
                $termekek = mysqli_query($this->connectProcess(), "select * from products where id = '" . $_GET["id"] . "'");
                $getId = $_GET["id"];
                while ($termek = mysqli_fetch_array($termekek)) {
                    if($getId === $termek["id"]) {
                        return "location: ?page=termekView&id=$getId";
                    }
                }
            }
            elseif($getpage === "profileView") {
                if (isset($_SESSION["user"])) {
                    $user_update = mysqli_query($this->connectProcess(), "select * from users where id = '" . $_SESSION["user"]["id"] . "' ");
                    $getId = $_GET["id"];
                    while($user = mysqli_fetch_assoc($user_update)) {
                        if($getId === $user["id"]) {
                            return "location: ?page=profileView&id=$getId";
                        }
                    }
                }
                else {
                    return "location: ?page=$getpage";
                }
            }
            elseif(!isset($getpage)) {
                return "location: index.php";
            }
        }
    }
}