<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * 新しいOwnersControllerインスタンスの生成
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:users');
    //     $this->middleware(function ($request, $next) {
    //         $id = $request->route()->parameter('product');
    //         if (!is_null($id)) {
    //             $productsOwnerId = Product::findOrFail($id)->shop->owner->id;
    //             $productsOwnerId = (int)$productsOwnerId;
    //             if ($productsOwnerId !== Auth::id()) {
    //                 abort(404);
    //             }
    //         }
    //         return $next($request);
    //     });
    }

    public function index()
    {
        $stocks = DB::table('t_stocks')
            ->select('product_id', DB::raw('sum(quantity) AS quantity'))
            ->groupBy('product_id')
            ->having('quantity', '>', 1);

        $products = DB::table('products')
            ->joinSub($stocks, 'stock', function ($join) {
                $join->on('products.id', '=', 'stock.product_id');
            })
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->join('secondary_categories', 'products.secondary_category_id', '=', 'secondary_categories.id')
            ->join('images AS image1', 'products.image1', '=', 'image1.id')
            ->join('images AS image2', 'products.image2', '=', 'image2.id')
            ->join('images AS image3', 'products.image3', '=', 'image3.id')
            ->join('images AS image4', 'products.image4', '=', 'image4.id')
            ->where('shops.is_selling', true)
            ->where('products.is_selling', true)
            ->select(
                'products.id AS id',
                'products.name AS name',
                'products.price',
                'products.sort_order AS sort_order',
                'products.information AS information',
                'secondary_categories.name AS category',
                'image1.filename AS filename'
            )
            ->get();

        // dd($stocks, $products);
        return view('user.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('user.show', compact('product'));
    }
}
