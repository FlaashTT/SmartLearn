<?php
ob_start();
require('../../assets/fpdf186/fpdf.php');
require_once("../popup.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (
        !isset($_POST['Id_adquirido']) || $_POST['Id_adquirido'] == "" ||
        !isset($_POST['Nome_utilizador']) || $_POST['Nome_utilizador'] == "" ||
        !isset($_POST['Nome_curso']) || $_POST['Nome_curso'] == "" ||
        !isset($_POST['Criador_curso']) || $_POST['Criador_curso'] == "" ||
        !isset($_POST['Data_conclusao']) || $_POST['Data_conclusao'] == ""
    ) {
        mostrarPopUp("Ocorreu um erro ao criar o certificado,tente mais tarde! NO INICIO");
        exit;
    } else {
        $idCertificado = $_POST['Id_adquirido'];
        $nomeAluno = $_POST['Nome_utilizador'];
        $nomeCurso = $_POST['Nome_curso'];
        $nomeAssinatura = $_POST['Criador_curso'];
        $dataConclusao = $_POST['Data_conclusao'];

        // Criar PDF
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // Inserir logótipo no canto superior esquerdo
        $pdf->Image('../../assets/image/Logo.png', 15, 12, 40);

        // Cor da borda decorativa (azul)
        $pdf->SetDrawColor(50, 50, 150);
        $pdf->SetLineWidth(2);
        $pdf->Rect(10, 10, 277, 190);

        // Cor do texto
        $pdf->SetTextColor(0, 0, 0);

        // Título
        $pdf->SetFont('Arial', 'B', 32);
        $pdf->Ln(15);
        $pdf->Cell(0, 20, mb_convert_encoding('Certificado de Conclusão', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        // Subtítulo
        $pdf->SetFont('Arial', 'I', 16);
        $pdf->Cell(0, 10, mb_convert_encoding('Este documento certifica a participação no curso abaixo mencionado.', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $pdf->Ln(20);

        // Nome do aluno
        $pdf->SetFont('Arial', '', 18);
        $pdf->Cell(0, 10, mb_convert_encoding("Certificamos que o(a) aluno(a):", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 22);
        $pdf->Cell(0, 12, mb_convert_encoding($nomeAluno, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $pdf->Ln(5);

        // Curso
        $pdf->SetFont('Arial', '', 18);
        $pdf->Cell(0, 10, mb_convert_encoding("Concluiu com sucesso o curso:", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(0, 12, mb_convert_encoding($nomeCurso, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $pdf->Ln(10);

        // Data
        $pdf->SetFont('Arial', '', 16);
        $pdf->Cell(0, 10, mb_convert_encoding("Data de conclusão: ", 'ISO-8859-1', 'UTF-8') . $dataConclusao, 0, 1, 'C');

        $pdf->Ln(25);

        // Linha da assinatura
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.5);
        $pdf->Line(100, 165, 200, 165);

        $pdf->SetFont('Arial', '', 16);
        $pdf->SetTextColor(0, 0, 0);

        $larguraTexto = $pdf->GetStringWidth($nomeAssinatura);
        $x = 100 + (100 - $larguraTexto) / 2;
        $y = 158;

        $pdf->SetXY($x, $y);
        $pdf->Cell($larguraTexto, 5, $nomeAssinatura, 0, 0, 'L');

        $pdf->SetY(168);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(0, 10, mb_convert_encoding('Assinatura da Coordenação do Curso', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $pdf->SetFont('Arial', 'I', 10);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->SetXY(210, 179);
        $pdf->Cell(60, 10, mb_convert_encoding("ID do Certificado: $idCertificado", 'ISO-8859-1', 'UTF-8'), 0, 0, 'R');

        // Enviar headers para download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="certificado.pdf"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        ob_end_clean();
        $pdf->Output('D', 'certificado.pdf');
        exit; // para garantir que nada mais seja enviado
    }
} else {
    mostrarPopUp("Ocorreu um erro ao transferir o certificado,tente mais tarde");
    exit; // importante para parar o script aqui
}