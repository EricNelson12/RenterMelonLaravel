@extends ('layouts.master')

@section ('content')
    <h1>Register for RenterMelon</h1>
    <form method="post" action="/show">
        {{ csrf_field() }}
        <fieldset>
            <div>
                <label>Username</label>
                <input type="text" name="username" />
            </div>

            <div>
                <label>Email</label>
                <input type="text" name="email" />
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" />
            </div>

            </div>
                <label>Confirm password</label>
                <input type="password" name="confirm" />
            <div>

            <div>
                <label>I accept the <a href="#">Terms and Conditions</a></label>
                <input type="checkbox" name="accept" />
            </div>

            <input type="submit" value="Submit" />
        </fieldset>
    </form>
@endsection
