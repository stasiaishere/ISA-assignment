<?php
session_start();
include("connection_database.php");

// Проверка, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
    $sqlu = "SELECT username, photo_path FROM users WHERE user_id = ?";
     $stmt = $conn->prepare($sqlu);
     $stmt->bind_param("i", $user_id);
     $stmt->execute();
     $stmt->bind_result($user_name, $photo_path);  // Kullanıcı adını çekiyoruz
     $stmt->fetch();  // Veriyi alıyoruz
     $stmt->close();  // Sorgu kapatı

// SQL-запрос для получения информации о пользователе и компьютерах
    $sql = "
    SELECT 
        u.username, u.email, c.computer_id, c.name AS computer_name, c.type, c.operation_system, c.status
    FROM users u
    LEFT JOIN users_computers uc ON u.user_id = uc.user_id
    LEFT JOIN computers c ON uc.computer_id = c.computer_id
    WHERE u.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

// Получение первой строки с данными пользователя
    $user_data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
            <?php if ($photo_path): ?>
                    <img src="<?php echo htmlspecialchars($photo_path); ?>" alt="User Photo" width="200" height="200" class="rounded-circle">
            <?php endif; ?>    
            <h1 class="h3">Welcome, <?php echo htmlspecialchars($user_data['username']); ?>!</h1>
                <!-- Дополнительная информация о пользователе -->
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
            </div>
          <a href="logout.php" class="btn btn-danger btn-sm">Log Out</a>
        </div>
        <form action="upload_photo.php" method="POST" enctype="multipart/form-data">
            <!-- <label for="photo">Upload your photo:</label> -->
            <input type="file" name="photo" id="photo" accept="image/*">
            <button type="submit" class="btn btn-primary btn-sm">Upload Image</button>
        </form>

        <div class="card">
            <div class="card-header">
                <h5>Your Computers</h5>
            </div>
            <div class="card-body">
                <?php if ($user_data['computer_id']): ?>
                    <?php do { ?>
                        <div class="computer-card border p-3 mb-3">
                            <h3 class="computer-name"><?= htmlspecialchars($user_data['computer_name']); ?></h3>
                            <p class="computer-type"><strong>Type:</strong> <?= htmlspecialchars($user_data['type']); ?></p>
                            <p class="computer-os"><strong>Operating System:</strong> <?= htmlspecialchars($user_data['operation_system']); ?></p>
                            <p class="computer-status"><strong>Status:</strong> <?= htmlspecialchars($user_data['status']); ?></p>
                            <div class="actions mt-2">
                                <a href="edit.php?computer_id=<?= $user_data['computer_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?computer_id=<?= $user_data['computer_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        </div>
                    <?php } while ($user_data = $result->fetch_assoc()); ?>
                <?php else: ?>
                    <p class="text-muted">No computers found.</p>
                <?php endif; ?>
            </div>
            <div class="container">
                <a href="inserting.php" class="submit btn btn-primary btn-sm">Add</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
