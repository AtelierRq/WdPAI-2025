const roomsConfig = {
    Polana: {
        label: 'Polana – 1 łóżko podwójne, prywatna łazienka',
        beds: 2,
        prices: {1: 150, 2: 200}
    },
    Homola: {
        label: 'Homola – 1 łóżko podwójne, 1 łóżko pojedyncze, prywatna łazienka',
        beds: 3,
        prices: {1: 100, 2: 200, 3: 250}
    },
    Kopa: {
        label: 'Kopa – 2 łóżka pojedyncze, dzielona łazienka',
        beds: 2,
        prices: {1: 100, 2: 200}
    },
    Skałka: {
        label: 'Skałka – 4 łóżka pojedyncze, dzielona łazienka',
        beds: 4,
        prices: {1: 100, 2: 200, 3: 250, 4: 300}
    }
};

const roomIds = {
    Polana: 1,
    Homola: 2,
    Kopa: 3,
    Skałka: 4
};

const MAX_ROOMS = 4;

const roomsContainer = document.getElementById('roomsContainer');
const addRoomBtn = document.getElementById('addRoomBtn');
const dateFrom = document.getElementById('dateFrom');
const dateTo = document.getElementById('dateTo');
const adults = document.getElementById('adults');
const children = document.getElementById('children');
const infants = document.getElementById('infants');
const breakfast = document.getElementById('breakfast');
const totalPriceEl = document.getElementById('totalPrice');
const errorEl = document.getElementById('priceError');
const submitBtn = document.getElementById('submitBtn');

const childPrice = 50;
const infantPrice = 30;
const breakfastPrice = 40;

// INIT
refreshAllSelects();
bindGlobalListeners();
updateAddRoomButtonState();

// EVENTY
addRoomBtn.addEventListener('click', () => {
    if (getRoomRows().length >= MAX_ROOMS) return;
    const row = createRoomRow();
    roomsContainer.appendChild(row);
    refreshAllSelects();
    calculate();
});

roomsContainer.addEventListener('change', e => {
    if (e.target.classList.contains('room-select')) {
        refreshAllSelects();
        calculate();
    }
});

roomsContainer.addEventListener('click', e => {
    if (e.target.classList.contains('remove-room')) {
        e.target.parentElement.remove();
        refreshAllSelects();
        calculate();
    }
});

function bindGlobalListeners() {
    [dateFrom, dateTo, adults, children, infants, breakfast]
        .forEach(el =>
            el.addEventListener('change', () => {
                calculate();
                updateAddRoomButtonState();
            })
        );
}

// ROOM ROW
function createRoomRow() {
    const div = document.createElement('div');
    div.className = 'room-row';

    const select = document.createElement('select');
    select.className = 'room-select';

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'remove-room';
    btn.textContent = '✕';

    div.append(select, btn);
    return div;
}

function getRoomRows() {
    return [...document.querySelectorAll('.room-row')];
}

function getSelectedRooms() {
    return [...document.querySelectorAll('.room-select')]
        .map(s => s.value)
        .filter(Boolean);
}

// SELECTY
function refreshAllSelects() {
    const selected = getSelectedRooms();
    const rows = getRoomRows();

    rows.forEach((row, index) => {
        const select = row.querySelector('.room-select');
        const removeBtn = row.querySelector('.remove-room');

        removeBtn.disabled = index === 0;

        const current = select.value;
        select.innerHTML = '';
        addOption(select, '', '-- wybierz pokój --');

        Object.keys(roomsConfig).forEach(room => {
            if (!selected.includes(room) || room === current) {
                addOption(select, room, roomsConfig[room].label);
            }
        });

        select.value = current;
    });

    addRoomBtn.disabled = rows.length >= MAX_ROOMS;
}

function addOption(select, value, label) {
    const opt = document.createElement('option');
    opt.value = value;
    opt.textContent = label;
    select.appendChild(opt);
}

// CENA
function calculate() {
    errorEl.innerText = '';
    submitBtn.disabled = true;

    const selectedRooms = getSelectedRooms();
    if (!selectedRooms.length) {
        updatePrice(0);
        syncFormData();
        return;
    }

    const from = new Date(dateFrom.value);
    const to = new Date(dateTo.value);
    if (isNaN(from) || isNaN(to) || from >= to) {
        updatePrice(0);
        syncFormData();
        return;
    }

    const days = (to - from) / (1000 * 60 * 60 * 24);
    const adultsCount = +adults.value;
    const childrenCount = +children.value;
    const infantsCount = +infants.value;

    const peopleUsingBeds = adultsCount + childrenCount;
    const totalBeds = selectedRooms.reduce(
        (sum, r) => sum + roomsConfig[r].beds,
        0
    );

    if (peopleUsingBeds > totalBeds) {
        errorEl.innerText =
            'Liczba gości przekracza liczbę miejsc w wybranych pokojach. Dodaj lub wybierz inny pokój.';
        updatePrice(0);
        syncFormData();
        return;
    }

    let remaining = peopleUsingBeds;
    let roomCost = 0;

    selectedRooms.forEach(room => {
        const beds = roomsConfig[room].beds;
        const used = Math.min(beds, remaining);

        if (used > 0) {
            roomCost += roomsConfig[room].prices[used] * days;
        }

        remaining -= used;
    });

    let total =
        roomCost +
        childrenCount * childPrice * days +
        infantsCount * infantPrice * days;

    if (breakfast.checked) {
        total +=
            (adultsCount + childrenCount + infantsCount) *
            breakfastPrice * days;
    }

    if (days > 3) total *= 0.95;

    updatePrice(Math.round(total));
    submitBtn.disabled = !isFormValid();
    syncFormData();
}

function updatePrice(val) {
    totalPriceEl.innerText = val + ' zł';
}

function updateAddRoomButtonState() {
    const peopleUsingBeds = +adults.value + +children.value;
    addRoomBtn.disabled = peopleUsingBeds < 3;
}

function isFormValid() {
    if (!dateFrom.value || !dateTo.value) return false;
    if (!document.getElementById('fullName').value.trim()) return false;
    if (!document.getElementById('email').value.trim()) return false;
    if (!document.getElementById('phone').value.trim()) return false;
    if (!getSelectedRooms().length) return false;

    const peopleUsingBeds = +adults.value + +children.value;
    const totalBeds = getSelectedRooms()
        .reduce((sum, r) => sum + roomsConfig[r].beds, 0);

    if (peopleUsingBeds > totalBeds) return false;

    return true;
}

function syncFormData() {
    document.getElementById('roomsInput').value = getSelectedRooms().map(roomKey => roomIds[roomKey]).join(',');
    document.getElementById('priceInput').value = totalPriceEl.innerText.replace(' zł', '');
}