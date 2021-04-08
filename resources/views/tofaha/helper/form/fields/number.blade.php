<div class="{{$options['groupClass'] ?? 'form-group col-md-4'}}">
    <label
        for="field_{{$name}}"
        class="{{$options['labelClass'] ?? 'title}}"
    >
        {{$title}}
    </label>
    <input
        id="field_{{$name}}"
        type="number" name="{{$name}}"
        {{isset($options['placeholder'])?'placeholder="'.$options['placeholder'].'"':''}}
        {{isset($options['min'])?'min="'.$options['min'].'"':''}}
        {{isset($options['max'])?'min="'.$options['max'].'"':''}}
        {{isset($options['required'])?'required=':''}}
        value="{{old($name,$default ?? '')}}"
        class="{{$options['fieldClass'] ?? 'form-control'}}"
    >
</div>
