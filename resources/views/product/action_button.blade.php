@if(auth()->user()->isAdmin != 1)
<a href="javascript:void(0)" id="edit_product" data-toggle="tooltip" data-id="{{ $id }}" data-original-title="Edit"
    class="edit btn btn-success btn-xs edit_product">
    Edit
</a>
@else
<a href="javascript:void(0)" id="edit_product" data-toggle="tooltip" data-id="{{ $id }}" data-original-title="Edit"
    class="edit btn btn-success btn-xs edit_product">
    Varification
</a>
@endif
@if(auth()->user()->isAdmin != 1)
<a href="javascript:void(0);" id="delete_product" data-toggle="tooltip" data-original-title="Delete" data-id="{{ $id }}"
    class="delete btn btn-danger btn-xs delete_product">
    Delete
</a>
@endif
