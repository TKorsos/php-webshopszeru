<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>PHP gyakorlás</title>
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <!-- nav helye -->
  <?php

  include("nav.php");

  $termekek = mysqli_query($page->connectProcess(), "select * from products");

  ?>

  <!-- main helye -->
  <main class="container-lg py-5 main-custom-top">
    <?php
      if (isset($_SESSION["alert"])) {
          echo '<section class="row row-cols-1 gy-3 py-3"><article class="col p-2">'.$_SESSION["alert"].'</article></section>';
        }
    ?>
    <section class="row row-cols-1 gy-3 py-3">
      <article class="col-auto p-2 mx-auto text-center">
        <h1>Minden ami számítástechnika</h1>
        <h5>Termékek, szolgáltatások és tanácsadás</h5>
      </article>
    </section>
    
      <section class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 gy-3 py-3">
        <?php

        /*
        - termék ár * 1 / akció mértéke attól függően van-e ill hogy melyik nap van
        - week_offer
        - melyik napokon legyen akciós
        - season_offer
        - melyik hónap/nap legyen akciós
        */
        while ($termek = mysqli_fetch_array($termekek)) {
          echo '
        <article class="col p-2">
          <div class="card border-card h-100 products-card">
            <div class="card-header text-center border-custom">
              <span><strong>Kép helye</strong></span>
            </div>
            <div class="card-body">
              <h5 class="card-title termek-cim">' . $termek["name"] . '</h5>
              <h6 class="fst-italic py-3 name-color">' . $termek["slug"] . '</h6>
              <h6 class="name-color">Leírás</h6>
              <p class="card-text text-color">' . $termek["description"] . '</p>
              <hr class="border-custom-thick">
              <h6 class="name-color">Termék ára</h6>
              <div class="card-text text-color">' . ($page->offer($termek["week_offer"], $termek["price"])) . '</div>
              <hr class="border-custom-thick">
            </div>
            <div class="card-footer border-0 d-grid justify-content-center gap-2">
              <form method="get">
                <a href="?page=termekView&id=' . $termek["id"] . '" class="btn btn-dark w-100" name="data" value="' . $termek["id"] . '">Megnézem</a>
              </form>
              <form action="?page=productCartProcess" method="post">
                <input type="hidden" name="id" value="' . $termek["id"] . '">
                  <button class="btn btn-dark w-100">Kosárba tesz</button> 
              </form>
            </div>
          </div>
        </article>';
        }
        ?>
      </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="./js/scripts.js"></script>
</body>

</html>