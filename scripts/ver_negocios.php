<?php
require_once __DIR__ . '/../config/database.php';
$db = (new Database())->getConnection();

$stmt = $db->query("SELECT id, nombre, categoria_id FROM negocios");
$negocios = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Negocios encontrados:\n";
print_r($negocios);
