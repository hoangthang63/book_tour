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
            <h4>List app admin account</h4>
            <!-- Signup modal-->
            <button type="button" class="btn btn-primary" data-toggle="modal" id="clickButton" data-target="#signup-modal">Add</button>
            <div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body">
                            <div class="text-center mt-2 mb-4">
                                <a href="index.html" class="text-success">
                                    {{-- <span><img src="https://www.paditech.com/wp-content/uploads/2018/08/logo_header.png" alt="" height="35"></span> --}}
                                </a>
                            </div>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            <form class="pl-3 pr-3" action="{{ route('store.app.admin') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="username">Name</label>
                                    <input class="form-control" type="text" name="name" id="username" required=""
                                        placeholder="Michael Zenaty">
                                </div>

                                <div class="form-group">
                                    <label for="emailaddress">Account</label>
                                    <input class="form-control" type="text" name="account" id="emailaddress" required=""
                                        placeholder="nhokCoDonPr0vjp123">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password" required="" id="password"
                                        placeholder="Enter your password">
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
        {{-- @php
            dd($errors->any())
        @endphp --}}
        <div class="card-body">
            <table class="table table-striped table-centered mb-0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Account</th>
                        <th>Password</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($list_app_admins as $each)
                        <tr>
                            <td>{{ $each->id }}</td>
                            <td>{{ $each->name }}</td>
                            <td>{{ $each->account }}</td>
                            <td title="{{ $each->password }}">{{ substr($each->password, 0, 10) . "..." }}</td>
                            <td><a href="{{ route('app.admin.edit',['app' => $each->id]) }}" class="btn btn-info">Edit</a></td>
                            <td>
                            <form action="{{ route('app.admin.destroy',['app' => $each->id]) }}" style="display: inline" method="POST" >
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2 d-flex justify-content-center">
                <nav>
                    <ul class="pagination pagination-rounded mb-0">

                        {{ $list_app_admins->links() }}

                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
@section('app')
    <style>
        .btn-outline-primary {
            pointer-events: none;
        }
    </style>
    <button type="button"
        class="btn btn-outline-primary mt-2">{{ session()->get('name_app') ? session()->get('name_app') : 'CGV' }} </button>
@endsection

@section('js')
<script>
    var show_pop_up = {{ $errors->any() }};
if (show_pop_up == true) {
    window.onload = function() {
        document.getElementById('clickButton').click();
    }
}
</script>
@endsection
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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
@endpush