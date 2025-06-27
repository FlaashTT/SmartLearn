<?php
require('../../assets/fpdf186/fpdf.php');

$nomeAluno = "João Silva";
$nomeCurso = "Introdução à Programação";
$dataConclusao = date('d/m/Y');

// Criar PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Inserir logótipo no canto superior esquerdo
$pdf->Image('../../assets/image/Logo.png', 15, 12, 40); // ajusta o caminho e tamanho se necessário

// Cor da borda decorativa (azul)
$pdf->SetDrawColor(50, 50, 150);
$pdf->SetLineWidth(2);
$pdf->Rect(10, 10, 277, 190); // A4 horizontal com margens

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

// Cor preta para linha da assinatura
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->Line(100, 165, 200, 165);

// Nome da coordenadora (em cima da linha)
$nomeAssinatura = "Joana Correia";
$pdf->SetFont('Arial', '',16);
$pdf->SetTextColor(0, 0, 0);

// Calcular posição para centrar o nome na linha (de 100 a 200 mm)
$larguraTexto = $pdf->GetStringWidth($nomeAssinatura);
$x = 100 + (100 - $larguraTexto) / 2; // linha tem 100 mm de comprimento
$y = 158; // ligeiramente acima da linha

$pdf->SetXY($x, $y);
$pdf->Cell($larguraTexto, 5, $nomeAssinatura, 0, 0, 'L');

// Texto por baixo da linha (legenda)
$pdf->SetY(168); // um pouco abaixo da linha
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(0, 10, mb_convert_encoding('Assinatura da Coordenação do Curso', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

// ID de Certificação no canto inferior direito
$idCertificado = strtoupper(substr(md5($nomeAluno . $nomeCurso . $dataConclusao), 0, 10)); // Gera um ID baseado no conteúdo
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetTextColor(100, 100, 100);
$pdf->SetXY(210, 179); // posiciona na horizontal e vertical dentro da página A4 Landscape (297x210mm)
$pdf->Cell(60, 10, mb_convert_encoding("ID do Certificado: $idCertificado", 'ISO-8859-1', 'UTF-8'), 0, 0, 'R');


// Headers para download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="certificado.pdf"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$pdf->Output('D', 'certificado.pdf');