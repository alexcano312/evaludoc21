@extends("alumno.layout.validar_codigo")

@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection


@section("titulo")
<title>Validar | Código</title>
@endsection

@section("titulo-pagina")

@endsection

@section("contenido")
<div class="content-wrap">
				<div class="container clearfix">
					@if(isset($codigo))
						<div class="row">
							<div class="col-lg-3 mb-3"></div>
							<div class="col-lg-6 mb-6 text-center">
								<h3 class="text-success">Evaluación Concluida <i class="icon-ok"></i></h3>
								<br>
								<h5>{{$evaluacion->nombre}}</h5>
								<h5>{{$alumno->nombre}} {{$alumno->apellidos}}</h5>
								<h5>{{$codigo->created_at}}</h5>
							</div>

							<div class="col-lg-3 mb-3">

							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 mb-3"></div>
							<div class="col-lg-6 mb-6 text-center">

								<img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(250)->generate('http://189.254.6.232/validar_codigo/'.$codigo->contructrorCodigo)) }} ">

							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 mb-3"></div>
							<div class="col-lg-6 mb-6 text-center">

								<h5 style="letter-spacing: 4px;">{{$codigo->codigo}}</h5>

							</div>
						</div>
					@else
						<div class="row">
							<div class="col-lg-3 mb-3"></div>
							<div class="col-lg-6 mb-6 text-center">
								<h3 class="text-danger">No fue posible encontrar la petición <i class="icon-remove"></i></h3>
								<br>
								<img src="/images/error.png" class="">
							</div>

							<div class="col-lg-3 mb-3">

							</div>
						</div>
					@endif

				</div>
			</div>
@endsection

@section("js")
@endsection