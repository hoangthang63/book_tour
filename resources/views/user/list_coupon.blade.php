@extends('user.master')
@section('content')
    <h2 class="pl-2">Danh sách coupon</h2>
    <div class="list-group">
        @if ($gets == '[]')
            <h5>Bạn chưa có coupon nào! Hãy scan thật nhiều để nhận coupon nhé !!!</h5>
        @endif
        @foreach ($gets as $get)
        <a href="{{ route('coupon.detail',[
            'id_coupon' => $get->id,
        ]) }}" class="list-group-item list-group-item-action border border-success border-bottom-0">
            <div class="d-flex w-100 justify-content-between">
                <h4 class="mb-1">{{ $get->name }}</h4>
                @if ($get->status ==1)
                <button class="btn btn-outline-primary">Sử dụng</button>
                @else
                <button class="btn btn-outline-secondary" disabled>Đã sử dụng</button>
                @endif
                
            </div>
            <div class="d-flex">
                <div class=""><img src="{{ $get->image }}"
                    alt="" height="100px" width="160px"></div>
                <div class=" pl-2" style="padding-right:110px"><h5 class="mt-0">{{ $get->detail }}</h5></div>
              </div>
        </a>
        @endforeach

    </div>
@endsection
