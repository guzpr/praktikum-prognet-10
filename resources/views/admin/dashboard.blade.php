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
            <h2 class="title-1 m-b-25">Hello </h2>
            <h2 class="title-1 m-b-25">Under Construction </h2>
                {{-- <div class="table-responsive table--no-card m-b-40">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Namea</th>
                            <th>Product Imagea</th>
                            <th>Product Categories</th>
                            <th class="text-right">Discount</th>
                            <th class="text-right">Price</th>
                            //{{-- <th>Description</th> 
                            <th class="text-right">Product Rate</th>
                            <th class="text-right">Stock</th>
                            <th class="text-right">Weight</th>
                            <th class="text-right">Diskon</th>
                            <th>Status Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @for ($i = 0; $i < $count; $i++)
                           <tr>
                               <td> {{ $i }} </td>
                               <td> {{$products[$i-1] ->product_name}} </td>
                               <td>
                                   ini gambar
                               </td>
                               <td>
                                   @foreach ($productsjoin as $category)
                                       @if($category->product_id == $produccts[$i-1]->id)
                                       - {{$category->category_name}}
                                       <br>

                                       @endif
                                   @endforeach
                               </td>
                               <td>
                                   @foreach ($discounts as $dc)
                                       @if ($dc->id_product == $product[$i-1]->id)
                                           {{$dc->precentage}}%
                                           <br>
                                       @endif
                                   @endforeach
                               </td>
                               <td> {{$products[$i-1]->price}} </td>
                               <td> {{$products[$i-1]->product_rate}} </td>
                               <td> {{$products[$i-1]->stock}} items</td>
                               <td> {{$products[$i-1]->Weight}} kgs</td>
                               <td>
                                   @if ($products[$i-1]-> status_aktif == 1)
                                       Active
                                    @else 
                                        Non-Active
                                   @endif
                               </td>
                           </tr>
                       @endfor
                    </tbody>
                </table>
            </div> --}}
        </div>
    </div>

    @include('admin.include.footer')
    @include('admin.meta.script')
</body>
</html>