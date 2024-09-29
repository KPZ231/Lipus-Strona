<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
} else {
    // Correctly accessing session variable
    setcookie("notification", "Zalogowano Jako: " . $_SESSION['username'], time() + 10);
}

$imagesDir = "images/";
$approvedDir = "approved_images/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve'])) {
        $imageName = basename($_POST['approve']);
        if (file_exists($imagesDir . $imageName)) {
            rename($imagesDir . $imageName, $approvedDir . $imageName);
            setcookie("notification", "Zatwierdzono zdjęcie: " . $imageName, time() + 10);
        }
    } elseif (isset($_POST['delete'])) {
        $imageName = basename($_POST['delete']);
        if (file_exists($imagesDir . $imageName)) {
            unlink($imagesDir . $imageName);
            setcookie("notification", "Usunięto zdjęcie: " . $imageName, time() + 10);
        } elseif (file_exists($approvedDir . $imageName)) {
            unlink($approvedDir . $imageName);
            setcookie("notification", "Usunięto zatwierdzone zdjęcie: " . $imageName, time() + 10);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/icon.png" type="image/x-icon" />
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet" />
    <title>"Lipuś" - Panel Administracyjny</title>
</head>
<body>
    <div class="h1-div">
        <h1 class="allura-regular" style="text-align: center; font-size: 52pt">
            Panel Administracyjny
        </h1>
        <hr />
        <div class="links">
            <a href="index.html">
                <h3>Strona Główna</h3>
            </a>
        </div>
    </div>
    <?php include 'notification.php'; ?>

    <div class="akutalnosciCreator">
        <h2 style="text-align:center; font-family: PT Sans Narrow, sans-serif;">Tworzenie Nowej Akutalności</h2>
        <hr>
        <br>
        <form action="adminpanel.php" method="POST" id="enterAktualnosci">
            <textarea name="enterText" id="enterText" placeholder="Wpisz Zawartość: " required form="enterAktualnosci"></textarea>
            <input type="submit" value="Wyślij" name="wyslij">
        </form>

        <?php
        include  'conn.php';

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        if (isset($_POST['wyslij'])) {
            $textValue = mysqli_real_escape_string($conn, $_POST['enterText']);
            $username = mysqli_real_escape_string($conn, $_SESSION['username']);

            // Fetch the user ID based on the username
            $userIdQuery = "SELECT _id FROM uzytkownicy_administracyjni WHERE _imie = '$username'";
            $result = mysqli_query($conn, $userIdQuery);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $userId = $_SESSION['username'];

                $sql = "INSERT INTO aktualnosci (_value, _uzytkownik_wypychajacy) VALUES ('$textValue', '$userId')";

                if (mysqli_query($conn, $sql)) {
                    setcookie("notification", "Wysłano", time() + 10);
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Error: User not found.";
            }
        }

        mysqli_close($conn);
        ?>
    </div>

    <h2 style="text-align:center; font-family: PT Sans Narrow, sans-serif;">Zatwierdzanie Zdjęć</h2>
    <div class="zdjecia-do-zatwierdzenia">
        <?php
        $images = glob($imagesDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

        foreach ($images as $image) {
            $imageName = basename($image);
            echo '<div class="gallery">';
            echo '<img src="' . $image . '" alt="' . $imageName . '" width="300" height="200">';
            echo '<form action="adminpanel.php" method="POST" style="display:inline-block;">';
            echo '<button type="submit" name="approve" value="' . $imageName . '">Zatwierdź</button>';
            echo '</form>';
            echo '<form action="adminpanel.php" method="POST" style="display:inline-block;">';
            echo '<button type="submit" name="delete" value="' . $imageName . '">Usuń</button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
    </div>

    <h2 style="text-align:center; font-family: PT Sans Narrow, sans-serif;">Zatwierdzone Zdjęcia</h2>
    <div class="zatwierdzone-zdjecia">
        <?php
        $approvedImages = glob($approvedDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

        foreach ($approvedImages as $image) {
            $imageName = basename($image);
            echo '<div class="gallery">';
            echo '<img src="' . $image . '" alt="' . $imageName . '" width="300" height="200">';
            echo '<form action="adminpanel.php" method="POST" style="display:inline-block;">';
            echo '<button type="submit" name="delete" value="' . $imageName . '">Usuń</button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
