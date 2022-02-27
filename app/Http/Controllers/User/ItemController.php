<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
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
}
