@if ($status == 'APPROVE')
    <label class="label label-success">{{ $status }}</label>
@elseif ($status == 'REJECT')
    <label class="label label-danger">{{ $status }}</label>
@else
    <label class="label label-warning">{{ $status }}</label>
@endif
