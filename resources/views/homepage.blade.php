<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    {{--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">--}}
    <link href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/bootstrap/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/dt-1.10.15/datatables.min.css"/>
    <link href="{{asset('assets/cropper/cropper.min.css')}}" rel="stylesheet" type="text/css">
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.css"/>--}}
    <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">


</head>
<body>
<div class="container">
    <h1>Product Management</h1>

    <div class="table-container">
        <div class="clearfix">
            <a href="#" class="btn btn-primary add-product" data-toggle="modal" data-target="#addProductModal"><span
                        class="glyphicon glyphicon-plus-sign"></span> Add
                Product</a>
        </div>
        <table id="products" class="table table-striped table-bordered dataTable no-footer">
            <thead>
            <tr>
                <th class="text-left">ID</th>
                <th class="text-left">Name</th>
                <th>Actions</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@include('addProductModal')
<div id="editProductModal" class="modal inmodal fade" role="dialog" aria-hidden="true"></div>
@include('viewProductModal')
<script type="text/javascript" src="{{asset('assets/jquery/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/toastr/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/cropper/cropper.min.js')}}"></script>

<script type="text/javascript" src="{{asset('assets/cropper/crop.js')}}"></script>
<script type="text/javascript" src="{{asset('js/script.js')}}"></script>

</body>
</html>
