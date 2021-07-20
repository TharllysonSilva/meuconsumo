(function( $ ) {
  $(function() {

    $(document).ready(function(){

        $('#formulario').submit(function(e) {
					e.preventDefault();
					alert("Botão clicado");
        	gerarRelatorio();

        });

        function gerarRelatorio() {
					var titulo = "Consumo no período = 8.8938 kWh";
					var chart = AmCharts.makeChart( "chartdiv", {
						"type": "serial",
						"theme": "light",

						"dataProvider": [{"dia": 0,"kwh":0}, {"dia": 1,"kwh":0}, {"dia": 2,"kwh":0}, {"dia": 3,"kwh":0},
											{"dia": 4,"kwh":0}, {"dia": 5,"kwh":0}, {"dia": 6,"kwh":0}, {"dia": 7,"kwh":0},
											{"dia": 8,"kwh":0}, {"dia": 9,"kwh":0}, {"dia": 10,"kwh":0}, {"dia": 11,"kwh":0},
											{"dia": 12,"kwh":0}, {"dia": 13,"kwh":0}, {"dia": 14,"kwh":0}, {"dia": 15,"kwh":0},
											{"dia": 16,"kwh":0}, {"dia": 17,"kwh":0}, {"dia": 18,"kwh":0}, {"dia": 19,"kwh":0},
											{"dia": 20,"kwh":0}, {"dia": 21,"kwh":0}, {"dia": 22,"kwh":3.1457}, {"dia": 23,"kwh":3.4192},
											{"dia": 24,"kwh":2.3289}, {"dia": 25,"kwh":0}, {"dia": 26,"kwh":0}, {"dia": 27,"kwh":0},
											{"dia": 28,"kwh":0}, {"dia": 29,"kwh":0}, {"dia": 30,"kwh":0}
						],

						"addClassNames": true,
						"startDuration": 1,
						"marginLeft": 0,

						"categoryField": "dia",
						"categoryAxis": {
							"gridPosition": "start",
							"gridAlpha": 0,
							"tickPosition": "start",
							//"tickLength": 20,
							"title": "Dia"
						},

						"valueAxes": [{
							"id": "a1",
							"title": "kwh",
							"gridAlpha": 0,
							"axisAlpha": 0
						}],

						"allLabels":[{
							"text": titulo,
							"align":"center",
							"bold": true,
							"size":15,

						}],

						"graphs": [ {
							"id": "g1",
							"fillAlphas": 0.9,

							"type": "column",
							"y": 100,
							"valueField": "kwh",
							"valueAxis": "a1",
							"balloonText": "[[value]] kWh",
							"legendValueText": "[[value]] kWh",

							"lineColor": "#428bca",
							"alphaField": "alpha",
						} ],

						"chartCursor": {
							"categoryBalloonEnabled": false,
							"cursorAlpha": 0,
							"zoomable": false,
							"valueBalloonsEnabled": false
						},



					});
        }
    });
  });
})(jQuery);
