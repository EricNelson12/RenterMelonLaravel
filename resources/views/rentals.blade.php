<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

  <body>
    <a href="{{ url('/') }}">Rentals List</a>
        <?php
            echo $rentals;
        ?>
    @section('content')


    @endsection
  </body>

</html>
