<?php

include_once("../../db/connection.php");

try {
  $sql = "SELECT * FROM tab_categoria where delete_date IS NULL";
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
  <title>Categorias</title>
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

  function SubmeterForm() {
    $("#FormLog").submit();
  }

  function VoltarAdicionar() {
    $("#ModalAdicionar").modal("hide");
  }

  function VoltarExcluir() {
    $("#ModalExcluir").modal("hide");
  }

  function Adicionar() {
    $("#ModalAdicionar").modal("show");

    $("#eId").val(0);
    $("#eNome").val("");
  }

  function GravarCategoria() {
    var dataU = {
      Id: $("#eId").val(),
      Nome: $('#eNome').val()
    };

    if (!dataU.Nome) {
      $("#eError").text("É necessário preencher o campo nome");
      return;
    }

    $.ajax({
      url: '../../api/categoria/insert.php',
      method: "POST",
      data: dataU,
      success: function (response) {
        console.log('Resposta do servidor:', response);
      },
      error: function (xhr, status, error) {
        console.error('Erro na requisição:', error);
      }
    });
    return;
  }

  function Editar(id) {
    $("#ModalAdicionar").modal("show");

    $.ajax({
      url: "../../api/categoria/query.php",
      type: "POST",
      data: {
        IdCategoria: id,
      },
      success: function (response) {
        var ob = JSON.parse(response);
        $("#eId").val(ob.id_categoria);
        $("#eNome").val(ob.nome);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(thrownError);
      },
    });
    return;
  }

  function Excluir(id) {
    $("#ModalExcluir").modal("show");
    $("#IdExclude").val(id);
  }

  function ExcluirCategoria() {
    var dataU = {};
    dataU.Id = $("#IdExclude").val();

    $.ajax({
      url: "../../api/categoria/delete.php",
      type: "POST",
      data: dataU,
      success: function (response) {
        if (response.indexOf("sucesso") != -1) {
          $("#ModalExcluir").modal("hide");
          $("#FormLog").submit();
        } else {
          $("#eError").text(response);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        $("#eError").text(thrownError);
      },
    });
    return;
  }
</script> -->

<body>
  <header>
    <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
      <div class="container-fluid">
        <a class="navbar-brand" href=".."><img src="../assets/images/logo.png" alt="logo" width="100px"
            height="100%" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse d-sm-inline-flex justify-content-between">
          <ul class="navbar-nav flex-grow-1">
            <li class="nav-item">
              <a class="nav-link text-dark" href="../categorias/index.php">Categoria</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="../produtos/index.php">Produto</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
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
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #ed233d; border-radius:5px 5px 0px 0px;">
          <h6 class="modal-title" style="color: white;">Adicionar Categoria</h6>
          <button type="button" class="close" data-dismiss="modal" onclick="VoltarAdicionar();">&times;</button>
        </div>
        <div class="modal-body">
          <form method='POST' id="modalform" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group form-group-sm col-sm-2">
                <label class="control-label">Id</label>
                <input class="form-control" id="eId" name="eId" value="<?php if (isset($row["id_categoria"]))
                  echo $row["id_categoria"]; ?>" disabled required />
              </div>
              <div class="form-group form-group-sm col-sm-10">
                <label class="control-label">Nome</label>
                <input type="text" class="form-control" id="eNome" name="eNome" value="<?php if (isset($row["nome"]))
                  echo $row["nome"]; ?>" required />
              </div>
            </div>
            <div class="row">&nbsp;</div>
          </form>
          <div class="modal-footer" style="background-color: #ed233d; border-radius:0px 0px 5px 5px;">
            <button type="button" class="btn btn-success" onclick="GravarCategoria();">Salvar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"
              onclick="VoltarAdicionar();">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="ModalExcluir" class="modal fade" role="dialog">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #ed233d; color:white; border-radius:5px 5px 0px 0px;">
          <h4 class="modal-title">Atenção</h4>
          <button type="button" class="close" data-dismiss="modal" onclick="VoltarExcluir();">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group form-group-sm col-sm-12">
              <input name="IdExclude" id="IdExclude" style="display:none" />
              <h6>Deseja realmente excluir esta categoria?</h6>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #ed233d; border-radius:0px 0px 5px 5px;">
          <button type="button" class="btn btn-success" onclick="ExcluirCategoria();">Excluir</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="VoltarExcluir();">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <footer class="container-fluid text-center border-top footer text-muted"
    style="position: fixed; bottom: 0px !important; width: 100%; height: 30px;">
    <div class="container">
      &copy; 2023 - Amanda Carvalheiro Barbosa
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>

</html>