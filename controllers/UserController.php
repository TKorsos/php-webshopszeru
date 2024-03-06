<?php

namespace controllers;

// a szerepek ne keveredjenek
// itt csak a működés legyen míg a views oldalain belül a megjelenítés
// usercontroller átdolgozás/ csak view és process

class UserController
{
    use \traits\Utilities;

    // másik classbe tegyem kezdet
    function offer($weekoffer, $price)
    {
        $val = 0.9;
        $_SESSION["week_offer"] = $val;
        $t = getdate();
        // $t["wday"] -> csere vmi számra teszthez
        $_SESSION["today"] = $t["wday"];

        if ($_SESSION["today"] === 0 || $_SESSION["today"] === 6) {
            return $weekoffer === "1" ? '<p class="text-decoration-line-through text-danger">' . $price . ' Ft</p><div>' . $price * $_SESSION["week_offer"] . ' Ft</div>' : '<div>' . $price . ' Ft</div>';
        } else {
            return '<p>' . $price . ' Ft</p>';
        }
    }

    // vagy ezt már esetleg egy másik class-be kellene tenni?
    function subTotal($week, $ertek)
    {
        if ($_SESSION["today"] === 0 || $_SESSION["today"] === 6) {
            return $week === "1" ? ($ertek *= $_SESSION["week_offer"]) : $ertek;
        } else {
            return $ertek = 1;
        }
    }

    function navOffer() {
        $t = getdate();
        // $t["wday"] -> csere vmi számra teszthez
        $_SESSION["today"] = $t["wday"];

        if ($_SESSION["today"] === 0 || $_SESSION["today"] === 6) {
            return '<header class="position-fixed w-100 week-color">
                        <div class="container-fluid">
                            <div class="col py-2 d-flex justify-content-center align-items-center">
                                <span class="week-offer-animation text-danger">
                                    <strong>Ne hagyd ki a kiváló lehetőségeket, hiszen már elindultak hétvégi akcióink!</strong>
                                </span>
                            </div>
                        </div>
                    </header>';
        } else {
            return '<header class="position-fixed w-100 week-color">
                        <div class="container-fluid">
                            <div class="col py-2 d-flex justify-content-center align-items-center">
                                <span class="week-offer-animation text-danger">
                                    <strong>Hétvégi különleges ajánlatainkban a kiemelt termékeink akár 10%-kal kezdvezőbb áron elérhetők!</strong>
                                </span>
                            </div>
                        </div>
                    </header>';
        }
    }
    // másik classbe tegyem kezdet

    function connectProcess()
    {
        $connection = mysqli_connect("localhost", "root", "12345", "pcshop");
        mysqli_set_charset($connection, "utf8mb4");

        return $connection;
    }   

    function loginProcess()
    {   
        if (isset($_POST["login"])) {
            // login kezdete
            $log_errors = [];

            if (empty($_POST["email"])) {
                $log_errors[] = "<div>Az e-mail cím megadása kötelező!</div>";
            }

            if (empty($_POST["password"])) {
                $log_errors[] = "<div>A jelszó megadása kötelező!</div>";
            }

            if (count($log_errors) > 0) {
                $_SESSION["alert"] = '<div class="container-lg"><div class="row"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-danger" role="alert">';
                foreach ($log_errors as $log_error) {
                    $_SESSION["alert"] .= "$log_error";
                }
                $_SESSION["alert"] .= '</div></div></div></div>';
            } else {
                $sql = mysqli_query($this->connectProcess(), "select * from users where email = '" . $_POST['email'] . "'");
                $user = mysqli_fetch_array($sql);

                if (isset($user["email"]) === false) {
                    $log_errors[] = '<div>A megadott e-mail cím nem létezik!</div>';
                } else {
                    if ($_POST["password"] !== $user["password"]) {
                        $log_errors[] = '<div>Hibás jelszót adott meg!</div>';
                    }
                }

                if (count($log_errors) > 0) {
                    $_SESSION["alert"] = '<div class="container-lg"><div class="row"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-danger" role="alert">';
                    foreach ($log_errors as $log_error) {
                        $_SESSION["alert"] .= "$log_error";
                    }
                    $_SESSION["alert"] .= '</div></div></div></div>';
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
                $reg_errors[] = "<div>Az Admin név fentartott név, nem használható!</div>";
            }

            if (mb_strlen($first_name) < 2) {
                $reg_errors[] = "<div>A vezetéknévnek minimum 2 karakternek kell lennie!</div>";
            }
            else {
                $_SESSION["post_user"]["first_name"] = $first_name;
            }

            if (mb_strlen($last_name) < 3) {
                $reg_errors[] = "<div>A keresztnévnek minimum 3 karakternek kell lennie!</div>";
            }
            else {
                $_SESSION["post_user"]["last_name"] = $last_name;
            }

            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $reg_errors[] = "<div>Invalid e-mail címet adott meg!</div>";
            }
          
            if ($talalt_email > 0) {
                $reg_errors[] = "<div>Ezen az e-mail címen már regisztráltak, kérem adjon meg egy új e-mail címet!</div>";
            }
            else {
                $_SESSION["post_user"]["email"] = $email;
            }

            if (mb_strlen($password) < 8) {
                $reg_errors[] = "<div>A jelszónak minimum 8 karakternek kell lennie!</div>";
            }

            if ($password != $password_confirmation) {
                $reg_errors[] = "<div>A két jelszó nem azonos!</div>";
            }

            if (mb_strlen($phone) != 12) {
                $reg_errors[] = "<div>A telefonszámank 12 karakternek kell lennie és +36-tal kezdődik!</div>";
            }
            else {
                $_SESSION["post_user"]["phone"] = $phone;
            }

            if (mb_strlen($billing_name) < 6) {
                $reg_errors[] = "<div>A számlázási névnek minimum 6 karakternek kell lennie!</div>";
            }
            else {
                $_SESSION["post_user"]["billing_name"] = $billing_name;
            }

            if (mb_strlen($country) < 3) {
                $reg_errors[] = "<div>Az országnak minimum 3 karakternek kell lennie!</div>";
            }
            else {
                $_SESSION["post_user"]["country"] = $country;
            }

            if (mb_strlen($zip) != 4) {
                $reg_errors[] = "<div>Az irányítószámnak 4 karakternek kell lennie!</div>";
            }
            else {
                $_SESSION["post_user"]["zip"] = $zip;
            }

            if (mb_strlen($city) < 3) {
                $reg_errors[] = "<div>A városnak minimum 3 karakternek kell lennie!</div>";
            }
            else {
                $_SESSION["post_user"]["city"] = $city;
            }

            if (mb_strlen($street) < 3) {
                $reg_errors[] = "<div>Az utcanévnek minimum 3 karakternek kell lennie!</div>";
            }
            else {
                $_SESSION["post_user"]["street"] = $street;
            }

            if (mb_strlen($nr) < 1) {
                $reg_errors[] = "<div>A házszámnak minimum 1 karakternek kell lennie!</div>";
            }
            else {
                $_SESSION["post_user"]["nr"] = $nr;
            }

            if (count($reg_errors) > 0) {
                $_SESSION["alert"] = '<div class="container-lg"><div class="row"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-danger" role="alert">';
                foreach ($reg_errors as $reg_error) {
                    $_SESSION["alert"] .= "$reg_error";
                }
                $_SESSION["alert"] .= '</div></div></div></div>';

            } else {
                mysqli_query($this->connectProcess(), "insert into users (`first_name`, `last_name`, `email`, `password`, `phone`, `billing_name`, `country`, `zip`, `city`, `street`, `nr`) values ('$first_name', '$last_name', '$email', '$password', '$phone', '$billing_name', '$country', '$zip', '$city', '$street', '$nr')");

                // bootstrap alert megjelenítés
                $_SESSION["alert"] = '<div class="container-lg"><div class="row"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-success" role="alert">
                    <strong>Sikeres volt a regisztráció!</strong>
                </div></div></div></div>';
            }

            // reg vége
            header("location: ".$this->landingUrl());
            exit;
        }
    }

    function updateProcess()
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
                $mod_errors[] = "<div>A jelszónak minimum 8 karakternek kell lennie!</div>";
            }

            if ($password != $password_confirmation) {
                $mod_errors[] = "<div>A két jelszó nem azonos!</div>";
            }

            if (mb_strlen($phone) != 12) {
                $mod_errors[] = "<div>A telefonszámank 12 karakternek kell lennie és +36-tal kezdődik!</div>";
            }

            if (mb_strlen($billing_name) < 6) {
                $mod_errors[] = "<div>A számlázási névnek minimum 6 karakternek kell lennie!</div>";
            }

            if (mb_strlen($country) < 3) {
                $mod_errors[] = "<div>Az országnak minimum 3 karakternek kell lennie!</div>";
            }

            if (mb_strlen($zip) != 4) {
                $mod_errors[] = "<div>Az irányítószámnak 4 karakternek kell lennie!</div>";
            }

            if (mb_strlen($city) < 3) {
                $mod_errors[] = "<div>A városnak minimum 3 karakternek kell lennie!</div>";
            }

            if (mb_strlen($street) < 3) {
                $mod_errors[] = "<div>Az utcanévnek minimum 3 karakternek kell lennie!</div>";
            }

            if (mb_strlen($nr) < 1) {
                $mod_errors[] = "<div>A házszámnak minimum 1 karakternek kell lennie!</div>";
            }

            if (count($mod_errors) > 0) {
                $_SESSION["alert"] = '<div class="container-lg"><div class="row"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-danger" role="alert">';
                foreach ($mod_errors as $mod_error) {
                    $_SESSION["alert"] .= "$mod_error";
                }
                $_SESSION["alert"] .= '</div></div></div></div>';
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

                $_SESSION["alert"] = '<div class="container-lg"><div class="row"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-success" role="alert">
                <strong>Sikeres volt az adatmódosítás!</strong>
                </div></div></div></div>';

            }
            // profilmódosítás vége
            header("location: ?page=profileView&id=".$_SESSION["user"]["id"]."");
            exit;
        }
    }

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
                $comment_errors[] = "<div>A névnek minimum 3 karakternek kell lennie!</div>";
            }

            if (filter_var($comment_email, FILTER_VALIDATE_EMAIL) == false) {
                $comment_errors[] = "<div>Invalid e-mail címet adott meg!</div>";
            }

            if (mb_strlen($comment_message) < 10) {
                $comment_errors[] = "<div>Az üzenetnek minimum 10 karakternek kell lennie!</div>";
            }

            // $_SESSION["alert"]
            if (count($comment_errors) > 0) {
                $_SESSION["alert"] = '<div class="container-lg"><div class="row"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-danger" role="alert">';
                foreach ($comment_errors as $comment_error) {
                    $_SESSION["alert"] .= "$comment_error";
                }
                $_SESSION["alert"] .= '</div></div></div></div>';
            } else {
                mysqli_query($this->connectProcess(), "insert into comment (`termek_id`, `comment_name`, `comment_email`, `comment_message`) values ('$termek_id', '$comment_name', '$comment_email', '$comment_message') ");
            }

            // comment vége

            header("location: ?page=termekView&id=$termek_id");
            exit;
        }
    }

    function rendelesProcess() {
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
                $order_errors[] = "<div>A vezetéknévnek minimum 2 karakternek kell lennie!</div>";
            }
    
            if (mb_strlen($last_name) < 3) {
                $order_errors[] = "<div>A keresztnévnek minimum 3 karakternek kell lennie!</div>";
            }
    
            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $order_errors[] = "<div>Invalid e-mail címet adott meg!</div>";
            }
    
            if (mb_strlen($phone) != 12) {
                $order_errors[] = "<div>A telefonszámank 12 karakternek kell lennie és +36-tal kezdődik!</div>";
            }
    
            if (mb_strlen($billing_name) < 6) {
                $order_errors[] = "<div>A számlázási névnek minimum 6 karakternek kell lennie!</div>";
            }
    
            if (mb_strlen($country) < 3) {
                $order_errors[] = "<div>Az országnak minimum 3 karakternek kell lennie!</div>";
            }
    
            if (mb_strlen($zip) != 4) {
                $order_errors[] = "<div>Az irányítószámnak 4 karakternek kell lennie!</div>";
            }
    
            if (mb_strlen($city) < 3) {
                $order_errors[] = "<div>A városnak minimum 3 karakternek kell lennie!</div>";
            }
    
            if (mb_strlen($street) < 3) {
                $order_errors[] = "<div>Az utcanévnek mimimum 3 karakternek kell lennie!</div>";
            }
    
            if (mb_strlen($nr) < 1) {
                $order_errors[] = "<div>A házszámnak minimum 1 karakternek kell lennie!</div>";
            }
    
            if (isset($atvetel) == false) {
                $order_errors[] = "<div>Nem adott meg átvételi formát!</div>";
            }
    
            if (isset($fizetes) == false) {
                $order_errors[] = "<div>Nem adott meg fizetési módot!</div>";
            }
    
            if (count($order_errors) > 0) {
                $_SESSION["alert"] = '<div class="container-lg"><div class="row"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-danger" role="alert">';
                foreach ($order_errors as $order_error) {
                    $_SESSION["alert"] .= "$order_error";
                }
                $_SESSION["alert"] .= '</div></div></div></div>';
            } else {
                mysqli_query($this->connectProcess(), "insert into orders (`user_id`, `payment_json`, `shipping_json`, `products_json`, `total`) values ('" . $user["id"] . "', '$paymentTest', '$shippingTest', '$productsTest', '$total') ");
    
                // sikeres üzenet
                $_SESSION["alert"] = '<div class="container-lg"><div class="row"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-success" role="alert"><strong>A rendelését felvettük!</strong></div></div></div></div>';
    
            }

            header("location: ?page=rendelesView");
            exit;
        }
    }

    // termek.php
    function termekAddToCartProcess() {
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
            }
        
            // header('location: ' . $_SERVER['REQUEST_URI']);
            header("location: ?page=termekView&id=$termek_id");
            exit;
        }
    }

    // termekek.php
    function productCartProcess() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            $termek_id = $_POST["id"];
            $termek_db = 1;
        
            $_SESSION["kosar"][$termek_id] = $termek_db;
        
            header("location: ?page=termekekView");
            exit;
        }
    }

    // kosar.php
    function cartProcess() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            $termek_id = $_POST["id"];
            $termek_db = is_numeric($_POST["qtty"]) && $_POST["qtty"] > 0 ? $_POST["qtty"] : 1;
        
            // felülírja a darabszámot
            $_SESSION["kosar"][$termek_id] = $termek_db;
        
            // termék törlése
            $product_id = $_POST["torol"];
            unset($_SESSION["kosar"][$product_id]);
        
            // header('location: ' . $_SERVER['REQUEST_URI']);
            header("location: ?page=kosarView");
            exit;
        }
    }

    // kosar.php
    function clearCartProcess() {
        if (isset($_POST["torolmind"])) {
            unset($_SESSION["kosar"]);

            header("location: ?page=kosarView");
            exit;
        }
    }

    // további processek

    function homeView()
    {
        $this->getViewFile("home");
    }

    function termekekView()
    {
        $this->getViewFile("termekek");
    }

    function termekView()
    {
        $this->getViewFile("termek");
    }

    function kosarView()
    {
        $this->getViewFile("kosar");
    }

    function rendelesView()
    {
        $this->getViewFile("rendeles");
    }

    function profileView()
    {
        $this->getViewFile("profile");
    }

    function logoutProcess()
    {
        unset($_SESSION["user"]);

        header("location: index.php");
    }
}
