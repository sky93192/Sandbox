<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_1 extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "user";
    protected $primaryKey = 'userId';
    public $timestamps = false;

    // protected $fillable = [
    //     'userEmail',
    //     'userPassword',
    //     'userNickName',
    //     'userName',
    //     'userCity',
    //     'userGender',
    //     'userBirthday',
    //     'userImg',
        
    // ];

    function cityList() {
        return $this->belongsTo(Citylist::class, 'cityId');
    }

    
   
}
