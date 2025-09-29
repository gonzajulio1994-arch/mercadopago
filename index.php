<?php
require __DIR__ . '/vendor/autoload.php';

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;


MercadoPagoConfig::setAccessToken("APP_USR-175624831516814-092619-269acf2958344d39a43e45f33a0ffcd4-2711131519");

// Producto fijo
$producto = [
    "title" => "Camiseta Oficial",
    "price" => 50.00
];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cantidad = isset($_POST["cantidad"]) ? (int)$_POST["cantidad"] : 1;

    if ($cantidad < 1) $cantidad = 1;

    $items = [[
        "title" => $producto["title"],
        "quantity" => $cantidad,
        "unit_price" => $producto["price"]
    ]];

    try {
        $client = new PreferenceClient();
        $preference = $client->create([
            "items" => $items,
            "back_urls" => [
                "success" => "http://localhost/miproyecto/success.php",
                "failure" => "http://localhost/miproyecto/failure.php",
                "pending" => "http://localhost/miproyecto/pending.php"
            ],
            
        ]);

        
        header("Location: " . $preference->init_point);
        exit;

    } catch (Exception $e) {
        echo "<h2>❌ Error al crear preferencia</h2>";
        echo "<pre>";
        print_r($e);
        echo "</pre>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Comprar camiseta</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .card {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-width: 400px;
      text-align: center;
    }
    h1 {
      font-size: 1.6rem;
      margin-bottom: 10px;
      color: #333;
    }
    p {
      font-size: 1.2rem;
      margin: 10px 0;
      color: #444;
    }
    label {
      display: block;
      margin: 15px 0 5px;
      font-weight: bold;
      color: #555;
    }
    input[type="number"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 1rem;
    }
    button {
      margin-top: 20px;
      background: #009ee3;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
      width: 100%;
    }
    button:hover {
      background: #007bbd;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Comprar <?php echo $producto["title"]; ?></h1>
    <p><strong>Precio unitario:</strong> S/ <?php echo $producto["price"]; ?></p>

    <form method="POST">
      <label for="cantidad">Cantidad:</label>
      <input type="number" id="cantidad" name="cantidad" value="1" min="1">
      <button type="submit">Comprar con Mercado Pago</button>
    </form>
  </div>
</body>
</html>
