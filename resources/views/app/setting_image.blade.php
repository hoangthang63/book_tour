@extends('layout.master')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Image</h4>
            <div onclick="showSuccessToast();" class="btn btn--success">Show success toast</div>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signup-modal">Setting
                Image</button>
            <div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body">
                            <div class="text-center mt-2 mb-4">
                                <a href="index.html" class="text-success">
                                    <span><img src="https://www.paditech.com/wp-content/uploads/2018/08/logo_header.png"
                                            alt="" height="35"></span>
                                </a>
                            </div>

                            <form class="pl-3 pr-3" action="{{ route('store.image') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label for="inputEmail3" class="col-3 col-form-label">Position</label>
                                    <div class="col-9">
                                        <select id="position" name="position[]" multiple class="form-control">
                                            @for ($i = 1; $i <= $maxStamp; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        {{-- <input type="number" class="form-control" name="ordinal_number" placeholder="20"> --}}
                                        {{-- <input type="text" id="range_04" data-plugin="range-slider" data-min="1"
                                            data-max="6" data-from="1" data-to="2" data-type="double" data-grid="true"
                                            name="range" /> --}}
                                    </div>

                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Image untick</label>
                                    <div class="col-9">
                                        <label class="custom-file-upload">
                                            <input type="file" name="image_untick">

                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Image ticked</label>
                                    <div class="col-9">
                                        <label class="custom-file-upload">
                                            <input type="file" name="image_ticked">
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
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
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
                        <th>Image untick</th>
                        <th>Image ticked</th>
                        <th>Position</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($gets as $each)
                        <tr>
                            <td><img src="{{ $each->image_untick }}" alt="" height="50px" width="50px"></td>
                            <td><img src="{{ $each->image_ticked }}" alt="" height="50px" width="50px"></td>
                            <td>{{ $each->ordinal_number }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="mt-2 d-flex justify-content-center">
                <nav>
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
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script>
        toastr.options.closeButton = true;
        toastr.options.progressBar = true;
        $(document).ready(function() {
            $('#position').multiselect({
                includeSelectAllOption: true,
                nonSelectedText: 'Select Position',
                enableFiltering: true,
                maxHeight: 300,
                enableCaseInsensitiveFiltering: true,
                buttonWidth: '200px'
            });
        });

        function showSuccessToast() {
            toastr.success('Success')
        }
    </script>
@endpush
