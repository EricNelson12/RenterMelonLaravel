@extends ('layouts.app')
@section ('content')

    {{-- TODO: Make miltiple filters work --}}

    <div id="mysidenav" class="sidenav">
    <form id="filter" method="post" action="/rentals/filter" >

        {!! csrf_field() !!}
        <h4>Filter</h4>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <table>
            {{-- For each filter we want to evaluate whether the user checked it at all. --}}
            <tr>
                <th>Smoking:</th>
                <td><input type="checkbox" name="smoke" onchange="this.form.submit()"
                    <?php if (isset($filters['smoke']) && $filters['smoke']!== null) {
                        if ($filters['smoke'] == true) {
                            echo 'checked';
                        }
                    } ?> /></td>
            </tr>
            <tr>
                <th>No Smoking:</th>
                <td><input type="checkbox" name="nosmoke" onchange="this.form.submit()"
                    <?php if (isset($filters['nosmoke']) && $filters['nosmoke']!== null) {
                        if ($filters['nosmoke'] == true) {
                            echo 'checked';
                        }
                    } ?> /></td>
                </tr>
            <tr>
                <th>Pets:</th>
                <td><input type="checkbox" name="pets" onchange="this.form.submit()"
                    <?php if (isset($filters['pets']) && $filters['pets']!== null) {
                        if ($filters['pets'] == true) {
                            echo 'checked';
                        }
                    } ?> /></td>
            </tr>
            <tr>
                <th>No Pets:</th>
                <td><input type="checkbox" name="nopets" onchange="this.form.submit()"
                    <?php if (isset($filters['nopets']) && $filters['nopets']!== null) {
                        if ($filters['nopets'] == true) {
                            echo 'checked';
                        }
                    } ?> /></td>
            </tr>
            <tr>
                <th>Furnished:</th>
                <td><input type="checkbox" name="furn" onchange="this.form.submit()"
                    <?php if (isset($filters['furn']) && $filters['furn']!== null) {
                        if ($filters['furn'] == true) {
                            echo 'checked';
                        }
                    }?>/></td>
            </tr>
            <tr>
                <th>Unfurnished:</th>
                <td><input type="checkbox" name="nofurn" onchange="this.form.submit()"
                    <?php if (isset($filters['nofurn']) && $filters['nofurn']!== null) {
                        if ($filters['nofurn'] == true) {
                            echo 'checked';
                        }
                    } ?> /></td>
            </tr>
            <tr>
                <th>Max Price:</th>
                <td><input
                    type="range"
                    min="<?=$minprice - 5?>" max="<?=$maxprice + 5?>"
                    step="1"
                    value="<?php
                    // We want the maxprice selected by the user but only if it's selected
                        if ( isset($filters['maxpricewanted']) ) {
                            echo $filters['maxpricewanted'];
                        } else { echo $maxprice; }
                    ?>"
                    name="maxpricewanted"
                    onchange="this.form.submit()"/></td>
            </tr>

            {{-- <tr>
                <th>Size:</th>
                <td><input type="range"
                min="10" max="2000" step="10"
                name="size"/></td>
            </tr> --}}
            <tr>
                <th>Bedrooms:</th>
                <td><select
                    name="bed"
                    onchange="this.form.submit()">
                <?php for ($i = 1; $i <= $maxbeds; $i++) { ?>
                    <option value="<?= $i ?>"
                        <?php if (isset ($filters['bed']) && $filters['bed'] == $i) echo 'selected'; ?>><?= $i ?>
                    </option>
                <?php } ?>
                </select></td>
            </tr>
            <tr>
                <th>Bathrooms:</th>
                <td><select
                    name="bath"
                    onchange="this.form.submit()">
                <?php for ($i = 1; $i <= $maxbaths; $i++) { ?>
                    <option value="<?= $i ?>"
                        <?php if (isset ($filters['bath']) && $filters['bath'] == $i) echo 'selected'; ?> ><?= $i ?>
                    </option>
                <?php } ?>
                </select></td>
            </tr>
        </table>
        {{-- <input type="submit" id="submit" class="btn btn-primary" name="submit" value="Submit" style="display:none;" /> --}}
        @if (Auth::check())
            <input type="submit" id="save" class="btn btn-primary" name="savefilters" value="Save These Filters" />
        @endif
        <a id="myBtn" class="btn btn-primary" href="/rentals?clearthesefilters=true">Clear</a>
    </form>
    </div>
    


    <div id="rentals">
        <table id="maintable">
            
            <input class="search form-control" id="searchbar" placeholder="Search" />
            <span class="btn btn-primary"  id="filterbtn" onclick="openNav()">Filters</span>
            <tr>
                <th colspan=2 ></th>
                <th class="sort" data-sort="rentalprice">Price</th>
                <th>Area</th>
                <th>Address</th>
                <th class="sort" data-sort="originalad">Original ad</th>
                <th class="sort" data-sort="dateadded">Post date</th>
                <th class="sort" data-sort="isSaved">Saved Ads</th>
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
                <td class= "isSaved">
                <?php

                 if($rental->isSaved){

                 	echo '<a href="/unsaveAd/';
                 	echo $rental->rID;
                 	echo '">';
                 	echo 'Remove Ad';}
                 else{
                 	echo '<a href="/saveAd/';
                 	echo $rental->rID;
                 	echo '">';
                 	echo 'Save Ad';}

                 ?> </a></td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>
@endsection
