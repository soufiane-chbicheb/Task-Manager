<?php
include_once("connexion.php");
session_start();

//include_once("sign up.php");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> verification</title>
    <style>
        input{
            padding:6px;
            margin:6px;
            width: 300px;
        }

            
        body, html {
          margin: 0;
          padding: 0;
          height: 100%;
          font-family: Arial, sans-serif;
          overflow: hidden;
        }


        #bg-video {
          position: fixed;
          right: 0;
          bottom: 0;
          min-width: 100%;
          min-height: 100%;
          z-index: -1;
          object-fit: cover;
          filter: brightness(0.5); 
        }


        .card-container {
          display: flex;
          align-items: center;
          justify-content: center;
          height: 100vh;
        }


        .card {
          background: rgba(255, 255, 255, 0.9);
          padding: 50px;
          border-radius: 15px;
          box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
          text-align: center;
          transition: all 0.3s ease;
          transform-style: preserve-3d;
          max-width: 600px;
          width: 85%;
          height: 270px;
        }


        .card:hover {
          transform: scale(1.05) translateZ(20px);
          box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
        }


        .card input[type="submit"] {
          margin-top: 8px;
          padding: 8px 18px;
          border: none;
          background-color: #007bff;
          color: white;
          border-radius: 8px;
          cursor: pointer;
          transition: background 0.3s;
        }

        .card button[type="submit"]:hover {
          background-color: #0056b3;
        }
        .card input[type="number"] {
          margin-top: 8px;
          padding: 8px 18px;
          border-radius: 8px;
        }

    </style>
</head>
<body>
    <?php
    
    if(isset($_SESSION['username']) && isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['verification_code'])){
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];
        $verification_code = $_SESSION['verification_code'];
    }
    else{
        header("location:sign up.php");
        exit();
    }
    
    ?>

    <!--<script>
        alert("A verification code has been sent to your email address.");
    </script>-->
    <video autoplay muted loop id="bg-video">
        <source src="video\t6.mp4" type="video/mp4"/>
    </video>    


    <div class="card-container">
        <div class="card">

            <h1>Enter your verification code </h1>
            <h4>We have sent a verification code to : <?= $_SESSION['email']?> </h4>

            <form action="verification.php" method="POST" id="form_ver">
                <label for="verify"> Please enter the code you received below:</label><br>
                <input type="number" name="verify" placeholder="Code" id="verify"><br>
                <div id="codeError" style="color:red"></div>

                <input type="submit" value="Continue" name="valider" id="valider" class="button"><br>
                <p><strong><a href="verification.php?resend=true" > Resend email</a></strong></p>
                <p>Sent to wrong email ? <a href="sign up.php"> Go back</a></p>
            </form>

        </div>

    </div>
        
    

    
    
    <script>
        document.getElementById("form_ver").addEventListener("submit" , function (event){
            document.getElementById("codeError").textContent = "";
            let code = document.getElementById("verify").value.trim();
            if(code.length != 6){
                document.getElementById("codeError").textContent = "Verification code must contain 6 number.";
                event.preventDefault();
                return;

            }
            
        })
    </script>

    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['valider'])){
        if((!empty($_POST['verify']))){
            $sentcode = $_POST['verify'];

            if($sentcode == $verification_code){

                $sql = "INSERT INTO users (nom_user , email , password) VALUES(? , ? , ? )";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$username , $email , $password]);
                
                echo "<div class='alert alert-success' role='alert'>
                        <strong>Your account has been successfully created.</strong> 
                    </div>";
                
                header("location:login.php");
                exit(); 
                $_SESSION['message'] = "Your account has been successfully created."; 
                ///$_SESSION['username'] = $username;
                ///$_SESSION['email'] = $email;
                ///$_SESSION['password'] =   

            }
            else{
                echo "<p> Verification Code not correct!</p>";
            }
        }
        else{
            echo"<p> Pleade enter the Verification Code!</p>";
        }

    }
    if(isset($_GET['resend']) && $_GET['resend'] == "true"){
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $users = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($users)){
            $to = $email;
            $subject = "Account Verification Code";
            $message = "Hello $username,\nYour verification code is: $verification_code";
            $header = "From: TaskManager@gmail.com\r\n ".
                    "Reply-To: TaskManager@gmail.com";

            if(mail($to , $subject , $message , $header)){

                echo "<div class='alert alert-success' role='alert'>
                           <strong>A verification Code has been sent to your email : $email</strong> 
                      </div>";
                
                echo "<p> Please check your inbox or spam folder.</p>";

                

                $sql = "INSERT INTO users (nom_user , email , password) VALUES(? , ? , ? )";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$username , $email , $password]);
            }    

            
            else{
                echo "<p> Failed to send verification email. Please try again.</p>";
          
                }

        }
        else{
            echo "<p> Your account has already been activated!</p>";
        }
        
        
    }
        
    
    
    
    
    ?>
    
    
</body>
</html>