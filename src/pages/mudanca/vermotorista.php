<?php
session_start();

if ($_SESSION["user"]["motorista"] != 1) {
    header("Location: ../usuario/login.php");
    exit;
}
?>


<!-- component -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
</head>
<?php include_once("../header.php") ?>

<script>
    

    function excluirmudanca(id) {
        var html = `<div class="flex gap-3"><button type="button" class="w-full text-white  font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700" id="excluir">Excluir</button>
                    <button type="button" class="w-full text-white  font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700" id="cancelar">Cancelar</button></div>`

        swal.fire({
            title: 'Tem certeza que quer excluir a mudança?',
            html: html,
            icon: 'info',
            showConfirmButton: false,
            customClass: {
                popup: 'my-swal-popup-class',
                confirmButton: 'my-confirm-button-class'
            }
        })


        $("#excluir").click(() => {
            $.ajax({
                url: "/BoxUp/src/api/controller/ExcluirMudanca.php",
                method: "POST",
                data: {
                    id
                },
                success: () => {
                    swal.fire({
                        icon: "success",
                        title: "Mudança deletada com sucesso",
                        customClass: {
                            popup: 'my-swal-popup-class',
                            confirmButton: 'my-confirm-button-class'
                        }
                    })

                    buscaMudancas();
                },
                error: (error) => {
                    swal.fire({
                        icon: "error",
                        title: data.data.message,
                        customClass: {
                            popup: 'my-swal-popup-class',
                            confirmButton: 'my-confirm-button-class'
                        }
                    })
                }
            })
        })

        $("#cancelar").click(() => {
            swal.close()
        })
    };
function buscaMudancas() {
    $.ajax({
        url: "/BoxUp/src/api/controller/ListarMudancaMotorista.php",
        method: "GET",
        success: (data) => {
            data = JSON.parse(data);
            let html = "";

            if (data.data.length > 0) {
                data.data.forEach(element => {
                    const total = element.preco * element.km;

                    const chatVisible = element.hasChat;
                    const chatText = chatVisible ? 'Abrir Chat' : 'Iniciar Chat';
                    const chatClass = chatVisible ? 'bg-green-700 hover:bg-green-800' : 'bg-gray-600 hover:bg-gray-700';

                    html += `
                    <div class="max-w-[30rem] p-6 mb-5 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <img src="/BoxUp/src/images/caminhaosemfundo.png" width="100" alt="Perfil" />
                            <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">${element.endereco_final}</h5>
                        </div>
                        <div class="flex flex-col gap-2 mt-4">
                            <div>
                                <label class="block mb-1 text-sm font-normal dark:text-gray-400">Endereço inicial:</label>
                                <input disabled value="${element.endereco_inicial}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg w-full p-2 dark:bg-gray-900 dark:border-black dark:text-gray-300" />
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-normal dark:text-gray-400">Endereço final:</label>
                                <input disabled value="${element.endereco_final}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg w-full p-2 dark:bg-gray-900 dark:border-black dark:text-gray-300" />
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 mt-3">
                            <div>
                                <label class="block mb-1 text-sm font-normal dark:text-gray-400">Valor da mudança:</label>
                                <input disabled value="R$ ${total}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg w-full p-2 dark:bg-gray-900 dark:border-black dark:text-gray-300" />
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-normal dark:text-gray-400">Status da mudança:</label>
                                <input disabled value="${element.status == 0 ? 'Em andamento' : element.status == 1 ? 'Concluída' : 'Cancelada'}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg w-full p-2 dark:bg-gray-900 dark:border-black dark:text-gray-300" />
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="block mb-1 text-sm font-normal dark:text-gray-400">Objetos:</label>
                            <textarea disabled rows="3" class="resize-none block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-900 dark:border-black dark:text-gray-300">${element.objetos}</textarea>
                        </div>
                        <div class="mt-3">
                            <label class="block mb-1 text-sm font-normal dark:text-gray-400">Observações:</label>
                            <textarea disabled rows="4" class="resize-none block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-900 dark:border-black dark:text-gray-300">${element.observacoes.trim() === "" ? "Não possui observações" : element.observacoes}</textarea>
                        </div>
                        <div class="flex gap-2 mt-5">
            <button 
                onclick="abrirOuCriarChat(${element.mudanca_id}, ${chatVisible})"
                class="px-2 py-2 text-sm font-medium text-white inline-flex items-center ${chatClass} rounded-lg"
            >
                <img src="/BoxUp/src/images/chat.png" width="20" />
                <span class="ml-1">${chatText}</span>
            </button>
        </div>
                    </div>`;
                });

                $("#container").html(html);
            } else {
                $("#container").html("<p class='text-2xl font-bold text-white'>Nenhuma mudança agendada <span class='text-blue-700'>ainda!</span></p>");
            }
        },
        error: (err) => console.error("Erro ao buscar mudanças:", err)
    });
}


function abrirOuCriarChat(mudancaId, hasChat) {
    if (hasChat) {
        window.location.href = `/BoxUp/src/pages/chat/chat.php?mudanca_id=${mudancaId}`;
    } else {
        $.ajax({
            url: "/BoxUp/src/api/controller/CriarChatController.php",
            method: "POST",
            data: { mudanca_id: mudancaId },
            success: () => window.location.href = `/BoxUp/src/pages/chat/chat.php?mudanca_id=${mudancaId}`,
            error: () => swal.fire({ icon: "error", title: "Erro ao iniciar o chat" })
        });
    }
}



    function abrirmodal(id, selected) {
        var html = `<div style="display: flex; flex-direction: column; align-items: start" class="flex flex-column items-start">
                        <label for="selectdms" class="block mb-2 text-sm font-medium text-white">Alterar status:</label>
                        <select id="selectdms" class="border border-gray-300 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-300 dark:border-gray-200 dark:placeholder-gray-700 dark:text-gray-700">
                            <option value="0" ${selected == 0 ? "selected" : ""}>Em andamento</option>
                            <option value="1" ${selected == 1 ? "selected" : ""}>Concluida</option>
                            <option value="2" ${selected == 2 ? "selected" : ""}>Cancelada</option>
                        </select>
                    </div>`
        swal.fire({
            title: 'Editar mudança',
            html: html,
            icon: 'info',
            customClass: {
                popup: 'my-swal-popup-class',
                confirmButton: 'my-confirm-button-class'
            }
        }).then((result) => {
            if (result) {
                $.ajax({
                    url: "/BoxUp/src/api/controller/EditarMudanca.php",
                    method: "POST",
                    data: {
                        status: $("#selectdms").val(),
                        id
                    },
                    success: (data) => {
                        swal.fire({
                            icon: "success",
                            title: "Status editado!",
                            customClass: {
                                popup: 'my-swal-popup-class',
                                confirmButton: 'my-confirm-button-class'
                            }
                        })

                        buscaMudancas();
                    },
                    error: (error) => {
                        swal.fire({
                            icon: "error",
                            title: error.error,
                            customClass: {
                                popup: 'my-swal-popup-class',
                                confirmButton: 'my-confirm-button-class'
                            }
                        })

                    }
                })
            }
        })
    };

    buscaMudancas();
</script>

<div class="bg-[#191825] min-h-screen">
    <div class="text-start text-[35px] mt-10 font-bold text-blue-700 pt-[5%] ml-[5%]">Ver as minhas mudanças</div>
    <div id="container" class="grid grid-cols-4 pt-6 gap-5 px-16">

    </div>
</div>


<?php include_once("../footer.php") ?>


</html>
<style>
    .my-swal-popup-class {
        background-color: #374151;
        color: white;
    }

    .my-confirm-button-class {
        background-color: #2563eb;
        color: black;
    }
</style>