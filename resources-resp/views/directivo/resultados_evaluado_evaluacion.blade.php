@extends("directivo.layout.main")
@section("titulohead")
	Resultado Evaluación {{$evaluacion->nombre}} | Directivo
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->

@endsection

@section("titulo-pagina")
	Resultado Evaluación {{$evaluacion->nombre}}
@endsection

@section("contenido")
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="row grid-container" data-layout="masonry" style="overflow: visible">

				<div class="col-lg-12 mb-12">
					<h4>Resultado</h4>
					<table class="table table-bordered">
						<thead>
						<tr>
							<th>Tema</th>
							<th>Preguntas</th>
							@foreach($inscripciones as $inscripcion)
								<th style="font-size: x-small">{{$inscripcion->grupo->nombre}}<br>{{$inscripcion->materia->materia->nombre}}<br>({{$inscripcion->nAlumnos}})</th>
							@endforeach
						</tr>
						</thead>
						<tbody>
						@foreach($temas as $tema)
							<tr>
								<td rowspan="{{$tema->nPreguntas +1}}">{{$tema->nombre}}</td>
							</tr>
							@foreach($tema->filtroPreguntas as $pregunta)
								<tr>
									<td>
                                        {{$pregunta->id}}{{$pregunta->texto}}
									</td>
                                    @foreach($tema->respuestadePreguntas as $respuesta)
                                        @if($respuesta->preguntaId == $pregunta->id)
                                            <td>{{$respuesta->promedio}}</td>
                                        @endif
                                    @endforeach
								</tr>
							@endforeach

							<tr>
								<td>Total:</td>
								<td>
									<span>Promedio: {{$tema->promedioTotal}}</span>
									<div class="progress">

										<div class="progress-bar progress-bar-striped"  role="progressbar" style="width: {{$tema->promedioTotalEnEscalaA100}}%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">{{$tema->promedioTotal}}</div>
									</div>
								</td>
							</tr>
						@endforeach

						</tbody>
					</table>
					<br><br>

				</div>
			</div>
		</div>
	</div>

@endsection

@section("js")

@endsection