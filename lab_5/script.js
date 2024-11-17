function getMushroomString(count) {
    const lastDigit = count % 10;
    const lastTwoDigits = count % 100;

    if (lastTwoDigits >= 11 && lastTwoDigits <= 14) {
        return count + " грибов";
    }

    switch (lastDigit) {
        case 1:
            return count + " гриб";
        case 2:
        case 3:
        case 4:
            return count + " гриба";
        default:
            return count + " грибов";
    }
}

function showMushroomText() {
    const count = document.getElementById('arrayInput1').value;
    const output = document.getElementById('result1');

    if (count !== "") {
        output.textContent = getMushroomString(parseInt(count));
    } else {
        output.textContent = "Пожалуйста, введите число!";
    }
}

function calculateSum() {
    const input = document.getElementById('arrayInput2').value;
    const arr = input.split(',').map(item => parseFloat(item.trim()));

    let sum = 0;
    let lastNegativeCosineIndex = -1;

    for (let i = 0; i < arr.length; i++) {
        const cosValue = Math.cos(arr[i]);
        if (cosValue < 0) {
            lastNegativeCosineIndex = i;
        }
    }

    if (lastNegativeCosineIndex !== -1) {
        for (let i = 0; i < lastNegativeCosineIndex; i++) {
            sum += arr[i];
        }

        const result = document.getElementById('result2');
        result.textContent = "Сумма элементов до последнего отрицательного косинуса (не включая его): " + sum;
    } else {
        const result = document.getElementById('result2');
        result.textContent = "Нет элементов с отрицательным косинусом.";
    }
}

function filterArray() {
    const input = document.getElementById('arrayInput3').value;
    const arr = input.split(',').map(item => eval(item.trim()));

    const filteredArray = arr.filter(item => {
        const integerPart = Math.floor(Math.abs(item));
        return sumOfDigits(integerPart) % 2 === 0;
    });

    const result = document.getElementById('result3'); 
    result.textContent = "Отфильтрованный массив: " + JSON.stringify(filteredArray);
}

function sumOfDigits(num) {
    let sum = 0;
    while (num > 0) {
        sum += num % 10;
        num = Math.floor(num / 10);
    }
    return sum;
}

 function isPalindrome(word) {
	const cleanedWord = word.toLowerCase().replace(/[^a-zа-яё]/g, '');
	const reversedWord = cleanedWord.split('').reverse().join('');
	return cleanedWord === reversedWord;
}

function checkPalindrome() {
	const word = document.getElementById("arrayInput4").value;
    const resultElement = document.getElementById("result4");
            
    if (isPalindrome(word)) {
		resultElement.textContent = `"${word}" является палиндромом!`;
	} else {
		resultElement.textContent = `"${word}" не является палиндромом.`;
	}
}