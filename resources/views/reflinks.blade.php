<!DOCTYPE html>
  <html>
    <!--Import Header-->
    @include('layouts.header')
    <!--Custom Per Page Header-->
    @yield('head')
    <body>
    <!--Import Navbar-->
    @include('link.navbar')
    <!--Import Search Bar-->
    @include('layouts.search')

    <!--Your Content Here -->
    
    @yield('content')
   

    <!--Import Footer-->
    @include('layouts.footer')

    @include('layouts.btmsheet')

    @include('layouts.navbutton')

     <!--Import all JS Usable in All Page-->
     <script type="text/javascript" src="/js/vendor.js"></script>
    <!--Import Initialize Js Components-->
    @include('layouts.jquery')
    @include('layouts.cartAjax')

    <!--Custom JS Here!-->
    {!! Html::script('js/search.js') !!}

    <!--Custom Script On Desired Page -->
    @yield('footer')
    

    </body>
   
    
  </html>
