/* $(document).ready(function () {
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
}); */

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
    Nome: $("#eNome").val(),
  };

  if (!dataU.Nome) {
    $("#eError").text("É necessário preencher o campo nome");
    return;
  }

  $.ajax({
    // url: "../../api/categoria/insert.php",
    url: "insert.php",
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
    // url: "../../api/categoria/query.php",
    url: "query.php",
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
    // url: "../../api/categoria/delete.php",
    url: "delete.php",
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
