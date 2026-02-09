<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Téléchargements - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 20px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 30px;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .back-button:hover {
            background: #764ba2;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f5f5f5;
            border-bottom: 2px solid #ddd;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .pdf-name {
            color: #667eea;
            font-weight: 500;
        }

        .date {
            color: #999;
            font-size: 13px;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn-download {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 15px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.3s;
        }

        .btn-download:hover {
            background: #764ba2;
        }

        .btn-download i {
            font-size: 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 32px;
            margin-bottom: 5px;
        }

        .stat-card p {
            font-size: 13px;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📄 Historique des Téléchargements</h1>
            <p>Zacharias Tannee Fomum Foundation - Formulaires PDF</p>
        </div>

        <div class="content">
            <a href="{{ route('BigForm') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Retour au formulaire
            </a>

            @if($pdfs->count() > 0)
                <div class="stats">
                    <div class="stat-card">
                        <h3>{{ $pdfs->count() }}</h3>
                        <p>Formulaires générés</p>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nom du fichier</th>
                                <th>Date de génération</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pdfs as $pdf)
                                <tr>
                                    <td class="pdf-name">
                                        <i class="fas fa-file-pdf"></i> {{ $pdf->filename }}
                                    </td>
                                    <td class="date">{{ $pdf->created_at->format('d/m/Y à H:i') }}</td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('redownload.pdf', $pdf->id) }}" class="btn-download">
                                                <i class="fas fa-download"></i> Télécharger
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-file-pdf"></i>
                    <h2>Aucun PDF trouvé</h2>
                    <p>Vous n'avez pas encore généré de formulaires PDF.</p>
                    <p>Complétez et soumettez le formulaire pour générer votre premier PDF.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
