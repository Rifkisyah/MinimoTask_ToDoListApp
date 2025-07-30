<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoList App</title>
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
</head>
<body>
    <section class="hero">
        <div class="hero-content">
            <h1>Organize Your Day</h1>
            <p>Simple and intuitive To-Do List to boost your productivity.</p>
            <a href="{{ Route('user.login') }}" class="btn">Get Started</a>
        </div>
        <div class="hero-image">
            <img src="{{ asset('assets/img/undraw_to-do-list_dzdz.png')}}" alt="To-Do Illustration">
        </div>
    </section>

    <footer>
        <p>&copy; <?= date("Y") ?> ToDoList App. All rights reserved.</p>
    </footer>
</body>
</html>
