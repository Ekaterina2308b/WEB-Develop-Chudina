const holidays = {
    "1-1": "Новый год",
	"1-7": "Рождество Христово",
	"2-23": "День защитника Отечества",
	"3-8": "Международный женский день",
    "5-1": "Праздник Весны и Труда",
    "5-9": "День Победы",
    "6-12": "День России",
	"11-4": "День народного единства",
	"9-1": "День знаний",
	"12-31": "Новый год (предпраздничный день)",
};

document.addEventListener("DOMContentLoaded", () => {
    const monthSelect = document.getElementById("month-select");
    const yearSelect = document.getElementById("year-select");
    const calendar = document.getElementById("calendar");

    const months = [
        "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
        "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
    ];
    months.forEach((month, index) => {
        const option = document.createElement("option");
        option.value = index;
        option.textContent = month;
        monthSelect.appendChild(option);
    });

    const currentYear = new Date().getFullYear();
    for (let year = currentYear - 10; year <= currentYear + 10; year++) {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }

    monthSelect.value = new Date().getMonth();
    yearSelect.value = currentYear;

    document.getElementById("generate-calendar").addEventListener("click", () => {
        const selectedMonth = parseInt(monthSelect.value);
        const selectedYear = parseInt(yearSelect.value);
        generateCalendar(selectedYear, selectedMonth);
    });

    generateCalendar(currentYear, new Date().getMonth());
});

function generateCalendar(year, month) {
    const calendar = document.getElementById("calendar");
    calendar.innerHTML = ""

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    const weekDays = ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"];
    weekDays.forEach(day => {
        const dayElem = document.createElement("div");
        dayElem.textContent = day;
        dayElem.className = "weekday";
        calendar.appendChild(dayElem);
    });

    for (let i = 0; i < (firstDay === 0 ? 6 : firstDay - 1); i++) {
        const emptyCell = document.createElement("div");
        calendar.appendChild(emptyCell);
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const dayElem = document.createElement("div");
        dayElem.textContent = day;

        const isWeekend = date.getDay() === 0 || date.getDay() === 6;
        const holidayKey = `${month + 1}-${day}`;

        if (holidays[holidayKey]) {
            dayElem.className = "holiday";
            dayElem.title = holidays[holidayKey];
        } else if (isWeekend) {
            dayElem.className = "weekend";
        }

        calendar.appendChild(dayElem);
    }
}
