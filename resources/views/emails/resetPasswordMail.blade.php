<!DOCTYPE html>
<html>
<head>
    <title>Book Tour</title>
</head>
<body>

    <h1>{{ $data['email'] }}</h1>
    <div>
        <p>Your new password is <strong>{{ $data['password'] }}</strong></p>
    </div>
</body>
</html>