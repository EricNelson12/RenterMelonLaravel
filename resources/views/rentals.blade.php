@extends ('layouts.app')
@section ('content')

    <form class="form-horizontal" id="searchbar" method="get" action="/rentals?search">
        <div class="form-group">
            <label>Search:</label>
            <input class="form-control" type=text name=search />
        </div>
            <input class="btn btn-primary" type="submit" value="Search"/>
            <a class="btn btn-primary" href="/rentals">Reset</a>
    </form>

    {{-- TODO: submit on change with JS? --}}
    <form id="filter" >
        <table>
            <tr>
                <th>Smoking:</th>
                <td><input type="checkbox" name="smoking"/></td>
            </tr>
            <tr>
                <th>Pets:</th>
                <td><input type="checkbox" name="pets"/></td>
            </tr>
            <tr>
                <th>Size:</th>
                <?php // TODO: use max and min size ?>
                <td><input type="range"
                    {{--  min="1" max="2" step="10" --}}
                    name="size"/></td>
            </tr>
            <tr>
                <th>Price:</th>
                <?php // TODO: use max and min price ?>
                <td><input type="range"
                    {{-- min="100" max="500" step="10" --}}
                    name="size"/></td>
            </tr>
            <tr>
                <th>Bedrooms:</th>
                <td><select>
                    <option value="" >
                        
                </select></td>
            </tr>
            <tr>
                <th>Bathrooms:</th>
                <td><select>
                    <option value="" >
                        
                </select></td>
            </tr>
        </table>
    </form>

    <table id="maintable">
        <tr><th></th>
        <th></th>
        <th><b>Price</b><a href="{{ url('/rentals?sort=price+asc') }}">&#9652;</a>
                        <a href="{{ url('/rentals?sort=price+desc') }}">&#9662;</a></th>
        <th>Area<a href="{{ url('/rentals?sort=area+asc') }}">&#9652;</a>
                <a href="{{ url('/rentals?sort=area+desc') }}">&#9662;</a></th>
        <th>Address</th>
        <th>Original ad</th>
        <th>Posted on<a href="{{ url('/rentals?sort=dateAdded+asc') }}">&#9652;</a>
                    <a href="{{ url('/rentals?sort=dateAdded+desc') }}">&#9662;</a></th></tr>
        <?php
            // this loops through each rental and display its information in tabular form
            foreach ($rentals as $rental) {
                //     // TODO: put thumbnail in first cell if you can find it :)
                    ?> <tr><td></td><td><a href="/rental/<?=$rental->rID?>">
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
