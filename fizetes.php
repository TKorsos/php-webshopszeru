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
    $szallitasi_cim = $_POST["szallitasi_cim"];
    $papir_szamla = $_POST["papir_szamla"];
    // végső kiíratás
    $data = "Név: \t$lname\t$fname\nE-mail cím: \t$email\nTelfonszám: \t$tel\nSzámlázási név: \t$szamlazasi_nev\nOrszág: \t$orszag\nIrányítószám: \t$irszam\tVáros: \t$varos\nUtca, házszám: \t$utca_hsz\nAdószám (Nem kötelező): \t$adoszam\nSzállítási cím ugyanez legyen? \t$szallitasi_cim\nPapír alapú számlát kér? \t$papir_szamla";

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

                    echo '<section class="row p-1"><article class="col border p-3">';
                    echo '<article><h4>Termék neve: ' . $termek["name"] . '</h4></article>';
                    echo '<article><h4>Darabszám: ' . $dbszam . '</h4></article>';
                    echo '<article><h4>Termék ára: ' . $subtotal . ' Ft</h4></article>';
                    echo '</article></section>';
                }
                echo '<section class="row p-2"><article class="col"><h4>Végösszeg: ' . $total . ' Ft</h4></article></section>';
            }

            // űrlap kezdete
            echo '<section class="row p-2 mt-5">
            <article class="col">
                <article class="row pb-4">
                    <h3>Személyes adatok</h3>
                </article>
                <article class="row">
                    <article class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="lname" id="lname" placeholder="Vezetéknév">
                            <label for="lname">Vezetéknév</label>
                        </div>
                    </article>
                    <article class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="fname" id="fname" placeholder="Keresztnév">
                            <label for="fname">Keresztnév</label>
                        </div>
                    </article>
                </article>
                <article class="row">
                    <article class="col">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email" id="email" placeholder="E-mail cím">
                            <label for="email">E-mail cím</label>
                        </div>
                    </article>
                </article>
                <article class="row">
                    <article class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="tel" id="tel" placeholder="Telefonszám">
                            <label for="tel">Telefonszám</label>
                        </div>
                    </article>
                </article>
            </article>
            <article class="col">
                <article class="row pb-4">
                    <h3>Számlázási adatok</h3>
                </article>
                <article class="row">
                    <article class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="szamlazasi_nev" id="szamlazasi_nev" placeholder="Számlázási név">
                            <label for="szamlazasi_nev">Számlázási név</label>
                        </div>
                    </article>
                </article>
                <article class="row">
                    <article class="col">
                        <div class="form-floating mb-3">
                            <select class="form-select" name="orszag" id="orszag" aria-label="Ország">
                                <option selected>Ország kiválasztása</option>
                                <option value="Magyarország">Magyarország</option>
                                <option value="Argentína">Argentína</option>
                                <option value="Ausztrália">Ausztrália</option>
                                <option value="Ausztria">Ausztria</option>
                                <option value="Egyiptom">Egyiptom</option>
                                <option value="Franciaország">Franciaország</option>
                                <option value="Horvátország">Horvátország</option>
                                <option value="Japán">Japán</option>
                                <option value="Kanada">Kanada</option>
                                <option value="Nagy-Britannia">Nagy-Britannia</option>
                                <option value="Németország">Németország</option>
                                <option value="Olaszország">Olaszország</option>
                                <option value="Románia">Románia</option>
                                <option value="Szerbia">Szerbia</option>
                                <option value="Szlovákia">Szlovákia</option>
                                <option value="Szlovénia">Szlovénia</option>
                                <option value="Ukrajna">Ukrajna</option>
                            </select>
                            <label for="orszag">Ország</label>
                        </div>
                    </article>
                    <article class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="irszam" id="irszam" placeholder="Irányítószám">
                            <label for="irszam">Irányítószám</label>
                        </div>
                    </article>
                </article>
                <article class="row">
                    <article class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="varos" id="varos" placeholder="Város">
                            <label for="varos">Város</label>
                        </div>
                    </article>
                </article>
                <article class="row">
                    <article class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="utca_hsz" id="utca_hsz" placeholder="Utcanév, házszám">
                            <label for="utca_hsz">Utcanév, házszám</label>
                        </div>
                    </article>
                </article>
                <article class="row">
                    <article class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="adoszam" id="adoszam" placeholder="Adószám - (nem kötelező)">
                            <label for="adoszam">Adószám - (nem kötelező)</label>
                        </div>
                    </article>
                </article>
                <article class="row">
                    <article class="col">
                        <div class="form-check">
                            <input class="form-check-input rounded-0" type="checkbox" value="" id="szallitasi_cim" name="szallitasi_cim">
                            <label class="form-check-label" for="szallitasi_cim">
                                A szállítási címem ugyanez.
                            </label>
                        </div>
                    </article>
                </article>
                <article class="row">
                    <article class="col">
                        <div class="form-check">
                            <input class="form-check-input rounded-0" type="checkbox" value="" id="papir_szamla" name="papir_szamla">
                            <label class="form-check-label" for="papir_szamla">
                                Papíralapú számlát kérek.
                            </label>
                        </div>
                    </article>
                </article>
            </article>
        </section>
        <section class="row p-2 justify-content-center">
            <article class="col-auto">
                <!-- gomb name értékének beállítása -->
                <button class="btn btn-primary rounded-5 py-2 px-5" id="tovabb" name="tovabb">Tovább</button>
            </article>
        </section>';
        // űrlap vége

            echo '<hr>';

            echo '<section class="row justify-content-between"><article class="col-auto"><a href="termekek.php" class="btn btn-dark">Vissza a vásárláshoz</a></article><article class="col-auto"><a href="kosar.php" class="btn btn-dark">Vissza a kosárhoz</a></article></section>';

            ?>

        </form>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.bundle.min.js" integrity="sha512-9GacT4119eY3AcosfWtHMsT5JyZudrexyEVzTBWV3viP/YfB9e2pEy3N7WXL3SV6ASXpTU0vzzSxsbfsuUH4sQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="scripts.js"></script>
</body>

</html>