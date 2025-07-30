<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      color: #333;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .form-container {
      background-color: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .form-container h2 {
      margin-bottom: 25px;
      color: #2575fc;
      text-align: center;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }

    button {
      width: 100%;
      padding: 12px;
      margin-top: 15px;
      background-color: #2575fc;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #1b60d1;
    }

    .link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.95rem;
    }

    .link a {
      color: #2575fc;
      text-decoration: none;
    }

    .link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Login Admin</h2>
    <form action="" method="POST">
      @csrf
      <input type="text" name="login" placeholder="Email or Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <div class="link">
        <a href={{ route('admin.forgot-password') }}> Forgot your password? </a>
      </div>
      <button type="submit">Login</button>
    </form>
    <div class="link">
      Don't have an account yet? <a href="{{ route('admin.register') }}">register now!</a>
    </div>
  </div>
</body>
</html>
