@extends('adminlte::page')

@section('title', 'Reporte de Productos')

@section('content_header')
    <h1>Ventas por productos</h1>
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
                            {{-- Generar los 12 meses, seleccionar el actual o el que viene de la request --}}
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
                            {{-- Generar años, ej: desde 2020 hasta el actual --}}
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

        {{-- CONTENEDOR DE GRÁFICO Y TABLA --}}
        <div class="row">
            
            {{-- GRÁFICO DE TORTA (Columna 1) --}}
            <div class="col-lg-5 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        Top 10 Productos Más Vendidos (Cantidad)
                    </div>
                    <div class="card-body">
                        {{-- Contenedor donde se renderizará el gráfico con Chart.js --}}
                        <canvas id="topProductosChart"></canvas> 
                        <p class="text-center mt-3 text-muted">Datos basados en la cantidad total de unidades vendidas.</p>
                    </div>
                </div>
            </div>

            {{-- TABLA DE RESULTADOS (Columna 2) --}}
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
                                    {{-- Aquí se iterarían los resultados del reporte ($reporteProductos) --}}
                                    {{-- FILAS DE EJEMPLO --}}
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
        
            // 💡 Datos pasados desde el controlador
            const chartLabels = @json($chartData['labels']);
            const chartValues = @json($chartData['data']);

            console.log(chartLabels);
            console.log(chartValues);
            
            const myChart = new Chart(ctx, {
                type: 'doughnut', // Gráfico de torta (doughnut)
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Unidades Vendidas',
                        data: chartValues,
                        backgroundColor: [
                            '#85b7c9ff', '#f1959eff', '#f0c18cff', '#f7f782ff', '#7af795ff', '#8ecaf8ff', 
                            '#965169ff', '#d880d8ff', '#b5b5faff', '#ec5858ff'
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