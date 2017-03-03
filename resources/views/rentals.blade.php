<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

  <body>
    <a href="{{ url('/') }}">Rentals List</a>
        <table>
            <th></th>
            <th></th>
            <th><b>Price</b></th>
            <th>Description</th>
            <th>Area</th>
            <th>Address</th>
            <th>Original</th>
            <th>Posted on</th>
        <?php
            foreach ($rentals as $rental) {
                echo '<tr><td></td><td><a href="#">' . $rental->title
                    . '</a></td><td>' . $rental->price . '</td>'
                    .'<td>' . $rental->description . '</td>'
                    .'<td>' . $rental->area . '</td>'
                    .'<td>' . $rental->address . '</td>'
                    .'<td><a href="'.$rental->link .'">';
                    if (strpos($rental->link, "craigslist")) {
                      echo "On Craigslist";
                    } elseif (strpos($rental->link, "kijiji")) {
                      echo "On Kijiji";
                    } elseif (strpos($rental->link, "castanet")) {
                      echo "On Castanet";
                    } else {
                      echo "Original";
                    }
                echo '</a></td><td> ' . $rental->datedAdded . ' </td></tr>';
            }
        ?>
        </table>
  </body>
</html>
