<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="text-center p-5 bg-white shadow rounded">
            @if(session()->has('success'))
                <div class="message success">
                    {{ session()->get('success') }}
                </div>
            @endif
        <h1>Bienvenue, {{ Auth::user()->name }} !</h1>
        <p class="text-muted message">Vous êtes connecté avec succès.</p>
       <a href="{{ route('logout') }}" class="btn btn-danger">Déconnexion</a>
    </div>

</body>
</html>
