@extends("directivo.layout.main")
@section("titulohead")
    Evaluaciones | Directivo
@endsection
@section("css")
    <!-- Bootstrap Data Table Plugin -->
    <link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection

@section("titulo-pagina")
    Evaluaciones
@endsection
@section("url")
    <li class="breadcrumb-item"><a href="{{route("directivo.inicio")}}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route("directivo.alumnos")}}">Alumnos</a></li>
@endsection
@section("contenido")
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="table-responsive">
                <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>clave</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Termino</th>
                        <th>Estatus</th>
                        <th>Ver</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>clave</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Termino</th>
                        <th>Estatus</th>
                        <th>Ver</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($evaluaciones as $evaluacion)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$evaluacion->nombre}}</td>
                            <td>
                                {{$evaluacion->slug}}
                            </td>
                            <td>
                               {{$evaluacion->fecha_inicio}}
                            </td>
                            <td>{{$evaluacion->fecha_termino}}</td>
                            <td>
                                @if($evaluacion->estatus == 1)
                                    Activa
                                @else
                                    Inactiva
                                @endif
                            </td>
                            <td>
                                <center>
                                    <a href="{{route("directivo.detalle.evaluacion",["slug" =>$evaluacion->slug])}}" class="button button-mini button-rounded button-aqua"><i class="icon-edit2"></i>Detalles</a>
                                </center>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section("js")
    <!-- Bootstrap Data Table Plugin -->
    <script src="/js/components/bs-datatable.js"></script>
    <script>

        $(document).ready(function() {
            $('#datatable1').dataTable({
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



        });

    </script>

@endsection