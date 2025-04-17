<?php
include("../segurança.php");
include("../../database/basedados.sql");

$erro = false;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $erro = true;
}
$idCurso = $_POST['idcurso'];
if (empty($idCurso)) {
    echo "
    <script>
        alert('Ocorreu um erro de ligação,tente novamente!');
    </script>";
    $erro = true;
}
?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartLearn</title>
    <link
        rel="stylesheet"
        href="../../assets/fontawesome/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/style_user.css" />
    <link rel="stylesheet" href="../../assets/css/style_curso_conteudo.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <?php
    include("../../src/views/utils/cabecalho.html");


    $stmt = $conn->prepare("
        SELECT * 
        FROM cursos_adquiridos ca
        INNER JOIN curso c ON ca.Id_curso = c.Id_curso
        WHERE ca.Id_user = ?;
    ");
    $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();

    ?>

        <!-- Secção Principal (Hero) -->
        <main class="container">
            <main class="container-c">
                <section class="curso-info">
                    <?php
                    echo '
                    <h1>'.$row['Nome_curso'].'</h1>
                    
                    <p>'.$row['Percentagem_progresso'].'% Concluído</p>

    ';

                    ?>
                    <div class="content">
                        <div class="scrollable-content">
                            <section class="step">
                                <!-- Mídia: Vídeo ou Imagem -->
                                <div class="media">
                                    <video controls>

                                    
                                        <source src="" type="video/mp4" />
                                        Seu navegador não suporta o elemento de vídeo.
                                    </video>
                                    <!-- Alternativa: Imagem -->
                                    <!-- <img src="/assets/image/capa_curso.png" alt="Capa do Curso"> -->
                                </div>

                                <!-- Título Principal -->
                                <h2>Introdução à Tecnologia</h2>
                                <p>
                                    A tecnologia é o conjunto de conhecimentos e ferramentas que
                                    permitem a criação de soluções para problemas do dia a dia.
                                    Ela está presente em todos os aspectos da nossa vida, desde os
                                    dispositivos que usamos até os sistemas que gerenciam grandes
                                    empresas.
                                </p>

                                <!-- Seção: História da Tecnologia -->
                                <h3>História da Tecnologia</h3>
                                <p>
                                    A tecnologia começou com ferramentas simples, como pedras
                                    afiadas e fogo, e evoluiu para invenções revolucionárias, como
                                    a roda, a eletricidade e os computadores. Hoje, vivemos na era
                                    digital, onde a tecnologia avança em um ritmo acelerado.
                                </p>

                                <!-- Seção: Impacto da Tecnologia -->
                                <h3>Impacto da Tecnologia</h3>
                                <p>
                                    A tecnologia transformou a forma como nos comunicamos,
                                    trabalhamos e vivemos. Ela trouxe benefícios como maior
                                    eficiência, acesso à informação e avanços na medicina. No
                                    entanto, também apresenta desafios, como questões éticas e
                                    impactos ambientais.
                                </p>

                                <!-- Seção: Áreas de Tecnologia -->
                                <h3>Áreas de Tecnologia</h3>
                                <ul>
                                    <li>
                                        <strong>Inteligência Artificial:</strong> Sistemas que
                                        simulam a inteligência humana.
                                    </li>
                                    <li>
                                        <strong>Internet das Coisas (IoT):</strong> Dispositivos
                                        conectados que trocam informações.
                                    </li>
                                    <li>
                                        <strong>Computação em Nuvem:</strong> Armazenamento e
                                        processamento de dados online.
                                    </li>
                                    <li>
                                        <strong>Desenvolvimento de Software:</strong> Criação de
                                        aplicativos e sistemas.
                                    </li>
                                    <li>
                                        <strong>Segurança Cibernética:</strong> Proteção contra
                                        ataques digitais.
                                    </li>
                                </ul>

                                <!-- Seção: Futuro da Tecnologia -->
                                <h3>Futuro da Tecnologia</h3>
                                <p>
                                    O futuro da tecnologia é promissor, com avanços em áreas como
                                    computação quântica, biotecnologia e exploração espacial. A
                                    inovação continuará a moldar o mundo e a criar novas
                                    oportunidades.
                                </p>

                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Idade</th>
                                            <th>Profissão</th>
                                            <th>País</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>João Silva</td>
                                            <td>30</td>
                                            <td>Engenheiro</td>
                                            <td>Brasil</td>
                                        </tr>
                                        <tr>
                                            <td>Maria Oliveira</td>
                                            <td>25</td>
                                            <td>Designer</td>
                                            <td>Portugal</td>
                                        </tr>
                                        <tr>
                                            <td>Carlos Santos</td>
                                            <td>40</td>
                                            <td>Professor</td>
                                            <td>Angola</td>
                                        </tr>
                                        <tr>
                                            <td>Ana Costa</td>
                                            <td>35</td>
                                            <td>Advogada</td>
                                            <td>Moçambique</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- Imagem Isolada -->
                                <h3>Imagem Isolada</h3>
                                <img
                                    src="../../assets/image/curso.png"
                                    alt="Imagem Grande"
                                    style="width: 100%; height: auto; border-radius: 8px" />
                            </section>
                        </div>
                        <div class="sidebar">
                            <h3>Conteúdo</h3>
                            <ul>
                                <?php

                                ?>
                                <li>Fase 1: Principal</li>
                                <li>Fase 2: Principal</li>
                                <li>Fase 3: Principal</li>
                                <li>Fase 4: Principal</li>
                                <li>Fase 5: Principal</li>
                                <li>Fase 6: Principal</li>
                                <li>Fase 7: Principal</li>
                                <li>Fase 8: Principal</li>
                                <li>Fase 9: Principal</li>
                                <li>Fase 10: Principal</li>
                                <li>Fase 11: Principal</li>
                                <li>Fase 12: Principal</li>
                                <li>Fase 13: Principal</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <div class="notes">
                    <label for="notes">Notas:</label>
                    <textarea id="notes" maxlength="500" placeholder="Escreva suas notas aqui..."></textarea>
                    <p id="char-count">0/2500 caracteres</p>
                </div>

                <footer class="footer-c">
                    <button class="avançar">Concluir</button>
                </footer>
            </main>
        </main>

        <!-- Rodapé -->
        <footer class="footer">
            <div class="footer-map">
                <!-- Aqui podes adicionar um iframe com o Google Maps -->
                <iframe
                    src="https://g.co/kgs/bK5fDXa"
                    width="100%"
                    height="300"
                    frameborder="0"
                    style="border: 0"
                    allowfullscreen=""
                    aria-hidden="false"
                    tabindex="0"></iframe>
            </div>
            <div class="container footer-content">
                <p>2025 Copyright by Leando Pinto e Ruben Pinheiro</p>
                <p>Castelo Branco – Rua Esperança – 6200-000</p>
                <p>Email: teste@gmail.com | Telefone: 255 777 222 | Fax: 966 662 222</p>
                <p>Privacy Policy | Terms & Conditions</p>
            </div>
        </footer>

        <script>
            const textarea = document.getElementById('notes');
            const charCount = document.getElementById('char-count');

            textarea.addEventListener('input', () => {
                charCount.textContent = `${textarea.value.length}/2500 caracteres`;
            });

            textarea.addEventListener('input', () => {
                textarea.style.height = 'auto'; // Reseta a altura
                textarea.style.height = `${textarea.scrollHeight}px`; // Ajusta à altura do conteúdo
            });
            textarea.addEventListener('input', () => {
                const maxWords = 100;
                const words = textarea.value.split(/\s+/).filter(word => word.length > 0);
                if (words.length > maxWords) {
                    textarea.value = words.slice(0, maxWords).join(' ');
                }
                charCount.textContent = `${words.length}/${maxWords} palavras`;
            });
        </script>
</body>

</html>






<?php
    }


   /* if ($erro) {
        echo "
    <script>
        window.history.back();
    </script>
    ";
        exit();
    }*/
?>