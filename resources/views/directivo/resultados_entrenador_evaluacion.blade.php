@extends("directivo.layout.resultados")
@section("titulohead")
	Resultado Evaluación {{$evaluacion->nombre}} | Directivo
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<style type="text/css" media="print">
		
	</style>
@endsection

@section("contenido")
	<div class="" id="tabla-promedio">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 mb-12">
					<div class="row">
						<div class="col-md-3">
							<img src="/images/logo_mex.png" class="">
						</div>

						<div class="col-md-6 text-center">
							<h5>UNIVERSIDAD POLITÉCNICA DE TECÁMAC</h5>
							<h5>SISTEMA DE EVALUACIÓN DE DESEMPEÑO ENTRENADOR</h5>
							<h5>
								Entrenador: {{$entrenador->persona->apellidos}} {{$entrenador->persona->nombre}}
								<br>
								<b>PERIODO:</b> {{$evaluacion->nombre}}
								<br>
								<b>GRUPOS:</b> {{count($inscripciones)}}
								<br>
								<b>PROMEDIO:</b> {{$promedioFinal}}
							</h5>
						</div>
						<div class="col-md-3">
							<img src="/images/logo.png" class="">
						</div>
					</div>
					<table class="table table-bordered">
						<thead>
						<tr>
							<th>Tema</th>
							<th>Preguntas</th>
							@foreach($inscripciones as $inscripcion)
								<th style="font-size: 60%;">{{$inscripcion->nombre}}<br></th>
							@endforeach
						</tr>
						</thead>
						<tbody>
						@foreach($temas as $tema)
							<tr>
								<td style="font-size: 60%;" rowspan="{{$tema->nPreguntas +1}}">{{$tema->nombre}}</td>
							</tr>
							@foreach($tema->filtroPreguntas as $pregunta)
								<tr style="font-size: 60%;">
									<td>
                                        {{$pregunta->texto}}
									</td>
                                    @foreach($tema->respuestadePreguntas as $respuesta)
                                        @if($respuesta->preguntaId == $pregunta->id)
                                            <td>{{$respuesta->promedio}}</td>
                                        @endif
                                    @endforeach
								</tr>
							@endforeach

							<tr style="font-size: 60%;">
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
					<br>
					<div class="row">
						<div class="col-md-3 text-center" style="font-size: 60%;">
							<hr style="height: 2px; background-color: black;">
							Vo. Bo. Dirección Academica
						</div>
						<div class="col-md-3 text-center" style="font-size: 60%;">
							<hr style="height: 2px; background-color: black;">
							{{$entrenador->persona->nombre}} {{$entrenador->persona->apellidos}}
						</div>
						<div class="col-md-6" style="font-size: 60%;">
							Área de Oportunidades/Compromisos
							<hr style="height: 2px; background-color: black;">
							<hr style="height: 2px; background-color: black;">
							<hr style="height: 2px; background-color: black;">
						</div>
					</div>
					<br>
					<br>
				</div>
			</div>
		</div>
	</div>

@endsection

@section("js")

@endsection