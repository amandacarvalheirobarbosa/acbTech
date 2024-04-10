<?php

include_once ("../../db/connection.php");

$TitlePage = "Categorias";

try {
  $sql = "SELECT * FROM tab_categoria where deleted IS NULL";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();
} catch (Exception $e) {
  $erro = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <title><?= $TitlePage ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Amanda Carvalheiro Barbosa">
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="/src/assets/css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<!-- <script type="text/javascript">
  $(document).ready(function () {
    $('.form_datetime').datetimepicker({
      format: 'dd/mm/yyyy hh:ii',
      language: 'pt-BR',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
    });
  });
</script> -->

<body>
  <header>
    <?php include_once ('../components/navBar.php') ?>
  </header>

  <div class="container">
    <main role="main" class="pb-3">
      <div class="row">
        <div class="col-4">
          <a class="btn" onclick="Adicionar();" style="background-color: #ed233d !important; color: white;"><i
              class="fas fa-plus"></i>
            Adicionar</a>
        </div>
      </div>
      <div class="row">
        <table class="table">
          <thead>
            <tr>
              <th class="hidden-xs hidden-sm">Id</th>
              <th class="hidden-xs hidden-sm">Nome</th>
              <th class="hidden-xs hidden-sm"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
              for ($i = 0; $i < $result->num_rows; $i++) {
                $row = $result->fetch_assoc();
                echo '<tr>
                        <td class="hidden-xs hidden-sm">' . $row["id_categoria"] . '</td>
                        <td class="hidden-xs hidden-sm">' . $row["nome"] . '</td>
        
                        <td>
                          <a class="btn btn-primary" title="Editar" onclick="Editar(' . $row["id_categoria"] . ')"><i class="fas fa-edit"></i></a>
                          <a class="btn btn-danger" title="Excluir" onclick="Excluir(' . $row["id_categoria"] . ')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                      </tr>';
              }
            }

            ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <div id="ModalAdicionar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #ed233d; color: white; border-radius: 5px 5px 0 0;">
          <h5 class="modal-title">Adicionar Categoria</h5>
          <button type="button" class="btn-close" onclick="VoltarAdicionar();" data-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" id="modalform" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="eId" class="form-label">ID</label>
              <input class="form-control" id="eId" name="eId" value="<?php if (isset($row["id_categoria"]))
                echo $row["id_categoria"]; ?>" disabled required>
            </div>
            <div class="mb-3">
              <label for="eNome" class="form-label">Nome</label>
              <input type="text" class="form-control" id="eNome" name="eNome" value="<?php if (isset($row["nome"]))
                echo $row["nome"]; ?>" required>
            </div>
          </form>
        </div>
        <div class="modal-footer" style="background-color: #ed233d; border-radius: 0 0 5px 5px;">
          <button type="button" class="btn btn-success" onclick="GravarCategoria();">Salvar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"
            onclick="VoltarAdicionar();">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <div id="ModalExcluir" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #ed233d; color: white; border-radius: 5px 5px 0 0;">
          <h5 class="modal-title">Atenção</h5>
          <button type="button" class="btn-close" onclick="VoltarExcluir();" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-sm-12">
              <input type="hidden" name="IdExclude" id="IdExclude">
              <h6>Deseja realmente excluir esta categoria?</h6>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #ed233d; border-radius: 0 0 5px 5px;">
          <button type="button" class="btn btn-success" onclick="ExcluirCategoria();">Excluir</button>
          <button type="button" class="btn btn-danger" onclick="VoltarExcluir();" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <?php include_once ('../components/footer.php') ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/script.js"></script>
</body>

</html>