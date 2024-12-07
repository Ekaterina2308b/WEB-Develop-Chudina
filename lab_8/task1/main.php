<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица умножения</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1 class="title">Таблица умножения</h1>
    <table id="multiplication-table">
        <?php
            echo "<thead>";
            echo "<tr>";
            echo "<th>×</th>";
            for ($i = 0; $i <= 10; $i++) {
                echo "<th>$i</th>";
            }
            echo "</tr>";
            echo "</thead>";

            echo "<tbody>";
            for ($i = 0; $i <= 10; $i++) {
                echo "<tr>";
                echo "<th>$i</th>";
                for ($j = 0; $j <= 10; $j++) {
                    echo "<td>" . ($i * $j) . "</td>";
                }
                echo "</tr>";
            }
            echo "</tbody>";
        ?>
    </table>
</body>
</html>
