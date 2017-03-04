@extends ('layouts.app')
@section ('content')
    <a href="{{ url('/') }}">Rentals List</a>
        <table>
            <th></th>
            <th></th>
            <th><b>Price</b><a href="{{ url('/rentals/sorted/asc+price') }}">&#9652;</a>
                            <a href="{{ url('/rentals/sorted/desc+price') }}">&#9662;</a></th>
            <th>Description</th>
            <th>Area<a href="{{ url('/rentals/sorted/asc+area') }}">&#9652;</a>
                    <a href="{{ url('/rentals/sorted/desc+area') }}">&#9662;</a></th>
            <th>Address</th>
            <th>Original</th>
            <th>Posted on<a href="{{ url('/rentals/sorted/asc+datedAdded') }}">&#9652;</a>
                    <a href="{{ url('/rentals/sorted/desc+datedAdded') }}">&#9662;</a></th>
        <?php
            foreach ($rentals as $rental) {
                echo '<tr><td></td><td><a href="#">' . $rental->title
                    . '</a></td><td>$' . $rental->price . '</td>'
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
@endsection
