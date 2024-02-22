<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\PointOfSale;
use App\Models\Product;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private UserService $user_service;

    public function __construct()
    {
        $this->user_service = new UserService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = [
            "admin_online" => $this->user_service->get_admin_online(),
            'total_products' => Product::count(),
            'total_transactions' => PointOfSale::count()
        ];

        return $this->view_admin("admin.index", "Dashboard", $data, TRUE);
    }

    public function get()
    {
        $monthlySales = PointOfSale::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(id) as sale_count')
            ->whereBetween('created_at', [Carbon::now()->subMonths(6), Carbon::now()->subMonth()])
            ->groupBy('year', 'month')
            ->get();

        $productTransactionsLastYear = PointOfSale::select('product_name')
            ->selectRaw('COUNT(id) as transaction_count')
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('product_name')
            ->orderBy('final_price_capital')
            ->get();

        $productTransactionsThisYear = PointOfSale::select('product_name')
            ->selectRaw('COUNT(id) as transaction_count')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('product_name')
            ->get();

        return response()->json([
            'monthlySales' => $monthlySales,
            'productTransactionsLastYear' => $productTransactionsLastYear,
            'productTransactionsThisYear' => $productTransactionsThisYear
        ]);
    }
}
