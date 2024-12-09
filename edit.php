<?php
    session_start();
    include("connection_database.php");
    $user_id = $_SESSION['user_id']; // Fetch user_id from session
 
    $computer_id = "";
    $name = "";
    $type = "";
    $operating_system = "";
    $status = "";
 
    $error = "";
    $success = "";
    if ($_SERVER["REQUEST_METHOD"] == 'GET') {
        if (!isset($_GET['computer_id'])) {
            header("Location: main.php");
            exit;
        }
    
        $computer_id = $_GET['computer_id'];
        $sql = "SELECT * FROM computers WHERE computer_id='$computer_id'";
        $result = $conn->query($sql);
    
        if ($result) {
            $row = $result->fetch_assoc();
            if (!$row) {
                header("Location: main.php");
                exit;
            }
    
            $name = $row['name'];
            $type = $row['type'];
            $operating_system = $row['operation_system'];
            $status = $row['status'];
        } else {
            header("Location: main.php");
            exit;
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $computer_id = isset($_POST['computer_id']) ? $_POST['computer_id'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $type = isset($_POST['type']) ? $_POST['type'] : '';
        $operating_system = isset($_POST['operation_system']) ? $_POST['operation_system'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
    
        $sql = "UPDATE computers SET name='$name', type='$type', operation_system='$operating_system', status='$status' WHERE computer_id='$computer_id'";
        $result = $conn->query($sql);
    
        if ($result) {
            $success = "Updated successfully.";
            header("Location: main.php");
            exit;
        } else {
            $error = "Error updating: " . $conn->error;
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Computer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            background-color: #fde700;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #F1C500;
        }
        .error, .success {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Computer</h1>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="computer_id" value="<?php echo htmlspecialchars($computer_id, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label for="type">Type:</label>
                <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label for="operating_system">Operating System:</label>
                <input type="text" id="operation_system" name="operation_system" value="<?php echo htmlspecialchars($operating_system, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="active" <?php echo ($status == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo ($status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn">Update</button>
        </form>
    </div>
</body>
</html>