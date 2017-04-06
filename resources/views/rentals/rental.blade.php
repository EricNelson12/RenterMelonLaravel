<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/X-Treme.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img src="http://i67.tinypic.com/110c9w1.jpg" width="50px" style="position:absolute;top:0px;left:0px;">

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'RenterMelon') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @elseif (Auth::user()->isAdmin())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                </ul>
                            </li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="/home" >
                                            Dashboard
                                        </a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>



    <!--
        Image would be placed here in the HTML
        Floating left of the table would probably look cool
    -->
    <table id="rentaldetails" style="float:left; margin-right: 5%;" width="50%">

        <tr>
            <th>Price</th>
            <td><?php

            echo $rental->price;
            echo " ";

            if( abs($rental->guess - $rental->price) < 200){
                echo '<span class="ok">Decent Value!</span>';
            } else if ($rental->guess - $rental->price > 200){
                echo '<span class="good">Inexpensive!</span>';
            } else if ($rental->guess - $rental->price < -200){
                echo '<span class="bad">Expensive!</span>';
            }

            //rentermelon price rating formula top secret tech here yall


            ?></td>
        </tr>
        <tr>
            <th>Area</th>
            <td><?=$rental->area?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?=$rental->address?></td>
        </tr>
        <tr>
            <th>Date added</th>
            <td><?=$rental->dateAdded?></td>
        </tr>
        <tr>
        <td colspan="2" style="text-align: right">
            {{--
        If a logged in user views this page they got the option to report below.
        A modal form will pop up.
    --}}
    @if(Auth::user() !== null)
        <div class="panel-body">
            <button id="myBtn" class="btn btn-primary">Report this ad</button>
        </div>
        <?php
        $_POST['id'] = Auth::user()->getId();
         ?>

        {{-- This is a modal form. I would not recommend changing the CSS for it --}}
        <div id="myModal" class="modal" style="text-align: left;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="post" action="/report">
                {{ csrf_field() }}
                    <input type="hidden" name="rID" value="<?= $rental->rID ?>" />
                    <h4>Reason</h4>
                    <input type="radio" name="reportType" value="Phishing"/>
                    <label>Phishing</label><br />
                    <input type="radio" name="reportType" value="Bot"/>
                    <label>Bot</label><br />
                    <input type="radio" name="reportType" value="Prince"/>
                    <label>Foreign prince</label><br />
                    <input type="radio" name="reportType" value="Other"/>
                    <label>Other scam</label><br />
                    <h4>Description</h4>
                    <textarea name="desc"></textarea><br />
                    <br />
                    {{-- IMPORTANT: WE NEED A PROPER SITE KEY FOR THIS --}}
                    <div class="g-recaptcha" data-sitekey="SITE_KEY_GOES_HERE"></div>
                    <br />
                    <input type="submit" id="myBtn" class="btn btn-primary" value="Submit report"/>
                </form>
            </div>
        </div>




    @endif
        </td>
        </tr>
    </table>
    <?php
        if (strcmp($rental->img, "no image") != 0)
             echo "<img src=\"".$rental->img."\" alt=\"rental image\" width=\"450px\">";
         else
            echo "no image available";

     ?>
    <p id="rentaldesc" style="clear:both;">
        <?=$rental->description?>

    </p>



    @if (Auth::check() && Auth::user()->isAdmin())
        <a class="btn btn-primary" href="/admin/remove/<?= $rental->rID ?>">Remove This Ad</a>
    @endif
  </div>
  <div id="googleMap" style="width:60%;margin:auto;margin-top:5em;height:400px;"></div>
  <!-- Scripts -->
  <script>
  function myMap() {
     var myLatLng = {lat: <?= $rental->lat ?>, lng: <?= $rental->lng ?>};
    var mapProp= {
        center:new google.maps.LatLng(<?= $rental->lat ?>, <?= $rental->lng ?>),
        zoom:14,
    };

    var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
    var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: "<?= $rental->address ?>",
          });

  }
  </script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5VuOQYcpsyakc9w43OPVe70v5Llb1mYw&callback=myMap"></script>
  <script src="{{ asset('js/app.js') }}"></script>
      <script src="{{ url('http://listjs.com/assets/javascripts/list.min.js') }}"></script>
  <script>
      var options = {
          valueNames: [ 'rentaltitle', 'rentalprice', 'rentalarea', 'originalad', 'dateadded','isSaved' ]
      };
      console.log(options);
      var rentalList = new List('rentals', options);
  </script>
  <script src="{{ asset('js/reportform.js') }}"></script>
</body>
</html>
