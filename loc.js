if ("geolocation" in navigator) {
    /* geolocation is available */
  } else {
    alert(
      "I'm sorry, but geolocation services are not supported by your browser.",
    );
  }
  var geolocation = Components.classes["@mozilla.org/geolocation;1"].getService(
    Components.interfaces.nsIDOMGeoGeolocation,
  );
  
  document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('btnLocalizacaoMotorista');
    const resultado = document.getElementById('resultadoLocalizacao');
  
    if (!btn || !resultado) {
      console.warn('Elementos de botão ou resultado não encontrados.');
      return;
    }
  
    // Verifica suporte à Geolocation API
    if (!('geolocation' in navigator)) {
      btn.addEventListener('click', () => {
        resultado.textContent = 'Geolocation não suportada pelo navegador.';
      });
      return;
    }
  
    btn.addEventListener('click', () => {
      resultado.textContent = 'Obtendo localização...';
  
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          const { latitude, longitude } = pos.coords;
          resultado.innerHTML = 
            `<p>Latitude: ${latitude.toFixed(6)}</p>` +
            `<p>Longitude: ${longitude.toFixed(6)}</p>`;
        },
        (err) => {
          let msg;
          switch (err.code) {
            case err.PERMISSION_DENIED:
              msg = 'Permissão negada pelo usuário.';
              break;
            case err.POSITION_UNAVAILABLE:
              msg = 'Posição indisponível.';
              break;
            case err.TIMEOUT:
              msg = 'Tempo de requisição esgotado.';
              break;
            default:
              msg = 'Erro desconhecido ao obter localização.';
          }
          resultado.textContent = msg;
        },
        {
          enableHighAccuracy: true,
          timeout: 7000,
          maximumAge: 0
        }
      );
    });
  });
  