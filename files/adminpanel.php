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

    <div class="akutalnosciCreator">
        <form action="aktualnosci.php" method="POST">
            <textarea name="enterText" id="enterText" placeholder="Wpisz Zawartość: "></textarea>

        </form>

    </div>

</body>

</html>