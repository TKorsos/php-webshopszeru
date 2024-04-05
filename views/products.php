<!DOCTYPE html>
<html lang="en">

<head>
  <?php
    include("meta.php");

    if(isset($_GET["id"])) {
      $id = $_GET["id"];
    }
    else {
      $id = 1;
    }
  ?>
</head>

<body id="<?php echo $id ?>">
  <!-- nav helye -->
  <?php

  include("nav.php");

  $stepLimit = 5;
  $getId = isset($_GET["id"]) ? $_GET["id"] : 1;
  $start = ($getId - 1) * $stepLimit;

  $termekek = mysqli_query($page->connectProcess(), "select * from products LIMIT $start, $stepLimit");

  ?>

  <!-- main helye -->
  <main class="container-lg py-5 main-custom-top">
    <?php
      include("alert.php");
    ?>
    <section class="row row-cols-1 gy-3 py-3">
      <article class="col-auto p-2 mx-auto text-center rounded-2 bg-light">
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
              <h5 class="card-title">' . $termek["name"] . '</h5>
              <h6 class="fst-italic py-3 name-color">' . $termek["slug"] . '</h6>
              <h6 class="name-color">Leírás</h6>
              <p class="card-text text-color">' . $termek["description"] . '</p>
              <hr class="border-custom-thick">
              <h6 class="name-color">Termék ára</h6>
              <div class="card-text text-color">';
                // érdemes lenne külön fájlba rakni mint pl cart.php és product.php
                $weekArr = $week->offer($termek["week_offer"], $termek["price"]);
                for($i = 0; $i < count($weekArr); $i++) {
                  if(count($weekArr) === 1) {
                    echo '<p>'.$weekArr[$i].' Ft</p>';
                  }
                  else {
                    if($i === 0) {
                      echo '<p class="text-decoration-line-through text-danger">'.$weekArr[$i].' Ft</p>';
                    }
                    else {
                      echo '<p>'.$weekArr[$i].' Ft</p>';
                    }
                  }
                }
              echo '</div>
              <hr class="border-custom-thick">
            </div>
            <div class="card-footer border-0 d-grid justify-content-center gap-2">
              <form method="get">
                <a href="?page=productView&id=' . $termek["id"] . '" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3" name="data" value="' . $termek["id"] . '">
                  <div>Megnézem</div>
                  <i class="bi bi-arrow-right-circle"></i>
                </a>
              </form>
              <form action="?page=productCartProcess&backUrl='.$_SERVER["REQUEST_URI"].'" method="post">
                <input type="hidden" name="id" value="' . $termek["id"] . '">
                <button class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-3">
                  <div>Kosárba tesz</div>
                  <i class="bi bi-cart4"></i>
                </button>
              </form>
            </div>
          </div>
        </article>';
        }
      ?>
    </section>
    <section class="row row-cols-1 gy-3 py-3">
      <article class="col-auto p-2 mx-auto text-center">
        <nav aria-label="Oldalak közti navigálás">
          <ul class="pagination text-center">
            <li class="page-item <?php echo $getId == '1' ? "disabled" : "" ?>"><a class="page-link" href="?page=productsView">Első oldal</a></li>
            <?php
              $pagesDb = mysqli_query($page->connectProcess(), "select * from products");
              $numsPage = mysqli_num_rows($pagesDb);
              $pages = ceil( $numsPage / $stepLimit );

              // oldalak ciklus
              for($i = 1; $i <= $pages; $i++) {
                echo '
                  <li class="page-item"><a class="page-link h-100 d-flex align-items-center" href="?page=productsView&id='.$i.'">'.$i.'</a></li>
                ';
              }
            ?>
            <li class="page-item <?php echo $getId == $pages ? "disabled" : "" ?>"><a class="page-link" href="?page=productsView&id=<?php echo $pages ?>">Utolsó oldal</a></li>
          </ul>
        </nav>
      </article>
    </section>
  </main>

  <?php include("scripts.php") ?>
</body>

</html>