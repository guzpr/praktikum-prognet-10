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
            <div class="overview-wrap">
                <h2 class="title-1 m-b-25">Product Categories</h2>
                <a class="au-btn au-btn-icon au-btn--blue" href="/admin/category/create">
                    <i class="zmdi zmdi-plus"></i> add item</button>
                </a>
            </div>
            <div class="table-responsive table--no-card m-b-40">
                    <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Category Name</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th>Active Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @for ($i = 1; $i <= sizeof($categories); $i++)
                                   <tr>
                                       <td> {{ $i }} </td>
                                       <td> {{$categories[$i-1] ->category_name}} </td>
                                       <td> {{$categories[$i-1] ->created_at}} </td>
                                       <td> {{$categories[$i-1] ->updated_at}} </td>
                                       <td> 
                                        @if( $categories[$i-1]->is_deleted == 0 )
                                            Active
                                        @else
                                            Not Active
                                        @endif
                                       </td>
                                       <td>
                                            @if( $categories[$i-1]->is_deleted == 1 )
                                            <form action="/admin/category/{{$categories[$i-1]->id}}/activate" method="GET">  
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-edit"></i> Activate
                                                </button>
                                            </form>
                                            @endif
                                            @if( $categories[$i-1]->is_deleted == 0 )
                                                <form action="/admin/category/{{$categories[$i-1]->id}}/edit" method="GET">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                </form>
                                                <form action="/admin/category/{{$categories[$i-1]->id}}" method="POST">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i> Deactivate
                                                    </button>
                                                </form>
                                            @endif
                                       </td>
                                   </tr>
                               @endfor
                            </tbody>
                        </table>
                     </div>
            </div>
        </div>
    </div>

    @include('admin.include.footer')
    @include('admin.meta.script')
</body>
</html>