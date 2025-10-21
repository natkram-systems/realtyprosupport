<?php
session_start();
$message = $_SESSION['message'] ?? "";
$name = $_SESSION['name'] ?? "";
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MMJ Greenland - Login & Register</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f4f6f5;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .container {
      background: #fff;
      border-radius: 10px;
      padding: 2rem;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      color: #2e7d32;
    }
    .message {
      color: red;
      text-align: center;
      margin-bottom: 1rem;
    }
    .welcome {
      color: #2e7d32;
      text-align: center;
      margin-bottom: 1rem;
      font-weight: bold;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }
    input, button {
      padding: 0.6rem;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }
    button {
      background-color: #2e7d32;
      color: white;
      border: none;
      cursor: pointer;
    }
    .toggle-link {
      text-align: center;
      margin-top: 1rem;
    }
    .toggle-link a {
      color: #2e7d32;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php if (!empty($name)) echo "<div class='welcome'>Welcome, $name!</div>"; ?>
    <?php if (!empty($message)) echo "<div class='message'>$message</div>"; ?>
    <h2 id="formTitle">Login</h2>
    <form action="login.php" method="POST" id="loginForm">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <form action="register.php" method="POST" id="registerForm" style="display: none;">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Register</button>
    </form>

    <div class="toggle-link">
      <span id="toggleText">Don't have an account? <a onclick="toggleForms()">Register</a></span>
    </div>
  </div>

  <script>
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const formTitle = document.getElementById('formTitle');
    const toggleText = document.getElementById('toggleText');

    function toggleForms() {
      if (loginForm.style.display === 'none') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        formTitle.innerText = 'Login';
        toggleText.innerHTML = "Don't have an account? <a onclick=\"toggleForms()\">Register</a>";
      } else {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        formTitle.innerText = 'Register';
        toggleText.innerHTML = "Already have an account? <a onclick=\"toggleForms()\">Login</a>";
      }
    }
  </script>
</body>
</html>
