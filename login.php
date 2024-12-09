<?php
    session_start();
    include("connection_database.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

    // Kullanıcı adı ve şifreyi veritabanında kontrol et
        $sql = "SELECT * FROM users WHERE username = '$username' AND pword = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            // Giriş başarılı
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['user_id']; // Kullanıcı ID'sini oturumda sakla
            header("Location: main.php"); // Anasayfaya yönlendir
            exit();
        } else {
            echo "Invalid username or password!";
            header("location: login.php");
        }
    }  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
        <form action="login.php" method="post" id="loginForm" onsubmit="return isValid()">
            <h1 class="h3 mb-3 fw-normal">Please log in</h1>

            <div class="form-floating">
                <input type="username" class="form-control" id="username" name="username" placeholder="name@example.com">
                <label for="username">Username</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="password">Password</label>
            </div>

            <button name="submit" class="btn btn-primary w-100 py-2" type="submit">Log in</button>
        </form>
    </main>
    <script>
        function isValid(){
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            if(username ==="" && password ===""){
                alert("Username and password field is empty");
                return false;
            }
            else{
                if(username ===""){
                    alert("Username field is empty");
                    return false;
                }

                if(password ===""){
                    alert("Password field is empty");
                    return false;
                }

            }
            return true; //deneme
        }
    </script>
</body>
</html>