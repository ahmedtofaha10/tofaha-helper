<div class="portlet">
    <div class="heading">
        <div class="justify-content-start row p-2">
            <div class="form-group col-md-2">
                <form action="{{url()->current()}}" method="get">
                    <div class="row">
                        <b class="col-md-3" style="width: 20%;margin: 5px;">
                            عرض
                        </b>
                        <select  name="pagination" onchange="this.form.submit()" class="form-control col-md-4" style="width: 25%">
                            <option {{$pagination == '5' ?"selected":""}} value="5">5</option>
                            <option {{$pagination == '10' ?"selected":""}} value="10">10</option>
                            <option {{$pagination == '20' ?"selected":""}} value="20">20</option>
                            <option {{$pagination == '30' ?"selected":""}} value="30">30</option>
                            <option {{$pagination == '50' ?"selected":""}} value="50">50</option>
                        </select>
                        <b class="col-md-3" style="width: 20%;margin: 5px;">
                            سجلات
                        </b>
                    </div>
                </form>
            </div>
            @if($excel)
                <a href="{{url(\Illuminate\Support\Facades\URL::full())}}?excel=true" class="btn green m-1 col-md-1">تصدير اكسل</a>
            @endif
            @if($print)
                <a href="{{url(\Illuminate\Support\Facades\URL::full())}}?print=true" target="_blank" class="btn blue m-1 col-md-1">طباعة</a>
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <table class="{{$tableClass ?? 'table table-bordered'}}">
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
                        <td>{!!( array_key_exists($column,$customs)?$customs[$column]($item) : $item->$column ) ?? $columnData["default"]!!}</td>
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

