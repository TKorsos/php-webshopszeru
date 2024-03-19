<?php
// megjelenítés
// név, tárgy - üzenet egy része (bootstrap), dátum
// név popover? név + e-mail
?>
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
                <h1>E-mailek listája</h1>
            </article>
        </section>
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col p-2">
                <?php
                $emails = mysqli_query($page->connectprocess(), "select * from emails");
                // contact_name, contact_email, contact_subject, contact_message
                ?>                
                <div class="accordion" id="emailsAccordion">
                    <?php
                    while($email = mysqli_fetch_assoc($emails)) {
                        echo '
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$email["id"].'" aria-expanded="false" aria-controls="collapse'.$email["id"].'">
                                    <div class="col-11 d-flex justify-content-between">
                                        <span class="collapse-email-name">'.$email["contact_name"].'</span>
                                        <span class="text-truncate collapse-email-title">'.$email["contact_subject"].' - '.$email["contact_message"].'</span>
                                        <span>'.$email["created_at"].'</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse'.$email["id"].'" class="accordion-collapse collapse" data-bs-parent="#emailsAccordion">
                                <div class="accordion-body">
                                    <div class="d-flex flex-column gap-3">
                                        <span>'.$email["contact_subject"].'</span>
                                        <span class="d-flex gap-3">
                                            <span>'.$email["contact_name"].'</span>
                                            <span>-</span>
                                            <span>'.$email["contact_email"].'</span>
                                            <span class="ms-auto">'.$email["created_at"].'</span>
                                        </span>
                                        <span>'.$email["contact_message"].'</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                    ?>
                </div>
            </article>
        </section>
    </main>

    <?php include("scripts.php") ?>
</body>

</html>