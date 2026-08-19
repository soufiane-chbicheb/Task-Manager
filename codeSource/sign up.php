<?php
ob_start();
include_once("connexion.php");
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title> Sign up</title>

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
      background-image: url('photo/1111.jpg');
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
    input{
      border-radius: 7px;
    }
    
  </style>
</head>
<body>
  
  <div class="container-fluid">
    <div class="row h-100">

      
        <div class="col-md-6 d-flex align-items-center justify-content-center form-section">
            <div class="w-75">
                <h1>Create an Account</h1>
                    <form action="sign up.php" method="POST" id="form">

                        <label for="username">User Name</label>
                        <input type="text" name="username" placeholder="User Name" required id="username" />
                        <div id="usernameError" class="text-danger"></div>

                        

                        <label for="email">Email Address</label>
                        <input type="email" name="email" placeholder="Email address" required id="email"/>
                        <div id="emailError" class="text-danger"></div>

                        <label for="code">Password</label>
                        <input type="password" name="code1" placeholder="Password" required id="code1"/>
                        <div id="code1Error" class="text-danger"></div>

                        <label for="code1">Repeat Password</label>
                        <input type="password" name="code2" placeholder="Repeat password" required id="code2"/>
                        <div id="code2Error" class="text-danger"></div>

                        <div class="mb-3">
                            <input type="checkbox" name="check" class="checkinput" required id="check" />
                            I accept the <a href="conditions.php" target="_blank"><u>Terms & Conditions</u></a>
                        </div>

                        <input type="submit" value="Create Account" name="creer" class="button" id="creer"/>

                        <p class="mt-3">Already have an account?
                            <strong><a href="login.php" target="_blank">Sign in</a></strong>
                        </p>

                    </form>
            </div>
        </div>

      
        <div class="col-md-6 image d-none d-md-block">

          <video autoplay muted loop playsinline style="width: 100%; height: 117%; object-fit: cover;">
          <source src="video/33.mp4" type="video/mp4">
          Your browser does not support the video tag.
          </video>
        </div>

        </div>
    </div>

    <script>

      document.getElementById("form").addEventListener("submit" , function(event){
        document.getElementById("usernameError").textContent = "";
        document.getElementById("emailError").textContent = "" ;
        document.getElementById("code1Error").textContent = "";
        document.getElementById("code2Error").textContent = "";
        //event.preventDefault();

        let hasError = false;

        const username = document.getElementById("username").value.trim();
        const email = document.getElementById("email").value.trim();
        const code1 =document.getElementById("code1").value;
        const code2 = document.getElementById("code2").value;


        const userRegex = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/; 
        if(!userRegex.test(username)){
          document.getElementById("usernameError").textContent = "Invalid user name .";
          hasError = true;
        }
        if(username.length < 4 && username.length>10){
          document.getElementById("usernameError").textContent = "Username must be between 4 and 10 characters long.";
          hasError = true;
        }

        const emailregex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailregex.test(email)){
          document.getElementById("emailError").textContent = "Invalid email address." ;
          hasError = true;
          
        }
        

        if(code1.length < 6){
          document.getElementById("code1Error").textContent = "Password must contain at least 6 characters.";
          hasError = true;
        
        }

        if(code1 !== code2){
          document.getElementById("code2Error").textContent = "Password don't match.";
          hasError = true;
          
        }

        if(hasError ){
          event.preventDefault();
        }

      })

      

    </script>


  <?php

  if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['creer'])){
    if((!empty($_POST['username'])) && (!empty($_POST['email'])) && (!empty($_POST['code1'])) && (!empty($_POST['code2'])) && isset($_POST['check'])){
      $username = htmlspecialchars($_POST['username']);
      $email = htmlspecialchars($_POST['email']);
      $password = htmlspecialchars($_POST['code1']);
      $password = password_hash($password , PASSWORD_DEFAULT );
      $verification_code = rand(100000 , 999999);

      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      $_SESSION['password'] = $password;
      $_SESSION['verification_code'] = $verification_code;



      $sql = "SELECT * FROM users WHERE username = ? AND email = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$username , $email]);
      $users = $stmt->fetch(PDO::FETCH_ASSOC);

      if($users){
        echo "<p> this account already exist !</p>";
      }
      else{
        

        $to = $email;
        $subject = "Account Verification Code";
        $message = "Hello $username,\nYour verification code is: $verification_code";
        $header = "From: TaskManager@gmail.com\r\n ".
                  "Reply-To: TaskManager@gmail.com";

        if(mail($to , $subject , $message , $header)){
          header("location:verification.php");
          exit();
        }      
        else{
          echo "<p> Failed to send verification email. Please try again.</p>";

        }     
      }
    }
  }

    ?>

  <?php
  ob_end_flush(); // ينهي التخزين المؤقت ويطبع الصفحة بعد كل العمليات
  ?>  

    

  






</body>
</html>
