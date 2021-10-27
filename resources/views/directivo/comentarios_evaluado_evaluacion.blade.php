@extends("directivo.layout.resultados")
@section("titulohead")
	Comentarios | Directivo
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection

@section("contenido")

	<div class="content-wrap">
		<div class="container clearfix">
			<div class="row">
				<div class="col-md-3">
					<img src="/images/logo_mex.png" class="">
				</div>
				<div class="col-md-6 text-center">
					<h3>UNIVERSIDAD POLITÉCNICA DE TECÁMAC</h3>
					<h5>SISTEMA DE EVALUACIÓN DE DESEMPEÑO DOCENTE</h5>
					<h6>
						{{$evaluado->persona->apellidos}} {{$evaluado->persona->nombre}}
						<br>
						<b>PERIODO:</b> {{$evaluacion->nombre}}
						<br>
						<b>GRUPOS:</b> {{count($inscripciones)}}
						<br>
						<b>Comentarios:</b> {{count($comentarios)}}
					</h6>
				</div>
				<div class="col-md-3">
					<img src="/images/logo.png" class="">
				</div>
			</div>
			<div class="table-responsive">
				<table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Grupo</th>
							<th>Comentario</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>#</th>
							<th>Grupo</th>
							<th>Comentario</th>
						</tr>
					</tfoot>
					<tbody>
						@foreach($comentarios as $comentario)
							<tr class="">
								<td>{{$loop->index + 1}}</td>
								<td>{{$comentario->grupo->nombre}}</td>
								<td>{{$comentario->texto}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@section("js")
	<!-- Bootstrap Data Table Plugin -->
	<script src="/js/components/bs-datatable.js"></script>
	<script src="/js/typehead.js"></script>
	<script>

		$(document).ready(function() {

			$('#datatable1').dataTable({
			    language: {
			        "decimal": "",
			        "emptyTable": "No hay información",
			        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
			        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
			        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
			        "infoPostFix": "",
			        "thousands": ",",
			        "lengthMenu": "Mostrar _MENU_ Entradas",
			        "loadingRecords": "Cargando...",
			        "processing": "Procesando...",
			        "search": "Buscar:",
			        "zeroRecords": "Sin resultados encontrados",
			        "paginate": {
			            "first": "Primero",
			            "last": "Ultimo",
			            "next": "Siguiente",
			            "previous": "Anterior"
			        }
			    },
			});

		});

	</script>

@endsection