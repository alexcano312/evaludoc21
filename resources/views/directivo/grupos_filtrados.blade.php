@extends("directivo.layout.main")
@section("titulohead")
	Grupo Activos | Directivo
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" xmlns="http://www.w3.org/1999/html"/>
	<link rel="stylesheet" href="/css/plugins/sweetalert/sweetalert.min.css" type="text/css" />
@endsection

@section("titulo-pagina")
		Grupo Activo
@endsection
@section("url")
	<li class="breadcrumb-item"><a href="{{route("directivo.inicio")}}">Inicio</a></li>
	<li class="breadcrumb-item"><a href="{{route("directivo.grupos")}}">Grupos</a></li>
	<li class="breadcrumb-item"><a href="#">Activos</a></li>
@endsection

<style>
	.tt-query {
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
	}

	.tt-hint {
		color: #999
	}

	.tt-menu {    /* used to be tt-dropdown-menu in older versions */
		width: 422px;
		margin-top: 4px;
		padding: 4px 0;
		background-color: #fff;
		border: 1px solid #ccc;
		border: 1px solid rgba(0, 0, 0, 0.2);
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		-webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
		-moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
		box-shadow: 0 5px 10px rgba(0,0,0,.2);
	}

	.tt-suggestion {
		padding: 3px 20px;
		line-height: 24px;
	}

	.tt-suggestion.tt-cursor,.tt-suggestion:hover {
		color: #fff;
		background-color: #0097cf;

	}
</style>

@section("contenido")

	<div class="content-wrap">
		<div class="container clearfix">
			@foreach($errors->get("generales") as $error)
			<span class="text-danger">
				{{$error}}
			</span>
			@endforeach
			@if (session('success'))
				<label class="form-check-label text-success float-right" for="defaultCheck1">
					¡Información guardada!
				</label>
			@endif
			<br>
			@foreach($grupos as $grupo)
				<div class="row">
					<div class="col-lg-12">
						<div class="clear"></div>
						<div class="form-row">
							<center><h3 class="text-center texto-naranja">Grupo {{$grupo->nombre}}</h3></center><br>
							<div class="clear"></div>
							<input type="button" class="button button-rounded button-aqua float-right guardar-filtro" grupo="{{$grupo->id}}" value="Guardar">
							<div class="col-lg-12">
								<table id="datatable1" class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
									<tr class="">
										<th>#</th>
										<th>Materia</th>
										<th>Evaluado</th>
									</tr>
									</thead>
									<tfoot>
									<tr class="">
										<th>#</th>
										<th>Materia</th>
										<th>Evaluado</th>
									</tr>
									</tfoot>
									<tbody >
									@foreach($grupo->materias() as $materia)
										<tr>
											<td>{{$loop->index + 1}}</td>
											<td >{{$materia->materia->nombre}}</td>
											<td>
												<select class="form-control grupo-{{$grupo->id}}" grupo="{{$grupo->id}}" materia="{{$materia->id}}">
													@if(!$grupo->verificaInscripcionMateria($materia->id))
														<option value="0" selected>Selecciona...</option>
													@else
														<option value="0">Selecciona...</option>
													@endif

													@foreach($evaluados as $evaluado)
														<option value="{{$evaluado->id}}"
															@if($grupo->verificaInscripcionMateria($materia->id))
																@if($grupo->verificaInscripcionMateria($materia->id)->evaluado_id == $evaluado->id)
																	selected
																@endif
															@endif
														>
														{{$evaluado->persona->apellidos}} {{$evaluado->persona->nombre}} 
														</option>
													@endforeach
												</select>
											</td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>
						</div>

						<div class="clear"></div>
						<br><br>
					</div>
				</div>
			@endforeach
		</div>
	</div>
	<input type="hidden" id="ruta-guardar-cambios" value="{{route("directivo.grupo.agregar.evaluados")}}">
@endsection

@section("js")
	<!-- Bootstrap Data Table Plugin -->
	<script src="/js/components/bs-datatable.js"></script>
	<script src="/js/typehead.js"></script>
	<script src="/js/plugins/sweetalert/sweetalert.min.js"></script>
	<script>

		$(document).ready(function() {
			var ruta = $("#ruta-guardar-cambios").val();
			$('.guardar-filtro').click(function () {

				var elementos = [];
				var idGrupo = $(this).attr("grupo");

				$(".grupo-"+idGrupo).each(function(index) {

					//if($(this).val() != 0){
						var idInscripcionMateria = $(this).attr('materia');
						var idEvaluado = $(this).val();
						var constructor = idInscripcionMateria+"-"+idEvaluado;
						elementos.push(constructor);
					//}
				});

				if(elementos.length > 0){
					$.ajax({
						url: ruta+"/"+idGrupo+"/"+elementos,
						dataType: 'json',
						cache: false,
						success:function (respuesta) {
							Swal.fire({
								position: 'top-end',
								type: 'success',
								title: '¡Información guardada!',
								showConfirmButton: false,
								timer: 1500
							})
						},
						error:function () {
							console.log(":(");
						}
					});
				}else{
					alert("vacio");
				}

			});

			$('.datatable').dataTable({
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
				"columnDefs": [
					{ "width": "5%", "targets": 0 }
				]
			});
		});



	</script>

@endsection