<?php
require('../../assets/fpdf186/fpdf.php');

$nomeAluno = "João Silva";
$nomeCurso = "Introdução à Programação";
$dataConclusao = date('d/m/Y');

// Criar PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Definir cores
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetDrawColor(50, 50, 150);
$pdf->SetTextColor(0, 0, 0);

// Borda decorativa
$pdf->SetLineWidth(2);
$pdf->Rect(10, 10, 277, 190); // A4 horizontal com margens

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

// Linha e assinatura
$pdf->Line(100, 165, 200, 165);

$pdf->SetY(170);
$pdf->SetFont('Arial', '', 14);
$pdf->SetTextColor(0, 0, 0); // Garante que o texto também fique a preto
$pdf->Cell(0, 10, mb_convert_encoding('Assinatura da Coordenação do Curso', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

// Opcional: imagem de assinatura (se tiveres uma PNG transparente)
// $pdf->Image('../../assets/imagens/assinatura.png', 125, 140, 50);

// Headers para download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="certificado.pdf"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$pdf->Output('D', 'certificado.pdf');

