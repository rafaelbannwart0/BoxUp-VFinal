<?php
// Inicia a sessão, se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define um usuário padrão caso não esteja logado
$user = $_SESSION['user'] ?? [
    'motorista' => 0, // padrão como usuário normal
    'nome' => 'Visitante'
];
?>
<head>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/BoxUp/src/js/jquery.min.js"></script>
  <title>BoxUp!</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</head>

<body class="h-screen">
  <nav class="fixed top-0 w-full bg-gray-900 z-50">
    <div class="max-w-screen-xl mx-auto px-6 py-4 flex flex-wrap items-center justify-center">

      <!-- Logo / Home -->
      <a href="/BoxUp/src/pages/home/home.php" class="flex items-center mr-6">
        <h1 class="text-white font-medium text-2xl border-r border-white pr-2">BoxUP</h1>
        <?php if ($user["motorista"] == 1): ?>
          <h3 class="text-gray-200 opacity-80 ml-3 font-semibold">Menu de motorista</h3>
        <?php else: ?>
          <h3 class="text-gray-200 opacity-80 ml-3 font-semibold">Menu de usuário</h3>
        <?php endif; ?>
      </a>

      <!-- Botão hambúrguer para mobile -->
      <button data-collapse-toggle="navbar-default"
        type="button"
        class="md:hidden ml-auto p-2 text-gray-400 hover:text-white focus:outline-none"
        aria-controls="navbar-default"
        aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Links -->
      <div class="hidden w-full md:flex md:items-center md:justify-center mt-4 md:mt-0" id="navbar-default">
        <ul class="flex flex-col md:flex-row md:space-x-8 items-center text-center">
          <li>
            <a href="/BoxUp/src/pages/suporte/index.php"
              class="block py-2 md:py-0 text-white hover:underline">
              Suporte
            </a>
          </li>
          <li>
            <a href="/BoxUp/src/pages/politicas/index.php"
              class="block py-2 md:py-0 text-white hover:underline">
              FAQ
            </a>
          </li>
          <?php if ($user["motorista"] == 1): ?>
            <li>
              <a href="/BoxUp/src/pages/mudanca/vermotorista.php"
                class="block py-2 md:py-0 text-white hover:underline">
                Minhas Mudanças
              </a>
            </li>
          <?php else: ?>
            <li>
              <a href="/BoxUp/src/pages/mudanca/ver.php"
                class="block py-2 md:py-0 text-white hover:underline">
                Minhas Mudanças
              </a>
            </li>
          <?php endif; ?>

          <?php if ($user["motorista"] == 1): ?>
          <li>
            <a href="/BoxUp/src/pages/geolocation/motoristas.php"
              class="block py-2 md:py-0 text-white hover:underline">
              Localização Motoristas
            </a>
          </li>
          <?php else: ?> <!-- Aqui, o correto seria clientes.php. porem como vcs fizeram tudo na mesma pag, deixei tudo como motorista*/ -->
          <li>
            <a href="/BoxUp/src/pages/geolocation/clientes.php"
              class="block py-2 md:py-0 text-white hover:underline">
              Localização Motoristas
            </a>
          </li>
          <?php endif; ?>


          <!-- Logout -->
          <li class="md:ml-auto">
            <a href="/BoxUp/src/pages/usuario/login.php"
              class="block p-2 bg-blue-600 hover:bg-blue-700 rounded text-white transition">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" width="24" height="24" fill="white">
                <path d="M932.254,490.726L772.835,331.315c-11.754-11.755-30.775-11.771-42.53-0.094
                        c-11.786,11.684-11.896,30.748-0.267,42.582L836.411,482H408.187
                        c-16.636,0-30.132,13.357-30.132,30s13.497,30,30.132,30H838.2
                        L730.21,650.055c-11.755,11.763-11.755,30.887,0,42.649
                        c5.885,5.885,13.606,8.848,21.312,8.848c7.706,0,15.427-2.933,21.312-8.818
                        l159.419-159.406c5.649-5.65,8.82-13.314,8.82-21.302
                        C941.073,504.039,937.903,496.375,932.254,490.726z"/>
                <path d="M698.927,787.552c-16.636,0-30,13.489-30,30.132V964h-526V60h526v146.376
                        c0,16.643,13.364,30.132,30,30.132c16.635,0,30-13.489,30-30.132V29.914
                        C728.927,13.27,715.238,0,698.603,0H113.032C96.397,0,82.927,13.27,82.927,29.914v964.233
                        c0,16.643,13.47,29.854,30.106,29.854h585.571c16.635,0,30.324-13.21,30.324-29.854V817.684
                        C728.927,801.041,715.562,787.552,698.927,787.552z"/>
              </svg>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</body>
