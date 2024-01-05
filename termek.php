<?php

session_start();

// $termek["week_offer"] -> $weekoffer
// $termek["price"] -> $price
// offert majd lehet át kellene nevezni
function offer($weekoffer, $price) {
  if( $_SESSION["today"] === 0 || $_SESSION["today"] === 6 ) {
    return $weekoffer === "1" ? '<div class="text-decoration-line-through text-danger">' . $price . ' Ft</div><div>' . $price * $_SESSION["week_offer"] . ' Ft</div>' : '<div>' . $price . ' Ft</div>';
  }
  else {
    return '<div>' . $price . ' Ft</div>';
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // termek_id és termek_db létrehozása id alapján lesz azonosítva majd a kosárban, így ha újra be lesz helyezve a kosárba ugyanaz az id már megtalálja és az ott lévő értéket módosítja vagy ad hozzá
    $termek_id = $_POST["data"];
    $termek_db = is_numeric($_POST["darabszam"]) && $_POST["darabszam"] > 0 ? $_POST["darabszam"] : 1;

    if (!isset($_SESSION["kosar"])) {
        $_SESSION["kosar"] = [];
    }
    // ahányszor nyomjuk meg a "kosárba tesz" gombot annyiszor adja hozzá a darabszámot
    $_SESSION["kosar"][$termek_id] += $termek_db;

    header('location: ' . $_SERVER['REQUEST_URI']);
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

    $termekek = mysqli_query($connection, "select * from products where id = '" . $_GET["id"] . "'");

    ?>

    <main class="container-lg py-5">
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col-auto p-2 mx-auto">
                <h1>Termék</h1>
            </article>
        </section>

        <form method="post">
        <?php

            // ( offer($termek["week_offer"], $termek["price"]) )
            // csak itt $termek helyett $data
            // egységesítés? $termek/$data

                    while ($data = mysqli_fetch_array($termekek)) {
                        echo '<section class="row p-2 g-3">
                        <article class="col-sm-6 col-md-8 d-flex flex-column gap-3">
                            <article>
                                <h5 class="card-title termek-cim">' . $data["name"] . ' - ' . $data["slug"] . '</h5>
                            </article>
                            <article class="d-flex justify-content-center align-items-center h-100 border">
                                <span><strong>Kép helye</strong></span>
                            </article>
                        </article>
                        <article class="col-sm-6 col-md-4 d-flex flex-column gap-3">
                            <h2 class="card-text text-color">' . ( offer($data["week_offer"], $data["price"]) ) . '</h2>
                            <article><a href="termekek.php" class="btn btn-dark w-100">Vissza a vásárláshoz</a></article>
                            <article><a href="kosar.php" class="btn btn-dark w-100">Tovább a kosárhoz</a></article>
                            <article class="row gap-3 gap-lg-0">
                                <article class="col-lg-4 col-xl-3"><input type="number" class="form-control" name="darabszam" value="1"></article>
                                <article class="col-lg-8 col-xl-9"><button type="submit" class="btn btn-dark w-100" name="data" value="' . $data["id"] . '">Kosárba tesz</button></article>
                            </article>
                        </article>
                    </section>
                    <hr>
                    <section class="row row-cols-1 p-2">
                        <article class="col pb-3">
                            <h2 class="card-text text-color">Leírás</h2>
                        </article>
                        <article class="col">
                            <p class="card-text text-color">' . $data["description"] . '</p>
                        </article>
                    </section>';
                    }

                    ?>

        </form>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
</body>

</html>