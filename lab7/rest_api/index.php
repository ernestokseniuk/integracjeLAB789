<?php
// Set HTML content type
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html>
<head>
    <title>World Database REST API</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 800px; margin: 0 auto; }
        .endpoint { background: #f5f5f5; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .method { color: #fff; padding: 3px 8px; border-radius: 3px; font-weight: bold; }
        .get { background: #28a745; }
        .post { background: #007bff; }
        .put { background: #ffc107; color: #000; }
        .delete { background: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌍 World Database REST API</h1>
        <p>Welcome to the World Database REST API. This API provides access to countries and cities data.</p>
        
        <h2>📍 API Status</h2>
        <p>✅ API is running on Docker container</p>
        <p>🐳 Container: lab7_web</p>
        <p>🌐 Port: 8000</p>
        
        <h2>🛠 Available Endpoints</h2>
        
        <div class="endpoint">
            <h3>Countries</h3>
            <p><span class="method get">GET</span> <code>/api/read_countries.php</code> - Get all countries</p>
            <p><span class="method get">GET</span> <code>/api/read_single_country.php?code={CODE}</code> - Get country by code</p>
            <p><span class="method post">POST</span> <code>/api/create_country.php</code> - Create new country</p>
        </div>
        
        <div class="endpoint">
            <h3>Cities</h3>
            <p><span class="method get">GET</span> <code>/api/read_cities.php</code> - Get all cities</p>
            <p><span class="method get">GET</span> <code>/api/read_cities.php?country={CODE}</code> - Get cities by country</p>
        </div>
        
        <h2>📊 Database Information</h2>
        <p>Database: MySQL 8.0</p>
        <p>Schema: world</p>
        <p>Tables: country, city, countrylanguage</p>
          <h2>🔗 Quick Test Links</h2>
        <ul>
            <li><a href="/api/read_countries.php" target="_blank">View all countries</a></li>
            <li><a href="/api/read_cities.php" target="_blank">View all cities</a></li>
            <li><a href="/api/read_single_country.php?code=POL" target="_blank">View Poland details</a></li>
            <li><a href="/api/read_cities.php?country=POL" target="_blank">View cities in Poland</a></li>
        </ul>        <h2>🌐 Web Interface</h2>
        <div style="display: flex; gap: 15px; justify-content: center; margin: 20px 0; flex-wrap: wrap;">
            <a href="countries.html" style="display: inline-block; padding: 15px 30px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
                🌍 Zarządzaj Krajami
            </a>
            <a href="cities.html" style="display: inline-block; padding: 15px 30px; background-color: #17a2b8; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
                🏙️ Przeglądaj Miasta
            </a>
            <a href="api-docs.html" style="display: inline-block; padding: 15px 30px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
                📚 Dokumentacja API
            </a>
            <a href="test-api.html" style="display: inline-block; padding: 15px 30px; background-color: #ffc107; color: black; text-decoration: none; border-radius: 5px; font-weight: bold;">
                🧪 Test API
            </a>
        </div>
        
        <hr>
        <p><small>Lab 7 - Docker REST API | Generated: <?php echo date('Y-m-d H:i:s'); ?></small></p>
    </div>
</body>
</html>