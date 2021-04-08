<div class="{{$options['groupClass'] ?? 'form-group col-md-4'}}">
    <label
        for="field_{{$name}}"
        class="{{$options['labelClass'] ?? 'title'}}"
    >
        {{$title}}
    </label>
    <input
        id="field_{{$name}}"
        type="time" name="{{$name}}"
        {{isset($options['placeholder'])?'placeholder="'.$options['placeholder'].'"':''}}
        {{isset($options['required'])?' required ':''}}
        {{isset($options['readonly'])?' readonly ':''}}
        value="{{old($name,$default ?? '')}}"
        class="{{$options['fieldClass'] ?? 'form-control'}}"
    >
</div>
