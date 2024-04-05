<?php

namespace controllers;

class WeekOffer {

    use \traits\Utilities;
   
    // cart, product, products fájlokban van
    // külön fájlba kidolgozni és úgy beilleszteni?
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
        if ($_SESSION["today"] === 0 || $_SESSION["today"] === 6) {
            return $week === "1" ? ($ertek *= $_SESSION["week_offer"]) : $ertek;
        } else {
            return $ertek = 1;
        }
    }
}

class UserController extends WeekOffer
{
    use \traits\Utilities;

    function connectProcess()
    {
        $connection = mysqli_connect("localhost", "root", "12345", "pcshop");
        mysqli_set_charset($connection, "utf8mb4");

        return $connection;
    }   

    // nav.php
    function loginProcess()
    {   
        if (isset($_POST["login"])) {
            // login kezdete
            $log_errors = [];

            if (empty($_POST["email"])) {
                $log_errors[] = "Az e-mail cím megadása kötelező!";
            }

            if (empty($_POST["password"])) {
                $log_errors[] = "A jelszó megadása kötelező!";
            }

            if (count($log_errors) > 0) {
                foreach ($log_errors as $log_error) {
                    $_SESSION["errors"][] = "$log_error";
                }
            } else {
                $sql = mysqli_query($this->connectProcess(), "select * from users where email = '" . $_POST['email'] . "'");
                $user = mysqli_fetch_array($sql);

                if (isset($user["email"]) === false) {
                    $log_errors[] = 'A megadott e-mail cím nem létezik!';
                } else {
                    if ($_POST["password"] !== $user["password"]) {
                        $log_errors[] = 'Hibás jelszót adott meg!';
                    }
                }

                if (count($log_errors) > 0) {
                    foreach ($log_errors as $log_error) {
                        $_SESSION["errors"][] = "$log_error";
                    }
                } else {
                    // belépés
                    $_SESSION["user"] = $user;
                }
            }

            // login vége
            header("location: ".$this->landingUrl());
            exit;
        }
    }

    // nav.php
    function registerProcess()
    {
        if (isset($_POST["reg"])) {
            // regisztráció kezdete
            $user_emails = mysqli_query($this->connectProcess(), "select * from users");
            $talalt_email = 0;

            while ($user_email = mysqli_fetch_assoc($user_emails)) {
                if ($_POST["email"] == $user_email["email"]) {
                    $talalt_email += 1;
                }
            }

            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $password_confirmation = $_POST["password_confirmation"];
            $phone = $_POST["phone"];
            $billing_name = $_POST["billing_name"];
            $country = $_POST["country"];
            $zip = $_POST["zip"];
            $city = $_POST["city"];
            $street = $_POST["street"];
            $nr = $_POST["nr"];

            // feltételek, hibaüzenetek, feltöltés
            $reg_errors = [];

            $admin = "admin";

            // session adatok ahonnan hiba esetén bentmaradnak azok az adatok amik nem hibásak
            $_SESSION["post_user"] = [];

            if ($first_name === $admin || $last_name === $admin || $first_name === ucfirst($admin) || $last_name === ucfirst($admin)) {
                $reg_errors[] = "Az Admin név fentartott név, nem használható!";
            }

            if (mb_strlen($first_name) < 2) {
                $reg_errors[] = "A vezetéknévnek minimum 2 karakternek kell lennie!";
            }
            else {
                $_SESSION["post_user"]["first_name"] = $first_name;
            }

            if (mb_strlen($last_name) < 3) {
                $reg_errors[] = "A keresztnévnek minimum 3 karakternek kell lennie!";
            }
            else {
                $_SESSION["post_user"]["last_name"] = $last_name;
            }

            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $reg_errors[] = "Invalid e-mail címet adott meg!";
            }
          
            if ($talalt_email > 0) {
                $reg_errors[] = "Ezen az e-mail címen már regisztráltak, kérem adjon meg egy új e-mail címet!";
            }
            else {
                $_SESSION["post_user"]["email"] = $email;
            }

            if (mb_strlen($password) < 8) {
                $reg_errors[] = "A jelszónak minimum 8 karakternek kell lennie!";
            }

            if ($password != $password_confirmation) {
                $reg_errors[] = "A két jelszó nem azonos!";
            }

            if (mb_strlen($phone) != 12) {
                $reg_errors[] = "A telefonszámank 12 karakternek kell lennie és +36-tal kezdődik!";
            }
            else {
                $_SESSION["post_user"]["phone"] = $phone;
            }

            if (mb_strlen($billing_name) < 6) {
                $reg_errors[] = "A számlázási névnek minimum 6 karakternek kell lennie!";
            }
            else {
                $_SESSION["post_user"]["billing_name"] = $billing_name;
            }

            if (mb_strlen($country) < 3) {
                $reg_errors[] = "Az országnak minimum 3 karakternek kell lennie!";
            }
            else {
                $_SESSION["post_user"]["country"] = $country;
            }

            if (mb_strlen($zip) != 4) {
                $reg_errors[] = "Az irányítószámnak 4 karakternek kell lennie!";
            }
            else {
                $_SESSION["post_user"]["zip"] = $zip;
            }

            if (mb_strlen($city) < 3) {
                $reg_errors[] = "A városnak minimum 3 karakternek kell lennie!";
            }
            else {
                $_SESSION["post_user"]["city"] = $city;
            }

            if (mb_strlen($street) < 3) {
                $reg_errors[] = "Az utcanévnek minimum 3 karakternek kell lennie!";
            }
            else {
                $_SESSION["post_user"]["street"] = $street;
            }

            if (mb_strlen($nr) < 1) {
                $reg_errors[] = "A házszámnak minimum 1 karakternek kell lennie!";
            }
            else {
                $_SESSION["post_user"]["nr"] = $nr;
            }

            if (count($reg_errors) > 0) {
                foreach ($reg_errors as $reg_error) {
                    $_SESSION["errors"][] = "$reg_error";
                }
            } else {
                mysqli_query($this->connectProcess(), "insert into users (`first_name`, `last_name`, `email`, `password`, `phone`, `billing_name`, `country`, `zip`, `city`, `street`, `nr`) values ('$first_name', '$last_name', '$email', '$password', '$phone', '$billing_name', '$country', '$zip', '$city', '$street', '$nr')");

                // bootstrap alert megjelenítés
                $_SESSION["success"] = 'Sikeres volt a regisztráció!';
            }

            // reg vége
            header("location: ".$this->landingUrl());
            exit;
        }
    }

    // profile_edit.php
    function profileUpdateProcess()
    {
        if (isset($_POST["modosit"])) {
            // update kezdet

            // név és email cím ne változzon meg
            // $first_name = $_POST["first_name"];
            // $last_name = $_POST["last_name"];
            // $email = $_POST["email"];
            $password = $_POST["password"];
            $password_confirmation = $_POST["password_confirmation"];
            $phone = $_POST["phone"];
            $billing_name = $_POST["billing_name"];
            $country = $_POST["country"];
            $zip = $_POST["zip"];
            $city = $_POST["city"];
            $street = $_POST["street"];
            $nr = $_POST["nr"];

            $mod_errors = [];

            if (mb_strlen($password) < 8) {
                $mod_errors[] = "A jelszónak minimum 8 karakternek kell lennie!";
            }

            if ($password != $password_confirmation) {
                $mod_errors[] = "A két jelszó nem azonos!";
            }

            if (mb_strlen($phone) != 12) {
                $mod_errors[] = "A telefonszámank 12 karakternek kell lennie és +36-tal kezdődik!";
            }

            if (mb_strlen($billing_name) < 6) {
                $mod_errors[] = "A számlázási névnek minimum 6 karakternek kell lennie!";
            }

            if (mb_strlen($country) < 3) {
                $mod_errors[] = "Az országnak minimum 3 karakternek kell lennie!";
            }

            if (mb_strlen($zip) != 4) {
                $mod_errors[] = "Az irányítószámnak 4 karakternek kell lennie!";
            }

            if (mb_strlen($city) < 3) {
                $mod_errors[] = "A városnak minimum 3 karakternek kell lennie!";
            }

            if (mb_strlen($street) < 3) {
                $mod_errors[] = "Az utcanévnek minimum 3 karakternek kell lennie!";
            }

            if (mb_strlen($nr) < 1) {
                $mod_errors[] = "A házszámnak minimum 1 karakternek kell lennie!";
            }

            if (count($mod_errors) > 0) {
                foreach ($mod_errors as $mod_error) {
                    $_SESSION["errors"][] = "$mod_error";
                }
            } else {

                mysqli_query($this->connectProcess(), "update `users` set 
                `password` = '" . $password . "',
                `phone` = '" . $phone . "',
                `billing_name` = '" . $billing_name . "',
                `country` = '" . $country . "',
                `zip` = '" . $zip . "',
                `city` = '" . $city . "',
                `street` = '" . $street . "',
                `nr` = '" . $nr . "'
                where id = '" . $_SESSION["user"]["id"] . "' ");

                $_SESSION["success"] = 'Sikeres volt az adatmódosítás!';

            }
            // profilmódosítás vége
            // profileUpdateView?
            header("location: ?page=profileUpdateView&id=".$_SESSION["user"]["id"]."");
            exit;
        }
    }

    // product.php
    function commentProcess()
    {
        if (isset($_POST["send_comment"])) {
            // comment kezdet

            // termek_id, comment_name, comment_email, comment_message
            $termek_id = $_GET["id"];
            $comment_name = $_POST["comment_name"];
            $comment_email = $_POST["comment_email"];
            $comment_message = $_POST["comment_message"];

            $comment_errors = [];

            if (mb_strlen($comment_name) < 3) {
                $comment_errors[] = "A névnek minimum 3 karakternek kell lennie!";
            }

            if (filter_var($comment_email, FILTER_VALIDATE_EMAIL) == false) {
                $comment_errors[] = "Invalid e-mail címet adott meg!";
            }

            if (mb_strlen($comment_message) < 10) {
                $comment_errors[] = "Az üzenetnek minimum 10 karakternek kell lennie!";
            }

            if (count($comment_errors) > 0) {
                foreach ($comment_errors as $comment_error) {
                    $_SESSION["errors"][] = "$comment_error";
                }
            } else {
                mysqli_query($this->connectProcess(), "insert into comment (`termek_id`, `comment_name`, `comment_email`, `comment_message`) values ('$termek_id', '$comment_name', '$comment_email', '$comment_message') ");

                $_SESSION["success"] = "Az üzenetedet sikeresen elküldtük!";
            }

            // comment vége

            header("location: ?page=productView&id=$termek_id");
            exit;
        }
    }

    // order.php
    function orderProcess() {
        if (isset($_POST["rendeles"])) {

            // user_id
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    
                $userToJSON = mysqli_query($this->connectProcess(), "select * from users where email='" . $_POST["email"] . "' ");
    
                $user = mysqli_fetch_assoc($userToJSON);
    
                // utf8 encode
                // ez a rész akkor kell ha nem csak az id-t akarnánk kiíratni
                $user = array_map('htmlentities', $user);
                $userJSON = html_entity_decode(json_encode($user));
    
                $userTest = $userJSON;
            }
    
            // payment_json
            if (isset($_POST["fizetes"])) {
    
                $fizetes = $_POST["fizetes"];
    
                $paymentToJSON = mysqli_query($this->connectProcess(), "select * from payment where type='" . $fizetes . "'");
    
                $payment = mysqli_fetch_assoc($paymentToJSON);
    
                // utf8 encode
                $payment = array_map('htmlentities', $payment);
                $paymentJSON = html_entity_decode(json_encode($payment));
    
                $paymentTest = $paymentJSON;
            }
    
            // shipping_json
            if (isset($_POST["atvetel"])) {
    
                $atvetel = $_POST["atvetel"];
    
                $shippingToJSON = mysqli_query($this->connectProcess(), "select * from shipping where type='" . $atvetel . "'");
    
                $shipping = mysqli_fetch_assoc($shippingToJSON);
    
                // utf8 encode
                $shipping = array_map('htmlentities', $shipping);
                $shippingJSON = html_entity_decode(json_encode($shipping));
    
                $shippingTest = $shippingJSON;
            }
    
            // vásárolni kívánt termékek
            $total = 0;
            // akcióhoz tartozó szorzó
            $ertek = 1;
            // products_json
            $productsTest = "";
    
            if (isset($_SESSION["kosar"]) && count($_SESSION["kosar"]) > 0) {
                // name, qtty, subtotal, total
                foreach ($_SESSION["kosar"] as $id => $dbszam) {
    
                    $termekek = mysqli_query($this->connectProcess(), "select * from products where id = $id");
                    $termek = mysqli_fetch_assoc($termekek);
    
                    $subtotal = ($dbszam * $this->subTotal($termek["week_offer"], $ertek) * $termek["price"]);
                    $total += $subtotal;
    
                    // products_json
                    $productsToJSON = mysqli_query($this->connectProcess(), "select * from products where id=$id ");
    
                    $products = mysqli_fetch_assoc($productsToJSON);
    
                    // utf8 encode
                    $products = array_map('htmlentities', $products);
                    $productsJSON = html_entity_decode(json_encode($products));
    
                    $productsTest .= $productsJSON;
                }
            }
    
            // first_name, last_name, email, phone (új ~ csak magyar számokra lesz jó), billing_name (új), country (új), zip, city, street, nr
    
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $billing_name = $_POST["billing_name"];
            $country = $_POST["country"];
            $zip = $_POST["zip"];
            $city = $_POST["city"];
            $street = $_POST["street"];
            $nr = $_POST["nr"];
    
            $order_errors = [];
    
            // hibafeltételek
            if (mb_strlen($first_name) < 2) {
                $order_errors[] = "A vezetéknévnek minimum 2 karakternek kell lennie!";
            }
    
            if (mb_strlen($last_name) < 3) {
                $order_errors[] = "A keresztnévnek minimum 3 karakternek kell lennie!";
            }
    
            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $order_errors[] = "Invalid e-mail címet adott meg!";
            }
    
            if (mb_strlen($phone) != 12) {
                $order_errors[] = "A telefonszámank 12 karakternek kell lennie és +36-tal kezdődik!";
            }
    
            if (mb_strlen($billing_name) < 6) {
                $order_errors[] = "A számlázási névnek minimum 6 karakternek kell lennie!";
            }
    
            if (mb_strlen($country) < 3) {
                $order_errors[] = "Az országnak minimum 3 karakternek kell lennie!";
            }
    
            if (mb_strlen($zip) != 4) {
                $order_errors[] = "Az irányítószámnak 4 karakternek kell lennie!";
            }
    
            if (mb_strlen($city) < 3) {
                $order_errors[] = "A városnak minimum 3 karakternek kell lennie!";
            }
    
            if (mb_strlen($street) < 3) {
                $order_errors[] = "Az utcanévnek mimimum 3 karakternek kell lennie!";
            }
    
            if (mb_strlen($nr) < 1) {
                $order_errors[] = "A házszámnak minimum 1 karakternek kell lennie!";
            }
    
            if (isset($atvetel) == false) {
                $order_errors[] = "Nem adott meg átvételi formát!";
            }
    
            if (isset($fizetes) == false) {
                $order_errors[] = "Nem adott meg fizetési módot!";
            }
    
            if (count($order_errors) > 0) {
                foreach ($order_errors as $order_error) {
                    $_SESSION["errors"][] = "$order_error";
                }
            } else {
                mysqli_query($this->connectProcess(), "insert into orders (`user_id`, `payment_json`, `shipping_json`, `products_json`, `total`) values ('" . $user["id"] . "', '$paymentTest', '$shippingTest', '$productsTest', '$total') ");
    
                // sikeres üzenet
                $_SESSION["success"] = 'A rendelését felvettük!';
    
            }

            header("location: ?page=orderView");
            exit;
        }
    }

    // product.php
    function productAddToCartProcess() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
            if (isset($_POST["data"])) {
                // termek_id és termek_db létrehozása id alapján lesz azonosítva majd a kosárban, így ha újra be lesz helyezve a kosárba ugyanaz az id már megtalálja és az ott lévő értéket módosítja vagy ad hozzá
                $termek_id = $_POST["data"];
                $termek_db = is_numeric($_POST["darabszam"]) && $_POST["darabszam"] > 0 ? $_POST["darabszam"] : 1;
        
                if (!isset($_SESSION["kosar"])) {
                    $_SESSION["kosar"] = [];
                }
                // ahányszor nyomjuk meg a "kosárba tesz" gombot annyiszor adja hozzá a darabszámot
                $_SESSION["kosar"][$termek_id] += $termek_db;

                // kiíratás
                $productToCart = mysqli_query($this->connectProcess(), "select * from products where id = '".$termek_id."' ");
                $productName = mysqli_fetch_assoc($productToCart);
                $_SESSION["success"] = $productName["name"]." bekerült a kosárba!";
            }
        
            header("location: ?page=productView&id=$termek_id");
            exit;
        }
    }

    // products.php
    function productCartProcess() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            $termek_id = $_POST["id"];
            $termek_db = 1;

            if (!isset($_SESSION["kosar"])) {
                $_SESSION["kosar"] = [];
            }
        
            $_SESSION["kosar"][$termek_id] = $termek_db;

            // kiíratás
            $productToCart =  mysqli_query($this->connectProcess(), "select * from products where id = '".$termek_id."'");
            $productName = mysqli_fetch_assoc($productToCart);
            $_SESSION["success"] = $productName["name"]." bekerült a kosárba!";
        
            header("location: ".$this->landingUrl());
            exit;
        }
    }

    // cart.php
    function cartProcess() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            $termek_id = $_POST["id"];
            $termek_db = is_numeric($_POST["qtty"]) && $_POST["qtty"] > 0 ? $_POST["qtty"] : 1;
        
            // felülírja a darabszámot
            $_SESSION["kosar"][$termek_id] = $termek_db;
        
            // termék törlése
            $product_id = $_POST["torol"];
            unset($_SESSION["kosar"][$product_id]);

            // kiíratás
            $productToCart = mysqli_query($this->connectProcess(), "select * from products where id = '".$termek_id."' ");
            $productName = mysqli_fetch_assoc($productToCart);
            // feltétel
            if(isset($_POST["torol"])) {
                $_SESSION["success"] = $productName["name"]." sikeresen el lett távolítva a kosárból!";
            }
            else {
                $_SESSION["success"] = "A kosármódosítás sikeres!";
            }
        
            header("location: ?page=cartView");
            exit;
        }
    }

    // cart.php
    function clearCartProcess() {
        if (isset($_POST["torolmind"])) {
            unset($_SESSION["kosar"]);

            $_SESSION["clear"] = "A kosarad kiürült!";

            header("location: ?page=cartView");
            exit;
        }
    }

    // contacts.php
    function contactsProcess() {
        if(isset($_POST["send_email"])) {
            $contact_name = $_POST["contact_name"];
            $contact_email = $_POST["contact_email"];
            $contact_subject = $_POST["contact_subject"];
            $contact_message = $_POST["contact_message"];

            $contact_errors = [];

            if(mb_strlen($contact_name) < 3) {
                $contact_errors[] = "A névnek minimum 3 karakterből kell állnia!";
            }

            if(filter_var($contact_email, FILTER_VALIDATE_EMAIL) == false) {
                $contact_errors[] = "Invalid e-mail címet adott meg!";
            }

            if(mb_strlen($contact_subject) < 5) {
                $contact_errors[] = "A tárgynak minimum 5 karakterből kell állnia!";
            }

            if(mb_strlen($contact_message) < 10) {
                $contact_errors[] = "Az üzenetnek minimum 10 karakterből kell állnia!";
            }

            if(count($contact_errors) > 0) {
                foreach($contact_errors as $contact_error) {
                    $_SESSION["errors"][] = $contact_error;
                }
            }
            else {
                mysqli_query($this->connectProcess(), "insert into emails (`contact_name`, `contact_email`, `contact_subject`, `contact_message`) values ('".$contact_name."', '".$contact_email."', '".$contact_subject."', '".$contact_message."') ");

                $_SESSION["success"] = "Az üzenetedet sikeresen elküldtük!";
            }

        }

        // üzenet vége

        header("location: ?page=contactsView");
        exit;
    }

    // további processek

    function homeView()
    {
        $this->getViewFile("home");
    }

    function productsView()
    {
        $this->getViewFile("products");
    }

    function productView()
    {
        $this->getViewFile("product");
    }

    function cartView()
    {
        $this->getViewFile("cart");
    }

    function contactsView() {
        $this->getViewFile("contacts");
    }

    function orderView()
    {
        $this->getViewFile("order");
    }

    function favListView() {
        $this->getViewFile("fav_list");
    }

    function favAddToListProcess() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST["add-fav-data"])) {
                $add_fav_user_id = $_POST["user-id"];
                $add_fav_product_id = $_POST["add-fav-data"];

                // adatbázsiba illesztés
                mysqli_query($this->connectProcess(), "insert into favlist (`userid`, `productid`) values ('$add_fav_user_id', '$add_fav_product_id') ");

                // üzenet
                $_SESSION["success"] = "Sikeresen bekerült a kedvencek listádba!";
            }

            header("location: ?page=productView&id=$add_fav_product_id");
            exit;
        }
    }

    function favRemoveFromListProcess() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST["remove-fav-data"])) {
                $remove_fav_user_id = $_POST["user-id"];
                $remove_fav_product_id = $_POST["remove-fav-data"];

                $remove_from_fav_list = mysqli_query($this->connectProcess(), "select * from favlist where `userid` = '$remove_fav_user_id' ");

                while($remove = mysqli_fetch_assoc($remove_from_fav_list)) {
                    if($remove["productid"] === $remove_fav_product_id) {
                        $remove_fav_id = $remove["id"];
                    }
                }

                // törlés az adatbázisból
                if(mb_strlen($remove_fav_id) > 0) {
                    mysqli_query($this->connectProcess(), "delete from favlist where `id` = '$remove_fav_id' ");

                    // üzenet
                    $_SESSION["success"] = "Sikeresen törölted a kedvencek listádból!";
                }
            }

        header("location: ?page=productView&id=$remove_fav_product_id");
        exit;
        }
    }

    function profileView()
    {
        $this->getViewFile("profile");
    }

    function profileUpdateView() {
        $this->getViewFile("profile_edit");
    }

    function profileDeleteProcess() {
        if (isset($_POST["account-delete"])) {

            $getid = $_POST["user-del-id"];

            // favlistből is törölni kell a hozzáfűződő sorokat!
            $favlist_delete_account = mysqli_query($this->connectProcess(), "select * from favlist where `userid` = '$getid' ");

            while($favs = mysqli_fetch_assoc($favlist_delete_account)) {
                mysqli_query($this->connectProcess(), "delete from favlist where `id` = '".$favs["id"]."' ");
            }

            // felhasználói fiók törlése
            mysqli_query($this->connectProcess(), "delete from users where `id` = '".$_SESSION["user"]["id"]."' ");

            // üzenet a felhasználó felé
            $_SESSION["success"] = "A felhasználói fiók sikeresen törlésre került!";
        }
        
        unset($_SESSION["user"]);

        header("location: index.php");
        exit;
    }

    function emailsView() {
        $this->getViewFile("emails");
    }

    function orderlistView() {
        $this->getViewFile("orderlist");
    }

    function logoutProcess()
    {
        unset($_SESSION["user"]);

        header("location: index.php");
    }
}

