<?php


namespace Tofaha\Helper\TofahaTables;


use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Excel;
use Tofaha\Helper\Helper;

class BaseTable
{
    protected $prefix;
    protected $columns;
    protected $data;
    protected $actions;
    protected $customs;
    protected $tableClass;
    public function __construct($prefix = 'table')
    {
        $this->prefix = $prefix;
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
        $this->data = array_map(function (&$item) use ($name,$callback){
            $item->$name = $callback($item);
        },$this->data);
    }
    protected function addColumn($name,$title,$options = []){
        $this->columns[$name] = ['title'=>$title,'options'=>$options];
    }
    protected function render(){
        $data = [
            'prefix'=>$this->prefix,
            'tableClass'=>$this->tableClass,
            'columns'=>$this->columns,
            'data'=>$this->data,
            'actions'=>$this->actions ?? [],
            'customs'=>$this->customs ?? [],
        ];
        return view('vendor.tofaha.helper.table.index',$data);
    }
    public function all(){
        $this->init();
        $this->data = $this->query()->paginate(10);
        return $this->render();
    }
    public function except($keys = []){
        $this->init();
        foreach ($this->columns as $column => $item){
            if (in_array($column,$keys)){
                unset($this->columns[$column]);
            }
        }
        $this->data = $this->query()->paginate(10);
        return $this->render();
    }
    public function only($keys = []){
        $this->init();
        foreach ($this->columns as $column => $item){
            if (! in_array($column,$keys)){
                unset($this->columns[$column]);
            }
        }
        $this->data = $this->query()->paginate(10);
        return $this->render();
    }
    public function exportExcel(){
        return \Maatwebsite\Excel\Facades\Excel::download(new ExcelExporter($this->data),$this->prefix.'_'.time().'.xlsx');
    }


}
