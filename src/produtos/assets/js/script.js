$(document).ready(function () {
  $(".form_datetime").datetimepicker({
    format: "dd/mm/yyyy hh:ii",
    language: "pt-BR",
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 1,
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
  $("#eIdCategoria").val("");
  $("#eNome").val("");
  $("#ePreco").val("");
  $("#eEstoque").val("");
}

function GravarProduto() {
  var dataU = {
    Id: $("#eId").val(),
    IdCategoria: $("#eIdCategoria").val(),
    Nome: $("#eNome").val(),
    Preco: $("#ePreco").val(),
    Estoque: $("#eEstoque").val(),
  };

  if (!dataU.IdCategoria) {
    $("#eError").text("É necessário preencher o campo categoria");
    return;
  }

  if (!dataU.Nome) {
    $("#eError").text("É necessário preencher o campo nome");
    return;
  }

  if (!dataU.Preco) {
    $("#eError").text("É necessário preencher o campo preço");
    return;
  }

  if (!dataU.Estoque) {
    $("#eError").text("É necessário preencher o campo estoque");
    return;
  }

  $.ajax({
    url: "../../api/produto/insert.php",
    method: "POST",
    data: dataU,
    success: function (response) {
      console.log("Resposta do servidor:", response);
    },
    error: function (xhr, status, error) {
      console.error("Erro na requisição:", error);
    },
  });
  return;
}

function Editar(id) {
  $("#ModalAdicionar").modal("show");

  $.ajax({
    url: "../../api/produto/query.php",
    type: "POST",
    data: {
      IdProduto: id,
    },
    success: function (response) {
      var ob = JSON.parse(response);
      $("#eId").val(ob.id_produto);
      $("#eIdCategoria").val(ob.id_categoria);
      $("#eNome").val(ob.nome);
      $("#ePreco").val(ob.preco);
      $("#eEstoque").val(ob.estoque);
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

function ExcluirProduto() {
  var dataU = {};
  dataU.Id = $("#IdExclude").val();

  $.ajax({
    url: "../../api/produto/delete.php",
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
