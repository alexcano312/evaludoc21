@extends("directivo.layout.main")
@section("titulohead")
	Resultado Evaluación {{$evaluacion->nombre}} | Directivo
@endsection
@section("css")
	<link rel="stylesheet" href="/css/plugins/sweetalert/sweetalert.min.css" type="text/css" />
@endsection

@section("titulo-pagina")
	Información {{$evaluacion->nombre}}
@endsection

@section("contenido")
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="form-row">
				<div class="col-lg-6 form-group">
					<input id="slug" value="{{$evaluacion->slug}}" type="hidden">
					<input type="hidden" value="{{route("directivo.resultados.evaluacion.evaluado")}}" id="url-evaluado">
					<input type="hidden" value="{{route("directivo.resultados.evaluacion.grupo")}}" id="url-grupo">
					<div class="form-group">
						<select class="form-control" id="evaluado-id">
							<option value="0">Selecciona...</option>
							@foreach($evaluados as $evaluado)
								<option value="{{$evaluado->id}}">{{$evaluado->persona->nombre}} {{$evaluado->persona->apellidos}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<select class="form-control" id="grupo-slug">
							<option value="0">Selecciona...</option>
							@foreach($grupos as $grupo)
								<option value="{{$grupo->slug}}">{{$grupo->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-lg-3 form-group">
					<div class="form-group">
						<button class="form-control button-success" id="ver-resultado-evaluado"><i class="icon-check"></i> Ver Resultados Evaluado</button>
					</div>
					<div class="form-group">
						<button class="form-control button-success" id="ver-resultado-grupo"><i class="icon-check"></i> Ver Resultados Grupo</button>
					</div>
				</div>
				<div class="col-lg-3 form-group">
					<div class="form-group">
						<button class="form-control button-aqua" id="ver-resultados-evaluados"><i class="icon-download"></i> Descargar Todos los Resultados</button>
					</div>
					<div class="form-group">
						<button class="form-control button-aqua" id="ver-resultados-grupos"><i class="icon-download"></i> Descargar Todos los Resultados</button>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section("js")
	<script src="/js/plugins/sweetalert/sweetalert.min.js"></script>
	<script>
		$(document).ready(function() {
		var slug = $("#slug").val();
			$('#ver-resultado-evaluado').click(function () {
				var idEvaluado = $("#evaluado-id").val();
				if(idEvaluado == 0){
					Swal.fire({
						position: 'top-end',
						type: 'error',
						title: '¡Selecciona un Evaluado!',
						showConfirmButton: false,
						timer: 1500
					});
					$("#evaluado-id").focus();
					return false;
				}
				var urlEvaluado = $("#url-evaluado").val();
				window.location.href = urlEvaluado+"/"+slug+"/"+idEvaluado;
			});

			$('#ver-resultado-grupo').click(function () {
				var slugGrupo = $("#grupo-slug").val();
				if(slugGrupo == 0){
					Swal.fire({
						position: 'top-end',
						type: 'error',
						title: '¡Selecciona un Grupo!',
						showConfirmButton: false,
						timer: 1500
					});
					$("#grupo-id").focus();
					return false;
				}
				var urlGrupo = $("#url-grupo").val();
				window.location.href = urlGrupo+"/"+slug+"/"+slugGrupo;
			});
		});
	</script>
@endsection