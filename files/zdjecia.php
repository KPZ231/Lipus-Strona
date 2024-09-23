<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="images/icon.png" type="image/x-icon" />
  <link rel="stylesheet" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Allura&family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet" />

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Łowisko Wędkarskie 'Lipus' - najlepsze miejsce do wędkowania i rekreacji. Sprawdź nasze oferty i zasady." />
  <meta name="keywords" content="łowisko komercyjne, wędkowanie, rekreacja, Lipus, łowienie ryb" />
  <meta name="author" content="KPZsProductions" />
  <meta name="robots" content="index, follow" />
  <meta name="googlebot" content="index, follow" />
  <title>"Lipuś" Regulamin</title>
</head>

<body>

  <?php
  if (isset($_COOKIE["notification"])) {
    echo "<div class='notification'>" . $_COOKIE["notification"] . "</div>";
    setcookie("notification", "", time() - 3600); // Wyczyść ciasteczko powiadomienia
  }
  ?>
  <img src="page_images/icon.png" alt="" width="72" height="72" style="position: absolute; top: 10px;">
  <div class="h1-div">
    <h1 class="allura-regular" style="text-align: center; font-size: 52pt">
      Łowisko Wędkarskie "Lipuś" - Zdjęcia
    </h1>
    <hr />
    <div class="links">
      <a href="index.html">
        <h3>Strona Glówna</h3>
      </a>
      <a href="informacje.html">
        <h3>Informacje</h3>
      </a>
      <a href="regulamin.html">
        <h3>Regulamin</h3>
      </a>
      <a href="aktualnosci.php">
        <h3>Aktualności</h3>
      </a>
      <a href="zdjecia.php">
        <h3>Zdjęcia</h3>
      </a>
    </div>
  </div>

  <h2 style="  font-family: Allura, cursive; text-align:center; font-size: 30pt;">Zdjęcia Z Łowiska</h2>
  <hr style="width: 60%;">
  <div class="zdjeciazlowiska">

    <div class="gallery">
      <a target="_blank" href="">
        <img src="page_images/107487379_165814818323550_5395329337564436489_n.jpg" alt="photo" width="600" height="400">
      </a>
    </div>

    <div class="gallery">
      <a target="_blank" href="">
        <img src="page_images/120235430_187061182865580_6520055962214538930_n.jpg" alt="photo" width="600" height="400">
      </a>
    </div>
    <div class="gallery">
      <a target="_blank" href="">
        <img src="page_images/108153463_166815224890176_3605460376888463576_n.jpg" alt="photo" width="600" height="400">
      </a>
    </div>

    <div class="gallery">
      <a target="_blank" href="">
        <img src="page_images/120275069_187061262865572_4663834638647213924_n.jpg" alt="photo" width="600" height="400">
      </a>
    </div>
  </div>

  <h2 style="font-family: Allura, cursive; text-align:center; font-size: 30pt;">Wasze Zdjęcia</h2>
  <hr style="width: 60%;">
  <form action="upload.php" method="post" enctype="multipart/form-data" style="text-align: center;">
    <label for="fileToUpload" class="custom-file-upload">Wybierz zdjęcie do przesłania: &nbsp;&nbsp;
      <i class="material-icons">cloud_upload</i>
    </label>
    
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Dodaj zdjęcie" name="submit">
  </form>
  <div class="zdjeciazlowiska">
    <?php
    $dir = "approved_images/";
    $images = glob($dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

    foreach ($images as $image) {
      $imageName = basename($image);
      echo '<div class="gallery">';
      echo '<a target="_blank" href="' . $image . '">';
      echo '<img src="' . $image . '" alt="' . $imageName . '" width="600" height="400">';
      echo '</a>';
      echo '</div>';
    }
    ?>
  </div>


  </div>
</body>

</html>