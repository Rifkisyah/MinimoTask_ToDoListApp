<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reset Password</title>
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

    input[type="email"],
    input[type="text"],
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

    .message {
      text-align: center;
      margin-top: 15px;
      font-size: 0.95rem;
    }

    .message.success {
      color: #2ecc71;
    }

    .message.error {
      color: #e74c3c;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Reset Password</h2>
    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <input type="email" name="email" placeholder="Enter your email" required>
      <input type="password" name="password" placeholder="New password" required>
      <input type="password" name="password_confirmation" placeholder="Confirm password" required>
      <button type="submit">Reset Password</button>
    </form>

    @if (session('status'))
      <div class="message success">{{ session('status') }}</div>
    @endif

    @error('email')
      <div class="message error">{{ $message }}</div>
    @enderror

    @error('password')
      <div class="message error">{{ $message }}</div>
    @enderror

    <div class="link">
      Back to <a href="{{ route('user.login') }}">Login</a>
    </div>
  </div>
</body>
</html>
