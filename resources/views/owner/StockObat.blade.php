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
                            <th>Nama Obat</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stock</th>
                            <th>Keterangan</th>
                            <th>User</th>
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
                                <form action="{{ route('stock-obat.store') }}" method="POST" id="form">
                                    @csrf
                                    <input type="hidden" value="" name="id" id="id">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="obat_id">Pilih Obat</label>
                                            <select name="obat_id" id="obat_id" class="form-control">
                                                <option value="" selected disabled>Pilih Obat</option>
                                                @foreach ($obat as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="stock_lama">Stock Lama</label>
                                                    <input autocomplete="off" type="text" class="form-control"
                                                        id="stock_lama" name="stock_lama"
                                                        onkeypress="return number(event)" value="0">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="masuk">Masuk</label>
                                                    <input autocomplete="off" type="text" class="form-control"
                                                        id="masuk" name="masuk" onkeypress="return number(event)"
                                                        value="0">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="keluar">Keluar</label>
                                                    <input autocomplete="off" type="text" class="form-control"
                                                        id="keluar" name="keluar" onkeypress="return number(event)"
                                                        value="0">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="stock_akhir">Stock Akhir</label>
                                                    <input autocomplete="off" type="text" class="form-control"
                                                        id="stock_akhir" name="stock_akhir" value="0"
                                                        onkeypress="return number(event)">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="beli">Harga Beli</label>
                                                    <input autocomplete="off" type="text" class="form-control" id="beli"
                                                        name="beli" onkeypress="return number(event)">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="jual">Harga Jual</label>
                                                    <input autocomplete="off" type="text" class="form-control" id="jual"
                                                        name="jual" onkeypress="return number(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="expired">Expired</label>
                                            <input autocomplete="off" type="date" class="form-control" id="expired"
                                                name="expired">
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangann">Text</label>
                                            <textarea id="keterangan" class="form-control" name="keterangan"
                                                rows="3"></textarea>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" id="btn-tutup" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" id="btn-simpan" class="btn btn-primary">Save</button>
                                        </div>
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

        //Reset Form Input
        // $('#btn-tambah').click(function() {
        //     $('#form')[0].reset()
        // });

        //Get data stok obat
        $('#obat_id').on('change', function() {
            let id = $(this).val()
            $.ajax({
                url: "{{ route('stock-obat.getObat') }}",
                type: 'POST',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    $('#stock_lama').val(res.data.stock)
                },
                error: function(xhr) {
                    console.log(xhr)
                }
            })
        })

        //Live Sum Input Stock
        $('#masuk').on('change', function() {
            let awal = parseInt($('#stock_lama').val())
            let masuk = parseInt($('#masuk').val())
            let keluar = parseInt($('#keluar').val())
            let akhir = (awal + masuk) - keluar
            $('#stock_akhir').val(akhir)
        })

        //Live Sum Input Stock
        $("#keluar").on('change', function() {
            let awal = parseInt($('#stock_lama').val())
            let masuk = parseInt($('#masuk').val())
            let keluar = parseInt($('#keluar').val())
            let akhir = (awal + masuk) - keluar
            $('#stock_akhir').val(akhir)
        })

        //Function Store
        $('#form').on('submit', function() {
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
                    $('#form')[0].reset()
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
    })

    //Get datatables
    function loadData() {
        $('#datatable').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('stock-obat.index') }}"
            },
            columns: [{
                    data: 'namaObat',
                    name: 'namaObat'
                },
                {
                    data: 'jual',
                    name: 'jual'
                },
                {
                    data: 'beli',
                    name: 'beli'
                },
                {
                    data: 'stock',
                    name: 'stock'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'userName',
                    name: 'userName'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                },
            ]
        })
    }

    //Validasi Inputan Harus Number
    function number(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

</script>
