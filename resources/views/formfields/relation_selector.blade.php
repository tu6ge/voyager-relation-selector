{{-- <input type="text"
       class="form-control"
       name="{{ $row->field }}"
       data-name="{{ $row->display_name }}"
       @if($row->required == 1) required @endif
             step="any"
       placeholder="{{ isset($options->placeholder)? old($row->field, $options->placeholder): $row->display_name }}"
       value="@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif" 
/> --}}
<div id="relation_selector_{{$row->id}}" >
    <relation-selector :level="3" v-model="value" ></relation-selector>
    <input type="hidden" name="{{ $row->field }}"  :value="value_level_0" />
    @foreach($options->relation as $key=>$item)
        <input type="hidden" name="{{ $item }}"  :value="value_level_{{$key+1}}" />
    @endforeach
</div>

