<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF Foundation - Formulaire Reçu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #333;
        }
        .message-box {
            background-color: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .message-box h2 {
            margin-top: 0;
            color: #667eea;
            font-size: 18px;
        }
        .message-box p {
            margin: 10px 0;
            font-size: 14px;
            line-height: 1.8;
        }
        .highlight {
            font-weight: bold;
            color: #764ba2;
        }
        .instruction-list {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .instruction-list h3 {
            margin-top: 0;
            color: #333;
            font-size: 16px;
        }
        .instruction-list ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        .instruction-list li {
            margin: 8px 0;
            font-size: 14px;
            line-height: 1.6;
        }
        .contact-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 14px;
        }
        .contact-info strong {
            color: #856404;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 10px 0;
            text-align: center;
        }
        .button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>ZTF FOUNDATION</h1>
            <p>Portail du Personnel</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                <p>Chère <span class="highlight">{{ $fullName }}</span>,</p>
            </div>

            <p>Nous vous remercions d'avoir soumis votre formulaire d'enregistrement auprès de la ZTF Foundation.</p>

            <!-- Main Message -->
            <div class="message-box">
                <h2>📋 Prochaine Étape Importante</h2>
                <p>Votre formulaire a été <span class="highlight">reçu et enregistré avec succès</span>.</p>
                <p>Cependant, pour accéder à votre compte et au tableau de bord, vous devez <span class="highlight">récupérer votre numéro de matricule auprès de la cellule informatique</span> de la ZTF Foundation.</p>
            </div>

            <!-- Instructions -->
            <div class="instruction-list">
                <h3>📝 Instructions pour Récupérer Votre Matricule :</h3>
                <ol>
                    <li><strong>Contactez la cellule informatique</strong> de la ZTF Foundation</li>
                    <li>Présentez votre email : <span class="highlight">{{ $email }}</span></li>
                    <li>Demandez votre numéro de matricule personnel</li>
                    <li>Mémorisez ou notez votre matricule avec soin</li>
                    <li>Utilisez-le pour vous connecter au portail du personnel</li>
                </ol>
            </div>

            <!-- Contact Information -->
            <div class="contact-info">
                <strong>⚠️ Important :</strong> Votre numéro de matricule sera nécessaire à chaque connexion à votre compte. 
                Si vous avez oublié votre matricule, veuillez contacter à nouveau la cellule informatique.
            </div>

            <!-- What's Next -->
            <div class="message-box" style="background-color: #e8f5e9; border-left-color: #4caf50;">
                <h2 style="color: #4caf50;">✅ Ce Qu'il Faut Faire Ensuite</h2>
                <ol style="margin: 10px 0; padding-left: 20px;">
                    <li>Une fois votre matricule obtenu, visitez le portail</li>
                    <li>Cliquez sur "Connexion"</li>
                    <li>Entrez votre email et votre mot de passe</li>
                    <li>Saisissez votre numéro de matricule quand demandé</li>
                    <li>Accédez à votre tableau de bord personnel</li>
                </ol>
            </div>

            <p style="margin-top: 20px;">Si vous avez des questions ou rencontrez des difficultés, n'hésitez pas à contacter directement la cellule informatique.</p>

            <p style="margin-top: 30px; color: #666; font-size: 14px;">
                Cordialement,<br>
                <strong>L'équipe de la ZTF Foundation</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>ZTF FOUNDATION - Portail du Personnel</strong></p>
            <p>© {{ date('Y') }} Zacharias Tannee Fomum Foundation. Tous droits réservés.</p>
            <p>Cet email a été envoyé automatiquement. Veuillez ne pas répondre directement à cet email.</p>
        </div>
    </div>
</body>
</html>
