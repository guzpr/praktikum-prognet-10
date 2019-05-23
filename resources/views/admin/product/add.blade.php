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
                <h2 class="title-1 m-b-25">Add New Product</h2>
            </div>
            <div class="card">
                <div class="card-header">
                    <strong>Basic Form</strong> Elements 
                </div>
                <div class="card-body card-block"> 
                    <form action="/admin/product/add" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Product Name</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" placeholder="Product Name" class="form-control" name="product_name">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Product Price</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" placeholder="Product Price" class="form-control" name="price">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Product Weight</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" placeholder="Product Weight" class="form-control" name="weight  ">
                            </div>
                        </div>
                        <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Product Stock</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="text-input" placeholder="Product Stock" class="form-control" name="stock">
                                </div>
                            </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="textarea-input" class=" form-control-label">Product Description</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <textarea id="textarea-input" rows="9" placeholder="Product Description..." class="form-control" name="description"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="multiple-select" class=" form-control-label">Product Category</label>
                            </div>  
                            <div class="col col-md-9">
                                @foreach($category as $cat)
                                    <input type="checkbox" id="category_id" name="category_id[]" value="{{ $cat->id }}" class="form-check-input">{{ $cat->category_name }}
                                    <br>
                                @endforeach
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="file-multiple-input" class=" form-control-label">Multiple File input</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <img id="blah" src="#" />
                                <input type="file" id="file-multiple-input" name="image[]" multiple accept="image/*" class="form-control-file">
                            </div>
                        </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Reset
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>

    @include('admin.include.footer')
    @include('admin.meta.script')
</body>
</html>