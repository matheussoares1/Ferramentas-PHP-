/*
--Instale a biblioteca PHPWord:
composer require phpoffice/phpword

*/
<?php
require 'vendor/autoload.php';
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

include("config.php"); // Certifique-se de incluir seu arquivo de configuração do banco de dados

// Verifique se o ID do usuário foi fornecido na URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Consulta para recuperar os dados do usuário com base no ID
    $query = "SELECT * FROM usuarios WHERE id = $userId"; // Substitua 'usuarios' pelo nome da sua tabela
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $userData = $result->fetch_assoc();

        // Inicialize o objeto PHPWord
        $phpWord = new PhpWord();

        // Defina o modelo de contrato (um arquivo Word com a estrutura pré-definida)
        $templateFile = 'modelo_de_contrato.docx'; // Substitua pelo caminho para seu modelo de contrato

        // Abra o modelo de contrato
        $document = IOFactory::load($templateFile);

        // Preencha o modelo com dados do usuário
        // Os marcadores no modelo do contrato devem coincidir com as chaves nos dados do usuário

        // Substitua os marcadores no modelo com os dados reais
        $document->setValue('NOME', $userData['nome']);
        $document->setValue('EMAIL', $userData['email']);

        // Salve o contrato gerado em um novo arquivo
        $generatedContractFile = "contrato_{$userId}.docx";
        $document->save($generatedContractFile);

        // Envie o contrato gerado para o usuário
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"$generatedContractFile\"");
        readfile($generatedContractFile);

        // Você também pode salvar o contrato em um local específico do servidor
        // e fornecer um link para o download

        // Lembre-se de adicionar tratamento de erros e validações, bem como garantir a segurança adequada.
    } else {
        echo "Usuário não encontrado.";
    }
} else {
    echo "ID de usuário não fornecido.";
}
?>
