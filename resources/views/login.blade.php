<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/app.css">
    <title>Login</title>
</head>
<body>
    @include('includes.navbar')
    
    <form class="container mt-5" method="post">
        @csrf
        <div class="row col-4 mx-auto g-3 card card-body shadow">

            @include('includes.messages')

            <h3 class="text-center">Login</h3>
            <div class="col-12">
                <input type="email" name="email" id="email" class="form-control" value='{{ old('email') }}' placeholder="Email">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </div>
            <div class="col-12">
                <button class="btn btn-success">Login</button>
            </div>
            <div>
                Not registered? <a class="link text-decoration-none ms-2" href={{ route('register') }}>Register</a>
            </div>
        </div>
    </form>

    <script src="/js/app.js"></script>
    
</body>
</html>