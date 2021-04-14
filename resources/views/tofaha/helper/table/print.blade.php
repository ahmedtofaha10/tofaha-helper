<style>
    table, th, td {
        border: 1px solid darkblue;
    }
    .portlet{
        direction: rtl;
    }
</style>
<div class="portlet" >
    <div class="portlet-body">
        <table border="1px" style="width: 100%;text-align: center;">
            <thead style="background-color: #0c203a;color: white;" >
            <tr>
                @foreach($columns as $column)
                    <td>{{$column['title']}}</td>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @if(count($data) == 0)
                <tr><td colspan="100">لا يوجد بيانات</td></tr>
            @endif
            @foreach ($data as $item)
                <tr>
                    @foreach($columns as $column => $columnData)
                        <td>{!!( array_key_exists($column,$customs)?$customs[$column]($item) : $item->$column ) ?? $columnData["default"]!!}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    window.print();
</script>
