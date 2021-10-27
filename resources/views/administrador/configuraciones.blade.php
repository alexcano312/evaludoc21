@extends("directivo.layout.main")
@section("titulohead")
	Configuraciones | Administrador
@endsection
@section("css")
@endsection

@section("titulo-pagina")
		Configuraciones
@endsection
@section("url")
	<li class="breadcrumb-item"><a href="{{route("administrador.inicio")}}">Inicio</a></li>
	<li class="breadcrumb-item active" aria-current="page">Configuraciones</li>
@endsection
@section("contenido")

	<div class="content-wrap">
		<div class="container ">

			<!-- INFORMACIÓN GENERAL -->
			<div class="row">
				<div class="col-lg-12">
                    <div class="row">
                        <label class="">Por favor completa la siguiente información para crear la nueva evaluación</label>
                        <div class="form-row">                            
                                <label>Nombre:</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Septiembre - Diciembre 2019" name="nombre" value="" autocomplete="off">                                                        
                                <label>Fecha Inicio</label>
                                <input type="date" class="form-control" id="fecha-inicio" name="fechaInicio" value="" autocomplete="off">                                                        
                                <label>Fecha Termino</label>
                                <input type="date" class="form-control" id="fecha-termino" name="fechaTermino" value="" autocomplete="off">                            
								<label for="verificacion">Por favor <b><i class="text-warning">HACER UN RESPALDO DE LA BD MANUALMENTE</i><b> y escribe la palabra ACEPTAR, posteriormente preciona el botón Actualizar grupo</label>
                        		<input type="text" class="form-control" id="verificacion">
                        <button class="button button-max button-rounded" id="actualizar-grupos"><i class="icon-upload"></i> Actualizar grupos</button>
                        </div>                        
                    </div>
					<h3 class="text-warning" id="espera">LA INFORMACIÓN SE ENCUENTRA ACTUALIZANDO, POR FAVOR ESPERA...</h3>
					<h3 class="text-success" id="correcto">¡LA INFORMACIÓN SE ACTUALIZO CORRECTAMENTE!</h3>
					<h3 class="text-danger" id="mserror">¡Ocurrio un Error, contacta el desarrollador!</h3>
					<div class="clear"></div>
				</div>
			</div>
			<div class="line"></div>
			<!-- TERMINA INFORMACIÓN GENERAL -->

		</div>
	</div>
    <input type="hidden" id="url-actualizacion" value="{{route("administrador.actualizar.informacion.completa")}}">
@endsection


@section("js")
	<!-- Bootstrap Data Table Plugin -->
	<script>

		$(document).ready(function() {
			$("#espera").hide();
			$("#correcto").hide();
			$("#mserror").hide();
            $("#actualizar-grupos").click( function () {
				
                var nombre = $("#nombre").val();
                var fechaInicio = $("#fecha-inicio").val();
                var fechaTermino = $("#fecha-termino").val();
                if(nombre == ""){
                    alert("Completa el nombre de la evaluación");
                    $("#nombre").focus();
                }

                if(fechaInicio == ""){
                    alert("Completa la fecha de inicio");
                    $("#fecha-inicio").focus();
                }

                if(fechaTermino == ""){
                    alert("Completa la fecha de inicio");
                    $("#fecha-termino").focus();
                }

                if($("#verificacion").val() == "" || $("#verificacion").val() == null || $("#verificacion").val() != "ACEPTAR"){
                    alert("Por favor escribe la palabra ACEPTAR");
                    return false;
                }
				$("#actualizar-grupos").hide();
                var nuevaEvaluacion = {
                    "nombre": nombre,
                    "fechaInicio" : fechaInicio,
                    "fechaTermino" : fechaTermino
                }
				$("#espera").show();
                
                var url = $("#url-actualizacion").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    url: url,
                    dataType: 'json',
                    data: nuevaEvaluacion,
                    cache: false,					
                    success: function (data) {
                        alert("Información actualizada");
						$("#espera").hide();
						$("#correcto").show();
                    },
                    error: function(errorThrown) {
                        alert("Ocurrio un error al actualizar la información");
						$("#espera").hide();
						$("#mserror").show();
                    },
                });
				

            });

		});
	</script>

@endsection
