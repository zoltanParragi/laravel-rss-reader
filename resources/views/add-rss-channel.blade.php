<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/app.css">
    <title>Add RSS Channel</title>
</head>
<body>
    @include('includes.navbar')
    
    <form class="container mt-5" method="post">
        @csrf
        <div class="row col-4 mx-auto g-3 card card-body shadow">

            @include('includes.messages')

            <h3 class="text-center">Add Channel</h3>
            <div class="col-12">
                <input type="text" name="channel_name" id="channel_name" class="form-control" value='{{ old('channel_name') }}' placeholder="Channel name">
                @error('channel_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12">
                <input type="url" name="url" id="url" class="form-control" placeholder="Url eg.: https://example.com">
                @error('url')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12">
                <button class="btn btn-success">Save</button>
            </div>
        </div>
    </form>

    <script src="/js/app.js"></script>
    
</body>
</html>