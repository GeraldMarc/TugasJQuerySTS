@extends('layout.main-layout')
@section('title', 'Edit Existing Product')
@section('content')
    <div>
        <h2>Edit Existing Product</h2>
    </div>
    <div>
        <form id="form_product" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div>
                <span>Nama : </span>
                <input type="text" name="name" id="name" required>
            </div>
            <div>
                <span>Description : </span>
                <input type="textarea" name="description" id="description" required>
            </div>
            <div>
                    <span>Unit Price : </span>
                    <input type="number" name="unit_price" id="unit_price" required>
            </div>
            <div>
                <span>Category : </span>
                <select name="product_category_id" id="product_category_id">
                    <option value="0">Select Product Category</option>
                    <option value="1">Category 1</option>
                    <option value="2">Category 2</option>
                    <option value="3">Category 3</option>
                    <option value="4">Category 4</option>
                    <option value="5">Category 5</option>
                    <option value="6">Category 6</option>
                    <option value="7">Category 7</option>
                    <option value="8">Category 8</option>
                    <option value="9">Category 9</option>
                    <option value="10">Category 10</option>
                </select>
            </div>
            <div id="main_product_image_div">

            </div>
            <div id="product_image_list_div">
                
            </div>
            <div>
                    <button type="button" onclick="setMainImage()">Set Selected as Main Image</button> 
                    <button type="button" onclick="removeSelectedImages()">Remove Selected Image</button>
            </div>
            <div>
                <input type="file" name="product_image_list" id="product_image_list" multiple="multiple">
                <button type="button" onclick="addImages()">Add Image(s)</button>
            </div>
            <div>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        // UPDATE PRODUCT INFORMATION
        $('form').submit(function(event){
            event.preventDefault();

            var name;
            var description;
            var unit_price;
            var product_category_id;

            name = $('#name').val();
            description = $('#description').val();
            unit_price = $('#unit_price').val();
            product_category_id = $('#product_category_id').val();
            if(name == ""){
                alert('Name must be filled!');
            }
            else if(description == ""){
                alert('Description must be filled!');
            }
            else if(unit_price == null || unit_price == ""){
                alert('Unit Price must be filled!');
            }
            else if(product_category_id == null || product_category_id == 0){
                alert('Product Category must be chosen!');
            }
            else{
                var formData = new FormData();
                formData.append('name', name);
                formData.append('description', description);
                formData.append('unit_price', unit_price);
                formData.append('product_category_id', product_category_id);

                $.ajax({
                    url: '/api/Product/Update/' + {{$id}} + '?_method=PUT',
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false, 
                    contentType: false, 
                    data: formData,
                    success: function (product) {
                        window.location.replace('{{ url("Product/Home/") }}');
                    }
                });
            }
        });

        // ADD SELECTED IMAGE(S)
        function addImages(){
            if($('#product_image_list')[0].files.length == 0){
                alert('Please choose at least 1 file to upload');
            }
            else{
                var product_image_list = new Array();

                $.each($('#product_image_list')[0].files, function(i, item){
                    product_image_list[i] = $('#product_image_list')[0].files[i];
                });

                var formData = new FormData();
                $.each(product_image_list, function(i, item){
                    formData.append('product_image_list[]', product_image_list[i]);
                });
                $.ajax({
                    url: '/api/ProductImage/Store/' + {{$id}},
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false, 
                    contentType: false,
                    data: formData,
                    success: function (data) {
                        alert('Add Image Successful');
                        window.location.reload();
                    }  
                });
            }
        }

        // SETS PRODUCT MAIN IMAGE
        function setMainImage(){
            if($('input[type="checkbox"]:checked').length != 1){
                alert('Please select one image');
            }
            else{
                var image_id = $('input[type="checkbox"]:checked').val();
                $.ajax({
                    url: '/api/ProductImage/SetMainImage/'+image_id,
                    type: 'PUT',
                    success: function (product) {
                        alert('Set main image successful');
                        window.location.reload();
                    }
                });
            }
        }

        // DELETE SELECTED IMAGE(S)
        function removeSelectedImages(){
            if($('#product_image_list')[0].files.length == 0){
                alert('Please choose at least 1 image to remove');
            }
            else{
                $('input[type="checkbox"]:checked').each(function(){
                    var image_id = $(this).val();
                    $.ajax({
                        url: '/api/ProductImage/Delete/'+image_id,
                        type: 'DELETE',
                        success: function (product) {
                            alert('Remove image successful');
                            window.location.reload();
                        }
                    });
                });
            }
        }

        // GENERATE DATA ON PAGE LOAD
        $(document).ready(function() {
            //LOAD DATA DARI PRODUCT
            $.ajax({
                url: '/api/Product/GetByID/'+{{$id}},
                type: 'GET',
                success: function (product) {
                    var item = product.data;

                    //LOAD SEMUA IMAGE DARI PRODUCT
                    $.ajax({
                        url: '/api/ProductImage/GetWithParam/'+item.id,
                        type: 'GET',
                        success: function(images){
                            //LOAD MAIN IMAGE DULUAN
                            $.each(images.data, function(index, image){
                                if(image.main_image == true){
                                    $('#main_product_image_div').append('<img class="main-image" src="' + image.product_image_url + '">');
                                }
                            });
                            //LOAD SISA IMAGENYA
                            $.each(images.data, function(index, image){
                                if(image.main_image == false){                                
                                    $('#product_image_list_div').append('<label class="image-checkbox">'
                                                                            + '<img class="product-image" src="' + image.product_image_url + '"/>'
                                                                            + '<input type="checkbox" name="product_image_list" value="' + image.id + '">'
                                                                            + '<i class="fa fa-check hidden"></i>'
                                                                        + '</label>');
                                }
                            });
                            $('#name').val(item.name);
                            $('#description').val(item.description);
                            $('#unit_price').val(item.unit_price);
                            $('#product_category_id').val(item.product_category_id);
                            $(".image-checkbox").on("click", function (e) {
                                if ($(this).hasClass('image-checkbox-checked')) {
                                    $(this).removeClass('image-checkbox-checked');
                                    $(this).find('input[type="checkbox"]').first().removeAttr("checked");
                                }
                                else {
                                    $(this).addClass('image-checkbox-checked');
                                    $(this).find('input[type="checkbox"]').first().attr("checked", "checked");
                                }
                    
                                e.preventDefault();
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection