@extends('user.master')
@section('title')
    <h2 class="page-title pt-2">{{ $gets->name }}</h2>
@endsection
@push('css')
    <style>
        @media only screen and (min-width:20.25em) and (max-width: 63.9375em){
            .css{
                flex-direction: column;
                display:flex;
            }
        }
    </style>
@endpush
@section('content')
    <div class="card d-block">
        <div class="card-body">
            <div class="d-flex w-100 justify-content-between css">
                <img src="{{ $gets->image }}" height="450px" width="850px" alt="">
                <div class="row pl-3">
                    <p><strong>Giới thiệu: </strong>{{ $gets->detail }} </p>
                    <p><strong>Lưu ý: </strong>{{ $gets->note }} </p>

                </div>
            </div>
            <div class="d-flex flex-row-reverse">
                <form action="{{ route('coupon.use', [
                    'id_coupon' => $gets->id,
                ]) }}"
                    method="post" id="formUse">
                    @csrf
                    <input type="text" value="{{ $gets->id }}" name="id" hidden>
                    @if ($gets->status == 1)
                        <button class="btn btn-outline-primary" id="btn-click">Sử dụng</button>
                    @else
                        <button class="btn btn-outline-secondary" disabled>Đã sử dụng</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function() {
            $("#formUse").on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {},
                    success: function() {
                        $("#btn-click").text('Đã sử dụng');
                        $("#btn-click").removeClass("btn btn-outline-primary").addClass("btn btn-outline-secondary");
                        $("#btn-click").prop('disabled', 'disabled');
                    }
                });
            });
        });
    </script>
@endsection
