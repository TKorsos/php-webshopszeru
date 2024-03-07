<?php
    if (isset($_SESSION["errors"])) {
        echo '
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col p-2">
                <div class="container-lg">
                    <div class="row">
                        <div class="col-sm-10 col-md-8 col-xl-6 mx-auto">
                            <div class="alert alert-danger" role="alert">';
                                foreach($_SESSION["errors"] as $error) {
                                    echo "<div>$error</div>";
                                }
                    echo '</div>
                        </div>
                    </div>
                </div>
            </article>
        </section>';
    }

    if (isset($_SESSION["success"])) {
        echo '
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col p-2">
                <div class="container-lg">
                    <div class="row">
                        <div class="col-sm-10 col-md-8 col-xl-6 mx-auto">
                            <div class="alert alert-success" role="alert">
                                <strong>'.$_SESSION["success"].'</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>';
    }

    if (isset($_SESSION["clear"])) {
        echo '
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col p-2">
                <div class="container-lg">
                    <div class="row">
                        <div class="col-sm-10 col-md-8 col-xl-6 mx-auto">
                            <div class="alert alert-warning" role="alert">
                                <strong>'.$_SESSION["clear"].'</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>';
    }
