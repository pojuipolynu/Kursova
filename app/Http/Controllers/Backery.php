<?php

namespace App\Http\Controllers;

use App\Models\Tovar;
use App\Models\Commentar;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Backery extends Controller
{
    public function show()
    {
        $popular = Tovar::where('name', '!=', 'Konstructor')->limit(2)->get();
        $firmovi = Tovar::select('*')->where('name', '!=', 'Konstructor')->orderBy('rate', 'DESC')->limit(4)->get();
        return view('main', compact('popular'), compact('firmovi'));
    }
    public function show_catalog()
    {
        $alltovar = Tovar::where('name', '!=', 'Konstructor')->get();
        return view('catalog', compact('alltovar'));
    }
    public function show_info()
    {
        return view('information');
    }
    public function show_tovar($id)
    {
        $tovar_page = Tovar::select('*')->where('id', '=', $id)->get();
        $comments = Commentar::select('*')->where('tovar_id', '=', $id)->get();
        $rate = $tovar_page[0]->rate + 1;
        $tovar_page[0]->rate = $rate;
        $tovar_page[0]->timestamps = false;
        $tovar_page[0]->update();
        return view('tovar', compact('tovar_page'), compact('comments'));
    }
    public function tovar_comment($id, Request $request): View
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'feedback' => 'required'
        ]);
        $comment = new Commentar();
        $comment->timestamps = false;
        $comment->tovar_id = "$id";
        $comment->text = $request->input('feedback');
        $comment->user_name = $request->input('name');
        $comment->email = $request->input('email');
        $comment->save();
        return self::show_tovar($id);
    }
    public function catalog_sort(Request $request): View
    {
        $search = new Tovar();
        if (($request->input('ready') and $request->input('not_ready')) or ($request->input('not_ready') and $request->input('not_available')) or ($request->input('ready') and $request->input('not_available'))) {
            echo "<p>Задані неможливі умови для пошуку</p>";
        } 
        elseif(($request->input('select_popular')!=0 and $request->input('select_vidp')!=0) or ($request->input('select_popular')!=0 and $request->input('select_price')!=0) or ($request->input('select_price')!=0 and $request->input('select_vidp')!=0)){
            echo "<p>Задані неможливі умови для пошуку</p>";
        }
        elseif($request->input('search_name')){
            $alltovar = Tovar::select('*')->where('name', '=', $request->input('search_name'))->where('name', '!=', 'Konstructor')->get();
            if ($alltovar =='[]'){
                $alltovar = Tovar::where('name', '!=', 'Konstructor')->get();
                echo "<p>На жаль, немає солодощів з такою назвою(((</p>";
                return view('catalog', compact('alltovar'));
            }
            else{
                return view('catalog', compact('alltovar'));
            }
        }
        else {
            if ($request->input('price_vid') and $request->input('price_do')) {
                $check_price = ['vid'=>$request->input('price_vid'), 'do'=>$request->input('price_do')];
            } elseif ($request->input('price_vid')) {
                $check_price = ['vid'=>$request->input('price_vid'), 'do'=>Tovar::max('price')];
            } elseif ($request->input('price_do')) {
                $check_price = ['vid'=>Tovar::min('price'), 'do'=>$request->input('price_do')];
            } else{
                $check_price = ['vid'=>Tovar::min('price'), 'do'=>Tovar::max('price')];
            }
            if($request->input('select_price')==1){
                $result = Tovar::select('*')->whereBetween('price', [$check_price['vid'], $check_price['do']])->orderBy('price', 'ASC')->get();
            }
            elseif($request->input('select_price')==2){
                $result = Tovar::select('*')->whereBetween('price', [$check_price['vid'], $check_price['do']])->where('name', '!=', 'Konstructor')->orderBy('price', 'DESC')->get();
            }
            if($request->input('select_popular')==1){
                $result = Tovar::select('*')->whereBetween('price', [$check_price['vid'], $check_price['do']])->where('name', '!=', 'Konstructor')->orderBy('rate', 'ASC')->get();
            }
            elseif($request->input('select_popular')==2){
                $result = Tovar::select('*')->whereBetween('price', [$check_price['vid'], $check_price['do']])->where('name', '!=', 'Konstructor')->orderBy('rate', 'DESC')->get();
            }

            if($request->input('select_vidp')==1){
                $result = Tovar::select('*')->whereBetween('price', [$check_price['vid'], $check_price['do']])->where('name', '!=', 'Konstructor')->orderBy('name', 'ASC')->get();
            }
            elseif($request->input('select_vidp')==2){
                $result = Tovar::select('*')->whereBetween('price', [$check_price['vid'], $check_price['do']])->where('name', '!=', 'Konstructor')->orderBy('name', 'DESC')->get();
            }

            if ($request->input('ready') or $request->input('status')==1) {
                $search->ready = 1;
                foreach ($result as $key => $value) {
                    if($value->ready != $search->ready){
                        $result->forget($key);
                    }
                }
            } elseif ($request->input('not_ready') or $request->input('status')==2) {
                $search->ready = 0;
                foreach ($result as $key => $value) {
                    if($value->ready != $search->ready){
                        $result->forget($key);
                    }
                }
            }
            if ($request->input('not_available') or $request->input('status')==3) {
                $search->inaccessible = 1;
                foreach ($result as $key => $value) {
                    if($value->inaccessible != $search->inaccessible){
                        $result->forget($key);
                    }
                }
            }
            if ($request->input('no_lactose') or $request->input('dodatkovo')==1) {
                $search->no_lactose = 1;
                foreach ($result as $key => $value) {
                    if($value->no_lactose != $search->no_lactose){
                        $result->forget($key);
                    }
                }
            }
            if ($request->input('no_gluten')or $request->input('dodatkovo')==2) {
                $search->no_gluten = 1;
                foreach ($result as $key => $value) {
                    if($value->no_gluten != $search->no_gluten){
                        $result->forget($key);
                    }
                }
            }
            if ($request->input('no_nuts')or $request->input('dodatkovo')==3) {
                $search->no_nuts = 1;
                foreach ($result as $key => $value) {
                    if($value->no_nuts != $search->no_nuts){
                        $result->forget($key);
                    }
                }
            }
            $alltovar = $result;
        }
        return view('catalog', compact('alltovar'));
    }
    public function categories($id){
        if($id<=4){
            $alltovar=Tovar::select('*')->where('type_id', '=', $id)->where('name', '!=', 'Konstructor')->get();
        }
        elseif($id==5){
            $alltovar=Tovar::select('*')->where('sale', '=', '1')->where('name', '!=', 'Konstructor')->get();
        }
        elseif($id==6){
            $alltovar=Tovar::select('*')->where('new', '=', '1')->where('name', '!=', 'Konstructor')->get();
        }
        return view('catalog', compact('alltovar'));
    }
}