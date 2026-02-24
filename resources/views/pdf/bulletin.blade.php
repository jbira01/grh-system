<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin de Paie</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { width: 100%; border-bottom: 2px solid #ddd; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #2563eb; }
        .company-info { float: right; text-align: right; }
        
        .box { border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; background-color: #f9fafb; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f3f4f6; text-align: left; padding: 8px; border: 1px solid #ddd; }
        td { padding: 8px; border: 1px solid #ddd; }
        
        .total-row td { font-weight: bold; background-color: #e5e7eb; }
        .net-pay { font-size: 18px; font-weight: bold; color: #166534; text-align: right; padding: 15px; border: 2px solid #166534; margin-top: 20px; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">GRH SYSTEM</div>
        <div class="company-info">
            <strong>Société PFE Tech</strong><br>
            Avenue Hassan II, Mohammedia<br>
            contact@grh-system.com
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="box">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 50%;">
                    <strong>Matricule :</strong> {{ $paie->employe->matricule }}<br>
                    <strong>Nom Prénom :</strong> {{ $paie->employe->user->nom }} {{ $paie->employe->user->prenom }}<br>
                    <strong>Département :</strong> {{ $paie->employe->departement->libelle ?? 'N/A' }}<br>
                    <strong>Poste :</strong> {{ $paie->employe->poste->titre ?? 'N/A' }}
                </td>
                <td style="border: none; width: 50%; text-align: right;">
                    <strong>Période :</strong> {{ $paie->mois }} / {{ $paie->annee }}<br>
                    <strong>Date d'édition :</strong> {{ now()->format('d/m/Y') }}
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Rubrique</th>
                <th style="text-align: right;">Base</th>
                <th style="text-align: right;">Taux</th>
                <th style="text-align: right;">Gains (+)</th>
                <th style="text-align: right;">Retenues (-)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salaire de Base</td>
                <td style="text-align: right;">{{ number_format($paie->salaire_brut, 2) }}</td>
                <td style="text-align: right;">-</td>
                <td style="text-align: right;">{{ number_format($paie->salaire_brut, 2) }}</td>
                <td></td>
            </tr>

            @if($paie->donnees_calcul)
                @foreach($paie->donnees_calcul as $key => $val)
                    @if(str_contains($key, 'cnss') && $key == 'montant_cnss')
                    <tr>
                        <td>Cotisation CNSS</td>
                        <td style="text-align: right;">{{ number_format($paie->donnees_calcul['base_cnss'] ?? 0, 2) }}</td>
                        <td style="text-align: right;">4.48 %</td>
                        <td></td>
                        <td style="text-align: right;">{{ number_format($val, 2) }}</td>
                    </tr>
                    @endif
                    @if(str_contains($key, 'amo') && $key == 'montant_amo')
                    <tr>
                        <td>Cotisation AMO</td>
                        <td style="text-align: right;">{{ number_format($paie->salaire_brut, 2) }}</td>
                        <td style="text-align: right;">2.26 %</td>
                        <td></td>
                        <td style="text-align: right;">{{ number_format($val, 2) }}</td>
                    </tr>
                    @endif
                @endforeach
            @endif

            <tr class="total-row">
                <td colspan="3">Totaux</td>
                <td style="text-align: right;">{{ number_format($paie->salaire_brut, 2) }}</td>
                <td style="text-align: right;">{{ number_format($paie->deductions, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="net-pay">
        NET À PAYER : {{ number_format($paie->net_a_payer, 2) }} DH
    </div>

    <div class="footer">
        Ce bulletin de paie est généré électroniquement par GRH System. Document confidentiel.
    </div>

</body>
</html>