<!DOCTYPE html>
<html>
    <head>
        <title>ZTF Foundation First Register</title>
        <link rel="stylesheet" href="{{ asset('app.css') }}">
    </head>
    <body>
        <h1>Welcome to the ZTF Foundation First Register</h1>
        <form action="{{ route('first.register') }}" method="POST">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
    </body>
</html>