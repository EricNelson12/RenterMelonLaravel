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
    <div class="panel-body">
        <button id="myBtn" class="btn btn-primary">Report this ad</button>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">
     <!-- Modal content -->
        <div class="modal-content">
           <span class="close">&times;</span>
           <form method="post" action="/rental/">
               <h4>Reason(s)</h4>
               <input type="radio" name="reportType" value="phishing"/>
               <label>Phishing</label><br />
               <input type="radio" name="reportType" value="bot"/>
               <label>Not a real person</label><br />
               <input type="radio" name="reportType" value="inflamatory"/>
               <label>Inflamatory</label><br />
               <h4>Description</h4>
               <textarea name="content"></textarea><br /><br />
               <input type="submit" id="myBtn" class="btn btn-primary" value="Submit report"/>
           </form>
        </div>
    </div>
@endsection
