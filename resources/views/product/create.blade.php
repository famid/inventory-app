@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><span>Create Your Products</span></div>
                    <div class="card-body">
                        <form id="fupForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="custom-input-label" for="categoryNameList">select your Category:</label>
                                <select name="category_id" id="categoryNameList" class="mdb-select md-form form-control">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group sub-category-div">
                                <label class="custom-input-label" for="subCategoryNameList">select your SubCategory:</label>
                                <select name="subcategory_id" id="subCategoryNameList" class="mdb-select md-form form-control">

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">Title</label>
                                <input id="title" type="text" class="form-control form-control-rounded @error('title')
                            is-invalid
                    @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" required style=color:black;"></textarea>
                                <span class="input-filed-error" id="descriptionError"></span>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input id="price" type="text" class="form-control form-control-rounded @error('price')
                            is-invalid
                    @enderror" name="price" value="{{ old('price') }}" required autocomplete="price" autofocus>

                                @error('price')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="thumbnail">Thumbnail</label>
                                <input id="thumbnail" type="file" class="form-control form-control-rounded @error('thumbnail')
                            is-invalid
                    @enderror" name="thumbnail" value="{{ old('thumbnail') }}" required autocomplete="thumbnail" autofocus>

                                @error('thumbnail')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="form-group pt-4">

                            </div>
                            <button id="save-product-button" type="submit" class="btn btn-outline-success ">
                                Save
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    {{--    <script src="https://cdn.tiny.cloud/1/gyr2lr6m4zfwdc9uvkc5ma6thz24gkrllpovpluic96qprzq/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>--}}

    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    <script src="https://code.jquery.com/"></script>
    <script>

        // ClassicEditor
        //     .create( document.querySelector( '#description' ) )
        //     .then( editor => {
        //         console.log( editor );
        //     } )
        //     .catch( error => {
        //         console.error( error );
        //     } );
        $(document).ready(function () {
            $("#fupForm").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('product.store') }}",
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                }).done(function (response) {
                    console.log(response);
                    if(response.success) {
                        window.location.href = "{{route('home')}}"
                    }
                }).fail(function (error) {
                    console.log(error);
                })

            });


            $(".sub-category-div").hide();
            $("#categoryNameList").on('click', function () {
                let categoryId = $("#categoryNameList").val();
                if (categoryId == null) {
                    $("#save-product-button").alert('click', 'select your Category first');
                } else {
                    let checkCreateOrUpdateSubCategory = "createSubCategory";
                    specificSubCategory(categoryId, checkCreateOrUpdateSubCategory);
                    $(".sub-category-div").show();
                }
            });


            function specificSubCategory(categoryId, checkCreateOrUpdateSubCategory) {
                $.ajax({
                    url: '{{route('subcategory.list')}}',
                    method: 'GET',
                    data: {
                        '_token': '{{csrf_token()}}',
                        'category_id': categoryId
                    }
                }).done(function (response) {
                    console.log(response['data']);
                    injectDynamicSubCategory(response['data'], checkCreateOrUpdateSubCategory);
                }).fail(function (error) {
                    console.log(error);
                });
            }

            function injectDynamicSubCategory(getSubCategory, checkCreateOrUpdateSubCategory) {
                let html = '';
                for (let i = 0; i < getSubCategory.length; i++) {
                    html += '<option value = "' + getSubCategory[i].id + '">' +
                        getSubCategory[i].title +
                        '</option>' +
                        '<hr>';
                }
                if (checkCreateOrUpdateSubCategory === "updateSubCategory") {
                    $('#updateSubCategoryNameList').html(html);
                } else if (checkCreateOrUpdateSubCategory === "createSubCategory") {
                    $('#subCategoryNameList').html(html);
                }
            }

        });
    </script>
@endsection












