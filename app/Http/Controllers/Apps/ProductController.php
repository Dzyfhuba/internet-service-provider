<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
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
        return $this->view_admin('admin.products.index', 'Produk', first_page: true);
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
            $row[] = rupiah($item->product_price_capital);
            $row[] = rupiah($item->product_price_sell);
            $button = "<a href='" . \route("app.products.show", $item->id) . "' class='btn btn-info btn-sm m-1'>Detail</a>";
            $button .= form_delete("form$item->id", route("app.products.destroy", $item->id));
            $button .= form_update("form$item->id", route("app.products.edit", $item->id));
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
        return $this->view_admin('admin.products.create', 'Tambah Produk');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
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
    public function show(Product $product)
    {
        return $this->view_admin("admin.products.show", "Detail Product", [
            'data' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return $this->view_admin('admin.products.edit', "Edit Produk: {$product->product_name}", [
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $response = $this->service->update($request, $product);
        return \response_json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        $response = \response_success_default("Berhasil hapus produk!", FALSE, \route("app.products.index"));
        return \response_json($response);
    }
}
