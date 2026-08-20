<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Task Manager Card</title>
  <link rel="stylesheet" href="styles.css">
  <style>
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
  height: 250px;
}

.card:hover {
  transform: scale(1.05) translateZ(20px);
  box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
}

.card button {
  margin-top: 20px;
  padding: 12px 24px;
  border: none;
  background-color: #007bff;
  color: white;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
}

.card button:hover {
  background-color: #0056b3;
}

  </style>
</head>
<body>

  <video autoplay muted loop id="bg-video">
    <source src="background.mp4" type="video/mp4" />
    Your browser does not support HTML5 video.
  </video>

  <div class="card-container">
    <div class="card">
      <h1>Task Manager</h1>
      <p>Organize your tasks efficiently.</p>
      <button>Get Started</button>
    </div>
  </div>

</body>
</html>
