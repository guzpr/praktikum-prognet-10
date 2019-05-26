<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.meta.head')
</head>
<body>
    @include('admin.include.sidebar')
    @include('admin.include.main')

    <div class="row">
        <div class="col-md-12" >
            <admin-dashboard-component></admin-dashboard-component>
        </div>
    </div>

    @include('admin.include.footer')

</body>
</html>