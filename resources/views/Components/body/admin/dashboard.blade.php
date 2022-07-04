<div class="container-fluid">
    <ol class="breadcrumb mb-4 mt-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        @if(isset($divisions_user_count))
            @foreach($divisions_user_count as $division)
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body text-white"><b>Siyatha  {{ ucwords(strtolower($division->division)) }} </b>
{{--                        <div class="float-right"> {{ $division->count }}</div>--}}
                        </div>
                        <div class="card-footer text-white">
                            <span class="small stretched-link"><b>User Count</b></span>
                            <div class="small float-right"><b> {{ $division->count }} </b></div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
