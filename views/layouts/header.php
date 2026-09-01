<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo ?? APP_NAME) ?></title>
    <meta name="description" content="<?= htmlspecialchars(APP_DESCRIPTION) ?>">
    <meta name="theme-color" content="#059669">
    
    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Leaflet CSS (Mapas) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/directorio.css?v=<?= time() ?>">
    
    <!-- PWA -->
    <link rel="manifest" href="<?= BASE_URL ?>public/manifest.json">
</head>
<body>
    <!-- Navbar -->
    <?php include ROOT_PATH . 'views/components/navbar.php'; ?>

    <!-- Flash Messages -->
    <div class="container mt-3">
        <?php if (!empty($_SESSION['mensaje'])): ?>
            <div class="alert alert-directorio alert-success-custom" role="alert">
                <i class="fas fa-check-circle"></i>
                <?= htmlspecialchars($_SESSION['mensaje']) ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>
        
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-directorio alert-error-custom" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>

    <main>
