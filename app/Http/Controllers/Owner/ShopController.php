<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    /**
     * 新しいOwnersControllerインスタンスの生成
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:owners');
        $this->middleware(function ($request, $next) {
            // dd($request->route()->parameter('shop'));   // 文字列
            // dd(Auth::id()); // 数字
            $id = $request->route()->parameter('shop');
            if (!is_null($id)) {
                $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                $shopsOwnerId = (int)$shopsOwnerId;
                $ownerId = Auth::id();
                if ($shopsOwnerId !== $ownerId) {
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $ownerId = Auth::id();
        $shops = Shop::where('owner_id', Auth::id())->get();
        return view('owner.shops.index', compact('shops'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        // dd(Shop::findOrFail($id));
        return view('owner.shops.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $imageFile = $request->image;
        if (!is_null($imageFile) && $imageFile->isValid()) {
            Storage::putFile('public/shops', $imageFile);
        }

        return redirect()
            ->route('owner.shops.index')
            ->with(['message' => 'お店の情報を更新しました。', 'status' => 'info']);
    }
}
