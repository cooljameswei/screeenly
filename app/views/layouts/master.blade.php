{{-- Include Header (Styles, Meta Tags and more) --}}
@include('layouts.header')

{{-- Include head with navigation and logo --}}
<header>
    @include('layouts.head')
    @include('layouts.appbar')
</header>


    <section id="main-content--wrapper" class="animated fadeIn" role="main">
        @yield('content')
    </section>

{{-- include footer  --}}
@include('layouts.footer')

{{-- include tail (scripts and end tags) --}}
@include('layouts.tail')
