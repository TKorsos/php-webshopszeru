<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>PHP gyakorlás</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <!-- nav helye -->
    <?php

    include("nav.php");

    ?>

    <!-- main helye -->
    <main class="container-lg py-5 main-custom-top">
        <?php
            if (isset($_SESSION["alert"])) {
                echo '<section class="row row-cols-1 gy-3 py-3"><article class="col p-2">'.$_SESSION["alert"].'</article></section>';
            }
        ?>
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col-auto p-2 mx-auto rounded-2 bg-light">
                <h1>A kosár taralma</h1>
            </article>
        </section>
        <section class="row row-cols-1 gy-3 py-3">
            <?php
            echo '<article class="col p-2"><table class="table table-responsive align-middle rounded-2 bg-light">';

            $total = 0;

            if (isset($_SESSION["kosar"]) && count($_SESSION["kosar"]) > 0) {

                echo '<thead><tr><th>Leírás</th><th>Ár</th><th colspan="2">Darabszám</th><th>Összeg (Ft)</th></tr></thead><tbody>';

                foreach ($_SESSION["kosar"] as $product_id => $qtty) {

                    // termek.php oldalról továbbküldi id-t majd itt ellenőrzi hogy az adatbázisban lévő id egyezik-e a küldött id-val
                    $termek = mysqli_fetch_assoc(mysqli_query($page->connectProcess(), "select * from products where id = $product_id"));

                    // akcióhoz tartozó szorzó
                    $ertek = 1;

                    $subtotal = ($qtty * $page->subTotal($termek["week_offer"], $ertek) * $termek["price"]);
                    $total += $subtotal;

                    echo '<tr>';
                    echo '<td>' . $termek["name"] . '</td>';
                    echo '<td class="text-center text-md-start">' . ($page->offer($termek["week_offer"], $termek["price"])) . '</td>';

                    echo '
                        <form action="?page=cartProcess" method="post">
                            <td>
                                <article class="row gap-3 justify-content-center justify-content-md-start">
                                    <article class="col-12 col-md-auto">
                                        <input type="number" class="form-control input-qtty" max="99" value="' . $qtty . '" name="qtty">
                                        <input type="hidden" name="id" value="' . $product_id . '">
                                    </article>
                                    <article class="col-12 col-md-auto">
                                        <button class="btn btn-dark w-100">Módosít</button>
                                    </article>
                                </article>
                            </td>
                            <td>
                                <button class="btn btn-danger" name="torol" value="' . $product_id . '">Eltávolítás a kosárból</button>
                            </td>
                        </form>';

                    echo '<td class="text-center text-md-start">' . $subtotal . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '
                    <h4 class="p-2 rounded-2 bg-light">Nincs termék a kosárban</h4>';
            }

            echo '</tbody></table></article>
                <article class="col-auto p-2">
                    <h3 class="p-2 rounded-2 bg-light">Összesen: ' . $total . ' Ft</h3>
                </article>';

            // kosár kiürítése
            if (isset($_SESSION["kosar"]) && count($_SESSION["kosar"]) > 0) {

                echo '
                <section class="row justify-content-center justify-content-md-between gap-2">
                    <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                        <form action="?page=clearCartProcess" method="post">
                            <input type="submit" class="btn btn-danger w-100" name="torolmind" id="torolmind" value="Kosár törlése">
                        </form>
                    </article>
                </section>';
            }

            echo '<hr>';

            // navigálás termékek és fizetés oldalak közt
            // rendelésnél ellenőrizni kell hogy be van-e jelentkezve ha igen akkor továbblép ha nem akkor előjön a login modal
            echo '
                <section class="row justify-content-center justify-content-md-between gap-2">
                    <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                        <a href="?page=termekekView" class="btn btn-dark w-100">Vissza a vásárláshoz</a>
                    </article>
                    <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                        <a href="?page=rendelesView" class="btn btn-dark w-100">Tovább a rendeléshez</a>
                    </article>
                </section>';
            ?>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="./js/scripts.js"></script>
</body>

</html>