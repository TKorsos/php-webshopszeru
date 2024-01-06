<nav class="navbar navbar-expand-lg nav-color">
    <div class="container-fluid">
        <a class="navbar-brand link-light" href="#">Logó</a>
        <button class="navbar-toggler border-light bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-lg-flex flex-lg-row justify-content-lg-evenly w-100">
                <li class="nav-item">
                    <a class="nav-link link-light" href="index.php">Kezdőlap</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light" href="termekek.php">Termékek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light" href="kosar.php">
                        <span class="position-relative pt-1 pe-1">Kosár tartalma
                            <?php
                            echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">';
                            if (count($_SESSION["kosar"]) > 0) {
                                echo array_sum($_SESSION["kosar"]) . 'db';
                            }
                            echo '</span>';
                            ?>
                        </span>
                    </a>
                </li>
                <!-- bejelentkezés és regisztráció akkor látható ha nincs bejelentkezve a felhasználó -->
                <?php if (isset($_SESSION['user']) == false) { ?>
                <li class="nav-item">
                    <a class="nav-link link-light" href="#loginModal" data-bs-toggle="modal">Bejelentkezés</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light" href="#regModal" data-bs-toggle="modal">Regisztráció</a>
                </li>
                <!-- kijelentkezés akkor látható ha be van jelentkezve a felhasználó -->
                <?php } else { ?>
                <li class="nav-item">
                    <div class="d-flex flex-row align-items-center">
                        <?php
                        if (isset($_SESSION['user'])) {
                            echo '<span class="text-light pe-3">Üdvözlünk, <span class="log-name">' . $_SESSION["user"]["first_name"] . ' ' . $_SESSION["user"]["last_name"] . '</span></span>';
                        }
                        ?>
                        <a class="nav-link link-light" href="logout.php">Kijelentkezés</a>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<?php

if (isset($_POST["login"])) {
    // login kezdete

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $connection = mysqli_connect("localhost", "root", "12345", "pcshop");

    $error = mysqli_error($connection);
    mysqli_set_charset($connection, "utf8mb4");

    if ($error) {
        echo $error;
    }

    $log_errors = [];

    if (empty($_POST["email"])) {
        $log_errors[] = "<div>Az e-mail cím megadása kötelező!</div>";
    }

    if (empty($_POST["password"])) {
        $log_errors[] = "<div>A jelszó megadása kötelező!</div>";
    }

    if (count($log_errors) > 0) {
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($log_errors as $log_error) {
            echo "$log_error";
        }
        echo '</div>';
    } else {
        $sql = mysqli_query($connection, "select * from users where email = '" . $_POST['email'] . "'");
        $user = mysqli_fetch_array($sql);

        if (isset($user["email"]) === false) {
            $log_errors[] = '<div>A megadott e-mail cím nem létezik!</div>';
        } else {
            if ($_POST["password"] !== $user["password"]) {
                $log_errors[] = '<div>Hibás jelszót adott meg!</div>';
            }
        }

        if (count($log_errors) > 0) {
            echo '<div class="alert alert-danger" role="alert">';
            foreach ($log_errors as $log_error) {
                echo "$log_error";
            }
            echo '</div>';
        } else {
            // belépés
            $_SESSION["user"] = $user;

            header("location: index.php");
        }
    }

    // login vége
}

if (isset($_POST["reg"])) {
    // regisztráció kezdete
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $connection = mysqli_connect("localhost", "root", "12345", "pcshop");

    $error = mysqli_error($connection);
    mysqli_set_charset($connection, "utf8mb4");

    if ($error) {
        echo $error;
    }

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];
    $phone = $_POST["phone"];
    $billing_name = $_POST["billing_name"];
    $country = $_POST["country"];
    $zip = $_POST["zip"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    $nr = $_POST["nr"];

    // feltételek, hibaüzenetek, feltöltés
    $reg_errors = [];

    if (mb_strlen($first_name) < 2) {
        $reg_errors[] = "<div>A vezetéknévnek minimum 2 karakternek kell lennie!</div>";
    }

    if (mb_strlen($last_name) < 3) {
        $reg_errors[] = "<div>A keresztnévnek minimum 3 karakternek kell lennie!</div>";
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $reg_errors[] = "<div>Invalid e-mail címet adott meg!</div>";
    }

    if (mb_strlen($password) < 8) {
        $reg_errors[] = "<div>A jelszónak minimum 8 karakternek kell lennie!</div>";
    }

    if ($password != $password_confirmation) {
        $reg_errors[] = "<div>A két jelszó nem azonos!</div>";
    }

    if (mb_strlen($phone) != 12) {
        $reg_errors[] = "<div>A telefonszámank 12 karakternek kell lennie és +36-tal kezdődik!</div>";
    }

    if (mb_strlen($billing_name) < 6) {
        $reg_errors[] = "<div>A számlázási névnek minimum 6 karakternek kell lennie!</div>";
    }

    if (mb_strlen($country) < 3) {
        $reg_errors[] = "<div>Az országnak minimum 3 karakternek kell lennie!</div>";
    }

    if (mb_strlen($zip) != 4) {
        $reg_errors[] = "<div>Az irányítószámnak 4 karakternek kell lennie!</div>";
    }

    if (mb_strlen($city) < 3) {
        $reg_errors[] = "<div>A városnak minimum 3 karakternek kell lennie!</div>";
    }

    if (mb_strlen($street) < 3) {
        $reg_errors[] = "<div>Az utcanévnek minimum 3 karakternek kell lennie!</div>";
    }

    if (mb_strlen($nr) < 1) {
        $reg_errors[] = "<div>A házszámnak minimum 1 karakternek kell lennie!</div>";
    }

    if (count($reg_errors) > 0) {
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($reg_errors as $reg_error) {
            echo "$reg_error";
        }
        echo '</div>';
    } else {
        mysqli_query($connection, "insert into users (`first_name`, `last_name`, `email`, `password`, `phone`, `billing_name`, `country`, `zip`, `city`, `street`, `nr`) values ('$first_name', '$last_name', '$email', '$password', '$phone', '$billing_name', '$country', '$zip', '$city', '$street', '$nr')");

        echo mysqli_error($connection);

        // bootstrap alert megjelenítés
        echo '<div class="alert alert-success" role="alert">
            <strong>Sikeres volt a regisztráció!</strong>
        </div>';
        
        // a megjelenített üzenet után 5 másodperccel frissít
        header('Refresh: 5');
    }
}

?>

<!-- bejelentkezés -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-custom modal-text-custom">
            <form method="post" class="row g-3 p-3">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="loginModalLabel">Bejelentkezés</h1>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col py-3">
                        <label for="emailLog" class="form-label">E-mail cím</label>
                        <input type="email" class="form-control" id="emailLog" name="email">
                    </div>
                    <div class="col py-3">
                        <label for="passwordLog" class="form-label">Jelszó</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="passwordLog" name="password">
                            <button type="button" class="btn btn-outline-light" id="passBtn" name="passBtn"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Mégsem</button>
                    <button type="submit" class="btn btn-success rounded-0" name="login">Belépés</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- regisztráció -->
<div class="modal fade" id="regModal" tabindex="-1" aria-labelledby="regModalLabel" aria-hidden="true">
    <!-- modal-fullscreen teszt? -->
    <div class="modal-dialog">
        <div class="modal-content modal-custom modal-text-custom">
            <form method="post" class="row g-3 p-3">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="regModalLabel">Regisztráció</h1>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <label for="firstNameReg" class="form-label">Vezetéknév</label>
                            <input type="text" class="form-control" id="firstNameReg" name="first_name" value="<?php echo $first_name ?? ''; ?>">
                        </div>
                        <div class="col-6">
                            <label for="lastNameReg" class="form-label">Keresztnév</label>
                            <input type="text" class="form-control" id="lastNameReg" name="last_name" value="<?php echo $last_name ?? ''; ?>">
                        </div>
                        <div class="col-12">
                            <label for="emailReg" class="form-label">E-mail cím</label>
                            <input type="email" class="form-control" id="emailReg" name="email" value="<?php echo $email ?? ''; ?>">
                        </div>
                        <div class="col-6">
                            <label for="passwordReg" class="form-label">Jelszó</label>
                            <input type="password" class="form-control" id="passwordReg" name="password">
                        </div>
                        <div class="col-6">
                            <label for="passwordConfReg" class="form-label">Jelszó újra</label>
                            <input type="password" class="form-control" id="passwordConfReg" name="password_confirmation">
                        </div>
                        <div class="col-12">
                            <label for="billingNameReg" class="form-label">Számlázási név</label>
                            <input type="text" class="form-control" id="billingNameReg" name="billing_name" value="<?php echo $billing_name ?? ''; ?>">
                        </div>
                        <div class="col-6">
                            <label for="phoneReg" class="form-label">Telefon</label>
                            <input type="text" class="form-control" id="phoneReg" name="phone" value="<?php echo $phone ?? ''; ?>">
                        </div>
                        <div class="col-6">
                            <label for="countryReg" class="form-label">Ország</label>
                            <input type="text" class="form-control" id="countryReg" name="country" value="<?php echo $country ?? ''; ?>">
                        </div>
                        <div class="col-4">
                            <label for="zipReg" class="form-label">Irányítószám</label>
                            <input type="text" class="form-control" id="zipReg" name="zip" value="<?php echo $zip ?? ''; ?>">
                        </div>
                        <div class="col-8">
                            <label for="cityReg" class="form-label">Város</label>
                            <input type="text" class="form-control" id="cityReg" name="city" value="<?php echo $city ?? ''; ?>">
                        </div>
                        <div class="col-8">
                            <label for="streetReg" class="form-label">Utca</label>
                            <input type="text" class="form-control" id="streetReg" name="street" value="<?php echo $street ?? ''; ?>">
                        </div>
                        <div class="col-4">
                            <label for="nrReg" class="form-label">Házszám</label>
                            <input type="text" class="form-control" id="nrReg" name="nr" value="<?php echo $nr ?? ''; ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Mégsem</button>
                    <button type="submit" class="btn btn-success rounded-0" id="liveToastBtn" name="reg">Regisztrál</button>
                </div>
            </form>
        </div>
    </div>
</div>