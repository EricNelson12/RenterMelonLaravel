@extends ('layouts.app')
@section ('content')
    <h1>Welcome to RenterMelon</h1>
    <p>
        <a href="{{ url('/register') }}">Register</a>
        <a href="{{ url('/rentals') }}">Rentals List</a>
    </p>
@endsection
