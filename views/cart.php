<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("meta.php") ?>
</head>

<body>
    <!-- nav helye -->
    <?php

    include("nav.php");

    ?>

    <!-- main helye -->
    <main class="container-lg py-5 main-custom-top">
        <?php
            include("alert.php");
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

                echo '<thead><tr><th>Leírás</th><th>Ár</th><th>Darabszám</th><th>Eltávolítás a kosárból</th><th>Összeg (Ft)</th></tr></thead><tbody>';

                foreach ($_SESSION["kosar"] as $product_id => $qtty) {

                    // termek.php oldalról továbbküldi id-t majd itt ellenőrzi hogy az adatbázisban lévő id egyezik-e a küldött id-val
                    $termek = mysqli_fetch_assoc(mysqli_query($page->connectProcess(), "select * from products where id = $product_id"));

                    // akcióhoz tartozó szorzó
                    $ertek = 1;

                    $subtotal = ($qtty * $week->subTotal($termek["week_offer"], $ertek) * $termek["price"]);
                    $total += $subtotal;

                    echo '<tr>';
                    echo '<td>' . $termek["name"] . '</td>';
                    echo '<td class="text-center text-md-start">';
                    // érdemes lenne külön fájlba rakni pl product.php
                    $weekArr = $week->offer($termek["week_offer"], $termek["price"]);
                    for($i = 0; $i < count($weekArr); $i++) {
                    if(count($weekArr) === 1) {
                        echo '<p>'.$weekArr[$i].' Ft</p>';
                    }
                    else {
                        if($i === 0) {
                        echo '<p class="text-decoration-line-through text-danger">'.$weekArr[$i].' Ft</p>';
                        }
                        else {
                        echo '<p>'.$weekArr[$i].' Ft</p>';
                        }
                    }
                    }
                    echo '</td>';

                    echo '
                        <form action="?page=cartProcess" method="post">
                            <td>
                                <article class="row gap-3 justify-content-center justify-content-md-start">
                                    <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                                        <input type="number" class="form-control input-qtty w-100" max="99" value="' . $qtty . '" name="qtty">
                                        <input type="hidden" name="id" value="' . $product_id . '">
                                    </article>
                                    <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                                        <button class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3">
                                            <div>Módosít</div>
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </article>
                                </article>
                            </td>
                            <td>
                                <button class="btn btn-danger d-flex justify-content-center align-items-center gap-3" name="torol" value="' . $product_id . '">
                                    <i class="bi bi-trash3"></i>
                                </button>
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
                            <button class="btn btn-danger btn-trash w-100 d-flex justify-content-center align-items-center gap-3" name="torolmind" id="torolmind">
                                <div>Kosár törlése</div>
                                <i class="bi bi-trash3"></i>
                            </button>
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
                        <a href="?page=productsView" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3">
                            <i class="bi bi-arrow-left-circle"></i>
                            <div>Vissza a vásárláshoz</div>
                        </a>
                    </article>
                    <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                        <a href="?page=orderView" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3">
                            <div>Tovább a rendeléshez</div>
                            <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </article>
                </section>';
            ?>
        </section>

    </main>

    <?php include("scripts.php") ?>
</body>

</html>