<!DOCTYPE html>
<html>
<head>
    <title>Travel KMA</title>
</head>
<body>

    <h3>Bạn đã đặt thành công {{ $data['amount'] }} vé tour {{ $data['name'] }}</h3>
    <div>
    @foreach ($data['tickets'] as $tickets)
        <img src="{{ $tickets }}" width="300" height="300">
    @endforeach
    </div>
</body>
</html>