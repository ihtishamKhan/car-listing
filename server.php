<?php
include './conn/index.php';
session_start();

// initializing variables
$name = "";
$email    = "";
$sign_errors = array();
$reg_errors = array();

function hashPassword($password) {
    $options = [
        'cost' => 12,
    ];
    return password_hash($password, PASSWORD_BCRYPT, $options);
}

echo verifyPassword("password", `$2y$12\$Kymhh.JA5w8LUrXmBvprp.U`);

// REGISTER USER
if (isset($_POST['register_user'])) {
  // receive all input values from the form
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($name)) { array_push($reg_errors, "Name is required"); }
  if (empty($email)) { array_push($reg_errors, "Email is required"); }
  if (empty($password)) { array_push($reg_errors, "Password is required"); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['email'] === $email) {
      array_push($reg_errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($reg_errors) == 0) {
  	$password = hashPassword($password);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (name, email, password) 
  			  VALUES('$name', '$email', '$password')";
  	mysqli_query($conn, $query);

    // get user to store in session
    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);


    $_SESSION['user']['id'] = $user['id'];
  	$_SESSION['user']['name'] = $user['name'];

  	header('location: index.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($email)) {
    array_push($sign_errors, "Email is required");
  }
  if (empty($password)) {
    array_push($sign_errors, "Password is required");
  }

  if (count($sign_errors) == 0) {
    $query = "SELECT * FROM users WHERE email='$email'";
    $results = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($results);
    echo 'user', $user['id'];

    // if user exists
    if ($user) {
      // verify password
      if (password_verify($password, $user['password'])) {
        $_SESSION['user']['id'] = $user['id'];
        $_SESSION['user']['name'] = $user['name'];
        header('location: index.php');
      }   else {
        array_push($sign_errors, "Wrong username/password combination");
      }
    } else {
      array_push($sign_errors, "Wrong username/password combinationnnnnnnnn");
    }
  }
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: authentication.php");
}

?>