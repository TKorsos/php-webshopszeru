<?php

session_start();

// $termek["week_offer"] -> $weekoffer
// $termek["price"] -> $price
// offert majd lehet át kellene nevezni
function offer($weekoffer, $price)
{
    if ($_SESSION["today"] === 0 || $_SESSION["today"] === 6) {
        return $weekoffer === "1" ? '<div>' . $price * $_SESSION["week_offer"] . '</div>' : '<div>' . $price . '</div>';
    } else {
        return '<div>' . $price . '</div>';
    }
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $termek_id = $_POST["id"];
    $termek_db = is_numeric($_POST["qtty"]) && $_POST["qtty"] > 0 ? $_POST["qtty"] : 1;

    // felülírja a darabszámot
    $_SESSION["kosar"][$termek_id] = $termek_db;

    // termék törlése
    $product_id = $_POST["torol"];
    unset($_SESSION["kosar"][$product_id]);

    header('location: ' . $_SERVER['REQUEST_URI']);
}

// mind törlése
if (isset($_POST["torolmind"])) {
    unset($_SESSION["kosar"]);
    header("location: kosar.php");
}

// fizetes.php
// name="fizetes" post
if (isset($_POST["fizet"])) {
    header('location: fizetes.php');
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

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $connection = mysqli_connect("localhost", "root", "12345", "pcshop");

    $errors = mysqli_error($connection);
    mysqli_set_charset($connection, "utf8mb4");

    if ($errors) {
        echo $errors;
    }

    ?>

    <!-- main helye -->
    <main class="container-lg pb-5 custom-top">
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col-auto p-2 mx-auto">
                <h1>A kosár taralma</h1>
            </article>
        </section>
        <section class="row row-cols-1 gy-3 py-3">
            <form method="post">
                <?php
                // oszolopokban lévő tartalom igazítása szöveg igazítása stb.****************
                // 
                echo '<article class="col p-2"><table class="table table-responsive align-middle">';

                $total = 0;

                if (isset($_SESSION["kosar"]) && count($_SESSION["kosar"]) > 0) {

                    echo '<thead><tr><th>Leírás</th><th>Ár</th><th colspan="2">Darabszám</th><th>Összeg (Ft)</th></tr></thead><tbody>';

                    foreach ($_SESSION["kosar"] as $product_id => $qtty) {

                        // termek.php oldalról továbbküldi id-t majd itt ellenőrzi hogy az adatbázisban lévő id egyezik-e a küldött id-val
                        $termek = mysqli_fetch_assoc(mysqli_query($connection, "select * from products where id = $product_id"));

                        // akcióhoz tartozó szorzó
                        $ertek = 1;

                        $subtotal = ($qtty * subTotal($termek["week_offer"], $ertek) * $termek["price"]);
                        $total += $subtotal;

                        // régi meghagyva ötletelésként
                        /*
                        echo '<form method="post"><td><article class="row gap-2 justify-content-center justify-content-md-start">
                        <article class="col-md-auto"><input type="number" class="form-control input-qtty" max="99" value="' . $qtty . '" name="qtty"><input type="hidden" name="id" value="' . $product_id . '"></article><article class="col-md-auto"><button class="btn btn-dark w-100">Módosít</button></article><article class="col-md-auto"><button class="btn btn-danger w-100" name="torol" value="' . $product_id . '">Eltávolítás a kosárból</button></article>
                        </article></td></form>';
                        */

                        echo '<tr>';
                        echo '<td>' . $termek["name"] . '</td>';
                        echo '<td class="text-center text-md-start">' . (offer($termek["week_offer"], $termek["price"])) . '</td>';

                        echo '<form method="post">
                        <td><article class="row gap-3 justify-content-center justify-content-md-start"><article class="col-12 col-md-auto"><input type="number" class="form-control input-qtty" max="99" value="' . $qtty . '" name="qtty"><input type="hidden" name="id" value="' . $product_id . '"></article><article class="col-12 col-md-auto"><button class="btn btn-dark w-100">Módosít</button></article></article></td><td><button class="btn btn-danger" name="torol" value="' . $product_id . '">Eltávolítás a kosárból</button></td>
                        </form>';

                        echo '<td class="text-center text-md-start">' . $subtotal . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<h4>Nincs termék a kosárban</h4>';
                }

                echo '</tbody></table></article>';
                echo '<h3>Összesen: ' . $total . ' Ft</h3>';

                echo '<article class="col p-2">';

                if (isset($_SESSION["kosar"]) && count($_SESSION["kosar"]) > 0) {

                    echo '<input type="submit" class="btn btn-danger" name="torolmind" id="torolmind" value="Kosár törlése"></article>';
                }

                echo '<hr>';

                echo '<section class="row justify-content-center justify-content-md-between gap-2">
            <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                <a href="termekek.php" class="btn btn-dark w-100">Vissza a vásárláshoz</a>
            </article>
            <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                <button class="btn btn-dark w-100" name="fizet">Tovább a fizetéshez</button>
                </article>
            </section>';

                ?>
            </form>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
</body>

</html>