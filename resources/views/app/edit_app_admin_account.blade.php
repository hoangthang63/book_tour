@extends('layout.master')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Edit app admin</h4>
            
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
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('app.admin.update',
            ['app' => $app]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group row mb-3">
                    <label for="inputEmail3" class="col-3 col-form-label">Tên</label>
                    <div class="col-9">
                        <input type="text" class="form-control" name="name" value="{{ $app->name }}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="inputEmail3" class="col-3 col-form-label">Tài khoản</label>
                    <div class="col-9">
                        <input type="text" class="form-control" name="account" value="{{ $app->account }}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="inputEmail3" class="col-3 col-form-label">Mật khẩu</label>
                    <div class="col-9">
                        <input type="password" class="form-control" name="password" value="{{ $app->password }}">
                    </div>
                </div>

                <div class="form-group mb-0 justify-content-end row">
                    <div class="col-9">
                        <button type="submit" class="btn btn-info  ">Lưu</button>
                    </div>
                </div>
            </form>
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
