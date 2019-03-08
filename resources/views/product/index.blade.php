@extends('layout.main-layout')
@section('title', 'Product Home')
@section('content')
    <div>
        <button onclick="addProduct()">Add New Product</button>
    </div>
    <div>
        <table border="1" id="products_list">
            <thead>
                <tr>
                    <td>Image</td>
                    <td>Name</td>
                    <td>Unit Price</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        function addProduct(){
            window.location.href = '{{url("Product/Add/")}}';
        }

        function editProduct(product_id){
            window.location.href = 'www.youtube.com';
        }

        function deleteProduct(product_id){
            if(confirm('Do you want to delete this product?')){
                $.ajax({
                    url: '/api/Product/Delete/'+product_id,
                    type: 'DELETE',
                    success: function (data) {
                        alert('Removed product successfully');
                        window.location.reload();
                    }
                });
            }
        }

        $(document).ready(function() {
            $.ajax({
                url: '/api/Product/GetAll',
                type: 'GET',
                success: function (data) {
                    $.each(data.data, function (i, item) {
                        $('#products_list > tbody').append('<tr>'
                                                                + '<td><img class="product-image" src="' + item.product_image_url + '"></td>'
                                                                + '<td>'
                                                                    + '<a href="{{url("Product/Detail/")}}/'+ item.id +'">' + item.name + '</a>'
                                                                +'</td>' 
                                                                + '<td>' + item.unit_price + '</td>'
                                                                + '<td>'
                                                                    + '<button onclick="editProduct('+ item.id +')">Edit</button>'
                                                                    + '<button onclick="deleteProduct('+ item.id +')">Remove</button>'
                                                                +'</td>'
                                                        + '</tr>');
                    });
                }
            });
        });
    </script>
@endsection