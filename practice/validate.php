<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Verificación</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        h2 {
            margin-bottom: 25px;
            font-size: 24px;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .correct {
            color: #2ecc71;
        }
        
        .incorrect {
            color: #e74c3c;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(106, 17, 203, 0.3);
            margin-top: 10px;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(106, 17, 203, 0.4);
        }
        
        .icon {
            font-size: 28px;
        }
        
        .details {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
        }
        
        .details h3 {
            margin-bottom: 10px;
            color: #555;
            font-size: 16px;
        }
        
        .query-box {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 12px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 14px;
            overflow-x: auto;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../index.php");
            exit();
        }

        $expected = trim(strtolower($_POST['expected']));
        $answer = trim(strtolower($_POST['answer']));
        
        $isCorrect = ($expected == $answer);
        $resultado = $isCorrect 
            ? "✅ ¡Correcto! Tu consulta es válida." 
            : "❌ Incorrecto. Revisa tu sintaxis.";
        
        $class = $isCorrect ? "correct" : "incorrect";
        ?>
        
        <h2 class="<?php echo $class; ?>">
            <span class="icon"><?php echo $isCorrect ? '✅' : '❌'; ?></span>
            <?php echo $resultado; ?>
        </h2>
        
        <div class="details">
            <h3>Consulta esperada:</h3>
            <div class="query-box"><?php echo htmlspecialchars($expected); ?></div>
            
            <h3>Tu respuesta:</h3>
            <div class="query-box"><?php echo htmlspecialchars($answer); ?></div>
        </div>
        
        <a href="../course/basico/practica.php" class="btn">Volver al panel</a>
    </div>
</body>
</html>