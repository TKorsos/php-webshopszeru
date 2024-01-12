<?php

session_start();

// $termek["week_offer"] -> $week
// $ertek -> $ertek
function subTotal($week, $ertek)
{
    if ($_SESSION["today"] === 0 || $_SESSION["today"] === 6) {
        return $week === "1" ? ($ertek *= $_SESSION["week_offer"]) : $ertek;
    } else {
        return $ertek = 1;
    }
}

/*
if (isset($_SESSION["user"]) == false) {
  exit('Csak bejelenkezett felhasználók részére!');
}
*/

error_reporting(E_ALL);
ini_set("display_errors", 1);

$connection = mysqli_connect("localhost", "root", "12345", "pcshop");

$errors = mysqli_error($connection);
mysqli_set_charset($connection, "utf8mb4");

if ($errors) {
    echo $errors;
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>PHP gyakorlás</title>
    <link rel="stylesheet" href="style.css">
</head>

<!--
  fenti tíltás beállítása
-->

<body>
    <!-- nav helye -->
    <?php

    include("nav.php");

    if (isset($_POST["tovabb"])) {

        // user_id *************************************
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    
            $userToJSON = mysqli_query($connection, "select * from users where email='" . $_POST["email"] . "' ");
    
            $user = mysqli_fetch_assoc($userToJSON);
    
            // utf8 encode
            // ez a rész akkor kell ha nem csak az id-t akarnánk kiíratni
            $user = array_map('htmlentities', $user);
            $userJSON = html_entity_decode(json_encode($user));
    
            $userTest = $userJSON;
        }
    
        // payment_json *************************************
        if (isset($_POST["fizetes"])) {
    
            $fizetes = $_POST["fizetes"]; // Undefined index: fizetes
    
            $paymentToJSON = mysqli_query($connection, "select * from payment where type='" . $fizetes . "'");
    
            $payment = mysqli_fetch_assoc($paymentToJSON);
    
            // utf8 encode
            $payment = array_map('htmlentities', $payment);
            $paymentJSON = html_entity_decode(json_encode($payment));
    
            $paymentTest = $paymentJSON;
        }
    
        // shipping_json *************************************
        if (isset($_POST["atvetel"])) {
    
            $atvetel = $_POST["atvetel"]; // Undefined index: atvetel
    
            $shippingToJSON = mysqli_query($connection, "select * from shipping where type='" . $atvetel . "'");
    
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
        // products_json *************************************
        $productsTest = "";
    
        if (isset($_SESSION["kosar"]) && count($_SESSION["kosar"]) > 0) {
            // name, qtty, subtotal, total
            foreach ($_SESSION["kosar"] as $id => $dbszam) {
    
                $termekek = mysqli_query($connection, "select * from products where id = $id");
                $termek = mysqli_fetch_assoc($termekek);
    
                $subtotal = ($dbszam * subTotal($termek["week_offer"], $ertek) * $termek["price"]);
                $total += $subtotal;
    
                // products_json *************************************
                $productsToJSON = mysqli_query($connection, "select * from products where id=$id ");
    
                $products = mysqli_fetch_assoc($productsToJSON);
    
                // utf8 encode
                $products = array_map('htmlentities', $products);
                $productsJSON = html_entity_decode(json_encode($products));
    
                $productsTest .= $productsJSON;
            }
        }
    
        // first_name, last_name, email, phone (új ~ csak magyar számokra lesz jó), billing_name (új), country (új), zip, city, street, nr
        // feltételek hogy a küldött értékek megegyeznek-e az adatbázisban lévőkkel
    
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
    
        // kiíratás
        /*
        echo "<div><p>userID: " . $user["id"] . "</p></div><div>$paymentTest</div><div>$shippingTest</div><div>$productsTest</div><div><p>$total</p></div>";
        */
    
        if (count($order_errors) > 0) {
            $_SESSION["alert"] = '<div class="container-lg"><div class="row pt-5"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-danger" role="alert">';
            foreach ($order_errors as $order_error) {
                $_SESSION["alert"] .= "$order_error";
            }
            $_SESSION["alert"] .= '</div></div></div></div>';
        } else {
            mysqli_query($connection, "insert into orders (`user_id`, `payment_json`, `shipping_json`, `products_json`, `total`) values ('" . $user["id"] . "', '$paymentTest', '$shippingTest', '$productsTest', '$total') ");
    
            echo mysqli_error($connection);

            // sikeres üzenet
            $_SESSION["alert"] = '<div class="container-lg"><div class="row pt-5"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-success" role="alert"><strong>A rendelését felvettük!</strong></div></div></div></div>';
    
            // header? refrech: 5 ?
        }
    }

    // alert megjelenítése
    if(isset($_SESSION["alert"])) {
        echo $_SESSION["alert"];
    }

    ?>

    <main class="container-lg pb-5 custom-top">
        <form method="post">

            <?php

            $total = 0;
            // akcióhoz tartozó szorzó
            $ertek = 1;

            if (isset($_SESSION["kosar"]) && count($_SESSION["kosar"]) > 0) {
                // name, qtty, subtotal, total
                foreach ($_SESSION["kosar"] as $id => $dbszam) {

                    $termek = mysqli_fetch_assoc(mysqli_query($connection, "select * from products where id = $id"));

                    $subtotal = ($dbszam * subTotal($termek["week_offer"], $ertek) * $termek["price"]);
                    $total += $subtotal;

                    echo '<section class="row p-1"><article class="col border p-3">';
                    echo '<article><h4>Termék neve: ' . $termek["name"] . '</h4></article>';
                    echo '<article><h4>Darabszám: ' . $dbszam . '</h4></article>';
                    echo '<article><h4>Termék ára: ' . $subtotal . ' Ft</h4></article>';
                    echo '</article></section>';
                }
                echo '<section class="row p-2"><article class="col"><h4>Végösszeg: ' . $total . ' Ft</h4></article></section>';
            }

            // űrlap kiíratáshoz
            $urlap = [
                [
                    [['Személyes adatok']],
                    [['Vezetéknév', 'Keresztnév']],
                    [['E-mail cím']],
                    [['Telefonszám']]
                ],
                [
                    [['Számlázási adatok']],
                    [['Számlázási név']],
                    [['Ország', 'Irányítószám']],
                    [['Város']],
                    [['Utcanév', 'Házszám']]
                ],
                [
                    [['Átvételi mód']],
                    [['Átvételi pontba kérem']],
                    [['Házhoz szállítás']],
                    [['Boltban veszem át']]
                ],
                [
                    [['Fizetési mód']],
                    [['Online fizetés']],
                    [['PayPal fizetés']],
                    [['Átvételkor fizetek']]
                ],
            ];

            $coutry = ['Magyarország', 'Argentína', 'Ausztrália', 'Ausztria', 'Egyiptom', 'Franciaország', 'Horvátország', 'Japán', 'Kanada', 'Nagy-Britannia', 'Németország', 'Olaszország', 'Románia', 'Szerbia', 'Szlovákia', 'Szlovénia', 'Ukrajna'];

            $for_ids = [
                "Vezetéknév" => "first_name",
                "Keresztnév" => "last_name",
                "E-mail cím" => "email",
                "Telefonszám" => "phone",
                "Számlázási név" => "billing_name",
                "Irányítószám" => "zip",
                "Város" => "city",
                "Utcanév" => "street",
                "Házszám" => "nr"
            ];

            // űrlap kiíratás ciklussal eleje
            echo '<section class="row p-2">';
            foreach ($urlap as $ocol) {
                echo '<article class="col-md-6 pt-5">';
                foreach ($ocol as $row_id => $row) {
                    echo ($row_id === 0 ? '<article class="row pb-4">' : '<article class="row">');
                    foreach ($row as $icol) {
                        foreach ($icol as $id => $content) {
                            echo '<article class="col-sm-' . (12 / count($icol)) . '">';
                            if ($content === 'Átvételi mód' || $content === 'Fizetési mód') {
                                echo '<h3 class="pb-4">' . $content . '</h3>';
                                foreach ($ocol as $key => $sor) {
                                    if ($key > 0) {
                                        echo '<div class="form-check">
                                            <input class="form-check-input" type="radio" name="' . ($content === 'Fizetési mód' ? "fizetes" : "atvetel") . '" id="' . ($content === 'Fizetési mód' ? "fizetes" . $key : "atvetel" . $key) . '" value="' . $sor[0][0] . '">
                                            <label class="form-check-label" for="' . ($content === 'Fizetési mód' ? "fizetes" . $key : "atvetel" . $key) . '">
                                            ' . $sor[0][0] . '
                                            </label>
                                        </div>';
                                    }
                                }
                            } elseif ($row_id === 0) {
                                echo '<h3>' . $content . '</h3>';
                            } elseif ($content === 'Ország') {
                                echo '<div class="form-floating mb-3">
                                    <select class="form-select" name="country" id="country" aria-label="' . $content . '">
                                        <option selected>Ország kiválasztása</option>';
                                foreach ($coutry as $list) {
                                    echo '<option value="' . $list . '">' . $list . '</option>';
                                }
                                echo '</select><label for="country">' . $content . '</label>
                                </div>';
                            } else {
                                foreach ($for_ids as $id => $forname) {
                                    if ($id === $content) {
                                        echo '<div class="form-floating mb-3">
                                            <input type="' . ($content === 'E-mail cím' ? 'email' : 'text') . '" class="form-control" name="' . $forname . '" id="' . $forname . '" placeholder="' . $content . '">
                                            <label for="' . $forname . '">' . $content . '</label>
                                </div>';
                                    }
                                }
                            }
                            echo '</article>';
                        }
                    }
                    echo '</article>';
                }
                echo '</article>';
            }
            echo '</section>';
            // űrlap kiíratás ciklussal vége

            echo '<section class="row p-2 justify-content-center">
                <article class="col-auto">
                    <!-- gomb name értékének beállítása -->
                    <button class="btn btn-primary rounded-5 py-2 px-5" id="tovabb" name="tovabb">Tovább</button>
                </article>
            </section>';

            echo '<hr>';

            echo '<section class="row justify-content-center justify-content-md-between gap-2">
                <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                    <a href="termekek.php" class="btn btn-dark w-100">Vissza a vásárláshoz</a>
                </article>
                <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                    <a href="kosar.php" class="btn btn-dark w-100">Vissza a kosárhoz</a>
                </article>
            </section>';

            ?>

        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
</body>

</html>