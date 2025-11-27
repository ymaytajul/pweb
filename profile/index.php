<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

// Obtener estadísticas del usuario con manejo de errores
try {
    // Primero verificar la estructura de la tabla user_progress
    $table_check = $conn->query("SHOW COLUMNS FROM user_progress LIKE 'completed'");
    $has_completed_column = $table_check->num_rows > 0;
    
    if ($has_completed_column) {
        $stats_query = $conn->query("
            SELECT 
                COUNT(DISTINCT course_id) as cursos_completados,
                SUM(score) as puntos_totales,
                (SELECT COUNT(*) FROM posts WHERE user_id = $id) as posts_count,
                (SELECT COUNT(*) FROM user_progress WHERE user_id = $id AND completed = 1) as lecciones_completadas
            FROM user_progress 
            WHERE user_id = $id
        ");
    } else {
        // Si no existe la columna completed, usar un enfoque alternativo
        $stats_query = $conn->query("
            SELECT 
                COUNT(DISTINCT course_id) as cursos_completados,
                SUM(score) as puntos_totales,
                (SELECT COUNT(*) FROM posts WHERE user_id = $id) as posts_count,
                COUNT(*) as lecciones_completadas
            FROM user_progress 
            WHERE user_id = $id AND score > 0
        ");
    }
    
    $stats = $stats_query->fetch_assoc();
    
} catch (Exception $e) {
    // En caso de error, usar valores por defecto
    $stats = [
        'cursos_completados' => 0,
        'puntos_totales' => 0,
        'posts_count' => 0,
        'lecciones_completadas' => 0
    ];
    
    // También podemos intentar una consulta más simple
    try {
        $simple_stats = $conn->query("
            SELECT 
                COUNT(DISTINCT course_id) as cursos_completados,
                SUM(score) as puntos_totales,
                (SELECT COUNT(*) FROM posts WHERE user_id = $id) as posts_count
            FROM user_progress 
            WHERE user_id = $id
        ");
        
        if ($simple_stats) {
            $simple_data = $simple_stats->fetch_assoc();
            $stats['cursos_completados'] = $simple_data['cursos_completados'] ?? 0;
            $stats['puntos_totales'] = $simple_data['puntos_totales'] ?? 0;
            $stats['posts_count'] = $simple_data['posts_count'] ?? 0;
            $stats['lecciones_completadas'] = $simple_data['cursos_completados'] ?? 0; // Usar cursos como aproximación
        }
    } catch (Exception $e2) {
        // Si sigue fallando, mantener los valores por defecto
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | SQL Learning</title>
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
            background: <?= htmlspecialchars($user['bg_color']) ?>;
            color: #fff;
            min-height: 100vh;
            padding: 20px;
            transition: background 0.5s ease;
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
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Layout */
        .profile-layout {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
        }

        @media (max-width: 768px) {
            .profile-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Sidebar */
        .profile-sidebar {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .avatar-section {
            text-align: center;
            margin-bottom: 25px;
        }

        .avatar-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255,255,255,0.3);
            margin-bottom: 15px;
            transition: var(--transition);
        }

        .avatar-preview:hover {
            transform: scale(1.05);
            border-color: rgba(255,255,255,0.6);
        }

        .avatar-upload {
            position: relative;
            display: inline-block;
        }

        .avatar-upload-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .avatar-upload-label:hover {
            background: rgba(255,255,255,0.3);
        }

        .stats-section {
            margin-top: 30px;
        }

        .stats-section h3 {
            margin-bottom: 15px;
            color: var(--warning);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .stat-value {
            font-weight: bold;
            color: var(--warning);
        }

        /* Main Content */
        .profile-main {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            font-size: 1.4rem;
            color: var(--warning);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 480px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            opacity: 0.9;
        }

        input, textarea {
            width: 100%;
            padding: 15px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            transition: var(--transition);
            backdrop-filter: blur(5px);
        }

        input::placeholder, textarea::placeholder {
            color: rgba(255,255,255,0.6);
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--warning);
            background: rgba(255,255,255,0.15);
            box-shadow: 0 0 0 3px rgba(253, 203, 110, 0.2);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .color-picker-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .color-preview {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid rgba(255,255,255,0.5);
            cursor: pointer;
        }

        .submit-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            background: var(--warning);
            color: var(--dark);
            border: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(253, 203, 110, 0.3);
        }

        .submit-btn:hover {
            background: #ffd700;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(253, 203, 110, 0.4);
        }

        /* Messages */
        .message {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .success {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
            border-color: rgba(46, 204, 113, 0.3);
        }

        .error {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            border-color: rgba(231, 76, 60, 0.3);
        }

        /* Theme Presets */
        .theme-presets {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .theme-preset {
            height: 40px;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: var(--transition);
        }

        .theme-preset:hover {
            transform: scale(1.05);
            border-color: var(--warning);
        }

        .theme-preset.active {
            border-color: var(--warning);
            box-shadow: 0 0 0 3px rgba(253, 203, 110, 0.3);
        }

        /* Debug info (opcional, quitar en producción) */
        .debug-info {
            background: rgba(0,0,0,0.3);
            padding: 10px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 0.8rem;
            color: #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="../dashboard.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Volver al Panel
            </a>
            <h1><i class="fas fa-user-cog"></i> Mi Perfil</h1>
            <p class="subtitle">Personaliza tu información y preferencias</p>
        </div>

        <?php
        if(isset($_SESSION['success'])){
            echo "<div class='message success'><i class='fas fa-check-circle'></i> ".$_SESSION['success']."</div>";
            unset($_SESSION['success']);
        }
        if(isset($_SESSION['error'])){
            echo "<div class='message error'><i class='fas fa-exclamation-triangle'></i> ".$_SESSION['error']."</div>";
            unset($_SESSION['error']);
        }
        ?>

        <div class="profile-layout">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="avatar-section">
                    <img src="avatars/<?= htmlspecialchars($user['avatar']) ?>" class="avatar-preview" alt="Avatar" id="avatarPreview">
                    <div class="avatar-upload">
                        <label for="avatarUpload" class="avatar-upload-label">
                            <i class="fas fa-camera"></i> Cambiar Avatar
                        </label>
                    </div>
                </div>

                <div class="stats-section">
                    <h3><i class="fas fa-chart-line"></i> Mis Estadísticas</h3>
                    <div class="stat-item">
                        <span><i class="fas fa-graduation-cap"></i> Cursos Completados</span>
                        <span class="stat-value"><?= $stats['cursos_completados'] ?? 0 ?></span>
                    </div>
                    <div class="stat-item">
                        <span><i class="fas fa-star"></i> Puntos Totales</span>
                        <span class="stat-value"><?= $stats['puntos_totales'] ?? 0 ?></span>
                    </div>
                    <div class="stat-item">
                        <span><i class="fas fa-comments"></i> Publicaciones</span>
                        <span class="stat-value"><?= $stats['posts_count'] ?? 0 ?></span>
                    </div>
                    <div class="stat-item">
                        <span><i class="fas fa-check-circle"></i> Lecciones Completadas</span>
                        <span class="stat-value"><?= $stats['lecciones_completadas'] ?? 0 ?></span>
                    </div>
                </div>

                <!-- Debug info (opcional) -->
                <!--
                <div class="debug-info">
                    <strong>Debug Info:</strong><br>
                    Has completed column: <?= $has_completed_column ? 'Yes' : 'No' ?>
                </div>
                -->
            </div>

            <!-- Main Content -->
            <div class="profile-main">
                <form method="post" action="update.php" enctype="multipart/form-data" id="profileForm">
                    <input type="file" name="avatar" id="avatarUpload" accept="image/*" style="display: none;" onchange="previewAvatar(this)">
                    
                    <h2 class="section-title"><i class="fas fa-user-edit"></i> Información Personal</h2>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="username"><i class="fas fa-user"></i> Nombre de Usuario</label>
                            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="bio"><i class="fas fa-edit"></i> Biografía</label>
                            <textarea id="bio" name="bio" placeholder="Comparte algo sobre ti, tus intereses en SQL, o tus metas de aprendizaje..."><?= htmlspecialchars($user['bio']) ?></textarea>
                        </div>

                        <div class="form-group full-width">
                            <label><i class="fas fa-palette"></i> Tema de Fondo</label>
                            <div class="color-picker-container">
                                <div class="color-preview" id="colorPreview" style="background: <?= htmlspecialchars($user['bg_color']) ?>"></div>
                                <input type="color" id="bg_color" name="bg_color" value="<?= htmlspecialchars($user['bg_color']) ?>" style="flex: 1;">
                            </div>
                            
                            <div class="theme-presets">
                                <div class="theme-preset" style="background: #2575fc;" data-color="#2575fc"></div>
                                <div class="theme-preset" style="background: #6a11cb;" data-color="#6a11cb"></div>
                                <div class="theme-preset" style="background: #00b894;" data-color="#00b894"></div>
                                <div class="theme-preset" style="background: #e74c3c;" data-color="#e74c3c"></div>
                                <div class="theme-preset" style="background: #2d3436;" data-color="#2d3436"></div>
                                <div class="theme-preset" style="background: #fd79a8;" data-color="#fd79a8"></div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Vista previa del avatar
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Actualizar vista previa del color
        document.getElementById('bg_color').addEventListener('input', function() {
            document.getElementById('colorPreview').style.background = this.value;
            document.body.style.background = this.value;
        });

        // Presets de colores
        document.querySelectorAll('.theme-preset').forEach(preset => {
            preset.addEventListener('click', function() {
                const color = this.getAttribute('data-color');
                document.getElementById('bg_color').value = color;
                document.getElementById('colorPreview').style.background = color;
                document.body.style.background = color;
                
                // Marcar preset activo
                document.querySelectorAll('.theme-preset').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Mostrar archivo seleccionado
        document.getElementById('avatarUpload').addEventListener('change', function() {
            const label = document.querySelector('.avatar-upload-label');
            if (this.files[0]) {
                label.innerHTML = `<i class="fas fa-check"></i> ${this.files[0].name}`;
            }
        });

        // Validación del formulario
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            
            if (username.length < 3) {
                e.preventDefault();
                alert('El nombre de usuario debe tener al menos 3 caracteres.');
                return;
            }
            
            if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                e.preventDefault();
                alert('Por favor, introduce un correo electrónico válido.');
                return;
            }
        });
    </script>
</body>
</html>