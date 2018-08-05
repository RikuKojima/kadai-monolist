<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function create() {
        //フォームから送信される検索ワードを取得(Form::text(keyword))
        $keyword = request()->keyword;
        $items = [];
        if ($keyword) {
            $client = new \RakutenRws_Client();
            $client->setApplicationId(env('RAKUTEN_APPLICATION_ID'));
            
            $rws_response = $lient->excecute('IchibaItemSearch', [
                'keyword' => $keyword,
                'imageFlag' => 1,
                'hits' => 20,
                ]);
            
            foreach ($rws_response->getData()['Items'] as $rws_item) {
                $item = new Item();
                $item->code = $rws_item['Item']['itemCode'];
                $item->name = $rws_item['Item']['itemName'];
                $item->url = $rws_item['Item']['itemUrl'];
                $item->image_url = str_replace('?_ex=128x128', '', $rws_item['Item']['mediumImageUrls'][0]['imageUrl']);
                $items[0] = $item;
            }
        }
        return view('item.create', [
            'keyword' =>$keyword,
            'items' =>$items,
            ]);
    }
    
    public function show($id)   {
        $item = Item::find($id);
        $want_users = $item->ant_users;
        
        return view('items.show',[
            'item' => $item,
            'want_users' => $want_users,
            ]);
    }
}
