@extends ('layouts.app')
@section ('content')

    <form id="searchbar" method="GET" href={{ link_to_action('RentalController@showSearched') }}>
        <input type=text name=keywords />
        <input type="submit" value="Search"/>
    </form>
    <table id="maintable">
        <th></th>
        <th></th>
        <th><b>Price</b><a href="{{ url('/rentals/sorted/asc+price') }}">&#9652;</a>
                        <a href="{{ url('/rentals/sorted/desc+price') }}">&#9662;</a></th>
        <th>Area<a href="{{ url('/rentals/sorted/asc+area') }}">&#9652;</a>
                <a href="{{ url('/rentals/sorted/desc+area') }}">&#9662;</a></th>
        <th>Address</th>
        <th>Original</th>
        <th>Posted on<a href="{{ url('/rentals/sorted/asc+dateAdded') }}">&#9652;</a>
                    <a href="{{ url('/rentals/sorted/desc+dateAdded') }}">&#9662;</a></th>
        <?php
            // loop through each rental and display its information in tabular form
            foreach ($rentals as $rental) {
                if ($sorted == true) {
                    // thumbnail would be the first item in each row
                    echo '<tr><td></td><td><a href="../../rentals/rental/';
                } else {
                    echo '<tr><td></td><td><a href="/rentals/rental/';
                }
                echo $rental->rID . '">' . $rental->title
                    .'</a></td><td>$' . $rental->price . '</td>'
                    .'<td>' . $rental->area . '</td>'
                    .'<td>' . $rental->address . '</td>'
                    .'<td><a href="' . $rental->link . '">';
                    if (strpos($rental->link, "craigslist")!== false) {
                      echo "Craigslist";
                    } elseif (strpos($rental->link, "kijiji")!== false) {
                      echo "Kijiji";
                    } elseif (strpos($rental->link, "castanet")!== false) {
                      echo "Castanet";
                    } else {
                      echo "Original";
                    }
                echo '</a></td><td> ' . $rental->dateAdded . ' </td></tr>';
            }
        ?>
        </table>
@endsection
