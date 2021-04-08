<?php

namespace Tofaha\Helper;

class Helper
{
    public static function deleteBtn($id,$url,$btnText = 'حذف',$message = '') {
        return view('tofaha.helper.deleteBtn',compact('id','url','btnText','message'));
    }
    public static function upload($name,$default = ''){
        if (request()->hasFile($name)){
            $fileName = time().'.'.request()->$name->extension();
            request()->$name->move(public_path('uploads'), $fileName);
            return $fileName;
        }
        return $default;
    }
}
