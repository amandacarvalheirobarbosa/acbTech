<?php
include_once("../../db/connection.php");

try {
  if (isset($_POST["Id"])) {
    $Id = mysqli_real_escape_string($conn, $_POST["Id"]);
    $IdCategoria = mysqli_real_escape_string($conn, $_POST["IdCategoria"]);
    $Nome = mysqli_real_escape_string($conn, $_POST["Nome"]);
    $Preco = mysqli_real_escape_string($conn, $_POST["Preco"]);
    $Estoque = mysqli_real_escape_string($conn, $_POST["Estoque"]);

    if ($Id == 0) {
      $stmt = $conn->prepare("INSERT INTO tab_produto (id_categoria, nome, preco, estoque, created, modified) VALUES (?,?,?,?,NOW(),NOW())");
      $stmt->bind_param('issi', $IdCategoria, $Nome, $Preco, $Estoque);

      if (!$stmt->execute()) {
        echo '[' . $stmt->errno . "] " . $stmt->error;
      } else {
        echo "Registro gravado com sucesso!";
      }
    } else {
      $sql = "SELECT * FROM tab_produto WHERE id_produto='" . $Id . "'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();

      $stmt = $conn->prepare("UPDATE tab_produto SET id_categoria=?, nome=?, preco=?, estoque=?, modified=NOW() WHERE id_produto=?");
      $stmt->bind_param('issii', $IdCategoria, $Nome, $Preco, $Estoque, $Id);

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
