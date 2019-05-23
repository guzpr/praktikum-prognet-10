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
                <h2 class="title-1 m-b-25">Edit courier</h2>
            </div>
            <div class="card">
                <div class="card-header">
                    <strong>Basic Form</strong> Elements 
                </div>
                <div class="card-body card-block"> 
                    <form action="/admin/courier/{{ $courier->id }}" method="POST" class="form-horizontal">
                        @csrf
                        @method("PUT")
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Category Name</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" placeholder="Product Name" class="form-control" name="courier" value="{{ $courier->courier }}">
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