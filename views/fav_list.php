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
    <?php include("meta.php") ?>
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
                <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3 mx-auto rounded-2 bg-light">
                    <?php

                    // megjelenés kidolgozása!
                    // bootstrap + br-ek eltüntetése
                    $termekek = mysqli_query($page->connectProcess(), "select * from products");
                    // sorrend dátum szerint csökkenő
                    $favlist = mysqli_query($page->connectProcess(), "select * from favlist");

                    while ($termek = mysqli_fetch_assoc($termekek)) {

                        while($favs = mysqli_fetch_assoc($favlist)) {
                            
                            if($favs["userid"] === $_SESSION["user"]["id"]) {
 
                                $fav_list_arr[] = $favs["productid"];
                                    if($favs["productid"] === $termek["id"]) {
                                }

                            }
                            
                        }
       
                        foreach($fav_list_arr as $fav) {
                            if($fav === $termek["id"]) {
                                echo $termek["name"].'<br>';
                                echo $termek["description"].'<br>';
                                echo $termek["price"].'<br><br>';
                            }
                        }
                     
                    }

                    if(count($fav_list_arr) === 0) {
                        echo "Üres a kedvencek listád!";
                    }
                    
                    ?>
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

<?php

/* alap
// megjelenés kidolgozása!
$page->favListCheckProcess();
$termekek = mysqli_query($page->connectProcess(), "select * from products");
while ($termek = mysqli_fetch_assoc($termekek)) {
    if(isset($_SESSION["fav_success"])) {
        foreach($_SESSION["fav_success"] as $favs) {
            if($termek["id"] === strval($favs)) {
                echo $termek["name"].'<br>';
                echo $termek["description"].'<br>';
                echo $termek["price"].'<br>';
            }
        }
    }
    
}
if(!isset($_SESSION["fav_success"])) {
    echo 'Üres a kedvencek listád!';
}
*/

?>