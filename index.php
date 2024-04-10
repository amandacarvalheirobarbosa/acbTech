<?php
$TitlePage = "ACB Tech";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <title><?= $TitlePage ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Amanda Carvalheiro Barbosa">
  <link rel="icon" href="./src/assets/images/logo.png">
  <link rel="stylesheet" href="/src/assets/css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <header>
    <?php include_once ('./src/components/navBar.php') ?>
  </header>

  <div class="container">
    <main role="main" class="pb-3">
      <div class="text-center">
        <img src="../src/assets/images/image.png" alt="Imagem Empresa" style="margin-top: 250px !important; opacity: 0.6;" />
      </div>
    </main>
  </div>

  <?php include_once ('./src/components/footer.php') ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>