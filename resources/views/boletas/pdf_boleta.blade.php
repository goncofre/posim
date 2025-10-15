<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta Venta #{{ $venta->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 16pt; margin: 0; }
        .header p { margin: 2px 0; }
        .details { margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
        .details table { width: 100%; }
        .details table td { padding: 3px 0; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table th, .items-table td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        .items-table th { background-color: #f0f0f0; text-align: center; }
        .totals { width: 40%; margin-left: auto; border: 1px solid #000; padding: 10px; }
        .totals p { display: flex; justify-content: space-between; margin: 5px 0; }
        .totals .final { font-size: 12pt; font-weight: bold; border-top: 1px solid #000; padding-top: 5px; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>[Nombre de tu Empresa/Tienda]</h1>
        <p>RUT: 98.765.432-1 | Teléfono: +56 9 XXXX XXXX</p>
        <p>Dirección: Calle Falsa 123, Santiago, Chile</p>
        <hr>
        <h2>BOLETA DE VENTA N° {{ $venta->id }}</h2>
        <p>Fecha: {{ $venta->created_at->format('d/m/Y H:i') }}</p>
        <p>Tipo de Pago: <span class="bold">{{ strtoupper($venta->tipo_pago) }}</span></p>
        <hr>
    </div>

    <div class="details">
        <table>
            <tr>
                <td style="width: 50%;">Vendedor: {{ $venta->user->name ?? 'Sistema' }}</td>
                <td>Despacho: {{ $venta->requiere_despacho ? 'SÍ' : 'NO' }}</td>
            </tr>
            @if($venta->clienteDespacho)
                <tr>
                    <td colspan="2">Cliente Despacho: {{ $venta->clienteDespacho->nombre_completo }} ({{ $venta->clienteDespacho->rut_fiscal }})</td>
                </tr>
                <tr>
                    <td colspan="2">Dirección: {{ $venta->clienteDespacho->direccion_despacho }}</td>
                </tr>
            @endif
        </table>
    </div>

    <h3>Detalle de la Venta</h3>
    <table class="items-table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Producto</th>
                <th class="right">Precio Unitario</th>
                <th class="right">Cantidad</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->items as $item)
                <tr>
                    <td>{{ $item->sku }}</td>
                    <td>{{ $item->nombre_producto }}</td>
                    <td class="right">${{ number_format($item->precio_unitario, 2) }}</td>
                    <td class="right">{{ $item->cantidad }}</td>
                    <td class="right">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p><span>Subtotal (Neto):</span> <span class="right bold">${{ number_format($venta->subtotal, 2) }}</span></p>
        <p><span>IVA (19%):</span> <span class="right bold">${{ number_format($venta->iva, 2) }}</span></p>
        <div class="final">
            <p><span>TOTAL FINAL:</span> <span class="right bold">${{ number_format($venta->total, 2) }}</span></p>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 50px;">
        <p>¡Gracias por su compra!</p>
    </div>

</body>
</html>