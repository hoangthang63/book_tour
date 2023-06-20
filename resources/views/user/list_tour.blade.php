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
            <h4>List Tour</h4>
            <!-- Signup modal-->
            {{-- <div class="form-group">
                <label for="simpleinput">Text</label>
                <input type="text" id="simpleinput" class="form-control">
            </div> --}}
            <form action="" method="GET">
                <div class="form-group row mb-0">
                    <input type="text" id="simpleinput" placeholder="nhập từ khóa" name="key_word" class="form-control col-6">
                    <select id="example-multiselect" name="type" class="form-control col-6">
                        <option value="inPrepare">Sắp bắt đầu</option>
                        <option value="all">Tất cả</option>
                        <option value="inProgress">Đang diễn ra</option>
                        <option value="ended">Kết thúc</option>
                    </select>
                </div>
            </form>


            <div class="form-group d-block">
                <a href="{{ route('tour.create') }}" class="btn btn-primary">Create</a>
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
                        <th>Tên</th>
                        <th>Điểm khởi hành</th>
                        <th>Giá</th>
                        <th>Thời gian</th>
                        <th>Đã đặt</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($listTour as $each)
                        <tr>
                            <td>{{ $each->id }}</td>
                            <td>{{ $each->name }}</td>
                            <td>{{ $each->departure_place }}</td>
                            <td>{{ $each->price }}</td>
                            <td>{{ $each->start_at . '~' .$each->end_at }}</td>
                            <td>{{ $each->slot - $each->slot_available . '/' .$each->slot }}</td>
                            <td><a href="{{ route('tour.edit',['tour' => $each->id]) }}" class="btn btn-info">Edit</a></td>
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

                        {{-- {{ $list_app_admins->links() }} --}}

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