<?php
// ranking.php
session_start();
$servername = "localhost";
$username = "root";
$password = "root"; // Cambia si tienes contraseña
$dbname = "sql_learning_app";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Revisar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener el ranking
$sql = "SELECT r.usuario_id AS id, u.username, r.puntos_totales, r.actualizado, u.avatar
        FROM ranking_usuarios r
        JOIN users u ON r.usuario_id = u.id
        ORDER BY r.puntos_totales DESC, r.actualizado ASC";

$result = $conn->query($sql);

// Obtener posición del usuario actual si está logueado
$current_user_position = null;
$current_user_data = null;
if (isset($_SESSION['user_id'])) {
    $current_user_id = $_SESSION['user_id'];
    $position_sql = "SELECT position FROM (
                        SELECT usuario_id, 
                               ROW_NUMBER() OVER (ORDER BY puntos_totales DESC, actualizado ASC) as position
                        FROM ranking_usuarios
                    ) as ranked 
                    WHERE usuario_id = $current_user_id";
    $position_result = $conn->query($position_sql);
    if ($position_result && $position_result->num_rows > 0) {
        $current_user_position = $position_result->fetch_assoc()['position'];
        
        // Obtener datos del usuario actual
        $user_sql = "SELECT r.usuario_id AS id, u.username, r.puntos_totales, r.actualizado, u.avatar
                     FROM ranking_usuarios r
                     JOIN users u ON r.usuario_id = u.id
                     WHERE r.usuario_id = $current_user_id";
        $user_result = $conn->query($user_sql);
        if ($user_result && $user_result->num_rows > 0) {
            $current_user_data = $user_result->fetch_assoc();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking | SQL Learning</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2575fc;
            --primary-dark: #1a5edb;
            --secondary: #6a11cb;
            --accent: #00b894;
            --warning: #fdcb6e;
            --danger: #e74c3c;
            --light: #f8f9fa;
            --dark: #2d3436;
            --gray: #636e72;
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
            color: var(--dark);
            min-height: 100vh;
            padding: 20px;
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
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 1.2rem;
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
            box-shadow: 0 8px 20px rgba(37, 117, 252, 0.3);
        }

        /* Current User Card */
        .current-user-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(15px);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            border-left: 5px solid var(--warning);
        }

        .current-user-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .current-user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--warning);
        }

        .user-details h3 {
            color: var(--dark);
            margin-bottom: 5px;
        }

        .user-position {
            font-size: 1.1rem;
            font-weight: bold;
            color: var(--primary);
        }

        .user-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            text-align: center;
        }

        .stat {
            background: var(--light);
            padding: 10px;
            border-radius: 10px;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--gray);
        }

        /* Ranking Table */
        .ranking-section {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .ranking-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 20px;
            text-align: center;
        }

        .ranking-header h2 {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 1.5rem;
        }

        .ranking-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ranking-table th {
            background: var(--light);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            border-bottom: 2px solid #e9ecef;
        }

        .ranking-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            transition: var(--transition);
        }

        .ranking-table tr:hover td {
            background: #f8f9fa;
        }

        .ranking-table tr.current-user {
            background: rgba(37, 117, 252, 0.05) !important;
            border-left: 4px solid var(--primary);
        }

        .position-cell {
            text-align: center;
            font-weight: bold;
            width: 80px;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar-small {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .username {
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .username:hover {
            color: var(--primary);
        }

        .points-cell {
            font-weight: bold;
            color: var(--primary);
            text-align: center;
        }

        .date-cell {
            color: var(--gray);
            font-size: 0.9rem;
            text-align: center;
        }

        /* Medals */
        .medal {
            font-size: 1.3rem;
        }

        .gold { color: #FFD700; }
        .silver { color: #C0C0C0; }
        .bronze { color: #CD7F32; }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        /* Footer */
        footer {
            text-align: center;
            color: rgba(255,255,255,0.8);
            margin-top: 40px;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .user-stats {
                grid-template-columns: 1fr;
            }
            
            .ranking-table {
                display: block;
                overflow-x: auto;
            }
            
            h1 {
                font-size: 2.2rem;
            }
            
            .current-user-info {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .ranking-table th:nth-child(4),
            .ranking-table td:nth-child(4) {
                display: none;
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
            <h1><i class="fas fa-trophy"></i> Ranking Global</h1>
            <p class="subtitle">Los mejores aprendices de SQL de la comunidad</p>
        </div>

        <nav>
            <a href="course/course.php" class="nav-btn"><i class="fas fa-graduation-cap"></i> Cursos</a>
            <a href="retos.php" class="nav-btn"><i class="fas fa-flag"></i> Retos</a>
            <a href="books.php" class="nav-btn"><i class="fas fa-book"></i> Biblioteca</a>
            <a href="profile/index.php" class="nav-btn"><i class="fas fa-user"></i> Mi Perfil</a>
        </nav>

        <?php if ($current_user_data && $current_user_position): ?>
        <div class="current-user-card">
            <div class="current-user-header">
                <div class="current-user-info">
                    <img src="profile/avatars/<?= htmlspecialchars($current_user_data['avatar']) ?>" class="user-avatar" alt="Tu avatar">
                    <div class="user-details">
                        <h3>Tu Posición</h3>
                        <div class="user-position">#<?= $current_user_position ?> en el ranking</div>
                    </div>
                </div>
            </div>
            <div class="user-stats">
                <div class="stat">
                    <div class="stat-value">#<?= $current_user_position ?></div>
                    <div class="stat-label">Posición</div>
                </div>
                <div class="stat">
                    <div class="stat-value"><?= $current_user_data['puntos_totales'] ?></div>
                    <div class="stat-label">Puntos</div>
                </div>
                <div class="stat">
                    <div class="stat-value"><?= date('M Y', strtotime($current_user_data['actualizado'])) ?></div>
                    <div class="stat-label">Última Act.</div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="ranking-section">
            <div class="ranking-header">
                <h2><i class="fas fa-crown"></i> Top Aprendices de SQL</h2>
            </div>

            <table class="ranking-table">
                <thead>
                    <tr>
                        <th class="position-cell">Posición</th>
                        <th>Usuario</th>
                        <th class="points-cell">Puntos</th>
                        <th class="date-cell">Última Actualización</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $pos = 1;
                        while($row = $result->fetch_assoc()) {
                            $is_current_user = isset($_SESSION['user_id']) && $row['id'] == $_SESSION['user_id'];
                            $row_class = $is_current_user ? 'current-user' : '';
                            
                            echo "<tr class='$row_class'>";
                            
                            // Posición con medallas
                            echo "<td class='position-cell'>";
                            if($pos == 1){
                                echo "<div class='medal gold'>🥇</div>";
                            } elseif($pos == 2){
                                echo "<div class='medal silver'>🥈</div>";
                            } elseif($pos == 3){
                                echo "<div class='medal bronze'>🥉</div>";
                            } else {
                                echo "<span style='color: var(--gray);'>#$pos</span>";
                            }
                            echo "</td>";
                            
                            // Información del usuario
                            echo "<td class='user-cell'>";
                            echo "<img src='profile/avatars/".htmlspecialchars($row['avatar'])."' class='user-avatar-small' alt='Avatar'>";
                            echo "<a href='view_profile.php?id=" . $row['id'] . "' class='username'>" . htmlspecialchars($row['username']) . "</a>";
                            if ($is_current_user) {
                                echo " <span style='color: var(--primary); font-size: 0.8rem;'>(Tú)</span>";
                            }
                            echo "</td>";
                            
                            echo "<td class='points-cell'>" . number_format($row['puntos_totales']) . " pts</td>";
                            echo "<td class='date-cell'>" . date('d M Y', strtotime($row['actualizado'])) . "</td>";
                            echo "</tr>";
                            $pos++;
                        }
                    } else {
                        echo "<tr><td colspan='4' class='empty-state'>
                                <i class='fas fa-users'></i>
                                <h3>No hay usuarios en el ranking</h3>
                                <p>Sé el primero en completar cursos y aparecer aquí</p>
                              </td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <footer>
            <p>SQL Learning &copy; 2025 - ¡Sigue aprendiendo y sube en el ranking!</p>
        </footer>
    </div>

    <script>
        // Animaciones de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.ranking-table tbody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, index * 100);
            });
            
            // Destacar la fila del usuario actual
            const currentUserRow = document.querySelector('.current-user');
            if (currentUserRow) {
                currentUserRow.style.animation = 'pulse 2s infinite';
            }
        });

        // Efecto de pulso para el usuario actual
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0% { background-color: rgba(37, 117, 252, 0.05); }
                50% { background-color: rgba(37, 117, 252, 0.1); }
                100% { background-color: rgba(37, 117, 252, 0.05); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>