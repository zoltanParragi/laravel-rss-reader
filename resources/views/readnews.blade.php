<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/app.css">
    <title>News</title>
</head>
<body>
    @include('includes.navbar')
    
    <div class="container pt-5 pb-5">
        
        <div class="row col-10 mx-auto">
            <h5 class="text-center">Channel name:</h5>
            <h1 class="text-center mt-0">{{$channel_name}}</h1>
            
            <div class="d-flex justify-content-end mt-5">
                {{ $newsitems->links() }}
            </div>
        </div>
        
        <div class="row col-10 mx-auto justify-content-between">
            @if (count($newsitems) > 0)

                @foreach ( $newsitems as $newsitem )
                    <div class="col-md-5 card shadow p-0 mt-0 mb-5">
                        <div class="card-header">
                            <h5>{{ $newsitem['title'] }}</h5>
                        </div>
                        <div class="p-4 card-body">
                            <img class="card-img-top mb-3 rounded-bottom" src={{$newsitem['img_url']}} width=250 alt={{ $newsitem['title'] }}>
                            <p>{{$newsitem['description']}}</p>
                            <p><i>Publication date: {{$newsitem['pub_date']}}</i></p>
                            <a href={{$newsitem['link']}} target="_blank">Read more</a>
                        </div>
                    </div>
                @endforeach

                <div class="container d-flex justify-content-around mt-5">
                    {{ $newsitems->links() }}
                </div>
            @else
                <h4 class="col-8 mx-auto text-center">First you have to save the news in this channel on <i class="fw-normal">My Channels</i> page to seem them here.</h4>
            @endif

        </div>
    </form>

    <script src="/js/app.js"></script>
    
</body>
</html>