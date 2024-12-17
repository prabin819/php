<?php

$showAlert = false;
$showError = false;
if($_SERVER['REQUEST_METHOD']=='POST'){

    include 'partials/_dbconnect.php';

    $exists = false;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    //check wheather this username exists
    $existsSql = "select * from users where username='$username'";
    $result = mysqli_query($conn, $existsSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows > 0){
      $exists = true;
    }else{
      $exists = false;
    }

    if(($password == $confirmPassword) && ($exists==false)){
      $hash = password_hash($password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (`username`, `password`, `date`) VALUES ('$username', '$hash', current_timestamp());";
        $result = mysqli_query($conn, $sql);
        if($result){
            $showAlert = true;
            
            // session_start();
            // $_SESSION['loggedin'] = true;
            // $_SESSION['username'] = $username;

            // header("location: welcome.php");
        }
    }
    else{
        if($exists){
          $showError = "Username already taken.";
        }
        else{
          $showError = "passwords do not match.";
        }
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sign up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php
        require 'partials/_nav.php'
    ?>

<?php
if($showAlert){
echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your account is now created and you can now login.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
};
if($showError){
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> '. $showError .'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
};
?>

    <div class="container">
        <h1 class='text-center'>Signup to our website</h1>

        <form action="/cwh/loginsystem/signup.php" method="post">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" maxlength="11">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">ConfirmPassword</label>
    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
    <div id="emailHelp" class="form-text">Make sure to type the same password.</div>

  </div>
  
  <button type="submit" class="btn btn-primary">Signup</button>
</form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>