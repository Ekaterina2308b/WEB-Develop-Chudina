<?php
$holidays = [
    "1-1" => "Новый год",
    "1-7" => "Рождество Христово",
    "2-23" => "День защитника Отечества",
    "3-8" => "Международный женский день",
    "5-1" => "Праздник Весны и Труда",
    "5-9" => "День Победы",
    "6-12" => "День России",
    "11-4" => "День народного единства",
    "9-1" => "День знаний",
    "12-31" => "Новый год (предпраздничный день)",
];

$months = [
    "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
    "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
];

$currentYear = date("Y");
$currentMonth = date("n") - 1;

$selectedYear = isset($_POST['year']) ? (int)$_POST['year'] : $currentYear;
$selectedMonth = isset($_POST['month']) ? (int)$_POST['month'] : $currentMonth;

function generateCalendar($year, $month, $holidays) {
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month + 1, $year);
    $firstDayOfMonth = date('N', strtotime("$year-" . ($month + 1) . "-01"));
    $calendarHtml = "<div id='calendar'>";

    $weekDays = ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"];
    foreach ($weekDays as $day) {
        $calendarHtml .= "<div class='weekday'>$day</div>";
    }

    for ($i = 1; $i < $firstDayOfMonth; $i++) {
        $calendarHtml .= "<div></div>";
    }

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = strtotime("$year-" . ($month + 1) . "-$day");
        $isWeekend = date('N', $date) >= 6;
        $holidayKey = ($month + 1) . "-$day";

        $class = '';
        $title = '';

        if (isset($holidays[$holidayKey])) {
            $class = 'holiday';
            $title = $holidays[$holidayKey];
        } elseif ($isWeekend) {
            $class = 'weekend';
        }

        $calendarHtml .= "<div class='$class' title='$title'>$day</div>";
    }

    $calendarHtml .= "</div>";
    return $calendarHtml;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Календарь</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="calendar-container">
        <form method="POST">
            <div class="controls">
                <select name="month">
                    <?php foreach ($months as $index => $month): ?>
                        <option value="<?= $index ?>" <?= $index == $selectedMonth ? 'selected' : '' ?>>
                            <?= $month ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select name="year">
                    <?php for ($year = $currentYear - 10; $year <= $currentYear + 10; $year++): ?>
                        <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>>
                            <?= $year ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <button type="submit">Показать календарь</button>
            </div>
        </form>
        <?= generateCalendar($selectedYear, $selectedMonth, $holidays); ?>
    </div>
</body>
</html>
