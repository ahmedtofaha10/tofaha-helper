<form
    action="{{{$action}}}"
    {{$method == 'post' || $method == 'get'?'method="'.$method.'"':'method="post"'}}
    {{$options['files'] ?'enctype="multipart/form-data"':""}}
>
    @csrf
    @if($method != 'post' && $method != 'get')
        @method($method)
    @endif
    <div class="{{$options['formClass'] ?? 'form-body row'}}">
        @isset($excepted)
            @foreach($fields as $field)
                @if(! in_array($field->name,$keys))
                {!! $field->html !!}
                @endif
            @endforeach
        @else
            @foreach($fields as $field)
                @if(count($keys) == 0 || in_array($field->name,$keys))
                    {!! $field->html !!}
                @endif
            @endforeach
        @endisset

    </div>

</form>
