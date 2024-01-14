<?php
/*
if (!isset($_SESSION)) {
    session_start();
}
*/

session_start();

// $termek["week_offer"] -> $weekoffer
// $termek["price"] -> $price
// offert majd lehet át kellene nevezni
function offer($weekoffer, $price)
{
    if ($_SESSION["today"] === 0 || $_SESSION["today"] === 6) {
        return $weekoffer === "1" ? '<div class="text-decoration-line-through text-danger">' . $price . ' Ft</div><div>' . $price * $_SESSION["week_offer"] . ' Ft</div>' : '<div>' . $price . ' Ft</div>';
    } else {
        return '<div>' . $price . ' Ft</div>';
    }
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

$connection = mysqli_connect("localhost", "root", "12345", "pcshop");

$errors = mysqli_error($connection);
mysqli_set_charset($connection, "utf8mb4");

if ($errors) {
    echo $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST["send_comment"])) {
        // termek_id, comment_name, comment_email, comment_message
        $termek_id = $_GET["id"];
        $comment_name = $_POST["comment_name"];
        $comment_email = $_POST["comment_email"];
        $comment_message = $_POST["comment_message"];

        $comment_errors = [];

        if (mb_strlen($comment_name) < 3) {
            $comment_errors[] = "<div>A névnek minimum 3 karakternek kell lennie!</div>";
        }

        if (filter_var($comment_email, FILTER_VALIDATE_EMAIL) == false) {
            $comment_errors[] = "<div>Invalid e-mail címet adott meg!</div>";
        }

        if (mb_strlen($comment_message) < 10) {
            $comment_errors[] = "<div>Az üzenetnek minimum 10 karakternek kell lennie!</div>";
        }

        // $_SESSION["alert"]
        if (count($comment_errors) > 0) {
            $_SESSION["alert"] = '<div class="container-lg custom-top"><div class="row pt-5"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-danger" role="alert">';
            foreach ($comment_errors as $comment_error) {
                $_SESSION["alert"] .= "$comment_error";
            }
            $_SESSION["alert"] .= '</div></div></div></div>';
        } else {
            mysqli_query($connection, "insert into comment (`termek_id`, `comment_name`, `comment_email`, `comment_message`) values ('$termek_id', '$comment_name', '$comment_email', '$comment_message') ");
        }
    } 
    
    if (isset($_POST["data"])) {
        // termek_id és termek_db létrehozása id alapján lesz azonosítva majd a kosárban, így ha újra be lesz helyezve a kosárba ugyanaz az id már megtalálja és az ott lévő értéket módosítja vagy ad hozzá
        $termek_id = $_POST["data"];
        $termek_db = is_numeric($_POST["darabszam"]) && $_POST["darabszam"] > 0 ? $_POST["darabszam"] : 1;

        if (!isset($_SESSION["kosar"])) {
            $_SESSION["kosar"] = [];
        }
        // ahányszor nyomjuk meg a "kosárba tesz" gombot annyiszor adja hozzá a darabszámot
        $_SESSION["kosar"][$termek_id] += $termek_db;
    }

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

    $termekek = mysqli_query($connection, "select * from products where id = '" . $_GET["id"] . "'");

    // alert megjelenítése
    if (isset($_SESSION["alert"])) {
        echo $_SESSION["alert"];
    }

    $comments_display = mysqli_query($connection, "select * from comment where termek_id = ' " . $_GET["id"] . " ' order by created_at desc ");

    while ($comment_db = mysqli_fetch_assoc($comments_display)) {
        if (!isset($comments_qtty)) {
            $comments_qtty = [];
        }

        $comments_qtty[] = $comment_db["comment_message"];
    }

    ?>

    <main class="container-lg pb-5 custom-top">
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
                            <h2 class="card-text text-color">' . (offer($data["week_offer"], $data["price"])) . '</h2>
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
                    </section>
                    <hr>';
            }

            // kommentek helye ( írás, módosítás (content_editable?), törlés ) - lehet kezdetben csak írás többi admin szükséges
            // egyelőre regisztráció nélkül lehet kommentelni
            // később ha regisztrációhoz kötött akkor az adott user adataival töltse ki ahol szükséges
            // mysql id, termek_id, comment_name, comment_email, comment_message, created_at, updated_at
            echo '
            <section class="row">
                <article class="col pb-3">
                    <h2>Üzenet küldése</h2>
                </article>
            </section>
            <section class="row">
                <article class="col">
                    <div class="row row-cols-1 gap-3">
                        <div class="col">
                            <div class="row gap-3 gap-lg-0">
                                <div class="col-lg-6">
                                    <label for="comment_name">Név</label>
                                    <input type="text" class="form-control" id="comment_name" name="comment_name">
                                </div>
                                <div class="col-lg-6">
                                    <label for="comment_email">E-mail</label>
                                    <input type="email" class="form-control" id="comment_email" name="comment_email">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="comment_message">Üzenet</label>
                            <textarea class="form-control" id="comment_message" name="comment_message"></textarea>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-dark" name="send_comment">Üzenet elküldése</button>
                        </div>
                    </div>
                </article>
            </section>
            <hr>
            <section class="row">
                <article class="col pb-3">
                    <h2>
                        Vélemények | ' . (isset($comments_qtty) && count($comments_qtty) > 0 ? count($comments_qtty) : '0') . ' db
                    </h2>
                </article>
            </section>
            <section class="row row-cols-1 gy-3">';
            // id, termek_id, comment_name, comment_email, comment_message, created_at, updated_at
            // kiírat, időrendi sorrend felül a legfrissebb, created_at alapján
            $comments_display = mysqli_query($connection, "select * from comment where termek_id = ' " . $_GET["id"] . " ' order by created_at desc ");

            while ($product_comment = mysqli_fetch_assoc($comments_display)) {
                echo '<article class="col-md-9"><h5>' . $product_comment["comment_name"] . ' (<a class="comment_mail" href="mailto: kjanos@mail.com">' . $product_comment["comment_email"] . '</a>)</h5></article>
                <article class="col-md-3 d-flex justify-content-md-end"><span class="message_date">' . $product_comment["created_at"] . '</span></article>
                <article class="col"><span class="message_text">' . $product_comment["comment_message"] . '</span></article>';
                echo '<hr>';
            }
            echo '</section>';

            ?>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
</body>

</html>