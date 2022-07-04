{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>--}}
{{--<script type="text/javascript">--}}
{{--    $(document).ready(function () {--}}
{{--        $('#search').on('keyup',function() {--}}
{{--            var query = $(this).val();--}}
{{--            $.ajax({--}}
{{--                url:"{{ route('search_employee') }}",--}}
{{--                type:"GET",--}}
{{--                success:function (data) {--}}
{{--                    $('#list').html(data);--}}
{{--                }--}}
{{--            })--}}
{{--        });--}}
{{--    });--}}

{{--</script>--}}

<script>
    var column_list = ['employee_id','first_name','last_name','division','join_date'];
</script>

<!-- Advance Filter Modal -->
<div class="modal fade" id="advanceModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center text-primary float-left">Advance Filter</h4>
                <button type="button" class="btn btn-outline-primary float-right" data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body">
                <p class="lead text-primary">Select Attribute</p>
                <div class="form-row ml-3">
                    <div class="form-group form-inline col-4">
                        <input type="checkbox" class="form-control-sm" id="user_id" checked disabled>
                        <label class="pl-2">ID</label>
                    </div>
                    <div class="form-group form-inline col-4">
                        <input type="checkbox" class="form-control-sm" id="first_name">
                        <label class="pl-2">First Name</label>
                    </div>
                    <div class="form-group form-inline col-4">
                        <input type="checkbox" class="form-control-sm" id="last_name">
                        <label class="pl-2">Last Name</label>
                    </div>
                    <div class="form-group form-inline col-4">
                        <input type="checkbox" class="form-control-sm" id="division">
                        <label class="pl-2">Division</label>
                    </div>
                    <div class="form-group form-inline col-4">
                        <input type="checkbox" class="form-control-sm" id="join_date">
                        <label class="pl-2">Join Date</label>
                    </div>
                    <div class="form-group form-inline col-4">
                        <input type="checkbox" class="form-control-sm" id="email">
                        <label class="pl-2">Email</label>
                    </div>
                </div>
                <hr>
                <div>
                    <p class="lead text-primary">Select Options</p>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <div class="custom-control">
                                <select class="custom-select" id="division-select">
                                    <option selected disabled value="none">Select Division</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->division }}">{{ $division->division }}</option>
                                    @endforeach
                                    <option value="0">Clear</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <form action="{{ route('advance_filter',['state' => 'filter_employee']) }}" method="post" id="advance_form">
                    @csrf
                    <input type="hidden" id="sql" name="sql">
                    <button type="button" class="btn btn-outline-info float-right" onclick="advance_search()">Search</button>
                </form>
                <button type="button" class="btn btn-outline-warning float-right mr-3" id="advance-search-clear">Clear</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <ol class="breadcrumb mb-4 mt-4">
        <li class="breadcrumb-item active">Filter Employee</li>
    </ol>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Employee Data Table
                    <div class="float-right">
                        <a class='btn btn-outline-primary btn-sm' href="{{ route('filter_employee',['state' => 'filter_employee']) }}">
                            <span class='fas fa-sync-alt'></span>
                        </a>
                        <button class='btn btn-outline-primary btn-sm' data-toggle="modal" data-target="#advanceModal">
                            <span class='fa fa-table'></span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between p-3">
                        <div>
                        <div class="d-inline-flex ">
                            <span>Show&nbsp;</span>
                            <select name="num_of_entry" id="num_of_entry" class="form-control align-self-center" onchange="ChangeNumofEntry(this.value)">
                                @if(isset($_COOKIE['row_count']))
                                    <option value="5" @if($_COOKIE['row_count'] == 5) selected @endif>5</option>
                                    <option value="10" @if($_COOKIE['row_count'] == 10) selected @endif>10</option>
                                    <option value="15" @if($_COOKIE['row_count'] == 15) selected @endif>15</option>
                                    <option value="20" @if($_COOKIE['row_count'] == 20) selected @endif>20</option>
                                @else
                                    <option value="5" selected>5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                @endif
                            </select>
                            <span>&nbsp;Entries</span>
                        </div>
                        <div class="btn-group ml-3" role="group" aria-label="Basic outlined example">
                            <button type="button" class="btn btn-outline-primary">PDF</button>
                            <button type="button" class="btn btn-outline-primary">Excel</button>
                            <button type="button" class="btn btn-outline-primary">Print</button>
                            <button type="button" class="btn btn-outline-primary">Copy</button>
                        </div>
                        </div>
                        <form action="{{ route('search_employee',['state' => 'filter_employee']) }}" method="post">
                            @csrf
                            <div class="d-inline-flex">
                                <input id="search-input" type="search"  class="form-control" placeholder="Search" name="search"/>
                                <button id="search-button" type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div id="list"></div>
                    <div class="table-responsive">
{{--                        {{ dd($tbl_header) }}--}}
                        @if(isset($users) && $tbl_header != null)
                            <table class="table table-striped table-dark">
                                <thead>
                                <tr>
                                    @foreach($tbl_header as $header)
                                        <th scope="col">{{ $header }}</th>
                                    @endforeach
                                        <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                   @foreach($users as $user)
                                       <tr>
                                       @foreach($tbl_header as $header)
                                           <th scope="row">{{ $user->$header }}</th>
                                       @endforeach
                                           <td>Action</td>
                                       </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        @else
{{--                            server dala wada nathnam svg eka ain karanna--}}
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </symbol>
                            </svg>
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                <div>
                                    No Any Employees to filter
                                </div>
                            </div>

                        @endif

                    </div>

                </div>
{{--                <div class="d-flex justify-content-between text-dark pr-3 pl-3">--}}
{{--                    <div>Showing {{ $users->firstItem() }} to {{$users->lastItem()}} of {{$users->total()}} entries</div>--}}
{{--                    {{$users->appends(['state' => 'filter_employee',])->onEachSide(5)->links("pagination::bootstrap-4")}}--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>
<script>
    function ChangeNumofEntry(value){
        const d = new Date();
        d.setTime(d.getTime() + (24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = 'row_count' + "=" + value + ";" + expires + ";path=/";
        window.location.assign('http://127.0.0.1:8000/filter_employee?state=filter_employee');
    }
    function advance_search(){
        $('#advanceModal').modal('hide');
        Notiflix.Loading.hourglass();
        let checkbx = ["first_name","last_name","division","join_date","email"];
        let select = "division-select";
        let text = "SELECT user_id,";



        for (let x = 0; x < checkbx.length; x++){
            if (document.getElementById(checkbx[x]).checked){
                text += checkbx[x] + ",";
            }
        }

        text = text.substring(0,text.length-1);
        text += " FROM users WHERE ";

        let whereState = false;
        let e = document.getElementById(select);
        let value = e.options[e.selectedIndex].value;
        if (value != "0" && value != "none"){
            let con = select.split("-");
            text += con[0] + '=' + '\''+ value +'\'' + ' AND ';
            whereState = true;
        }

        if (whereState){
            text = text.substring(0,text.length-5);
        }
        else{
            text = text.substring(0,text.length-7);
        }

        text += " ORDER BY user_id ASC";

        document.getElementById('sql').value = text;
        document.getElementById('advance_form').submit();
        Notiflix.Loading.remove();
    }
</script>
