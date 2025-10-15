<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSIm | Tu Punto de Venta Inteligente</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJc5fU2F6qj6vLpX8vG5gq1j4y7I9g/g3+p9I/c0eS0gX19fA449+zR8+8wBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        /* Estilos personalizados amigables */
        :root {
            --bs-primary: #007bff; /* Azul primario de Bootstrap */
            --posim-green: #28a745; /* Verde para destacar */
        }
        .hero-section {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 100px 0;
            min-height: 80vh;
        }
        .feature-icon {
            font-size: 2.5rem;
            color: var(--posim-green);
        }
        .cta-section {
            background-color: var(--bs-primary);
            color: white;
            padding: 60px 0;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--posim-green) !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-cash-register me-2"></i> POSIm
            </a>
            <div class="d-none d-lg-block">
                <div class="d-flex justify-content-end">
                    @if (Route::has('login'))
                        <nav class="d-flex gap-2">
                            @auth
                                {{-- Si está autenticado, muestra el Dashboard --}}
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="btn btn-sm btn-outline-success"
                                >
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            @else
                                {{-- Si NO está autenticado, muestra Login y Register --}}
                                <a
                                    href="{{ route('login') }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 mx-auto">
                    <h1 class="display-3 fw-bold text-dark mb-4">
                        El Punto de Venta <span class="text-primary">Inteligente</span>
                    </h1>
                    <p class="lead mb-5 text-secondary">
                        POSIm es la solución intuitiva que te permite gestionar ventas, inventario y clientes de forma rápida y eficiente, ¡desde cualquier lugar!
                    </p>
                    
                    @if (!auth()->check()) {{-- Muestra solo si no estás logueado --}}
                    <a href="{{ route('register') }}" class="btn btn-lg btn-success shadow-lg me-3">
                        <i class="fas fa-arrow-right-to-bracket me-2"></i> Comienza Gratis Hoy
                    </a>
                    @endif
                    <a href="#features" class="btn btn-lg btn-outline-secondary">
                        Descubre Más
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Optimiza tu Operación Diaria</h2>
            
            <div class="row text-center">
                
                <div class="col-md-4 mb-4">
                    <i class="fas fa-hand-holding-usd feature-icon mb-3"></i>
                    <h3 class="h4 fw-bold">Ventas Ágiles y Detalladas</h3>
                    <p class="text-muted">Procesa transacciones en segundos, acepta múltiples métodos de pago y emite boletas en PDF automáticamente.</p>
                </div>
                
                <div class="col-md-4 mb-4">
                    <i class="fas fa-box-open feature-icon mb-3"></i>
                    <h3 class="h4 fw-bold">Control de Inventario Preciso</h3>
                    <p class="text-muted">Mantén el stock actualizado en tiempo real. Gestiona SKU, precios y tipos de producto sin complicaciones.</p>
                </div>
                
                <div class="col-md-4 mb-4">
                    <i class="fas fa-shipping-fast feature-icon mb-3"></i>
                    <h3 class="h4 fw-bold">Gestión de Clientes y Envíos</h3>
                    <p class="text-muted">Registra clientes de despacho y enlaza cada venta. La información de envío queda guardada de forma segura.</p>
                </div>

            </div>
            
            <div class="text-center mt-4">
                <p class="text-primary fw-bold">¡Todo lo que tu negocio necesita en una sola plataforma!</p>
            </div>
        </div>
    </section>

    <section class="cta-section text-center">
        <div class="container">
            <h2 class="fw-bold mb-3">¿Listo para Impulsar tu Negocio?</h2>
            <p class="lead mb-4">Regístrate ahora y transforma la manera en que gestionas tus ventas.</p>
            
            <a href="{{ route('register') }}" class="btn btn-lg btn-light fw-bold shadow-lg">
                ¡Empieza Ahora!
            </a>
        </div>
    </section>

    <footer class="bg-dark text-white-50 py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} POSIm. Todos los derechos reservados.</p>
            <small>Desarrollado con Laravel y Bootstrap 5.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9fTQoBfH79j+A4uK8z0XzJqJ4yvI" crossorigin="anonymous"></script>
</body>
</html>