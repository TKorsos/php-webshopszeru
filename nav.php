<!-- kiíratás php-val plusz feltételek? -->

<nav class="navbar navbar-expand-lg nav-color">
    <div class="container-fluid">
        <a class="navbar-brand link-light" href="#">Logó</a>
        <button class="navbar-toggler border-light bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link link-light" href="index.php">Kezdőlap</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light" href="termekek.php">Termékek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light" href="kosar.php">Kosár tartalma</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light" href="#exampleModal" data-bs-toggle="modal">Bejelentkezés</a>
                </li>
                <li class="nav-item">
                    <div class="d-flex flex-row align-items-center">
                    <?php
                    if (isset($_SESSION['user'])) {
                        echo '<span class="text-light pe-3">Üdvözlünk, '.$_SESSION["user"]["first_name"].' '.$_SESSION["user"]["last_name"].'</span>';
                    }
                    ?>
                        <a class="nav-link link-light" href="logout.php">Kijelentkezés</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php

if (isset($_POST["login"])) {
    // login kezdete

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $connection = mysqli_connect("localhost", "root", "12345", "gyakorlas");

    $error = mysqli_error($connection);
    mysqli_set_charset($connection, "utf8mb4");

    if ($error) {
        echo $error;
    }

    $errors = [];

    if (empty($_POST["email"])) {
        $errors[] = "<div>Az e-mail cím megadása kötelező!</div>";
    }

    if (empty($_POST["password"])) {
        $errors[] = "<div>A jelszó megadása kötelező!</div>";
    }

    if (count($errors) > 0) {
        print '<div class="alert alert-danger" role="alert">';
        foreach ($errors as $error) {
            print "$error";
        }
        print '</div>';
    } else {
        $sql = mysqli_query($connection, "select * from users where email = '" . $_POST['email'] . "'");
        $user = mysqli_fetch_array($sql);

        if (isset($user["email"]) === false) {
            $errors[] = '<div>A megadott e-mail cím nem létezik!</div>';
        } else {
            if ($_POST["password"] !== $user["password"]) {
                $errors[] = '<div>Hibás jelszót adott meg!</div>';
            }
        }

        if (count($errors) > 0) {
            print '<div class="alert alert-danger" role="alert">';
            foreach ($errors as $error) {
                print "$error";
            }
            print '</div>';
        } else {
            // belépés
            $_SESSION["user"] = $user;

            header("location: index.php");
        }
    }

    // login vége
}

?>

<!-- bejelentkezés -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-custom modal-text-custom">
            <form method="post" class="row g-3 p-3">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Bejelentkezés</h1>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col py-3">
                        <label for="emailLog" class="form-label">E-mail cím</label>
                        <input type="email" class="form-control" id="emailLog" name="email">
                    </div>
                    <div class="col py-3">
                        <label for="passwordLog" class="form-label">Jelszó</label>
                        <input type="password" class="form-control" id="passwordLog" name="password">
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