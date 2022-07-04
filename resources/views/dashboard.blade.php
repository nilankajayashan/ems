<!doctype html>
<html lang="en">
@include('../Components/header')
<body class="sb-nav-fixed">
    @include('../Components/top-nav-dashboard')
    <div id="layoutSidenav">
            @if(\Illuminate\Support\Facades\Auth::user()->role == USER)
                @include('../Components/inc/user/user-side-nav')
            @elseif(\Illuminate\Support\Facades\Auth::user()->role == ADMIN)
                @include('../Components/inc/admin/admin-side-nav')
            @endif
            <div id="layoutSidenav_content">
                    <main>
                        @if(\Illuminate\Support\Facades\Auth::user()->role == USER)
                            @switch(Request::get('state'))
                                @case('dashboard')
                                    @include('../Components/body/user/dashboard')
                                    @break
                                @case('profile')
                                    @include('../Components/body/user/profile')
                                    @break
                                @case('leave')
                                    @include('../Components/body/user/leave')
                                    @break
                                @case('change-password')
                                    @include('../Components/body/user/change-password')
                                    @break
                            @endswitch

                        @elseif(\Illuminate\Support\Facades\Auth::user()->role = ADMIN)
                            @switch(Request::get('state'))
                                @case('dashboard')
                                    @include('../Components/body/admin/dashboard')
                                    @break
                                @case('filter_employee')
                                    @include('../Components/body/admin/filter_employee')
                                    @break
                            @endswitch
                        @endif
                    </main>
                @include('../Components/footer')
                </div>
            </div>
</body>
<script src="{{ asset('js/scripts.js')}}" type="text/javascript"></script>
</html>


