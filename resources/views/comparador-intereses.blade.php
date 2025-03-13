<?php
// Iniciar sesión para mantener los valores entre solicitudes
session_start();

// Establecer valores predeterminados desde las variables de Laravel
$capital = $capitalTotal ?? 5000; // Capital original desde Laravel
$tasaBanco = $tasaInteresBanco ?? 69.0;
$tasaDigitt = $tasaInteresKaaxClub ?? 33.0;
$nombreBanco = $nombreBanco ?? 'BBVA Bancomer';
$colorBanco = '#FF5A45'; // Rojo del banco
$colorCapitalBanco = '#162E4A'; // Azul oscuro para BBVA
$colorDigitt = '#4E7DFF'; // Azul de Digitt
$colorFondoDigitt = '#E9FFDB'; // Fondo verde claro
$interesesBanco = $interesesBanco ?? 0;
$interesesKaaxClub = $interesesKaaxClub ?? 0;
$plazo = $plazo ?? 12;

// Procesar cambios en el formulario si se han enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $capital = isset($_POST['capital']) ? floatval($_POST['capital']) : $capital;
    $tasaBanco = isset($_POST['tasaBanco']) ? floatval($_POST['tasaBanco']) : $tasaBanco;
    $tasaDigitt = isset($_POST['tasaDigitt']) ? floatval($_POST['tasaDigitt']) : $tasaDigitt;
    $nombreBanco = isset($_POST['nombreBanco']) ? $_POST['nombreBanco'] : $nombreBanco;
    
    // Guardar en sesión
    $_SESSION['capital'] = $capital;
    $_SESSION['tasaBanco'] = $tasaBanco;
    $_SESSION['tasaDigitt'] = $tasaDigitt;
    $_SESSION['nombreBanco'] = $nombreBanco;
}

// Función para formatear números en estilo mexicano
function formatoMoneda($numero) {
    return number_format($numero, 2, '.', ',');
}

// Función para generar ID único para almacenamiento local
function generarID() {
    return uniqid('comparador_');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador de Intereses</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos adicionales para mejorar la experiencia visual */
        .barra-container {
            transition: all 0.3s ease-in-out;
        }
        .input-animado {
            transition: all 0.2s;
        }
        .input-animado:focus {
            transform: scale(1.02);
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.5);
        }
        .actualizar-btn {
            transition: all 0.3s;
        }
        .actualizar-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">
    <!-- Mensaje de instrucciones -->
   
    
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <!-- Banner de ahorro -->
                        <div class="bg-light p-3 rounded mb-4 text-center" id="bannerAhorro">
                            <!-- Será actualizado por JavaScript -->
                        </div>

                        <!-- Formulario para editar variables -->
                        <div class="bg-light p-3 rounded mb-4" style="display: none">
                            <h5 class="fw-bold mb-3">Editar Variables:</h5>
                            <form id="comparadorForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Capital ($):</label>
                                        <input 
                                            type="number" 
                                            id="capital" 
                                            name="capital" 
                                            value="<?php echo $capital; ?>" 
                                            class="form-control input-animado"
                                            step="100"
                                        >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tasa Banco (%):</label>
                                        <input 
                                            type="number" 
                                            id="tasaBanco" 
                                            name="tasaBanco" 
                                            value="<?php echo $tasaBanco; ?>" 
                                            class="form-control input-animado"
                                            step="0.1"
                                        >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tasa Digitt (%):</label>
                                        <input 
                                            type="number" 
                                            id="tasaDigitt" 
                                            name="tasaDigitt" 
                                            value="<?php echo $tasaDigitt; ?>" 
                                            class="form-control input-animado"
                                            step="0.1"
                                        >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre del Banco:</label>
                                        <input 
                                            type="text" 
                                            id="nombreBanco" 
                                            name="nombreBanco" 
                                            value="<?php echo htmlspecialchars($nombreBanco); ?>" 
                                            class="form-control input-animado"
                                        >
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-primary actualizar-btn" id="actualizarBtn">
                                        Actualizar
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Sección de intereses -->
                        <div class="row mb-4" id="seccionIntereses">
                            <!-- Será actualizado por JavaScript -->
                        </div>

                        <!-- Gráficas de comparación -->
                        <div class="row align-items-end" id="graficasComparacion">
                            <!-- Será actualizado por JavaScript -->
                        </div>
                        
                       

                        <!-- Línea divisoria -->
                        <hr class="my-4">
                        <div class="text-center">
                            <small>El ahorro real depende del monto exacto de tu deuda. Lo conoceras antes de firmar</small>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="plazo-maximo" value="<?php echo $plazo; ?>">
    <input type="hidden" id="intereses-banco-inicial" value="<?php echo $interesesBanco; ?>">
    <input type="hidden" id="intereses-kaaxclub-inicial" value="<?php echo $interesesKaaxClub; ?>">
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para manejar la actualización dinámica de gráficas -->
    <script>
        // Configuración de colores
        const colorBanco = '<?php echo $colorBanco; ?>';
        const colorCapitalBanco = '<?php echo $colorCapitalBanco; ?>';
        const colorDigitt = '<?php echo $colorDigitt; ?>';
        const colorFondoDigitt = '<?php echo $colorFondoDigitt; ?>';
        
        // Función para formatear moneda
        function formatoMoneda(numero) {
            return new Intl.NumberFormat('es-MX', { 
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(numero);
        }
        
        // Función para actualizar todas las gráficas y datos
        function actualizarGraficas() {
            // Obtenemos los valores actuales
            const capital = parseFloat(document.getElementById('capital').value);
            const tasaBanco = parseFloat(document.getElementById('tasaBanco').value);
            const tasaDigitt = parseFloat(document.getElementById('tasaDigitt').value);
            const nombreBanco = document.getElementById('nombreBanco').value;
            const plazoMaximo = parseInt(document.getElementById('plazo-maximo').value);
            
            // Calculamos los intereses usando la misma lógica que en Laravel
            
            const interesesBanco = parseFloat(document.getElementById('intereses-banco-inicial').value);
            // Calcular intereses para Kaaxclub
            const interesesDigitt = parseFloat(document.getElementById('intereses-kaaxclub-inicial').value);
            // Para mostrar los intereses calculados inicialmente por Laravel
            const interesesBancoInicial = parseFloat(document.getElementById('intereses-banco-inicial').value);
            const interesesKaaxclubInicial = parseFloat(document.getElementById('intereses-kaaxclub-inicial').value);
            // Usamos los valores calculados por Laravel si es la primera carga y están disponibles
            const ahorro = parseFloat((interesesBanco - interesesDigitt).toFixed(2));
            const porcentajeAhorro = parseFloat(((ahorro / interesesBanco) * 100).toFixed(2));
            
            // Cálculo de alturas para visualización
            const maxAltura = Math.max(capital + interesesBanco, capital + interesesDigitt);
            const escala = 180 / maxAltura; // Usamos 180px como altura máxima disponible para escalar
            
            const alturaCapital = capital * escala;
            const alturaInteresBanco = interesesBanco * escala;
            const alturaInteresDigitt = interesesDigitt * escala;
            
            // Altura total de cada barra
            const alturaTotalBanco = alturaCapital + alturaInteresBanco;
            const alturaTotalDigitt = alturaCapital + alturaInteresDigitt;
            
            // Actualizar banner de ahorro
            document.getElementById('bannerAhorro').innerHTML = `
                <h2 class="fw-bold">
                    Ahorra <span class="text-primary">$${formatoMoneda(ahorro)}</span> (${porcentajeAhorro}%)
                </h2>
                <p class="text-secondary">al transferir tu deuda de tarjetas a Kaaxclub 😊
                <br> Calculando para $${formatoMoneda(capital)} a ${plazoMaximo} meses      
                </p>
            `;
            
            // Actualizar sección de intereses
            document.getElementById('seccionIntereses').innerHTML = `
                <div class="col-6 text-center">
                    <span class="fw-semibold">Intereses</span>
                    <br>
                    <span class="fs-5 fw-bold text-danger">$${formatoMoneda(interesesBanco)}</span>
                    <br>
                    <span class="small">Tasa ${tasaBanco}%</span>
                </div>
                <div class="col-6 text-center">
                    <span class="fw-semibold">Intereses</span>
                    <br><span class="fs-5 fw-bold text-primary">$${formatoMoneda(interesesDigitt)}</span>
                    <br><span class="small">Tasa ${tasaDigitt}%</span>
                </div>
            `;
            
            // Actualizar gráficas de comparación
            document.getElementById('graficasComparacion').innerHTML = `
                <!-- Barra del banco -->
                <div class="col-4 col-md-3 mx-auto text-center">
                   
                    
                    <div class="barra-container position-relative rounded overflow-hidden shadow" style="height: ${alturaTotalBanco}px">
                        <!-- Componente de interés (parte superior) -->
                        <div 
                            class="position-absolute top-0 w-100" 
                            style="
                                background-color: ${colorBanco};
                                height: ${alturaInteresBanco}px
                            "
                        ></div>
                        <!-- Componente de capital (parte inferior) -->
                        <div 
                            class="position-absolute bottom-0 w-100" 
                            style="
                                background-color: ${colorCapitalBanco};
                                height: ${alturaCapital}px
                            "
                        >
                            <div class="h-100 d-flex align-items-center justify-content-center text-white">
                                <p class="fw-bold small m-0">${nombreBanco}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Barra de Digitt -->
                <div class="col-4 col-md-3 mx-auto text-center">
                   
                    
                    <div class="barra-container position-relative rounded overflow-hidden shadow" style="height: ${alturaTotalDigitt}px">
                        <!-- Componente de interés (parte superior) -->
                        <div 
                            class="position-absolute top-0 w-100" 
                            style="
                                background-color: ${colorFondoDigitt};
                                height: ${alturaInteresDigitt}px
                            "
                        ></div>
                        <!-- Componente de capital (parte inferior) -->
                        <div 
                            class="position-absolute bottom-0 w-100" 
                            style="
                                background-color: ${colorDigitt};
                                height: ${alturaCapital}px
                            "
                        >
                            <div class="h-100 d-flex align-items-center justify-content-center text-white">
                                <p class="fw-bold small m-0">Kaaxclub</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            
            
            // Guardar en sesión mediante AJAX (opcional)
            guardarEnSesion(capital, tasaBanco, tasaDigitt, nombreBanco);
        }
        
        // Función para guardar los datos en la sesión PHP mediante AJAX
        function guardarEnSesion(capital, tasaBanco, tasaDigitt, nombreBanco) {
            // Crear objeto FormData para enviar datos
            const formData = new FormData();
            formData.append('capital', capital);
            formData.append('tasaBanco', tasaBanco);
            formData.append('tasaDigitt', tasaDigitt);
            formData.append('nombreBanco', nombreBanco);
            
            // Realizar petición AJAX
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            }).catch(error => console.error('Error al guardar en sesión:', error));
        }
        
        // Eventos para actualizar en tiempo real
        document.getElementById('capital').addEventListener('input', actualizarGraficas);
        document.getElementById('tasaBanco').addEventListener('input', actualizarGraficas);
        document.getElementById('tasaDigitt').addEventListener('input', actualizarGraficas);
        document.getElementById('nombreBanco').addEventListener('input', actualizarGraficas);
        document.getElementById('actualizarBtn').addEventListener('click', actualizarGraficas);
        
        // Inicializar la visualización al cargar la página
        document.addEventListener('DOMContentLoaded', actualizarGraficas);
    </script>
</body>
</html>