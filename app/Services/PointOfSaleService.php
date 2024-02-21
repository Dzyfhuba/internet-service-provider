<?php
namespace App\Services;

use App\Http\Requests\PointOfSaleRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UserRequest;
use App\Models\Product;
use App\Models\PointOfSale;
use App\Models\SessionToken;
use App\Models\User;
use App\Services\Cores\BaseService;
use App\Services\Cores\ErrorService;
use App\Validations\UserValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PointOfSaleService extends BaseService
{
    /**
     * Generate query index page
     *
     * @param Request $request
     */
    private function generate_query_get(Request $request)
    {
        $column_search = ["product_name"];
        $column_order = [
            NULL, "product_name", "product_description", 'final_price_capital', 'final_price_sell',
            'quantity'
        ];
        $order = ["product_sales.id" => "DESC"];

        $results = PointOfSale::query()
            ->where(function ($query) use ($request, $column_search) {
                $i = 1;
                if (isset($request->search)) {
                    foreach ($column_search as $column) {
                        if ($request->search["value"]) {
                            if ($i == 1) {
                                $query->where($column, "LIKE", "%{$request->search["value"]}%");
                            } else {
                                $query->orWhere($column, "LIKE", "%{$request->search["value"]}%");
                            }
                        }
                        $i++;
                    }
                }
            });

        if (isset($request->order) && !empty($request->order)) {
            $results = $results->orderBy($column_order[$request->order["0"]["column"]], $request->order["0"]["dir"]);
        } else {
            $results = $results->orderBy(key($order), $order[key($order)]);
        }

        return $results;
    }

    public function get_list_paged(Request $request)
    {
        $results = $this->generate_query_get($request);
        if ($request->length != -1) {
            $limit = $results->offset($request->start)->limit($request->length);
            return $limit->get();
        }
    }

    public function get_list_count(Request $request)
    {
        return $this->generate_query_get($request)->count();
    }

    /**
     * Store new user
     *
     * @param Request $request
     */
    public function store(PointOfSaleRequest $request)
    {
        try {
            $values = $request->validated();
            $product = Product::find($values['product_id']);
            $item = PointOfSale::create([
                'product_name' => $product['product_name'],
                'final_price_capital' => $product['product_price_capital'],
                'final_price_sell' => $product['product_price_sell'],
            ]);

            $response = \response_success_default("Berhasil menambahkan penjualan produk!", $item->id, route("app.point-of-sales.index"));
        } catch (\Exception $e) {
            ErrorService::error($e, "Gagal store penjualan produk!");
            $response = \response_errors_default();
        }

        return $response;
    }
}
