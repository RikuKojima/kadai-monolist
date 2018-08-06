<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function items() {
        return $this->belongsToMany(Item::class)->withPivot('type')->withTimestamps();
    }
    
    public function want_items() {
        return $this->items()->where('type','want');
    }
    public function have_items() {
        return $this->items()->where('type','have');
    }
    
    //wantしているかどうかの判定
    public function is_wanting($itemIdOrCode) {
        //$itemIdOrCodeが数値ならば
        if (is_numeric($itemIdOrCode)) {
            $item_id_exists = $this->want_items()->where('item_id',$itemIdOrCode)->exists();
            return $item_id_exists;
        }else {
            $item_code_exist = $this->want_items()->where('code',$itemIdOrCode)->exists();
            return $item_code_exist;
        }
    }
    
    public function want($itemId) {
        // 既に Want しているかの確認
        $exist = $this->is_wanting($itemId);

        if ($exist) {
            // 既に Want していれば何もしない
            return false;
        } else {
            // 未 Want であれば Want する
            $this->items()->attach($itemId, ['type' => 'want']);
            return true;
        }
    }
    
    public function dont_want($itemId) {
        
        //wantしているか
        $exist = $this->is_wanting($itemId);
        
        if($exist){
            \DB::delete("DELETE FROM item_user WHERE user_id = ? AND item_id = ? AND type = 'want'", [$this->id, $itemId]);
        }else{
            return false;
        }
    }
    
    public function is_having($itemIdOrCode) {
        if (is_numeric($itemIdOrCode)) {
            //$itemIdOrCodeが数値のとき
            $item_id_exists = $this->have_items()->where('item_id',$itemIdOrCode)->exists();
            return $item_id_exists;
        } else {
            $item_code_exists = $this->have_items()->where('code',$itemIdOrCode)->exists();
            return $item_code_exists;
        }
    }
    
    public function have($itemId) {
        //すでにhaveしているのか
        
        $exists = $this->is_having($itemId);
        
        if ($exists){
            return false;
        }else {
            // attach($hoge,['column' => $value])
            // $hogeがあるデータのカラムに値$valueを挿入する
            //haveがまだならtypeをhaveにする
            $this->items()->attach($itemId,['type' => 'have']);
            return true;
        }
    }
    
    public function dont_have($itemId) {
        //すでにhaveしているのか
        
        $exists = $this->is_having($itemId);
        
        if($exists){
            \DB::delete("DELETE FROM item_user WHERE user_id = ? AND item_id = ? AND type = 'have'", [$this->id, $itemId]);
        }else{
            return false;
        }
    }
}