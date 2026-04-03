<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil | UV-BF Projet Cave</title>
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; }
        .card { max-width: 450px; margin: auto; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 25px; }
        .header { border-bottom: 2px solid #007bff; margin-bottom: 20px; padding-bottom: 10px; }
        h2 { margin: 0; color: #333; font-size: 1.5em; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-save { background-color: #28a745; color: white; border: none; padding: 12px; width: 100%; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
        .btn-save:hover { background-color: #218838; }
        .status-msg { background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

<div class="card">
    <div class="header">
        <h2>Gestion du Profil</h2>
    </div>

    {{-- Message de confirmation --}}
    @if(session('status'))
        <div class="status-msg">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ url('/profil') }}" method="POST">
        @csrf {{-- INDISPENSABLE : Sécurité Laravel --}}

        <div class="form-group">
            <label>Nom complet</label>
            {{-- Le ?? '' empêche l'erreur si vous n'êtes pas encore connecté --}}
            <input type="text" name="name" value="{{ $user->name ?? '' }}" required>
        </div>

        <div class="form-group">
            <label>Email Universitaire</label>
            <input type="email" name="email" value="{{ $user->email ?? '' }}" required>
        </div>

        <button type="submit" class="btn-save">Mettre à jour le profil</button>
    </form>
</div>

</body>
</html>