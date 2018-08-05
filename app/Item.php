<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //item_userテーブルと接続
    //中間テーブルがその他の属性を持っている場合、リレーション定義時にwithPivotで指定できる
    public function users() {
        return $this->belongsToMany(User::class)->withPivot('type')->withTimestamps();
        
    }
    
    public function want_users() {
        return $this->users()->where('type','want');
    }
}
