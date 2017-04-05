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
                    <td><a href="/rental/<?=$rental->number?>"><?= $rental->number ?></a></td>
                    <td><?= $rental->ts ?></td>
                </tr>
                <tr>
                    <td colspan=2>
                        <?= $rental->title ?>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
