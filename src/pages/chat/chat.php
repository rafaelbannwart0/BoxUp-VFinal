<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user = $_SESSION["user"];

$mudanca_id = isset($_GET['mudanca_id']) ? intval($_GET['mudanca_id']) : 0;
if ($mudanca_id <= 0) {
    echo "Mudança inválida!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<?php include_once("../header.php") ?>

<div class="min-h-screen bg-[#191825] py-12 px-6 flex flex-col">
    <h1 class="text-[35px] font-bold text-blue-700 mb-6">Chat da mudança #<?php echo $mudanca_id; ?></h1>

    <div id="chat-box" class="flex-1 overflow-y-auto mb-4 p-4 bg-gray-900 rounded-lg space-y-3">
        <!-- Mensagens serão renderizadas aqui -->
    </div>

    <div class="flex gap-2">
        <input id="message-input" type="text" placeholder="Digite sua mensagem..."
            class="flex-1 p-2 rounded-lg border border-gray-300 dark:bg-gray-800 dark:text-white" />
        <button id="send-btn" class="bg-blue-700 text-white px-4 py-2 rounded-lg">Enviar</button>
    </div>
</div>

<script>
const mudancaId = <?php echo $mudanca_id; ?>;
const userId = "<?php echo $user['id']; ?>";

function loadMessages() {
    $.ajax({
        url: "/BoxUp/src/api/controller/GetChatController.php",
        method: "GET",
        data: { mudanca_id: mudancaId },
        success: function(data) {
            const messages = JSON.parse(data);
            let html = "";
            messages.forEach(msg => {
                const alignment = msg.remetente_id == userId ? "justify-end" : "justify-start";
                const bgColor = msg.remetente_id == userId ? "bg-blue-700 text-white" : "bg-gray-700 text-white";

                html += `<div class="flex ${alignment}">
                            <div class="p-2 rounded-lg ${bgColor} max-w-xs break-words">${msg.mensagem}</div>
                        </div>`;
            });
            $("#chat-box").html(html);
            $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
        }
    });
}

$("#send-btn").click(function() {
    const message = $("#message-input").val().trim();
    if (!message) return;

    $.post("/BoxUp/src/api/controller/SendChatController.php", 
        { mensagem: message, mudanca_id: mudancaId }, 
        function() {
            $("#message-input").val("");
            loadMessages();
        }
    );
});

setInterval(loadMessages, 2000);
loadMessages();
</script>

<?php include_once("../footer.php") ?>

</html>
