@extends ('layouts.app')
@section ('content')

    <!--
        Image would be placed here in the HTML
        Floating left of the table would probably look cool
    -->
    <table id="rentaldetails" style="float:left; margin-right: 5%;" width="50%">

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
    <?php
        if (strcmp($rental->img, "no image") != 0)
             echo "<img src=\"".$rental->img."\" alt=\"rental image\" width=\"450px\">";
         else
            echo "no image available";

     ?>
    <p id="rentaldesc" style="clear:both;">
        <?=$rental->description?>
    </p>


    {{--
        If a logged in user views this page they got the option to report below.
        A modal form will pop up.
    --}}
    @if(Auth::user() !== null)
        <div class="panel-body">
            <button id="myBtn" class="btn btn-primary">Report this ad</button>
        </div>
        <?php
        $_POST['id'] = Auth::user()->getId();
         ?>

        {{-- This is a modal form. I would not recommend changing the CSS for it --}}
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="post" action="/report">
                {{ csrf_field() }}
                    <input type="hidden" name="rID" value="<?= $rental->rID ?>" />
                    <h4>Reason</h4>
                    <input type="radio" name="reportType" value="Phishing"/>
                    <label>Phishing</label><br />
                    <input type="radio" name="reportType" value="Bot"/>
                    <label>Bot</label><br />
                    <input type="radio" name="reportType" value="Prince"/>
                    <label>Foreign prince</label><br />
                    <input type="radio" name="reportType" value="Other"/>
                    <label>Other scam</label><br />
                    <h4>Description</h4>
                    <textarea name="desc"></textarea><br /><br />
                    <input type="submit" id="myBtn" class="btn btn-primary" value="Submit report"/>
                </form>
            </div>
        </div>
    @endif
@endsection
