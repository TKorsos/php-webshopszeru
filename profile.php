<?php

session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

$connection = mysqli_connect("localhost", "root", "12345", "pcshop");

$error = mysqli_error($connection);
mysqli_set_charset($connection, "utf8mb4");

if ($error) {
    echo $error;
}

$uzenet = "";

if (isset($_POST["modosit"])) {

    // név és email cím ne változzon meg
    // $first_name = $_POST["first_name"];
    // $last_name = $_POST["last_name"];
    // $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];
    $phone = $_POST["phone"];
    $billing_name = $_POST["billing_name"];
    $country = $_POST["country"];
    $zip = $_POST["zip"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    $nr = $_POST["nr"];

    $mod_errors = [];

    if (mb_strlen($password) < 8) {
        $mod_errors[] = "<div>A jelszónak minimum 8 karakternek kell lennie!</div>";
    }

    if ($password != $password_confirmation) {
        $mod_errors[] = "<div>A két jelszó nem azonos!</div>";
    }

    if (mb_strlen($phone) != 12) {
        $mod_errors[] = "<div>A telefonszámank 12 karakternek kell lennie és +36-tal kezdődik!</div>";
    }

    if (mb_strlen($billing_name) < 6) {
        $mod_errors[] = "<div>A számlázási névnek minimum 6 karakternek kell lennie!</div>";
    }

    if (mb_strlen($country) < 3) {
        $mod_errors[] = "<div>Az országnak minimum 3 karakternek kell lennie!</div>";
    }

    if (mb_strlen($zip) != 4) {
        $mod_errors[] = "<div>Az irányítószámnak 4 karakternek kell lennie!</div>";
    }

    if (mb_strlen($city) < 3) {
        $mod_errors[] = "<div>A városnak minimum 3 karakternek kell lennie!</div>";
    }

    if (mb_strlen($street) < 3) {
        $mod_errors[] = "<div>Az utcanévnek minimum 3 karakternek kell lennie!</div>";
    }

    if (mb_strlen($nr) < 1) {
        $mod_errors[] = "<div>A házszámnak minimum 1 karakternek kell lennie!</div>";
    }

    if (count($mod_errors) > 0) {
        echo '<div class="container-lg"><div class="row pt-5"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-danger" role="alert">';
        foreach ($mod_errors as $mod_error) {
            echo "$mod_error";
        }
        echo '</div></div></div></div>';
    } else {

        mysqli_query($connection, "update `users` set `password` = '" . $password . "', `phone` = '" . $phone . "', `billing_name` = '" . $billing_name . "', `country` = '" . $country . "', `zip` = '" . $zip . "', `city` = '" . $city . "', `street` = '" . $street . "', `nr` = '" . $nr . "' where id = '" . $_SESSION["user"]["id"] . "' ");

        $uzenet = '<div class="container-lg"><div class="row pt-5"><div class="col-sm-10 col-md-8 col-xl-6 mx-auto"><div class="alert alert-success" role="alert">
        <strong>Sikeres volt az adatmódosítás!</strong>
        </div></div></div></div>';

        header('Refresh: 5');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>PHP gyakorlás</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php

    include("nav.php");

    if (mb_strlen($uzenet) > 0) {
        echo $uzenet;
    }

    if (isset($_SESSION["user"])) {
        $user_update = mysqli_query($connection, "select * from users where id = '" . $_SESSION["user"]["id"] . "' ");

        $user = mysqli_fetch_assoc($user_update);
    }

    ?>

    <main class="container-lg py-5">
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col-auto p-2 mx-auto">
                <h1>Profil adataim módosítása</h1>
            </article>
            <article class="col-lg-8 p-2 mx-auto">
                <form method="post" class="container">
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
</body>

</html>