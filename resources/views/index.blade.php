@extends ('layouts.app')
@section ('content')
    <div class="panel-body">
        <h1>Welcome to RenterMelon</h1>
        <p>
            <a class="btn btn-primary" href="{{ url('/rentals') }}"/>View list of rentals</a>
        </p>
    </div>
  </div>
  <div id="googleMap" style="width:100%;height:400px;"></div>
  <!-- Scripts -->
  <script>
  function myMap() {

    var mapProp= {
        center:new google.maps.LatLng(49.886301, -119.470693),
        zoom:12,
    };




    var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

    @foreach($rentals as $rental)

    var myLatLng = {lat: <?= $rental->lat ?>, lng: <?= $rental->lng ?>};

    var marker<?=$rental->rID?> = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: "<?= $rental->address ?> $<?= $rental->price ?> <?= $rental->price ?> <?= $rental->description ?> ",
            url: "/rental/<?=$rental->rID?>",
          });

          google.maps.event.addListener(marker<?=$rental->rID?>, 'click', function() {
                window.location.href = marker<?=$rental->rID?>.url;
            });


    @endforeach



  }
  </script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5VuOQYcpsyakc9w43OPVe70v5Llb1mYw&callback=myMap"></script>
@endsection
