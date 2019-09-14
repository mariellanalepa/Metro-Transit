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
  <!--
  <script src="{{ asset('js/app.js') }}" defer></script>
  -->
  
  <!-- Styles -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" 
        crossorigin="anonymous">
  
  @yield('css')
  <!--
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  -->
  <style>
    body {
      background-image: url(https://images.unsplash.com/photo-1520105072000-f44fc083e508?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1778&q=80);
      background-size: 110%;
      font-family: 'Nunito', sans-serif !important; 
    }
    
    a, a:hover, a:active {
      color: white;
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
    }
   
    
    .container-fluid {
        height: 100%;
    }
    
    .flex-wrapper {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
        justify-content: space-between
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px;}
    
    .panel {
        margin-top: 20px;
    }
    
    .main-bod {
        padding-top: 20px;
    }
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #9D0D13;
      height: 100%;
      min-height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
      margin-bottom: -15px;
    }
  </style>
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

<div class="container-fluid">    
  <div class="row content">
    <div class="col-sm-10 col-sm-offset-1 hid">
      <div class="row">
        <div class="main-bod col-sm-6 col-sm-offset-3 text-center">
            @include('common.errors')
            @include('common.status')
          <div class="panel">
              <div class="panel-heading"><h3>Employee Login</h3></div>
            <hr>
              <div class="panel-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="userName" class="col-md-4 col-form-label text-md-right">{{ __('User name') }}</label>

                        <div class="col-md-6">
                            <input id="userName" class="form-control{{ $errors->has('userName') ? ' is-invalid' : '' }}" name="userName" value="{{ old('userName') }}" required autofocus>

                            @if ($errors->has('userName'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('userName') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                      <button type="submit" class="btn btn-basic">
                        Login
                      </button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>    
    
<footer class="container-fluid text-center">
  <p>Mariella Nalepa 2019</p>
</footer>
</body>

@yield('js')

</html>

