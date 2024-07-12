<?php
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$message = "";

// Sprawdź, czy plik jest obrazem
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $message = "Plik jest obrazem - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $message = "Plik nie jest obrazem.";
        $uploadOk = 0;
    }
}

// Sprawdź, czy plik już istnieje
if (file_exists($target_file)) {
    $message = "Przepraszamy, plik już istnieje.";
    $uploadOk = 0;
}

// Sprawdź rozmiar pliku
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $message = "Przepraszamy, twój plik jest za duży.";
    $uploadOk = 0;
}

// Zezwalaj tylko na określone formaty plików
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    $message = "Przepraszamy, dozwolone są tylko pliki JPG, JPEG, PNG i GIF.";
    $uploadOk = 0;
}

// Sprawdź, czy $uploadOk jest ustawiony na 0 przez błąd
if ($uploadOk == 0) {
    $message = "Przepraszamy, twój plik nie został przesłany.";
// Jeśli wszystko jest w porządku, spróbuj przesłać plik
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "Plik ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " został przesłany.";
    } else {
        $message = "Przepraszamy, wystąpił błąd podczas przesyłania pliku.";
    }
}

setcookie("notification", $message, time() + 3600, "/"); // Ustaw ciasteczko powiadomienia
header("Location: zdjecia.php"); // Przekieruj z powrotem na stronę z kodem HTML
exit();
?>
