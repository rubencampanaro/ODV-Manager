<?php
function bodyStart() {
  echo '<header>
  <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container-fluid">
  <a class="navbar-brand" href="./index.php">
  <img src=".././img/icon_original.png" alt="" width="34" height="24" class="d-inline-block align-text-top rounded me-1" />
  <b>ODV Manager</b>
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
  <ul class="navbar-nav ms-auto">
  <li class="nav-item text-nowrap my-1 my-lg-0">
  <a class="nav-link text-white" href="./index.php">Dashboard</a>
  </li>
  </ul>
  <ul class="nav nav-pills">
  <li class="nav-item text-nowrap my-1 my-lg-0 ms-lg-3">
  <a class="nav-link active bg-danger" href=".././logout.php">Logout</a>
  </li>
  </ul>
  </div>
  </div>
  </nav>
  </header>
  <main>';
}

function bodyEnd() {
  echo '</main>
  <script src=".././scripts/bootstrap.bundle.min.js"></script>
  <script src=".././scripts/all.min.js"></script>';
}
?>
