<?php
include_once("../../db/connection.php");

try {
  if (isset($_POST["Id"])) {
    $Id = mysqli_real_escape_string($conn, $_POST["Id"]);
    $Nome = mysqli_real_escape_string($conn, $_POST["Nome"]);

    if ($Id == 0) {
      $stmt = $conn->prepare("INSERT INTO tab_categoria (nome, created, modified) VALUES (?,NOW(),NOW())");

      $stmt->bind_param('s', $Nome);

      if (!$stmt->execute()) {
        echo '[' . $stmt->errno . "] " . $stmt->error;
      } else {
        echo "Registro gravado com sucesso!";
      }
    } else {
      $sql = "SELECT * FROM tab_categoria WHERE id_categoria='" . $Id . "'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();

      $stmt = $conn->prepare("UPDATE tab_categoria SET nome=?,modified=NOW() WHERE id_categoria=?");
      $stmt->bind_param('s', $Nome, $Id);

      if (!$stmt->execute()) {
        echo '[' . $stmt->errno . "] " . $stmt->error;
      } else {
        echo "Registro gravado com sucesso!";
      }
    }
  }

  // $stmt->close();

} catch (Exception $e) {
  $erro = $e->getMessage();
  echo json_encode($erro);
}
