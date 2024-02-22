@extends('layouts.admin.app')

@push('style')
    <style>
        .x-scroll-snap {
            overflow-x: scroll;
            scroll-snap-type: x mandatory;
        }

        .x-scroll-snap>* {
            scroll-snap-align: start;
        }

        .min-w-sm {
            min-width: 300px !important;
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    <div class="d-flex md gap-3 x-scroll-snap">
        <div class="card min-w-sm">
            <div class="card-header">
                <h5>Admin Aktif</h5>
            </div>
            <div class="card-body">
                <ul>
                    @forelse ($admin_online as $item)
                        <li>
                            <a href="{{ route('app.users.show', $item->id) }}">{{ "$item->name $item->last_active" }}</a>
                        </li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="card min-w-sm">
            <div class="card-header">
                <h5>Jumlah Produk</h5>
            </div>
            <div class="card-body">
                <span>{{ $total_products }}</span>
            </div>
        </div>

        <div class="card min-w-sm">
            <div class="card-header">
                <h5>Jumlah Transaksi</h5>
            </div>
            <div class="card-body">
                <span>{{ $total_transactions }}</span>
            </div>
        </div>

    </div>
    <div class="card min-w-sm">
        <div class="card-header">
            <h5>Transaksi 6 Bulan Lalu</h5>
        </div>
        <div class="card-body">
            <div id="transaction"></div>
        </div>
    </div>

    <div class="card min-w-sm">
        <div class="card-header">
            <h5>Jumlah Transaksi Setiap Produk Tahun {{ explode('-', now()->subYear())[0] }}</h5>
        </div>
        <div class="card-body">
            <div id="productTransactionsLastYear"></div>
        </div>
    </div>

    <div class="card min-w-sm">
        <div class="card-header">
            <h5>Jumlah Transaksi Setiap Produk Tahun {{ now()->year }}</h5>
        </div>
        <div class="card-body">
            <div id="productTransactionsThisYear"></div>
        </div>
    </div>

    @push('style')
        <link rel="stylesheet" href="/assets/extensions/apexcharts/apexcharts.css">
    @endpush
    @push('script')
        <script src="/assets/extensions/apexcharts/apexcharts.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                fetch('/app/dashboard/get', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(res => res.json())
                    .then((data) => {
                        // ============== 6 months ago ====================
                        const monthlySales = data.monthlySales;

                        var options = {
                            chart: {
                                type: 'bar',
                                height: 300
                            },
                            series: [{
                                name: 'Sales Count',
                                data: monthlySales.map((item) => {
                                    return {
                                        x: new Date(item.year, item.month - 1),
                                        y: item.sale_count
                                    };
                                }).sort((a, b) => a.x - b.x)
                            }],
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    dataLabels: {
                                        position: 'top', // top, center, bottom
                                    },
                                }
                            },

                            xaxis: {
                                type: 'datetime',
                                labels: {
                                    format: 'MMM yyyy'
                                },
                                title: {
                                    text: 'Bulanan'
                                }
                            },
                            yaxis: {
                                type: 'number',
                                title: 'Jumlah Transaksi'
                            }
                        };

                        const chart1 = new ApexCharts(document.querySelector("#transaction"), options);
                        chart1.render()

                        // ================== product sale a year ago =======================
                        const productTransactionsLastYear = data.productTransactionsLastYear;

                        const chart2 = new ApexCharts(document.querySelector("#productTransactionsLastYear"), {
                            chart: {
                                type: 'bar',
                                height: 300
                            },
                            series: [{
                                name: 'Transaction Count',
                                data: productTransactionsLastYear.map(function(item) {
                                    return item.transaction_count;
                                })
                            }],
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    dataLabels: {
                                        position: 'top', // top, center, bottom
                                    },
                                }
                            },

                            xaxis: {
                                categories: productTransactionsLastYear.map(function(item) {
                                    return item.product_name;
                                }),
                                labels: {
                                    rotate: -45,
                                    style: {
                                        fontSize: '12px'
                                    }
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Transaction Count'
                                }
                            },

                        });
                        chart2.render()

                        // ================ product sale a current year =============
                        const productTransactionsThisYear = data.productTransactionsThisYear;

                        const chart3 = new ApexCharts(document.querySelector("#productTransactionsThisYear"), {
                            chart: {
                                type: 'bar',
                                height: 300
                            },
                            series: [{
                                name: 'Transaction Count',
                                data: productTransactionsThisYear.map(function(item) {
                                    return item.transaction_count;
                                })
                            }],
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    dataLabels: {
                                        position: 'top', // top, center, bottom
                                    },
                                }
                            },

                            xaxis: {
                                categories: productTransactionsThisYear.map(function(item) {
                                    return item.product_name;
                                }),
                                labels: {
                                    rotate: -45,
                                    style: {
                                        fontSize: '12px'
                                    }
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Transaction Count'
                                }
                            },

                        });
                        chart3.render()
                    })
            });
        </script>
    @endpush
@endsection
