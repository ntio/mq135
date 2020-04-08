<html>

<head>
	<title>Arduino.mq135 chart</title>
	 <script src="../js/jquery.min.js"></script>
	<script src="../js/Chart.min.js"></script>
	<script src="../js/utils.js"></script>
	
	
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> -->
	<style>
	canvas{
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	#reloj { width: 150px; height: 30px; padding: 5px 10px; border: 1px solid black; 
         font: bold 1.5em dotum, "lucida sans", arial; text-align: center;
         float: right; margin: 1em 3em 1em 1em; }
	</style>
	
</head>

<body>
	<div style="width:75%;">
		<canvas id="canvas"></canvas>
	</div>
		
    <div id="reloj">
   00 : 00 : 00
  </div>
	<script>
	  function getData(url) {
        obj = {fecha: [], valor: []};
        var fecha = [], valor = [];

        var jsonData = $.ajax({
          url: url,
          dataType: 'json',
          async: false
        }).done(function (results) {
          // Split timestamp and data into separate arrays
          results.forEach(function(packet) {
            fecha.push(packet.fecha);
            valor.push(packet.valor);
            
          });
        });
        obj["fecha"] = fecha;
        obj["valor"] = valor;
        return obj;
      }

	    
		 var mq135datos = getData('getvalores.php?q=y');
		var config = {
		    labels : mq135datos.fecha,
			datasets: [{
					label: 'PPM',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data:mq135datos.valor,
					fill: false,
				
				}]
			};
			
      // Get the context of the canvas element we want to select
       Chart.defaults.global.defaultFontSize = 18;
      var ctx = document.getElementById("canvas").getContext("2d");
      var mq135chart = new Chart(ctx, {
        type: 'line',
        data: config,
        animation:{
          animateScale: true
        },
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'MQ135.valor'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{					   
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Fecha'
						},
						ticks: {
							reverse: true
						}
					}],
					yAxes: [{
					     ticks: {
                        beginAtZero: true
                            },
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'CO2 en PPM'
						}
					}]
				}
			}
		});

		
				
		function actual() {
         fecha2=new Date(); //Actualizar fecha.
         hora=fecha2.getHours(); //hora actual
         minuto=fecha2.getMinutes(); //minuto actual
         segundo=fecha2.getSeconds(); //segundo actual
         if (hora<10) { //dos cifras para la hora
            hora="0"+hora;
            }
         if (minuto<10) { //dos cifras para el minuto
            minuto="0"+minuto;
            }
         if (segundo<10) { //dos cifras para el segundo
            segundo="0"+segundo;
            }
         //ver en el recuadro del reloj:
         mireloj = hora+" : "+minuto+" : "+segundo;	
				 return mireloj; 
         }
         function actualizar() { //función del temporizador
          mihora=actual(); //recoger hora actual
           mireloj=document.getElementById("reloj"); //buscar elemento reloj
           mireloj.innerHTML=mihora; //incluir hora en elemento
         
	      }
	       setInterval(function(){

        var updatemq135datos = getData('getvalores.php?q=y');
        mq135chart.data.labels = updatemq135datos.fecha;
        mq135chart.data.datasets[0].data = updatemq135datos.valor;
      
        mq135chart.update();
        actualizar();
         }, 1000);

         

	</script>
	
 </body>

</html>

