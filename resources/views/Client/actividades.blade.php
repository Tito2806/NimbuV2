@extends('Client.index')
@section('content')
    <!--
                      Please note: this code is in no way ready to be used as is in production on your website. It will need to be adapted to be cross browser compliant & accessible. I just wanted to share how one might go about this effect with CSS & JS and no other dependencies
                    -->
    <link rel="stylesheet" href="{{ asset('../../css/actividades.css') }}">
    <div>
        <h1>
            Actividades
        </h1>
    
    <div class="container-cards" id="containerActividades">
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url: "{{ route('actividadesCliente.index') }}",
                dataType: "json",
                success: function(data){
				for (let i = 0; i < data.data.length; i++) {
                    $("#containerActividades").append('<div class="card" id="actividad'+ i +'"></div>');
                    $('#actividad' + i).append('<h1 id="titulo'+ i +'"></h1>');
                    $('#titulo' + i).text(data.data[i].titulo);

                    
                }
			}
            });
        });
    </script>
@stop
