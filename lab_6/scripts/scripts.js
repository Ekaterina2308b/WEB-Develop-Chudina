document.addEventListener("DOMContentLoaded", function () {
    var phoneInputs = document.querySelectorAll('input.tel');
    var dateInputs = document.querySelectorAll('input.date');

    var getInputNumbersValue = function (input) {
        return input.value.replace(/\D/g, '');
    };

    var onPhonePaste = function (e) {
        var input = e.target,
            inputNumbersValue = getInputNumbersValue(input);
        var pasted = e.clipboardData || window.clipboardData;
        if (pasted) {
            var pastedText = pasted.getData('Text');
            if (/\D/g.test(pastedText)) {
                input.value = inputNumbersValue;
                return;
            }
        }
    };

    var onPhoneInput = function (e) {
        var input = e.target,
            inputNumbersValue = getInputNumbersValue(input),
            selectionStart = input.selectionStart,
            formattedInputValue = "";

        if (!inputNumbersValue) {
            return input.value = "";
        }

        if (input.value.length != selectionStart) {
            if (e.data && /\D/g.test(e.data)) {
                input.value = inputNumbersValue;
            }
            return;
        }

        if (["7", "8", "9"].indexOf(inputNumbersValue[0]) > -1) {
            if (inputNumbersValue[0] == "9") inputNumbersValue = "7" + inputNumbersValue;
            var firstSymbols = (inputNumbersValue[0] == "8") ? "8" : "+7";
            formattedInputValue = input.value = firstSymbols + " ";
            if (inputNumbersValue.length > 1) {
                formattedInputValue += '(' + inputNumbersValue.substring(1, 4);
            }
            if (inputNumbersValue.length >= 5) {
                formattedInputValue += ') ' + inputNumbersValue.substring(4, 7);
            }
            if (inputNumbersValue.length >= 8) {
                formattedInputValue += '-' + inputNumbersValue.substring(7, 9);
            }
            if (inputNumbersValue.length >= 10) {
                formattedInputValue += '-' + inputNumbersValue.substring(9, 11);
            }
        } else {
            formattedInputValue = '+' + inputNumbersValue.substring(0, 16);
        }
        input.value = formattedInputValue;
    };

    var onPhoneKeyDown = function (e) {
        var inputValue = e.target.value.replace(/\D/g, '');
        if (e.keyCode == 8 && inputValue.length == 1) {
            e.target.value = "";
        }
    };

    var onPhoneFocus = function (e) {
        var input = e.target;
        if (input.value === "") {
            input.value = "+7 ";
            input.setSelectionRange(3, 3); 
        }
    };

    var onDateInput = function (e) {
        var input = e.target,
            inputNumbersValue = getInputNumbersValue(input),
            formattedInputValue = "";

        if (!inputNumbersValue) {
            return input.value = "";
        }

        if (inputNumbersValue.length <= 2) {
            formattedInputValue = inputNumbersValue;
        } else if (inputNumbersValue.length <= 4) {
            formattedInputValue = inputNumbersValue.substring(0, 2) + "." + inputNumbersValue.substring(2, 4);
        } else if (inputNumbersValue.length <= 8) {
            formattedInputValue = inputNumbersValue.substring(0, 2) + "." + inputNumbersValue.substring(2, 4) + "." + inputNumbersValue.substring(4, 8);
        } else {
            formattedInputValue = inputNumbersValue.substring(0, 2) + "." + inputNumbersValue.substring(2, 4) + "." + inputNumbersValue.substring(4, 8);
        }

        var day = parseInt(inputNumbersValue.substring(0, 2));
        var month = parseInt(inputNumbersValue.substring(2, 4));

        if (day > 31) {
            formattedInputValue = "31." + inputNumbersValue.substring(2, 4) + "." + inputNumbersValue.substring(4, 8);
        }
        if (month > 12) {
            formattedInputValue = inputNumbersValue.substring(0, 2) + ".12." + inputNumbersValue.substring(4, 8);
        }

        input.value = formattedInputValue;
    };

    for (var phoneInput of phoneInputs) {
        phoneInput.addEventListener('keydown', onPhoneKeyDown);
        phoneInput.addEventListener('input', onPhoneInput, false);
        phoneInput.addEventListener('paste', onPhonePaste, false);
        phoneInput.addEventListener('focus', onPhoneFocus);
    }

    for (var dateInput of dateInputs) {
        dateInput.addEventListener('input', onDateInput, false);
    }

    function validateRequiredFields() {
        const requiredFields = document.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(function(field) {
            const errorMessageElement = field.nextElementSibling;

            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('error');
                errorMessageElement.textContent = "Это поле обязательно для заполнения.";
            } else {
                field.classList.remove('error');
                errorMessageElement.textContent = "";
            }
        });

        return isValid;
    }

    function validateForm() {
        let isValid = validateRequiredFields();

        const phoneInput = document.getElementById('owner-phone');
        const phoneValue = getInputNumbersValue(phoneInput);
        const dateInput = document.getElementById('reg-date');
        const dateValue = dateInput.value;

        const phoneErrorElement = phoneInput.nextElementSibling;
		console.log(phoneValue.length);
        if (phoneValue.length !== 11) {
            isValid = false;
            phoneInput.classList.add('error');
            phoneErrorElement.textContent = "Введите корректный номер телефона.";
        } else {
            phoneInput.classList.remove('error');
            phoneErrorElement.textContent = "";
        }

        const dateErrorElement = dateInput.nextElementSibling;
        const datePattern = /^(0[1-9]|[12][0-9]|3[01])\.(0[1-9]|1[0-2])\.\d{4}$/;
        if (!datePattern.test(dateValue)) {
            isValid = false;
            dateInput.classList.add('error');
            dateErrorElement.textContent = "Введите корректную дату (ДД.ММ.ГГГГ).";
        } else {
            dateInput.classList.remove('error');
            dateErrorElement.textContent = "";
        }

        return isValid;
    }

    var form = document.getElementById('car-registration-form');
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        if (!validateForm()) {
            return;
        }

        var ownerName = document.getElementById('owner-name').value;
        var ownerPhone = document.getElementById('owner-phone').value;
        var carMake = document.getElementById('car-make').value;
        var carModel = document.getElementById('car-model').value;
        var regDate = document.getElementById('reg-date').value;
        var carMileage = document.getElementById('car-mileage').value;
        var carPrice = document.getElementById('car-price').value;

        document.getElementById('preview-owner-name').textContent = ownerName;
        document.getElementById('preview-owner-phone').textContent = ownerPhone;
        document.getElementById('preview-car-make').textContent = carMake;
        document.getElementById('preview-car-model').textContent = carModel;
        document.getElementById('preview-reg-date').textContent = regDate;
        document.getElementById('preview-car-mileage').textContent = carMileage;
        document.getElementById('preview-car-price').textContent = carPrice;

        form.reset();
    });
});
