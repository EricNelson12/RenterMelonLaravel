@extends ('layouts.app')
@section ('content')

    <!--
        Image would be placed here in the HTML
        Floating left of the table would probably look best
    -->
    <table id="rentaldetails">
        <?php
            // I know this does not seem like it should be a loop.
            // However, it works ;)
            foreach ($rental as $rent) {
                echo
                '<tr><th>Price</th>
                    <td>' . $rent->price . '</td></tr>
                <tr><th>Area</th>
                    <td>' . $rent->area . '</td></tr>
                <tr><th>Address</th>
                    <td>' . $rent->address . '</td></tr>
                <tr><th>Date added</th>
                    <td>' . $rent->datedAdded . '</td></tr></table>';
                echo
                    "<p id=\"rentaldesc\">$rent->description</p>";
            }
        ?>


@endsection
