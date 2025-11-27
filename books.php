<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca | SQL Learning</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2575fc;
            --primary-dark: #1a5edb;
            --secondary: #6a11cb;
            --accent: #00b894;
            --light: #f8f9fa;
            --dark: #2d3436;
            --gray: #636e72;
            --border-radius: 16px;
            --shadow: 0 10px 30px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header Styles */
        header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px 20px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        h1 {
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .subtitle {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
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
            border: 1px solid transparent;
        }

        .nav-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(37, 117, 252, 0.3);
        }

        /* Search and Filters */
        .search-section {
            background: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .search-container {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .search-box {
            flex: 1;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 1px solid #e0e0e0;
            border-radius: 50px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.1);
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .filter-container {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 20px;
            background: var(--light);
            border: 1px solid #e0e0e0;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Books Grid */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .book-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .book-cover {
            height: 250px;
            position: relative;
            overflow: hidden;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .book-card:hover .book-cover img {
            transform: scale(1.05);
        }

        .book-cover::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.3));
            opacity: 0;
            transition: var(--transition);
        }

        .book-card:hover .book-cover::after {
            opacity: 1;
        }

        .book-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .book-title {
            font-size: 1.4rem;
            margin-bottom: 10px;
            color: var(--dark);
            line-height: 1.3;
        }

        .book-description {
            color: var(--gray);
            margin-bottom: 20px;
            flex: 1;
        }

        .book-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: var(--gray);
        }

        .book-level {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            background: var(--light);
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .book-level.beginner {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .book-level.intermediate {
            background: #e3f2fd;
            color: #1565c0;
        }

        .book-level.advanced {
            background: #fce4ec;
            color: #c2185b;
        }

        .book-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            flex: 1;
            text-align: center;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 117, 252, 0.4);
        }

        .btn-secondary {
            background: var(--light);
            color: var(--dark);
            border: 1px solid #e0e0e0;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .books-grid {
                grid-template-columns: 1fr;
            }
            
            .search-container {
                flex-direction: column;
            }
            
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-book-open"></i> Biblioteca SQL Learning</h1>
            <p class="subtitle">Explora nuestra colección de recursos para dominar SQL y bases de datos</p>
        </header>

        <nav>
            <a href="../sqla/dashboard.php" class="nav-btn"><i class="fas fa-arrow-left"></i> Volver al Panel</a>
            <a href="course/course.php" class="nav-btn"><i class="fas fa-graduation-cap"></i> Cursos</a>
            <a href="retos.php" class="nav-btn"><i class="fas fa-flag"></i> Retos</a>
            <a href="ranking.php" class="nav-btn"><i class="fas fa-trophy"></i> Ranking</a>
        </nav>

        <section class="search-section">
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" placeholder="Buscar libros, autores o temas...">
                </div>
                <button class="btn btn-primary" id="searchBtn">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
            <div class="filter-container">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <button class="filter-btn" data-filter="beginner">Principiante</button>
                <button class="filter-btn" data-filter="intermediate">Intermedio</button>
                <button class="filter-btn" data-filter="advanced">Avanzado</button>
                <button class="filter-btn" data-filter="free">Gratuitos</button>
            </div>
        </section>

        <section class="books-grid" id="booksContainer">
            <!-- Libro 1 -->
            <div class="book-card" data-level="beginner" data-free="true">
                <div class="book-cover">
                    <!-- REEMPLAZA books/sql-for-beginners.jpg CON LA RUTA DE TU IMAGEN -->
                    <img src="books/sql-for-beginners.jpg" alt="SQL For Beginners">
                </div>
                <div class="book-content">
                    <h3 class="book-title">SQL For Beginners</h3>
                    <p class="book-description">Una guía completa para empezar con SQL desde cero. Aprende los fundamentos de bases de datos, consultas básicas y prácticas recomendadas.</p>
                    <div class="book-meta">
                        <span class="book-level beginner"><i class="fas fa-signal"></i> Principiante</span>
                        <span><i class="far fa-clock"></i> 5h de lectura</span>
                    </div>
                    <div class="book-actions">
                        <a href="https://www.sqltutorial.org/" target="_blank" class="btn btn-primary">
                            <i class="fas fa-book-open"></i> Leer Online
                        </a>
                    </div>
                </div>
            </div>

            <!-- Libro 2 -->
            <div class="book-card" data-level="intermediate" data-free="false">
                <div class="book-cover">
                    <!-- REEMPLAZA books/learning-sql.jpg CON LA RUTA DE TU IMAGEN -->
                    <img src="books/learning-sql.jpg" alt="Learning SQL">
                </div>
                <div class="book-content">
                    <h3 class="book-title">Learning SQL – Alan Beaulieu</h3>
                    <p class="book-description">Libro muy respetado para aprender SQL de forma profesional. Cubre desde conceptos básicos hasta técnicas avanzadas de optimización.</p>
                    <div class="book-meta">
                        <span class="book-level intermediate"><i class="fas fa-signal"></i> Intermedio</span>
                        <span><i class="far fa-clock"></i> 12h de lectura</span>
                    </div>
                    <div class="book-actions">
                        <a href="https://www.oreilly.com/library/view/learning-sql-3rd/9781492057604/" target="_blank" class="btn btn-primary">
                            <i class="fas fa-external-link-alt"></i> Ver en O'Reilly
                        </a>
                    </div>
                </div>
            </div>

            <!-- Libro 3 -->
            <div class="book-card" data-level="beginner" data-free="true">
                <div class="book-cover">
                    <!-- REEMPLAZA books/sql-cheat-sheet.jpg CON LA RUTA DE TU IMAGEN -->
                    <img src="books/sql-cheat-sheet.jpg" alt="SQL Cheat Sheet">
                </div>
                <div class="book-content">
                    <h3 class="book-title">SQL Curso Básico</h3>
                    <p class="book-description">PDF gratuito con todos los comandos SQL esenciales. Perfecto para tener como referencia rápida mientras practicas y desarrollas.</p>
                    <div class="book-meta">
                        <span class="book-level beginner"><i class="fas fa-signal"></i> Principiante</span>
                        <span><i class="fas fa-file-pdf"></i> PDF</span>
                    </div>
                    <div class="book-actions">
                        <a href="https://www.fcca.umich.mx/descargas/apuntes/academia%20de%20informatica/Base%20de%20Datos%20%20I%20%20%20%20G.A.G.C/Curso%20de%20SQL.pdf" target="_blank" class="btn btn-primary">
                            <i class="fas fa-download"></i> Descargar PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Libro 4 -->
            <div class="book-card" data-level="advanced" data-free="true">
                <div class="book-cover">
                    <!-- REEMPLAZA books/advanced-sql.jpg CON LA RUTA DE TU IMAGEN -->
                    <img src="books/advanced-sql.jpg" alt="Advanced SQL Programming">
                </div>
                <div class="book-content">
                    <h3 class="book-title">Advanced SQL Programming IBM</h3>
                    <p class="book-description">Domina consultas complejas, optimización de rendimiento, stored procedures y técnicas avanzadas de SQL para desarrolladores expertos.</p>
                    <div class="book-meta">
                        <span class="book-level advanced"><i class="fas fa-signal"></i> Avanzado</span>
                        <span><i class="far fa-clock"></i> 8h de lectura</span>
                    </div>
                    <div class="book-actions">
                        <a href="https://www.ibm.com/docs/en/ssw_ibm_i_71/sqlp/rbafy.pdf" target="_blank" class="btn btn-primary">
                            <i class="fas fa-book-open"></i> Leer Online
                        </a>
                    </div>
                </div>
            </div>

            <!-- Libro 5 -->
            <div class="book-card" data-level="intermediate" data-free="true">
                <div class="book-cover">
                    <!-- REEMPLAZA books/sql-security.jpg CON LA RUTA DE TU IMAGEN -->
                    <img src="books/sql-security.jpg" alt="SQL Security Best Practices">
                </div>
                <div class="book-content">
                    <h3 class="book-title">SQL Security Best Practices</h3>
                    <p class="book-description">Aprende a proteger tus bases de datos contra inyecciones SQL, gestionar permisos y aplicar las mejores prácticas de seguridad.</p>
                    <div class="book-meta">
                        <span class="book-level intermediate"><i class="fas fa-signal"></i> Intermedio</span>
                        <span><i class="far fa-clock"></i> 4h de lectura</span>
                    </div>
                    <div class="book-actions">
                        <a href="https://download.oracle.com/database/oracle-database-security-primer.pdf" target="_blank" class="btn btn-primary">
                            <i class="fas fa-book-open"></i> Leer Online
                        </a>
                    </div>
                </div>
            </div>

            <!-- Libro 6 -->
            <div class="book-card" data-level="beginner" data-free="true">
                <div class="book-cover">
                    <!-- REEMPLAZA books/database-design.jpg CON LA RUTA DE TU IMAGEN -->
                    <img src="books/database-design.jpg" alt="Database Design Fundamentals">
                </div>
                <div class="book-content">
                    <h3 class="book-title">Database Design Fundamentals</h3>
                    <p class="book-description">Comprende los principios del diseño de bases de datos, normalización, relaciones y cómo estructurar datos eficientemente.</p>
                    <div class="book-meta">
                        <span class="book-level beginner"><i class="fas fa-signal"></i> Principiante</span>
                        <span><i class="far fa-clock"></i> 6h de lectura</span>
                    </div>
                    <div class="book-actions">
                        <a href="https://pedrobeltrancanessa-biblioteca.weebly.com/uploads/1/2/4/0/12405072/fundamentos_de_sql_3edi_oppel.pdf" target="_blank" class="btn btn-primary">
                            <i class="fas fa-book-open"></i> Leer Online
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <p>SQL Learning &copy; 2025 - Continúa tu viaje de aprendizaje</p>
        </footer>
    </div>

    <script>
        // Filtrado de libros
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const books = document.querySelectorAll('.book-card');
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            
            // Filtrado por categorías
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');
                    
                    // Actualizar botón activo
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Filtrar libros
                    books.forEach(book => {
                        if (filter === 'all') {
                            book.style.display = 'flex';
                        } else if (filter === 'free') {
                            if (book.getAttribute('data-free') === 'true') {
                                book.style.display = 'flex';
                            } else {
                                book.style.display = 'none';
                            }
                        } else {
                            if (book.getAttribute('data-level') === filter) {
                                book.style.display = 'flex';
                            } else {
                                book.style.display = 'none';
                            }
                        }
                    });
                });
            });
            
            // Búsqueda de libros
            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase();
                
                books.forEach(book => {
                    const title = book.querySelector('.book-title').textContent.toLowerCase();
                    const description = book.querySelector('.book-description').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || description.includes(searchTerm)) {
                        book.style.display = 'flex';
                    } else {
                        book.style.display = 'none';
                    }
                });
            }
            
            searchBtn.addEventListener('click', performSearch);
            searchInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    performSearch();
                }
            });
        });
    </script>
</body>
</html>