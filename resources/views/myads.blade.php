@extends('layouts.app')
@section('content')

    <table class="table table-bordered table-striped">
        <thead>
            <th>Ad number</th>
            <th>Last viewed</th>
        </thead>
        <tbody>
            @foreach ($rentals as $rental)
                <tr>
                    <td><?= $rental->number ?></td>
                    <td><?= 1 ?></td>
                </tr>
                <tr>
                    <td colspan=2><a href="/rental/<?=$rental->number?>">
                        <?= $rental->title ?></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
