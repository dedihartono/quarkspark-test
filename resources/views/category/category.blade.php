@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Category
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> Category</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    @if(auth()->user()->isAdmin !== 1)
                    <button type="button" class="btn btn-primary btn-xs" href="javascript:void(0)"
                        id="create_category">Add
                        Data</button>
                    @endif
                </div>
                <div class="box-body">
                    <table class="table table-bordered" id="category_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NO</th>
                                <th>Name</th>
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
<div class="modal fade" id="category_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_header">Add Category</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="category_form">
                    <div class="box-body">
                        <input type="hidden" name="category_id" id="category_id">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" required name="name" id="name"
                                placeholder="Enter name">
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
<script>
    $(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let table = $('#category_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'category/json',
        columns: [
            { data: 'id', name: 'id' , 'visible':false},
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'name', name: 'name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action_button', orderable: false}
        ]
    });

    $('#create_category').click(function () {
        $('#save_button').val("create_category");
        $('#category_id').val('');
        $('#category_form').trigger("reset");
        $('#modal_header').html("Create Category");
        $('#category_modal').modal('show');
    });

    $('body').on('click', '.edit_category', function () {
        let category_id = $(this).data('id');
        $.get('{{ url("category/edit") }}/' + category_id , function (data) {
            $('#modal_header').html("Edit Category");
            $('#save_button').val("edit_category");
            $('#category_modal').modal('show');
            $('#category_id').val(data.id);
            $('#name').val(data.name);
        })
    });

    $('#save_button').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
            data: $('#category_form').serialize(),
            url: "{{ url('category/store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#category_form').trigger("reset");
                $('#category_modal').modal('hide');
                table.draw();
                $('#save_button').html('Submit');
            },
            error: function (data) {
                console.log('Error:', data);
                $('#save_button').html('Submit');
            }
        });
    });

    $('body').on('click', '.delete_category', function () {
        let category_id = $(this).data("id");
        let conf = confirm("Are You sure want to delete !");
        if (conf) {
            $.ajax({
                url: "{{ url('category/delete') }}/"+category_id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });
});
</script>
@endsection
