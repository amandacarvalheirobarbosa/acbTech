function SubmeterForm() {
  $("#FormLog").submit();
}

function Adicionar() {
  $("#ModalAdicionar").modal("show");

  $("#eId").val(0);
  $("#eNome").val("");
}

function EditarCategoria(id) {
  $("#ModalAdicionar").modal("show");
}

function Editar(id) {
  $.ajax({
    type: "POST",
    url: "query.php",
    data: {
      IdCategoria: id,
    },
    success: function (html) {
      var ob = JSON.parse(html);
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
    type: "POST",
    url: "delete.php",
    data: dataU,
    success: function (html) {
      if (html.indexOf("sucesso") != -1) {
        $("#ModalExcluir").modal("hide");
        $("#FormLog").submit();
      } else {
        $("#eError").text(html);
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      $("#eError").text(thrownError);
    },
  });
  return;
}
