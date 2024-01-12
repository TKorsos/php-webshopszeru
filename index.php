<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>PHP gyakorlás</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- nav helye -->
  <?php

  include("nav.php");

  // 3 termék kiválasztása vmilyen szempont szerint és azok megjelenítése carouselbe
  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  $connection = mysqli_connect("localhost", "root", "12345", "pcshop");

  $error = mysqli_error($connection);
  mysqli_set_charset($connection, "utf8mb4");

  if ($error) {
    echo $error;
  }

  $top_brands = mysqli_query($connection, "select * from products order by price desc");
  $top = [];

  while ($top_brand = mysqli_fetch_assoc($top_brands)) {
    if ($top_brand["top_brand_apple"] == "1") {
      $top[] = $top_brand;
    }
  }

  echo '
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner custom-carousel-inner">';

  // ez a rész nem úgy működik ciklussal ahogy elképzeltem

  echo '<div class="carousel-item custom-carousel-height active" data-bs-interval="5000">
              <div class="custom-carousel-height custom-carousel">
                <h5>' . $top[0]["name"] . '</h5>
                <h6>' . $top[0]["slug"] . '</h6>
                <p>' . $top[0]["description"] . '</p>
                <p>' . $top[0]["price"] . ' Ft</p>
              </div>
            </div>
            <div class="carousel-item custom-carousel-height" data-bs-interval="5000">
              <div class="custom-carousel-height custom-carousel">
                <h5>' . $top[1]["name"] . '</h5>
                <h6>' . $top[1]["slug"] . '</h6>
                <p>' . $top[1]["description"] . '</p>
                <p>' . $top[1]["price"] . ' Ft</p>
              </div>
            </div>
            <div class="carousel-item custom-carousel-height" data-bs-interval="5000">
              <div class="custom-carousel-height custom-carousel">
                <h5>' . $top[2]["name"] . '</h5>
                <h6>' . $top[2]["slug"] . '</h6>
                <p>' . $top[2]["description"] . '</p>
                <p>' . $top[2]["price"] . ' Ft</p>
              </div>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      ';

  // alert megjelenítése
  // mb_strlen() > 0
  if (isset($_SESSION["alert"])) {
    echo $_SESSION["alert"];
  }
  ?>

  <!-- main helye -->
  <main class="container-lg py-5">
    <section class="row row-cols-1 gy-3 py-3">
      <article class="col-auto p-2 mx-auto">
        <h1>Kezdőlap</h1>
      </article>
      <article class="col p-2">
        <p>
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Facilis sint, illum possimus dicta labore iure? Officia illo alias unde sed atque, fuga aut. Iste vel accusantium deleniti eligendi voluptatibus reprehenderit?
        </p>
      </article>
      <article class="col-auto p-2 mx-auto">
        <h2>Heading 2</h2>
      </article>
      <article class="col p-2">
        <p>
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Facilis sint, illum possimus dicta labore iure? Officia illo alias unde sed atque, fuga aut. Iste vel accusantium deleniti eligendi voluptatibus reprehenderit? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Explicabo velit eum cumque impedit illo ad tempora ullam sit sapiente corporis.
        </p>
      </article>
      <article class="col-auto p-2 mx-auto">
        <h3>Heading 3</h3>
      </article>
      <article class="col p-2">
        <p>
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Facilis sint, illum possimus dicta labore iure? Officia illo alias unde sed atque, fuga aut. Iste vel accusantium deleniti eligendi voluptatibus reprehenderit? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusantium quae facere praesentium vitae fugiat ratione.
        </p>
      </article>
    </section>
  </main>

  <?php

  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="scripts.js"></script>
</body>

</html>