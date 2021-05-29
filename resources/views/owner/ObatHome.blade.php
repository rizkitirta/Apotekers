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
                    Tambah Obat
                </button>
                <table class="table table-striped bordered " id="datatable">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Dosis</th>
                            <th>Indikasi</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                </table>

                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Obat</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- form start -->
                                <form action="{{ route('obat.store') }}" method="POST" id="form">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" name="id" id="id">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="nama">Nama Obat</label>
                                                    <input autocomplete="off" type="text" class="form-control" id="nama"
                                                        placeholder="Enter Name" name="nama">
                                                </div>
                                                <div class="form-group">
                                                    <label for="kode">Kode</label>
                                                    <input autocomplete="off" type="text" class="form-control" id="kode"
                                                        placeholder="Enter Kode" name="kode"
                                                        onkeypress="return number(event)">
                                                </div>
                                                <div class="form-group">
                                                    <label for="dosis">Dosis</label>
                                                    <input autocomplete="off" type="text" class="form-control"
                                                        id="dosis" placeholder="Enter dosis" name="dosis">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="indikasi">Indikasi</label>
                                                    <input autocomplete="off" type="text" class="form-control"
                                                        id="indikasi" placeholder="Enter indikasi" name="indikasi">
                                                </div>
                                                <div class="form-group">
                                                    <label for="kategori_id">Kategori</label>
                                                    <select name="kategori_id" id="kategori_id" class="form-control">
                                                        <option value="">Pilih Kategori</option>
                                                        @foreach ($kategori as $item)
                                                            <option value="{{ $item->id }}">{{ $item->kategori }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="satuan_id">Satuan</label>
                                                    <select name="satuan_id" id="satuan_id" class="form-control">
                                                        <option value="">Pilih Satuan</option>
                                                        @foreach ($satuan as $item)
                                                            <option value="{{ $item->id }}">{{ $item->satuan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
            $('#form').attr('action', "{{ route('obat.store') }}")
            $('#id').val('')
            $('#nama').val('')
            $('#kode').val('')
            $('#dosis').val('')
            $('#indikasi').val('')
            $('#kategori_id').val('')
            $('#satuan_id').val('')
        });

    })

    function loadData() {
        $('#datatable').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('obat.index') }}"
            },
            columns: [{
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'dosis',
                    name: 'dosis'
                },
                {
                    data: 'indikasi',
                    name: 'indikasi'
                },
                {
                    data: 'kategoris',
                    name: 'kategoris'
                },
                {
                    data: 'satuans',
                    name: 'satuans'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                },
            ]
        })
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
        $('#form').attr('action', "{{ route('obat.update') }}")
        let id = $(this).attr('id')
        $.ajax({
            url: "{{ route('obat.edit') }}",
            type: 'POST',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                console.log(res);
                $('#id').val(res.id)
                $('#nama').val(res.nama)
                $('#kode').val(res.kode)
                $('#dosis').val(res.dosis)
                $('#indikasi').val(res.indikasi)
                $('#kategori_id').val(res.kategori_id)
                $('#satuan_id').val(res.satuan_id)
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
            title: 'Apakah Anda Yakin?',
            text: "Data Akan Dihapus Permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).attr('id')
                $.ajax({
                    url: "{{ route('obat.hapus') }}",
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




