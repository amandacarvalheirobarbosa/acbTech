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
      if (response.indexOf("sucesso") != -1) {
        console.log("Resposta do servidor:", response);
        location.reload();

        $("#ModalEdit").modal("hide");
        $("#FormLog").submit();
      } else {
        $("#eError").text(response);
      }
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
        location.reload();

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

function formatMoney(money) {
  var formattedMoney = money.toString().replace(/\D/g, "");
  formattedMoney = formattedMoney.replace(/(\d{2})$/, ",$1");
  formattedMoney = formattedMoney.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
  return formattedMoney;
}

function updateMoneyField(input) {
  var money = input.value;
  var formattedMoney = formatMoney(money);
  input.value = formattedMoney;
}
