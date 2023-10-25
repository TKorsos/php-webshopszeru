<?php

session_start();
$_SESSION["osszeg"] = 0;

/*
if (isset($_SESSION["user"]) == false) {
  exit('Csak bejelenkezett felhasználók részére!');
}
*/

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>PHP gyakorlás</title>
    <link rel="stylesheet" href="style.css">
</head>

<!--
  fenti tíltás beállítása
-->

<body>
    <!-- nav helye -->
    <?php

    include("nav.php");

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $connection = mysqli_connect("localhost", "root", "12345", "gyakorlas");

    $errors = mysqli_error($connection);
    mysqli_set_charset($connection, "utf8mb4");

    if ($errors) {
        echo $errors;
    }

    $termekek = mysqli_query($connection, "select * from customers limit 10");

    // mind törlése
    if (isset($_POST["torolmind"])) {
        unset($_SESSION["kosar"]);
        header("location: kosar.php");
    }

    ?>

    <!-- main helye -->
    <main class="container-lg py-5">
        <section class="row row-cols-1 gy-3 py-3">
            <article class="col-auto p-2 mx-auto">
                <h1>A kosár taralma</h1>
            </article>
        </section>
        <section class="row row-cols-1 gy-3 py-3">
            <?php
            $penznem = 'Ft';

            echo '<article class="col p-2"><table class="table table-responsive"><tbody>';
            if (isset($_SESSION["kosar"])) {
                // kiíratáson még dolgozni***************
                // darabszám bevezetése**************
                while ($termek = mysqli_fetch_array($termekek)) {
                    $kosar = $_SESSION["kosar"];
                    // $kosar = array_unique($kosartomb);
                    echo '<tr>';

                    // teszt eleje***************** 2023.10.05.
                    /*
                    foreach ($kosar as $id => $tartalom) {
                        // echo '$id: '.$id.'----$tart: '.$tart.'<br>';

                        foreach ($_SESSION["darabszam"] as $key => $darab) {
                            // echo '$key: '.$key.'----$darab: '.$darab.'<br>';

                            if ($id === $key) {

                                if ($termek["customerNumber"] === $tartalom) {

                                    $_SESSION["osszeg"] += $darab * $termek["creditLimit"];
                                    echo '<form method="post"><td>' . $termek["customerName"] . '</td><td>' . $darab . '</td><td>' . $termek["creditLimit"] . '</td><td>' . $penznem . '</td><td><button type="submit" class="btn btn-dark" name="data" value="' . $id . '">Töröl</button></td></form>';
                                }
                            }
                        }
                    }
                    exit;
                    */
                    // teszt vége*****************


                    foreach ($kosar as $key => $tartalom) {

                        //echo '$id: '.$key.'----$tart: '.$tartalom.'<br>';

                        if ($termek["customerNumber"] === $tartalom) {

                            //echo '$id: '.$key.'----$tart: '.$tartalom.'<br>';

                            // darabszám??????????????????
                            // $_SESSION["darabszam"]
                            // $tartalom hányszor fordul elő benne? vagy $kosar-ban?
                            // ciklussal körbefuttatni és feltétel hogy van-e már olyan?

                            // tesztek
                            // teszt eleje***************** 2023.10.05.
                            foreach ($kosar as $id => $tartalom) {
                                // echo '$id: '.$id.'----$tart: '.$tart.'<br>';

                                foreach ($_SESSION["darabszam"] as $key => $darab) {
                                    //echo '$key: '.$key.'----$darab: '.$darab.'<br>';

                                    if ($id === $key) {

                                        //$_SESSION["osszeg"] += $darab * $termek["creditLimit"];

                                        if ($termek["customerNumber"] === $tartalom) {

                                            $_SESSION["osszeg"] += $darab * $termek["creditLimit"];
                                            echo '<form method="post"><td>' . $termek["customerName"] . '</td><td>' . $darab . '</td><td>' . $termek["creditLimit"] . '</td><td>' . $penznem . '</td><td><button type="submit" class="btn btn-dark" name="data" value="' . $id . '">Töröl</button></td></form>';
                                        }

                                    }
                                }

                            }
                            
                            // teszt vége*****************

                            // törlés bekerült ~ 20231004
                            // $_SESSION["osszeg"] += $_SESSION["darabszam"][$key] * $termek["creditLimit"];
                            /*
                            echo '<form method="post"><td>' . $termek["customerName"] . '</td><td>' . $_SESSION["darabszam"][$key] . '</td><td>' . $termek["creditLimit"] . '</td><td>' . $penznem . '</td><td><form method="post"><button type="submit" class="btn btn-dark" name="data" value="' . $key . '">Töröl</button></form></td></form>';
                            */
                            
                        }
                    }

                    echo '</tr>';
                }
            }



            // kiíratáson még dolgozni***************
            echo '<tr>' . ($_SESSION["osszeg"] > 0) ? '<th>A végösszeg: </th><th></th><th>' . $_SESSION["osszeg"] . '.00 </th><th>' . $penznem . '</th>' : '<th> </th>';
            echo '</tr></tbody></table></article><article class="col p-2">';

            // teszt rész ********************
            echo '<hr>';

            echo '<form method="post"><input type="submit" name="torolmind" id="torolmind" value="Mindent töröl"></form></article>';

            ?>
        </section>
    </main>

    <?php

    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.bundle.min.js" integrity="sha512-9GacT4119eY3AcosfWtHMsT5JyZudrexyEVzTBWV3viP/YfB9e2pEy3N7WXL3SV6ASXpTU0vzzSxsbfsuUH4sQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="scripts.js"></script>
</body>

</html>