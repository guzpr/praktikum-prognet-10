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
                <h2 class="title-1 m-b-25">Discount</h2>
                <a class="au-btn au-btn-icon au-btn--blue" href="{{route('admin.discount.add')}}">
                    <i class="zmdi zmdi-plus"></i> add item</button>
                </a>
            </div>
            <div class="table-responsive table--no-card m-b-40">
                    <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Discount</th>
                                    <th>Product Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @for ($i = 1; $i <= sizeof($Discount); $i++)
                                   <tr>
                                       <td> {{ $i }} </td>
                                       <td> {{$Discount[$i-1] ->percentage}} </td>
                                       <td> {{$products[$i-1] ->product_name}} </td>
                                       <td> {{$Discount[$i-1] ->start}} </td>
                                       <td> {{$Discount[$i-1] ->end}} </td>
                                       <td>
                                            <form action="/admin/discounts/{{$Discount[$i-1]->id}}/edit" method="GET">
                                                <button type="submit">
                                                    <i class="fa fa-edit">Edit</i>
                                                </button>
                                            </form>
                                            <form action="/admin/discounts/{{$Discount[$i-1]->id}}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit">
                                                    <i class="fa fa-trash">Delete</i>
                                                </button>
                                            </form>
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