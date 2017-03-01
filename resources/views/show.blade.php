@extends ('layouts.master')

@section ('content')
    <?php
        $users = DB::select('select * from users');
        foreach ($users as $user) {
            echo $user->username;
        }
    ?>

@endsection
