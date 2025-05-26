<?php
function mostrarPopUp($mensagem, $tempo = null, $caminho = null)
{
    // Define tempo padrão se for true
    $tempoFinal = ($tempo === true) ? 5000 : ($tempo ?? 0); // 0 = manual (com botão)

    echo <<<HTML
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="fecharPopup()">&times;</span>
            <p>{$mensagem}</p>
            <button onclick="fecharPopup()" style="margin-top: 15px; padding: 10px 20px; border: none; background-color: #007bff; color: white; border-radius: 6px; cursor: pointer;">Fechar</button>
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
            ircaminho();
        }

        mostrarPopup({$tempoFinal});


        function ircaminho() {
        var caminho = "<?php echo $caminho; ?>"; // passar a variável PHP para JS

        if (caminho) {
            window.location.href = document.referrer;
        } 
    }
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
        background-color: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(3px);
        animation: fadeIn 0.3s ease-in-out;
    }

    .popup-content {
        background: linear-gradient(145deg, #ffffff, #f1f1f1);
        margin: auto;
        margin-top: 12%;
        padding: 30px;
        border-radius: 16px;
        width: 350px;
        max-width: 90%;
        text-align: center;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        position: relative;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        animation: slideIn 0.4s ease-out;
    }

    .close-btn {
        position: absolute;
        top: 12px;
        right: 16px;
        cursor: pointer;
        font-size: 22px;
        color: #555;
        transition: color 0.2s ease;
    }

    .close-btn:hover {
        color: #000;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>