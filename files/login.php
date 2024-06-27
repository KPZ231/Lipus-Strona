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
            Logowanie
        </h1>
        <hr />
        <div class="links">
            <a href="index.html">
                <h3>Strona Glówna</h3>
            </a>
        </div>
    </div>

    <?php include 'notification.php'; ?>


    <div class="login">
        <h1>Logowanie</h1>
        <hr>
        <form action="login.php" method="POST">
            Nazwa Użytkownika: <input type="text" name="username" id="usernameLogin" required>
            <br>
            Hasło: <input type="password" name="password" id="passwordLogin" required>
            <br>
            <input type="submit" value="Zaloguj">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Validate input
            if (empty($username) || empty($password)) {
                echo "Wszystkie pola są wymagane.";
            } else {
                // Database connection
                $servername = "localhost"; // zmień na właściwy serwer
                $dbusername = "root"; // zmień na właściwą nazwę użytkownika
                $dbpassword = ""; // zmień na właściwe hasło
                $dbname = "lipus";

                // Create connection
                $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare and bind
                $stmt = $conn->prepare("SELECT _password FROM uzytkownicy_administracyjni WHERE _imie = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($hashedPassword);
                    $stmt->fetch();

                    // Verify password
                    if (password_verify($password, $hashedPassword)) {
                        // Start a session and set session variables
                        session_start();
                        $_SESSION['username'] = $username;
                        setcookie("username", $username, time() + (86400 * 30), "/"); // Set cookie for 30 days

                        // Set a success message
                        setcookie("notification", "Logowanie zakończone sukcesem.", time() + 10);

                        // Redirect to the admin panel
                        header("Location: adminpanel.php");
                        exit();
                    } else {
                        echo "Nieprawidłowa nazwa użytkownika lub hasło.";
                    }
                } else {
                    echo "Nieprawidłowa nazwa użytkownika lub hasło.";
                }

                // Close connections
                $stmt->close();
                $conn->close();
            }
        }
        ?>
    </div>

</body>

</html>