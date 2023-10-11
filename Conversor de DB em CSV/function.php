<?php
include("config.php"); // Certifique-se de incluir seu arquivo de configuração do banco de dados

// Nome do arquivo CSV que você deseja criar
$csvFileName = "exported_data.csv";

// Abre o arquivo CSV para escrita
$csvFile = fopen($csvFileName, 'w');

if ($csvFile === false) {
    die("Erro ao abrir o arquivo CSV para escrita.");
}

// Consulta para recuperar os dados do banco de dados
$query = "SELECT * FROM usuarios"; // Substitua 'usuarios' pelo nome da sua tabela

$result = $conn->query($query);

if ($result === false) {
    die("Erro na consulta: " . $conn->error);
}

// Escreve o cabeçalho no arquivo CSV
$columnNames = array('ID', 'Nome', 'Email'); // Substitua pelos nomes das colunas da sua tabela
fputcsv($csvFile, $columnNames);

// Itera sobre os resultados e escreve no arquivo CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($csvFile, $row);
}

// Fecha o arquivo CSV
fclose($csvFile);

echo "Exportação concluída. Você pode <a href='$csvFileName' download>baixar o arquivo CSV</a>.";

// Lembre-se de adicionar validações, tratamentos de erro e medidas de segurança, se necessário.
?>
