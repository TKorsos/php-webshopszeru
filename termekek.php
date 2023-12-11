<?php

session_start();

$val = 0.9;
$_SESSION["week_offer"] = $val;

$t = getdate();
// $t["wday"] -> csere vmi számra teszthez
$_SESSION["today"] = $t["wday"];

// $termek["week_offer"] -> $weekoffer
// $termek["price"] -> $price
// offert majd lehet át kellene nevezni
function offer($weekoffer, $price) {
  if( $_SESSION["today"] === 0 || $_SESSION["today"] === 5 || $_SESSION["today"] === 6 ) {
    return $weekoffer === "1" ? '<div class="text-decoration-line-through text-danger">' . $price . ' Ft</div><div>' . $price * $_SESSION["week_offer"] . ' Ft</div>' : '<div>' . $price . ' Ft</div>';
  }
  else {
    return '<div>' . $price . ' Ft</div>';
  }
}

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

  $connection = mysqli_connect("localhost", "root", "12345", "pcshop");

  $errors = mysqli_error($connection);
  mysqli_set_charset($connection, "utf8mb4");

  if ($errors) {
    echo $errors;
  }

  $termekek = mysqli_query($connection, "select * from products");

  ?>

  <!-- main helye -->
  <main class="container-lg py-5">
    <section class="row row-cols-1 gy-3 py-3">
      <article class="col-auto p-2 mx-auto">
        <h1>Termékek</h1>
      </article>
    </section>

    <!-- teszt -->
    <!-- post helyett get -->
    <form method="get">

      <section class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 gy-3 py-3">
        <?php

        // termék ár * 1 / akció mértéke attól függően van-e ill hogy melyik nap van
        // week_offer
        // melyik napokon legyen akciós
        // season_offer
        // melyik hónap/nap legyen akciós
        // majd ha itt jó a feltétel akkor legyen a többibe is átvive!!!********
        
        while ($termek = mysqli_fetch_array($termekek)) {
          echo '
        <article class="col p-2">
        <div class="card border-card shadow h-100">
          <div class="card-header text-center border-custom">
            <span><strong>Kép helye</strong></span>
          </div>
          <div class="card-body">
            <h5 class="card-title termek-cim">' . $termek["name"] . '</h5>
            <h6 class="fst-italic py-3 name-color">' . $termek["slug"] . '</h6>
            <h6 class="name-color">Leírás</h6>
            <p class="card-text text-color">'.$termek["description"].'</p>
            <hr class="border-custom">
            <h6 class="name-color">Termék ára</h6>
            <p class="card-text text-color">' . ( offer($termek["week_offer"], $termek["price"]) ) . '</p>
            <hr class="border-custom">
          </div>
          <div class="card-footer border-0 d-grid justify-content-center">';
          echo '<a href="termek.php?id=' . $termek["id"] . '" class="btn btn-dark" name="data" value="' . $termek["id"] . '">Megnézem</a>';
          echo '</div>
        </div>
        </article>
        ';
        }
        ?>
      </section>

    </form>

  </main>

  <?php

  ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.bundle.min.js" integrity="sha512-9GacT4119eY3AcosfWtHMsT5JyZudrexyEVzTBWV3viP/YfB9e2pEy3N7WXL3SV6ASXpTU0vzzSxsbfsuUH4sQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="scripts.js"></script>
</body>

</html>