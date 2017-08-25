<?php

namespace App\Models;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Actice extends Eloquent
{
    protected $table = 'actice';
    /**
     * user_id
     * sort_id
     * writer
     * title
     * content
     * 验证数据完整性
     */
    protected $fillable=[
        'user_id',
        'sort_id',
        'writer',
        'title',
        'content',
		'aimg'
    ];

    /**
     * @return array
     * 验证规则
     */
    public function rules(){
        return [
            'create'=>[
                'sort_id'=>'required',
                'writer'=>'required|min:2',
                'title'=>"required|min:5|unique:".$this->getTable(),
                'content'=>'required|min:20',
				'aimg'=>'required'
            ],
            'update'=>[
                'sort_id'=>'required',
                'writer'=>'required|min:2',
                'title'=>"required|min:5",
                'content'=>'required|min:20',
				'aimg'=>'required'
            ]
        ];
    }
}
