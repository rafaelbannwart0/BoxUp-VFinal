<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Box Up!</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</head>

<body class="bg-[#FFFEE6] m-0 p-0">
  <main class="h-screen">
    <header class="!bg-[#000] h-16 flex items-center justify-between pr-10 pl-10 p-2 sticky top-0">
      <div>
        <h1 class="text-white font-medium text-2xl border-r border-white pr-2">BoxUP</h1>
      </div>
      <div>
        <a href="/BoxUp/src/pages/usuario/login.php">
          <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mt-1">Entre / cadastra-se</button>
        </a>
      </div>
    </header>

    <div class="div1 w-[80%] h-[90dvh] flex">
      <div class="d-flex flex-column align-items-start w-50 flex flex-col  items-start w-[50%]">
        <h1 class="text-start text-[45px] font-bold m-0 p-0" style="font-weight:600;">
          Agende sua mudança <br> aqui na
          <span class="text-blue-700">BoxUp</span>!
        </h1>
        <div class="text-black d-flex justify-content-start text-start opacity-80 text-[20px] mt-[20px] font-semibold flex justify-start" style="
            font-weight:600;
            text-shadow: none !important;
          ">
          Preparar-se para uma nova etapa da vida nunca foi tão fácil: descubra, agende e realize com tranquilidade sua mudanças residenciais, garantindo conforto e confiabilidade em cada passo do processo. <br />

        </div>
        <a href="./src/pages/usuario/login.php">
          <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mt-5">Mostre-me mais</button>
        </a>
      </div>
      <div class="imagemlanding"></div>
    </div>
  </main>
</body>

</html>
<style>
  .div1 {
    text-shadow: 1px 1px 5px rgba(0, 0, 0, 1);
    margin: 0 auto;
    text-align: center;
    letter-spacing: 1px;
    align-items: center;
  }

  body {
    font-family: Arial, sans-serif;
    background-color: #121824;
    overflow-x: hidden;
  }

  h1,
  h3,
  h5 {
    color: black;
    text-shadow: none;
  }

  p {
    text-shadow: none;
  }

  ::-webkit-scrollbar {
    width: 0px;
  }

  ::-webkit-scrollbar-thumb {
    background-color: #2e89c0;
  }

  ::-webkit-scrollbar-track {
    background-color: #121824;
  }

  .imagemlanding {
    width: 40%;
    height: 50%;
    background-image: url("./src/images/landing.png");
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
  }
</style>
<script>

</script>

</html>