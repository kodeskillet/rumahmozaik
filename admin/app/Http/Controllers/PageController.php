<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CatalogTypeController;
use App\Http\Controllers\Product;
use App\Http\Controllers\Order;

class PageController extends Controller
{
    /**
     * Display icons page
     *
     * @return \Illuminate\View\View
     */
    public function icons()
    {
        return view('pages.icons');
    }

    /**
     * Display tables page
     *
     * @return \Illuminate\View\View
     */
    public function tables()
    {
        return view('pages.tables');
    }

    /**
     * Display notifications page
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        return view('pages.notifications');
    }

    /**
     * Display typography page
     *
     * @return \Illuminate\View\View
     */
    public function typography()
    {
        return view('pages.typography');
    }

    public function product(CatalogTypeController $catalogs, ProductController $products)
    {
        $products = json_decode($products->index());
        $catalog = json_decode($catalogs->index());
        return view('pages.product',compact('catalog', 'products'));
    }

    public function productDelete(ProductController $product, $id)
    {
        $product=$product->destroy($id);
        return redirect()->action('PageController@product');
    }

    public function catalog(CatalogTypeController $catalogs)
    {
        $catalogs = json_decode($catalogs->index());
        return view('pages.catalog',compact('catalogs'));
    }

    public function catalogDelete(CatalogTypeController $catalogs, $id)
    {
        $catalogs = $catalogs->destroy($id);
        return redirect()->action('PageController@catalog');
    }

    public function order()
    {
        return view('pages.order');
    }
}
