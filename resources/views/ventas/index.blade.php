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
                    <a class="dropdown-item" href="#">Producto 1 ($100)</a>
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
                    <tr id="fila-resumen">
                        <td colspan="4" style="text-align: right; font-weight: bold;">SUBTOTAL:</td>
                        <td class="col-total" style="font-weight: bold;" id="subtotal-general">0</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="columna-secundaria">
            <h2>Resumen de Venta</h2>
    
            <div class="resumen-item">
                <span class="label">Subtotal (Neto):</span>
                <span class="valor" id="resumen-subtotal">0</span>
            </div>
            
            <div class="resumen-item">
                <span class="label">IVA (19%):</span>
                <span class="valor" id="resumen-iva">0</span>
            </div>
            
            <hr>
            
            <div class="resumen-item total-final">
                <span class="label">TOTAL A PAGAR:</span>
                <span class="valor" id="resumen-total">0</span>
            </div>
            
            <hr class="mt-4">

            <div class="opciones-venta">
                <h3>Opciones Adicionales</h3>
                
                <div class="despacho-radiobox mb-3">
                    <label class="d-block mb-2">¿Requiere Despacho?</label>
                    
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="opcionDespacho" id="despachoSi" value="si">
                        <label class="form-check-label" for="despachoSi">Sí</label>
                    </div>
                    
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="opcionDespacho" id="despachoNo" value="no" checked>
                        <label class="form-check-label" for="despachoNo">No</label>
                    </div>
                    
                    <small class="form-text text-muted mt-2">Selecciona si la venta incluye entrega a domicilio.</small>
                     <button id="btn-cliente" class="btn btn-primary btn-lg btn-block mt-4">
                        Agregar Cliente
                    </button>
                </div>
            </div>
            
            <button id="btn-pagar" class="btn btn-primary btn-lg btn-block mt-4">
                PAGAR
            </button>
        </div>
    </div>

    <div class="modal fade" id="modalClienteDespacho" tabindex="-1" role="dialog" aria-labelledby="modalClienteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalClienteLabel">Datos del Cliente para Despacho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-cliente-despacho">
                        
                        <div class="form-group mb-3">
                            <label for="buscarCliente">Buscar Cliente Existente (RUT/Nombre):</label>
                            <input type="text" class="form-control" id="buscarCliente" placeholder="Comienza a escribir para buscar...">
                            <small class="form-text text-muted">Si el cliente no existe, ingresa sus datos a continuación.</small>
                        </div>

                        <hr>
                        
                        <div class="form-group mb-3">
                            <label for="nombreCliente">Nombre Completo *</label>
                            <input type="text" class="form-control" id="nombreCliente" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="rutCliente">RUT/ID Fiscal *</label>
                            <input type="text" class="form-control" id="rutCliente" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="direccionCliente">Dirección de Despacho *</label>
                            <input type="text" class="form-control" id="direccionCliente" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="telefonoCliente">Teléfono</label>
                            <input type="tel" class="form-control" id="telefonoCliente">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarCliente">Guardar Datos</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMetodoPago" tabindex="-1" role="dialog" aria-labelledby="modalMetodoPagoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalMetodoPagoLabel">Seleccionar Método de Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Total a pagar: <strong id="pago-total-display">$0</strong></p>
                    <hr>

                    <div class="form-group">
                        <label>Seleccione el método de pago:</label>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metodoPago" id="pagoEfectivo" value="efectivo" checked>
                            <label class="form-check-label" for="pagoEfectivo">
                                Efectivo 💵
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metodoPago" id="pagoDebito" value="debito">
                            <label class="form-check-label" for="pagoDebito">
                                Tarjeta de Débito 💳
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metodoPago" id="pagoCredito" value="credito">
                            <label class="form-check-label" for="pagoCredito">
                                Tarjeta de Crédito 💳
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metodoPago" id="pagoTransferencia" value="transferencia">
                            <label class="form-check-label" for="pagoTransferencia">
                                Transferencia Bancaria 🏦
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnConfirmarPago">Confirmar Venta</button>
                </div>
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
        .columna-secundaria h3 {
            font-size: 1.1rem;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        #btn-pagar, #btn-cliente {
            width: 100%;
            padding: 10px 15px;
            font-size: 1.25rem;
            font-weight: bold;
        }
        /* Simulación de clases de Bootstrap: d-block, form-check-input, etc. */
        .d-block { display: block; } 
        .form-check-inline { display: inline-block; margin-right: 1rem; }
        .btn-primary { 
            background-color: #007bff; 
            border-color: #007bff; 
            color: white; 
            cursor: pointer;
        }
        .btn-lg { padding: .5rem 1rem; }
    </style>
@stop

@section('js')
    <script>
        let productosEnVenta = []; 

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

            const productoAActualizar = productosEnVenta.find(
                producto => producto.sku === idProducto
            );

            if (productoAActualizar) {
                productoAActualizar.cantidad = cantidad;
                console.log(`Cantidad actualizada para SKU ${idProducto}. Nueva cantidad: ${cantidad}`);
            } else {
                console.warn(`Producto con SKU ${idProducto} no encontrado en el array de ventas.`);
            }

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

        async function buscarProductos(textoBusqueda) {
            const texto = textoBusqueda.toLowerCase().trim();
    
            if (texto.length < 2) {
                resultadosDiv.style.display = 'none';
                resultadosDiv.classList.remove('show');
                return;
            }

            try {
                // Construye la URL con el texto de búsqueda como parámetro
                const url = `/producto/buscar?search=${encodeURIComponent(texto)}`;
                
                // Realiza la petición GET al endpoint de Laravel
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const resultados = await response.json();
                
                mostrarResultados(resultados);

            } catch (error) {
                console.error("Error al buscar productos:", error);
                resultadosDiv.innerHTML = '<a class="dropdown-item disabled text-danger">Error de conexión con el servidor.</a>';
                resultadosDiv.style.display = 'block';
                resultadosDiv.classList.add('show');
            }
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
                item.textContent = `${producto.sku} - ${producto.nombre_producto} (${producto.precio_venta.toFixed(0)})`;
                
                // Asignar los datos del producto al elemento para usarlos al hacer clic
                item.dataset.sku = producto.sku;
                item.dataset.nombre = producto.nombre_producto;
                item.dataset.precio = producto.precio_venta;

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

            const productoExistente = productosEnVenta.find(p => p.sku === sku);

            if (productoExistente) {
                // Si ya existe, incrementamos la cantidad
                productoExistente.cantidad += cantidadInicial;
                // FUTURO: Debes actualizar la fila de la tabla en el DOM aquí.
                console.log(`Producto ${nombre} ya estaba en la lista. Cantidad incrementada.`);
            } else {
                // Si es nuevo, lo agregamos al array
                productosEnVenta.push({
                    sku: sku,
                    nombre: nombre,
                    precio_unitario: precio,
                    cantidad: cantidadInicial
                });
                
                // 2. Llamar a la función que agrega la fila a la tabla (DOM)
                agregarProductoATabla(sku, nombre, precio, cantidadInicial); 
            }

            // Ocultar los resultados de búsqueda
            resultadosDiv.style.display = 'none';
            resultadosDiv.classList.remove('show');
            inputBusqueda.value = ''; // Limpiar el input

            // Llamar a la función que agrega la fila a la tabla (función definida anteriormente)
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

            const btnPagar = document.getElementById('btn-pagar');
            const modalMetodoPago = $('#modalMetodoPago'); 
            const radioDespachoSi = document.getElementById('despachoSi');
            const radioDespachoNo = document.getElementById('despachoNo');

            const btnCliente = document.getElementById('btn-cliente');
            const radiosDespacho = document.getElementsByName('opcionDespacho');
            
            function actualizarBotonCliente() {
                const requiereDespacho = document.getElementById('despachoSi').checked;
                
                if (requiereDespacho) {
                    btnCliente.disabled = false;
                    btnCliente.classList.remove('btn-outline-secondary');
                    btnCliente.classList.add('btn-info');
                } else {
                    btnCliente.disabled = true;
                    btnCliente.classList.remove('btn-info');
                    btnCliente.classList.add('btn-outline-secondary');
                }
            }

            actualizarBotonCliente(); 

            radiosDespacho.forEach(radio => {
                radio.addEventListener('change', (event) => {
                    console.log(`Opción de despacho cambiada a: ${event.target.value}`);
                    actualizarBotonCliente(); // Actualiza el estado del botón
                    
                    // FUTURO: Podrías limpiar los datos de cliente si se cambia a "No"
                });
            });

             // 1. Manejar el click del botón de pago
            btnPagar.addEventListener('click', () => {
                const totalVenta = parseFloat(document.getElementById('resumen-total').textContent) || 0;
        
                if (totalVenta <= 0) {
                    alert('Agregue productos a la venta antes de pagar.');
                    return;
                }

                // 1. Actualizar el total dentro del modal
                document.getElementById('pago-total-display').textContent = `$${totalVenta.toFixed(0)}`;
                
                // 2. Mostrar el modal de métodos de pago (Usando jQuery de Bootstrap 4)
                modalMetodoPago.modal('show');
            });

            const btnConfirmarPago = document.getElementById('btnConfirmarPago');
            btnConfirmarPago.addEventListener('click', async () => {
                // 1. Recolección de Datos Generales de la Venta
                const subtotal = parseFloat(document.getElementById('resumen-subtotal').textContent);
                const iva = parseFloat(document.getElementById('resumen-iva').textContent);
                const total = parseFloat(document.getElementById('resumen-total').textContent);
                
                const requiereDespacho = document.getElementById('despachoSi').checked;
                const metodoPago = document.querySelector('input[name="metodoPago"]:checked').value;
                
                const clienteId = window.clienteDespachoId || null;
                
                // 2. Creación del Objeto de Datos para enviar a Laravel
                const datosVenta = {
                    _token: '{{ csrf_token() }}',
                    subtotal: subtotal,
                    iva: iva,
                    total: total,
                    requiere_despacho: requiereDespacho,
                    tipo_pago: metodoPago,
                    cliente_despacho_id: clienteId,
                    items: productosEnVenta
                };

                if (productosEnVenta.length === 0) {
                    alert('No hay productos para vender.');
                    modalMetodoPago.modal('hide');
                    return;
                }

                // 3. Petición AJAX (Fetch) al Servidor
                try {
                    const response = await fetch('/venta/guardar', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/pdf, application/json' // Aceptamos PDF o JSON
                        },
                        body: JSON.stringify(datosVenta)
                    });

                    if (response.ok) {
                        const contentType = response.headers.get("content-type");
                        if (contentType && contentType.includes("application/pdf")) {
                            // Si la respuesta es un PDF, lo abrimos para imprimir
                            const blob = await response.blob();
                            const pdfUrl = URL.createObjectURL(blob);
                            window.open(pdfUrl, '_blank');
                            
                            // Cerramos modal y recargamos
                            modalMetodoPago.modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        } else {
                            // Si es otro tipo de respuesta (ej. JSON), la procesamos
                            const resultado = await response.json();
                            alert('Venta registrada exitosamente!');
                            console.log('Respuesta del servidor:', resultado);
                            modalMetodoPago.modal('hide');
                            location.reload();
                        }
                    } else {
                        // Manejar errores de validación o del servidor (que devuelven JSON)
                        const resultado = await response.json();
                        console.error('Error del Servidor:', resultado);
                        alert('Error al guardar la venta: ' + (resultado.message || 'Verifique los datos.'));
                    }

                } catch (error) {
                    console.error('Error de conexión:', error);
                    alert('Error de conexión con el servidor. Intente nuevamente.');
                }
            });
            
            const btnGuardarCliente = document.getElementById('btnGuardarCliente');
                btnGuardarCliente.addEventListener('click', () => {
                    const nombre = document.getElementById('nombreCliente').value;
                    const direccion = document.getElementById('direccionCliente').value;
                    
                    if (nombre && direccion) {
                        alert(`Datos de cliente guardados para despacho. Nombre: ${nombre}, Dirección: ${direccion}`);
                        // Aquí iría la lógica para guardar en la BD o en una variable JS
                        
                        // Ocultar el modal (requiere JQuery o la función de Bootstrap)
                        $('#modalClienteDespacho').modal('hide');
                    } else {
                        alert('Por favor, complete el nombre y la dirección.');
                    }
                });

            // 2. Manejar el cambio en la opción de despacho (útil para futuras funciones como agregar costo de despacho)
            radiosDespacho.forEach(radio => {
                radio.addEventListener('change', (event) => {
                    console.log(`Opción de despacho cambiada a: ${event.target.value}`);
                    // FUTURO: Si el despacho tiene un costo fijo, lo agregarías aquí y llamarías a recalcularSubtotalGeneral();
                });
            });
        });

        $(document).ready(function() {
            $('#btn-cliente').on('click', function(e) {
                e.preventDefault(); 
                
                // Solo mostramos el modal si el botón NO está deshabilitado
                if (!$(this).prop('disabled')) {
                    $('#modalClienteDespacho').modal('show');
                }
            });
        });
    </script>
@stop