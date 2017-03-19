@extends ('layouts.app')
@section ('content')

    {{-- TODO: submit on change with JS? --}}
    
    <div id="rentals">
    <table id="maintable">
        <input class="search form-control" id="searchbar" placeholder="Search" />
        <tr>
            <th></th>
            <th></th>
            <th><button class="sort btn btn-primary" data-sort="rentalprice">Price</button></th>
            <th>Area</th>
            <th>Address</th>
            <th><button class="sort btn btn-primary" data-sort="originalad">Original ad</button></th>
            <th>Posted on</th>
        </tr>
        <tbody class="list">
        <?php
            // this loops through each rental and display its information in tabular form
        foreach ($rentals as $rental) {
            // TODO: put thumbnail in first cell if you can find it :)
        ?>
        <tr>
            <td class="rentalimage"></td>
            <td class="individualrental"><a href="/rental/<?=$rental->rID?>"></a></td>
            <td class="rentalprice"><?=$rental->price?></td>
            <td class="rentalarea"><?=$rental->area?></td>
            <td class="rentaladdress"><?=$rental->address?></td>
            <td class="originalad"><a href="<?=$rental->link?>"><?php
            if (strpos($rental->link, "craigslist") !== false) {
                echo "Craigslist";
            } elseif (strpos($rental->link, "kijiji") !== false) {
                echo "Kijiji";
            } elseif (strpos($rental->link, "castanet") !== false) {
                echo "Castanet";
            } else {
                echo "Original";
            }
        ?></a></td>
            <td class="dateAdded"><?=$rental->dateAdded;?></td>
        </tr>
<?php } ?>
    </tbody>
    </table>
    </div>

    <script src="http://listjs.com/assets/javascripts/list.min.js"></script>
    <script>
        var options = {
            valueNames: [ 'rentalimage', 'individualrental', 'rentalprice', 'rentalarea', 'rentaladdress' , 'originalad', 'dateAdded' ]
        };
        console.log(options);
        var rentalList = new List('rentals', options);
    </script>
@endsection
