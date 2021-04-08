<?php


namespace Tofaha\Helper\Forms;


class BaseForm
{
    private $fields;
    private $action;
    private $method;
    private $options;
    private $btn;
    public function __construct()
    {
        $this->fields = [];
        $this->init();
    }
    protected function init(){}
    protected function setHeader($action,$method,$options = []){
        $this->action = $action;
        $this->method = $method;
        $this->options = $options;
    }
    protected function addString($name,$title,$default = '',$options = []){
        array_push($this->fields,['name'=>$name,'html'=>view('vendor.tofaha.helper.form.fields.string',compact('name','title','default','options'))]);
    }
    protected function addNumber($name,$title,$default = '',$options = []){
        array_push($this->fields,['name'=>$name,'html'=>view('vendor.tofaha.helper.form.fields.number',compact('name','title','default','options'))]);
    }
    protected function addHidden($name,$value){
        array_push($this->fields,['name'=>$name,'html'=>'<input type="hidden" name="'.$name.'" value="'.$value.'">']);
    }

    protected function setFooter($title,$class='btn btn-success'){
        $btn = '<button class="'.$class.'" type="submit">'.$title.'</button>';
    }
    public function all($keys = []){
        $data = [
            'action'        =>  $this->action,
            'method'        =>  $this->method,
            'formOptions'   =>  $this->options,
            'fields'        =>  $this->fields,
            'btn'           =>  $this->btn,
            'keys'          =>  $keys,
        ];
        return view('vendor.tofaha.helper.form.index',$data);
    }
    public function except($keys = []){
        $data = [
            'action'        =>  $this->action,
            'method'        =>  $this->method,
            'formOptions'   =>  $this->options,
            'fields'        =>  $this->fields,
            'btn'           =>  $this->btn,
            'excepted'      =>  true,
            'keys'          =>  $keys,
        ];
        return view('vendor.tofaha.helper.form.index',$data);
    }


}
