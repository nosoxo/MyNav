<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Category;

class IndexController extends Controller
{
    /**
     * 导航页
     * @return mixed
     */
    public function nav()
    {
        if (session()->get('LOGIN_ADMIN') == 'admin') {
            $categories = Category::orderBy('sort')->get();
        } else {
            $categories = Category::where('flag', 0)->orderBy('sort')->get();
        }
        foreach ($categories as $key => $category) {
            $categories[$key]->links = Link::where('category_id', $category->id)->get();
        }
        //        $links = Link::all();


        //        dump($categories);
        //        echo($links);
        return view('index', ['categories' => $categories]);
    }

    /**
     * 跳转的网址
     * @param $id
     * @return mixed
     */
    public function url($id)
    {
        $link = Link::find($id);
        $link->increment('click');
        $link->save();
        return redirect($link->url);
    }

    /**
     * 获取测试数据
     */
    public function seeder()
    {
        $links = Link::all();
        $categories = Category::all();
        echo (str_replace("\\/", "/", json_encode($links, JSON_UNESCAPED_UNICODE)));
        echo (str_replace("\\/", "/", json_encode($categories, JSON_UNESCAPED_UNICODE)));
    }
}
