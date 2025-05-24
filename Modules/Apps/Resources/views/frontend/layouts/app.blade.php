<!DOCTYPE html>
<html lang="{{ locale() }}" dir="{{ is_rtl() }}">

  @include('apps::frontend.layouts._head')

  <body>
      @include('apps::frontend.layouts._header')

      @yield('content')

      @include('apps::frontend.layouts._footer')

      @include('apps::frontend.layouts._jquery')
      @include('apps::frontend.layouts._js')

  </body>

</html>
