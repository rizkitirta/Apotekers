<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table table-striped bordered "  id="datatable">
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

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@stack('js')
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.js') }}"></script>
<script>
    $(document).ready(function(){
        loadData()
    })

    function loadData() {
        $('#datatable').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('supplier.index') }}"
            },
            columns: [
                {data: 'nama', name: 'nama'},
                {data: 'telp', name: 'telp'},
                {data: 'email', name: 'email'},
                {data: 'rekening', name: 'rekening'},
                {data: 'alamat', name: 'alamat'},
                {data: 'aksi', name: 'aksi', orderable: false},
            ]
        })
    }
</script>
