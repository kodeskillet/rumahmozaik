<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CatalogTypeController;

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

    public function product(CatalogTypeController $catalogs)
    {
        $catalog = $catalogs->index();
        return view('pages.product',compact('catalog'));
    }

    // public function productStore(ProductController $products)
    // {

    // }

    public function catalog(CatalogTypeController $catalogs)
    {
        $catalogs = $catalogs->index();
        return view('pages.catalog',compact('catalogs'));
    }

    public function catalogDelete(CatalogTypeController $catalogs, $id)
    {
        $catalogs = $catalogs->destroy($id);
        return redirect()->action('PageController@catalog');
    }
}
