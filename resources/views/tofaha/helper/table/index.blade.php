@php($req = (request()->has('pagination')?"&pagination=".request('pagination'):"").(request()->has('search')?"&search=".request('search'):"").(request()->has('orderBy')?"&orderBy=".request('orderBy'):"").(request()->has('orderAs')?"&orderAs=".request('orderAs'):""))
<div class="row">
    @foreach($filters as $filter)
        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 col-xs-6" style="margin-bottom: 10px" >
            <div class="dashboard-stat2 bordered"
                 style="
                        background-image: linear-gradient(
                        45deg
                        , #34495e , #428bca);
                        margin: 5px;
                        padding: 10px 12px 10px !important;
                        border-radius: 10px !important;
                       ">
                <a href="?tableFilter={{$filter['name']}}{{$req}}" style="color: #FFF">
                    <div class="display">
                        <div class="number" style="display: flex;justify-content: space-between">
                            <h3 class="" style="margin-top: 0 !important;">
                                <span class="text-white" style="font-size: 30px">{!!  $filter['counter'] !!}</span>
                            </h3>
                            <span style="color: #FFF;font-size: 16px;">{{$filter['title']}}</span>

                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
</div>
<div class="portlet">
    <div class="heading">
        <div class="  p-2" style="display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap">
            <div style="display:flex;flex-grow: 1">
                <div class="form-group ">
                    <form action="{{url()->current()}}" method="get">
                        @if(request()->has('search')) <input type="hidden" name="search" value="{{request('search')}}"> @endif
                        @if(request()->has('orderBy')) <input type="hidden" name="orderBy" value="{{request('orderBy')}}"><input type="hidden" name="orderAs" value="{{request('orderAs')}}"> @endif
                        <div class="row">
                            <b class=" ps-2" style="margin: 5px;">
                                عرض
                            </b>
                            <select  name="pagination" onchange="this.form.submit()" class="form-control col-md-4 mx-2" style="width: 25%">
                                <option {{$pagination == '5' ?"selected":""}} value="5">5</option>
                                <option {{$pagination == '10' ?"selected":""}} value="10">10</option>
                                <option {{$pagination == '20' ?"selected":""}} value="20">20</option>
                                <option {{$pagination == '30' ?"selected":""}} value="30">30</option>
                                <option {{$pagination == '50' ?"selected":""}} value="50">50</option>
                            </select>
                            <b class="col-md-3" style=";margin: 5px;">
                                سجلات
                            </b>
                        </div>
                    </form>
                </div>
                <div class="mx-2 text-center " style="margin-left: 5px">
                    @if($excel)
                        <a href="{{url(\Illuminate\Support\Facades\URL::full())}}{{count(request()->all()) ?"&excel=true":"?excel=true"}}" class="  btn green m-1 col-md-12">تصدير اكسل</a>
                    @endif
                </div>
                <div class="mx-2 text-center ">

                    @if($print)
                        <a href="{{url(\Illuminate\Support\Facades\URL::full())}}{{count(request()->all()) ?"&print=true":"?print=true"}}" target="_blank" class="  btn blue m-1 col-md-12">طباعة</a>
                    @endif
                </div>
            </div>
            <div class=" text-center">
                <form action="{{url()->current()}}" method="get">
                    @if(request()->has('pagination')) <input type="hidden" name="pagination" value="{{request('pagination')}}"> @endif
                    @if(request()->has('orderBy')) <input type="hidden" name="orderBy" value="{{request('orderBy')}}"><input type="hidden" name="orderAs" value="{{request('orderAs')}}"> @endif
                    <div class="" style="display:flex;align-items: center">
                        <div class="" style="margin-left: 5px">
                            <input class="form-control" value="{{request('search','')}}" placeholder="يمكنك البحث علي اي خانة" name="search">
                        </div>
                        <div class="">
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
                            <a href="?{{request()->has('pagination')?"pagination=".request('pagination')."&":""}}{{request()->has('tableFilter')?"tableFilter=".request('tableFilter')."&":""}}{{request()->has('search')?"search=".request('search')."&":""}}orderBy={{$key}}&orderAs={{request()->has('orderBy') && request('orderAs') == 'asc' ?"desc":"asc"}}" style="color: white;display: block;width: 100%;height: 100%;">
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
                    <td class="act-d">تحكم</td>
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
                        <td>{!! $item->$column ?? $columnData["default"]!!}</td>
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
            {!! $data->links('vendor.pagination.bootstrap-4') !!}
        </div>
    </div>
</div>

