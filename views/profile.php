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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>PHP gyakorlás</title>
    <link rel="stylesheet" href="./css/style.css">
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
        <main class="container-lg py-5">
            <section class="row row-cols-1 gy-3 py-3">
                <article class="col-auto p-2 mx-auto">
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
    ?>

        <main class="container-lg py-5 main-custom-top">
            <?php
                if (isset($_SESSION["alert"])) {
                    echo '<section class="row row-cols-1 gy-3 py-3"><article class="col p-2">'.$_SESSION["alert"].'</article></section>';
                }
            ?>
            <section class="row row-cols-1 gy-3 py-3">
                <article class="col-auto p-2 mx-auto">
                    <h1>Profil adataim módosítása</h1>
                </article>
                <article class="col-lg-8 p-2 mx-auto">
                    <form action="?page=updateProcess" method="post" class="container">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <label for="first_name">Vezetéknév</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user["first_name"] ?>" disabled>
                            </div>
                            <div class="col-lg-6">
                                <label for="last_name">Keresztnév</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user["last_name"] ?>" disabled>
                            </div>
                            <div class="col-12">
                                <label for="email">E-mail cím</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user["email"] ?>" disabled>
                            </div>
                            <div class="col-lg-6">
                                <label for="password">Jelszó</label>
                                <input type="password" class="form-control" id="password" name="password" value="<?php echo $user["password"] ?>">
                            </div>
                            <div class="col-lg-6">
                                <label for="password_confirmation">Jelszó megerősítése</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="<?php echo $user["password"] ?>">
                            </div>
                            <div class="col-12">
                                <label for="phone">Telefonszám</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user["phone"] ?>">
                            </div>
                            <div class="col-12">
                                <label for="billing_name">Számlázási név</label>
                                <input type="text" class="form-control" id="billing_name" name="billing_name" value="<?php echo $user["billing_name"] ?>">
                            </div>
                            <div class="col-12">
                                <label for="country">Ország</label>
                                <input type="text" class="form-control" id="country" name="country" value="<?php echo $user["country"] ?>">
                            </div>
                            <div class="col-lg-6">
                                <label for="zip">Irányítószám</label>
                                <input type="text" class="form-control" id="zip" name="zip" value="<?php echo $user["zip"] ?>">
                            </div>
                            <div class="col-lg-6">
                                <label for="city">Város</label>
                                <input type="text" class="form-control" id="city" name="city" value="<?php echo $user["city"] ?>">
                            </div>
                            <div class="col-lg-6">
                                <label for="street">Utca</label>
                                <input type="text" class="form-control" id="street" name="street" value="<?php echo $user["street"] ?>">
                            </div>
                            <div class="col-lg-6">
                                <label for="nr">Házszám</label>
                                <input type="text" class="form-control" id="nr" name="nr" value="<?php echo $user["nr"] ?>">
                            </div>
                            <div class="col-12 py-5 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary" name="modosit">Módosítás</button>
                            </div>
                        </div>
                    </form>
                </article>
            </section>
        </main>

    <?php
        // bejelentkezett ág vége
    }
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="./js/scripts.js"></script>
</body>

</html>