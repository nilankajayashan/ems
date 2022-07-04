<!-- Modal profileUpdateModal -->
<div class="modal fade" id="profileUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('edit_profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group text-center">
                        <label for="file-input">
                            <img
                                @if($user_data['profile_image'] == null)
                                src="https://img.icons8.com/bubbles/100/000000/user.png"
                                @else
                                src="{{ asset('Profile_Images/'.ucfirst($user_data['division']).'/'.$user_data['profile_image']) }}"
                                @endif
                                class="img-radius" id="imagePreview" style="width: 150px;height: 150px;border: 1px solid black">
                        </label>
                        <input type="file" id="file-input" style="display:none" onchange="previewImage(event)" name="profile_image"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Employee Name" value="{{ ucfirst($user_data['first_name'])." ".ucfirst($user_data['last_name']) }}" name="full_name">
                        <input type="hidden" class="form-control" value="{{ ucfirst($user_data['division']) }}" name="division">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Save Changes"></input>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script>
    var previewImage = function(event) {
        var output = document.getElementById('imagePreview');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };
</script>
{{--end model--}}

<div class="container-fluid m-auto">
    <div class="row">
        <div class="col-12">
            <ol class="breadcrumb mb-4 mt-4">
                <li class="breadcrumb-item active">Profile</li>
            </ol>
            <div class="card user-card-full">
                <div class="row">
                    <div class="col-sm-4 bg-c-lite-green user-profile">
                        <div class="card-block text-center text-white">
                            <div class="m-b-25"> <img
                                   @if($user_data['profile_image'] == null)
                                    src="https://img.icons8.com/bubbles/100/000000/user.png"
                                   @else
                                   src="{{ asset('Profile_Images/'.ucfirst($user_data['division']).'/'.$user_data['profile_image']) }}"
                                   @endif
                                   class="img-radius" alt="User-Profile-Image" style="width: 150px;height: 150px;border: 1px solid black"> </div>
                            <h5 class="f-w-600"> {{ ucfirst($user_data['first_name']) }}&nbsp;{{ ucfirst($user_data['last_name']) }}</h5>
                            <p>Employer</p> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                            <div class="sb-nav-link-icon" data-toggle="modal" data-target="#profileUpdateModal"><i class="fas fa-edit" style="cursor: pointer"></i></div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card-block">
                            <h4 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Employee ID</p>
                                    <h6 class="text-muted f-w-400">
                                        {{ $user_data['user_id'] }}
                                    </h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Division</p>
                                    <h6 class="text-muted f-w-400">
                                        {{ ucfirst($user_data['division']) }}
                                    </h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">First Name</p>
                                    <h6 class="text-muted f-w-400">
                                        {{ ucfirst($user_data['first_name']) }}
                                    </h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Last Name</p>
                                    <h6 class="text-muted f-w-400">
                                        {{ ucfirst($user_data['last_name']) }}
                                    </h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Join Date</p>
                                    <h6 class="text-muted f-w-400">
                                        {{ $user_data['join_date'] }}
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="card-block">
                            <h4 class="m-b-20 p-b-5 b-b-default f-w-600">Leaves</h4>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
