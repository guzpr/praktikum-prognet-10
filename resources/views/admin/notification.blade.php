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
            <admin-notification-component></admin-notification-component>
        </div>
    </div>

    @include('admin.include.footer')

</body>
</html>