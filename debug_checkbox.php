<?php
require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Get user ID 2
$user = \App\Models\User::find(2);

if ($user) {
    echo "<h2>Debug Checkbox - Usuario ID 2</h2>";
    echo "<p><strong>Valor en BD:</strong> " . $user->notification_new_request . "</p>";
    echo "<p><strong>Tipo:</strong> " . gettype($user->notification_new_request) . "</p>";
    echo "<p><strong>Condición == '1':</strong> " . ($user->notification_new_request == '1' ? 'true' : 'false') . "</p>";
    echo "<p><strong>Condición == 1:</strong> " . ($user->notification_new_request == 1 ? 'true' : 'false') . "</p>";
    echo "<p><strong>Resultado final:</strong> " . (($user->notification_new_request == '1' || $user->notification_new_request == 1) ? 'CHECKED' : 'NOT CHECKED') . "</p>";
    
    echo "<hr>";
    echo "<h3>Test Checkbox HTML:</h3>";
    
    // Test con Bootstrap 4 (original)
    echo "<h4>Bootstrap 4 (Original):</h4>";
    echo '<div class="custom-control custom-switch">';
    echo '<input type="checkbox" class="custom-control-input" id="test1" name="test1" value="1" ' . (($user->notification_new_request == '1' || $user->notification_new_request == 1) ? 'checked' : '') . '>';
    echo '<label class="custom-control-label" for="test1">Test Bootstrap 4</label>';
    echo '</div>';
    
    echo "<br>";
    
    // Test con Bootstrap 5 (nuevo)
    echo "<h4>Bootstrap 5 (Nuevo):</h4>";
    echo '<div class="form-check form-switch">';
    echo '<input type="checkbox" class="form-check-input" id="test2" name="test2" value="1" ' . (($user->notification_new_request == '1' || $user->notification_new_request == 1) ? 'checked' : '') . '>';
    echo '<label class="form-check-label" for="test2">Test Bootstrap 5</label>';
    echo '</div>';
    
    echo "<br>";
    
    // Test con checkbox simple
    echo "<h4>Checkbox Simple:</h4>";
    echo '<input type="checkbox" id="test3" name="test3" value="1" ' . (($user->notification_new_request == '1' || $user->notification_new_request == 1) ? 'checked' : '') . '>';
    echo '<label for="test3">Test Simple</label>';
    
    echo "<hr>";
    echo "<h3>CSS y JavaScript Test:</h3>";
    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo '    console.log("Test1 checked:", document.getElementById("test1").checked);';
    echo '    console.log("Test2 checked:", document.getElementById("test2").checked);';
    echo '    console.log("Test3 checked:", document.getElementById("test3").checked);';
    echo '    ';
    echo '    // Force all to checked';
    echo '    document.getElementById("test1").checked = true;';
    echo '    document.getElementById("test2").checked = true;';
    echo '    document.getElementById("test3").checked = true;';
    echo '    ';
    echo '    console.log("After force - Test1:", document.getElementById("test1").checked);';
    echo '    console.log("After force - Test2:", document.getElementById("test2").checked);';
    echo '    console.log("After force - Test3:", document.getElementById("test3").checked);';
    echo '});';
    echo '</script>';
    
} else {
    echo "Usuario ID 2 no encontrado";
}

$kernel->terminate($request, $response);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Debug Checkbox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <!-- El contenido PHP se renderiza arriba -->
</body>
</html>