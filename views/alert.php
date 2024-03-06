<?php

    if (isset($_SESSION["errors"])) {
        echo '<section class="row row-cols-1 gy-3 py-3"><article class="col p-2">' . $_SESSION["errors"] . '</article></section>';
    }

    if (isset($_SESSION["success"])) {
        echo '<section class="row row-cols-1 gy-3 py-3"><article class="col p-2">' . $_SESSION["success"] . '</article></section>';
    }