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
    
    <div class="container pt-5 pb-5">
        @csrf
        <div class="row col-10 mx-auto g-3">

            @include('includes.messages')

            <h3 class="text-center">My Channels</h3>
            @foreach ( Session::get('channels') as $channel )

                <div class="card card-body shadow p-0">
                    <div class="card-header">
                        <h5>{{ $channel['channel_name'] }}</h5>
                    </div>
                    <ul class="list-unstyled ps-3 pe-3 pt-3">
                        <li>Url: {{ $channel['url'] }}</li>
                        <li>Last updated: {{ $channel['updated_at'] }}</li>
                    </ul>
                    <div class="ps-3 pe-3 pb-3">
                        <a 
                            class="btn btn-primary"
                            href={{route('readnews', [ 'id' => $channel['id']])}}
                        >
                            Read the News
                        </a>
                        <a 
                            class="btn btn-success"
                            href={{ route('savenews', [ 'id' => $channel['id']]) }}
                        >
                            Save / Update News
                        </a>
                        
                        <a 
                            class="btn btn-danger" 
                            {{-- href={{url('deletechannel/'.$channel['id'])}} --}}
                            href={{ route('deletechannel', [ 'id' => $channel['id']]) }}
                        >
                            Delete Channel
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </form>

    <script src="/js/app.js"></script>
    
</body>
</html>