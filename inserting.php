
<?php
  session_start();
  include("connection_database.php");

  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  // checking the form data
  if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $operation_system = mysqli_real_escape_string($conn, $_POST['operation_system']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO computers (name, type, operation_system, status) VALUES ('$name', '$type', '$operation_system', '$status')";
    if (mysqli_query($conn, $sql)) {
        $computer_id = mysqli_insert_id($conn);
        $sql_relation = "INSERT INTO users_computers (user_id, computer_id) VALUES ('$user_id', '$computer_id')";
        mysqli_query($conn, $sql_relation);
        header("Location: main.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
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
            <h1 class="h3">Welcome, #!</h1>
            <a href="logout.php" class="btn btn-danger btn-sm">Log Out</a>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Adding Computers</h5>
            </div>
            <div class="card-body">
            <form class="inserting" action="inserting.php" method="post">
              <input type="text" name="name" class="computer-name form-control" placeholder="Enter computer name f.e for 'HR' or 'Admin'"><br>
              <textarea name="type" class="computer-type form-control" placeholder="Enter the type of computer f.e laptop, desktop"></textarea><br>
              <input type="text" name="operation_system" class="operation-system form-control" placeholder="Operating system"><br>
              <input type="text" name="status" class="status-computer form-control" placeholder="Active or inactive"> <br>
              <button name="submit" class="btn-submit btn btn-outline-success" type="submit">Save</button>
              <button type="button" class="btn-cancel btn btn-outline-danger" onclick="window.location.href='main.php'">Cancel</button>
</form>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>