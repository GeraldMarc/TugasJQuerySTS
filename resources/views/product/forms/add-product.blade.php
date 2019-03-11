@extends('layout.main-layout')
@section('title', 'Add New Product')
@section('content')
    <div>
        <h2>Add New Product</h2>
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
            <div>
                <span>Main Image : </span>
                <input type="file" name="main_product_image" id="main_product_image" required>
            </div>
            <div>
                <span>Additional Product Images (optional) : </span>
                <input type="file" name="product_image_list" id="product_image_list" multiple="multiple" required>
            </div>
            <div>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $('form').submit(function(event){
            event.preventDefault();
            console.log($('#main_product_image'));
            console.log($('#product_image_list')[0].files);

            var name;
            var description;
            var unit_price;
            var product_category_id;
            var main_product_image;
            var product_image_list = new Array();

            name = $('#name').val();
            description = $('#description').val();
            unit_price = $('#unit_price').val();
            product_category_id = $('#product_category_id').val();
            main_product_image = $('#main_product_image')[0].files[0];
            $.each($('#product_image_list')[0].files, function(i, item){
                product_image_list[i] = $('#product_image_list')[0].files[i];
            });
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
            else if(main_product_image == null){
                alert('Main Image must be chosen!');
            }
            else{
                var formData = new FormData();
                formData.append('name', name);
                formData.append('description', description);
                formData.append('unit_price', unit_price);
                formData.append('product_category_id', product_category_id);
                formData.append('main_product_image', main_product_image);
                $.each(product_image_list, function(i, item){
                    formData.append('product_image_list[]', product_image_list[i]);
                });

                $.ajax({
                    url: '/api/Product/Store/',
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false, 
                    contentType: false, 
                    data: formData,
                    success: function (product) {
                        $.ajax({
                            url: '/api/ProductImage/Store/' + product.data.id,
                            type: 'POST',
                            dataType: 'JSON',
                            processData: false, 
                            contentType: false,
                            data: formData,
                            success: function (data) {}  
                        });
                        window.location.replace('{{ url("Product/Home/") }}');
                    }
                });
            }
        });

        $(document).ready(function() {
            
        });
    </script>
@endsection