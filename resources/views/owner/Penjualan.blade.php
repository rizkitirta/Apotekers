<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2> --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col-4">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Data Customer</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form action="{{ route('penjualan.store') }}" method="POST" id="form">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nama_pasien">Nama Pasien</label>
                                        <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"
                                            placeholder="Enter Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="telp">No telpon</label>
                                        <input type="text" class="form-control" id="telp" placeholder="Telp"
                                            name="telp">
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Text</label>
                                        <textarea id="alamat" class="form-control" name="alamat" rows="3"></textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="no_resep">No Resep</label>
                                                <input type="text" class="form-control" id="no_resep" name="no_resep"
                                                    placeholder="Isi Jika Ada">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="pengirim">Pengirim</label>
                                                <input type="text" class="form-control" id="pengirim" name="pengirim"
                                                    placeholder="Isi Jika Ada">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-8">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Data Pembelian</h3>
                            </div>
                            <!-- form start pembelian -->
                                <input type="hidden" value="" name="id" id="id">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="obat_id">Nama Obat</label>
                                                <select id="obat_id" class="form-control" name="obat_id">
                                                    <option>Pilih Obat</option>
                                                    @foreach ($obat as $item)
                                                        <option value="{{ $item->id }}">{{ $item->namaObat }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="stock">Stock Tersedia</label>
                                                <input autocomplete="off" type="text" class="form-control" id="stock"
                                                    name="stock" onkeypress="return number(event)" value="0">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="kwintansi">No Kwintansi</label>
                                                <input autocomplete="off" type="text" class="form-control"
                                                    id="kwintansi" name="kwintansi" onkeypress="return number(event)"
                                                    value="0">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <input autocomplete="off" type="text" class="form-control" id="tanggal"
                                                    name="tanggal" value="0" onkeypress="return number(event)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="qty">Jumlah Pembelian</label>
                                                <input autocomplete="off" type="number" class="form-control" id="qty"
                                                name="qty" onkeypress="return number(event)" value="0">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="harga">Harga @satuan</label>
                                                <input autocomplete="off" type="text" class="form-control" id="harga"
                                                    name="harga" onkeypress="return number(event)" value="0">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="diskon">Diskon</label>
                                                <input autocomplete="off" type="text" class="form-control" id="diskon"
                                                    name="diskon" onkeypress="return number(event)" value="0">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="total_harga">Total Harga</label>
                                                <input autocomplete="off" type="text" class="form-control"
                                                    id="total_harga" name="total_harga" value="0"
                                                    onkeypress="return number(event)">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" id="btn-simpan" class="btn btn-success">Save</button>
                                    <button type="submit" id="btn-tambahObat" class="btn btn-primary">Tambah
                                        Obat</button>
                                </div>
                            </form>
                            <div class="card-body shadow">
                                <table class="table table-striped bordered " id="datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Total Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

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
                url: "{{ route('penjualan.getObat') }}",
                type: 'POST',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    $('#stock').val(res.data.stock)
                    $('#harga').val(res.data.jual)
                },
                error: function(xhr) {
                    console.log(xhr)
                }
            })
        })

        //Live Sum Input Qty
        $('#qty').on('change', function() {
            let qty = parseInt($('#qty').val())
            let harga = parseInt($('#harga').val())
            $('#total_harga').val(qty * harga)
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
                url: "{{ route('penjualan.index') }}"
            },
            columns: [{
                    data: 'namaObat',
                    name: 'namaObat'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'totalHarga',
                    name: 'totalHarga'
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
