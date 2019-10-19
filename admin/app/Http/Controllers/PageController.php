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

    public function catalog()
    {
        return view('pages.catalog');
    }
}
