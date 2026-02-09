<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creation des Roles avec Grade  associe  pour {{Auth::user()->name ?? 'Utilisateur'}}</title>
</head>
<body>
    <form method="POST" action="{{route('roles.store')}}">
        <label for="name">Nom du Role:</label>
        <input type="text" name="name" value="{{old(value)}}" placeholder=" veuillez saisir le nom du role"required>
        <label for="grade">Grade associe:</label>
        <input type="number" name="grade" min="1" max="10" placeholder="grade(exple:1 pour comite,2 chef de departement,3 staff)" required>
    </form>
</body>
</html>