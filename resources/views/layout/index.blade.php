@extends('layout.master')
@section('content')
@php
if (session()->has('notification')) {
    $success = true;
}
session()->forget('notification');
@endphp
<div onclick="showSuccessToast();" id="success" class="btn btn--success" hidden>Show success toast</div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>List app</h4>
            <!-- Center modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#centermodal">Add</button>
            <div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center mt-2 mb-4">
                                <a href="" class="text-success">
                                    {{-- <span><img src="https://www.paditech.com/wp-content/uploads/2018/08/logo_header.png" alt="" height="35"></span> --}}
                                </a>
                            </div>

                            <form class="pl-3 pr-3" action="{{ route('store.app') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="username">Name</label>
                                    <input class="form-control" type="text" name="name" id="username" required=""
                                        placeholder="CGV">
                                </div>

                                <div class="form-group">
                                    <label for="emailaddress">Logo</label>
                                    <input class="form-control" type="file" name="logo" id="emailaddress" required=""
                                        placeholder="nhokCoDonPr0vjp123">
                                </div>


                                <div class="form-group text-center">
                                    <button class="btn btn-primary" type="submit">Add</button>
                                </div>

                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
        <div class="card-body">
            <table class="table table-striped table-centered mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Logo</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($list_apps as $list_app)
                        <tr>
                            <td>{{ $list_app->name }}</td>
                            <td><img src="{{ $list_app->logo }}" alt="" style="width:80px ;height: 80px"></td>
                            <td><a href="{{ route('app.edit',
                            ['app' => $list_app->id_app]) }}" class="btn btn-info">Edit</a></td>
                            <td>
                                <form action="{{ route('app.destroy',['app' => $list_app->id_app]) }}" style="display: inline" method="POST" >
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" onclick="return confirm('You will delete all data related to this app. Are you sure?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2 d-flex justify-content-center">
                <nav>
                    <ul class="pagination pagination-rounded mb-0">

                        {{ $list_apps->links() }}

                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
@section('app')
    <style>
        body.modal-open div.modal-backdrop {
            z-index: 0;
        }
    </style>
    <button type="button" class="btn btn-outline-primary mt-2" data-toggle="modal" data-target="#right-modal"
        id="btn-click">{{ session()->get('name_app') ? session()->get('name_app') : 'CGV' }} </button>
    <div id="right-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-right">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>Chọn app</h4>
                    <div class="text-center">
                        <form action="{{ route('choose.app') }}" method="POST" id="formApp">
                            @csrf
                            <select class="custom-select mb-3" name="id_app">
                                @foreach ($all_apps as $all_app)
                                    <option value="{{ $all_app->id_app }}" name="id_app">{{ $all_app->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('js')
    <script>
        $(function() {
            $("#formApp").on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {},
                    success: function(data) {

                        $('#right-modal').modal('hide');
                        $("#btn-click").text(data.name);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script>
        var notifi = {{ $success ?? false }};
        if (notifi == true) {
            window.onload = function() {
                document.getElementById('success').click();
            }
        }
        toastr.options.closeButton = true;
        toastr.options.progressBar = true;
        function showSuccessToast() {
            toastr.success('Success')
        }
    </script>
@endsection
@push('js')

@endpush
