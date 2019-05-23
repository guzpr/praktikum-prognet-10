<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.meta.head')
</head>
<body>
    @include('admin.include.sidebar')
    @include('admin.include.main')

    <div class="row">
        <div class="col-md-12">
            <h2 class="title-1 m-b-25">Earnings By Items</h2>
                <div class="table-responsive table--no-card m-b-40">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Category Name</th>
                            <th>Date Created</th>
                            <th>Date Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @for ($i = 1; $i <= sizeof($products); $i++)
                           <tr>
                               <td> {{ $i }} </td>
                               <td> {{$productCategories[$i-1] ->category_name}} </td>
                               
                           </tr>
                       @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.include.footer')
    @include('admin.meta.script')
</body>
</html>