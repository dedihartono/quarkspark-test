@if(isset($deleted_at))
<label class="label label-danger">
    <a href="javascript:void(0)" style="color:white;" data-toggle="tooltip" data-id="{{ $id }}"
        data-original-title="Status" class="deactive_user">
        Deactive
    </a>
</label>
@else
<label class="label label-success">
    <a href="javascript:void(0)" style="color:white;" data-toggle="tooltip" data-id="{{ $id }}" data-original-title="Status"
        class="active_user">
        Active
    </a>
</label>
@endif
