@extends("alumno.layout.menu_codigo")

@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection


@section("titulo")
<title>Código | {{$evaluacion->nombre}}</title>
@endsection

@section("titulo-pagina")

@endsection

@section("contenido")
	<script>
		function comprobarClave(){
			clave1 = document.form_correo.correo1.value;
			clave2 = document.form_correo.correo2.value;


			if (clave1 != clave2){
				alert("Los correos deben coincidir");
				return false;
			}else{
				document.getElementById('btnEnvio').style.display = 'none';
				document.form_correo.submit()

			}


		}
	</script>
	<div class="content-wrap">
				<div class="container clearfix">
					<div class="row">
						<div class="col-lg-3 mb-3"></div>
						<div class="col-lg-6 mb-6 text-center">
							<h3 class="text-success">Evaluación Concluida <i class="icon-ok"></i></h3>
							<br>
							<h3>{{$evaluacion->nombre}}</h3>
							<h4>{{Session::get("alumno")->nombre}} {{Session::get("alumno")->apellidos}}</h4>
							<h5>{{$codigo->created_at}}</h5>
						</div>

						<div class="col-lg-3 mb-3">

							
							

						</div>
					</div>
					<div class="row">
						<div class="col-lg-3 mb-3"></div>
						<div class="col-lg-6 mb-6 text-center">

							<img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(250)->generate('http://189.254.6.232/eva_doc/validar/'.$codigo->contructrorCodigo)) }} ">

						</div>
					</div>
					<div class="row">
						<div class="col-lg-3 mb-3"></div>
						<div class="col-lg-6 mb-6 text-center">

							<h5 style="letter-spacing: 4px;">{{$codigo->codigo}}</h5>

						</div>
					</div>
					<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-body">
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="modal-title" id="myModalLabel">Enviar código de evaluación a tu correo</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									</div>
									<div class="modal-body">
										<h4><p>Recuerda revisar en la bandeja de correo no deseado.</p></h4>
										<form name="form_correo" id="form_correo" method="post" action="{{route("alumno.enviar.evaluacion")}}">
											{{csrf_field()}}
											<div class="form-group">
												<label for="exampleInputEmail1">Correo:</label>
												<input type="email" class="form-control" id="correo1" aria-describedby="emailHelp" name="correo" placeholder="Correo" required>
											</div>
											<div class="form-group">
												<label for="correo2">Repetir Correo</label>
												<input type="email" class="form-control" id="correo2" name="correo2" placeholder="Repetir Correo" required>
												<small id="email1" class="form-text text-muted">Deben ser iguales los correos.</small>
											</div>
											<input type="hidden" name="codigoId" value="{{$codigo->id}}">
											<button onClick="comprobarClave()" id="btnEnvio" type="button" class="button button-rounded  button-large tright float-right "><i class="icon-arrow-up1"></i><span>Enviar</span></button>

										</form>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

@endsection

@section("js")
@endsection