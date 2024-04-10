<?php
include_once("../../db/connection.php");

try {
  if (isset($_POST["Id"])) {

    $Id = mysqli_real_escape_string($conn, $_POST["Id"]);

    $sql = "SELECT * FROM tab_categoria WHERE id_categoria='" . $Id . "'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
      echo "Categoria não encontrado para excluir";
      return;
    } else {
      $stmt = $conn->prepare("UPDATE `tab_categoria` SET deleted=NOW() WHERE id_categoria=?");
      $stmt->bind_param('i', $Id);

      if (!$stmt->execute()) {
        echo '[' . $stmt->errno . "] " . $stmt->error;
      } else {
        $stmt = $conn->prepare("UPDATE `tab_categoria` SET deleted=NOW() WHERE id_categoria=?");
        $stmt->bind_param('i', $Id);
        echo "Registro excluido com sucesso!";
      }
    }
  }

  // $stmt->close();

} catch (Exception $e) {
  $erro = $e->getMessage();
  echo json_encode($erro);
}
