@extends('adminlte::page')

@section('title', 'Ventas - POSIM')

@section('content_header')
    <h1>Ventas</h1>
@stop

@section('content')
    <div class="contenedor-columnas">
        <div class="columna-principal">
            <h1>Módulo de Venta</h1>
            
            <div class="seccion-busqueda">
                <input 
                    type="text" 
                    class="input-busqueda form-control" 
                    id="input-busqueda-producto"
                    placeholder="Escribe SKU o nombre para buscar y agregar a la venta..."
                >
                
                <div id="resultados-busqueda" class="dropdown-menu" style="width: 100%; display: none;">
                    <a class="dropdown-item" href="#">Producto 1 ($100.00)</a>
                </div>
            </div>

            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th class="col-sku">SKU</th>
                        <th>Nombre del Producto</th>
                        <th class="col-precio">Precio Unitario</th>
                        <th class="col-cantidad">Cantidad</th>
                        <th class="col-total">Total</th>
                    </tr>
                </thead>
                <tbody id="cuerpo-tabla-productos">
                    <tr id="fila-P001" data-price="350">
                        <td class="col-sku">P001</td>
                        <td>Monitor 27" 4K</td>
                        <td class="col-precio">
                            <input type="number" value="350" min="1" step="1" class="input-precio" data-id="P001">
                        </td>
                        <td class="col-cantidad">
                            <input type="number" value="2" min="1" class="input-cantidad" data-id="P001">
                        </td>
                        <td class="col-total" id="total-P001">700</td>
                    </tr>
                    
                    <tr id="fila-P003" data-price="99.50">
                        <td class="col-sku">P003</td>
                        <td>Disco SSD 1TB NVMe</td>
                        <td class="col-precio">
                            <input type="number" value="99" min="1" step="1" class="input-precio" data-id="P003">
                        </td>
                        <td class="col-cantidad">
                            <input type="number" value="1" min="1" class="input-cantidad" data-id="P003">
                        </td>
                        <td class="col-total" id="total-P003">99</td>
                    </tr>

                    <tr id="fila-resumen">
                        <td colspan="4" style="text-align: right; font-weight: bold;">SUBTOTAL:</td>
                        <td class="col-total" style="font-weight: bold;" id="subtotal-general">799.50</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="columna-secundaria">
            <h2>Resumen de Venta</h2>
    
            <div class="resumen-item">
                <span class="label">Subtotal (Neto):</span>
                <span class="valor" id="resumen-subtotal">0.00</span>
            </div>
            
            <div class="resumen-item">
                <span class="label">IVA (19%):</span>
                <span class="valor" id="resumen-iva">0.00</span>
            </div>
            
            <hr>
            
            <div class="resumen-item total-final">
                <span class="label">TOTAL A PAGAR:</span>
                <span class="valor" id="resumen-total">0.00</span>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Estilos generales para el cuerpo y el contenedor */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .contenedor-columnas {
            /* Usamos Flexbox para alinear los elementos en una fila */
            display: flex;
            width: 100%; /* Ocupa todo el ancho de la ventana/padre */
            min-height: 100vh; /* Para que sea visible */
            border: 1px solid #ccc; /* Borde para visualización */
        }

        /* Estilos para la primera columna (80% de ancho) */
        .columna-principal {
            flex: 8; /* Esto hace que ocupe 8 partes de 10 (80%) */
            background-color: #f0f0f0;
            padding: 20px;
            box-sizing: border-box; /* Incluye padding en el ancho total */
        }

        /* Estilos para la segunda columna (20% de ancho) */
        .columna-secundaria {
            flex: 2; /* Esto hace que ocupe 2 partes de 10 (20%) */
            background-color: #e0e0e0;
            padding: 20px;
            box-sizing: border-box; /* Incluye padding en el ancho total */
            border-left: 1px solid #ccc;
        }

        /* Estilos de contenido */
        h2 {
            margin-top: 0;
            color: #333;
        }
        /* ========================================
           Estilos Específicos de la Columna Principal
        ========================================
        */

        /* Estilo del Input de Búsqueda */
        .seccion-busqueda {
            position: relative;
            margin-bottom: 25px;
        }
        #resultados-busqueda{
            position: absolute; 
            top: 100%; 
            left: 0; 
            width: 100%; 
            z-index: 1000; 
        }

        .input-busqueda {
            width: 100%;
            padding: 10px 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Estilo de la Tabla de Productos */
        .tabla-productos {
            width: 100%;
            border-collapse: collapse; /* Para que las celdas se vean limpias */
            margin-top: 15px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .tabla-productos th, .tabla-productos td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .tabla-productos th {
            background-color: #4CAF50; /* Color distintivo para el encabezado */
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }

        .tabla-productos tr:nth-child(even) {
            background-color: #f9f9f9; /* Rayas para mejor lectura */
        }
        
        /* Ajuste de ancho para algunas columnas */
        .col-cantidad, .col-precio, .col-total {
            width: 10%;
            text-align: right;
        }
        .col-precio input{
            width: 80px;
        }
        .col-cantidad input{
            width: 40px;
        }
        .col-sku {
            width: 15%;
        }
        .columna-secundaria .resumen-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .columna-secundaria .label {
            font-weight: normal;
        }

        .columna-secundaria .valor {
            font-weight: bold;
        }

        .columna-secundaria .total-final {
            font-size: 20px;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px solid #333;
        }
        .columna-secundaria hr {
            border: none;
            border-top: 1px dashed #ccc;
            margin: 15px 0;
        }
    </style>
@stop

@section('js')
    <script>
        const productosSimulados = [
            { sku: 'P001', nombre: 'Monitor 27" 4K', precio: 350 },
            { sku: 'P002', nombre: 'Teclado Mecánico RGB', precio: 75 },
            { sku: 'P003', nombre: 'Disco SSD 1TB NVMe', precio: 99 },
            { sku: 'P004', nombre: 'Webcam Full HD', precio: 45 },
            { sku: 'P005', nombre: 'Mouse Inalámbrico', precio: 25 }
        ];

        const IVA_RATE = 0.19; // 19% de IVA
        const subtotalTablaElemento = document.getElementById('subtotal-general');
        
        const cuerpoTablaProductos = document.getElementById('cuerpo-tabla-productos');
        const subtotalElemento = document.getElementById('subtotal-general');

        // Elementos del Resumen Lateral
        const resumenSubtotalElemento = document.getElementById('resumen-subtotal');
        const resumenIvaElemento = document.getElementById('resumen-iva');
        const resumenTotalElemento = document.getElementById('resumen-total');

        let inputBusqueda;
        let resultadosDiv;

        let subtotalVenta = 0;
        const productosEjemplo = [
            { sku: 'P001', nombre: 'Monitor 27" 4K', precio: 350 },
            { sku: 'P002', nombre: 'Teclado Mecánico RGB', precio: 75 },
            { sku: 'P003', nombre: 'Disco SSD 1TB NVMe', precio: 99 },
            { sku: 'P004', nombre: 'Webcam Full HD', precio: 45 }
        ];
        function calcularTotalProducto(idProducto) {
            // 1. Obtener los inputs específicos de la fila
            const inputPrecio = document.querySelector(`.input-precio[data-id="${idProducto}"]`);
            const inputCantidad = document.querySelector(`.input-cantidad[data-id="${idProducto}"]`);
            const totalCelda = document.getElementById(`total-${idProducto}`);
            
            // 2. Obtener los valores (asegurando que sean números y no estén vacíos)
            let precio = parseFloat(inputPrecio.value) || 0;
            let cantidad = parseInt(inputCantidad.value) || 0;
            
            // Asegurar valores mínimos (opcional)
            if (precio < 0.01) {
                precio = 1;
                inputPrecio.value = precio.toFixed(0);
            }
            if (cantidad < 1) {
                cantidad = 1;
                inputCantidad.value = cantidad;
            }

            // 3. Calcular y actualizar la celda Total
            const totalLinea = precio * cantidad;
            totalCelda.textContent = totalLinea.toFixed(0);

            // 4. Recalcular el Subtotal General
            recalcularSubtotalGeneral();
        }


        /**
         * Recalcula y actualiza el valor del subtotal general.
         */
        function recalcularSubtotalGeneral() {
            let subtotalGeneral = 0;
    
            // 1. Sumar todos los totales de las filas de productos
            const todasLasFilasTotal = cuerpoTablaProductos.querySelectorAll('.col-total:not(#subtotal-general)');
            
            todasLasFilasTotal.forEach(celda => {
                // Asegurar que el valor sea un número antes de sumar
                subtotalGeneral += parseFloat(celda.textContent) || 0;
            });

            // 2. Calcular IVA y Total Final
            const ivaCalculado = subtotalGeneral * IVA_RATE;
            const totalFinal = subtotalGeneral + ivaCalculado;

            // 3. Actualizar la celda de Subtotal en la Tabla (Columna 1)
            subtotalTablaElemento.textContent = subtotalGeneral.toFixed(0);
            
            // 4. Actualizar el Resumen Lateral (Columna 2)
            resumenSubtotalElemento.textContent = subtotalGeneral.toFixed(0);
            resumenIvaElemento.textContent = ivaCalculado.toFixed(0);
            resumenTotalElemento.textContent = totalFinal.toFixed(0);
        }


        /**
         * Asigna los event listeners a todos los inputs de precio y cantidad.
         */
        function inicializarEventosCalculo() {
            // Seleccionar todos los inputs relevantes en la tabla
            const inputsCalculo = cuerpoTablaProductos.querySelectorAll('.input-precio, .input-cantidad');

            inputsCalculo.forEach(input => {
                // Usamos el evento 'input' para capturar cambios en tiempo real
                input.addEventListener('input', (event) => {
                    const idProducto = event.target.dataset.id;
                    // Después de calcular el total del producto, la función
                    // llama automáticamente a recalcularSubtotalGeneral(),
                    // que ahora actualiza el resumen lateral.
                    calcularTotalProducto(idProducto); 
                });
            });

            // Ejecutar el cálculo inicial para asegurar que todo esté correcto al cargar
            recalcularSubtotalGeneral();
        }

        // ===========================================
        // FUNCIÓN DE AGREGAR PRODUCTO (Actualizada para inputs)
        // ===========================================

        /**
         * Función para añadir una nueva fila de producto a la tabla (usando inputs).
         * @param {string} sku - SKU del producto.
         * @param {string} nombre - Nombre del producto.
         * @param {number} precioUnitario - Precio por unidad.
         * @param {number} cantidad - Cantidad a agregar.
         */
        function agregarProductoATabla(sku, nombre, precioUnitario, cantidad) {
            const totalInicial = precioUnitario * cantidad;
            
            // 1. Crear el elemento de la fila (<tr>)
            const nuevaFila = document.createElement('tr');
            nuevaFila.id = `fila-${sku}`; // ID único de la fila
            
            // 2. Definir el contenido HTML de la fila con inputs
            nuevaFila.innerHTML = `
                <td class="col-sku">${sku}</td>
                <td>${nombre}</td>
                <td class="col-precio">
                    <input type="number" value="${precioUnitario.toFixed(0)}" min="1" step="1" class="input-precio" data-id="${sku}">
                </td>
                <td class="col-cantidad">
                    <input type="number" value="${cantidad}" min="1" class="input-cantidad" data-id="${sku}">
                </td>
                <td class="col-total" id="total-${sku}">${totalInicial.toFixed(0)}</td>
            `;
            
            // 3. Insertar la nueva fila antes de la fila del subtotal
            const filaSubtotal = document.getElementById('fila-resumen');
            cuerpoTablaProductos.insertBefore(nuevaFila, filaSubtotal);

            // 4. Re-inicializar los eventos para incluir los inputs recién creados
            inicializarEventosCalculo(); 
        }

        function buscarProductos(textoBusqueda) {
            const texto = textoBusqueda.toLowerCase().trim();
            
            if (texto.length < 2) {
                resultadosDiv.style.display = 'none';
                return;
            }

            // Filtrar los productos simulados (Lógica de búsqueda en el frontend)
            const resultados = productosSimulados.filter(p => 
                p.nombre.toLowerCase().includes(texto) || p.sku.toLowerCase().includes(texto)
            );
            
            mostrarResultados(resultados);
        }

        /**
         * Muestra los resultados de la búsqueda en el div desplegable.
         * @param {Array<Object>} productos
         */
        function mostrarResultados(productos) {
            resultadosDiv.innerHTML = '';
            
            if (productos.length === 0) {
                resultadosDiv.innerHTML = '<a class="dropdown-item disabled">No se encontraron productos.</a>';
                resultadosDiv.style.display = 'block';
                resultadosDiv.classList.add('show');
                return;
            }

            productos.forEach(producto => {
                const item = document.createElement('a');
                item.classList.add('dropdown-item');
                item.href = '#';
                item.textContent = `${producto.sku} - ${producto.nombre} (${producto.precio.toFixed(2)})`;
                
                // Asignar los datos del producto al elemento para usarlos al hacer clic
                item.dataset.sku = producto.sku;
                item.dataset.nombre = producto.nombre;
                item.dataset.precio = producto.precio;

                // Adjuntar el evento de clic para agregar el producto a la tabla
                item.addEventListener('click', manejarClickProducto);
                
                resultadosDiv.appendChild(item);
            });
            
            resultadosDiv.style.display = 'block';
            resultadosDiv.classList.add('show');
        }

        /**
         * Maneja el evento de clic en un resultado de búsqueda.
         */
        function manejarClickProducto(event) {
            event.preventDefault(); // Evita que el enlace recargue la página
            
            const item = event.currentTarget;
            const sku = item.dataset.sku;
            const nombre = item.dataset.nombre;
            const precio = parseFloat(item.dataset.precio);
            const cantidadInicial = 1; // Siempre agregar con cantidad 1 por defecto

            // Ocultar los resultados de búsqueda
            resultadosDiv.style.display = 'none';
            resultadosDiv.classList.remove('show');
            inputBusqueda.value = ''; // Limpiar el input

            // Llamar a la función que agrega la fila a la tabla (función definida anteriormente)
            agregarProductoATabla(sku, nombre, precio, cantidadInicial);
        }

        
        // --- SIMULACIÓN DE AGREGAR UN NUEVO PRODUCTO DESPUÉS DE LA CARGA ---
        // Esto simularía que el usuario busca y agrega un nuevo producto:
        document.addEventListener('DOMContentLoaded', () => {
            inputBusqueda = document.getElementById('input-busqueda-producto');
            resultadosDiv = document.getElementById('resultados-busqueda');

            // 1. Manejar la búsqueda al escribir
            inputBusqueda.addEventListener('input', (e) => {
                buscarProductos(e.target.value);
            });
            
            // 2. Ocultar el div si se hace clic fuera
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.seccion-busqueda')) {
                    resultadosDiv.style.display = 'none';
                }
            });

            
            // Ejemplo de cómo agregar el producto P002 (Webcam Full HD)
            const productoNuevo = { sku: 'P004', nombre: 'Webcam Full HD', precio: 45 };
            // agregarProductoATabla(productoNuevo.sku, productoNuevo.nombre, productoNuevo.precio, 3);

            inicializarEventosCalculo();
        });
    </script>
@stop