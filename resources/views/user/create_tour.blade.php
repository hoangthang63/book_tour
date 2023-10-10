@extends('layout.master')
{{-- @extends('user.master') --}}
@section('content')
    <h2 class="pl-2">Tạo Tour</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body scroll">
                        {{-- <h4 class="header-title">Tên</h4> --}}
                        <form action="{{ route('tour.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group">
                            <label for="simpleinput">Tên:</label>
                            <input type="text" id="simpleinput" name="name" placeholder="nhập tên tour" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="example-select">Loại:</label>
                            <select class="form-control" name="type" id="example-select">
                                <option value="0">Nội địa</option>
                                <option value="1">Quốc tế</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="example-textarea">Mô tả:</label>
                            <textarea class="form-control" name="description" id="example-textarea" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="simpleinput">Điểm khởi hành:</label>
                            <input type="text" id="simpleinput" name="departure_place" placeholder="Hà Nội" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="example-fileinput">Ảnh tour:</label>
                            <input type="file" id="example-fileinput" name="image" class="form-control-file">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="example-date">Ngày khởi hành:</label>
                            <input class="form-control col-sm-4" onchange="myFuntion()" id="start_date" type="date" name="start_at">
                        </div>

                        <div class="form-group mb-3">
                            <label for="example-date">Ngày kết thúc:</label>
                            <input class="form-control col-sm-4" onchange="myFuntion()" id="end_date" type="date" name="end_at">
                        </div>

                        <div id="items">
                            
                        </div>

                        <div class="form-group">
                            <label for="simpleinput">Số chỗ</label>
                            <input type="number" id="" min="1" name="slot" placeholder="40" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="simpleinput">Giá:</label>
                            <input type="number" id="" min="0" name="price" placeholder="nhập giá" class="form-control">
                        </div>

                        <button class="btn btn-primary">Tạo</button>
                        {{-- <p class="text-muted font-14">Select2 gives you a customizable select box with support for searching, tagging, remote data sets, infinite scrolling, and many other highly used options.</p> --}}
                    </form>

                    </div>
                </div>
            </div>
        </div>
@endsection
@section('js')
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
    <script>
        let start_date_el = document.getElementById("start_date");
        let end_date_el = document.getElementById("end_date");
        var now = dayjs(dayjs(), "MM-DD-YYYY")
        function myFuntion(){
            const start_date = dayjs(start_date_el.value);
            const end_date = dayjs(end_date_el.value);
            console.log("now:" + (now - start_date))
            if (now - start_date > 0) {
                document.getElementById("start_date").value = ''
                alert("Ngày khởi hành phải sau ngày hôm nay");
                return
            }

            if (now - end_date > 0) {
                document.getElementById("end_date").value = ''
                alert("Ngày kết thúc phải sau ngày hôm nay");
                return
            }

            if (start_date - end_date >= 0) {
                document.getElementById("end_date").value = ''
                alert("Ngày kết thúc phải sau ngày khởi hành");
                return
            }

            let days = end_date.diff(start_date, 'days');

            console.log(days)
            if (days > 0) {
                $('#items').html('');
                let total = `<input type="hidden" value="${days}" name="total" class="form-control">`
                $('#items').append(total);

                for (let index = 1; index <= days; index++) {
                     html = `
                <h4>Ngày ${index}</h4>
                            <div class="form-group">
                                <label >Tiêu đề</label>
                                <input type="text" name="schedule_title_${index}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control" name="schedule_description_${index}" rows="5"></textarea>
                </div>
                <div class="form-group">
                            <label for="example-fileinput">Ảnh</label>
                            <input type="file" name="schedule_image_${index}" class="form-control-file">
                </div>`
                $('#items').append(html);
                }
            }

        }
    </script>
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