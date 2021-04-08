<?php


namespace Tofaha\Helper;


class Table
{
    protected $prefix;
    protected $columns;
    protected $titles;
    protected $data;
    protected $actions;
    protected $customs;
    protected $tableClass;
    public function __construct($prefix = 'table')
    {
        $this->prefix = $prefix;
    }
    public function setPrefix($prefix){
        $this->prefix = $prefix;
        return $this;
    }
    public function setColumns($columns){
        $this->columns = $columns;
        return $this;
    }
    public function setTitles($titles){
        $this->titles = $titles;
        return $this;
    }
    public function setData($data){
        $this->data = $data;
        return $this;
    }
    public function addAction($name,$callback = null){
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
    public function addCustom($name,$callback){
        $this->customs[$name] = $callback;
        return $this;
    }
    public function render($tableClass = "table-bordered table text-center"){
        $this->tableClass = $tableClass;
        $data = [
            'prefix'=>$this->prefix,
            'tableClass'=>$this->tableClass,
            'columns'=>$this->columns,
            'titles'=>$this->titles,
            'data'=>$this->data,
            'actions'=>$this->actions ?? [],
            'customs'=>$this->customs ?? [],
        ];
        return view('vendor.tofaha.helper.table.simple_table',$data);
    }
}
