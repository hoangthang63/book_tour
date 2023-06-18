@extends('user.master')
@section('content')
    <h2 class="pl-2">Tạo Tour</h2>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="header-title">Tên</h4> --}}
                    <form action="{{ route('tour.update', ['tour' => $tour->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $tour->slot -  $tour->slot_available }}" name="booked" class="form-control">
                        <div class="form-group">
                            <label for="simpleinput">Tên:</label>
                            <input type="text" id="simpleinput" name="name" value="{{ $tour->name }}"
                                placeholder="nhập tên tour" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="example-select">Loại:</label>
                            <select class="form-control" name="type" id="example-select">
                                <option value="0" {{ $tour->type == '0' ? 'selected' : '' }}>Nội địa</option>
                                <option value="1" {{ $tour->type == '1' ? 'selected' : '' }}>Quốc tế</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="example-textarea">Mô tả:</label>
                            <textarea class="form-control" name="description" id="example-textarea" rows="5">{{ $tour->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="simpleinput">Điểm khởi hành:</label>
                            <input type="text" id="simpleinput" name="departure_place"
                                value="{{ $tour->departure_place }}" placeholder="Hà Nội" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="example-fileinput">Ảnh tour:</label>
                            <input type="file" id="example-fileinput" name="image" class="form-control-file">
                        </div>

                        <div class="form-group mb-3">
                            <label for="example-date">Ngày khởi hành:</label>
                            <input class="form-control col-sm-4" id="start_date" value="{{ $tour->start_at }}"
                                type="date" name="start_at">
                        </div>

                        <div class="form-group mb-3">
                            <label for="example-date">Ngày kết thúc:</label>
                            <input class="form-control col-sm-4" onchange="myFuntion()" value="{{ $tour->end_at }}"
                                id="end_date" type="date" name="end_at">
                        </div>

                        <div id="items">
                            <input type="hidden" value="{{ $schedules->total }}" name="total" class="form-control">
                            @foreach ($schedules as $schedule)
                                <h4>Ngày {{ $schedule->day }}</h4>
                                <div class="form-group">
                                    <label>Tiêu đề</label>
                                    <input type="text" name="{{ "schedule_title_" . $schedule->day }}" value="{{ $schedule->title }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea class="form-control" name="{{ "schedule_description_" . $schedule->day }}" rows="5">{{ $schedule->description }}</textarea>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="simpleinput">Số chỗ</label>
                            <input type="number" id="" value="{{ $tour->slot }}" name="slot" placeholder="40"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="simpleinput">Giá:</label>
                            <input type="number" id="" name="price" value="{{ $tour->price }}"
                                placeholder="nhập giá" class="form-control">
                        </div>

                        <button class="btn btn-primary">Lưu</button>
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
        let schedule = @json($schedules);
        window.onload = function() {
            console.log(schedule);
        };
        // console.log(schedule);
        let start_date_el = document.getElementById("start_date");
        let end_date_el = document.getElementById("end_date");

        function myFuntion() {
            const start_date = dayjs(start_date_el.value);
            const end_date = dayjs(end_date_el.value);

            let days = end_date.diff(start_date, 'days');

            console.log(days)
            if (days > 0) {
                $('#items').html('');
                let total = `<input type="hidden" value="${days}" name="total" class="form-control">`
                $('#items').append(total);

                for (let index = 1; index <= days; index++) {
                    if (schedule.length >= index) {
                        html = `
                        <h4>Ngày ${index}</h4>
                                    <div class="form-group">
                                        <label >Tiêu đề</label>
                                        <input type="text" name="schedule_title_${index}" value="${schedule[index - 1].title || ''}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Mô tả</label>
                                        <textarea class="form-control" name="schedule_description_${index}" rows="5">${schedule[index - 1].description || ''} </textarea>
                        </div>`
                    }else{ 
                        html = `
                        <h4>Ngày ${index}</h4>
                                    <div class="form-group">
                                        <label >Tiêu đề</label>
                                        <input type="text" name="schedule_title_${index}"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Mô tả</label>
                                        <textarea class="form-control" name="schedule_description_${index}" rows="5"></textarea>
                        </div>`
                    }
                    
                    $('#items').append(html);
                }
            }

        }
    </script>
@endsection
