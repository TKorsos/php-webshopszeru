<?php

use controllers\UserController;

$page = new UserController;

use controllers\WeekOffer;

$week = new WeekOffer;

?>
<nav class="navbar sticky-top navbar-expand-lg nav-color">
    <div class="container-fluid">
        <a class="navbar-brand link-light" href="index.php">PC Shop</a>
        <div class="order-lg-last">
            <div class="date text-center" id="date-js"></div>
        </div>
        <button class="navbar-toggler border-light bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse w-100" id="navbarNav">
            <ul class="navbar-nav d-lg-flex flex-lg-row justify-content-lg-evenly w-100">
                <li class="nav-item">
                    <a class="nav-link link-light" href="?page=productsView">Termékek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light" href="?page=cartView">
                        <span class="position-relative pt-1 pe-1">Kosár tartalma
                            <?php

                            if (isset($_SESSION["kosar"]) &&  count($_SESSION["kosar"]) > 0) {
                                echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">';
                                echo array_sum($_SESSION["kosar"]) . 'db';
                                echo '</span>';
                            }

                            ?>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light" href="?page=contactsView">Kapcsolat</a>
                </li>
                <!-- ezt majd csak az admin láthatja!!! -->
                <?php if(isset($_SESSION["user"]) == true && $_SESSION["user"]["email"] === "admin@info.hu") { ?>
                <li class="nav-item">
                    <a class="nav-link link-light" href="?page=emailsView">E-mailek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light" href="?page=orderlistView">Rendelések listája</a>
                </li>
                <?php } ?>
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
                            <a class="nav-link link-light" href="?page=profileView&id=<?php echo $_SESSION["user"]["id"] ?>">Profilom</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="d-flex flex-row align-items-center">
                            <?php
                            if (isset($_SESSION['user'])) {
                                echo '<span class="welcome-text text-light pe-3">Üdvözlünk, <span class="log-name">' . $_SESSION["user"]["first_name"] . ' ' . $_SESSION["user"]["last_name"] . '</span></span>';
                            }
                            ?>
                            <a class="nav-link link-light" href="?page=logoutProcess">Kijelentkezés</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<!-- akciók ha minden oldalon szeretnénk szerepeltetni -->
<header class="position-fixed w-100 week-color">
    <div class="container-fluid">
        <div class="col py-2 d-flex justify-content-center align-items-center">
            <span class="week-offer-animation text-danger">
                <strong>
                    <?php echo $week->navOffer(); ?>
                </strong>
            </span>
        </div>
    </div>
</header>

<!-- bejelentkezés -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-custom modal-text-custom">
            <form action="?page=loginProcess&backUrl=<?php echo $_SERVER["REQUEST_URI"] ?>" method="post" class="row g-3 p-3">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="loginModalLabel">Bejelentkezés</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col py-3">
                        <label for="emailLog" class="form-label">E-mail cím</label>
                        <input type="email" class="form-control" id="emailLog" name="email">
                    </div>
                    <div class="col py-3">
                        <label for="passwordLog" class="form-label">Jelszó</label>
                        <div class="input-group">
                            <input type="password" class="form-control js-password-log" id="passwordLog" name="password">
                            <button type="button" class="btn btn-outline-light js-password-btn" name="passBtn"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex flex-nowrap justify-content-between gap-2">
                    <button type="button" class="btn btn-danger w-50 m-0" data-bs-dismiss="modal">Mégsem</button>
                    <button type="submit" class="btn btn-success w-50 m-0" name="login">Belépés</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- regisztráció -->
<div class="modal fade" id="regModal" tabindex="-1" aria-labelledby="regModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-custom modal-text-custom">
            <form action="?page=registerProcess&backUrl=<?php echo $_SERVER["REQUEST_URI"] ?>" method="post" class="row g-3 p-3">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="regModalLabel">Regisztráció</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <label for="firstNameReg" class="form-label">Vezetéknév</label>
                            <input type="text" class="form-control" id="firstNameReg" name="first_name" value="<?php echo $_SESSION["post_user"]["first_name"] ?? ''; ?>">
                        </div>
                        <div class="col-6">
                            <label for="lastNameReg" class="form-label">Keresztnév</label>
                            <input type="text" class="form-control" id="lastNameReg" name="last_name" value="<?php echo $_SESSION["post_user"]["last_name"] ?? ''; ?>">
                        </div>
                        <div class="col-12">
                            <label for="emailReg" class="form-label">E-mail cím</label>
                            <input type="email" class="form-control" id="emailReg" name="email" value="<?php echo $_SESSION["post_user"]["email"] ?? ''; ?>">
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
                            <input type="text" class="form-control" id="billingNameReg" name="billing_name" value="<?php echo $_SESSION["post_user"]["billing_name"] ?? ''; ?>">
                        </div>
                        <div class="col-6">
                            <label for="phoneReg" class="form-label">Telefon</label>
                            <input type="text" class="form-control" id="phoneReg" name="phone" value="<?php echo $_SESSION["post_user"]["phone"] ?? ''; ?>">
                        </div>
                        <div class="col-6">
                            <label for="countryReg" class="form-label">Ország</label>
                            <input type="text" class="form-control" id="countryReg" name="country" value="<?php echo $_SESSION["post_user"]["country"] ?? ''; ?>">
                        </div>
                        <div class="col-4">
                            <label for="zipReg" class="form-label">Irányítószám</label>
                            <input type="text" class="form-control" id="zipReg" name="zip" value="<?php echo $_SESSION["post_user"]["zip"] ?? ''; ?>">
                        </div>
                        <div class="col-8">
                            <label for="cityReg" class="form-label">Város</label>
                            <input type="text" class="form-control" id="cityReg" name="city" value="<?php echo $_SESSION["post_user"]["city"] ?? ''; ?>">
                        </div>
                        <div class="col-8">
                            <label for="streetReg" class="form-label">Utca</label>
                            <input type="text" class="form-control" id="streetReg" name="street" value="<?php echo $_SESSION["post_user"]["street"] ?? ''; ?>">
                        </div>
                        <div class="col-4">
                            <label for="nrReg" class="form-label">Házszám</label>
                            <input type="text" class="form-control" id="nrReg" name="nr" value="<?php echo $_SESSION["post_user"]["nr"] ?? ''; ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex flex-nowrap justify-content-between gap-2">
                    <button type="button" class="btn btn-danger w-50 m-0" data-bs-dismiss="modal">Mégsem</button>
                    <button type="submit" class="btn btn-success w-50 m-0" name="reg">Regisztrál</button>
                </div>
            </form>
        </div>
    </div>
</div>