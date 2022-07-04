<!doctype html>
<html lang="en">
@include('Components/header')
<body>
<div class="col-12">
    @if($leave_table_name != null )
        <table class="table table-bordered table-dark table-hover">
            <tr>
                <td colspan="@if($leave_table_name == "half day leaves"){{ 4 }}@else{{ 3 }}@endif" class="text-center">
                    <span class="h3">{{ ucwords($leave_table_name) }} Details ({{ ucwords($user_name) }})</span>
                </td>
            </tr>
            <tr>
                <td class="lead">Date</td>
                @if($leave_table_name == "half day leaves")
                    <td class="lead">Time</td>
                @endif
                <td class="lead">Reason</td>
                <td class="lead">State</td>
            </tr>
            @if(count($leave_data) == 0)
                <tr>
                    <td colspan="@if($leave_table_name == "half day leaves"){{ 4 }}@else{{ 3 }}@endif" class="text-center bg-info">{{ __(ucfirst("you have not any"." ".$leave_table_name." yet")) }}</td>
                </tr>
            @else
                    @foreach($leave_data as $row)
                        <tr>
                            <td>{{ $row->leave_date }}</td>
                            @if($leave_table_name == "half day leaves")
                                <td>{{ date('h:i:s A', strtotime($row->leave_time)) }}</td>
                            @endif
                            <td>{{ ucwords($row->reason) }}</td>
                            @if($row->status == PENDING)
                                <td><span class="btn btn-outline-warning btn-sm">&nbsp;Pending&nbsp;</span></td>
                            @elseif($row->status == HEAD_APPROVED || $row->status == HR_APPROVED)
                                <td><span class="btn btn-outline-success btn-sm">Approved</span></td>
                            @elseif($row->status == REJECTED)
                                <td><span class="btn btn-outline-danger btn-sm">Rejected</span></td>
                            @endif
                        </tr>
                    @endforeach

            @endif
        </table>
    @else
        <script>
            Notiflix.Report.warning(
                'Wrong request',
                '"Dear user," <br/><br/> You requested Leave table can not found',
                'okay',
                {{--function back(){--}}
                {{--    <a class="btn btn-warning btn-sm" href="{{ route('profile',['state' => 'profile']) }}">Back</a>--}}
                {{--},--}}

            );
        </script>

    @endif
</div>
</body>
</html>
