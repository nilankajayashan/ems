<div class="container-fluid">
    <ol class="breadcrumb mb-4 mt-4">
        <li class="breadcrumb-item active">Change Password</li>
        @if(session()->has('message'))
            @if(session()->get('state'))
                <script>Notiflix.Notify.success('{{ session()->get('message') }}');</script>
            @else
                <script>Notiflix.Notify.failure('{{ session()->get('message') }}');</script>
            @endif
        @endif
    </ol>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('password_reset') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <label>Re Enter New Password</label>
                    <input type="password" class="form-control" name="re_password" required>
                </div>
                <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn btn-danger">Reset</button>
            </form>
        </div>
    </div>
</div>
