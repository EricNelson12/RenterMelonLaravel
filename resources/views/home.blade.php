@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <a id="myBtn" class="btn btn-primary" href="/rentals?clearmyfilters=true">Clear My Filters</a>
                    <a id="myBtn" class="btn btn-primary" href="/history">History</a>
                    <a id="myBtn" class="btn btn-primary" href="/myads">Saved Ads</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
