<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['approve'])) {
    $image = $_POST['image'];
    $source = "images/" . $image;
    $destination = "approved_images/" . $image;

    if (file_exists($source)) {
        // Create approved_images directory if it doesn't exist
        if (!file_exists('approved_images')) {
            mkdir('approved_images', 0777, true);
        }

        // Move the image to the approved_images directory
        if (rename($source, $destination)) {
            // Append the image to the zdjecia.html
            $file = 'zdjecia.html';
            $current = file_get_contents($file);

            $newImageHTML = '<div class="gallery">
                <a target="_blank" href="' . $destination . '">
                    <img src="' . $destination . '" alt="' . $image . '" width="600" height="400">
                </a>
            </div>';

            // Insert new image HTML before the "Wasze Zdjęcia" section
            $position = strpos($current, '<h2 style="font-family: Allura, cursive; text-align:center; font-size: 30pt;">Wasze Zdjęcia</h2>');
            if ($position !== false) {
                $current = substr_replace($current, $newImageHTML, $position, 0);
            } else {
                $current .= $newImageHTML; // If not found, append to the end
            }

            file_put_contents($file, $current);

            setcookie("notification", "Zdjęcie zostało zatwierdzone.", time() + 10, "/");
        } else {
            setcookie("notification", "Wystąpił błąd podczas zatwierdzania zdjęcia.", time() + 10, "/");
        }
    } else {
        setcookie("notification", "Zdjęcie nie istnieje.", time() + 10, "/");
    }

    header("Location: adminpanel.php");
    exit();
} else {
    header("Location: adminpanel.php");
    exit();
}
