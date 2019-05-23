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
                <h2 class="title-1 m-b-25">Product List</h2>
                <a class="au-btn au-btn-icon au-btn--blue" href=" {{route('admin.add')}} ">
                        <i class="zmdi zmdi-plus"></i> add item</button>
                </a>                        
            </div>
            <div class="table-responsive table--no-card m-b-40">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Namea</th>
                            <th>Product Images</th>
                            <th>Product Categories</th>
                            <th class="text-right">Discount</th>
                            <th class="text-right">Price</th>
                            {{-- <th>Description</th> --}}
                            <th class="text-right">Product Rate</th>
                            <th class="text-right">Stock</th>
                            <th class="text-right">Weight</th>
                            <th>Status Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @for ($i = 1; $i <= sizeof($products); $i++)
                           <tr>
                               <td> {{ $i }} </td>
                               <td> {{$products[$i-1] ->product_name}} </td>
                               <td>
                                   @foreach ($productImages as $images)
                                       @if ($images->products_id == $products[$i-1]->id)
                                            <form action="/admin/product-images/{{$images->id}}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <a href="/{{ $images->image_name }}">
                                                    <img src="/{{ $images->image_name }}" width="70">
                                                </a>
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </form>
                                       @endif
                                   @endforeach
                                   <form action="/admin/product-images/{{$products[$i-1]->id}}" method="POST" class="form" enctype="multipart/form-data">
                                   @csrf
                                   @method("put")
                                   <input type="file"  required name="image[]" id="image" multiple accept="image/*" >
                                       <button type="submit" class="btn btn-success btn-sm">
                                           <i class="fa fa-plus"></i>
                                       </button>
                                   </form>
                               </td>
                               <td>
                                   @foreach ($productsjoin as $category)
                                       @if($category->product_id == $products[$i-1]->id)
                                       - {{$category->category_name}}
                                       <br>

                                       @endif
                                   @endforeach
                               </td>
                               <td>
                                @foreach($discounts as $d)
                                    @if($d->id_product == $products[$i-1]->id)
                                        {{ $d->percentage }}%
                                        <br>
                                    @else 
                                        No Disscount
                                    @endif
                                @endforeach
                               </td>
                               <td> {{$products[$i-1]->price}} </td>
                               <td> {{$products[$i-1]->product_rate}} </td>
                               <td> {{$products[$i-1]->stock}} items</td>
                               <td> {{$products[$i-1]->weight}} kgs</td>
                               <td>
                                   @if ($products[$i-1]-> is_deleted == 0)
                                       Active
                                    @else 
                                        Non-Active
                                   @endif
                               </td>
                               <td>
                                    @if( $products[$i-1]->is_deleted == 1 )
                                    <form action="/admin/product/{{$products[$i-1]->id}}/activate" method="GET">  
                                        <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i> Activate
                                        </button>
                                    </form>
                                    @endif
                                    @if( $products[$i-1]->is_deleted == 0 )
                                        <form action="/admin/product/{{$products[$i-1]->id}}/edit" method="GET">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-edit"></i> Edit
                                            </button>
                                        </form>
                                        <form action="/admin/product/deactivate/{{$products[$i-1]->id}}" method="POST">
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

    @include('admin.include.footer')
    @include('admin.meta.script')
</body>
</html>