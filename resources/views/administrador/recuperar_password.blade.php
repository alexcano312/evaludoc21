@extends("administrador.layout.main")
@section("titulohead")
	Recuperar Password | Administrador
@endsection
@section("css")
@endsection

@section("titulo-pagina")
	Recuperar Password
@endsection

@section("contenido")
<div class="content-wrap">
	<div class="container clearfix">

		<div class="accordion accordion-lg divcenter nobottommargin clearfix" style="max-width: 550px;">

			<div class="acctitle"><i class="acc-closed icon-lock3"></i><i class="acc-open icon-unlock"></i>Recuperar Contraseña</div>
			<div class="acc_content clearfix">
				<form id="login-form" name="login-form" class="nobottommargin">
					<div class="col_full">
						<label for="exampleFormControlFile1">Ingresa tu correo para enviarte un link de recuperación.</label>
						<label for="login-form-username">Correo:</label>
						<input type="text" id="login-form-username" name="login-form-username" value="" class="form-control" required="" placeholder="example@uptecamac.edu.mx"/>
					</div>
					<div class="col_full nobottommargin text-center">
						<input type="submit" class="button button-3d fondo-naranja nomargin" id="login-form-submit" name="login-form-submit" value="Recuperar">
					</div>
				</form>
			</div>			
		</div>
	</div>
</div>
@endsection

@section("js")

@endsection