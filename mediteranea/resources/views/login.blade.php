<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 20px;
        }

        h1 {
            font-size: 2.5em;
            color: #007bff;
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .google-login {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .google-login a {
            padding: 10px 20px;
            background-color: #db4437;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .google-login a:hover {
            background-color: #c1352e;
        }

        .message {
            max-width: 600px;
            margin: 10px auto;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <h1>Formulaire de connexion client</h1>

    @if(session()->has('success'))
        <div class="message success">
            {{ session()->get('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="message error">
            {{ session()->get('error') }}
        </div>
    @endif

    <form action="{{ route('store.login') }}" method="POST">
        @csrf

        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" required>
        @if ($errors->has('email'))
            <p class="error-message">{{ $errors->first('email') }}</p>
        @endif

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Se connecter">
    </form>

    <div class="google-login">
        <a href="{{ route('auth.google.redirect') }}">Se connecter avec Google</a>
    </div>
</body>
</html>
