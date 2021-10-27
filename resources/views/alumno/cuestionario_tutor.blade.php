@extends("alumno.layout.main")

@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection


@section("titulo")
<title>TUTOR | EVADOC</title>
@endsection

@section("titulo-pagina")
{{$inscripcion->tutor->personal->nombre." ".$inscripcion->tutor->personal->apellidos}}
@endsection

@section("materia")
	(Tutor)
@endsection
@section("url")
	<li class="breadcrumb-item"><a href="{{route("alumno.inicio")}}">Inicio</a></li>
	<li class="breadcrumb-item active" aria-current="page">Evaluación</li>
	<li class="breadcrumb-item active" aria-current="page">{{$slug}}</li>
	<li class="breadcrumb-item active" aria-current="page">Tutor</li>
@endsection
@section("contenido")
<div class="content-wrap">
	<div class="container clearfix">
		<div class="col-sm-12">
			<div class="col-lg-12">
				@foreach($errors->get("generales") as $error)
					<span class="text-danger ">
					{{$error}}
				</span>
				@endforeach
				<form action="{{route("alumno.evaluar.evaluado")}}" method="post" name="form_cuestionario" id="form_cuestionario">
					{{csrf_field()}}
					<?php
						// -- Variable de apoyo para no repetir los nombres de las categorias
						$tema = null;
						// -- Variable de apoyo para saber el número de pregunta
						$contador = 0;

						// -- Recorrer cada una de las prgeuntas pendientes
						foreach ($preguntas as $valor => $pregunta ){

							// -- Variable pasa saber el número de pregunta
							$contador++;

							if($tema != $pregunta->tema_id){
								// -- Imprimir el nombre de la categoria
								echo '<h3>'.$pregunta->tema->nombre.'</h3>';
								$tema = $pregunta->tema_id;
							}

							echo '
							<div class="form-group">
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-12 col-form-label">' . ($valor + 1) .'.- ' . $pregunta->texto .'</label>
							</div>
							<fieldset class="form-group">
								<div class="row">
									<div class="col-sm-10">
										<input type="hidden" name="p_'.($valor + 1).'" value="'.$pregunta->id.'">
										<input type="hidden" name="slug" value="'.$slug.'">
										<div class="form-check">
											<input class="form-check-input" type="radio" name="n_'.$pregunta->id.'" id="n0'.$pregunta->id.'" value="0" required>
											<label class="form-check-label" for="n0'.$pregunta->id.'">
												Nunca
											</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="n_'.$pregunta->id.'" id="n1'.$pregunta->id.'" value="1" required>
											<label class="form-check-label" for="n1'.$pregunta->id.'">
												Ocasionalmente
											</label>
										</div>
										<div class="form-check disabled">
											<input class="form-check-input" type="radio" name="n_'.$pregunta->id.'" id="n2'.$pregunta->id.'" value="2" required>
											<label class="form-check-label" for="n2'.$pregunta->id.'">
												Casi siempre
											</label>
										</div>
										<div class="form-check disabled">
											<input class="form-check-input" type="radio" name="n_'.$pregunta->id.'" id="n3'.$pregunta->id.'" value="3" required>
											<label class="form-check-label" for="n3'.$pregunta->id.'">
												Siempre
											</label>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="line"></div>
							';
						}

						echo '
						<input type="hidden" value="Tutor" name="tipo_evaluacion">
						<input type="hidden" value="'.$contador.'" name="nPreguntas">
						<input type="hidden" value="'.$inscripcion->id.'" name="inscripcionId">
						<div class="form-group">
							<label for="comentario">Comentario para el docente (Opcional)</label>
							<textarea class="form-control" name="comentario" id="comentario" rows="3"></textarea>
						</div>
						<div class="form-group row">
							<div class="col-sm-10">
								<button id="btnEnviar" type="submit" class="button button-3d button-xlarge button-rounded button-dirtygreen float-right"><i class="icon-ok"></i>Enviar</button>
							</div>
						</div>
				</form>';
				?>
				<div class="line"></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section("js")
@endsection