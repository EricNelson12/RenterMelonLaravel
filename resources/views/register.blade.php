@extends ('layouts.master')

@section ('content')
    <h1>Register for RenterMelon</h1>
    <form method="post" action="/register">
        {{ csrf_field() }}
        <fieldset>
            <label>Username</label>
            <input type="text" name="username" />
            <br/>

            <label>Email</label>
            <input type="text" name="email" />
            <br/>

            <label>Password</label>
            <input type="password" name="password" />
            <br/>

            <label>Confirm password</label>
            <input type="password" name="confirm" />
            <br/>

            <label>I accept the <a href="#">Terms and Conditions</a></label>
            <input type="checkbox" name="accept" />
            <br />

            <input type="submit" value="Submit" />
        </fieldset>
    </form>
@endsection
