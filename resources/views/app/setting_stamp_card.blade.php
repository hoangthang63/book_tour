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
            <h4>Setting Stamp Card</h4>
            <a href="{{ route('setting.image') }}" class="btn btn-primary">View Image</a>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        @if (session()->has('message'))
            <div class="alert alert-warning mt-2">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('store.stamp') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mb-3">
                    <label for="inputEmail3" class="col-3 col-form-label">Max Stamp Card</label>
                    <div class="col-9">
                        <input type="number" class="form-control" name="maximum_stamp_card" placeholder="20" value="{{ $maxStamp }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="inputPassword5" class="col-3 col-form-label">Scan several times per day</label>
                    <div class="col-9">
                        <input type="checkbox" id="switch1" {{ $scanSeveralTimesPerDay ? 'checked' : ''}} data-switch="bool"
                            name="scan_several_times_per_day" />
                        <label for="switch1" data-on-label="On" data-off-label="Off"></label>
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
