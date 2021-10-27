@extends("directivo.layout.main")
@section("titulohead")
    Evaluación {{$evaluacion->nombre}} | Directivo
@endsection
@section("css")
    <!-- Bootstrap Data Table Plugin -->
    <link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css"/>
@endsection

@section("titulo-pagina")
    Evaluación {{$evaluacion->nombre}}
@endsection
@section("url")
    <li class="breadcrumb-item"><a href="{{route("directivo.inicio")}}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route("directivo.evaluaciones")}}">evaluaciones</a></li>
    <li class="breadcrumb-item"><a href="#">{{$evaluacion->nombre}}</a></li>
@endsection


@section("contenido")

    <div class="content-wrap">
        <div class="container clearfix">

            <!-- INFORMACIÓN GENERAL -->
            <div class="row">
                <div class="col-lg-11 offset-lg-1">

                    @foreach($errors->get("generales") as $error)
                        <span class="text-danger">
							{{$error}}
						</span>
                    @endforeach

                    <h3 class="texto-naranja">
                        Información General
                        @if (session('success'))
                            <div class="style-msg successmsg">
                                <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Well done!</strong> You
                                    successfully read this important alert message.
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            </div>
                        @endif
                    </h3>

                    <form method="post"
                    ">
                    {{csrf_field()}}
                    <div class="form-row">
                        <div class="col-lg-6 form-group">
                            <input name="id" value="{{$evaluacion->id}}" type="hidden">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" class="form-control" value="{{$evaluacion->nombre}}" name="nombre"
                                       readonly>
                            </div>

                            <div class="form-group">
                                <label>Fecha Inicio</label>
                                <input type="text" class="form-control" value="{{$evaluacion->fecha_inicio}}" readonly>
                            </div>

                            <diV class="form-group">
                                <label>Estatus</label>
                                <input type="text" class="form-control"
                                       value="@if($evaluacion->estatus == 1)Activa @else Inactiva @endif" readonly>
                            </diV>

                            <div class="form-group">
                                <label>Alumnos con evaluación</label>
                                <input type="text" class="form-control" value="{{count($inscripcionesConEvaluacion)}}"
                                       readonly>
                            </div>
                            <div class="form-group">
                                <label>Tutores totales evaluados</label>
                                <input type="text" class="form-control" value="" id="tutoresTotales" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 form-group">
                            <div class="form-group">
                                <label>Clave</label>
                                <input type="text" class="form-control" value="{{$evaluacion->slug}}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Fecha Termino</label>
                                <input type="text" class="form-control" value="{{$evaluacion->fecha_termino}}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Alumnos totales en evaluación</label>
                                <input type="text" class="form-control"
                                       value="{{count($inscripcionesConEvaluacion) + count($inscripcionesSinEvaluacion)}}"
                                       readonly>
                            </div>
                            <div class="form-group">
                                <label>Alumnos sin evaluación</label>
                                <input type="text" class="form-control" value="{{count($inscripcionesSinEvaluacion)}}"
                                       readonly>
                            </div>
                            <div class="form-group">
                                <label>Profesores totales evaluados</label>
                                <input type="text" class="form-control" value="" id="profsTotales" readonly>
                            </div>
                        </div>
                    </div>
                    <a class="button button-border button-rounded button-green color-naranja"
                       href="{{route("directivo.resultados.evaluacion",["slug" =>$evaluacion->slug])}}">Resultados</a>
                </div>
            </div>
            <div class="line"></div>
			<h3 class="texto-naranja">Alumnos sin realizar evaluación</h3>
            <div>
                <table>
                    <table id="alumnos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Matricula</th>
                            <th>Sexo</th>
                            <th>Generación</th>
                            <th>Carrera</th>
                            <th>Estatus</th>
                            <th>Grupo Actual</th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoTabla">
                        <tbody>
                    </table>
                </table>
            </div>
        </div>
        <div>
		<center>
            <div class="col-lg-6 mb-6">
                <h3>Alumnos faltantes de realizar evaluacion por carrera</h3>
                <div class="toolbar center">
                    <canvas id="chart-2"></canvas>
                </div>
            </div>
            <div class="col-lg-6 mb-6">
                <h3>Alumnos faltantes de realizar evaluacion docente</h3>
                <div class="bottommargin divcenter" style="max-width: 750px; min-height: 350px;">
                    <canvas id="chart-1"></canvas>
                </div>
            </div>
			</center>
        </div>
    </div>
    <input id="idSesion" hidden value="{{$idSes}}">
    <input id="evaluacionId" hidden value="{{$evaluacionId}}">
    <input value="{{route("api.datosGraf")}}" hidden id="urlGetData">
@endsection

@section("js")
    <script src="/js/chart.js"></script>
    <script src="/js/components/bs-datatable.js"></script>
    <script src="/js/chart-utils.js"></script>
    <script>
        $(document).ready(function () {
            urlDat = $("#urlGetData").val() + "/" + $("#idSesion").val() + "/" + $("#evaluacionId").val();
            $.ajax({
                type: "get",
                url: urlDat,
                dataType: "json",
                success: function (response) {
                    datos = response.detalle;
                    $("#profsTotales").val(datos.numProfEvaluados);
                    $("#tutoresTotales").val(datos.numTutoresEvaluados);
                    ctx = document.getElementById("chart-1").getContext("2d");
                    colores = ["#F74620", "#2059F7", "#E4EA10", "#9AF70C", "#F78B0C", "#0CC5F7", "#0C2AF7"];
                    graf1 = llenarDatosFalt(datos.arrFaltantes, colores, 'pie', ctx);
                    ctx2 = document.getElementById("chart-2").getContext("2d");
                    graf2 = llenarDatos(datos.carreras, colores, 'polarArea', ctx2);
                    /*ctx3 = document.getElementById("chart-3").getContext("2d");
                     graf3 = llenarDatos(datos.areas, colores, 'polarArea', ctx3);*/
                    datosAlumnos = datos.alumnosFaltos;
                    $("#cuerpoTabla").html("");
                    contador = 1;
                    datosAlumnos.forEach(function (dato) {
                        tipo = (dato.alumno.tipo === 0) ? "Regular" : "Recursador";
                        sexo = (dato.alumno.sexo === 0) ? "Femenino" : "Masculino";
                        $("#cuerpoTabla").append("<tr><td>"+contador+"</td><td>" + dato.alumno.nombre + " " + dato.alumno.apellidos + "</td>" +
                            "<td>" + tipo + "<td>" + dato.alumno.matricula + "</td><td>"+sexo+"</td></td><td>"+dato.alumno.generacion.nombre+"</td>" +
                            "<td>"+dato.alumno.carrera.nombre+"</td><td>"+dato.alumno.estatus+"</td><td>"+dato.grupoActual.nombre+"</td></tr>");
                        contador++;
                    });
                    tablita=$('#alumnos').dataTable({
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
                    });
                }
            });
        });
        function llenarDatosFalt(datos, colores, tipo, ctx) {
            datitos = [];
            nombres = [];
            for (var d in datos) {
                datitos.push(datos[d]);
                nombres.push(d);
            }
            grafica = new Chart(ctx, {
                type: tipo,
                data: {
                    datasets: [{
                        data: datitos,
                        backgroundColor: colores
                    }],
                    labels: nombres
                }
            });
            return grafica;
        }
        function llenarDatos(datos, colores, tipo, ctx) {
            datitos = [];
            nombres = [];
            for (var d in datos) {
                suma = datos[d]["hombres"] + datos[d]["mujeres"];
                datitos.push(suma);
                nombres.push(datos[d]["nombre"]);
            }
            grafica = new Chart(ctx, {
                type: tipo,
                data: {
                    datasets: [{
                        barThickness: 6,
                        data: datitos,
                        backgroundColor: colores,
                        label: "Carreras"
                    }],
                    labels: nombres
                }
            });
            return grafica;
        }
    </script>
@endsection