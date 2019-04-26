<?php
use Flaravel\Upload\Fupload;
use Illuminate\Support\Str;



//文件上传
Route::post('upload', function(){
    $file = request()->file;
    $url = Fupload::upload($file,request()->path ?? 'common',$file->getClientOriginalExtension());
    return $url;
})->middleware('auth:api');

//文件删除
Route::post('delete/file', function(){
   $res = Fupload::delete(Str::after(request()->url,config('app.url').'storage/'));
   if($res)
   {
        return 1;
   }else{
        return 0;
   }
})->middleware('auth:api');
