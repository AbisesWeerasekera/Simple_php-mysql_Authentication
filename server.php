<?php
//Every time you login to a page you are tracked ,that tracking period called a session
session_start();

//initialize variables
$username = '';
$email = '';

//somebody doesn't include their username, then error will print 
$errors = array();

//connection to the db
//mysqli_connect(host name(ip address),username,password,database name) ***Escape all escape characters**
$db = mysqli_connect('localhost', 'root', '', 'practice');
 if(!$db){
     die("Couldn't connect to the database".mysqli_connect_error());
 }

if (isset($_POST['reg_user'])) {
    //Register users
    //mysqli_real_escape_string(database connection variable name,form key value)
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


    //form validations
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "Passwords do not match");
    }


    //check db for existing with the same username and email

    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $results = mysqli_query($db, $user_check_query);
    //fetch a results row as an associative arrays
    $user = mysqli_fetch_assoc($results);

    if ($user) {
        if ($user['username'] == $username) {
            array_push($errors, "Username already exits");
        }
        if ($user['email'] == $email) {
            array_push($errors, "This email id already has a registerd username");
        }
    }

    //Register user if no error has occured

    if (count($errors) == 0) {
        $password = md5($password_1); // this will encrypt the password
        $query = "INSERT INTO users (username, email, password) VALUES ('$username','$email,'$password')";
 

        //fire query to the database
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = 'You are now logged in';

        //Redirect the browser
        header('location: index.php');
    }
}

//Login user

if (isset($_POST['login_user'])) {

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password_1']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }

    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);

        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        //fire query to the database
        $results = mysqli_query($db, $query);
    }

    if (mysqli_num_rows($results)) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "Logged in successfully";
        header('location : index.php');
    } else {
        array_push($errors, "Wrong username and password combination, please try again");
    }
}
