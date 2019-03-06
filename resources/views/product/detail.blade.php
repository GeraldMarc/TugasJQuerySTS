@extends('layout.main-layout')
@section('title', 'Product Detail')
@section('content')
    <div>
        <table border="1" id="product_detail">
            <thead>
                <tr>
                    <td>Images</td>
                    <td>ID</td>
                    <td>SKU</td>
                    <td>Name</td>
                    <td>Category</td>
                    <td>Description</td>
                    <td>Unit Price</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        function setMainImage(image_id){
            console.log(image_id);
            $.ajax({
                url: '/api/ProductImage/SetMainImage/'+image_id,
                type: 'PUT',
                success: function (product) {
                    alert('Set main image successful');
                    window.location.reload();
                }
            });
        }

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
                            $('#product_detail > tbody').append('<tr>'
                                                                    + '<td class="modalImage">');
                            //LOAD MAIN IMAGE DULUAN
                            $.each(images.data, function(index, image){
                                if(image.main_image == true){
                                    $('#product_detail > tbody').append('<img class="main-image" src="' + image.product_image_url + '">');
                                }
                            });
                            //LOAD SISA IMAGENYA
                            $.each(images.data, function(index, image){
                                if(image.main_image == false){                                
                                    $('#product_detail > tbody').append('<img class="product-image" src="' + image.product_image_url + '" onclick="setMainImage('+image.id+')">');
                                }
                            });
                            $('#product_detail > tbody').append(    '</td>'
                                                                    + '<td>' + item.id + '</td>'
                                                                    + '<td>' + item.sku + '</td>'
                                                                    + '<td>' + item.name + '</td>'
                                                                    + '<td>' + item.category_name + '</td>' 
                                                                    + '<td>' + item.description + '</td>'
                                                                    + '<td>' + item.unit_price + '</td>'
                                                            + '</tr>');
                        }
                    });
                }
            });
        });
    </script>
@endsection