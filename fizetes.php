<?php

session_start();

/*
if (isset($_SESSION["user"]) == false) {
  exit('Csak bejelenkezett felhasználók részére!');
}
*/

error_reporting(E_ALL);
ini_set("display_errors", 1);

$connection = mysqli_connect("localhost", "root", "12345", "gyakorlas");

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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

    ?>

    <main class="container-lg py-5">
        <form method="post">

        <?php

        // innen tovább fizetési mód megadása radio button személyes adatok megadása egy tovább gombbal
        // űrlap oldal először csak legyen meg készítsek el minden módosítást előbb majd utána jöhet az űrlapos fizetős php kidolgozása
        // űrlap file_put_contents() -el küldene fájlt

        $total = 0;

        if (isset($_SESSION["kosar"]) && count($_SESSION["kosar"]) > 0) {
            // name, qtty, subtotal, total
            foreach ($_SESSION["kosar"] as $id => $dbszam) {

                $termek = mysqli_fetch_assoc(mysqli_query($connection, "select * from products where id = $id"));

                $subtotal = ($dbszam * $termek["price"]);
                $total += $subtotal;

                echo '<section class="row p-2"><article class="col border p-3">';
                echo '<article><h4>Termék neve: ' . $termek["name"] . '</h4></article>';
                echo '<article><h4>Darabszám: ' . $dbszam . '</h4></article>';
                echo '<article><h4>Termék ára: ' . $subtotal . '</h4></article>';
                echo '</article></section>';
            }
            echo '<section class="row p-2"><article class="col"><h4>Végösszeg: ' . $total . '</h4></article></section>';
        }

        echo '<section class="row p-2"><article class="col"><h1>űrlap helye</h1></article></section>';

        echo '<hr>';

        echo '<section class="row justify-content-between"><article class="col-auto"><a href="termekek.php" class="btn btn-dark">Vissza a vásárláshoz</a></article><article class="col-auto"><a href="kosar.php" class="btn btn-dark">Vissza a kosárhoz</a></article></section>';

        ?>

        </form>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.bundle.min.js" integrity="sha512-9GacT4119eY3AcosfWtHMsT5JyZudrexyEVzTBWV3viP/YfB9e2pEy3N7WXL3SV6ASXpTU0vzzSxsbfsuUH4sQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="scripts.js"></script>
</body>

</html>