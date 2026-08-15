<?php
include_once("connexion.php");
session_start();
ob_start();
?>



<?php
$sendError = "";
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset'])){
    if(!empty($_POST['email'])){
        $email = htmlspecialchars($_POST['email']);
        

        $_SESSION['email'] = $email;
        

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt=$conn->prepare($sql);
        $stmt->execute([$email]);
        $users = $stmt->fetch(PDO::FETCH_ASSOC);

        if($users){
            $resetlink = "http://localhost/php/project/change_password.php";
 
            $to = $email;
            $subject = "Password Reset Request";
            $message = "Hello,\n\nClick the link below to reset your password:\n\n $resetlink \n\n";
            $header = "From: taskmanager@gmail.com\r\n".
                      "Reply-To: taskmanaget@gmail.com";

            if(mail($to , $subject , $message , $header)){
                echo"<script>alert('An email with a password reset link has been sent to: {$email}.')</script>";
                
            }           
            else{
                $sendError = "Error sending the email!";
            }
        }
        else{
            $sendError = "This account is not exist!";
        }
    }
    else{
        $sendError = "Enter your email.";
    } 
}    


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Reset password</title>
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
          object-fit: contain;
          filter: brightness(0.5); 
          background-color:black;
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
          height: 280px;
        }


        .card:hover {
          transform: scale(1.05) translateZ(20px);
          box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
        }


        .card input[type="submit"] {
          margin-top: 18px;
          padding: 10px 20px;
          border: none;
          background-color: #007bff;
          color: white;
          border-radius: 8px;
          cursor: pointer;
          transition: background 0.3s;
        }

        .card input[type="submit"]:hover {
          background-color: #0056b3;
        }

        .card input[type="email"] {
          margin-top: 18px;
          padding: 10px 20px;
         
          
          border-radius: 8px;
         
        }
        
    </style>
</head>
<body>

    <video autoplay muted loop id="bg-video">
        <source src="video\t6.mp4" type="video/mp4"/>
    </video>    


    <div class="card-container">
        <div class="card">

            <h1> Forget Your Password?  </h1>
            <h4> Enter your email adress and we will send you instructions to reset your password.  </h4>

            <form action="reset_password.php" method="POST" id="reset">

                <input type="email" name="email" placeholder="Email address" id="email"><br>
                <div id="emailError" style="color:red"></div>
                <p id="sendError" style="color:red"><?php if(!empty($sendError)){echo $sendError;}  ?></p>
                
                
                

                <input type="submit" value="Continue" name="reset" id="reset" class="button"><br>
              
                <p ><strong ><a href="login.php" > Back to log in </a></strong></p>
                
            </form>

        </div>

    </div>
    <script>
        document.getElementById("reset").addEventListener("submit" , function(event){
            document.getElementById("emailError").textContent = "";

            const email = document.getElementById("email").value.trim();
            
            emailregex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(!emailregex.test(email)){
                document.getElementById("emailError").textContent = "Invalid email address.";
                event.preventDefault();
                return;
            }
        })
    </script>
</body>
</html>
        
<?php
ob_end_flush();
?>