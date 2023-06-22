<?php
session_start();

if( isset($_SESSION["login"]) ){
    header("Location: index.php");
    exit;
}

require 'functions.php';

if( isset($_POST["login"]) ){

    $username = $_POST["username"];
    $password = $_POST["password"];

   $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    //cek username
    if(mysqli_num_rows($result) === 1 ){
        
        //cek password
        $row = mysqli_fetch_assoc($result);
        if( password_verify($password, $row["password"]) ) {

            //set session 
            $_SESSION["login"] = true;
            header("Location: index.php");
            exit;
        }
    }

    $error = true;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login</title>

    <!-- Bootstrap CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.rtl.min.css">


<!-- Bootstrap Icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

<link rel="stylesheet" href="style.css">

</head>
<body>

<div class="global-container">
    <div class="card login-form">

    <div class="card-body">
         <h1 class="card-title text-center">L O G I N</h1>
    </div>

    <div class="card-text">

    <?php if( isset($error) ) : ?>
    
        <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle"> Username atau Password Salah!</i> 
         </div>
      

    <?php endif; ?>

    <form action="" method="post">
    
            
                <div class="mb-3">
                    <label for="username">Username </label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>

                <div class="mb-3"> 
                    <label for="password">Password </label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="mb-3 form-check">
                    <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                </div>

                <div class="d-grid gap-2">
                   <button type="submit" name="login" class="btn btn-primary">Login</button>
                </div>
                    
            
            

    </form>

    
    </div>
</div>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>