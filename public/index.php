<?php

use App\Controller\ContactController;

require_once __DIR__."/../vendor/autoload.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Magazord Back-End Test</title>
</head>
<body>

    
    <table id="person-table" class="border">
        <caption>Lista de Usuários</caption>
        <thead>
            <tr>
                <th class="border">ID</th>
                <th class="border">NAME</th>
                <th class="border">CPF</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border">test</td>
                <td class="border">test</td>
                <td class="border">TESt</td>
            </tr>
        </tbody>
    </table>
</body>
</html>