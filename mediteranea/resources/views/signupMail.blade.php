
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmation d'inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Confirmation d'inscription</h1>
    <p>Merci de vous être inscrit sur notre plateforme ! Pour finaliser votre inscription, veuillez cliquer sur le lien ci-dessous :</p>
    <p>
        <a href="{{ $confirmationLink }}" class="button">Confirmer mon inscription</a>
    </p>
    <p>Si vous n'avez pas créé de compte, vous pouvez ignorer cet email.</p>
    <p>Merci,<br>L'équipe {{ config('app.name') }}</p>
</body>
</html>
