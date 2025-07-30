<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forget Password</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #111;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    header {
      width: 100%;
      background-color: #222;
      padding: 20px;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
    }

    .container {
      margin-top: 100px;
      background-color: #1e1e1e;
      padding: 30px;
      border-radius: 12px;
      width: 90%;
      max-width: 400px;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.05);
    }

    .container h2 {
      margin-bottom: 20px;
      font-size: 22px;
    }

    .container input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      background-color: #2c2c2c;
      border: 1px solid #444;
      color: #fff;
      border-radius: 6px;
      font-size: 14px;
    }

    .container button {
      width: 100%;
      padding: 12px;
      background-color: #3498db;
      border: none;
      border-radius: 6px;
      color: white;
      font-weight: bold;
      font-size: 16px;
      margin-top: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .container button:hover {
      background-color: #2980b9;
    }

    .success, .error {
      margin-top: 10px;
      text-align: center;
      font-size: 14px;
    }

    .success {
      color: #2ecc71;
    }

    .error {
      color: #e74c3c;
    }
  </style>
</head>
<body>

  <header>Reset Your Password</header>

  <div class="container" id="stepEmail">
    <h2>Enter your email</h2>
    <input type="email" id="email" placeholder="Your email address" />
    <button onclick="sendToken()">Send Token</button>
    <div class="success" id="emailSuccess" style="display: none;">Token has been sent to your email.</div>
    <div class="error" id="emailError" style="display: none;">Failed to send token.</div>
  </div>

  <div class="container" id="stepToken" style="display: none;">
    <h2>Enter token & new password</h2>
    <input type="text" id="token" placeholder="Verification token" />
    <input type="password" id="newPassword" placeholder="New password" />
    <button onclick="resetPassword()">Reset Password</button>
    <div class="success" id="resetSuccess" style="display: none;">Password reset successfully.</div>
    <div class="error" id="resetError" style="display: none;">Invalid token or error occurred.</div>
  </div>

  <script>
    function sendToken() {
      const email = document.getElementById('email').value.trim();
      if (!email) {
        alert('Please enter your email.');
        return;
      }

      // Placeholder logic - replace with AJAX/backend call
      console.log("Sending token to", email);
      // Simulate success
      document.getElementById('emailSuccess').style.display = 'block';
      document.getElementById('emailError').style.display = 'none';
      setTimeout(() => {
        document.getElementById('stepEmail').style.display = 'none';
        document.getElementById('stepToken').style.display = 'block';
      }, 1000);
    }

    function resetPassword() {
      const token = document.getElementById('token').value.trim();
      const newPassword = document.getElementById('newPassword').value.trim();
      if (!token || !newPassword) {
        alert('Please fill in both fields.');
        return;
      }

      // Placeholder logic - replace with real verification
      console.log("Verifying token:", token);
      if (token === '123456') { // fake token for testing
        document.getElementById('resetSuccess').style.display = 'block';
        document.getElementById('resetError').style.display = 'none';
      } else {
        document.getElementById('resetError').style.display = 'block';
        document.getElementById('resetSuccess').style.display = 'none';
      }
    }
  </script>

</body>
</html>
