@extends('Client.index')
@section('content')
    <!--
                      Please note: this code is in no way ready to be used as is in production on your website. It will need to be adapted to be cross browser compliant & accessible. I just wanted to share how one might go about this effect with CSS & JS and no other dependencies
                    -->
    <link rel="stylesheet" href="{{ asset('../../css/actividades.css') }}">
    <div class="container">
        <h1>
            Actividades
        </h1>
        <div class="card" id="actividad">
            <div>
                <h1 id="titulo" name="titulo">nombre de la actividad</h1>
            </div>
            <div>
                <img src="" alt="">
            </div>
            <div class="datos">
                <h2 id="descripcion">Descripcion</h2>
                <h3>Fecha</h3>
                <h3>Hora</h3>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url: "{{ route('actividadesCliente.index') }}",
                data: {
                    get_param: 'value'
                },
                success: function(data) {
                    var names = data
                    $('#cand').html(data);
                    $('#actividad').data('myval',20); //setter
                }
            });
        });
    </script>
@stop
