
  <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="{{ asset('core/css/materialize.min.css') }}" />
      <link rel="stylesheet" href="{{ asset('core/css/initalize.css') }}" />
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>


    <body>
        <!-- Header section -->

        <!-- Main Section -->
        <main>
                @yield('main-content')
        </main>

        <!-- Footer Section -->
        <footer>

        </footer>


      <!--JavaScript at end of body for optimized loading-->
      <script src="{{ asset('core/js/jquery.min.js') }}" defer></script>
      <script src="{{ asset('core/js/materialize.min.js') }}" defer></script>
      <script src="{{ asset('core/js/initalize.js') }}" defer></script>
      @yield('js-files')
    </body>
  </html>
        