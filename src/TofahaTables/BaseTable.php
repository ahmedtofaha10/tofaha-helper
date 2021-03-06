<?php


namespace Tofaha\Helper\TofahaTables;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Tofaha\Helper\Helper;

class BaseTable
{
    protected $prefix;
    protected $columns;
    protected $data;
    protected $actions;
    protected $customs = [];
    protected $filters = [];
    protected $tableClass;
    public $excel = false;
    public $print = false;
    protected $pagination = 10;

    public function __construct($prefix = 'table')
    {
        $this->prefix = $prefix;
        if (request()->has('excel')){
            return $this->exportExcel();
        }
        if (request()->has('print')){
            return $this->printTable();
        }
    }
    protected function init(){}
    protected function query(){return Model::query();}
    protected function setPrefix($prefix){
        $this->prefix = $prefix;
        return $this;
    }
    protected function addAction($name,$callback = null){
        switch ($name){
            case "show":
                $this->actions[$name] = function ($d){
                    return '<a href="'.route($this->prefix.'.show',$d->id).'" class="btn btn-info"><i class="fa fa-eye"></i></a>';
                };
                break;
            case "edit":
                $this->actions[$name] = function ($d){
                    return '<a href="'.route($this->prefix.'.edit',$d->id).'" class="btn btn-primary"><i class="fa fa-edit"></i></a>';
                };
                break;
            case "delete":
                $this->actions[$name] = function ($d){
                    return Helper::deleteBtn($d->id,route($this->prefix.'.destroy',$d->id));
                };
                break;
            default:
                $this->actions[$name] = $callback;
                break;
        }
        return $this;
    }
    protected function addCustom($name,$callback){
        $this->customs[$name] = $callback;
    }
    protected function addColumn($name,$title,$options = [],$default='???? ????????'){
        $this->columns[$name] = ['title'=>$title,'options'=>$options,'default'=>$default];
    }
    public function addFilter($name,$title,$counter,$callback){
        $this->filters[$name] = compact('name','title','counter','callback');
    }
    protected function render(){
        $query = $this->query();
        if (request()->has('tableFilter')){
            if ($this->filters[request('tableFilter')] != null){
                $temp = $this->filters[request('tableFilter')]['callback'];
                $query = $query->where($temp);
            }
        }
        if (request()->has('pagination'))
            $this->pagination = request('pagination');

        $firstTemp = $query->get();
        $items = $firstTemp->map(function (&$item){
            foreach ($this->columns as  $key => $column){
                $item->$key = array_key_exists($key,$this->customs)?$this->customs[$key]($item):$item->$key;
            }
            return $item;
        });


        if (request()->has('search') and request('search')){
            $items = $items->filter(function ($dd){
                foreach($this->columns as $key => $column){
                    $temp = str_contains($dd->$key ?? '',request('search','')) ;
                    if ($temp)
                        return true;
                }
            });

        }



        if (request()->has('orderBy')){
            $items = $this->paginate($items->sortBy(request('orderBy'),request('orderAs')),$this->pagination)->appends(request()->all());
        }else{
            $items = $this->paginate($items,$this->pagination)->appends(request()->all());
        }
        $data = [
            'prefix'=>$this->prefix,
            'tableClass'=>$this->tableClass,
            'columns'=>$this->columns,
            'filters'=>$this->filters,
            'data'=>$items,
            'excel'=>$this->excel,
            'print'=>$this->print,
            'pagination'=>$this->pagination,
            'actions'=>$this->actions ?? [],
            'customs'=>$this->customs ?? [],
        ];
        return view('vendor.tofaha.helper.table.index',$data);
    }
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function all(){
        $this->init();
        return $this->render();
    }
    public function except($keys = []){
        $this->init();
        foreach ($this->columns as $column => $item){
            if (in_array($column,$keys)){
                unset($this->columns[$column]);
            }
        }
        return $this->render();
    }
    public function only($keys = []){
        $this->init();
        foreach ($this->columns as $column => $item){
            if (! in_array($column,$keys)){
                unset($this->columns[$column]);
            }
        }
        return $this->render();
    }
    public function exportExcel(){
        $this->init();
        $temp = [[]];
        foreach($this->columns as $name => $item)
            array_push( $temp[0],$item["title"]);
        $data  =$this->query()->get();
        $data = $data->all();
        foreach($data as $index => &$item){
            foreach($this->customs as $name => $fnc)
                $item->$name = $fnc($item);
            $row = new \stdClass();
            foreach($this->columns as $name => $columnData){
                $row->$name = $item->$name;
            }
            array_push( $temp,$row);
        }

        return \Maatwebsite\Excel\Facades\Excel::download(new ExcelExporter($temp),$this->prefix.'_'.time().'.xlsx');
    }
    public function printTable(){
        $this->init();
        $data  =$this->query()->get();
        $data = $data->all();
        $viewData = [
            'prefix'=>$this->prefix,
            'columns'=>$this->columns,
            'data'=>$data,
            'customs'=>$this->customs ?? [],
        ];
        return view('vendor.tofaha.helper.table.print',$viewData);
    }


}
