@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Reported</div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>User number</th>
                                <th>Ad number</th>
                                <th>Reason</th>
                            </thead>
                            <tbody>
                                @foreach ($reported as $report)
                                    <tr>
                                        <td><?= $report->id ?></td>
                                        <td><a href="/rental/<?=$report->rID?>"><?= $report->rID ?></a></td>
                                        <td><?= $report->reportType ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <p>
                                                <?= $report->description ?>
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
