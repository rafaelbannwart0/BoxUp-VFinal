<?php
require __DIR__ . '/../header.php';
?>

<main class="p-6 bg-gray-100 min-h-screen pt-24 p-4">
  <div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 mt-10">Localização do Cliente</h1>
    
    <p id="status" class="mb-4 p-2 bg-yellow-100 text-yellow-800 rounded shadow-sm">
      Obtendo localização…
    </p>
    
    <div id="map" class="w-full h-[500px] rounded-xl shadow-lg border border-gray-300"></div>
  </div>
</main>

<?php
require __DIR__ . '/../footer.php';
?>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
  $(function() {
    if (!navigator.geolocation) {
      $('#status').text('Geolocalização não suportada pelo navegador.');
      return;
    }

    // Inicializa o mapa (começa no Brasil como fallback)
    const map = L.map('map', {
      zoomControl: true,   // mostra controle +/-
      dragging: true,      // permite arrastar
      scrollWheelZoom: true, // zoom com scroll
      doubleClickZoom: true, // zoom com duplo clique
      touchZoom: true        // zoom em telas touch
    }).setView([-14.235, -51.9253], 4);


    // Adiciona o tile layer (mapa base)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap'
    }).addTo(map);

    let marker = null;
    let rota = null;

    // Obter posição em tempo real
    function atualizarLocalizacao() {
      navigator.geolocation.getCurrentPosition(
        function(pos) {
        $('#status').text('Localização obtida com sucesso.')
          .delay(3000)      // espera 3 segundos
          .fadeOut('slow'); // desaparece suavemente
          const lat = pos.coords.latitude;
          const lon = pos.coords.longitude;

          if (marker) {
            marker.setLatLng([lat, lon]);
          } else {
            marker = L.marker([lat, lon]).addTo(map)
              .bindPopup("Cliente aqui").openPopup();
            map.setView([lat, lon], 15); // só centraliza na primeira vez
          }

          
          $.post('/src/api/controller/EnviarLocalizacaoController.php', {
            tipo: 'motorista',
            lat: lat,
            lon: lon
          }).done(function(resp){
            console.log("Localização enviada:", resp);
          });
          
        },
        function(err) {
          $('#status').text('Erro ao obter localização: ' + err.message);
        },
        {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 0
        }
      );
    }

    // Atualiza a cada 5 segundos
    atualizarLocalizacao();
    setInterval(atualizarLocalizacao, 5000);

    // (Opcional) Mostrar rota fixa A → B
    function desenharRota(pontoA, pontoB) {
      if (rota) {
        map.removeLayer(rota);
      }
      rota = L.polyline([pontoA, pontoB], {color: 'blue'}).addTo(map);
      map.fitBounds([pontoA, pontoB]);
    }

    // Exemplo de rota fixa (pode vir do backend)
    // desenharRota([-23.55, -46.63], [-22.90, -47.06]);
  });
</script>
