<?php
function mostrarPopUp($mensagem, $tempo = null) {
    // Define tempo padrão se for true
    $tempoFinal = ($tempo === true) ? 5000 : ($tempo ?? 0); // 0 = manual (com botão)

    echo <<<HTML
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="fecharPopup()">&times;</span>
            <p>{$mensagem}</p>
        </div>
    </div>

    <script>
        function mostrarPopup(tempo = 0) {
            const popup = document.getElementById('popup');
            popup.style.display = 'block';

            if (tempo > 0) {
                setTimeout(() => {
                    popup.style.display = 'none';
                }, tempo);
            }
        }

        function fecharPopup() {
            document.getElementById('popup').style.display = 'none';
        }

        mostrarPopup({$tempoFinal});
    </script>
HTML;
}
?>

<style>
    .popup {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .popup-content {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border-radius: 10px;
        width: 300px;
        text-align: center;
        box-shadow: 0 0 10px black;
        position: relative;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        cursor: pointer;
        font-size: 20px;
    }
</style>