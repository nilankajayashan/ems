@if(session()->has('status'))
    @if(session()->get('status') == 'success')
        <script>Notiflix.Notify.success("Your request sent to your department head");</script>
    @elseif(session()->get('status') == 'error')
        <script>Notiflix.Notify.failure('Your request does not sent successfully..! please try again');</script>
    @elseif(session()->get('status') =='same_day')
        <script>Notiflix.Notify.warning('You already requested leave for this day..! please meet your department head');</script>
    @endif
@endif
<div class="container-fluid">

    <ol class="breadcrumb mb-4 mt-4">
        <li class="breadcrumb-item active">Leave Request</li>
    </ol>
    <div class="card-block">
        <h4 class="m-b-20 p-b-5 b-b-default f-w-600">Your Leaves</h4>
        <div class="row">
            @if ($oneYearComplete)
                <div class="col-sm-6">
                    <p class="m-b-10 f-w-600">Annual Leave</p>
                    <div class="form-inline">
                        <h6 class="text-muted f-w-400">{{ $leave_count->annual_leaves }} </h6>
                        <a class="btn btn-outline-primary btn-sm ml-3" target="_blank" href="{{ route('leave_table',['leave_type' => 'annual']) }}">View</a>
                    </div>
                </div>
            @endif
            @if ($sixMonthComplete || $oneYearComplete)
                <div class="col-sm-6">
                    <p class="m-b-10 f-w-600">Casual Leave</p>
                    <div class="form-inline">
                        <h6 class="text-muted f-w-400">{{ $leave_count->casual_leaves }}</h6>
                        <a class="btn btn-outline-primary btn-sm ml-3" target="_blank" href="{{ route('leave_table',['leave_type' =>'casual']) }}">View</a>
                    </div>
                </div>
            @endif
            @if ($sixMonthComplete || $oneYearComplete || $insideSixMonth)
                <div class="col-sm-6">
                    <p class="m-b-10 f-w-600">Half Day</p>
                    <div class="form-inline">
                        <h6 class="text-muted f-w-400">{{ $leave_count->half_day_leaves }}</h6>
                        <a class="btn btn-outline-primary btn-sm ml-3" target="_blank" href="{{ route('leave_table',['leave_type' =>'half_day']) }}">View</a>
                    </div>
                </div>
            @endif
            @if ($sixMonthComplete || $oneYearComplete)
                <div class="col-sm-6">
                    <p class="m-b-10 f-w-600">Sick Leave</p>
                    <div class="form-inline">
                        <h6 class="text-muted f-w-400">{{ $leave_count->sick_leaves }}</h6>
                        <a class="btn btn-outline-primary btn-sm ml-3" target="_blank" href="{{ route('leave_table',['leave_type' => 'sick']) }}">View</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h5>Request To Leave</h5>
            <form action="{{ route('request_leave') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Leave Type</label>
                    <select class="form-control" name="leave_type" required onchange="checkLeaveType(this.value)">
                        <option value="none" selected disabled>Select Leave Type</option>

                        @if ($oneYearComplete)
                            <option value='annual_leave'>Annual Leave</option>
                        @endif
                        @if ($oneYearComplete || $sixMonthComplete)
                            <option value='casual_leave'>Casual Leave</option>
                        @endif
                        @if ($oneYearComplete || $sixMonthComplete || $insideSixMonth)
                            <option value='half_day'>Half Day Leave</option>
                        @endif
                        @if ($oneYearComplete || $sixMonthComplete)
                            <option value='sick_leave'>Sick Leave</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label>Reason</label>
                    <textarea class="form-control" rows="3" spellcheck="false" name="reason" required></textarea>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" class="form-control" name="date" required>
                </div>
                <div class="form-group" id="timeOption" style="display: none">
                    <label>Time</label>
                    <input type="time" id="timeInput" class="form-control" name="time">
                </div>
                <button type="submit" name="submit_leave" class="btn btn-primary">Request</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn btn-danger">Reset</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function checkLeaveType(value){
        if (value == 'half_day'){
            document.getElementById("timeOption").style.display = "block";
            document.getElementById("timeInput").setAttribute('required','true');
        }
        else{
            document.getElementById("timeOption").style.display = "none";
            document.getElementById("timeInput").removeAttribute('required');
            document.getElementById("timeInput").value = '';
        }

    }
</script>
