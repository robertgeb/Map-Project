# Projeto Break check

***

## Etapas:
1. Modelar o banco de dados
2. Modelagem do site
3. Integrar o site e exibir dados
4. Adicionar funcionalidades

***

### Modelar o banco de dados


O banco de dados se baseia em coordenadas no Google maps e contém os elementos:

###### ID
identificador geral da coordenada

###### codigo
referencia na forma “país: estado/regiao: cidade: idioma: : ”

###### latitude
 latitude do endereço

###### longitude
 longitude do endereço

###### endereco
 endereço por extenso, se não houver é auto preenchido

###### nome
 nome da localidade

###### resumo
 dados adicionais que queiram adicionar.

###### bd_referenciado
 referencia o banco de dados com dados adicionais – só é exibido quando clica em mais informações

###### data_adicao
 data que foi adicionado formato YY-MM-DD HH:MM:SS

###### data_modific
 Data a ultima modificação que ocorreu nessa tabela (na forma YY-MM-DD HH:MM:SS)
###### verific_existe
 contador de quantas vezes o elemento foi avaliado como existente.

* OBS: Criar um campo para marcar que não existe, pois se ele estiver marcado irá ignorar o contador para todos os outros campos, se não, avaliar e comentar incrementa este contador.
verific_naoExiste: contador de que o local não existe
* OBS: Se o verific_naoExiste>verific_existe será posto um alerta que ele é duvidoso, se permanecer deste modo por um tempo o endereço não e exibido.
* OBS: demais observações na forma “obs: obs: : ”
avaliacao:  nota do restaurante em pontos de 0 a 10.

Foi optado pela ENGINE=ARCHIVE, pois  é voltado para a inserção rápida e grandes dados e pode ser comprimido ou descomprimido sobre demanda.

#### Criando DATABASE:
	CREATE DATABASE pontos COLLATE latin1_swedish_ci;

#### Criando MYSQL:
	CREATE TABLE IF NOT EXISTS pontos_mapa (
		ID INT AUTO_INCREMENT PRIMARY KEY,
		codigo VARCHAR(2000) NOT NULL,
		latitude VARCHAR (200) NOT NULL,
		longitude VARCHAR (200) NOT NULL,
		endereco VARCHAR (2000) NOT NULL,
		nome VARCHAR (2000) NOT NULL,
		resumo VARCHAR (2000),
		bd_referenciado VARCHAR(2000) NOT NULL,
		data_adicao TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
		data_ultima_modificacao TIMESTAMP NULL DEFAULT 	CURRENT_TIMESTAMP,
		verific_existe INT(11),
		verific_naoExiste INT (11),
		obs VARCHAR(2000),
		avaliacao INT(11)
	)ENGINE=ARCHIVE;

***

### Modelagem do Site

O site é usado como base php, focado na integração por includes e estruturado para que do client side o site seja um corpo único e sem muitos links externos. Modelo lógico do site:


***

### Manipulação e uso de códigos

#### Geração do mapa:
1. ###### Codigo completo:
		(function() {
			window.onload = function() {
				// Geração do mapa
				var map = new google.maps.Map(document.getElementById("map"), {
					center: new google.maps.LatLng(-22.6085, -43.7128),
					zoom: 15,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
				});

				// Gerando uma janela de informação global para ser reusado em 	todos os marcadores
				//var infoWindow = new google.maps.InfoWindow();

				// Criando loop para exibir todo o JSON
				for (var i = 0, length = json.length; i < length; i++) {
					var data = json[i],
					latLng = new google.maps.LatLng(data.latitude data.longitude);
					// inserindo marcador no mapa
					var marker = new google.maps.Marker({
						position: latLng,
						map: map,
						title: data.nome
					});

					//Gerando o encapsulamento para reter as informações corretas em cada loop
					(function(marker, data) {
						//Criando o evento em caso de clique no marcador
						google.maps.event.addListener(marker, "click", function(e) {
							//Gerando janela de informação suspensa
							//infoWindow.open(map, marker);
							//inserindo o conteúdo endereço na caixa de informação
							//infoWindow.setContent(data.endereco);
							//chamando a função externa do AJAX
							obter_dados(data.ID); // adicionar função Ajax
						});
							//Parâmetros usados na função de cada marcador
					})(marker, data);
				}
			}
		})();

2. ###### Inicialização da pagina:

		(function() {
			window.onload = function() {
				//Código escrito aqui
			}
		})();

 * Cria-se uma função vazia que é iniciada logo em seguida, quando a pagina é carregada pelo comando `window.onload = function()`. Dentro da função entra todo o código de criação do mapa.

	`<script type="text/javascript" src="php/listaJSON.php"></script>`
	Script que incorpora o JSON usado para posicionar os marcadores no mapa

* ###### Geração do mapa
O mapa é gerado usando o Google maps API em javascript1, como primeiro código é gerado o mapa:
		var map = new google.maps.Map(document.getElementById("map"),{
			center: new google.maps.LatLng(-22.6085, -43.7128),
			zoom: 15,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});

	* Neste código é gerado a variável map, que recebe a inicialização do mapa. O mapa é colocado dentro da id “map” por meio do `document.getElementById` e recebe um conjunto de parâmetros, os usados são:

		* Center – indica o centro do mapa;
		* Zoom – indica o zoom do mapa;
		* mapTypeId – indica o tipo de mapa. Outros formatos de exibição:
		* MapTypeId.ROADMAP  Exibe em format de ruas
		* MapTypeId.SATELLITE  Exibe como Satélite
		* MapTypeId.HYBRID  Mistura informal entre satélite e desenho
		* MapTypeId.TERRAIN  exibe em format de terreno
		* disableDefaultUI:true – Habilita ou desabilita(false) os menus embutidos no google maps.
		* icon:"imagem/close.png" – muda o ícone do marcador.

* ###### Geração do balão de informações do google maps
		// Creating a global infoWindow object that will be reused by all markers
		var infoWindow = new google.maps.InfoWindow();
	Cria-se uma variável que recebe o balão de informções do maps. Ele será repetidamente usado no loop que gera os marcadores no mapa, cada um com uma informação diferente.
O balão de informação inicialmente não está sendo usado, pois no seu lugar é usado um AJAX que exibe simultaneamente e detalhadamente os dados do marcador ao clicar nele. Futuramente ele pode ser usado em um evento para mostrar detalhes rápidos.

* ###### Loop de exibição dos marcadores
		for (var i = 0, length = json.length; i < length; i++) {
			var data = json[i],
			latLng = new google.maps.LatLng(data.latitude, data.longitude);
			// inserindo marcador no mapa
			var marker = new google.maps.Marker({
			position: latLng,
			map: map,
			title: data.nome
		});
Cria-se um loop usando o range do JSON gerado para exibir todos os marcadores no mapa.O loop ocorre ainda DENTRO DA INICIALIZAÇÃO DO MAPA,  primeiro se estabelece o Center, zoom e mapTypeId como parâmetros de entrada, e no corpo da função se insere os marcadores e demais eventos como as janelas.
Para que os valores do loop sejam exibidos eles são salvos em uma variável chamada “data” que contém toda a informação do marcador e demais dados. Em cada loop é gerado um valor para a variável latLng. Este é inserido logo em seguida na variável Mark onde é inserido no mapa, por meio da div map (trecho `map: map,`).

* ###### Evento de clique
		(function(marker, data) {
			//Criando o evento em caso de clique no marcador
			google.maps.event.addListener(marker, "click", function(e) {
				//Gerando janela de informação suspensa
				//infoWindow.open(map, marker);
				//inserindo o conteúdo endereço na caixa de informação
				//infoWindow.setContent(data.endereco);
				//chamando a função externa do AJAX
				obter_dados(data.ID); // adicionar função Ajax
			});
				//Parâmetros usados na função de cada marcador
		})(marker, data);
Esta função é aplicada sempre que é clicado em um marcador, isso ocorre por causa do evento dado por “google.maps.event.addListener(marker, "click", function(e) {“ onde ao clicar em qualquer elemento “marker” que no caso é o marcador, ele ira chamar a função “obter_dados(data.ID);”, que é uma função externa AJAX.


#### Funções externas

1. ###### Fechar Janela
function fechar_info(){
var fechar = document.getElementById('conteudo').style.display;
if(fechar == "block"){
document.getElementById('conteudo').style.display = 'none';
}
}
	Função javascript simples que é usada dentro da div conteúdo. A div por defaut está oculta para o usuário (display:none) e ao executar o AJAX por meio da função “obter_dados(data.ID)” ela se tora visível (display:block). Caso o usuário queira ocultar a div basta clicar no elemento que contém esta função que retorna a div para oculto.

* ###### Gerar o AJAX
		//função ajax
		function CriaRequest() {
		request = new XMLHttpRequest();
		if (!request)
		  alert("Seu Navegador não suporta Ajax!");
		else
		  return request;
		  }

		//função de requisição ajax
		function obter_dados (identificacao, div_usada, caminho){
		  var display = document.getElementById(div_usada).style.display;
		  if(display != "block"){
		    document.getElementById(div_usada).style.display = 'block';
		  };

		  var result = document.getElementById(div_usada);
		  var xmlreq = CriaRequest();

		  xmlreq.open("GET",caminho + identificacao, true);

		  // função para mudanças nos dados
		  xmlreq.onreadystatechange = function(){
		    // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		    if (xmlreq.readyState == 4) {
		      // Verifica se o arquivo foi encontrado com sucesso
		      if (xmlreq.status == 200) {
		        result.innerHTML = xmlreq.responseText;
		      }else{
		        result.innerHTML = "Erro: " + xmlreq.statusText;
		      }
		    }
		  };
		  xmlreq.send(null);
		};

* ######  Criando o XML
		function CriaRequest() {
		  request = new XMLHttpRequest();
		  if (!request)
		    alert("Seu Navegador não suporta Ajax!");
		  else
		    return request;
		}

Esta função cria uma requisição simples do HTML de uma pagina permitindo a montagem do balão de informações.

* ###### Obtendo a pagina
    function obter_dados (identificacao, div_usada,caminho){
      var display = document.getElementById(div_usada).style.display;
      if(display != "block"){
        document.getElementById(div_usada).style.display = 'block';
      };

      var result = document.getElementById(div_usada);
      var xmlreq = CriaRequest();

      xmlreq.open("GET",caminho + identificacao, true);

      // função para mudanças nos dados
      xmlreq.onreadystatechange = function(){
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
          // Verifica se o arquivo foi encontrado com sucesso
          if (xmlreq.status == 200) {
            result.innerHTML = xmlreq.responseText;
          }else{
            result.innerHTML = "Erro: " + xmlreq.statusText;
          }
        }
      };
      xmlreq.send(null);
    };

Esta função usa como parâmetros as entradas:
Identificação = id do Marker que foi clicado, para que seja feito uma busca no BD
div_usada= div que será exibido o resultado do AJAX
caminho – url de pesquisa onde se encontra o AJAX
O uso destas entradas ocorre para tornar a função AJAX versátil e utilizável em qualquer parte do site, reduzindo a necessidade de códigos.

		var display = document.getElementById(div_usada).style.display;
      if(display != "block"){
        document.getElementById(div_usada).style.display = 'block';
      };
A variável display captura a div que ficará o AJAX e muda seu display para block, tornando-a visível.

		var result = document.getElementById(div_usada);
      var xmlreq = CriaRequest();

    xmlreq.open("GET",caminho + identificacao, true);

A variavel result é uma nova captura da div que conterá o AJAX, mas desta vez é para exibir o seu conteúdo. Em seguida é chamada a função de request HTTP, salvo na variável xmlreq, e esta recebe os parâmetros: método de entrada, o caminho da url.

  	xmlreq.onreadystatechange = function(){
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
          // Verifica se o arquivo foi encontrado com sucesso
          if (xmlreq.status == 200) {
            result.innerHTML = xmlreq.responseText;
          }else{
            result.innerHTML = "Erro: " + xmlreq.statusText;
          }
        }
      };
      xmlreq.send(null);
    };

Esta parte da função verifica se a conexão foi bem sucedida (readystate=4) e se a pagina foi obtida com sucesso (xml.req=200). result.innerHTML contém o conteúdo HTML obtido e salvo na div. Por fim é feito um envio sem parâmetros (xmlreq.send(null);).

* ###### Php contendo dados – Página index.php
Ao fazer a requisição no trecho `xmlreq.open("GET",caminho + identificacao, true);` na página índex.php, é usado o caminho `php/informacao_marcador.php?buscasql=` e a div conteudo. O conteúdo do php informacao_marcador.php é:
		<?php
			include "conexao.php";
			// Verifica se a variável está vazia
			$buscasql=$_GET["buscasql"];
			if (empty($buscasql)) {
			  $sql = "SELECT * FROM pontos_mapa";
			} else {
			  $sql = "SELECT * FROM pontos_mapa WHERE ID like $buscasql";
			}
			$result = mysql_query($sql);
			$cont = mysql_affected_rows($conexao);
			// Verifica se a consulta retornou linhas
			if ($cont > 0) {
			  // Captura os dados da consulta e inseri na tabela HTML
			  while ($linha = mysql_fetch_array($result)) {
			      $return='O ponto é '.utf8_encode($linha["nome"]).
			      '<br>Sua latitude fica em '.utf8_encode($linha["latitude"]).
			      '<br> e sua longitude em '.utf8_encode($linha["longitude"]);
			  };
			  echo '<img class="close" src="imagem/close.png" alt="Fechar" onclick="fechar_janela()"/>';
			  echo $return;
			} else {
			  // Se a consulta não retornar nenhum valor, exibi mensagem para o usuário
			  echo "Não foram encontrados registros!";
			};
		?>
É importado os dados da conexão e é obtido a id do marcador pela variável $buscasql=$_GET["buscasql"]; e feito a busca no banco de dados normalmente. O while usado tem a função de exibir mais de uma informação no caso de concatenar pontos(que ocorrerá futuramente).
