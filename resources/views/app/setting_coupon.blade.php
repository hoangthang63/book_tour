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
        <div class="card-header ">
            <h4>Setting Coupon</h4>


        </div>
        <div class="card-body scroll">
            @if (session()->has('message'))
                <div class="alert alert-warning mt-2">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger mb-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="form-horizontal" action="{{ route('store.coupon') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mb-2">
                    <label for="inputEmail3" class="col-3 col-form-label">Name</label>
                    <div class="col-9">
                        <input type="text" class="form-control" name="name" placeholder="Coupon CGV"
                            value="{{ $name ?? '' }}">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label for="inputPassword5" class="col-3 col-form-label">Detail</label>
                    <div class="col-9">
                        <textarea name="detail" class="form-control" placeholder="Nhập giới thiệu" style="height: 50px;">{{ $detail ?? '' }}</textarea>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="inputPassword5" class="col-3 col-form-label">Note</label>
                    <div class="col-9">
                        <input type="text" class="form-control" name="note" value="{{ $note ?? '' }}"
                            placeholder="01 khách hàng chỉ nhận được 01 mã">
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="inputPassword5" class="col-3 col-form-label">Number of stamp needed</label>
                    <div class="col-9">
                        <input type="number" class="form-control" name="number_of_stamp_needed"
                            value="{{ $number_of_stamp_needed ?? '' }}" placeholder="5">
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-3 col-form-label"> Image</label>
                    <div class="col-9">


                        <label class="custom-file-upload">
                            <img src="{{ $image ?? '' }}" alt="ảnh coupon" height="70px" width="130px">
                            <input type="file" name="image">

                        </label>
                    </div>
                </div>
                <div class="form-group mb-0 justify-content-end row">
                    <div class="col-9">
                        <button type="submit" class="btn btn-info  ">Save</button>
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

        .scroll {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
    <button type="button"
        class="btn btn-outline-primary mt-2">{{ session()->get('name_app') ? session()->get('name_app') : 'CGV' }} </button>
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
