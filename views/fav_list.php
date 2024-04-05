<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("meta.php") ?>
</head>

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
    ?>

        <main class="container-lg py-5 main-custom-top">
            <?php
            include("alert.php");
            ?>
            <section class="row d-flex flex-column gy-3 py-3">
                <article class="col-auto p-2 mx-auto">
                    <h1 class="p-2 rounded-2 bg-light">Kedvenceim listája</h1>
                </article>
                <article class="col-12 col-sm-8 col-md-5 mx-auto">
                    <div class="container">
                        <?php

                        $termekek = mysqli_query($page->connectProcess(), "select * from products");
                        // sorrend dátum szerint csökkenő
                        // problémás mert hiába van csökkenőbe a termékek szerint fog rangsorolni

                        $favlist = mysqli_query($page->connectProcess(), "select * from favlist where `userid` = '".$_SESSION["user"]["id"]."' order by `created_at` desc ");

                        while ($termek = mysqli_fetch_assoc($termekek)) {

                            while($favs = mysqli_fetch_assoc($favlist)) {

                                $fav_list_arr[] = $favs["productid"];

                            }

                            foreach($fav_list_arr as $fav) {
                                if($fav === $termek["id"]) {
                                    echo '
                                    <div class="row d-flex gap-3 gap-sm-0 border border-1 rounded-2 p-3 my-2 bg-light fav-card">
                                        <div class="col-sm-3 d-flex align-items-center justify-content-center">
                                            <div class="bg-success w-100 h-100 d-flex justify-content-center align-items-center">
                                                Kép helye
                                            </div>
                                        </div>
                                        <div class="col-sm-9 d-flex flex-column gap-2">
                                            <div>'.$termek["id"].'.) '.$termek["name"].'</div>
                                            <div>'.$termek["description"].'</div>
                                            <div>'.$termek["price"].' Ft</div>
                                        </div>
                                        <div class="col-12 pt-3 text-center">
                                            <div class="text-bg-primary">törlés gomb helye</div>
                                        </div>
                                    </div>';
                                }
                            }
                        }

                        echo '
                        <div class="mt-5">
                            <div class="text-bg-danger">összes törlése gomb</div>
                        </div>';

                        if(count($fav_list_arr) === 0) {
                            echo "Üres a kedvencek listád!";
                        }
                        
                        ?>
                    </div>
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