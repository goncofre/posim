@extends('adminlte::page')

@section('title', 'Reporte de Usuarios')

@section('content_header')
    <h1>Ventas por usuarios</h1>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                Filtros de Reporte
            </div>
            <div class="card-body">
                <form action="{{ route('reporteproductos') }}" method="GET" class="form-inline">
                    <div class="form-group mr-3 mb-2">
                        <label for="mes" class="mr-2">Mes:</label>
                        <select name="mes" id="mes" class="form-control">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ (request('mes') == $i || (date('n') == $i && !request('mes'))) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->monthName }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group mr-3 mb-2">
                        <label for="anio" class="mr-2">Año:</label>
                        <select name="anio" id="anio" class="form-control">
                            @for ($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ (request('anio') == $i || (date('Y') == $i && !request('anio'))) ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mb-2">Generar Reporte</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        Top 10 Usuarios con Más Ventas (Cantidad)
                    </div>
                    <div class="card-body">
                        <canvas id="topProductosChart"></canvas> 
                        <p class="text-center mt-3 text-muted">Datos basados en la cantidad total de unidades vendidas.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        Detalle de Ventas por Producto
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Producto</th>
                                        <th class="text-right">Unidades Vendidas</th>
                                        <th class="text-right">Total Recaudado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>LAPTOP001</td>
                                        <td>Laptop Gamer Pro-X</td>
                                        <td class="text-right">55</td>
                                        <td class="text-right">$ 68,804.45</td>
                                    </tr>
                                    <tr>
                                        <td>CAFEKG</td>
                                        <td>Café Tostado Premium (Kg)</td>
                                        <td class="text-right">450</td>
                                        <td class="text-right">$ 6,750.00</td>
                                    </tr>
                                    <tr>
                                        <td>SSD512</td>
                                        <td>Disco SSD 512GB NVMe</td>
                                        <td class="text-right">120</td>
                                        <td class="text-right">$ 9,540.00</td>
                                    </tr>
                                    {{-- FIN FILAS DE EJEMPLO --}}
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light font-weight-bold">
                                        <td colspan="2" class="text-right">TOTAL GENERAL:</td>
                                        <td class="text-right">625</td>
                                        <td class="text-right">$ 85,094.45</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Datos simulados del Top 10 (esto vendría del backend)
            const topProductos = {
                nombres: ['Laptop Gamer', 'SSD 512GB', 'Teclado RGB', 'Webcam HD', 'Mouse Inalámbrico', 'Café Tostado', 'Azúcar Blanca', 'Monitor 4K', 'Auriculares', 'Cable HDMI'],
                cantidades: [55, 120, 75, 45, 20, 450, 600, 30, 80, 150]
            };

            const ctx = document.getElementById('topProductosChart').getContext('2d');
            
            const myChart = new Chart(ctx, {
                type: 'doughnut', // Gráfico de torta (doughnut)
                data: {
                    labels: topProductos.nombres.slice(0, 10),
                    datasets: [{
                        label: 'Unidades Vendidas',
                        data: topProductos.cantidades.slice(0, 10),
                        // Colores de ejemplo
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', 
                            '#68b916ff', '#DC143C', '#00FFFF', '#FFA07A'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        title: {
                            display: false,
                        }
                    }
                }
            });
        });
    </script>
@stop