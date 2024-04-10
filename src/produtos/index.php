<?php

include_once("../../db/connection.php");

try {
  $sql = "SELECT prod.*, cat.nome as nome_cat FROM tab_produto prod LEFT JOIN tab_categoria cat ON cat.id_categoria=prod.id_categoria WHERE prod.delete_date IS NULL";
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
  <title>Produtos</title>
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
    <?php include_once('../components/navBar.php') ?>
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
              <th>Id</th>
              <th>Categoria</th>
              <th>Nome</th>
              <th>Preço</th>
              <th>Estoque</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
              for ($i = 0; $i < $result->num_rows; $i++) {
                $row = $result->fetch_assoc();
                echo '<tr>
                        <td class="hidden-xs hidden-sm">' . $row["id_produto"] . '</td>
                        <td class="hidden-xs hidden-sm">' . $row["nome_cat"] . '</td>
                        <td class="hidden-xs hidden-sm">' . $row["nome"] . '</td>
                        <td class="hidden-xs hidden-sm">R$ ' . $row["preco"] . '</td>
                        <td class="hidden-xs hidden-sm">' . $row["estoque"] . '</td>
        
                        <td>
                          <a class="btn btn-primary" title="Editar" onclick="Editar(' . $row["id_produto"] . ')"><i class="fas fa-edit"></i></a>
                          <a class="btn btn-danger" title="Excluir" onclick="Excluir(' . $row["id_produto"] . ')"><i class="fas fa-trash-alt"></i></a>
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
        <div class="modal-header" style="background-color: #ed233d; color:white; border-radius:5px 5px 0px 0px;">
          <h6 class="modal-title">Adicionar Produto</h6>
          <button type="button" class="close" data-dismiss="modal" onclick="VoltarAdicionar();">&times;</button>
        </div>
        <div class="modal-body">
          <form method='POST' id="modalform" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group form-group-sm col-sm-2">
                <label class="control-label">Id</label>
                <input class="form-control" id="eId" name="eId" value="<?php if (isset($row["id_produto"]))
                  echo $row["id_produto"]; ?>" disabled required />
              </div>
              <div class="form-group form-group-sm col-sm-4">
                <label class="control-label">Categoria</label>
                <select class="form-control" id="eIdCategoria" name="eIdCategoria">
                  <?php
                  $sqlcat = "SELECT id_categoria, nome FROM tab_categoria WHERE delete_date IS NULL";
                  $stmtcat = $conn->prepare($sqlcat);
                  $stmtcat->execute();
                  $resultcat = $stmtcat->get_result();
                  if ($resultcat->num_rows > 0) {
                    while ($rowcat = $resultcat->fetch_assoc()) {
                      echo "<option value='" . $rowcat["id_categoria"] . "' " . ($row["id_categoria"] == $rowcat["id_categoria"] ? 'selected' : '') . ">" . $rowcat["nome"] . "</option>";
                    }
                  }
                  ?>
                </select>
                <!-- <input class="form-control" id="eIdCategoria" name="eIdCategoria" value="<?php if (isset($row["id_categoria"]))
                  echo $row["id_categoria"]; ?>" required /> -->
              </div>
              <div class="form-group form-group-sm col-sm-6">
                <label class="control-label">Nome</label>
                <input type="text" class="form-control" id="eNome" name="eNome" value="<?php if (isset($row["nome"]))
                  echo $row["nome"]; ?>" required />
              </div>
            </div>
            <div class="row">
              <div class="form-group form-group-sm col-sm-6">
                <label class="control-label">Preço (R$)</label>
                <div class="input-group">
                  <!-- <span class="input-group-addon">R$</span> -->
                  <input class="form-control" type="text" id="ePreco" name="ePreco" maxlength="10"
                    onkeyup="updateMoneyField(this)" value="<?php if (isset($row["preco"]))
                      echo $row["preco"]; ?>" required />
                </div>
              </div>
              <div class="form-group form-group-sm col-sm-6">
                <label class="control-label">Estoque</label>
                <input type="number" class="form-control" id="eEstoque" name="eEstoque" value="<?php if (isset($row["estoque"]))
                  echo $row["estoque"]; ?>" required />
              </div>
            </div>
            <div class="row">&nbsp;</div>
          </form>
          <div class="modal-footer" style="background-color: #ed233d; border-radius:0px 0px 5px 5px;">
            <button type="button" class="btn btn-success" onclick="GravarProduto();">Salvar</button>
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
              <h6>Deseja realmente excluir este produto?</h6>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #ed233d; border-radius:0px 0px 5px 5px;">
          <button type="button" class="btn btn-success" onclick="ExcluirProduto();">Excluir</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="VoltarExcluir();">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

 <?php include_once('../components/footer.php'); ?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>

</html>