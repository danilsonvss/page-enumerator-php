<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Upload de ZIP</title>
</head>
<body>
    <h1>Page Flip</h1>
    <h2>Enviar arquivo ZIP com imagens</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Arquivo ZIP:</label>
        <input type="file" name="zip_file" accept=".zip" required><br><br>

        <label>Destino:</label>
        <select name="destination" required>
            <option value="cubiculos">Cubículos</option>
            <option value="caixas-paineis">Caixas Painéis</option>
            <option value="extratores">Extratores</option>
            <option value="qgbtccm">QGBT/CCM</option>
            <option value="qtlog">QTLOG</option>
            <option value="qtserv">QTSERV</option>
        </select><br><br>

        <button type="submit" name="submit">Enviar</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            require  __DIR__ . '/src/UploadHandler.php';

            $handler = new UploadHandler($_FILES['zip_file'], $_POST['destination']);
            $handler->process();
            echo "<p>Imagens extraídas com sucesso para a pasta <strong>{$_POST['destination']}</strong>.</p>";
            unset($_POST);
        } catch (Exception $e) {
            echo "<p>Erro: " . $e->getMessage() . "</p>";
        }
    }
    ?>
</body>
</html>
