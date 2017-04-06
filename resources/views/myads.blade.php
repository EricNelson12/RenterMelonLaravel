@extends('layouts.app')
@section('content')

    <table class="table table-bordered table-striped">

        <tbody>
            @foreach ($rentals as $rental)
                <tr>
                    <td><a href="/rental/<?=$rental->number?>">
                        <?= $rental->title ?></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
