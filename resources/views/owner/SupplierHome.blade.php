<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <button type="button" class="btn btn-primary float-right mb-2" data-toggle="modal"
                    data-target="#modal-default" id="btn-tambah">
                    Insert Supplier
                </button>
                <table class="table table-striped bordered " id="datatable">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Telpon</th>
                            <th>Email</th>
                            <th>Rekening</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                </table>

                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Supplier</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- form start -->
                                <form action="{{ route('supplier.store') }}" method="POST" id="form">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" value="" name="id" id="id">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="nama">Nama Supplier</label>
                                                    <input autocomplete="off" type="text" class="form-control" id="nama"
                                                        placeholder="Enter Name" name="nama">
                                                </div>
                                                <div class="form-group">
                                                    <label for="telp">No Telpon</label>
                                                    <input autocomplete="off" type="text" class="form-control" id="telp"
                                                        placeholder="Enter Telp" name="telp"
                                                        onkeypress="return number(event)">
                                                </div>
                                                <div class="form-group">
                                                    <label for="rekening">No Rekening</label>
                                                    <input autocomplete="off" type="text" class="form-control"
                                                        id="rekening" placeholder="Enter rekening" name="rekening"
                                                        onkeypress="return number(event)">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="email">Email address</label>
                                                    <input autocomplete="off" type="email" class="form-control"
                                                        id="email" placeholder="Enter email" name="email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <textarea autocomplete="off" class="form-control" name="alamat"
                                                        id="alamat" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" id="btn-tutup" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" id="btn-simpan" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
        </div>
    </div>
</x-app-layout>
@stack('js')
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.js') }}"></script>
<script>
    $(document).ready(function() {
        loadData()

        $('#btn-tambah').click(function() {
            $('#form').attr('action', "{{ route('supplier.store') }}")
            $('#id').val('')
            $('#nama').val('')
            $('#telp').val('')
            $('#email').val('')
            $('#rekening').val('')
            $('#alamat').val('')
        });
    })

    function loadData() {
        $('#datatable').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('supplier.index') }}"
            },
            columns: [{
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'telp',
                    name: 'telp'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'rekening',
                    name: 'rekening'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                },
            ]
        })
    }

    function number(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $(document).on('submit', 'form', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            typeData: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(res) {
                console.log(res)
                $('#btn-tutup').click()
                $('#datatable').DataTable().ajax.reload()
                Swal.fire({
                    icon: 'success',
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            error: function(xhr) {
                console.log(xhr);
                Swal.fire({
                    icon: 'error',
                    title: xhr.responseJSON.message,
                })
            }
        })
    })

    $(document).on('click', '.edit', function() {
        $('#modal-default').modal()
        $('#form').attr('action', "{{ route('supplier.update') }}")
        let id = $(this).attr('id')
        $.ajax({
            url: "{{ route('supplier.edit') }}",
            type: 'POST',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                console.log(res);
                $('#id').val(res.id)
                $('#nama').val(res.nama)
                $('#telp').val(res.telp)
                $('#email').val(res.email)
                $('#rekening').val(res.rekening)
                $('#alamat').val(res.alamat)
                $('#btn-tutup').click()
                $('#datatable').DataTable().ajax.reload()
            },
            error: function(xhr) {
                console.log(xhr);
                Swal.fire({
                    icon: 'error',
                    title: xhr.responseJSON.message,
                })
            }
        })
    })

    $(document).on('click', '.hapus', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).attr('id')
                $.ajax({
                    url: "{{ route('supplier.hapus') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        console.log(res);
                        $('#datatable').DataTable().ajax.reload()
                    },
                    error: function(xhr) {
                        console.log(xhr);

                    }
                })
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })

    })

</script>
