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

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
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
        <form action="adminpanel.php" method="POST" id="enterAktualnosci">
            <textarea name="enterText" id="enterText" placeholder="Wpisz Zawartość: " required form="enterAktualnosci"></textarea>
            <input type="submit" value="Wyślij" name="wyslij">
        </form>

        <?php
        $conn = mysqli_connect("localhost", "root", "", "lipus");

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
</body>

</html>
