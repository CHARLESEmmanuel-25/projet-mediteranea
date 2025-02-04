<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations sur la Base de Données</title>
</head>
<body>
    <h1>Informations sur la Base de Données</h1>
    <p><strong>Nom de la base de données :</strong> {{ $databaseName }}</p>
    <p><strong>Hôte :</strong> {{ $host }}</p>
    <p><strong>Nom d'utilisateur :</strong> {{ $username }}</p>

    <h2>Tables de la base de données :</h2>
    <ul>
        @foreach ($tables as $table)
            <li>{{ $table->{'Tables_in_' . $databaseName} }}</li>
        @endforeach
    </ul>
</body>
</html>
