<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300);

        html {
            height: 90%;
        }

        body {
            background: #3F485B;
            display: flex;
            align-items: center;
            height: 90%;
        }

        .back {
            margin: 1em auto;
            font-family: "Roboto";
        }

        .back span {
            font-size: 3em;
            color: #F2C640;
            background: #262B37;
            display: table-cell;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.3), 0 5px 0 #ccc;
            padding: 0 15px;
            line-height: 100px;
            animation: jumb 2s infinite;
        }

        @keyframes jumb {
            0% {
                transform: translateY(0px)
            }

            50% {
                transform: translateY(-30px);
                box-shadow: 0 15px 0 rgb(242, 198, 64);
            }

            100% {
                transform: translateY(0px)
            }
        }

        .back span:nth-child(1) {
            animation-delay: 0s;
        }

        .back span:nth-child(2) {
            animation-delay: .1s;
        }

        .back span:nth-child(3) {
            animation-delay: .2s;
        }

        .back span:nth-child(4) {
            animation-delay: .3s;
        }

        .back span:nth-child(5) {
            animation-delay: .4s;
        }

        .back span:nth-child(6) {
            animation-delay: .5s;
        }

        .back span:nth-child(7) {
            animation-delay: .6s;
        }
    </style>
</head>

<body>
    <form method="POST" action="{{ route('user.logging.in') }}">
        @csrf
        <input type="hidden" id="name" name="phone_number_user" >
        <button class="btn btn-primary " id="clickButton" hidden>Tiếp tục</button>
    </form>
    <span class="back">
        <span>L</span>
        <span>o</span>
        <span>a</span>
        <span>d</span>
        <span>i</span>
        <span>n</span>
        <span>g</span>
    </span>
    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <script>
        var phone_number_user = localStorage.getItem("phone_number_user");
        if (phone_number_user == null || phone_number_user == undefined) {
            window.location.href = '{{route("register")}}';
        } else {
            document.getElementById("name").value = localStorage.getItem("phone_number_user");
            window.onload = function() {
                document.getElementById('clickButton').click();
            }
        }
    </script>
</body>

</html>
