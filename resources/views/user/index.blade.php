@extends('user.master')
@section('list_app')
    <select name="id_app" class="" onchange="window.location.href=this.value;">
        @foreach ($list_apps as $list_app)
            <option value="{{ route('user', [$list_app->id_app]) }}" @if ($id_app == $list_app->id_app) selected @endif
                name="id_app">
                {{ $list_app->name }}</option>
        @endforeach
    </select>
    @php
        // dd($pop_up,$coupon);
        if (session()->has('id_coupon')) {
            $j = true;
        }
        session()->forget('id_coupon');
        if (session()->has('notification')) {
            $success = true;
        }
        session()->forget('notification');
    @endphp
@endsection
@section('popup')
    <div onclick="showSuccessToast();" id="success" class="btn btn--success" hidden>Show success toast</div>

    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#bs-example-modal-lg" id="clickButton"
        hidden>Popup</button>
    <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Chúc mừng bạn đã
                        trúng coupon</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body"
                    style="background-image: url({{ $coupon_image }}); background-size: 100% 100%; height:400px">
                    <h4>{{ $coupon_name }}</h4>
                    <img src="" alt="">
                </div>
                <div class="modal-footer">
                    <a href="{{ route('coupon.detail', ['id_coupon' => $id_coupon]) }}" class="btn btn-primary">Chi tiết</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('content')
    @if (session()->has('message'))
        <div class="alert alert-warning mt-2">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="d-flex flex-wrap align-content-around justify-content-center " style="height:100%">
        @for ($i = 1; $i <= $max_stamp_card; $i++)
            @if ($i <= $point % $max_stamp_card)
                <div class="p-4 "><img
                        src="{{ $image[$i - 1]->image_ticked ?? 'https://img.icons8.com/external-dreamstale-lineal-dreamstale/344/external-checked-interface-dreamstale-lineal-dreamstale-2.png' }}"
                        alt="" style="height:130px; width:130px;">
                </div>
            @else
                <div class="p-4 "><img
                        src="{{ $image[$i - 1]->image_untick ?? 'https://img.icons8.com/dotty/344/circled.png' }}"
                        alt="" style="height:130px;width:130px;">
                </div>
            @endif
        @endfor
    </div>
@endsection

@section('open_popup')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script>
        var i = {{ $pop_up }};
        var coupon = {{ $j ?? false }};
        // var coupon = {{ session()->has('coupon') }};
        // var idCoupon = {{ $id_coupon }};
        // var show_pop_up = localStorage.getItem("show_pop_up");(show_pop_up == null || show_pop_up == undefined)
        if (i == 1 && coupon == true) {
            window.onload = function() {
                // localStorage.setItem("show_pop_up", "1");
                document.getElementById('clickButton').click();
            }
        }

        // if ( i == 0 && idCoupon == -1) {
        //         localStorage.removeItem("show_pop_up");
        // }
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