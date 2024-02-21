<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\PointOfSaleRequest;
use App\Models\Product;
use App\Models\PointOfSale;
use App\Services\PointOfSaleService;
use Illuminate\Http\Request;

class PointOfSaleController extends Controller
{
    private PointOfSaleService $service;
    public function __construct()
    {
        $this->service = new PointOfSaleService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view_admin('admin.point-of-sales.index', 'Point Of Sales', first_page: true);
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
            $row[] = $item->quantity;
            $row[] = rupiah($item->final_price_capital * $item->quantity);
            $row[] = rupiah($item->final_price_sell * $item->quantity);
            $row[] = rupiah($item->final_price_sell * $item->quantity - $item->final_price_capital * $item->quantity);
            $row[] = date($item->updated_at);
            // $button = "<a href='" . \route("app.point-of-sales.show", $item->id) . "' class='btn btn-info btn-sm m-1'>Detail</a>";
            $button = form_delete("form$item->id", route("app.point-of-sales.destroy", $item->id));
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
        return $this->view_admin('admin.point-of-sales.create', 'Tambahkan Data Penjualan Produk', [
            'products' => implode('', array_map(fn($product) => "<option value='{$product['id']}'>{$product['product_name']}</option>", $products))
        ]);
        // implode('', array_map(fn ($product) => "<option value='{$product['id']}'>{$product['product_name']}</option>", $products));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PointOfSaleRequest $request)
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
    public function destroy(PointOfSale $item)
    {
        $item->delete();
        $response = \response_success_default("Berhasil hapus pencatatan product!", FALSE, \route("app.point-of-sales.index"));
        return \response_json($response);
    }
}
