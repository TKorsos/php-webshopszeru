<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title><?php echo $this->pageTitle() ?></title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <!-- nav helye -->
    <?php

    include("nav.php");

    $termekek = mysqli_query($page->connectProcess(), "select * from products where id = '" . $_GET["id"] . "'");

    $termek_focim = mysqli_fetch_array($termekek);

    // a vélemények számának megadásához kell
    $comments_display = mysqli_query($page->connectProcess(), "select * from comment where termek_id = ' " . $_GET["id"] . " ' ");

    while ($comment_db = mysqli_fetch_assoc($comments_display)) {
        if (!isset($comments_qtty)) {
            $comments_qtty = [];
        }

        $comments_qtty[] = $comment_db["comment_message"];
    }

    ?>

    <main class="container-lg py-5 main-custom-top">
        <?php
            if (isset($_SESSION["alert"])) {
                echo '<section class="row row-cols-1 gy-3 py-3"><article class="col p-2">'.$_SESSION["alert"].'</article></section>';
            }
        ?>
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col-auto p-2 mx-auto">
                <h1 class="p-2 rounded-2 bg-light"><?php echo $termek_focim["name"] ?></h1>
            </article>
        </section>

        <form action="?page=termekAddToCartProcess&id=<?php echo $_GET["id"] ?>" method="post" class="rounded-2 bg-light">
            <?php

            $termekek = mysqli_query($page->connectProcess(), "select * from products where id = '" . $_GET["id"] . "'");
            while ($data = mysqli_fetch_array($termekek)) {
                echo '<section class="row p-2 g-3">
                        <article class="col-sm-6 col-md-8 d-flex flex-column gap-3">
                            <article>
                                <h5 class="card-title termek-cim">' . $data["slug"] . '</h5>
                            </article>
                            <article class="d-flex justify-content-center align-items-center h-100 border">
                                <span><strong>Kép helye</strong></span>
                            </article>
                        </article>
                        <article class="col-sm-6 col-md-4 d-flex flex-column gap-3">
                            <h2 class="card-text text-color">' . ($page->offer($data["week_offer"], $data["price"])) . '</h2>
                            <article><a href="?page=termekekView" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3"><i class="bi bi-arrow-left-circle"></i><div>Vissza a vásárláshoz</div></a></article>
                            <article><a href="?page=kosarView" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3"><div>Tovább a kosárhoz</div><i class="bi bi-arrow-right-circle"></i></a></article>
                            <article class="row gap-3 gap-lg-0">
                                <article class="col-lg-4 col-xl-3"><input type="number" class="form-control" name="darabszam" value="1"></article>
                                <article class="col-lg-8 col-xl-9"><button type="submit" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3" name="data" value="' . $data["id"] . '"><div>Kosárba tesz</div><i class="bi bi-cart4"></i></button></article>
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

        <form action="?page=commentProcess&id=<?php echo $_GET["id"] ?>" method="post" class="rounded-2 bg-light mt-5">

            <?php
            // kommentek helye ( írás, módosítás (content_editable?), törlés ) - lehet kezdetben csak írás többi admin szükséges
            // egyelőre regisztráció nélkül lehet kommentelni
            // később ha regisztrációhoz kötött akkor az adott user adataival töltse ki ahol szükséges
            echo '
            <section class="row p-2 g-3">
                <article class="col">
                    <h2>Küldje el véleményét</h2>
                </article>
            </section>
            <section class="row p-2">
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
                            <button type="submit" class="btn btn-dark d-flex justify-content-center align-items-center gap-3" name="send_comment"><div>Üzenet elküldése</div><i class="bi bi-envelope-arrow-up"></i></button>
                        </div>
                    </div>
                </article>
            </section>';
            ?>
        </form>
        <?php
        echo ' <hr>
            <section class="row">
                <article class="col-auto pb-3">
                    <h2 class="p-2 rounded-2 bg-light">
                        Vélemények | ' . (isset($comments_qtty) && count($comments_qtty) > 0 ? count($comments_qtty) : '0') . ' db
                    </h2>
                </article>
            </section>
            <section class="row row-cols-1 m-0 gy-3 rounded-2 bg-light">';
        
        $comments_display = mysqli_query($page->connectProcess(), "select * from comment where termek_id = ' " . $_GET["id"] . " ' order by created_at desc ");

        while ($product_comment = mysqli_fetch_assoc($comments_display)) {
            echo '<article class="col-md-9"><h5>' . $product_comment["comment_name"] . ' (<a class="comment_mail" href="mailto: ' . $product_comment["comment_email"] . '">' . $product_comment["comment_email"] . '</a>)</h5></article>
                <article class="col-md-3 d-flex justify-content-md-end"><span class="message_date">' . $product_comment["created_at"] . '</span></article>
                <article class="col"><span class="message_text">' . $product_comment["comment_message"] . '</span></article>';
            // új admin törlés gombja!
            // művelet még hiányzik - művelet később (form)
            if (isset($_SESSION["user"]) && $_SESSION["user"]["billing_name"] === "Admin Admin") {
                echo '<article class="col"><button class="btn btn-danger d-flex justify-content-center align-items-center gap-3" name="delete_comment" value="' . $product_comment["id"] . '"><div>Üzenet törlése</div><i class="bi bi-trash3"></i></button></article>';
            }
            echo '<hr>';
        }
        echo '</section>';

        ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="./js/scripts.js"></script>
</body>

</html>