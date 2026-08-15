<?php
include_once("connexion.php");
session_start();
ob_start();
if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];
    echo $message;
}


?>



<?php
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])){
  if((!empty($_POST['email'])) && (!empty($_POST['code']))){
    $email = htmlspecialchars($_POST['email']);
    $password_input = $_POST['code'];


    $sql = "SELECT * FROM users where email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
      if(password_verify($password_input , $user['password'] )){

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        header("location:dash.php");
        exit();
        
      }
      else{
        $error_message = " Password not correct!";
      }
    }
    else{
      $error_message = "This account does not exist!";
    }
  }
  else{
    $error_message ="Please enter your email and password!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title> Log in</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <style>
    body, html {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    .form-section {
      padding: 40px;
    }

    .form-section h1 {
      margin-bottom: 30px;
    }

    .form-section input[type="text"],
    .form-section input[type="email"],
    .form-section input[type="password"] {
      padding: 4px;
      margin-bottom: 10px;
      width: 100%;
    }

    .checkinput {
      margin-right: 10px;
    }

    /*.image {
      background-image: url('photo/ff.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
    }*/

    .button {
      padding: 10px 25px;
      background-color: #007BFF;
      color: white;
      border: none;
    }

    .button:hover {
      background-color: #0056b3;
    }

    a {
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
    .forget{
      display:flex;
      justify-content: space-evenly;
      align-items: center;
      
    }
    input{
      border-radius: 7px;
    }
  </style>
</head>
<body>
  <header>


  <div class="container-fluid">
    <div class="row h-100">

      
        <div class="col-md-6 d-flex align-items-center justify-content-center form-section">
            <div class="w-75">
                <h1>Sign in</h1>
                <?php if (!empty($error_message)) : ?>
                  <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>  
                    <form action="login.php" method="POST">

                        <label for="email">Email Address</label>
                        <input type="email" name="email" placeholder="Email address" required />

                        <label for="code">Password</label>
                        <input type="password" name="code" placeholder="Password" required />

                        
                        <div class="mb-3">
                            <input type="checkbox" name="remember" class="checkinput"  /> Remember me
                            
                        </div>

                        <input type="submit" value="Sign in now" name="login" class="button" /><br>
                        <br>
                        <div class="forget">
                            <a class="mt-3" href="reset_password.php" target="_blank"><strong>Forget Password?</strong></a>
                            <p class="mt-3">Dont have Account ?<strong><a href="sign up.php"> Sign up</a></strong></p>
                        </div>    

                        
                    </form>
            </div>
        </div>

      
        <div class="col-md-6 image d-none d-md-block">
        <video autoplay muted loop playsinline style="width: 100%; height: 100vh; object-fit: cover; display: block;">
        <source src="video/44.mp4" type="video/mp4">
        </video>

        </div>

        </div>
    </div>


  <!-- Bootstrap JS -->
  <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>-->
  </header>

</body>
</html>



<?php
ob_end_flush();
?>