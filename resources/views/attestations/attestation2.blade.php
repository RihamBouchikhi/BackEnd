<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attestation de Stage</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" >
  <style>
    .header-logo {
      display:flex;
      justify-content:center;
      height: auto;
      padding-top:20px;
    }
    .header-text {
      line-height: 1.5;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <header class="header-logo ">
      <img src="data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents(base_path('public/logo-MEN.png'))); ?>" width="250">
  </header>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title text-center">Attestation de Stage</h5>
          </div>
          <div class="card-body">
            <p>Je soussigné(e), M. MOHAMED LOUDIFA, Chef division de centre informatique de la Direction du Système d'information
                dont le siège social se situe au Av. Ibn Rochd, Rabat, 
                atteste que M/Mme full_name a effectué un stage ausein de notre service d'une durée du [Indiquer la date de début du stage] au 
              [Indiquer la date de fin du stage]. Tout au long de cette période, [Madame, Monsieur] [Indiquer Nom Prénom du stagiaire] 
          </p>
            <p>
              Par sa rigueur et ses qualités professionnelles et humaines, M/Mme full_name a su
            trouver sa place au sein de l'équipe. Sa présence a été satisfaisante à tous points de vue.
            </p>
              <p>Cette attestation est délivrée à la demande du stagiaire pour servir et valoir ce que de droit.</p>
            <p class="text-end mt-5">Fait le [Préciser la date]</p>
            <p class="text-end">A [Préciser le lieu]</p>
            <div class="row">
              <div class="col-md-6">
                <p class="text-end">[Nom Prénom du représentant de l'entreprise]</p>
              </div>
              <div class="col-md-6">
                <p class="text-end">Signature</p>
              </div>
            </div>
            <div class="text-end">
              <p>Cachet de l'entreprise</p>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div class='h-full '>

  </div>
<footer  class=" text-center mt-5">
    <p class='m-0'>Direction du Système d'Information</p>
    <p class='m-0'>Ministère de l’Education Nationale, du Préscolaire & des Sports</p>
    <p class='m-0'>Avenue Ibn Rochd, Haut Agdal - Rabat ° Tél : 05 37 68 72 19 ° Fax : 05 37 77 18 74</p>
</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
