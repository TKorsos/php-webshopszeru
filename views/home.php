<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("meta.php") ?>
</head>

<body>
  <!-- nav helye -->
  <?php

  include("nav.php");

  echo '
    <div id="carouselTopMain" class="carousel slide custom-top-carousel" data-bs-ride="carousel">
      <div class="carousel-indicators">';
           
        $top_brand_main = mysqli_query($page->connectProcess(), "select * from products order by price desc");
        $i = 0;
        while ($top_brand = mysqli_fetch_assoc($top_brand_main)) {
          if ($top_brand["main_signed"] == "1") {
            if ($i === 0) {
              $activeClass = "active";
            } else {
              $activeClass = "";
            }
            echo '<button type="button" data-bs-target="#carouselTopMain" data-bs-slide-to="' . $i . '" class="' . $activeClass . '" aria-current="true" aria-label="Slide ' . ($i + 1) . '"></button>';
            $i += 1;
          }
        }
             
  echo '</div>
        <div class="carousel-inner custom-carousel-inner">';
           
        $top_brand_main = mysqli_query($page->connectProcess(), "select * from products order by price desc");
        $i = 0;
        while ($top_brand = mysqli_fetch_assoc($top_brand_main)) {
          if ($top_brand["main_signed"] == "1") {
            if ($i === 0) {
              $activeClass = "active";
            } else {
              $activeClass = "";
            }
            echo '<div class="carousel-item custom-carousel-height ' . $activeClass . '" data-bs-interval="5000">
                    <div class="custom-carousel-height custom-carousel">
                      <h5>' . $top_brand["name"] . '</h5>
                      <h6>' . $top_brand["slug"] . '</h6>
                      <p class="w-75">' . $top_brand["description"] . '</p>
                      <p>' . $top_brand["price"] . ' Ft</p>
                      <div class="card-footer border-0 d-grid justify-content-center">
                        <a href="?page=termekView&id=' . $top_brand["id"] . '" class="btn btn-dark d-flex justify-content-center align-items-center gap-3" name="data" value="' . $top_brand["id"] . '">
                          <div>Megnézem</div>
                          <i class="bi bi-arrow-right-circle"></i>
                        </a>
                      </div>
                    </div>
                  </div>';
            $i += 1;
          }
        }
    
  echo '</div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselTopMain" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselTopMain" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
      </div>';
  ?>

  <!-- main helye -->
  <main class="container-lg py-5">
    <?php
      include("alert.php");
    ?>
    <section class="row row-cols-1 gy-3 py-3 bg-danger">
      <article class="col p-2">
        <h2>Hétvégi akciók!</h2>
        <h4>Ezen a hétvégén különgleges ajánlatunk van: 10% kedvezmény a kiválasztott termékeinkre!</h4>
      </article>
      <article class="col p-2">
        <?php
        $termekekAkcio2 = mysqli_query($page->connectProcess(), "select * from products");
        ?>
        <div class="container-lg">
          <section class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 gy-3 py-3">
            <?php
            while ($termek = mysqli_fetch_array($termekekAkcio2)) {
              if ($termek["week_offer"] === "1") {
                echo '
                    <article class="col p-2">
                      <div class="card border-card h-100 card-border-anim">
                        <div class="card-inner">
                          <div class="card-header text-center border-custom">
                            <span><strong>Kép helye</strong></span>
                          </div>
                          <div class="card-body">
                            <h5 class="card-title termek-cim">' . $termek["name"] . '</h5>
                            <h6 class="name-color">Leírás</h6>
                            <p class="card-text text-color">' . $termek["description"] . '</p>
                          </div>
                        </div>
                      </div>
                    </article>';
              }
            }
            ?>
          </section>
        </div>
      </article>
      <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
        <a href="?page=termekekView" class="btn btn-dark d-flex justify-content-center align-items-center gap-3">
          <div>Tovább a teljes listához</div>
          <i class="bi bi-arrow-right-circle"></i>
        </a>
      </article>
    </section>
    <form method="get">
      <!-- asus -->
      <section class="row row-cols-1 gy-3 py-3">
        <article class="col-auto p-2">
          <h2 class="p-2 rounded-2 bg-light">Top Asus termékeink</h2>
        </article>
        <article class="col p-2">
          <div id="carouselTopAsus" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">

              <?php
              $top_brand_asus = mysqli_query($page->connectProcess(), "select * from products order by price desc");
              $i = 0;
              while ($top_brand = mysqli_fetch_assoc($top_brand_asus)) {
                if ($top_brand["top_brand_asus"] == "1") {
                  if ($i === 0) {
                    $activeClass = "active";
                  } else {
                    $activeClass = "";
                  }
                  echo '<button type="button" data-bs-target="#carouselTopAsus" data-bs-slide-to="' . $i . '" class="' . $activeClass . '" aria-current="true" aria-label="Slide ' . ($i + 1) . '"></button>';
                  $i += 1;
                }
              }
              ?>

            </div>
            <div class="carousel-inner custom-carousel-inner">

              <?php
              $top_brand_asus = mysqli_query($page->connectProcess(), "select * from products order by price desc");
              $i = 0;
              while ($top_brand = mysqli_fetch_assoc($top_brand_asus)) {
                if ($top_brand["top_brand_asus"] == "1") {
                  if ($i === 0) {
                    $activeClass = "active";
                  } else {
                    $activeClass = "";
                  }
                  echo '<div class="carousel-item custom-carousel-height ' . $activeClass . '" data-bs-interval="5000">
                          <div class="custom-carousel-height custom-carousel">
                            <h5>' . $top_brand["name"] . '</h5>
                            <h6>' . $top_brand["slug"] . '</h6>
                            <p>' . $top_brand["description"] . '</p>
                            <p>' . $top_brand["price"] . ' Ft</p>
                            <div class="card-footer border-0 d-grid justify-content-center">
                              <a href="?page=termekView&id=' . $top_brand["id"] . '" class="btn btn-dark d-flex justify-content-center align-items-center gap-3" name="data" value="' . $top_brand["id"] . '">
                                <div>Megnézem</div>
                                <i class="bi bi-arrow-right-circle"></i>
                              </a>
                            </div>
                          </div>
                        </div>';
                  $i += 1;
                }
              }
              ?>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselTopAsus" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselTopAsus" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </article>
        <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3 p-2">
          <a href="?page=termekekView" class="btn btn-dark d-flex justify-content-center align-items-center gap-3">
            <div>Tovább a teljes listához</div>
            <i class="bi bi-arrow-right-circle"></i>
          </a>
        </article>
      </section>
      <!-- dell -->
      <section class="row row-cols-1 gy-3 py-3">
        <article class="col-auto p-2">
          <h2 class="p-2 rounded-2 bg-light">Top Dell termékeink</h2>
        </article>
        <article class="col p-2">
          <div id="carouselTopDell" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">

              <?php
              $top_brand_dell = mysqli_query($page->connectProcess(), "select * from products order by price desc");
              $i = 0;
              while ($top_brand = mysqli_fetch_assoc($top_brand_dell)) {
                if ($top_brand["top_brand_dell"] == "1") {
                  if ($i === 0) {
                    $activeClass = "active";
                  } else {
                    $activeClass = "";
                  }
                  echo '<button type="button" data-bs-target="#carouselTopDell" data-bs-slide-to="' . $i . '" class="' . $activeClass . '" aria-current="true" aria-label="Slide ' . ($i + 1) . '"></button>';
                  $i += 1;
                }
              }
              ?>

            </div>
            <div class="carousel-inner custom-carousel-inner">

              <?php
              $top_brand_dell = mysqli_query($page->connectProcess(), "select * from products order by price desc");
              $i = 0;
              while ($top_brand = mysqli_fetch_assoc($top_brand_dell)) {
                if ($top_brand["top_brand_dell"] == "1") {
                  if ($i === 0) {
                    $activeClass = "active";
                  } else {
                    $activeClass = "";
                  }
                  echo '<div class="carousel-item custom-carousel-height ' . $activeClass . '" data-bs-interval="5000">
                          <div class="custom-carousel-height custom-carousel">
                            <h5>' . $top_brand["name"] . '</h5>
                            <h6>' . $top_brand["slug"] . '</h6>
                            <p>' . $top_brand["description"] . '</p>
                            <p>' . $top_brand["price"] . ' Ft</p>
                            <div class="card-footer border-0 d-grid justify-content-center">
                              <a href="?page=termekView&id=' . $top_brand["id"] . '" class="btn btn-dark d-flex justify-content-center align-items-center gap-3" name="data" value="' . $top_brand["id"] . '">
                                <div>Megnézem</div>
                                <i class="bi bi-arrow-right-circle"></i>
                              </a>
                            </div>
                          </div>
                        </div>';
                  $i += 1;
                }
              }
              ?>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselTopDell" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselTopDell" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </article>
        <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3 p-2">
          <a href="?page=termekekView" class="btn btn-dark d-flex justify-content-center align-items-center gap-3">
            <div>Tovább a teljes listához</div>
            <i class="bi bi-arrow-right-circle"></i>
          </a>
        </article>
      </section>
      <!-- hp -->
      <section class="row row-cols-1 gy-3 py-3">
        <article class="col-auto p-2">
          <h2 class="p-2 rounded-2 bg-light">Top HP termékeink</h2>
        </article>
        <article class="col p-2">
          <div id="carouselTopHp" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">

              <?php
              $top_brand_hp = mysqli_query($page->connectProcess(), "select * from products order by price desc");
              $i = 0;
              while ($top_brand = mysqli_fetch_assoc($top_brand_hp)) {
                if ($top_brand["top_brand_hp"] == "1") {
                  if ($i === 0) {
                    $activeClass = "active";
                  } else {
                    $activeClass = "";
                  }
                  echo '<button type="button" data-bs-target="#carouselTopHp" data-bs-slide-to="' . $i . '" class="' . $activeClass . '" aria-current="true" aria-label="Slide ' . ($i + 1) . '"></button>';
                  $i += 1;
                }
              }
              ?>

            </div>
            <div class="carousel-inner custom-carousel-inner">

              <?php
              $top_brand_hp = mysqli_query($page->connectProcess(), "select * from products order by price desc");
              $i = 0;
              while ($top_brand = mysqli_fetch_assoc($top_brand_hp)) {
                if ($top_brand["top_brand_hp"] == "1") {
                  if ($i === 0) {
                    $activeClass = "active";
                  } else {
                    $activeClass = "";
                  }
                  echo '<div class="carousel-item custom-carousel-height ' . $activeClass . '" data-bs-interval="5000">
                          <div class="custom-carousel-height custom-carousel">
                            <h5>' . $top_brand["name"] . '</h5>
                            <h6>' . $top_brand["slug"] . '</h6>
                            <p>' . $top_brand["description"] . '</p>
                            <p>' . $top_brand["price"] . ' Ft</p>
                            <div class="card-footer border-0 d-grid justify-content-center">
                              <a href="?page=termekView&id=' . $top_brand["id"] . '" class="btn btn-dark d-flex justify-content-center align-items-center gap-3" name="data" value="' . $top_brand["id"] . '">
                                <div>Megnézem</div>
                                <i class="bi bi-arrow-right-circle"></i>
                              </a>
                            </div>
                          </div>
                        </div>';
                  $i += 1;
                }
              }
              ?>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselTopHp" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselTopHp" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </article>
        <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3 p-2">
          <a href="?page=termekekView" class="btn btn-dark d-flex justify-content-center align-items-center gap-3">
            <div>Tovább a teljes listához</div>
            <i class="bi bi-arrow-right-circle"></i>
          </a>
        </article>
      </section>
      <!-- lenovo -->
      <section class="row row-cols-1 gy-3 py-3">
        <article class="col-auto p-2">
          <h2 class="p-2 rounded-2 bg-light">Top Lenovo termékeink</h2>
        </article>
        <article class="col p-2">
          <div id="carouselTopLenovo" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">

              <?php
              $top_brand_lenovo = mysqli_query($page->connectProcess(), "select * from products order by price desc");
              $i = 0;
              while ($top_brand = mysqli_fetch_assoc($top_brand_lenovo)) {
                if ($top_brand["top_brand_lenovo"] == "1") {
                  if ($i === 0) {
                    $activeClass = "active";
                  } else {
                    $activeClass = "";
                  }
                  echo '<button type="button" data-bs-target="#carouselTopLenovo" data-bs-slide-to="' . $i . '" class="' . $activeClass . '" aria-current="true" aria-label="Slide ' . ($i + 1) . '"></button>';
                  $i += 1;
                }
              }
              ?>

            </div>
            <div class="carousel-inner custom-carousel-inner">

              <?php
              $top_brand_lenovo = mysqli_query($page->connectProcess(), "select * from products order by price desc");
              $i = 0;
              while ($top_brand = mysqli_fetch_assoc($top_brand_lenovo)) {
                if ($top_brand["top_brand_lenovo"] == "1") {
                  if ($i === 0) {
                    $activeClass = "active";
                  } else {
                    $activeClass = "";
                  }
                  echo '<div class="carousel-item custom-carousel-height ' . $activeClass . '" data-bs-interval="5000">
                          <div class="custom-carousel-height custom-carousel">
                            <h5>' . $top_brand["name"] . '</h5>
                            <h6>' . $top_brand["slug"] . '</h6>
                            <p>' . $top_brand["description"] . '</p>
                            <p>' . $top_brand["price"] . ' Ft</p>
                            <div class="card-footer border-0 d-grid justify-content-center">
                              <a href="?page=termekView&id=' . $top_brand["id"] . '" class="btn btn-dark d-flex justify-content-center align-items-center gap-3" name="data" value="' . $top_brand["id"] . '">
                                <div>Megnézem</div>
                                <i class="bi bi-arrow-right-circle"></i>
                              </a>
                            </div>
                          </div>
                        </div>';
                  $i += 1;
                }
              }
              ?>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselTopLenovo" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselTopLenovo" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </article>
        <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3 p-2">
          <a href="?page=termekekView" class="btn btn-dark d-flex justify-content-center align-items-center gap-3">
            <div>Tovább a teljes listához</div>
            <i class="bi bi-arrow-right-circle"></i>
          </a>
        </article>
      </section>
      <!-- apple -->
      <section class="row row-cols-1 gy-3 py-3">
        <article class="col-auto p-2">
          <h2 class="p-2 rounded-2 bg-light">Top Apple termékeink</h2>
        </article>
        <article class="col p-2">
          <div id="carouselTopApple" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">

              <?php
              $top_brand_apple = mysqli_query($page->connectProcess(), "select * from products order by price desc");
              $i = 0;
              while ($top_brand = mysqli_fetch_assoc($top_brand_apple)) {
                if ($top_brand["top_brand_apple"] == "1") {
                  if ($i === 0) {
                    $activeClass = "active";
                  } else {
                    $activeClass = "";
                  }
                  echo '<button type="button" data-bs-target="#carouselTopApple" data-bs-slide-to="' . $i . '" class="' . $activeClass . '" aria-current="true" aria-label="Slide ' . ($i + 1) . '"></button>';
                  $i += 1;
                }
              }
              ?>

            </div>
            <div class="carousel-inner custom-carousel-inner">

              <?php
              $top_brand_apple = mysqli_query($page->connectProcess(), "select * from products order by price desc");
              $i = 0;
              while ($top_brand = mysqli_fetch_assoc($top_brand_apple)) {
                if ($top_brand["top_brand_apple"] == "1") {
                  if ($i === 0) {
                    $activeClass = "active";
                  } else {
                    $activeClass = "";
                  }
                  echo '<div class="carousel-item custom-carousel-height ' . $activeClass . '" data-bs-interval="5000">
                          <div class="custom-carousel-height custom-carousel">
                            <h5>' . $top_brand["name"] . '</h5>
                            <h6>' . $top_brand["slug"] . '</h6>
                            <p>' . $top_brand["description"] . '</p>
                            <p>' . $top_brand["price"] . ' Ft</p>
                            <div class="card-footer border-0 d-grid justify-content-center">
                              <a href="?page=termekView&id=' . $top_brand["id"] . '" class="btn btn-dark d-flex justify-content-center align-items-center gap-3" name="data" value="' . $top_brand["id"] . '">
                                <div>Megnézem</div>
                                <i class="bi bi-arrow-right-circle"></i>
                              </a>
                            </div>
                          </div>
                        </div>';
                  $i += 1;
                }
              }
              ?>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselTopApple" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselTopApple" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </article>
        <article class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3 p-2">
          <a href="?page=termekekView" class="btn btn-dark d-flex justify-content-center align-items-center gap-3">
            <div>Tovább a teljes listához</div>
            <i class="bi bi-arrow-right-circle"></i>
          </a>
        </article>
      </section>
    </form>
    <section class="row row-cols-1 gy-3 py-3">
      <article class="col-auto p-2 mx-auto">
        <h2>Elérhetőségünk</h2>
      </article>
      <article class="col p-2 contact-main">
        <ul class="contact-list">
          <li>+36121231234</li>
          <li>admin@info.hu</li>
          <li>PC Shop</li>
        </ul>
      </article>
    </section>
  </main>

  <?php include("scripts.php") ?>
</body>

</html>