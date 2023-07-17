<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/app.css">
    <title>Register</title>
</head>
<body>
    @include('includes.navbar')

    <form class="container mt-5" method="post">
        @csrf
        <div class="row col-4 mx-auto g-3 card card-body shadow">

            @include('includes.messages')

            <h3 class="text-center">Register</h3>
            <div class="col-12">
                <input type="name" name="name" id="name" class="form-control" value='{{ old('name') }}'
                    placeholder="Your name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12">
                <input type="email" name="email" id="email" class="form-control" value='{{ old('email') }}'
                    placeholder="Your email address">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12">
                <input type="password" name="password" id="password" class="form-control"
                    placeholder="Your password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12">
                <input type="password" name="password_confirmation" id="password" class="form-control"
                    placeholder="Password again">
            </div>
            <div class="col-12">
                <button class="btn btn-success">Send</button>
            </div>
            <div>
                Already registered? <a class="link text-decoration-none ms-2" href={{ route('login') }}>Login</a>
            </div>
        </div>
    </form>

    <script src="/js/app.js"></script>
    
</body>
</html>