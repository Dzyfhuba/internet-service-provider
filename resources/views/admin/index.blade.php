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
            <h5>Transaksi 6 bulan lalu</h5>
        </div>
        <div class="card-body">
            <div id="transaction"></div>
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
                        const monthlySales = data.monthlySales;
                        console.log(monthlySales)

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

                        const chart = new ApexCharts(document.querySelector("#transaction"), options);
                        chart.render()
                    })
            });
        </script>
    @endpush
@endsection
