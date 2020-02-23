<div id="relation_selector_{{$row->id}}" >
<relation-selector :level="{{$level}}" v-model="value"  resources_url="{{ $options->resources_url }}"></relation-selector>
    @if(isset($options->relation))
        @foreach($options->relation as $key=>$item)
            <input type="hidden" name="{{ $item }}"  :value="value_level_{{$key}}" />
        @endforeach
    @endif
    <input type="hidden" name="{{ $row->field }}"  :value="value_level_{{ $level -1 }}" />
</div>