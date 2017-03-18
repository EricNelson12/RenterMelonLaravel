@extends ('layouts.app')
@section ('content')

    <form class="form-horizontal" id="searchbar" method="get" action="/rentals?search">
        <div class="form-group">
            <label>Search:</label>
            <input class="form-control" type=text name=search />
        </div>
            <input class="btn btn-primary" type="submit" value="Search"/>
    </form>
    <table id="maintable">
        <th></th>
        <th></th>
        <th><b>Price</b><a href="{{ url('/rentals?sort=price+asc') }}">&#9652;</a>
                        <a href="{{ url('/rentals?sort=price+desc') }}">&#9662;</a></th>
        <th>Area<a href="{{ url('/rentals?sort=area+asc') }}">&#9652;</a>
                <a href="{{ url('/rentals?sort=area+desc') }}">&#9662;</a></th>
        <th>Address</th>
        <th>Original</th>
        <th>Posted on<a href="{{ url('/rentals?sort=dateAdded+asc') }}">&#9652;</a>
                    <a href="{{ url('/rentals?sort=dateAdded+desc') }}">&#9662;</a></th>
        <?php
            // this loops through each rental and display its information in tabular form
            foreach ($rentals as $rental) {
                //     // TODO: put thumbnail in first cell if you can find it :)
                    ?> '<tr><td></td><td><a href="/rental/<?=$rental->rID?>">
                <?php

                echo $rental->title
                    .'</a></td><td>$' . $rental->price . '</td>'
                    .'<td>' . $rental->area . '</td>'
                    .'<td>' . $rental->address . '</td>'
                    .'<td><a href="' . $rental->link . '">';
                    if (strpos($rental->link, "craigslist") !== false) {
                      echo "Craigslist";
                    } elseif (strpos($rental->link, "kijiji") !== false) {
                      echo "Kijiji";
                    } elseif (strpos($rental->link, "castanet") !== false) {
                      echo "Castanet";
                    } else {
                      echo "Original";
                    }
                echo '</a></td><td> ' . $rental->dateAdded . ' </td></tr>';
            }
        ?>
        </table>
@endsection
