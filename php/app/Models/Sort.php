<?php

namespace App\Models;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Sort extends Eloquent
{

    /**
     * @var string
     * 表名称
     */
    protected $table='sort';
    /**
     * @var array
     * 数据验证，保证数据完整性
     */
    protected  $fillable=[
        'pid',
        'img_path',
        'content',
        'name',
        'num',
        'id_str',
		'type',
        'simg'
		
    ];


    /**
     * @return array
     * 数据验证规则
     */
    public function rules()
    {
        return [
              'create' => [
                'name' => "required|min:2|max:10|unique:".$this->getTable(),
                'pid' => 'required|min:1',
             ],
            'update'=>[
                'name'=>"required|min:2|max:10",
            ]
            ];
    }
    public  function GetSortName(){
        return $this->belongsTo(Attributes::class ,'sort_id');
    }

}
