<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Social Media</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link href="{{ URL::to('css/ap.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/lightbox.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/test.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript">
        /*global $*/
        $( function() {
            $( document ).tooltip();
        } );
    </script>

    @yield('style')

</head>
<body id="app-layout">
    <div class="body_wrapper">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ route('main') }}">
                    <img class="" alt="SocialMedia" src="/images/logo.png">
                </a>
                
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                
                <ul class="nav navbar-nav nav-pills" role="tablist">
                    @if(!Auth::guest())
                        <li role="presentation">
                            <a href="{{ route('main') }}" title="Home"><span class="glyphicon glyphicon-home"></span> Home <span class="badge"></span></a>
                        </li>
                        <li role="presentation">
                            <a href="{{ route('profile',['id' => Auth::user()->id]) }}" title="profile">
                                <img src="{{ Auth::user()->profile->img->link }}" class="img-rounded" alt="{{ Auth::user()->name }}" width="25" height="25">
                                </span> {{ Auth::user()->name }}
                            </a>
                        </li>
                        <li role="presentation">
                            <a title="Messages" tabindex="0" class="btn" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover">
                                <span class="glyphicon glyphicon-envelope"></span><span class="badge"></span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a title="Notification" tabindex="0" class="btn" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover">
                                <span class="glyphicon glyphicon-globe"></span><span class="badge"></span>
                            </a>
                        </li>
                    @endif
                </ul>
                
                @if (!Auth::guest())
                <div class="search col-sm-4">
                    <form action="{{ route('search') }}" method="post" id="search_form" class="navbar-form">
                            <div class="input-group">
                                <input type="text" name="key" class="form-control" id="tags" placeholder="Search by Email Or Name...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Go!</button>
                                </span>
                            </div><!-- /input-group -->
                        
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
                @endif
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right col-sm-2">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img src="{{ Auth::user()->profile->img->link }}" class="img-circle" width="25" height="25">
                                {{ Auth::user()->name }} <span class="badge"></span><span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('set') }}"><i class="glyphicon glyphicon-cog"></i> Settings</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <body>
    
    @yield('content')
    
    <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Post</h4>
              </div>
              <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="post-body">Edit The post</label>
                        <textarea type="textarea" class="form-control" name="post-body" id="post-body" cols="5" rows="5"></textarea>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
              </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script   src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script type="text/javascript" src="{{ URL::to('js/app.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="{{ URL::to('js/lightbox.js') }}"></script>
</div>
</body>
</html>
