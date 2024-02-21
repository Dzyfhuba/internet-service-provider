<?php
namespace App\Services;

use App\Http\Requests\ProductOfSaleRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UserRequest;
use App\Models\Product;
use App\Models\ProductOfSale;
use App\Models\SessionToken;
use App\Models\User;
use App\Services\Cores\BaseService;
use App\Services\Cores\ErrorService;
use App\Validations\UserValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProductOfSaleService extends BaseService
{
    /**
     * Generate query index page
     *
     * @param Request $request
     */
    private function generate_query_get(Request $request)
    {
        $column_search = ["p.product_name", "p.product_description"];
        $column_order = [
            NULL, "p.product_name", "p.product_description", 'p.product_price_capital', 'p.product_price_sell',
            'product_sales.quantity'
        ];
        $order = ["product_sales.id" => "DESC"];

        $results = ProductOfSale::query()
            ->join('products as p', 'p.id', '=', 'product_sales.product_id')
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
    public function store(ProductOfSaleRequest $request)
    {
        try {
            $values = $request->validated();
            $item = ProductOfSale::create($values);

            $response = \response_success_default("Berhasil menambahkan penjualan produk!", $item->id, route("app.product-of-sales.show", $item->id));
        } catch (\Exception $e) {
            ErrorService::error($e, "Gagal store penjualan produk!");
            $response = \response_errors_default();
        }

        return $response;
    }

    /**
     * Update new user
     *
     * @param Request $request
     * @param User $product
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $product_id = $product->id;
            $values = $request->validated();

            $product->update($values);

            $response = \response_success_default("Berhasil update data produk!", $product_id, route("app.products.show", $product->id));
        } catch (\Exception $e) {
            ErrorService::error($e, "Gagal update produk!");
            $response = \response_errors_default();
        }

        return $response;
    }

    /**
     * Get last admin online
     *
     */
    public function get_admin_online()
    {
        $query = SessionToken::query()
            ->select([
                "u.name",
                "session_tokens.active_time",
                "u.id",
                DB::raw("MAX(session_tokens.active_time) AS max_time")
            ])
            ->join("users AS u", "u.id", "session_tokens.user_id")
            ->where("is_login", 1)
            ->having("max_time", ">", DB::raw("(NOW() - INTERVAL 15 MINUTE)"))
            ->groupBy("session_tokens.user_id")
            ->get()
            ->map(function ($item) {
                $to_time = strtotime(date("Y-m-d H:i:s"));
                $from_time = strtotime($item->max_time);
                $last_active = round(abs($to_time - $from_time) / 60);
                if ($last_active <= 0) {
                    $last_active = "Active";
                } else {
                    $last_active .= "m ago";
                }

                $item->last_active = $last_active;
                return $item;
            });

        return $query;
    }
}
