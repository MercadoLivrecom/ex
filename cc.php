<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Números de Cartão</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        input[type="text"], input[type="number"], select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        #output {
            margin-top: 20px;
        }
        .card-list {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #fff;
            border-radius: 4px;
        }
        .card-item {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
        .card-item:last-child {
            border-bottom: none;
        }
        .copy-btn {
            margin-top: 10px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .copy-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerador de Números de Cartão</h1>
        <form method="post">
            <label for="prefix">6 Dígitos do Cartão:</label>
            <input type="text" id="prefix" name="prefix" maxlength="6" required>

            <label for="expiry">Data de Validade:</label>
            <input type="text" id="expiry" name="expiry" placeholder="MM/AA" maxlength="5" required>

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" value="000" required>

            <label for="quantity">Quantidade de Fileiras:</label>
            <input type="number" id="quantity" name="quantity" min="1" required>

            <button type="submit">Gerar Cartões</button>
        </form>

        <div id="output">
            <?php
            function generateCardNumber($prefix) {
                $number = $prefix;
                while (strlen($number) < 15) {
                    $number .= rand(0, 9);
                }
                return $number;
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $prefix = $_POST['prefix'];
                $quantity = intval($_POST['quantity']);
                $expiry = $_POST['expiry'];
                $cvv = $_POST['cvv'];

                if (!preg_match('/^\d{6}$/', $prefix)) {
                    echo "<p>Os 6 dígitos devem ser numéricos e ter exatamente 6 dígitos.</p>";
                } else {
                    echo "<div class='card-list'>";
                    for ($i = 0; $i < $quantity; $i++) {
                        $cardNumber = generateCardNumber($prefix);
                        echo "<div class='card-item'>$cardNumber - $expiry - $cvv</div>";
                    }
                    echo "</div>";
                    echo "<button class='copy-btn' onclick='copyToClipboard()'>Copiar Todos</button>";
                }
            }
            ?>

            <script>
                function copyToClipboard() {
                    const range = document.createRange();
                    range.selectNode(document.querySelector('.card-list'));
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);
                    document.execCommand('copy');
                    window.getSelection().removeAllRanges();
                    alert('Cartões copiados para a área de transferência.');
                }
            </script>
        </div>
    </div>
</body>
</html>
