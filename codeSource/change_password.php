<?php
include_once("connexion.php");
ob_start();
session_start();
?>
<?php
if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
}

$error = "";
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['new'])){
    if((!empty($_POST['code1'])) && (!empty($_POST['code2']))){
        $password1 = $_POST['code1'];
        $password2 = $_POST['code2'];

        if($password1!== $password2){
          $error = "Password does not match.";
        }
        else{
          $password1 = password_hash($password1 , PASSWORD_DEFAULT);
          
          $sql = "UPDATE users SET password = ? WHERE email = ?";
          $stmt = $conn->prepare($sql);
          $stmt->execute([$password1 , $email]);
          
          header("location:login.php");
          exit();

        }  
            
        }
    else{
      $error = "Please enter new Password";
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

            <h1> Reset Your Password  </h1>
            <h4> Strong password include numbers, letters, and punctuation marks.  </h4>

            <form action="change_password.php" method="POST" id="reset">
              <?php if(!empty($error)){echo "<p style='color:red;'> $error</p>";}?>
                <label for="code1"> Enter new password</label><br>
                <input type="password" name="code1" id="code1" required><br>
                <p id = "code1Error" style="color:red"></p>

                <label for="code2"> Confirm new password</label><br>
                <input type="password" name="code2" id="code2" required><br>
                <p id = "code2Error" style="color:red"></p>

                <input type="submit" value="Reset Password" name="new" class="button"><br>

            </form>

        </div>

    </div>

    <script>
      document.getElementById("reset").addEventListener("submit" , function(event){
        document.getElementById("code1Error").textContent = "";
        document.getElementById("code2Error").textContent = "";
        const password1 = document.getElementById("code1").value;
        const password2 = document.getElementById("code2").value;

        if(password1.length < 6){
          document.getElementById("code1Error").textContent = "Password must contain 6 caracters At least.";
          event.preventDefault();
        }
        if(password1 != password2){
          document.getElementById("code2Error").textContent = "Password not match."
          event.preventDefault();
        }

      })
    </script>
    

</body>
</html>    