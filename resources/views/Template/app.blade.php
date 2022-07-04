<!doctype html>
<html lang="en">
    @include('../Components/header')
    <body class="bg-dark">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    @yield('content')
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                @include('../Components/footer')
            </div>
        </div>
    </body>
</html>

