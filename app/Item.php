<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['code', 'name', 'url', 'image_url'];
    //createやupdate8()で入力を受け付ける。ホワイトリスト
    //item_userテーブルと接続
    //中間テーブルがその他の属性を持っている場合、リレーション定義時にwithPivotで指定できる
    public function users() {
        //wantとhave両方のUser一覧を取得する
        return $this->belongsToMany(User::class)->withPivot('type')->withTimestamps();
        
    }
    
    public function want_users() {
        //type=wantのUser一覧を取得する
        return $this->users()->where('type','want');
    }
    
    public function have_users() {
        //type=haveのUser一覧を取得する
        return $this->users()->where('type', 'want');
    }
}
