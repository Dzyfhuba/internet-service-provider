<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductOfSaleRequest;
use App\Models\Product;
use App\Services\ProductOfSaleService;
use Illuminate\Http\Request;

class ProductOfSaleController extends Controller
{
    private ProductOfSaleService $service;
    public function __construct()
    {
        $this->service = new ProductOfSaleService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view_admin('admin.product-of-sales.index', 'Product Of Sales', first_page: true);
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
            $row[] = rupiah($item->product_price_sell * $item->quantity);
            $button = "<a href='" . \route("app.product-of-sales.show", $item->id) . "' class='btn btn-info btn-sm m-1'>Detail</a>";
            $button .= form_delete("form$item->id", route("app.product-of-sales.destroy", $item->id));
            $button .= form_update("form$item->id", route("app.product-of-sales.edit", $item->id));
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
        $products = Product::all()->toArray();
        // dd($products);
        return $this->view_admin('admin.product-of-sales.create', 'Tambahkan Data Penjualan Produk', [
            'products' => implode('', array_map(fn ($product) => "<option value='{$product['id']}'>{$product['product_name']}</option>", $products))
        ]);
        // implode('', array_map(fn ($product) => "<option value='{$product['id']}'>{$product['product_name']}</option>", $products));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductOfSaleRequest $request)
    {
        $response = $this->service->store($request);
        return \response_json($response);
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
