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
                <h2 class="title-1 m-b-25">Set New Discount</h2>
            </div>
            <div class="card">
                <div class="card-header">
                    <strong>Basic Form</strong> Elements 
                </div>
                <div class="card-body card-block"> 
                    <form action="/admin/discounts/add" method="POST" class="form-horizontal">
                        @csrf
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Discount Percentage</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" placeholder="Discount Percentage" class="form-control" name="percentage">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Product Name </label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="id_product" id="id_product" class="form-control">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Start Date</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="date" id="text-input" placeholder="Start Date" class="form-control" name="start">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">End Date</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="date" id="text-input" placeholder="End Date" class="form-control" name="end">
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
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    @include('admin.include.footer')
    @include('admin.meta.script')
</body>
</html>