<!-- base template for web navigation -->
<!-- template modified from https://www.w3schools.com/bootstrap/bootstrap_templates.asp -->
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Metro Transit</title>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- For preventing CSRF attacks - token used in Laravel -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
  
  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
  <script type="text/javascript" src="{{ URL::asset('js/bootstrap-timepicker.min.js') }}"></script>
  <!--
  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
  <script src="{{ asset('js/app.js') }}" defer></script>
  -->
  
  <!-- Styles -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" 
        crossorigin="anonymous">
  <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-timepicker.min.css') }}" />
  

  <style>
    body {
      font-family: 'Nunito', sans-serif !important; 
    }
    
    a {
      color: white;
    }
    
    a:hover {
        color: #9d9d9d;
        text-decoration: none;
    }
    
    .navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:focus, .navbar-inverse .navbar-nav>.active>a:hover {
      padding-top: 18px;
    }
    
    .navbar-inverse .navbar-nav>li>a {
      padding-top: 18px;
    }    
    
     #logo {
        color: white;
        font-size: 25px;
        padding-top: 10px;
        padding-right: 20px;
    }
    
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      height: 100%;
      position: fixed;
      width: 100%;
      height: 55px;
      z-index: 500;
    }
   
    
    .container-fluid {
        height: 100%;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px;}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #9D0D13;
      height: 100%;
      min-height: 100%;
      width: 215px;
      position: fixed;
      margin-top: 55px; 
      z-index: 400;
    }
    
    
    p {
        padding-top: 10px;
    }
    
    /* Add padding to top of main content */
    .col-sm-10.text-left{ 
        padding: 20px;
    }
    
    .col-sm-2{
        padding-left: 0px;
        padding-right: 0px;
    }
    
    main {
        position: relative;
        margin-left: 215px;
        margin-top: 55px;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
      position: fixed;
      width: 100%;
      height: 60px;
    }
  </style>
  
  @yield('css')
  
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
        <div id="logo">
          <span class="fas fa-bus" href="#"></span>
          <a href="{{ route('public') }}"> Metro Transit</a>
        </div>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        @yield('head-nav')
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{ route('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        <li><a href="{{ route('logout') }}" 
          onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                <span class="glyphicon glyphicon-log-out"></span> 
                  Logout
            </a>
        </li>
        <!-- workaround to get logout via post method 
             was added in Laravel 5.3+ to prevent websites from logging you out
        -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
        @yield('side-nav')
    </div>
    <main class="col-sm-10 text-left"> 
        @yield('content')
    </main>
  </div>
</div>
    <!--
<footer class="container-fluid text-center">
  <p>Mariella Nalepa 2019</p>
</footer>
    -->
</body>
  

@yield('js')

</html>

