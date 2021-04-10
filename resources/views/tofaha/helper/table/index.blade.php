<div class="portlet">
    <div class="heading">
        <div class="justify-content-start">
            <div class="form-group col-md-1">
                <form action="" method="get">
                    <select name="pagination" onchange="this.form.submit()" class="form-control">
                        <option {{$pagination == '5' ?"selected":""}} value="5">5</option>
                        <option {{$pagination == '10' ?"selected":""}} value="10">10</option>
                        <option {{$pagination == '20' ?"selected":""}} value="20">20</option>
                        <option {{$pagination == '30' ?"selected":""}} value="30">30</option>
                        <option {{$pagination == '50' ?"selected":""}} value="50">50</option>
                    </select>
                </form>
            </div>
            @if($excel)
                <a href="{{$exportExcelLink}}" class="btn green"><i class="fa fa-file-excel-o"></i></a>
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <table class="{{$tableClass}}">
            <thead style="background-color: #0c203a;color: white;" >
            <tr>
                @foreach($columns as $column)
                    <td>{{$column['title']}}</td>
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
                    @foreach($columns as $column => $columnData)
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
    </div>
    <div class="footer-ul">
        <div class="text-center">
            {!! $data->links() !!}
        </div>
    </div>
</div>

