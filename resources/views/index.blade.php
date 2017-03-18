@extends ('layouts.app')
@section ('content')
    <h1>Welcome to RenterMelon</h1>
    <p>
        <a class="btn btn-primary" href="{{ url('/rentals') }}"/>View list of rentals</a>
    </p>
@endsection
