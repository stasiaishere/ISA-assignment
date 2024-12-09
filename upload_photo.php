// upload_photo.php
<?php
session_start();
include("connection_database.php");

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photo'])) {
    $photo = $_FILES['photo'];
    $upload_dir = 'uploads/';
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    if (in_array($photo['type'], $allowed_types)) {
        $file_name = basename($photo['name']);
        $upload_path = $upload_dir . $file_name;

        // Перемещаем файл в папку uploads
        if (move_uploaded_file($photo['tmp_name'], $upload_path)) {
            // Сохраняем путь к файлу в базе данных
            $sql = "UPDATE users SET photo_path = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $upload_path, $user_id);
            $stmt->execute();
            $stmt->close();

            // Перенаправляем обратно на главную страницу
            header("Location: main.php");
            exit;
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type. Only JPG, PNG, and GIF are allowed.";
    }
}
?>
