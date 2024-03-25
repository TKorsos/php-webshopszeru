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
    <?php

    include("nav.php");

    if (isset($_SESSION["user"])) {
        $user_update = mysqli_query($page->connectProcess(), "select * from users where id = '" . $_SESSION["user"]["id"] . "' ");

        $user = mysqli_fetch_assoc($user_update);
    }

    if (isset($_SESSION["user"]) == false) {
        // nem bejelenkezett ág
        echo '
        <main class="container-lg py-5 main-custom-top">';
            include("alert.php");
        echo '<section class="row row-cols-1 gy-3 py-3">
                <article class="col-auto p-2 mx-auto rounded-2 bg-light">
                    <h1>Ez az oldal bejelentkezést igényel!</h1>
                </article>
            </section>
            <section class="row row-cols-1 gy-3 py-3">
                <article class="col-auto p-2 mx-auto">
                    <div class="col-12 py-5 d-flex justify-content-center">
                        <a class="btn btn-dark w-100" href="#loginModal" data-bs-toggle="modal">Bejelentkezés</a>
                    </div>
                </article>
            </section>
        </main>';
    } else {
        // bejelentkezett ág
        // itt annyival módosul hogy bekerül 3 link ahonnan lehet továbblépni, csak az ez alatti részt kell átírni
    ?>

        <main class="container-lg py-5 main-custom-top">
            <?php
                include("alert.php");
            ?>
            <section class="row d-flex flex-column gy-3 py-3">
                <article class="col-auto p-2 mx-auto">
                    <h1 class="p-2 rounded-2 bg-light">Profil adataim</h1>
                </article>
                <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3 mx-auto">
                    <a href="?page=favListView&id=<?php echo $_SESSION["user"]["id"] ?>" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3">
                        <div>Kedvencek listája</div>
                        <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </article>
                <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3 mx-auto">
                    <a href="?page=profileUpdateView&id=<?php echo $_SESSION["user"]["id"] ?>" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3">
                        <div>Profil adataim módosítása</div>
                        <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </article>
                <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3 mx-auto">
                    <a href="?page=profileDeleteView&id=<?php echo $_SESSION["user"]["id"] ?>" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3">
                        <div>Felhasználói fiók törlése</div>
                        <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </article>
            </section>
        </main>

    <?php
        // bejelentkezett ág vége
    }
    ?>


    <?php include("scripts.php") ?>
</body>

</html>