<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/login.css">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();
    if(isset($_POST['submit']))
    {
        $username=$_POST['username'];
        $password=$_POST['password'];

        if($username == "123" && $password == "123"){
            $_SESSION['user']=$username;
            header('location:home.php');
            exit();
        }else{
            header('location:index.php');
            exit();
        }
    }
    ?>
    <div class="main">
        <div class="header">AYUsearch Login</div>
        <div class="login-layout">
            <div class="form-login">
                <form action="index.php" method="post">
                    <div class="input-field">
                        <label for="username">Enter Username:</label>
                        <input type="text" name="username" id="username" placeholder="Username">
                    </div>
                    <div class="input-field">
                        <label for="password">Enter Password:</label>
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="input-field btn-field">
                        <button type="submit" name="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>