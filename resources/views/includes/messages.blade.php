@if (Session::has('errormsg') || Session::has('successmsg'))

    @if (Session::has('errormsg'))
        @php
            $key = 'danger';
        @endphp
    @else
        @php
            $key = 'success';
        @endphp
    @endif

    <div class='alert alert-{{ $key }}'>
        {{ Session::has('errormsg') ? Session::get('errormsg') : Session::get('successmsg') }}
    </div>

@endif