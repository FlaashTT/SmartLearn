<?php
require('../../assets/fpdf186/fpdf.php');

$nomeAluno = "João Silva";
$nomeCurso = "Introdução à Programação";
$dataConclusao = date('d/m/Y');

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 24);

$pdf->Cell(0, 30, mb_convert_encoding('Certificado de Conclusão', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

$pdf->Ln(9);

$pdf->SetFont('Arial', '', 18);
$pdf->MultiCell(0, 10, mb_convert_encoding("Certificamos que o(a) aluno(a)\n", 'ISO-8859-1', 'UTF-8'), 0, 'C');
$pdf->SetFont('Arial', 'B', 20);
$pdf->MultiCell(0, 12, mb_convert_encoding($nomeAluno, 'ISO-8859-1', 'UTF-8'), 0, 'C');
$pdf->SetFont('Arial', '', 18);
$pdf->MultiCell(0, 10, mb_convert_encoding("concluiu com sucesso o curso:\n", 'ISO-8859-1', 'UTF-8'), 0, 'C');

$pdf->SetFont('Arial', 'B', 20);
$pdf->MultiCell(0, 12, mb_convert_encoding($nomeCurso, 'ISO-8859-1', 'UTF-8'), 0, 'C');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(0, 10, mb_convert_encoding("Concluído em: ", 'ISO-8859-1', 'UTF-8') . $dataConclusao, 0, 1, 'C');

$pdf->Ln(20);
$pdf->Line(100, 180, 200, 180);
$pdf->SetY(185);
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(0, 10, mb_convert_encoding('Assinatura da Coordenação', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');


// Headers para download correto
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="certificado.pdf"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$pdf->Output('D', 'certificado.pdf');

