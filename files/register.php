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
    <script>
        // Skrypt uruchamiający się przed załadowaniem zawartości strony
        document.addEventListener("DOMContentLoaded", function () {
            // Ustal tutaj hasło do weryfikacji
            const correctPassword = "LowiskoLipusHasloTymczasowe";
            
            // Wyświetl okienko prompt do wpisania hasła
            let userPassword = prompt("Podaj hasło, aby uzyskać dostęp do rejestracji:");

            // Sprawdź, czy podane hasło jest poprawne
            if (userPassword === correctPassword) {
                // Jeśli hasło jest poprawne, użytkownik otrzymuje dostęp do strony
                alert("Hasło poprawne. Dostęp do rejestracji przyznany.");
            } else {
                // Jeśli hasło jest niepoprawne, użytkownik nie dostanie dostępu
                alert("Nieprawidłowe hasło. Dostęp do strony zablokowany.");
                // Zablokowanie dostępu - przekierowanie użytkownika na inną stronę lub zamknięcie
                window.location.href = "https://example.com"; // Możesz tu wstawić np. stronę główną
            }
        });
    </script>
</head>

<body>
    <div class="h1-div">
        <h1 class="allura-regular" style="text-align: center; font-size: 52pt">
            Rejestracja
        </h1>
        <hr />
        <div class="links">
            <a href="index.html">
                <h3>Strona Glówna</h3>
            </a>
        </div>
    </div>
    <?php include 'notification.php'; ?>

    <div class="register">
        <h1>Rejestracja</h1>
        <hr>
        <form action="register.php" method="POST">
            Nazwa Użytkownika: <input type="text" name="username" id="usernameRegister" required>
            <br>
            Hasło: <input type="password" name="password" id="passwordRegister" required>
            <br>
            Powtórz Hasło: <input type="password" name="repeatPassword" id="repeatPassword" required>
            <br>
            <input type="submit" value="Zarejestruj">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $repeatPassword = $_POST['repeatPassword'];

            // Validate input
            if (empty($username) || empty($password) || empty($repeatPassword)) {
                echo "Wszystkie pola są wymagane.";
            } elseif ($password !== $repeatPassword) {
                echo "Hasła nie są zgodne.";
            } else {
                // Hash the password using bcrypt
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

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
                $stmt = $conn->prepare("INSERT INTO uzytkownicy_administracyjni (_imie, _password) VALUES (?, ?)");
                $stmt->bind_param("ss", $username, $hashedPassword);

                // Execute the query
                if ($stmt->execute()) {
                    // Set a success message
                    setcookie("notification", "Rejestracja zakończona sukcesem.", time() + 10);
                    // Redirect to login page
                    header("Location: login.php");
                    exit();
                } else {
                    echo "Błąd: " . $stmt->error;
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
