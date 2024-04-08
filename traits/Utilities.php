<?php

namespace traits;

trait Utilities {
    function getViewFile( $file ) {
        include(__DIR__."/../views/".$file.".php");
    }

    function pageTitle() {
        $pages = ["Termékek" => "productsView", "Kosár" => "cartView", "Rendelés" => "orderView" ];
        $getpage = $_GET["page"];
        foreach($pages as $key => $page) {
            if($page === $getpage) {
                return "PC Shop - $key";
            }
            elseif($getpage === "productView") {
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
        if(isset($_GET["backUrl"])) {
            if(isset($_GET["id"])) {
                return $_GET["backUrl"]."&id=".$_GET["id"];
            }
            return $_GET["backUrl"];
        }
        else {
            return "page error";
        }
    }

    // cart, product, products, order-process fájlokban van
    function offer($weekoffer, $price)
    {
        $val = 0.9;
        $_SESSION["week_offer"] = $val;
        $t = getdate();
        // $t["wday"] -> csere vmi számra teszthez
        $_SESSION["today"] = $t["wday"];

        if ($_SESSION["today"] === 0 || $_SESSION["today"] === 6) {
            if($weekoffer === "1") {
                return [$price, $price * $_SESSION["week_offer"]];
            }
            else {
                return [$price];
            }
        } else {
            return [$price];
        }
    }

    function navOffer() {
        $t = getdate();
        // $t["wday"] -> csere vmi számra teszthez
        $_SESSION["today"] = $t["wday"];

        if ($_SESSION["today"] === 0 || $_SESSION["today"] === 6) {
            return 'Ne hagyd ki a kiváló lehetőségeket, hiszen már elindultak hétvégi akcióink!';
        } else {
            return 'Hétvégi különleges ajánlatainkban a kiemelt termékeink akár 10%-kal kezdvezőbb áron elérhetők!';
        }
    }

    function subTotal($week, $ertek)
    {
        $val = 0.9;
        $_SESSION["week_offer"] = $val;
        $t = getdate();
        // $t["wday"] -> csere vmi számra teszthez
        $_SESSION["today"] = $t["wday"];

        if ($_SESSION["today"] === 0 || $_SESSION["today"] === 6) {
            return $week === "1" ? ($ertek *= $_SESSION["week_offer"]) : $ertek;
        } else {
            return $ertek = 1;
        }
    }
}