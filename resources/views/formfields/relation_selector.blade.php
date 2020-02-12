{{-- <input type="text"
       class="form-control"
       name="{{ $row->field }}"
       data-name="{{ $row->display_name }}"
       @if($row->required == 1) required @endif
             step="any"
       placeholder="{{ isset($options->placeholder)? old($row->field, $options->placeholder): $row->display_name }}"
       value="@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif" 
/> --}}

<div class="form-group">
    <div class="col-md-4">
        <select class="form-control">
            <option >山东</option>
        </select>
    </div>
    <div class="col-md-4">
        <select class="form-control">
            <option >青岛</option>
        </select>
    </div>
    <div class="col-md-4">
        <select class="form-control">
            <option >李沧区</option>
        </select>
    </div>
</div>