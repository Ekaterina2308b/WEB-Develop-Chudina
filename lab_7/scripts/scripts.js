let currentInput = "";
let operator = null;
let previousInput = "";

function appendNumber(number) {
    currentInput += number;
    document.getElementById('screen').value = currentInput;
}

function setOperator(op) {
    if (currentInput === "") return;
    if (previousInput !== "") {
        calculate();
    }
    operator = op;
    previousInput = currentInput;
    currentInput = "";
}

function clearScreen() {
    currentInput = "";
    previousInput = "";
    operator = null;
    document.getElementById('screen').value = "";
}

function toggleSign() {
    if (currentInput !== "") {
        currentInput = (parseFloat(currentInput) * -1).toString();
        document.getElementById('screen').value = currentInput;
    }
}

function calculateInverse() {
    if (currentInput !== "") {
        const num = parseFloat(currentInput);
        if (num !== 0) {
            currentInput = (1 / num).toString();
            document.getElementById('screen').value = currentInput;
        } else {
            alert("Ошибка: деление на ноль");
            clearScreen();
        }
    }
}

function calculateSquareRoot() {
    if (currentInput !== "") {
        const num = parseFloat(currentInput);
        if (num >= 0) {
            currentInput = Math.sqrt(num).toString();
            document.getElementById('screen').value = currentInput;
        } else {
            alert("Ошибка: нельзя извлечь квадратный корень из отрицательного числа");
            clearScreen();
        }
    }
}

function calculatePercentage() {
    if (currentInput !== "") {
        const num = parseFloat(currentInput);
        currentInput = (num / 100).toString();
        document.getElementById('screen').value = currentInput;
    }
}

function calculate() {
    if (previousInput === "" || currentInput === "") return;
    let result;
    const prev = parseFloat(previousInput);
    const current = parseFloat(currentInput);

    switch (operator) {
        case '+':
            result = prev + current;
            break;
        case '-':
            result = prev - current;
            break;
        case '*':
            result = prev * current;
            break;
        case '/':
            if (current === 0) {
                alert("Ошибка: деление на ноль");
                clearScreen();
                return;
            }
            result = prev / current;
            break;
        default:
            return;
    }
    
    currentInput = result.toString();
    operator = null;
    previousInput = "";
    document.getElementById('screen').value = currentInput;
}
