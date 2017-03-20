@extends ('layouts.app')
@section ('content')
    <div class="panel-body">
        <h1>Welcome to RenterMelon</h1>
        <p>
            <a class="btn btn-primary" href="{{ url('/rentals') }}"/>View list of rentals</a>
        </p>
    </div>
@endsection
