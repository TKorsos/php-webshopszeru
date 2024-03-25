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
            <article class="col-auto p-2 mx-auto">
                <h1>Rendelések listája</h1>
            </article>
        </section>
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col p-2">
                <?php
                $orders = mysqli_query($page->connectprocess(), "select * from orders order by created_at desc");
                // id, user_id, payment_json, shipping_json, products_json, total, created_at
                echo '<div class="container-lg text-break">';
                while($order = mysqli_fetch_assoc($orders)) {
                    echo '<div class="row row-cols-1 py-3 order-list-row">
                            <div class="col p-2 rounded-2 bg-light d-flex flex-column gap-2 order-list">
                                <div>User Id: '.$order["user_id"].'</div>
                                <div>Payment JSON: '.$order["payment_json"].'</div>
                                <div>Shipping JSON: '.$order["shipping_json"].'</div>
                                <div>Products JSON: '.$order["products_json"].'</div>
                                <div>Total: '.$order["total"].' Ft</div>
                            </div>
                        </div>';
                }
                echo '</div>';
                ?>
            </article>
        </section>
    </main>

    <?php include("scripts.php") ?>
</body>

</html>