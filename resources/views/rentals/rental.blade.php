@extends ('layouts.app')
@section ('content')

    <!--
        Image would be placed here in the HTML
        Floating left of the table would probably look cool
    -->
    <table id="rentaldetails">

        <tr>
            <th>Price</th>
            <td><?=$rental->price?></td>
        </tr>
        <tr>
            <th>Area</th>
            <td><?=$rental->area?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?=$rental->address?></td>
        </tr>
        <tr>
            <th>Date added</th>
            <td><?=$rental->dateAdded?></td>
        </tr>
    </table>
    <p id="rentaldesc">
        <?=$rental->description?>
    </p>

@endsection
