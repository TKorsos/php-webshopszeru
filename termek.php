<?php

session_start();
//$_SESSION["darabszam"] = 1;
//$_SESSION["darabszam"] = [];
$_SESSION["termekdarab"] = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION["kosar"])) {
        $_SESSION["kosar"] = [];
    }
    $_SESSION["kosar"][] = $_POST["data"];

    if (!isset($_SESSION["darabszam"])) {
        $_SESSION["darabszam"] = [];
    }
    $_SESSION["darabszam"][] = $_POST["darabszam"];

    // header a kosar.php-ra??? meg kéne nézni pár webshopot hogy ott hogy van
    // teszt másik oldalon: 3 terméknél rányomok a kosárba gombra, majd az elsőt újra megnyitom és megint elküldöm
    // az első termék mennyisége változik? 2 lesz? vagy marad 1?

    //header('location: ' . $_SERVER['PHP_SELF']);
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

    $termekek = mysqli_query($connection, "select * from customers where customerNumber = '".$_GET["id"]."'");

    ?>

    <main class="container-lg py-5">
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col-auto p-2 mx-auto">
                <h1>Termék</h1>
            </article>
        </section>
    </main>

    <form method="post">
        <section class="row">
            <article class="col">
                <?php

                $penznem = 'Ft';

                while( $data = mysqli_fetch_array($termekek) ) {
                    echo '
        <article class="col p-2">
        <div class="card border-card shadow h-100">
          <div class="card-header text-center border-custom">
            <span><strong>Kép helye</strong></span>
          </div>
          <div class="card-body">
            <h5 class="card-title termek-cim">' . $data["customerName"] . '</h5>
            <!-- contactLastName, contactFirstName -->
            <h6 class="fst-italic py-3 name-color">' . $data["contactLastName"] . ' ' . $data["contactFirstName"] . '</h6>
            <h6 class="name-color">Leírás</h6>
            <p class="card-text text-color">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>
            <hr class="border-custom">
            <h6 class="name-color">Termék ára</h6>
            <p class="card-text text-color">' . $data["creditLimit"] . ' ' . $penznem . '</p>
            <hr class="border-custom">
          </div>
          <div class="card-footer border-0 d-grid justify-content-center gap-3"><div>';
                    echo '<input type="number" class="form-control" name="darabszam">';
                    echo '</div><button type="submit" class="btn btn-dark" name="data" value="' . $data["customerNumber"] . '">Kosárba tesz</button>';
                    echo '</div>
        </div>
        </article>
        ';
                }
                

                ?>
            </article>
        </section>
    </form>

    <?php

    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.bundle.min.js" integrity="sha512-9GacT4119eY3AcosfWtHMsT5JyZudrexyEVzTBWV3viP/YfB9e2pEy3N7WXL3SV6ASXpTU0vzzSxsbfsuUH4sQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="scripts.js"></script>
</body>

</html>