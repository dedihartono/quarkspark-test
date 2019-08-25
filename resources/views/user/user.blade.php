@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        User
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> User</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <button type="button" class="btn btn-primary btn-xs" href="javascript:void(0)" id="create_user">Add
                        Data</button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered" id="users_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NO</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th align="center">Status</th>
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
<div class="modal fade" id="user_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_header">Add User</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="user_form">
                    <div class="box-body">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" required name="name" id="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" required name="email" id="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" required name="password" id="password" placeholder="Password">
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

    let table = $('#users_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'user/json',
        columns: [
            { data: 'id', name: 'id' , 'visible':false},
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action_button', orderable: false}
        ]
    });

    $('#create_user').click(function () {
        $('#save_button').val("create_user");
        $('#user_id').val('');
        $('#user_form').trigger("reset");
        $('#modal_header').html("Create User");
        $('#user_modal').modal('show');
    });

    $('body').on('click', '.edit_user', function () {
        var user_id = $(this).data('id');
        $.get('{{ url("user/edit") }}/' + user_id , function (data) {
            $('#modal_header').html("Edit User");
            $('#save_button').val("edit_user");
            $('#user_modal').modal('show');
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
        })
    });

    $('#save_button').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
            data: $('#user_form').serialize(),
            url: "{{ url('user/store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#user_form').trigger("reset");
                $('#user_modal').modal('hide');
                table.draw();
                $('#save_button').html('Submit');
            },
            error: function (data) {
                console.log('Error:', data);
                $('#save_button').html('Submit');
            }
        });
    });

    $('body').on('click', '.delete_user', function () {
        let user_id = $(this).data("id");
        let conf = confirm("Are You sure want to delete !");
        if (conf) {
            $.ajax({
                url: "{{ url('user/delete') }}/"+user_id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });

    $('body').on('click', '.deactive_user', function () {
        let user_id = $(this).data("id");
        let conf = confirm("Are You sure want to active !");
        if (conf) {
            $.ajax({
                url: "{{ url('user/restore') }}/"+user_id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });

    $('body').on('click', '.active_user', function () {
        let user_id = $(this).data("id");
        let conf = confirm("Are You sure want to deactive !");
        if (conf) {
            $.ajax({
                url: "{{ url('user/trashed') }}/"+user_id,
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
