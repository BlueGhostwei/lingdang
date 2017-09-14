<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Site extends Eloquent
{
    protected $table = "site";
	protected $primaryKey='sid';
    protected $fillable = [
        'user_id',
        'consignee',
        'phone',
        'area',
        'street',
		'district',
		'scene',
        'scontent',
        'sdefault'

    ];
    public function rules(){
        return [
            'create'=>[
               // 'uid'=>'required',
			   
                'consignee'=>'required',
                'phone'=>'required|numeric',
                'area'=>'required',
                'street'=>'required',
				'district'=>'required',
				//'scene'=>'required',
                'scontent'=>'required'
            ],
            'update'=>[
               // 'uid'=>'required',
			    
                'consignee'=>'required',
                'phone'=>'required|numeric',
                'area'=>'required',
                'street'=>'required',
				'district'=>'required',
				'sdefault'=>'required',
                'scontent'=>'required'
            ]
        ];
    }



}
