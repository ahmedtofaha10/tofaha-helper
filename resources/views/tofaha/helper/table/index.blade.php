<div class="portlet">
    <div class="heading">
        <div class=" row p-2">
            <div class="form-group col-md-2">
                <form action="{{url()->current()}}" method="get">
                    @if(request()->has('search')) <input type="hidden" name="search" value="{{request('search')}}"> @endif
                    @if(request()->has('orderBy')) <input type="hidden" name="orderBy" value="{{request('orderBy')}}"><input type="hidden" name="orderAs" value="{{request('orderAs')}}"> @endif
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
            <div class="col-md-1 text-center ">
                @if($excel)
                    <a href="{{url(\Illuminate\Support\Facades\URL::full())}}{{count(request()->all()) ?"&excel=true":"?excel=true"}}" class="  btn green m-1 col-md-12">تصدير اكسل</a>
                @endif
            </div>
            <div class="col-md-1 text-center ">

                @if($print)
                    <a href="{{url(\Illuminate\Support\Facades\URL::full())}}{{count(request()->all()) ?"&print=true":"?print=true"}}" target="_blank" class="  btn blue m-1 col-md-12">طباعة</a>
                @endif
            </div>
            <div class="col-md-5 text-center ">

            </div>
            <div class="float-left col-md-3 text-center">
                <form action="{{url()->current()}}" method="get">
                    @if(request()->has('pagination')) <input type="hidden" name="pagination" value="{{request('pagination')}}"> @endif
                    @if(request()->has('orderBy')) <input type="hidden" name="orderBy" value="{{request('orderBy')}}"><input type="hidden" name="orderAs" value="{{request('orderAs')}}"> @endif
                    <div class="row">
                        <div class="col-md-8">
                            <input class="form-control" value="{{request('search','')}}" placeholder="يمكنك البحث علي اي خانة" name="search">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success col-md-12">بحث</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <table class="{{$tableClass ?? 'table table-bordered'}}">
            <thead style="background-color: #0c203a;color: white;" >
            <tr>
                @foreach($columns as $key => $column)
                    <td >
                        @if(! empty($customs[$key]))
                            {{$column['title']}}
                        @else
                            <a href="?{{request()->has('pagination')?"pagination=".request('pagination')."&":""}}{{request()->has('search')?"search=".request('search')."&":""}}orderBy={{$key}}&orderAs={{request()->has('orderBy') && request('orderAs') == 'asc' ?"desc":"asc"}}" style="color: white;display: block;width: 100%;height: 100%;">
                                {{$column['title']}}
                                @if(request()->has('orderBy') && request('orderBy') == $key)
                                    <i class="fa fa-arrow-up" style="color: {{request('orderAs') == 'asc' ?"rgba(245,245,245,0.25)":"white"}};"></i>
                                    <i class="fa fa-arrow-down" style="color:{{request('orderAs') == 'asc' ?"white":"rgba(245,245,245,0.25)"}};"></i>
                                @else
                                    <i class="fa fa-arrow-up" style="color:rgba(245,245,245,0.25);"></i>
                                    <i class="fa fa-arrow-down" style="color:rgba(245,245,245,0.25);"></i>
                                @endif
                            </a>
                        @endif

                    </td>
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

