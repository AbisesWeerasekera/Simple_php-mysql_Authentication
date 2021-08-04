<?php
include('server.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
</head>
<body>
    

<div class="container">
    <div class="header">
        <h2>Log in</h2>
    </div>

    <form action="login.php" method="post">

<div>
    <label for="username">Username :</label>
    <input type="text" name="username" id="username" required>
</div>



<div>
    <label for="password">Password :</label>
    <input type="password" name="password_1" id="password" required>
</div>





<button type="submit" name="login_user">Log in</button>

<p>Not a User <a href="registration.php"><b>Register here</b></a></p>

    </form>
   
</div>
</body>
</html>