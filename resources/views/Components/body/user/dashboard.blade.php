<!-- Confirm Modal-->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Stop Work?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="endwork-form" action="{{ route('end_work') }}" method="POST">
                <div class="modal-footer">
                    @csrf
                    <textarea id="work-note" class="form-control" rows="3" spellcheck="false" placeholder="Enter your today works" required name="tasks"></textarea>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" onclick="validateUserWork()">Stop</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <ol class="breadcrumb mb-4 mt-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    @if(session()->has('message'))
        @if(session()->get('state'))
            <div class='alert alert-success alert-dismissible fade show'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> {{ session()->get('message') }} </div>
        @else
            <div class='alert alert-danger alert-dismissible fade show'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error!</strong> {{ session()->get('message') }} </div>
        @endif
    @endif
    <div class="row pt-5">
        <div class="col-1"></div>
        <a class="col-4 btn btn-success user-large-button" id="startWork"
           @if($start_state)
           href='{{ route('start_work_login') }}'
         @endif
        >
            <h2 class="pt-3 lead">Start Work</h2>
            <h3 class="pt-3 lead" id="startTime">
                @if(isset($start_time)) {{ $start_time }} @endif
            </h3>
        </a>
        <div class="col-2"></div>
        <a class="col-4 btn btn-danger text-center user-large-button" id="endWork"
             @if($end_state)
             onclick="endWork()"
            @endif
        >
            <h2 class="pt-3 lead">End Work</h2>
            <h3 class="pt-3 lead" id="endTime">
                @if(isset($end_time)) {{ $end_time }} @endif
            </h3>
        </a>
        <div class="col-1"></div>
    </div>
    @if(count($task_list) > 0)
        <div class="pt-5">
            <table class="table table-dark table-hover table-bordered" id="tasksTable">
                <thead>
                    <tr>
                        <th class='lead'>Assign Task</th>
                        <th class='lead'>Status (To mark as complete, select the checkbox)</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($task_list as $task)
                    <tr>
                        <td>{{ ucwords($task->task) }}</td>
                        <td>
                            <label class='container'>
                                <input type='checkbox' onclick="setAsComplete('task{{ $loop->index }}')">
                                <span class='checkmark'></span>
                                <span id="task{{ $loop->index }}">Not Complete</span>
                            </label>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script type="text/javascript">
    function endWork(){
        let table = document.getElementById("tasksTable");
        if(typeof(table) != 'undefined' && table != null){
            let count = table.tBodies[0].rows.length;
            let state = true;
            for(let x=0;x < count;x++){
                if(document.getElementById("task"+x).innerText === "Not Complete"){
                    state = false;
                    Notiflix.Notify.failure('Please Complete All the Tasks');
                    break;
                }
            }
            if(state){
                $("#confirmModal").modal();
            }
        }
        else{
            $("#confirmModal").modal();
        }
    }

    function validateUserWork(){
        let inputText = document.getElementById("work-note");
        let todayWork = inputText.value;
        if ((todayWork.length == 0) || (todayWork == 'null')){
            inputText.value = "";
            inputText.setAttribute("placeholder","Please Enter Your Works Before Stop");
            inputText.style.border = "2px solid red";
        }
        else{
            document.getElementById('endwork-form').submit();
        }
    }

    function setAsComplete(id){
        if(document.getElementById(id).innerText === "Not Complete"){
            document.getElementById(id).innerText = "Complete";
        }
        else{
            document.getElementById(id).innerText = "Not Complete";
        }
    }
</script>
