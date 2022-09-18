<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card">
            @if(Auth::check() && Auth::user()->rol == "Administrador")
            
            <div class="card-header">
                <h2>Tabla Usuario</h2>
                <div class="d-flex flex-row-reverse"><button
                        class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="createNewUser"><i
                            class="fas fa-plus"></i>Agregar Usuario</button></div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" id="tableUser">
                            <thead class="font-weight-bold text-center">
                                <tr>
                                    {{-- <th>No.</th> --}}
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Imagen</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                {{-- @foreach ($users as $r_users)
                                    <tr>
                                <td>{{$r_users->id}}</td>
                                <td>{{$r_users->name}}</td>
                                <td>{{$r_users->email}}</td>
                                <td>{{$r_users->level}}</td>
                                <td>
                                    <div class="btn btn-success editUser" data-id="{{$r_users->id}}">Edit</div>
                                    <div class="btn btn-danger deleteUser" data-id="{{$r_users->id}}">Delete</div>
                                </td>
                                </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>


<!-- Modal-->
<div class="modal fade" id="modal-user" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Modal Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUser" name="formUser">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" id="name"
                            placeholder="Nombre del usuarios"><br>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="Correo del usuario"><br>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña"><br>
                        <label for="">Rol de usuario</label>
                        <select name="rol" class="form-control" id="rol">
                            <option value="-">Rol</option>
                            <option value="Usuario">Usuario</option>
                            <option value="Administrador">Administrador</option>
                        </select><br>
                        <input id="browse" type="file" onchange="previewFiles()" multiple>
                        <div id="preview"></div>
                        <input type="hidden" name="image" id="image" value="">
                        <br>
                        <input type="hidden" name="user_id" id="user_id" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="saveBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>


@push('scripts')
    <script>
        // Listen for the change event so we can capture the file
        function previewFiles() {
            var preview = document.querySelector('#preview');
            var files = document.querySelector('input[type=file]').files;

            function readAndPreview(file) {
                // Asegurate que `file.name` coincida con el criterio de extensiones
                if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                    var reader = new FileReader();
                    reader.addEventListener("load", function() {
                        var image = new Image();
                        image.height = 100;
                        image.title = file.name;
                        image.src = this.result;
                        document.getElementById("image").value = image.src;
                        preview.appendChild(image);
                    }, false);
                    reader.readAsDataURL(file);
                }
            }
            if (files) {
                [].forEach.call(files, readAndPreview);
            }
        };
        $('document').ready(function() {
            // success alert
            function swal_success() {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
            // error alert
            function swal_error() {
                Swal.fire({
                    position: 'centered',
                    icon: 'error',
                    title: 'Something goes wrong !',
                    showConfirmButton: true,
                })
            }

            // table serverside
            var table = $('#tableUser').DataTable({
                processing: false,
                serverSide: true,
                ordering: false,
                dom: 'Bfrtip',
                buttons: ['pdf'],
                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'name',
                        name: 'nombre'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'rol',
                        name: 'rol'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        "render": function(data) {
                            return '<img src="../../../../images/usuario/'+data+'" width="70px">';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // csrf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // initialize btn add
            $('#createNewUser').click(function() {
                $('#saveBtn').val("create user");
                $('#user_id').val('');
                $('#formUser').trigger("reset");
                $('#modal-user').modal('show');
            });
            // initialize btn edit
            $('body').on('click', '.editUser', function() {
                var user_id = $(this).data('id');
                $.get("{{ route('users.index') }}" + '/' + user_id + '/edit', function(data) {
                    $('#saveBtn').val("edit-user");
                    $('#modal-user').modal('show');
                    $('#user_id').val(data.id);
                    $('#name').val(data.name);
                    $('#avatar').val(data.image);
                    $('#rol').val(data.rol);
                    $('#email').val(data.email);
                    $('#level').val(data.level);
                })
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Save');

                $.ajax({
                    data: $('#formUser').serialize(),
                    url: "{{ route('users.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#formUser').trigger("reset");
                        $('#modal-user').modal('hide');
                        swal_success();
                        table.draw();

                    },
                    error: function(data) {
                        swal_error();
                        $('#saveBtn').html('Save Changes');
                    }
                });

            });
            // Inicializa la funcion de eliminar el usuario
            $('body').on('click', '.deleteUser', function() {
                var user_id = $(this).data("id");

                Swal.fire({
                    title: 'Esta seguro?',
                    text: "Esta accion no se puede revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('users.store') }}" + '/' + user_id,
                            success: function(data) {
                                swal_success();
                                table.draw();
                            },
                            error: function(data) {
                                swal_error();
                            }
                        });
                    }
                })
            });

            // statusing


        });
    </script>
@push('scripts')
