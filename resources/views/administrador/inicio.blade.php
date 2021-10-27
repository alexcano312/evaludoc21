@extends("administrador.layout.main")
@section("titulohead")
	Inicio | Administrador
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection

@section("titulo-pagina")
	Inicio
@endsection

@section("contenido")

	<style>
		.chart-samples ul { list-style: none; }

		.chart-samples h4 {
			text-transform: uppercase;
			margin-bottom: 20px;
			font-weight: 400;
		}

		.chart-samples li {
			font-size: 16px;
			line-height: 2.2;
			font-weight: 600;
		}

		.chart-samples li a:not(:hover) { color: #AAA; }
	</style>

<div class="content-wrap">
				<div class="container clearfix">
					<div class="row grid-container" data-layout="masonry" style="overflow: visible">
						<div class="col-lg-6 mb-6">
							<!-- Charts Area
					============================================= -->
							<div class="bottommargin divcenter" style="max-width: 100%; min-height: 350px;">
								<canvas id="chart-0"></canvas>
							</div>

							<div class="toolbar center">
								Información de alumnos
							</div>
							<!-- Charts Area End -->
						</div>
						<div class="col-lg-6 mb-6">
							<div class="bottommargin divcenter" style="max-width: 750px; min-height: 350px;">
								<canvas id="chart-1"></canvas>
							</div>


							<!-- Charts Area End -->

							<div class="line"></div>
						</div>
					</div>				
				</div>
			</div>
@endsection

@section("js")
	<script src="/js/chart.js"></script>
	<script src="/js/chart-utils.js"></script>
	<script>

		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

		var chartColors = window.chartColors;
		var color = Chart.helpers.color;
		// ---------------
		// -- Grafica 2
		// ---------------

		var horizontalBarChartData = {
			labels: ["Ingenierias", "Licenciaturas"],
			datasets: [{
				label: 'Mujeres',
				backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
				borderColor: window.chartColors.red,
				borderWidth: 1,
				data: [
					50,
					30,
				]
			}, {
				label: 'Hombres',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				data: [
					40,
					15,
				]
			}]

		};
		var config = {
			data: {
				datasets: [{
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
					],
					backgroundColor: [
						color(chartColors.red).alpha(0.5).rgbString(),
						color(chartColors.orange).alpha(0.5).rgbString(),
						color(chartColors.yellow).alpha(0.5).rgbString(),
						color(chartColors.green).alpha(0.5).rgbString(),
						color(chartColors.blue).alpha(0.5).rgbString(),
					],
					label: 'Información' // for legend
				}],
				labels: [
					"Software",
					"Mecánica",
					"Manufactura",
					"Negocios",
					"Financiera"
				]
			},
			options: {
				responsive: true,
				legend: {
					position: 'right',
				},
				title: {
					display: true,
					text: 'Alumnos Registrados: 100'
				},
				scale: {
					ticks: {
						beginAtZero: true
					},
					reverse: false
				},
				animation: {
					animateRotate: false,
					animateScale: true
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById("chart-0");
			window.myPolarArea = Chart.PolarArea(ctx, config);

			var ctx = document.getElementById("chart-1").getContext("2d");
			window.myHorizontalBar = new Chart(ctx, {
				type: 'horizontalBar',
				data: horizontalBarChartData,
				options: {
					// Elements options apply to all of the options unless overridden in a dataset
					// In this case, we are setting the border of each horizontal bar to be 2px wide
					elements: {
						rectangle: {
							borderWidth: 2,
						}
					},
					responsive: true,
					legend: {
						position: 'right',
					},
					title: {
						display: true,
						text: 'Docentes'
					}
				}
			});
		};






		// ----------------------------------------






	</script>
@endsection