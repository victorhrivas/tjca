<x-laravel-ui-adminlte::adminlte-layout>
  <head>
    <link rel="shortcut icon" href="{{ asset('images/pirca-mini.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&display=swap" rel="stylesheet">
    <title>{{ config('app.name') }} - Bienvenido</title>
    <style>
      /* =========================
         Estilos Globales - Modo Oscuro
      ========================== */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      /* Usamos League Spartan para todos los títulos */
      h1, h2, h3 {
        font-family: 'League Spartan', sans-serif;
        font-weight: 600;
      }
      body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-color: #121212;
        color: #e0e0e0;
        line-height: 1.6;
        padding-top: 70px; /* Altura del navbar */
        padding-bottom: 80px; /* Relleno para que no se tape con el footer fijo */
      }
      a {
        text-decoration: none;
        color: inherit;
      }
      .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
      }

      /* =========================
         Encabezado / Menú Superior
      ========================== */
      header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background-color: #1f1f1f;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        z-index: 999;
      }
      nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 70px;
        padding: 0 2rem;
      }
      .brand {
        display: flex;
        align-items: center;
      }
      .brand-logo {
        height: 50px;
        margin-right: 10px;
      }
      .nav-menu {
        list-style: none;
        display: flex;
        align-items: center;
        gap: 1.5rem;
      }
      .nav-menu li a {
        display: inline-flex;
        align-items: center;
        color: #e0e0e0;
        font-weight: 500;
        transition: color 0.3s;
      }
      .nav-menu li a.login-link {
        color: #64b5f6;
      }
      .nav-menu li a:hover {
        color: #64b5f6;
      }

      /* =========================
         Sección Hero con Fondo Oscuro
      ========================== */
      .hero {
        position: relative;
        background: url("{{ asset('images/welcome/background.jpg') }}") no-repeat center center;
        background-size: cover;
        min-height: 65vh;
        display: flex;
        align-items: center;
        text-align: center;
      }
      .hero::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1;
      }
      .hero .container {
        position: relative;
        z-index: 2;
      }
      .hero-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 2rem;
      }
      .hero-text {
        flex: 1;
        text-align: left;
      }
      .hero-image {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .hero-image img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        margin-left: 20px;
      }
      .hero h1 {
        font-size: 3rem;
        margin-bottom: 20px;
        color: #ffffff;
      }
      .hero p {
        font-size: 1.2rem;
        margin-bottom: 30px;
        color: #ccc;
      }
      .btn-cta {
        background-color: #64b5f6;
        color: #121212;
        padding: 12px 24px;
        border-radius: 5px;
        font-weight: 600;
        transition: background-color 0.3s, color 0.3s;
      }
      .btn-cta:hover {
        background-color: #42a5f5;
        color: #fff;
      }

      /* =========================
         Sección Nosotros
      ========================== */
      .about {
        background-color: #1f1f1f;
        padding: 60px 0;
        text-align: center;
      }
      .about h2 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #64b5f6;
      }
      .about p {
        font-size: 1rem;
        max-width: 800px;
        margin: 0 auto;
        color: #ccc;
      }

      /* =========================
         Sección Soluciones a Medida con Carrusel Simple
      ========================== */
      .custom {
        background-color: #121212;
        padding: 60px 0;
        text-align: center;
      }
      .custom h2 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #64b5f6;
      }
      .custom p {
        font-size: 1rem;
        max-width: 800px;
        margin: 0 auto 30px;
        color: #ccc;
      }
      .carousel-container {
        position: relative;
        width: 100%;
        max-width: 800px;
        margin: 40px auto;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
      }
      .carousel-item {
        display: none;
      }
      .carousel-item.active {
        display: block;
      }
      .carousel-item img {
        width: 100%;
        display: block;
        border-radius: 10px;
      }
      .carousel-controls {
        position: absolute;
        top: 50%;
        width: 100%;
        transform: translateY(-50%);
        display: flex;
        justify-content: space-between;
        padding: 0 15px;
        pointer-events: none;
      }
      .carousel-controls span {
        pointer-events: auto;
        cursor: pointer;
        font-size: 2rem;
        color: #fff;
        user-select: none;
        background: rgba(0, 0, 0, 0.3);
        padding: 5px 10px;
        border-radius: 5px;
      }

      /* =========================
         Sección Planes
      ========================== */
      .plans {
        background-color: #1f1f1f;
        padding: 60px 0;
        text-align: center;
      }
      .plans h2 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #64b5f6;
      }
      .plans-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 40px;
        justify-content: center;
        align-items: flex-start;
      }
      /* Cards de Planes: mostrados lado a lado en escritorio */
      .plan-cards {
        display: flex;
        gap: 20px;
        flex: 1;
        min-width: 300px;
        justify-content: center;
      }
      .plan-card {
        background-color: #1f1f1f;
        border: 1px solid #333;
        border-radius: 5px;
        padding: 20px;
        width: 100%;
        max-width: 600px;
        display: flex;
        gap: 20px;
        text-align: left;
      }
      .plan-left, .plan-right {
        flex: 1;
      }
      .plan-card h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #64b5f6;
      }
      .plan-card p,
      .plan-card ul {
        font-size: 1rem;
        color: #ccc;
      }
      .plan-card ul {
        list-style: disc;
        margin-left: 20px;
      }
      .legend {
        color: #64b5f6;
        font-size: 0.9rem;
        margin-top: 20px;
        text-align: center;
        }
      /* Estilos para montos y precios */
      .amount {
        font-family: 'League Spartan', sans-serif;
        font-size: 2.5rem;
        color: #64b5f6;
        margin: 10px 0;
      }
      .price-list li {
        font-family: 'League Spartan', sans-serif;
        color: #64b5f6;
        font-size: 1rem;
      }
      .features-list li {
        font-size: 1rem;
        color: #ccc;
      }

      /* =========================
         Comparativa
      ========================== */
      .comparison {
        margin-top: 40px;
        overflow-x: auto;
      }
      .comparison-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #121212;
        color: #e0e0e0;
      }
      .comparison-table thead th {
        border: 1px solid #333;
        padding: 10px;
        background-color: #1f1f1f;
      }
      .comparison-table tbody td {
        border: 1px solid #333;
        padding: 10px;
        text-align: center;
      }
      .comparison-table tbody tr:nth-child(even) {
        background-color: #1f1f1f;
      }
      .comparison-table tbody tr:nth-child(odd) {
        background-color: #121212;
      }

      /* =========================
         Sección Final / Llamada a la Acción
      ========================== */
      .final-cta {
        background-color: #121212;
        padding: 40px 0;
        text-align: center;
      }
      .final-cta h2 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #64b5f6;
      }
      .final-cta p {
        font-size: 1.2rem;
        margin-bottom: 30px;
        color: #ccc;
      }
      .final-cta .btn-cta {
        margin-top: 10px;
      }

      /* =========================
         Media Query para dispositivos móviles
      ========================== */
      @media (max-width: 768px) {
        .hero-content {
          flex-direction: column;
          text-align: center;
        }
        .hero-image {
          margin-top: 20px;
          margin-left: 0;
          justify-content: center;
        }
        .plan-card {
          flex-direction: column;
        }
        .plans-wrapper, .plan-cards {
          flex-direction: column;
          gap: 40px;
        }
      }

      /* =========================
         Footer Fijo
      ========================== */
      footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #1f1f1f;
        padding: 20px 0;
        text-align: center;
        font-size: 0.9rem;
        color: #888;
        z-index: 999;
      }
    </style>
  </head>
  <body>
    <!-- Encabezado / Menú Superior -->
    <header>
      <nav>
        <div class="brand">
          <img src="{{ asset('images/pirca-white.png') }}" alt="Pirca Logo" class="brand-logo">
        </div>
        <ul class="nav-menu">
          <li><a href="#">Inicio</a></li>
          <li><a href="#nosotros">Nosotros</a></li>
          <li>
            <a href="{{ route('login') }}" class="login-link" title="Iniciar Sesión">
              <i class="fa fa-sign-in-alt"></i>
            </a>
          </li>
        </ul>
      </nav>
    </header>

    <!-- Sección Hero: Bienvenido a Pirca -->
    <section class="hero">
      <div class="container hero-content">
        <div class="hero-text">
          <h1>¡Bienvenido a {{ config('app.name') }}!</h1>
          <p>El CRM inteligente que potencia tu gestión de clientes y ventas.</p>
        </div>
        <div class="hero-image">
          <img src="{{ asset('images/welcome/sidebar.png') }}" alt="Sidebar">
        </div>
      </div>
    </section>

    <!-- Sección Nosotros: Quiénes somos -->
    <section id="nosotros" class="about">
      <div class="container">
        <h2>¿Quiénes somos?</h2>
        <p>
          Somos un equipo apasionado por la tecnología, dedicado a desarrollar soluciones innovadoras para optimizar la gestión de clientes, inventarios y ventas. Con {{ config('app.name') }}, tendrás un CRM robusto, seguro y fácil de usar, adaptado a las necesidades de tu negocio.
        </p>
      </div>
    </section>

    <!-- Sección Soluciones a Medida con Carrusel Simple -->
    <section id="custom" class="custom">
      <div class="container">
        <h2>Soluciones a Medida</h2>
        <p>
          Además de nuestros planes predefinidos, desarrollamos módulos a pedido para que tu CRM se ajuste exactamente a las necesidades de tu negocio. Contamos con un demo funcional y un equipo de expertos listo para atender tus requerimientos.
        </p>
        <!-- Carrusel de Imágenes Simple -->
        <div class="carousel-container">
          <div class="carousel-item active">
            <img src="{{ asset('images/welcome/dashboard.png') }}" alt="Dashboard">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/welcome/cotizacion.png') }}" alt="Cotización">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/welcome/table.png') }}" alt="Tabla">
          </div>
          <div class="carousel-controls">
            <span class="prev">&#10094;</span>
            <span class="next">&#10095;</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Sección Planes: Nuestros Planes -->
    <section id="planes" class="plans">
      <div class="container">
        <h2>Nuestros Planes</h2>
        <div class="plans-wrapper">
          <!-- Cards de Planes (lado a lado en escritorio) -->
          <div class="plan-cards">
            <!-- Plan Básico -->
            <div class="plan-card">
              <div class="plan-left">
                <h3>Plan Básico</h3>
                <p><strong>Implementación:</strong></p>
                <h1 class="amount">$250.000</h1>
                <p>(pago único)</p>
                <p><strong>Precio mensual por usuario:</strong></p>
                <ul class="price-list">
                  <li>1 a 5 usuarios: $9.990 c/u</li>
                  <li>6 a 10 usuarios: $7.990 c/u</li>
                  <li>Más de 10 usuarios: $5.990 c/u</li>
                </ul>
              </div>
              <div class="plan-right">
                <p><strong>Funcionalidades:</strong></p>
                <ul class="features-list">
                  <li>Gestión básica de clientes</li>
                  <li>Seguimiento de ventas</li>
                  <li>Dashboard general</li>
                  <li>Soporte estándar</li>
                </ul>
              </div>
            </div>
            <!-- Plan Empresa -->
            <div class="plan-card">
              <div class="plan-left">
                <h3>Plan Empresa</h3>
                <p><strong>Implementación:</strong></p>
                <h1 class="amount">$350.000</h1>
                <p>(pago único)</p>
                <p><strong>Precio mensual por usuario:</strong></p>
                <ul class="price-list">
                  <li>1 a 5 usuarios: $11.990 c/u</li>
                  <li>6 a 10 usuarios: $9.990 c/u</li>
                  <li>Más de 10 usuarios: $7.990 c/u</li>
                </ul>
              </div>
              <div class="plan-right">
                <p><strong>Todo lo del plan básico, más:</strong></p>
                <ul class="features-list">
                  <li>Integraciones personalizadas (ERP, Base de Datos cliente)</li>
                  <li>Soporte prioritario</li>
                  <li>Generación formal de cotizaciones</li>
                  <li>Informes avanzados y dashboards gerenciales</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <p class="legend">
            Los módulos a medida se cotizan de forma personalizada, ya que el precio depende de la complejidad y los requerimientos específicos de cada desarrollo.
        </p>

        <div class="comparison">
          <h3>Comparativa de Funcionalidades</h3>
          <table class="comparison-table">
            <thead>
              <tr>
                <th>Funcionalidades</th>
                <th>Plan Básico ✅</th>
                <th>Plan Empresa 🚀</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Gestión básica de clientes</td>
                <td>✅</td>
                <td>✅</td>
              </tr>
              <tr>
                <td>Seguimiento de ventas</td>
                <td>✅</td>
                <td>✅</td>
              </tr>
              <tr>
                <td>Dashboard general</td>
                <td>✅</td>
                <td>✅</td>
              </tr>
              <tr>
                <td>Soporte estándar</td>
                <td>✅</td>
                <td>✅</td>
              </tr>
              <tr>
                <td>Integraciones personalizadas (ERP, BD cliente)</td>
                <td>❌</td>
                <td>✅</td>
              </tr>
              <tr>
                <td>Soporte prioritario</td>
                <td>❌</td>
                <td>✅</td>
              </tr>
              <tr>
                <td>Generación formal de cotizaciones</td>
                <td>❌</td>
                <td>✅</td>
              </tr>
              <tr>
                <td>Informes avanzados y dashboards gerenciales</td>
                <td>❌</td>
                <td>✅</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Sección Final / Llamada a la Acción -->
    <section class="final-cta">
      <div class="container">
        <h2>¿Listo para impulsar tu negocio?</h2>
        <p>Descubre cómo nuestras soluciones pueden transformar tu gestión comercial. No esperes más, contáctanos hoy mismo.</p>
        <a href="#contactModal" class="btn-cta" id="openModalBtnFinal">¡Quiero Saber Más!</a>
      </div>
    </section>

    <!-- Modal de Contacto -->
    <div id="contactModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Información de Contacto</h2>
        <p><strong>Whatsapp:</strong> +569 86453392</p>
        <p><strong>Correo:</strong> vhrivas.c@gmail.com</p>
        <p><strong>LinkedIn:</strong> victorhrivaas</p>
    </div>
    </div>

    <!-- Estilos del Modal Mejorado -->
    <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 100;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background: linear-gradient(135deg, #1f1f1f, #333);
        margin: 10% auto;
        padding: 30px 40px;
        border: 1px solid #444;
        width: 80%;
        max-width: 500px;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
        color: #e0e0e0;
        text-align: center;
        position: relative;
        animation: slideIn 0.4s;
    }

    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-content .close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 28px;
        color: #aaa;
        cursor: pointer;
    }

    .modal-content .close:hover,
    .modal-content .close:focus {
        color: #fff;
    }
    </style>


    <!-- Script para el Modal y Carrusel Simple -->
    <script>
      // Modal
      const modal = document.getElementById("contactModal");
      const btns = document.querySelectorAll("#openModalBtn, #openModalBtnFinal");
      const span = document.querySelector(".modal-content .close");

      btns.forEach(btn => {
        btn.onclick = function() {
          modal.style.display = "block";
        };
      });
      span.onclick = function() {
        modal.style.display = "none";
      };
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      };

      // Carrusel Simple en Soluciones a Medida
      const carouselItems = Array.from(document.querySelectorAll('.carousel-item'));
      const prevBtn = document.querySelector('.carousel-controls .prev');
      const nextBtn = document.querySelector('.carousel-controls .next');
      let currentIndex = 0;
      const totalItems = carouselItems.length;

      function showItem(index) {
        carouselItems.forEach((item, i) => {
          item.classList.toggle('active', i === index);
        });
      }
      if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
          currentIndex = (currentIndex === 0) ? totalItems - 1 : currentIndex - 1;
          showItem(currentIndex);
        });
        nextBtn.addEventListener('click', () => {
          currentIndex = (currentIndex + 1) % totalItems;
          showItem(currentIndex);
        });
      }
      setInterval(() => {
        currentIndex = (currentIndex + 1) % totalItems;
        showItem(currentIndex);
      }, 5000);
    </script>

    <!-- Footer Fijo -->
    <footer>
      <div class="container">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
      </div>
    </footer>
  </body>
</x-laravel-ui-adminlte::adminlte-layout>
