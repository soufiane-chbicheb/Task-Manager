<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
    box-sizing: border-box;
    padding: 0;
    margin: 0;

}
html{
    scroll-behavior: smooth;
}
body,html{
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100vh;  
    font-family: sans-serif;
    
}
body{
    width: 100%;
    height: 100%;
    
    position: relative;
    background-image: url(back1.img.jpg);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    text-align: center;
    justify-content: center;
    animation: change 40s infinite ease-in-out ;
    font-family: Arial, sans-serif; 
    background-attachment: fixed;
    background-color: rgb(0, 0, 0,0.4);
    
}
/*.content{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    text-transform: uppercase;
}
 .content a{
    background: rgb(135, 157, 161);
    padding: 10px 24px;
    text-decoration: none;
    font-size: 18px;
    border-radius: 20px;
}
.content a:hover{
    background: rgb(191, 177, 177);
    color: rgb(29, 95, 142);

} */
 .navbar{
     color: white;
     display: flex;
     align-items: center;
     justify-content: space-between;
     padding: 15px 20px;
     position: relative;
     text-align: right;
     background-color: rgb(0, 0, 0,0.4);
        z-index: 1000;
        border-radius: 0 0 20px 20px;
        border: white solid 1px;
}
.logo{
    font-size: 1.5rem;
    font-weight: bold;
}
.navlinks{
    list-style: none;
    display: flex;
    gap: 20px;
    border: solid 1px white;
    border-radius: 25px;
    padding: 10px 50px 10px 50px;
    background-color: rgb(0, 0, 0,0.5);
}
.boten:hover{
    color: rgb(13, 0, 255);
}
.navlinks li a{
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    
}
.navlinks li a:hover{
    color: gray;
}
.mumuicon{
    display: none;
    font-size: 1.8rem;
    cursor: pointer ;    
}

#munut{
    display: none;
}
@media(max-width:768px){
    
}
@keyframes change{
    0%
    {
        background-image: url(home/1.jpeg);
    }
    25%
    {
        background-image: url(home/2.jpeg);
    }
    50%
    {
        background-image: url(home/14.jpg);
    }
    75%
    {
        background-image: url(home/21.jpg);
    }
    100%
    {
        background-image: url(home/1.jpeg);
    }
}
.card div{
   border: solid 1px white;
   justify-content: space-between;
   padding: 25px;
   margin: 20px;
   width: 200px;
   height:200px;
   background-color: white;
   box-sizing: border-box;
   color: black;
   border-radius: 25px;
   transition: 1s;
}
.card{
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    flex-wrap: wrap;
    margin-top: 300px;
    
}

h3{
    font-family: italic;
}
h1{
    font-size: 50px;
    font-family: 'Courier New', Courier, monospace;
    color: wblack;
    color: aqua;
}
h2{
    color:aqua;
    margin-top: 300px;
}
h4{
    color: blue;
}
.t{
    color: white;
    margin-top: 170px;
}
.click{
    background-color: blue;
    width: 200px;
    height: 50px;
    border: solid 1px blue;
    border-radius: 33px; 
    color: white;
    font-size: 18px;
    margin:10px ;
    margin-top: 40px;
}
.click:hover{
     background-color:#007BFF ;
     color: white;
}
.card div:hover{
    
    transform: scale(1.1);
    box-shadow: 0 0 20px rgba(0,0,0,0.2);
    transition: transform 0.6s ease, box-shadow 0.3s ease;
  
}

    .footer a {
      color: #bbb;
      text-decoration: none;
      margin: 0 10px;
      transition: color 0.3s;
    }

    .footer a:hover {
      color: #fff;
    }

    .footer .social-icons {
      margin-top: 20px;
    }

    .footer .social-icons i {
      font-size: 20px;
      margin: 0 10px;
      cursor: pointer;
    }

    .footer p {
      margin-top: 20px;
      font-size: 14px;
      color: #888;
    }
  .footer {
      background-color: #222;
      color: #fff;
      padding: 40px 20px;
      text-align: center;
      margin-top: 400px;
    }

    .footer h3 {
      margin-bottom: 15px;
    }
 .comments-box {
      width: 400px;
      height: 100px;
      overflow: hidden;
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      position: relative;
      margin-left: 375px;
      margin-top: 80px;
      
    }
    

    .comments-slider {
      display: flex;
      flex-direction: column;
      animation: slideComments 12s infinite;
      position: absolute;
      top: 0;
      left: 0;
      
    }

    .comment {
      width: 100%;
      min-height: 100px;
      padding: 20px;
      box-sizing: border-box;
      direction: rtl; /* To animate right to left visually */
      transform: translateX(100%);
      animation: slideIn 6s forwards;
   }

    /* Keyframe for vertical sliding (comment by comment) */
    @keyframes slideComments {
      0%   { transform: translateY(0); }
      33%  { transform: translateY(-100px); }
      66%  { transform: translateY(-200px); }
      100% { transform: translateY(0); }
    }

    /* Optional: slide in each comment from right */
    @keyframes slideIn {
      from { transform: translateX(100%); opacity: 0; }
      to   { transform: translateX(0); opacity: 1; }
    }

    .comment strong {
      color: gainsboro;
      display: block;
      margin-bottom: 5px;

    }

    .comment p {
      margin: 0;
    }
    .cc{
        color: black;
         

    }
   .pot{
        color: white;
        font-size: 20px;
        margin-top: 20px;
        margin-left: 20px;
    }
    .pot:hover{
        color: blue;
    }
    .pot a{
        text-decoration: none;
        color: white;
    }
    .pot a:hover{
        color: blue;
    }
      
   
  
    </style>
     <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    </head>
<body>
 <div class="container">
    <nav class="navbar">
        <div class="logo">Task Manager</div>
        <input type="checkbox"  id="munut">
        <label for="munut" class="munuicon"></label>
        <!-- linking -->
        <ul class="navlinks">
            <li><a href="http://localhost/php/project/home.php">home</a></li>
            <li><a href="http://localhost/php/project/dashboard.php">dashboard</a></li>
            <li><a href="http://localhost/php/project/about.php">about us</a></li>
            <li  class="boten" ><a href="http://localhost/php/project/sign up.php">sing up</a></li> <!-- here -->
        </ul>
    </nav>
  <div class="t">
    <h1>Task Manager</h1>
    <br>
        <h3>the ultimate task management solution</h3>
    
  </div>

  <div class="card">
      <div class="intercard">
          <h4>Step 1</h4><br>
          <p>create your account by poviding your details</p>
      </div >
      <div class="intercard">
          <h4>Step 2</h4><br>
<p>receive a verification code to confirm your account</p>
      </div>
      <div class="intercard" >
          <h4>Step 3</h4><br>
<p><strong>start managing</strong> your task efficiently with mession Manager</p>
      </div>
     
      
  </div>
  <!-- linking -->
  <div class="btn">
    <input class="click" onclick='window.location.href="http://localhost/php/project/sign%20up.php";' type="submit" value="Sign up">
    

</div>

 </div>
 <h2 >Review</h2>
 <div class="comments-box">
    <div class="comments-slider">
      <!-- Comment 1 -->
      <div class="comment">
        <strong style="color: blue;">Sarah</strong>
        <p class="cc">Great website! Very helpful and easy to use.</p>
      </div>

      <!-- Comment 2 -->
      <div class="comment">
        <strong style="color: blue;">Ahmed</strong>
        <p class="cc">I love the design and how clean everything looks.</p>
      </div>

      <!-- Comment 3 -->
      <div class="comment">
        <strong  style="color: blue;">Lina</strong>
        <p class="cc">This idea is amazing. Waiting for new features!</p>
      </div>
    </div>
  </div>



  <footer class="footer">
    <h3>TO DO LIST</h3>
    <div>
      <a href="http://localhost/php/project/home.php">home</a>
      <a href="http://localhost/php/project/about.php">about us</a>
      <a href="http://localhost/php/project/dashboard.php">dashboard</a>
      <a href="http://localhost/php/project/sign up.php" class="pot">sing up</a> <!-- here -->
    </div>

    <div class="social-icons">
      <i class="fab fa-facebook-f"></i>
      <i class="fab fa-twitter"></i>
      <i class="fab fa-instagram"></i>
      <i class="fab fa-linkedin-in"></i>
    </div>

    <p>&copy; 2025 all rights reserved</p>
  </footer>

</body>
</html>