<?php
require_once "./session.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <title>ODV Manager</title>
  <meta charset="utf-8" />
  <?php require_once "../scripts/head.php"; ?>
</head>
<body>
  <?php require_once "../scripts/body.php"; bodyStart(); ?>
  <div class="py-5 text-center bg-amministratore">
    <div class="d-flex align-items-center justify-content-center">
      <span class="fa-stack fa-2x">
        <i class="fas fa-circle fa-stack-2x text-white"></i>
        <i class="fas fa-house-user fa-stack-1x text-body"></i>
      </span>
      <h1 class="text-white fw-bold text-shadow">Dashboard / Amministratore</h1>
    </div>
  </div>
  <div class="container my-5 p-4 bg-white rounded shadow">
    <h2 class="mb-4 fw-bold">Personalizzazione:</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
      <div class="col">
        <div class="card bg-primary mb-3">
          <a class="text-decoration-none" href="./app.php?n=personalizza_campi_dati_utenti.php">
            <div class="row g-0">
              <div class="col-3 pt-2 text-center">
                <span class="fa-stack fa-2x">
                  <i class="fas fa-circle fa-stack-2x text-white"></i>
                  <i class="fas fa-user-shield fa-stack-1x text-body"></i>
                </span>
              </div>
              <div class="col-9 my-auto">
                <div class="card-body">
                  <h5 class="card-title text-white mb-0">Campi dati utenti</h5>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card bg-danger mb-3">
          <a class="text-decoration-none" href="./app.php?n=personalizza_azioni_volontariato.php">
            <div class="row g-0">
              <div class="col-3 pt-2 text-center">
                <span class="fa-stack fa-2x">
                  <i class="fas fa-circle fa-stack-2x text-white"></i>
                  <i class="fas fa-thumbtack fa-stack-1x text-body"></i>
                </span>
              </div>
              <div class="col-9 my-auto">
                <div class="card-body">
                  <h5 class="card-title text-white mb-0">Azioni di volontariato</h5>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card bg-yellow mb-3">
          <a class="text-decoration-none" href="./app.php?n=personalizza_dettagli_azioni_volontariato.php">
            <div class="row g-0">
              <div class="col-3 pt-2 text-center">
                <span class="fa-stack fa-2x">
                  <i class="fas fa-circle fa-stack-2x text-white"></i>
                  <i class="fas fa-tasks fa-stack-1x text-body"></i>
                </span>
              </div>
              <div class="col-9 my-auto">
                <div class="card-body">
                  <h5 class="card-title text-white mb-0">Dettagli azioni di volontariato</h5>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card bg-success mb-3">
          <a class="text-decoration-none" href="./app.php?n=personalizza_benemerenze.php">
            <div class="row g-0">
              <div class="col-3 pt-2 text-center">
                <span class="fa-stack fa-2x">
                  <i class="fas fa-circle fa-stack-2x text-white"></i>
                  <i class="fas fa-award fa-stack-1x text-body"></i>
                </span>
              </div>
              <div class="col-9 my-auto">
                <div class="card-body">
                  <h5 class="card-title text-white mb-0">Benemerenze</h5>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card bg-danger mb-3">
          <a class="text-decoration-none" href="./app.php?n=personalizza_ruoli.php">
            <div class="row g-0">
              <div class="col-3 pt-2 text-center">
                <span class="fa-stack fa-2x">
                  <i class="fas fa-circle fa-stack-2x text-white"></i>
                  <i class="fas fa-user-tag fa-stack-1x text-body"></i>
                </span>
              </div>
              <div class="col-9 my-auto">
                <div class="card-body">
                  <h5 class="card-title text-white mb-0">Ruoli</h5>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card bg-primary mb-3">
          <a class="text-decoration-none" href="./app.php?n=personalizza_stati.php">
            <div class="row g-0">
              <div class="col-3 pt-2 text-center">
                <span class="fa-stack fa-2x">
                  <i class="fas fa-circle fa-stack-2x text-white"></i>
                  <i class="fas fa-user-check fa-stack-1x text-body"></i>
                </span>
              </div>
              <div class="col-9 my-auto">
                <div class="card-body">
                  <h5 class="card-title text-white mb-0">Stati</h5>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="container my-5 p-4 bg-white rounded shadow">
    <h2 class="mb-4 fw-bold">Personale - Azioni di Volontariato:</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
      <div class="col">
        <div class="card bg-primary mb-3">
          <a class="text-decoration-none" href="./app.php?n=registra_azione_volontariato.php">
            <div class="row g-0">
              <div class="col-3 pt-2 text-center">
                <span class="fa-stack fa-2x">
                  <i class="fas fa-circle fa-stack-2x text-white"></i>
                  <i class="fas fa-thumbtack fa-stack-1x text-body"></i>
                </span>
              </div>
              <div class="col-9 my-auto">
                <div class="card-body">
                  <h5 class="card-title text-white mb-0">Registra azione</h5>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card bg-danger mb-3">
          <a class="text-decoration-none" href="./app.php?n=gestione_azioni_volontariato.php">
            <div class="row g-0">
              <div class="col-3 pt-2 text-center">
                <span class="fa-stack fa-2x">
                  <i class="fas fa-circle fa-stack-2x text-white"></i>
                  <i class="fas fa-tasks fa-stack-1x text-body"></i>
                </span>
              </div>
              <div class="col-9 my-auto">
                <div class="card-body">
                  <h5 class="card-title text-white mb-0">Gestione azioni</h5>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card bg-success mb-3">
          <a class="text-decoration-none" href="./app.php?n=benemerenze.php">
            <div class="row g-0">
              <div class="col-3 pt-2 text-center">
                <span class="fa-stack fa-2x">
                  <i class="fas fa-circle fa-stack-2x text-white"></i>
                  <i class="fas fa-award fa-stack-1x text-body"></i>
                </span>
              </div>
              <div class="col-9 my-auto">
                <div class="card-body">
                  <h5 class="card-title text-white mb-0">Benemerenze</h5>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php bodyEnd(); ?>
</body>
</html>
