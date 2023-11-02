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

// kimenet formázása **************************************************
// lname, fname, email, tel, szamlazasi_nev, orszag, irszam, varos, utca_hsz, adoszam, szallitasi_cim, papir_szamla
if(isset($_POST["tovabb"])) {
    // fogadó fájl
    // $file = 'test.pdf';
    // $file = 'test.xlsx'; így legalább táblázatba van
    $file = 'test.xlsx';
    // vásárolni kívánt termékek
    $total = 0;
    $product = '';
    if (isset($_SESSION["kosar"]) && count($_SESSION["kosar"]) > 0) {
        // name, qtty, subtotal, total
        foreach ($_SESSION["kosar"] as $id => $dbszam) {

            $termek = mysqli_fetch_assoc(mysqli_query($connection, "select * from products where id = $id"));

            $subtotal = ($dbszam * $termek["price"]);
            $total += $subtotal;

            $prod = $termek["name"];
            // vásárolt termék adatai
            $product .= "Termék neve: \t$prod\nDarabszám: \t$dbszam\nTermék ára: \t$subtotal\n";
        }
        // + végösszeg
        $product .= "Végösszeg: \t$total";
    }

    // űrlapadatok
    $lname = $_POST["lname"];
    $fname = $_POST["fname"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $szamlazasi_nev = $_POST["szamlazasi_nev"];
    $orszag = $_POST["orszag"];
    $irszam = $_POST["irszam"];
    $varos = $_POST["varos"];
    $utca_hsz = $_POST["utca_hsz"];
    $adoszam = $_POST["adoszam"];
    if(isset($_POST["szallitasi_cim"])) {
        $szallitasi_cim = $_POST["szallitasi_cim"];
    } else {
        $szallitasi_cim = "Nem, másik címre kérem.";
    }
    if(isset($_POST["papir_szamla"])) {
        $papir_szamla = $_POST["papir_szamla"];
    } else {
        $papir_szamla = "Nem.";
    }
    // radio-nál kötelezővé kell tenni a választást
    $atvetel = $_POST["atvetel"];
    $fizetes = $_POST["fizetes"];

    // végső kiíratás
    $data = "Név: \t$lname\t$fname\nE-mail cím: \t$email\nTelfonszám: \t$tel\nSzámlázási név: \t$szamlazasi_nev\nOrszág: \t$orszag\nIrányítószám: \t$irszam\tVáros: \t$varos\nUtca, házszám: \t$utca_hsz\nAdószám (Nem kötelező): \t$adoszam\nSzállítási cím ugyanez legyen? \t$szallitasi_cim\nPapír alapú számlát kér? \t$papir_szamla\nÁtvétel módja: \t$atvetel\nFizetés módja: \t$fizetes";

    $sum = "$product\n$data";

    $txt = file_put_contents($file, $sum);

    // checkboxokkal még gond van
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
            // ciklusos megoldás *********************************************
            // személyes adatok, átvételi mód radio, fizetési mód megadása radio
            // checkboxnál feltétel hogy igen/nem

            $total = 0;

            if (isset($_SESSION["kosar"]) && count($_SESSION["kosar"]) > 0) {
                // name, qtty, subtotal, total
                foreach ($_SESSION["kosar"] as $id => $dbszam) {

                    $termek = mysqli_fetch_assoc(mysqli_query($connection, "select * from products where id = $id"));

                    $subtotal = ($dbszam * $termek["price"]);
                    $total += $subtotal;

                    echo '<section class="row p-1"><article class="col border p-3">';
                    echo '<article><h4>Termék neve: ' . $termek["name"] . '</h4></article>';
                    echo '<article><h4>Darabszám: ' . $dbszam . '</h4></article>';
                    echo '<article><h4>Termék ára: ' . $subtotal . ' Ft</h4></article>';
                    echo '</article></section>';
                }
                echo '<section class="row p-2"><article class="col"><h4>Végösszeg: ' . $total . ' Ft</h4></article></section>';
            }

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
                    [['Város', 'Utcanév, házszám']],
                    [['Adószám - (nem kötelező)']],
                    [['A szállítási címem ugyanez.']],
                    [['Papíralapú számlát kérek.']]
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
                "Vezetéknév" => "lname",
                "Keresztnév" => "fname",
                "E-mail cím" => "email",
                "Telefonszám" => "tel",
                "Számlázási név" => "szamlazasi_nev",
                "Irányítószám" => "irszam",
                "Város" => "varos",
                "Utcanév, házszám" => "utca_hsz",
                "Adószám - (nem kötelező)" => "adoszam"
            ];
    
            // űrlap kiíratás ciklussal eleje
            echo '<section class="row p-2">';
            foreach ($urlap as $ocol) {
                echo '<article class="col-6 pt-5">';
                foreach ($ocol as $row_id => $row) {
                    echo ($row_id === 0 ? '<article class="row pb-4">' : '<article class="row">');
                    foreach ($row as $icol) {
                        foreach ($icol as $id => $content) {
                            echo '<article class="col-' . (12 / count($icol)) . '">';
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
                            } elseif ($content === 'A szállítási címem ugyanez.' || $content === 'Papíralapú számlát kérek.') {
                                // checkbox value pipa és nem pipa esetén ************
                                echo '<div class="form-check">
                                    <input class="form-check-input rounded-0" type="checkbox" value="' . $content . '" id="' . ($content === 'A szállítási címem ugyanez.' ? "szallitasi_cim" : "papir_szamla") . '" name="' . ($content === 'A szállítási címem ugyanez.' ? "szallitasi_cim" : "papir_szamla") . '">
                                    <label class="form-check-label" for="' . ($content === 'A szállítási címem ugyanez.' ? "szallitasi_cim" : "papir_szamla") . '">' . $content . '</label>
                                </div>';
                            } elseif ($content === 'Ország') {
                                echo '<div class="form-floating mb-3">
                                    <select class="form-select" name="orszag" id="orszag" aria-label="' . $content . '">
                                        <option selected>Ország kiválasztása</option>';
                                foreach ($coutry as $list) {
                                    echo '<option value="' . $list . '">' . $list . '</option>';
                                }
                                echo '</select><label for="orszag">' . $content . '</label>
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

            echo '<section class="row justify-content-between"><article class="col-auto"><a href="termekek.php" class="btn btn-dark">Vissza a vásárláshoz</a></article><article class="col-auto"><a href="kosar.php" class="btn btn-dark">Vissza a kosárhoz</a></article></section>';

            ?>

        </form>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.bundle.min.js" integrity="sha512-9GacT4119eY3AcosfWtHMsT5JyZudrexyEVzTBWV3viP/YfB9e2pEy3N7WXL3SV6ASXpTU0vzzSxsbfsuUH4sQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="scripts.js"></script>
</body>

</html>