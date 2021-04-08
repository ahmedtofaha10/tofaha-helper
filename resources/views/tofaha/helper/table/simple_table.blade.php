<table class="{{$tableClass}}">
    <thead style="background-color: #0c203a;color: white;" >
        <tr>
        @foreach($titles as $title)
            <td>{{$title}}</td>
        @endforeach
        @if(count($actions))
            <td>تحكم</td>
        @endif
        </tr>
    </thead>
    <tbody>
        @if(count($data) == 0)
            <tr><td colspan="100">لا يوجد بيانات</td></tr>
        @endif
        @foreach ($data as $item)
            <tr>
                @foreach($columns as $column)
                    <td>{{array_key_exists($column,$customs)?$customs[$column]($item) : $item->$column}}</td>
                @endforeach
                @if(count($actions))
                    <td>
                        @foreach($actions as $action)
                            @if(is_string( $action ))
                                @include($action)
                            @else
                                {!! $action($item) !!}
                            @endif
                        @endforeach
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
