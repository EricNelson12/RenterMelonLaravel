<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

  <body>
    <a href="{{ url('/') }}">Rentals List</a>
        <table>
            <th>

            </th>
            <th>
                <b>Price</b>
            </th>
            <th>
                Description
            </th>
            <th>
                Area
            </th>
            <th>
                Address
            </th>
            <th>

            </th>
            <th>
                Posted
            </th>
        <?php
            foreach ($rentals as $rental) {
                echo '<tr><td>' . $rental->title . '</td>'
                    .'<td>' . $rental->description . '</td>'
                    .'<td>' . $rental->area . '</td>'
                    .'<td>' . $rental->address . '</td>'
                    .'<td>' . $rental->link . '</td></tr>';
            }
        ?>
        </table>
    @section('content')


    @endsection
  </body>

</html>
