@extends ('layouts.master')

@section ('content')
    <h1>Register for RenterMelon</h1>
    {!! Form::open(array('action' => 'Auth\RegisterController@show')) !!}
        {!! csrf_field() !!}
        {!! Form::label('username', 'Username') !!}
        {!! Form::text('username') !!}
        <br/>

        {!! Form::label('email', 'Email address') !!}
        {!! Form::email('email') !!}
        <br/>

        {!! Form::label('password', 'Password') !!}
        {!! Form::password('password') !!}
        <br/>

        {!! Form::label('confirm', 'Confirm password') !!}
        {!! Form::password('confirm') !!}
        <br/>

        {!! Form::label('accept', 'I accept the Terms and Conditions')!!}
        {!! Form::checkbox('accept')!!}
        <br/>

        {!! Form::submit('Register') !!}

    {!! Form::close() !!}
@endsection
