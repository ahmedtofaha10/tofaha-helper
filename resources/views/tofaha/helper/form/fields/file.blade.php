<div class="{{$options['groupClass'] ?? 'form-group col-md-4'}}">
    <label
        for="field_{{$name}}"
        class="{{$options['labelClass'] ?? 'title'}}"
    >
        {{$title}}
    </label>
    <input
        id="field_{{$name}}"
        type="file" name="{{$name}}"
        {{isset($options['placeholder'])?'placeholder="'.$options['placeholder'].'"':''}}
        {{isset($options['required'])?' required ':''}}
        class="{{$options['fieldClass'] ?? 'form-control'}}"
    >
</div>
