<?php

namespace App\Models;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Photo extends Eloquent
{
    protected $table='photo';
    protected $fillable=[
        'file_name',
        'img_Md5',
        'line',
        'number'
    ];
    public function rules(){
        return [
          'create'=>[
               'img_Md5'=>'required',
          ] ,
        ];
    }
}
