@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Product
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> Product</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    @if(auth()->user()->isAdmin != 1)
                    <button type="button" class="btn btn-primary btn-xs" href="javascript:void(0)"
                        id="create_product">Add
                        Data</button>
                    <button class="btn btn-info btn-xs" id="create_verification">Set Verification Email
                        (Optional)</button>
                    @endif
                </div>
                <div class="box-body table-responsice">
                    <table class="table table-bordered" id="product_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NO</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Note</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<div class="modal fade" id="product_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_header">Add Product</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="product_form">
                    <div class="box-body">
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" required name="name" id="name"
                                placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                @isset($dropdowns)
                                @foreach ($dropdowns as $item)
                                <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" required name="price" id="price"
                                placeholder="Enter Price">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" required name="stock" id="stock"
                                placeholder="Enter Stock">
                        </div>
                        <div class="form-group">
                            <label id="label_status" for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                @isset($status)
                                @foreach ($status as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea class="form-control" placeholder="Enter Note" name="note" id="note" cols="30"
                                rows="10"></textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="button" id="save_button" value="create" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="verification_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_header"></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="verification_form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" value="{{ session('email_session') ?? '' }}"
                                required name="email" id="email" placeholder="Enter email">
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" id="verification_button" value="create"
                                class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let table = $('#product_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'product/json',
        columns: [
            { data: 'id', name: 'id' , 'visible':false},
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'name', name: 'name' },
            { data: 'category', name: 'category' },
            { data: 'price', name: 'price' },
            { data: 'stock', name: 'stock' },
            { data: 'status', name: 'status' },
            { data: 'note', name: 'note' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action_button', orderable: false}
        ]
    });

    $('#create_product').click(function () {
        $('#save_button').val("create_product");
        $('#product_id').val('');
        $('#product_form').trigger("reset");
        $('#modal_header').html("Create Product");
        $('#status').attr('readonly', true).hide();
        $('#label_status').hide();
        $('#product_modal').modal('show');
    });

    $('body').on('click', '.edit_product', function () {
        let product_id = $(this).data('id');
        let isAdmin = "{{ auth()->user()->isAdmin }}";
        $.get('{{ url("product/edit") }}/' + product_id , function (data) {
            $('#modal_header').html("Edit Product");
            $('#save_button').val("edit_product");
            $('#product_modal').modal('show');
            $('#product_id').val(data.id);
            if(isAdmin != 0){
                $('#name').val(data.name).attr('readonly', true);
                $('#category_id').val(data.category_id).attr('readonly', true);
                $('#price').val(data.price).attr('readonly', true);
                $('#stock').val(data.stock).attr('readonly', true);
                $('#label_status').show();
                $('#status').val(data.status).show().attr('readonly', false);
                $('#note').val(data.note).attr('readonly', true);
            }else{
                $('#name').val(data.name);
                $('#category_id').val(data.category_id);
                $('#price').val(data.price);
                $('#stock').val(data.stock);
                $('#label_status').hide();
                $('#status').val(data.status).hide().attr('readonly', true);
                $('#note').val(data.note);
            }
        })
    });

    $('#save_button').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
            data: $('#product_form').serialize(),
            url: "{{ url('product/store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#product_form').trigger("reset");
                $('#product_modal').modal('hide');
                table.draw();
                $('#save_button').html('Submit');
            },
            error: function (data) {
                console.log('Error:', data);
                $('#save_button').html('Submit');
            }
        });
    });

    $('body').on('click', '.delete_product', function () {
        let product_id = $(this).data("id");
        let conf = confirm("Are You sure want to delete !");
        if (conf) {
            $.ajax({
                url: "{{ url('product/delete') }}/"+product_id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });

    $('#create_verification').click(function () {
        $('#verification_button').val("create_verification");
        $('#modal_header').html("Set Verification Email (Optional)");
        $('#verification_modal').modal('show');
    });

    $('#verification_button').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
            data: $('#verification_form').serialize(),
            url: "{{ url('mailsetsession') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                alert(data.success);
                location.reload();
                $('#verification_modal').modal('hide');
                $('#verification_button').html('Submit');
            },
            error: function (data) {
                console.log('Error:', data);
                $('#verification_button').html('Submit');
            }
        });
    });
});
</script>
@endsection
