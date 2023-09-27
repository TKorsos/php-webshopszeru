<?php

session_start();
$_SESSION["osszeg"] = 0;

/*
if (isset($_SESSION["user"]) == false) {
  exit('Csak bejelenkezett felhasználók részére!');
}
*/

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

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $connection = mysqli_connect("localhost", "root", "12345", "gyakorlas");

    $errors = mysqli_error($connection);
    mysqli_set_charset($connection, "utf8mb4");

    if ($errors) {
        echo $errors;
    }

    $termekek = mysqli_query($connection, "select * from customers limit 10");

    if(isset($_POST["torol"])) {
        unset($_SESSION["kosar"]);
        header("location: kosar.php");
    }

    ?>

    <!-- main helye -->
    <main class="container-lg py-5">
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col-auto p-2 mx-auto">
                <h1>A kosár taralma</h1>
            </article>
        </section>
        <section class="row row-cols-1 gy-3 py-3">
            <?php
            $penznem = 'Ft';

            echo '<article class="col p-2">';
            if (isset($_SESSION["kosar"])) {
                // kiíratáson még dolgozni***************
                while ($termek = mysqli_fetch_array($termekek)) {
                    $kosar = $_SESSION["kosar"];
                    foreach ($kosar as $tartalom) {
                        if ($termek["customerNumber"] === $tartalom) {
                            $_SESSION["osszeg"] += $termek["creditLimit"];
                            echo $termek["customerName"] . ' ' . $termek["creditLimit"] . ' ' . $penznem . '<br>';
                        }
                    }
                }
            }

            // kiíratáson még dolgozni***************
            echo ($_SESSION["osszeg"] > 0) ? 'A végösszeg: ' . $_SESSION["osszeg"] . '.00 ' . $penznem : '';
            echo '</article><article class="col p-2">';

            // teszt rész ********************
            echo '<hr>';

            echo '<form method="post"><input type="submit" name="torol" id="torol" value="Töröl"></form></article>';

            ?>
        </section>
    </main>

    <?php

    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.bundle.min.js" integrity="sha512-9GacT4119eY3AcosfWtHMsT5JyZudrexyEVzTBWV3viP/YfB9e2pEy3N7WXL3SV6ASXpTU0vzzSxsbfsuUH4sQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="scripts.js"></script>
</body>

</html>