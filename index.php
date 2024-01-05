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