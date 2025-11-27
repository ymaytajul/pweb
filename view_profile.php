<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    echo "<div style='text-align:center; padding:50px; font-family:Arial;'>Perfil no encontrado.</div>";
    exit();
}

$id = intval($_GET['id']);
$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

if (!$user) {
    echo "<div style='text-align:center; padding:50px; font-family:Arial;'>Este usuario no existe.</div>";
    exit();
}

// Obtener estadísticas del usuario con manejo de errores
try {
    // Verificar estructura de la tabla user_progress
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
        // Enfoque alternativo si no existe la columna completed
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
    
    $stats = $stats_query ? $stats_query->fetch_assoc() : [];
    
} catch (Exception $e) {
    // Valores por defecto en caso de error
    $stats = [
        'cursos_completados' => 0,
        'puntos_totales' => 0,
        'posts_count' => 0,
        'lecciones_completadas' => 0
    ];
}

// Obtener posts recientes del usuario
$recent_posts = $conn->query("
    SELECT content, created_at, image_path 
    FROM posts 
    WHERE user_id = $id 
    ORDER BY created_at DESC 
    LIMIT 3
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?= htmlspecialchars($user['username']) ?> | SQL Learning</title>
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
            margin-bottom: 40px;
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

        /* Profile Layout */
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
            text-align: center;
        }

        .avatar-section {
            margin-bottom: 25px;
        }

        .avatar {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255,255,255,0.3);
            margin-bottom: 15px;
            transition: var(--transition);
        }

        .avatar:hover {
            transform: scale(1.05);
            border-color: rgba(255,255,255,0.6);
        }

        .username {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--warning);
        }

        .member-since {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 20px;
        }

        .stats-section {
            margin-top: 25px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }

        .stat-card {
            background: rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--warning);
            display: block;
        }

        .stat-label {
            font-size: 0.8rem;
            opacity: 0.9;
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

        .info-section {
            margin-bottom: 30px;
        }

        .info-item {
            margin-bottom: 20px;
            padding: 20px;
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
            border-left: 4px solid var(--warning);
        }

        .info-label {
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--warning);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-content {
            line-height: 1.6;
        }

        /* Posts Section */
        .posts-section {
            margin-top: 30px;
        }

        .posts-grid {
            display: grid;
            gap: 20px;
        }

        .post-card {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid var(--primary);
            transition: var(--transition);
        }

        .post-card:hover {
            background: rgba(255,255,255,0.08);
            transform: translateY(-2px);
        }

        .post-content {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .post-image {
            margin-top: 15px;
            border-radius: 8px;
            overflow: hidden;
        }

        .post-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .post-date {
            font-size: 0.8rem;
            opacity: 0.7;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            opacity: 0.7;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Badges */
        .badges-section {
            margin-top: 25px;
        }

        .badges-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
            justify-content: center;
        }

        .badge {
            background: rgba(253, 203, 110, 0.2);
            color: var(--warning);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            border: 1px solid rgba(253, 203, 110, 0.3);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .avatar {
                width: 140px;
                height: 140px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="dashboard.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
            <h1><i class="fas fa-user"></i> Perfil Público</h1>
            <p class="subtitle">Conoce más sobre <?= htmlspecialchars($user['username']) ?></p>
        </div>

        <div class="profile-layout">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="avatar-section">
                    <img src="profile/avatars/<?= htmlspecialchars($user['avatar']) ?>" class="avatar" alt="Avatar de <?= htmlspecialchars($user['username']) ?>">
                    <div class="username"><?= htmlspecialchars($user['username']) ?></div>
                    <div class="member-since">
                        <i class="far fa-calendar"></i> Miembro desde <?= date('M Y', strtotime($user['created_at'])) ?>
                    </div>
                </div>

                <div class="stats-section">
                    <h3><i class="fas fa-chart-line"></i> Estadísticas</h3>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <span class="stat-number"><?= $stats['cursos_completados'] ?? 0 ?></span>
                            <span class="stat-label">Cursos Completados</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number"><?= $stats['puntos_totales'] ?? 0 ?></span>
                            <span class="stat-label">Puntos Totales</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number"><?= $stats['posts_count'] ?? 0 ?></span>
                            <span class="stat-label">Publicaciones</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number"><?= $stats['lecciones_completadas'] ?? 0 ?></span>
                            <span class="stat-label">Lecciones Completadas</span>
                        </div>
                    </div>
                </div>

                <div class="badges-section">
                    <h3><i class="fas fa-award"></i> Logros</h3>
                    <div class="badges-grid">
                        <?php if(($stats['cursos_completados'] ?? 0) > 0): ?>
                            <div class="badge"><i class="fas fa-graduation-cap"></i> Aprendiz SQL</div>
                        <?php endif; ?>
                        <?php if(($stats['posts_count'] ?? 0) > 2): ?>
                            <div class="badge"><i class="fas fa-comments"></i> Comunicador</div>
                        <?php endif; ?>
                        <?php if(($stats['puntos_totales'] ?? 0) > 100): ?>
                            <div class="badge"><i class="fas fa-star"></i> Destacado</div>
                        <?php endif; ?>
                        <?php if(($stats['lecciones_completadas'] ?? 0) > 10): ?>
                            <div class="badge"><i class="fas fa-trophy"></i> Comprometido</div>
                        <?php endif; ?>
                        <?php if(empty($stats['posts_count']) || $stats['posts_count'] == 0): ?>
                            <div class="badge"><i class="fas fa-seedling"></i> Nuevo Miembro</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="profile-main">
                <div class="info-section">
                    <h2 class="section-title"><i class="fas fa-info-circle"></i> Información Personal</h2>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i> Correo Electrónico
                        </div>
                        <div class="info-content">
                            <?= htmlspecialchars($user['email']) ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-edit"></i> Biografía
                        </div>
                        <div class="info-content">
                            <?php if(!empty(trim($user['bio']))): ?>
                                <?= nl2br(htmlspecialchars($user['bio'])) ?>
                            <?php else: ?>
                                <span style="opacity:0.7; font-style:italic;">
                                    <?= htmlspecialchars($user['username']) ?> aún no ha escrito su biografía.
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-palette"></i> Tema Personalizado
                        </div>
                        <div class="info-content">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 30px; height: 30px; border-radius: 6px; background: <?= htmlspecialchars($user['bg_color']) ?>; border: 2px solid rgba(255,255,255,0.5);"></div>
                                <span><?= htmlspecialchars($user['bg_color']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="posts-section">
                    <h2 class="section-title"><i class="fas fa-comments"></i> Publicaciones Recientes</h2>
                    
                    <div class="posts-grid">
                        <?php if($recent_posts && $recent_posts->num_rows > 0): ?>
                            <?php while($post = $recent_posts->fetch_assoc()): ?>
                                <div class="post-card">
                                    <div class="post-content">
                                        <?= $post['content'] ?>
                                    </div>
                                    <?php if(!empty($post['image_path'])): ?>
                                        <div class="post-image">
                                            <img src="<?= htmlspecialchars($post['image_path']) ?>" alt="Imagen del post">
                                        </div>
                                    <?php endif; ?>
                                    <div class="post-date">
                                        <i class="far fa-clock"></i> <?= date('d M Y H:i', strtotime($post['created_at'])) ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h3>Sin publicaciones aún</h3>
                                <p><?= htmlspecialchars($user['username']) ?> no ha compartido publicaciones todavía.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Efectos de interacción
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de entrada para las tarjetas
            const cards = document.querySelectorAll('.stat-card, .info-item, .post-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>