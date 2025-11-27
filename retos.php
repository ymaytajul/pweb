<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

// Función para actualizar o insertar puntos
function completarReto($conn, $user_id, $nivel, $points) {
    $stmt = $conn->prepare("SELECT puntos_totales FROM ranking_usuarios WHERE usuario_id=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $stmt->store_result();
    
    if($stmt->num_rows > 0){
        $stmt->bind_result($puntos_actuales);
        $stmt->fetch();
        $puntos_totales = $puntos_actuales + $points;

        $update = $conn->prepare("UPDATE ranking_usuarios SET puntos_totales=? WHERE usuario_id=?");
        $update->bind_param("ii",$puntos_totales,$user_id);
        $update->execute();
        $update->close();
    } else {
        $insert = $conn->prepare("INSERT INTO ranking_usuarios (usuario_id, puntos_totales) VALUES (?,?)");
        $insert->bind_param("ii",$user_id,$points);
        $insert->execute();
        $insert->close();
    }
    $stmt->close();
}

// Obtener estadísticas del usuario
$user_id = $_SESSION['user_id'];
$stats_query = $conn->query("
    SELECT 
        (SELECT COUNT(*) FROM retos_completados WHERE user_id = $user_id AND nivel = 'basico') as basico_completados,
        (SELECT COUNT(*) FROM retos_completados WHERE user_id = $user_id AND nivel = 'intermedio') as intermedio_completados,
        (SELECT COUNT(*) FROM retos_completados WHERE user_id = $user_id AND nivel = 'avanzado') as avanzado_completados,
        (SELECT SUM(puntos) FROM retos_completados WHERE user_id = $user_id) as puntos_totales
");
$stats = $stats_query->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Retos | SQL Learning</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
    --primary: #667eea;
    --primary-dark: #5a6fd8;
    --secondary: #764ba2;
    --accent: #ff416c;
    --success: #28a745;
    --warning: #ffc107;
    --danger: #dc3545;
    --light: #f8f9fa;
    --dark: #2d3436;
    --gray: #6c757d;
    --border-radius: 16px;
    --shadow: 0 10px 30px rgba(0,0,0,0.1);
    --transition: all 0.3s ease;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    min-height: 100vh;
    padding: 20px;
    line-height: 1.6;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
}

/* Header */
.header {
    text-align: center;
    margin-bottom: 30px;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(255,255,255,0.2);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    transition: var(--transition);
    margin-bottom: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
}

.back-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-2px);
}

h1 {
    font-size: 2.8rem;
    margin-bottom: 10px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
}

/* Navigation */
nav {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.nav-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: white;
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
    border-radius: 50px;
    transition: var(--transition);
    box-shadow: var(--shadow);
}

.nav-btn:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

/* Stats Section */
.stats-section {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    border-radius: var(--border-radius);
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(255,255,255,0.2);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    text-align: center;
}

.stat-card {
    background: rgba(255,255,255,0.1);
    padding: 20px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.1);
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: var(--warning);
    display: block;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

/* Level Selection */
.level-section {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    border-radius: var(--border-radius);
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(255,255,255,0.2);
    text-align: center;
}

.level-title {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: var(--warning);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.level-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.level-card {
    background: rgba(255,255,255,0.15);
    padding: 25px;
    border-radius: 12px;
    text-decoration: none;
    color: white;
    transition: var(--transition);
    border: 2px solid transparent;
}

.level-card:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-5px);
    border-color: var(--warning);
}

.level-card h3 {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    color: var(--warning);
}

.level-card.basico { border-left: 5px solid #28a745; }
.level-card.intermedio { border-left: 5px solid #ffc107; }
.level-card.avanzado { border-left: 5px solid #dc3545; }

.points-badge {
    display: inline-block;
    background: var(--accent);
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: bold;
    margin-top: 8px;
}

/* Challenge Section */
.challenge-section {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    border-radius: var(--border-radius);
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(255,255,255,0.2);
}

.challenge-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 15px;
}

.challenge-title {
    font-size: 1.4rem;
    color: var(--warning);
    display: flex;
    align-items: center;
    gap: 10px;
}

.level-badge {
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: bold;
}

.basico-badge { background: #28a745; }
.intermedio-badge { background: #ffc107; color: var(--dark); }
.avanzado-badge { background: #dc3545; }

.question-card {
    background: rgba(255,255,255,0.15);
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 25px;
    border-left: 4px solid var(--warning);
}

.question-text {
    font-size: 1.2rem;
    line-height: 1.6;
    font-weight: 600;
}

/* Word Bank & Drop Zone */
.word-bank, .drop-zone {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 12px;
    margin: 25px 0;
    min-height: 80px;
    padding: 20px;
    border-radius: 12px;
    transition: var(--transition);
}

.word-bank {
    background: rgba(255,255,255,0.1);
    border: 2px dashed rgba(255,255,255,0.3);
}

.drop-zone {
    background: rgba(255,255,255,0.05);
    border: 2px dashed rgba(255,255,255,0.5);
    min-height: 100px;
    align-items: center;
}

.word {
    background: var(--accent);
    color: white;
    padding: 12px 18px;
    border-radius: 10px;
    cursor: grab;
    user-select: none;
    font-weight: bold;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(255, 65, 108, 0.3);
}

.word:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(255, 65, 108, 0.4);
}

.word:active {
    cursor: grabbing;
}

/* States */
.correct {
    background: rgba(40, 167, 69, 0.3) !important;
    border-color: var(--success) !important;
}

.incorrect {
    background: rgba(220, 53, 69, 0.3) !important;
    border-color: var(--danger) !important;
}

/* Buttons */
.actions {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin: 25px 0;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 15px 30px;
    border: none;
    border-radius: 50px;
    font-weight: bold;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    font-size: 1rem;
}

.btn-primary {
    background: var(--primary);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 1px solid rgba(255,255,255,0.3);
}

.btn-secondary:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-3px);
}

/* Result */
.result {
    text-align: center;
    padding: 20px;
    border-radius: 12px;
    margin: 20px 0;
    font-weight: bold;
    font-size: 1.1rem;
    transition: var(--transition);
}

.result-success {
    background: rgba(40, 167, 69, 0.2);
    border: 2px solid var(--success);
    color: var(--success);
}

.result-error {
    background: rgba(220, 53, 69, 0.2);
    border: 2px solid var(--danger);
    color: var(--danger);
}

/* Points Animation */
@keyframes pointsPop {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.5); opacity: 0.7; }
    100% { transform: scale(1); opacity: 0; }
}

.points-animation {
    position: fixed;
    font-size: 2rem;
    font-weight: bold;
    color: var(--warning);
    pointer-events: none;
    animation: pointsPop 1s ease-out forwards;
    z-index: 1000;
}

/* Instructions */
.instructions {
    text-align: center;
    margin: 15px 0;
    opacity: 0.9;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .level-cards {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .challenge-header {
        flex-direction: column;
        text-align: center;
    }
    
    h1 {
        font-size: 2.2rem;
    }
    
    .actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="dashboard.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Volver al Panel
            </a>
            <h1><i class="fas fa-brain"></i> Retos de SQL</h1>
            <p class="subtitle">Pon a prueba tus conocimientos y gana puntos</p>
        </div>

        <nav>
            <a href="course/course.php" class="nav-btn"><i class="fas fa-graduation-cap"></i> Cursos</a>
            <a href="books.php" class="nav-btn"><i class="fas fa-book"></i> Biblioteca</a>
            <a href="ranking.php" class="nav-btn"><i class="fas fa-trophy"></i> Ranking</a>
            <a href="profile/index.php" class="nav-btn"><i class="fas fa-user"></i> Perfil</a>
        </nav>

        <!-- Estadísticas -->
        <section class="stats-section">
            <h2 class="level-title"><i class="fas fa-chart-line"></i> Tu Progreso</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-number"><?= $stats['basico_completados'] ?? 0 ?></span>
                    <span class="stat-label">Retos Básicos</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number"><?= $stats['intermedio_completados'] ?? 0 ?></span>
                    <span class="stat-label">Retos Intermedios</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number"><?= $stats['avanzado_completados'] ?? 0 ?></span>
                    <span class="stat-label">Retos Avanzados</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number"><?= $stats['puntos_totales'] ?? 0 ?></span>
                    <span class="stat-label">Puntos Totales</span>
                </div>
            </div>
        </section>

        <?php
        $nivel = $_GET['nivel'] ?? null;

        if(!$nivel): ?>
        <!-- Selección de Nivel -->
        <section class="level-section">
            <h2 class="level-title"><i class="fas fa-layer-group"></i> Selecciona tu Nivel</h2>
            <div class="level-cards">
                <a href="retos.php?nivel=basico" class="level-card basico">
                    <h3><i class="fas fa-seedling"></i> Básico</h3>
                    <p>Consultas SELECT simples, WHERE básico</p>
                    <div class="points-badge">10 puntos</div>
                </a>
                <a href="retos.php?nivel=intermedio" class="level-card intermedio">
                    <h3><i class="fas fa-tree"></i> Intermedio</h3>
                    <p>WHERE complejo, ORDER BY, DISTINCT</p>
                    <div class="points-badge">25 puntos</div>
                </a>
                <a href="retos.php?nivel=avanzado" class="level-card avanzado">
                    <h3><i class="fas fa-mountain"></i> Avanzado</h3>
                    <p>JOINs, GROUP BY, subconsultas complejas</p>
                    <div class="points-badge">50 puntos</div>
                </a>
            </div>
        </section>

        <?php else: 
        // Retos por nivel
        $retos_basico = [
            ["pregunta"=>"Muestra todos los datos de la tabla usuarios.","respuesta"=>"SELECT * FROM usuarios;"],
            ["pregunta"=>"Muestra todos los datos de la tabla cursos.","respuesta"=>"SELECT * FROM cursos;"],
            ["pregunta"=>"Muestra solo la columna nombre de la tabla usuarios.","respuesta"=>"SELECT nombre FROM usuarios;"],
            ["pregunta"=>"Muestra los correos de todos los usuarios.","respuesta"=>"SELECT correo FROM usuarios;"]
        ];

        $retos_intermedio = [
            ["pregunta"=>"Muestra los nombres y correos de los usuarios activos.","respuesta"=>"SELECT nombre, correo FROM usuarios WHERE estado = 'activo';"],
            ["pregunta"=>"Muestra los productos con precio mayor a 100.","respuesta"=>"SELECT * FROM productos WHERE precio > 100;"],
            ["pregunta"=>"Selecciona los nombres de usuarios ordenados alfabéticamente.","respuesta"=>"SELECT nombre FROM usuarios ORDER BY nombre ASC;"],
            ["pregunta"=>"Selecciona los nombres distintos de los cursos.","respuesta"=>"SELECT DISTINCT nombre FROM cursos;"]
        ];

        $retos_avanzado = [
            ["pregunta"=>"Une las tablas pedidos y clientes para mostrar el nombre del cliente con cada pedido.","respuesta"=>"SELECT p.*, c.nombre FROM pedidos p JOIN clientes c ON p.cliente_id = c.id;"],
            ["pregunta"=>"Agrupa los productos por categoría y muestra el precio promedio.","respuesta"=>"SELECT categoria, AVG(precio) FROM productos GROUP BY categoria;"],
            ["pregunta"=>"Encuentra los empleados con salario mayor al promedio.","respuesta"=>"SELECT * FROM empleados WHERE salario > (SELECT AVG(salario) FROM empleados);"],
            ["pregunta"=>"Muestra los 5 productos más caros.","respuesta"=>"SELECT * FROM productos ORDER BY precio DESC LIMIT 5;"]
        ];

        $retos = match($nivel) {
            'basico' => $retos_basico,
            'intermedio' => $retos_intermedio,
            'avanzado' => $retos_avanzado,
            default => $retos_basico
        };

        $puntos_por_nivel = [
            'basico' => 10,
            'intermedio' => 25,
            'avanzado' => 50
        ];

        $reto = $retos[array_rand($retos)];
        $pregunta = $reto["pregunta"];
        $respuesta_correcta = $reto["respuesta"];
        $palabras = preg_split('/\s+/', str_replace([",", ";", "(", ")"], " ; ", $respuesta_correcta));
        $palabras = array_filter($palabras);
        shuffle($palabras);
        $json_palabras = json_encode($palabras, JSON_UNESCAPED_UNICODE);
        $json_respuesta = json_encode($respuesta_correcta, JSON_UNESCAPED_UNICODE);
        ?>

        <!-- Sección del Reto -->
        <section class="challenge-section">
            <div class="challenge-header">
                <h2 class="challenge-title"><i class="fas fa-puzzle-piece"></i> Reto Actual</h2>
                <span class="level-badge <?= $nivel ?>-badge">
                    Nivel: <?= ucfirst($nivel) ?> - <?= $puntos_por_nivel[$nivel] ?> puntos
                </span>
            </div>

            <div class="question-card">
                <p class="question-text"><?= $pregunta ?></p>
            </div>

            <p class="instructions">
                <i class="fas fa-lightbulb"></i> Arrastra las palabras para formar la consulta SQL correcta
            </p>
            
            <div class="word-bank" id="wordBank"></div>
            <div class="drop-zone" id="dropZone">
                <span style="opacity:0.7;">Suelta las palabras aquí...</span>
            </div>

            <div class="actions">
                <button class="btn btn-primary" id="validar">
                    <i class="fas fa-check"></i> Validar Respuesta
                </button>
                <button class="btn btn-secondary" id="nuevo">
                    <i class="fas fa-redo"></i> Nuevo Reto
                </button>
                <a href="retos.php" class="btn btn-secondary">
                    <i class="fas fa-exchange-alt"></i> Cambiar Nivel
                </a>
            </div>

            <div id="resultado"></div>
        </section>

        <script>
        const palabras = <?php echo $json_palabras; ?>;
        const respuestaCorrectaRaw = <?php echo $json_respuesta; ?>;
        const nivel = '<?php echo $nivel; ?>';
        const puntos = <?php echo $puntos_por_nivel[$nivel]; ?>;
        const banco = document.getElementById('wordBank');
        const zona = document.getElementById('dropZone');
        const resultadoEl = document.getElementById('resultado');

        function normalizar(str) {
            return str ? String(str).replace(/\s+/g, ' ').trim().replace(/\s+([,;:\.\)\?\!])/g, '$1').replace(/(\()\s+/g, '$1').toUpperCase() : '';
        }

        function crearElementoPalabra(texto) {
            const div = document.createElement('div');
            div.className = 'word';
            div.draggable = true;
            div.textContent = texto;
            div.addEventListener('dragstart', e => {
                e.dataTransfer.setData('text/plain', texto);
                div.style.opacity = '0.5';
            });
            div.addEventListener('dragend', () => {
                div.style.opacity = '1';
            });
            div.addEventListener('click', () => {
                zona.appendChild(div);
                actualizarEstado();
            });
            return div;
        }

        function actualizarEstado() {
            const palabrasEnZona = zona.querySelectorAll('.word');
            if (palabrasEnZona.length > 0) {
                zona.querySelector('span').style.display = 'none';
            } else {
                zona.querySelector('span').style.display = 'block';
            }
        }

        // Inicializar palabras
        palabras.forEach(token => {
            banco.appendChild(crearElementoPalabra(token));
        });

        // Configurar zonas de drop
        [banco, zona].forEach(el => {
            el.addEventListener('dragover', e => {
                e.preventDefault();
                el.style.background = 'rgba(255,255,255,0.1)';
            });
            
            el.addEventListener('dragleave', () => {
                el.style.background = '';
            });
            
            el.addEventListener('drop', e => {
                e.preventDefault();
                el.style.background = '';
                const texto = e.dataTransfer.getData('text/plain');
                const palabra = Array.from(banco.querySelectorAll('.word')).find(w => w.textContent === texto) ||
                               Array.from(zona.querySelectorAll('.word')).find(w => w.textContent === texto);
                if (palabra) {
                    el.appendChild(palabra);
                    actualizarEstado();
                }
            });
        });

        // Validar respuesta
        document.getElementById('validar').addEventListener('click', () => {
            let respuestaUsuario = '';
            zona.querySelectorAll('.word').forEach(w => respuestaUsuario += w.textContent + ' ');
            respuestaUsuario = respuestaUsuario.replace(/\s+/g, ' ').trim();
            
            const userNorm = normalizar(respuestaUsuario);
            const correctNorm = normalizar(respuestaCorrectaRaw);
            
            zona.classList.remove('correct', 'incorrect');
            resultadoEl.className = 'result';

            if (userNorm === correctNorm) {
                resultadoEl.innerHTML = '<i class="fas fa-check-circle"></i> ¡Correcto! +' + puntos + ' puntos';
                resultadoEl.classList.add('result-success');
                zona.classList.add('correct');

                // Animación de puntos
                const pointsEl = document.createElement('div');
                pointsEl.className = 'points-animation';
                pointsEl.textContent = `+${puntos}`;
                pointsEl.style.left = `${window.innerWidth/2}px`;
                pointsEl.style.top = `${window.innerHeight/2}px`;
                document.body.appendChild(pointsEl);

                // Guardar puntos vía AJAX (MANTENIENDO LA FUNCIONALIDAD ORIGINAL)
                $.post('guardar_puntos.php', { 
                    user_id: <?php echo $_SESSION['user_id']; ?>, 
                    nivel: nivel,
                    puntos: puntos
                }, function(data) {
                    console.log('Puntos guardados:', data);
                });

            } else {
                resultadoEl.innerHTML = '<i class="fas fa-times-circle"></i> Intenta nuevamente. Revisa la sintaxis.';
                resultadoEl.classList.add('result-error');
                zona.classList.add('incorrect');
            }
        });

        document.getElementById('nuevo').addEventListener('click', () => {
            window.location.reload();
        });

        // Inicializar estado
        actualizarEstado();
        </script>

        <?php endif; ?>
    </div>
</body>
</html>