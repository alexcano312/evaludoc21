@extends("administrador.layout.main")
@section("titulohead")
	Login - Evaluación Docente | Administrador
@endsection
@section("css")
@endsection

@section("titulo-pagina")
Login
@endsection

@section("contenido")
<div class="content-wrap">
	<div class="container clearfix">

		<div class="accordion accordion-lg divcenter nobottommargin clearfix" style="max-width: 550px;">

			<div class="acctitle"><i class="acc-closed icon-lock3"></i><i class="acc-open icon-unlock"></i>Inicia con tu cuenta</div>
			<div class="acc_content clearfix">
				<form id="login-form" method="post" action="{{route("administrador.verifica.credenciales")}}" name="login-form" class="nobottommargin">
					{{csrf_field()}}
					@foreach($errors->get("generales") as $error)
						<span class="text-danger">
							{{$error}}
						</span>
					@endforeach
					<br>
					<div class="col_full">
						<label for="login-form-username">Correo:</label>
						<input type="text" id="login-form-username" name="correo" value="" class="form-control" required="" />
						@foreach($errors->get("correo") as $error)
							<span class="text-danger">
								{{$error}}
							</span>
						@endforeach
					</div>

					<div class="col_full">
						<label for="login-form-password">Contraseña:</label>
						<input type="password" id="login-form-password" name="password" value="" class="form-control" required="" />
						@foreach($errors->get("password") as $error)
							<span class="text-danger">
								{{$error}}
							</span>
						@endforeach
					</div>
					@if(isset($_GET["r"]))
					<input type="hidden" name="url" value="{{$_GET["r"]}}">
					@endif
					<div class="col_full nobottommargin text-right">
						<input type="submit" class="button button-3d fondo-naranja nomargin" id="login-form-submit" name="login-form-submit" value="Iniciar">
					</div>
				</form>
				<a class="nav-link text-right" href="{{route("administrador.recuperar.password")}}">¿Olvidaste tu contraseña?</a>
			</div>			
		</div>
	</div>
</div>
@endsection

@section("js")

@endsection