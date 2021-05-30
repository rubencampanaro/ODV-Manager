<!DOCTYPE html>
<html lang="it">
<head>
  <title>ODV Manager</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="./css/bootstrap.min.css" type="text/css" rel="stylesheet" />
  <link href="./css/style.css" type="text/css" rel="stylesheet" />
  <link href="./img/icon.png" type="image/png" rel="icon" />
</head>
<body>
  <header>
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
      <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">
          <img src="./img/icon_original.png" alt="" width="34" height="25" class="d-inline-block align-text-top rounded me-1" />
          <b>ODV Manager</b>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item text-nowrap my-1 my-lg-0">
              <a class="nav-link text-white" href="./index.php">Home</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <main>
    <div class="py-5 text-center bg-avviso">
      <div class="d-flex align-items-center justify-content-center">
        <span class="fa-stack fa-2x">
          <i class="fas fa-circle fa-stack-2x text-white"></i>
          <i class="fas fa-exclamation-triangle fa-stack-1x text-body"></i>
        </span>
        <h1 class="text-white fw-bold text-shadow">Avviso</h1>
      </div>
    </div>
    <div class="container-md my-5 p-4 bg-white rounded shadow">
      <div class="alert alert-danger fade show m-0 text-center" role="alert">
        <?php
        if(isSet($_GET['code']))
        {
          $code = $_GET['code'];
          switch ($code)
          {
            case 1:
            echo '<b>Attenzione</b> - Autenticazione fallita.';
            break;
            case 2:
            echo '<b>Errore</b> - Sessione non valida.';
            break;
            case 3:
            echo '<b>Errore</b> - App non trovata.';
            break;
            case 4:
            echo '<b>Errore</b> - Dati non ricevuti.';
            break;
            default:
            echo 'Codice di avviso non valido.';
          }
        }
        else
        echo 'Codice di avviso non ricevuto.';
        ?>
      </div>
    </div>
  </main>
  <script src="./scripts/bootstrap.bundle.min.js"></script>
  <script src="./scripts/all.min.js"></script>
</body>
</html>
