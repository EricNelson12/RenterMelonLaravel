@extends ('layouts.app')
@section ('content')

    {{-- TODO: Make miltiple filters work --}}
    <form id="filter" method="post" action="/rentals/filter" >

        {!! csrf_field() !!}
        <h4>Filters</h4>
        <table>
            <tr>
                <th>Smoking:</th>
                <td><input type="checkbox" name="smoke" onchange="this.form.submit()"
                    <?php
                    if (isset($filters['smoke'])) {
                        if ($filters['smoke'] == true) {
                            echo 'checked';
                        }
                    }
                    ?>
                /></td>
            </tr>
            <tr>
                <th>Pets:</th>
                <td><input type="checkbox" name="pets" onchange="this.form.submit()"
                    <?php
                    if (isset($filters['pets'])) {
                        if ($filters['pets'] == true) {
                            echo 'checked';
                        }
                    }
                    ?>
                /></td>
            </tr>
            <tr>
                <th>Furnished:</th>
                <td><input type="checkbox" name="furn" onchange="this.form.submit()"
                    <?php
                    if (isset($filters['furn'])) {
                        if ($filters['furn'] == true) {
                            echo 'checked';
                        }
                    }
                    ?>
                /></td>
            </tr>
            <tr>
                <th>Price:</th>
                <td><input
                    type="range"
                    min="<?=$rentals->minprice?>" max="<?=$rentals->maxprice?>"
                    step="10"
                    name="maxpricewanted"
                    onchange="this.form.submit()"/>
                </td>
            </tr>
            {{--
                <tr>
                <tr>
                <th>Size:</th>
                <td><input type="range"
                min="10" max="2000" step="10"
                name="size"/></td>
            </tr>
                <th>Bedrooms:</th>
                <td>
                    <select name="bedrooms">
                        <option value="1" >1</option>
                        <option value="2" >2</option>
                        <option value="3" >3</option>
                        <option value="4" >4</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Bathrooms:</th>
                <td><select name="bathrooms">
                    <option value="1" >1</option>
                    <option value="2" >2</option>
                    <option value="3" >3</option>
                    <option value="4" >4</option>
                </select></td>
            </tr> --}}
        </table>
        <a id="myBtn" class="btn btn-primary" href="/rentals">Clear</a>
    </form>
    <div id="rentals">
        <table id="maintable">
            <input class="search form-control" id="searchbar" placeholder="Search" />
            <tr>
                <th></th>
                <th></th>
                <th><button class="sort" data-sort="rentalprice">Price</button></th>
                <th>Area</th>
                <th>Address</th>
                <th><button class="sort" data-sort="originalad">Original ad</button></th>
                <th><button class="sort" data-sort="dateadded">Post date</button></th>
                <th>Save Ad</th>
            </tr>
            <tbody class="list">
            <?php
            // this loops through each rental and displays its information in tabular form
            foreach ($rentals as $rental) {
            ?><tr>
                <td>
                <?php
                if (strcmp($rental->img, "no image") != 0)
                	echo "<img src=\"".$rental->img."\" alt=\"rental image\" width=\"120px\">";

                ?>
                </td>
                <td class="rentaltitle"><a href="/rental/<?=$rental->rID?>"><?=$rental->title?></a></td>
                <td class="rentalprice"><?=$rental->price?></td>
                <td class="rentalarea"><?=$rental->area?></td>
                <td><?=$rental->address?></td>
                <td class="originalad"><a href="<?=$rental->link?>"><?php
                // the logic here decides what gets displayed for the link to the original ad
                if (strpos($rental->link, 'craigslist') !== false) {
                    echo 'Craigslist';
                } elseif (strpos($rental->link, 'kijiji') !== false) {
                    echo 'Kijiji';
                } elseif (strpos($rental->link, 'castanet') !== false) {
                    echo 'Castanet';
                } else {
                    echo 'Original';
                }
                ?></a></td>
                <td class="dateadded"><?=$rental->dateAdded;?></td>
                <td class= "saveAd"><a href="/saveAd/<?=$rental->rID?>"><?php if($rental->isSaved){echo 'Saved';}else{echo 'Save Ad';}?> </a></td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>
@endsection
