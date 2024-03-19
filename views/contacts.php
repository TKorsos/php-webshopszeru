<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("meta.php") ?>
</head>

<body>
    <!-- nav helye -->
    <?php

    include("nav.php");

    ?>

    <!-- main helye -->
    <main class="container-lg py-5 main-custom-top">
        <?php
        include("alert.php");
        ?>
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col-auto p-2 mx-auto rounded-2 bg-light">
                <h1>Elérhetőségünk</h1>
            </article>
        </section>
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col p-2 contact-main">
                <ul class="contact-list">
                    <li>PC Shop</li>
                    <li class="d-flex justify-content-center align-items-center gap-2"><i class="bi bi-telephone fs-5"></i><span>+36121231234</span></li>
                    <li class="d-flex justify-content-center align-items-center gap-2"><i class="bi bi-envelope fs-5"></i><span>admin@info.hu</span></li>
                </ul>
            </article>
        </section>
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col-auto p-2 mx-auto rounded-2 bg-light">
                <h2>Küldj nekünk üzenetet, ha bármi kérdésed lenne!</h2>
            </article>
        </section>
        <section class="row row-cols-1 gy-3 py-3 justify-content-center">
            <article class="col col-md-8 col-lg-6 col-xl-4 p-2">
                <form action="?page=contactsProcess" class="p-2 rounded-2 bg-light" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="contact_name" placeholder="Név" name="contact_name">
                        <label for="contact_name">Név</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="contact_email" placeholder="E-mail" name="contact_email">
                        <label for="contact_email">E-mail</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="contact_subject" placeholder="Tárgy" name="contact_subject">
                        <label for="contact_subject">Tárgy</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Üzenet helye" id="contact_message" style="height: 100px" name="contact_message"></textarea>
                        <label for="contact_message">Üzenet helye</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-dark d-flex justify-content-center align-items-center gap-3" name="send_email"><div>Üzenet elküldése</div><i class="bi bi-envelope-arrow-up"></i></button>
                    </div>
                </form>
            </article>
        </section>
    </main>

    <?php include("scripts.php") ?>
</body>

</html>