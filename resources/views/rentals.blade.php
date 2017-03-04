@extends ('layouts.app')
@section ('content')
    <a href="{{ url('/') }}">Rentals List</a>
        <table>
            <th></th>
            <th></th>
            <th><b>Price</b><a href="{{ url('/rentals/priceasc') }}">up </a><a href="{{ url('/rentals/pricedesc') }}">down</a></th>
            <th>Description</th>
            <th>Area<a href="{{ url('/rentals/locasc') }}">up </a><a href="{{ url('/rentals/locdesc') }}">down</a></th>
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
@endsection
