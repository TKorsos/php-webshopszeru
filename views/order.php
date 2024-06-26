<?php

/*
if (isset($_SESSION["user"]) == false) {
  exit('Csak bejelenkezett felhasználók részére!');
}
*/

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("meta.php") ?>
</head>

<!--
  fenti tíltás beállítása
-->

<body>
    <!-- nav helye -->
    <?php

    include("nav.php");

    ?>

    <main class="container-lg py-5 main-custom-top">
        <?php
            include("alert.php");
        ?>
        <form action="?page=orderProcess" method="post">

            <?php

            $total = 0;
            // akcióhoz tartozó szorzó
            $ertek = 1;

            if (isset($_SESSION["kosar"]) && count($_SESSION["kosar"]) > 0) {
                foreach ($_SESSION["kosar"] as $id => $dbszam) {

                    $termek = mysqli_fetch_assoc(mysqli_query($page->connectProcess(), "select * from products where id = $id"));

                    $subtotal = ($dbszam * $page->subTotal($termek["week_offer"], $ertek) * $termek["price"]);
                    $total += $subtotal;

                    echo '
                    <section class="row p-1">
                        <article class="col border p-3 rounded-2 bg-light product-table-row">
                            <article>
                                <h4>
                                    <a href="?page=productView&id='.$id.'" class="product-name-link">
                                        Termék neve: ' . $termek["name"] . '
                                    </a>
                                </h4>
                            </article>
                            <article>
                                <h4>Darabszám: ' . $dbszam . '</h4>
                            </article>
                            <article>
                                <h4>Termék ára: ' . $subtotal . ' Ft</h4>
                            </article>
                        </article>
                    </section>';
                }
                echo '
                <section class="row p-1">
                    <article class="col-auto rounded-2 bg-light">
                        <h4 class="m-0 p-2">Végösszeg: ' . $total . ' Ft</h4>
                    </article>
                </section>';
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

            // űrlap kiíratás
            echo '<section class="row p-2">';
            foreach ($urlap as $ocol) {
                echo '<article class="col-md-6 rounded-2 bg-light">';
                foreach ($ocol as $row_id => $row) {
                    echo ($row_id === 0 ? '<article class="row pb-4">' : '<article class="row">');
                    foreach ($row as $icol) {
                        foreach ($icol as $id => $content) {
                            echo '<article class="col-sm-' . (12 / count($icol)) . '">';
                            if ($content === 'Átvételi mód' || $content === 'Fizetési mód') {
                                echo '<h3 class="pb-4">' . $content . '</h3>';
                                foreach ($ocol as $key => $sor) {
                                    if ($key > 0) {
                                        echo '
                                        <div class="form-check">
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
                                echo '
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="country" id="country" aria-label="' . $content . '">
                                        <option selected>Ország kiválasztása</option>';
                                foreach ($coutry as $list) {
                                    echo '
                                    <option value="' . $list . '">' . $list . '</option>';
                                }
                                echo '
                                    </select>
                                    <label for="country">' . $content . '</label>
                                </div>';
                            } else {
                                foreach ($for_ids as $id => $forname) {
                                    if ($id === $content) {
                                        echo '
                                        <div class="form-floating mb-3">
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

            echo '
                <section class="row py-2 justify-content-center">
                    <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                        <button class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3" id="rendeles" name="rendeles">
                            <div>Rendelés elküldése</div>
                            <i class="bi bi-send"></i>
                        </button>
                    </article>
                </section>';

            echo '<hr>';

            echo '
            <section class="row justify-content-center justify-content-md-between gap-2">
                <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                    <a href="?page=productsView" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3">
                        <i class="bi bi-arrow-left-circle"></i>
                        <div>Vissza a vásárláshoz</div>
                    </a>
                </article>
                <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
                    <a href="?page=cartView" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3">
                        <i class="bi bi-arrow-left-circle"></i>
                        <div>Vissza a kosárhoz</div>
                    </a>
                </article>
            </section>';

            ?>

        </form>
    </main>

    <?php include("scripts.php") ?>
</body>

</html>