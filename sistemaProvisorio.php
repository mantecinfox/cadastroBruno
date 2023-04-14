<?php
// Dados de conexão com o banco de dados
$host = "localhost";
$user = "usuario";
$password = "senha";
$dbname = "nome_do_banco";

// Conexão com o banco de dados
$conexao = mysqli_connect($host, $user, $password, $dbname);

// Verifica se houve algum erro na conexão
if (mysqli_connect_errno()) {
  echo "Erro ao conectar com o banco de dados: " . mysqli_connect_error();
  exit();
}

// Inclusão de um novo cliente
if (isset($_POST['incluir'])) {
  $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
  $email = mysqli_real_escape_string($conexao, $_POST['email']);
  $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
  $ativo = isset($_POST['ativo']) ? 1 : 0;
  $inativo = isset($_POST['inativo']) ? 1 : 0;
  
  $sql = "INSERT INTO clientes (nome, email, telefone, ativo, inativo) VALUES ('$nome', '$email', '$telefone', '$ativo', '$inativo')";
  
  if (mysqli_query($conexao, $sql)) {
    echo "Cliente incluído com sucesso.";
  } else {
    echo "Erro ao incluir cliente: " . mysqli_error($conexao);
  }
}

// Exclusão de um cliente existente
if (isset($_POST['excluir'])) {
  $id = mysqli_real_escape_string($conexao, $_POST['id']);
  
  $sql = "DELETE FROM clientes WHERE id = '$id'";
  
  if (mysqli_query($conexao, $sql)) {
    echo "Cliente excluído com sucesso.";
  } else {
    echo "Erro ao excluir cliente: " . mysqli_error($conexao);
  }
}

// Exibição da lista de clientes
$sql = "SELECT * FROM clientes";
$resultado = mysqli_query($conexao, $sql);

echo "<table>";
echo "<tr><th>Nome</th><th>Email</th><th>Telefone</th><th>Ativo</th><th>Inativo</th><th>Ações</th></tr>";

while ($cliente = mysqli_fetch_assoc($resultado)) {
  echo "<tr>";
  echo "<td>" . $cliente['nome'] . "</td>";
  echo "<td>" . $cliente['email'] . "</td>";
  echo "<td>" . $cliente['telefone'] . "</td>";
  echo "<td>" . ($cliente['ativo'] ? "Sim" : "Não") . "</td>";
  echo "<td>" . ($cliente['inativo'] ? "Sim" : "Não") . "</td>";
  echo "<td>";
  echo "<form method='post' action=''>";
  echo "<input type='hidden' name='id' value='" . $cliente['id'] . "'>";
  echo "<input type='submit' name='excluir' value='Excluir'>";
  echo "</form>";
  echo "</td>";
  echo "</tr>";
}

echo "</table>";

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>
