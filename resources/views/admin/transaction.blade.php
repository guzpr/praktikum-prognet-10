<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.meta.head')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


</head>
<body>
    @include('admin.include.sidebar')
    @include('admin.include.main')

    <admin-transaction-component></admin-transaction-component>
    

    @include('admin.include.footer')
</body>
</html>