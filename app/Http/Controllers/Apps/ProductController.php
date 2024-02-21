<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    private ProductService $service;
    public function __construct()
    {
        $this->service = new ProductService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $data = Product::all();
        return $this->view_admin('admin.products.index', 'Products', first_page: false);
    }

    public function get(Request $request)
    {
        $list = $this->service->get_list_paged($request);
        $count = $this->service->get_list_count($request);

        $data = [];
        $no = $request->start;

        foreach ($list as $item) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $item->product_name;
            $row[] = $item->product_description;
            $row[] = $item->product_price_capital;
            $row[] = $item->product_price_sell;
            $button = "<a href='" . \route("app.products.show", $item->id) . "' class='btn btn-info btn-sm m-1'>Detail</a>";
            $button .= form_delete("form$item->id", route("app.products.destroy", $item->id));
            $row[] = $button;
            $data[] = $row;
        }

        $output = [
            "draw" => $request->draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        ];

        return \response()->json($output, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
