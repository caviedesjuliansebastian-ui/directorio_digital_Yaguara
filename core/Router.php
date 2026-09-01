<?php
class Router {
    public function run() {
        // Obtener la URL
        $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home/index';
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        // Definir Controlador y Método
        $controllerName = ucfirst(strtolower($url[0])) . 'Controller';
        $methodName = isset($url[1]) ? $url[1] : 'index';

        $controllerFile = ROOT_PATH . 'controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                
                if (method_exists($controller, $methodName)) {
                    $params = array_slice($url, 2);
                    call_user_func_array([$controller, $methodName], $params);
                } else {
                    $this->notFound("Método $methodName no encontrado.");
                }
            } else {
                $this->notFound("Controlador no encontrado.");
            }
        } else {
            $this->notFound("Página no encontrada.");
        }
    }

    private function notFound($message = "Página no encontrada") {
        http_response_code(404);
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>404 — <?= APP_NAME ?></title>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
                .container { text-align: center; padding: 2rem; }
                .code { font-size: 8rem; font-weight: 700; background: linear-gradient(135deg, #059669, #0284c7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1; }
                h1 { font-size: 1.5rem; margin: 1rem 0; color: #94a3b8; }
                a { display: inline-block; margin-top: 1.5rem; padding: 0.75rem 2rem; background: linear-gradient(135deg, #059669, #0284c7); color: white; text-decoration: none; border-radius: 12px; font-weight: 600; transition: transform 0.2s; }
                a:hover { transform: translateY(-2px); }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="code">404</div>
                <h1><?= htmlspecialchars($message) ?></h1>
                <a href="<?= BASE_URL ?>">← Volver al inicio</a>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}
