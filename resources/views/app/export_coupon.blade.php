@extends('layout.master')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Coupon winning list</h4>
            <form action="{{ route('export') }}" method="post">
                @csrf
                <div class="form-group mb-0 d-flex">
                    <input type="text" class="form-control" placeholder="choose date" name="date" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd">
                    <button class="btn btn-primary">Export</button>
                
                </div>
            </form>

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
        <div class="card-body">
            <table class="table table-striped table-centered mb-0">
                <thead>
                    <tr>
                        <th>Coupon name</th>
                        <th>Winner's phone number</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($gets as $each)
                        <tr>
                            <td>{{ $each->name }}</td>
                            <td>{{ $each->phone_number }}</td>
                            <td>{{ $each->created_at }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2 d-flex justify-content-center">
                <nav >
                    <ul class="pagination pagination-rounded mb-0">
    
                        {{ $gets->links() }}
                        
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

    </script>
@endsection
