<?php
session_start(); // Upewnij się, że sesja jest rozpoczęta
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/icon.png" type="image/x-icon" />
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet" />

    <meta name="description" content="Łowisko Wędkarskie 'Lipus' - najlepsze miejsce do wędkowania i rekreacji. Sprawdź nasze oferty i zasady." />
    <meta name="keywords" content="łowisko komercyjne, wędkowanie, rekreacja, Lipus, łowienie ryb" />
    <meta name="author" content="KPZsProductions" />
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow" />
    <title>Lipuś - Aktualności</title>

    <script>
        function deleteAktualnosc(id) {
            if (confirm('Czy na pewno chcesz usunąć tę aktualność?')) {
                fetch('delete_aktualnosc.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Reload page after successful deletion
                        } else {
                            alert('Błąd przy usuwaniu aktualności.');
                        }
                    });
            }
        }
    </script>
</head>

<body>
    <div class="h1-div">
        <h1 class="allura-regular" style="text-align: center; font-size: 49pt">
            Łowisko Wędkarskie "Lipuś" - Aktualności
        </h1>
        <hr />
        <div class="links">
            <a href="index.html">
                <h3>Strona Główna</h3>
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
            <a href="">
                <h3>Zdjęcia</h3>
            </a>
        </div>
    </div>

    <div class="akutalnosciContainer">
        <?php
        $conn = mysqli_connect("localhost", "root", "", "lipus");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = mysqli_query($conn, "SELECT _id, _value, _uzytkownik_wypychajacy FROM aktualnosci");

        if (mysqli_num_rows($sql) == 0) {
            echo "Niestety nie ma jeszcze żadnych aktualności :(";
        } else {
            // Fetch and display each row
            while ($res = mysqli_fetch_row($sql)) {
                echo '<div class="akutalnosc">';
                echo '<h3>' . htmlspecialchars($res[1], ENT_QUOTES, 'UTF-8') . '</h3>';
                echo '<h2>Dodane Przez: ' . htmlspecialchars($res[2], ENT_QUOTES, 'UTF-8') . '</h2>';
                
                // Display delete button if session is set
                if (isset($_SESSION['username'])) {
                    echo '<button onclick="deleteAktualnosc(' . $res[0] . ')">Usuń Aktualność</button>';
                }
                
                echo '</div>';
            }
        }

        mysqli_close($conn);

        ?>
    </div>

</body>

</html>