@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between">
                    <span>{{ __('Products') }}</span>
                    <a href="{{route('product.create')}}">Create Product</a>
                </div>
                <div class="card-body col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control">

                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="subcategory_id">Subcategory</label>

                            <select name="subcategory_id" id="subcategory_id" class="form-control">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="title">Title</label>
                            <input id="title" type="text" class="form-control">
                        </div>

                        <div class="col-md-3" style="display: flex; justify-content: center;">
                            <div>
                                <label for="min_price">Min(Tk)</label>
                                <input id="min_price" min="0" value="0" type="number" class="form-control">
                            </div>
                            <div>
                                <label for="max_price">Max(Tk)</label>
                                <input id="max_price" min="0" value="10000" type="number" class="form-control">
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table width="100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Price</th>
                                <th>Thumbnail</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody id="products_table">


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{asset('assets/js/product.js')}}">

</script>
@endsection
