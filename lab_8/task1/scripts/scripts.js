const table = document.getElementById('multiplication-table');

const thead = document.createElement('thead');
const headerRow = document.createElement('tr');

const emptyCell = document.createElement('th');
emptyCell.textContent = '×';
headerRow.appendChild(emptyCell);

for (let i = 0; i <= 10; i++) {
    const th = document.createElement('th');
    th.textContent = i;
    headerRow.appendChild(th);
}

thead.appendChild(headerRow);
table.appendChild(thead);

const tbody = document.createElement('tbody');

for (let i = 0; i <= 10; i++) {
    const row = document.createElement('tr');
    
    const th = document.createElement('th');
    th.textContent = i;
    row.appendChild(th);
    
    for (let j = 0; j <= 10; j++) {
        const td = document.createElement('td');
        td.textContent = i * j;
        row.appendChild(td);
    }

    tbody.appendChild(row);
}

table.appendChild(tbody);
