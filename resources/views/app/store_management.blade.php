@extends('layout.master')
@push('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/fc-4.1.0/fh-3.2.4/r-2.3.0/sc-2.0.7/sb-1.3.4/datatables.min.css"/>
@endpush
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>List store</h4>
            {{-- <form class="mb-0">
                <div class="d-flex">
                    <input type="search" class="form-control" name="q" value="{{ $search }}" placeholder="Enter name or address..." >
                    <button class="btn btn-primary">Search</button>
                </div>

            </form> --}}
            <!-- Signup modal-->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signup-modal">Import CSV</button>
            <div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body">
                            <div class="text-center mt-2 mb-4">
                                <a href="index.html" class="text-success">
                                    {{-- <span><img src="https://www.paditech.com/wp-content/uploads/2018/08/logo_header.png"
                                            alt="" height="35"></span> --}}
                                </a>
                            </div>

                            <form class="pl-3 pr-3" action="{{ route('store.import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="username">CSV File</label>
                                    <input class="form-control" type="file" name="csv" id="username" required=""
                                        placeholder="Michael Zenaty">
                                </div>

                                <div class="form-group text-center">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>

                            </form>

                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            @if ($errors->any())
                <div class="alert alert-danger mb-0">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="card-body scroll">
            <table class="table table-striped table-centered mb-0" id="table-store">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Qr Code</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($gets as $each)
                        @php
                            $idApp = session()->get('id_app');
                            $qrCodeURrl = url('user/' . $idApp . '/' . $each->id);
                        @endphp
                        <tr>
                            <td>{{ $each->id }}</td>
                            <td>{{ $each->name }}</td>
                            <td>{{ $each->address }}</td>
                            <td>
                                
                                    <img src="data:image/png;base64, {!! base64_encode(
                                        QrCode::format('png')->size(50)->generate($qrCodeURrl),
                                    ) !!} ">
                                

                            </td>
                            <td>
                                <a href="data:image/png;base64, {!! base64_encode(
                                    QrCode::format('png')->size(50)->generate($qrCodeURrl),
                                ) !!} " download>
                                    <img src="https://img.icons8.com/external-anggara-blue-anggara-putra/344/external-download-ui-basic-anggara-blue-anggara-putra.png"
                                        height="30px" alt="">
                                </a>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2 d-flex justify-content-center">
                <nav>
                    <ul class="pagination pagination-rounded mb-0">

                        {{ $gets->links() }}

                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
@push('js')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/fc-4.1.0/fh-3.2.4/r-2.3.0/sc-2.0.7/sb-1.3.4/datatables.min.js"></script>
{{-- <script>
    $(function() {
    $('#table-store').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 2,
      lengthMenu: [[2, 4, 6, 8], [2, 4, 6,8]],
        ajax: '{!! route('api.store',[
            'id_app' => session()->get('id_app'),
        ]) !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            {
                        data: 'Qr code',
                        targets: 3,
                        orderable: false,
                        searchable: false,
                        render: function ( data, type, row, meta ) {
                          return '<img src="data:image/png;base64, {!! base64_encode(
                                        QrCode::format('png')->size(50)->generate(url('user/' . {{ $idApp }} . '/' . ${data})),
                                    ) !!} "/>';
                        }

        ]
    });
});
</script> --}}
@endpush
@section('app')
    <style>
        .btn-outline-primary {
            pointer-events: none;
        }
        .scroll {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
    <button type="button"
        class="btn btn-outline-primary mt-2">{{ session()->get('name_app') ? session()->get('name_app') : 'CGV' }} </button>
@endsection
