
  <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="{{ asset('core/css/materialize.min.css') }}" />
      <link rel="stylesheet" href="{{ asset('core/css/initalize.css') }}" />
      @yield('css-files')
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Admin | R-System</title>
    </head>


    <body>
        <!-- Header section -->
        <header>
            <nav>
                <div class="nav-wrapper  light-blue darken-4">
                    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>

                    <ul class="right">
                            <li><a href="sass.html"><i class="material-icons">search</i></a></li>
                            <li><a href="badges.html"><i class="material-icons">view_module</i></a></li>
                            <li><a href="collapsible.html"><i class="material-icons">refresh</i></a></li>

                            <!-- Logout Functionality -->
                            <li>
                            <a href="{{ route('logout') }}" class="waves-effect"  onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">arrow_back</i></a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                            </li>
                    </ul>
                </div>
            </nav>

             <ul id="slide-out" class="sidenav sidenav-fixed ">
                    <li><div class="user-view">
                    <div>
                        <img src="/core/images/logo.png">
                    </div>
                   
                    </div></li>
                    <li><div class="divider"></div></li>
                    <li><a href="#!"><i class="material-icons">add_to_queue</i>Link 1</a></li>
                    <li><a href="#!"><i class="material-icons">all_inclusive</i>Secoond link</a></li>

                    <!-- Logout Functionality -->
                      <li>
                        <a href="{{ route('logout') }}" class="waves-effect"  onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">arrow_back</i>Logout</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    </li>
                </ul>
        </header>


        <!-- Main Section -->
        <main>
            <div class="container">
                @yield('main-content')
            </div>
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
        