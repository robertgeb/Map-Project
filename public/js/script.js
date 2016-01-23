  //função ajax
  function CriaRequest() {
    request = new XMLHttpRequest();
    if (!request)
      alert("Navegador não suportado!");
    else
      return request;
  }

  //função de requisição ajax
  function obter_dados(identificacao, div_usada, caminho) {
    var display = document.getElementById(div_usada).style.display;
    if (display != "block") {
      document.getElementById(div_usada).style.display = 'block';
    }

    var result = document.getElementById(div_usada);
    var xmlreq = CriaRequest();

    xmlreq.open("GET", caminho + identificacao, true);

    // função para mudanças nos dados
    xmlreq.onreadystatechange = function() {
      // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
      if (xmlreq.readyState == 4) {
        // Verifica se o arquivo foi encontrado com sucesso
        if (xmlreq.status == 200) {
          result.innerHTML = xmlreq.responseText;
        } else {
          result.innerHTML = "Erro: " + xmlreq.statusText;
        }
      }
    };
    xmlreq.send(null);
  }

  //funcao para ocultar a janela flutuante superior
  function fechar_janela() {
    var display = document.getElementById("conteudo").style.display;
    if (display != "none") {
      document.getElementById("conteudo").style.display = 'none';
    }
  }


  (function() {
    window.onload = function() {
      // Geracao do mapa
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(-22.6085, -43.7128),
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      // Gerando uma janela de informacao global para ser reusado em todos os marcadores
      var infoWindow = new google.maps.InfoWindow();
      // Criando loop para exibir todo o JSON

      for (var i = 0, length = json.length; i < length; i++) {
        var data = json[i],
          latLng = new google.maps.LatLng(data.latitude, data.longitude);
        // inserindo marcador no mapa
        var marker = new google.maps.Marker({
          position: latLng,
          map: map,
          title: data.nome,
        });

        //Gerando o encapsulamento para reter as informacões corretas em cada loop
        (function(marker, data) {
          //Criando o evento em caso de clique no marcador
          google.maps.event.addListener(marker, "click", function(e) {
            //Gerando janela de informacao suspensa
            //infoWindow.open(map, marker);
            //inserindo o conteúdo endereco na caixa de informacao
            //infoWindow.setContent(data.endereco);
            //chamando a funcao externa do AJAX
            obter_dados(data.ID, "conteudo", "php/show_map/informacao_marcador.php?buscasql=");
            // adicionar funcao Ajax
          });
          //Parametros usados na funcao de cada marcador
        })(marker, data);
      }
    };
  })();
