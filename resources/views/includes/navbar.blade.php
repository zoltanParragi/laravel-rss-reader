<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href={{ route('welcome') }}>RSS Reader</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href={{ route('welcome') }}>Home</a>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('register') }}>Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('login') }}>Login</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('my-channels') }}>My channels</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('add-rss-channel') }}>Add channel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('profile') }}>My profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('logout') }}>Logout</a>
                    </li>
                @endguest
            </ul>
            
            @auth
            <ul class="d-flex navbar-nav">
                <li class="nav-item text-white">Üdvözlünk {{ auth()->user()->name }}!</li>
            </ul>
            @endauth
        </div>
    </div>
</nav>