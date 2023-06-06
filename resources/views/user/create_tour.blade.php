@extends('user.master')
@section('content')
    <h2 class="pl-2">Tạo Tour</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="header-title">Tên</h4> --}}
                        <div class="form-group">
                            <label for="simpleinput">Tên:</label>
                            <input type="text" id="simpleinput" placeholder="nhập tên tour" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="example-fileinput">Ảnh tour:</label>
                            <input type="file" id="example-fileinput" class="form-control-file">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="example-date">Ngày khởi hành:</label>
                            <input class="form-control col-sm-4" id="start_date" type="date" name="date">
                        </div>

                        <div class="form-group mb-3">
                            <label for="example-date">Ngày kết thúc:</label>
                            <input class="form-control col-sm-4" onchange="myFuntion()" id="end_date" type="date" name="date">
                        </div>

                        <div id="items">

                        </div>


                        <div class="form-group">
                            <label for="simpleinput">Giá:</label>
                            <input type="text" id="" placeholder="nhập tên tour" class="form-control">
                        </div>
                        {{-- <p class="text-muted font-14">Select2 gives you a customizable select box with support for searching, tagging, remote data sets, infinite scrolling, and many other highly used options.</p> --}}

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
        function myFuntion(){
            const start_date = dayjs(start_date_el.value);
            const end_date = dayjs(end_date_el.value);

            let days = end_date.diff(start_date, 'days');

            console.log(days)
            if (days > 0) {
                for (let index = 1; index <= days; index++) {
                    let html = `
                <h4>Ngày ${index}</h4>
                            <div class="form-group">
                                <label for="simpleinput">Tiêu đề</label>
                                <input type="text" id="simpleinput" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="example-textarea">Mô tả</label>
                                <textarea class="form-control" id="example-textarea" rows="5"></textarea>
                </div>`
                $('#items').append(html);
                }
            }

        }
    </script>
@endsection