//const { createElement } = require("react");
/*
const btnList = document.querySelectorAll('.selected');

btnList.forEach(btn => {
    btn.addEventListener('click', () => {
        btn.classList.add('active-item');
    });
});
//btnList.addEventListener('click', () => {
//    btnList.classList.add('active-item');
//});         
*/

// ===============================
// For Purchase Order (PO) Section
// ===============================
if (document.getElementById('add_new')) {
    const addBtn = document.getElementById('add_new');
    const pasteHere = document.getElementById('pasteHere');

    const template = `
        <div class="row g-2 mb-2 px-3 py-2 bg-light rounded-3 shadow-sm form-section">
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary">
                    <i class="bi bi-receipt" style="color:#60BF4F"></i> Item Name
                </label>
                <input type="text" name="itemName[]" class="form-control shadow-sm">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold text-secondary">
                    <i class="bi bi-box" style="color:#60BF4F"></i> Quantity
                </label>
                <input type="number" name="qty[]" class="form-control shadow-sm">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold text-secondary">
                    <i class="bi bi-tag" style="color:#60BF4F"></i> Unit Price
                </label>
                <input type="text" name="unitPrice[]" class="form-control shadow-sm">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold text-secondary">
                    <i class="bi bi-weight" style="color:#60BF4F"></i> Size/Weight
                </label>
                <input type="text" name="sizeWeigth[]" class="form-control shadow-sm">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 remove-btn">
                    <i class="bi bi-x-circle"></i> Remove
                </button>
            </div>
        </div>
    `;

    // Add new row
    addBtn.addEventListener("click", function () {
        pasteHere.insertAdjacentHTML("beforeend", template);
    });

    // Remove row (event delegation)
    pasteHere.addEventListener("click", function (e) {
        if (e.target.closest(".remove-btn")) {
            e.target.closest(".form-section").remove();
        }
    });
}



// ===============================
// For Service Request Section
// ===============================

// --- EQUIPMENT --- //

function getQty() {
    const get = document.getElementById('equipment');
    const availInput = document.getElementById("avail");

    if (get && availInput) {
        const idData = get.options[get.selectedIndex].value;
        const forQty = idData.slice(idData.indexOf(",") + 1);
        availInput.value = forQty;
    } else if (availInput) {
        availInput.value = '';
    }
}

function checkInputEq() {
    const input = document.getElementById("avail");
    const get = document.getElementById('equipment');
    if (!input || !get) return;

    if (input.value.trim() === "") {
        alert("Input is empty");
        return;
    }

    const selectedOption = get.options[get.selectedIndex];
    const nameData = selectedOption.text.trim();
    const idData = selectedOption.value.split(",")[0];

    const wrapper = document.createElement('div');
    wrapper.classList.add('row', 'g-2', 'align-items-end', 'mb-2', 'added-item');

    wrapper.innerHTML = `
        <div class="col-md-6">
            <label class="form-label fw-semibold text-secondary">Equipment</label>
            <input type="text" class="form-control" value="${nameData}" readonly>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold text-secondary">Qty</label>
            <input type="number" class="form-control" name="eqQty[]" placeholder="Qty">
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-outline-danger w-100 remove-eq mt-4">
                <i class="bi bi-x-circle"></i> Remove
            </button>
        </div>
        <input type="hidden" name="equipment[]" value="${idData}">
    `;

    document.getElementById('addEquipment').appendChild(wrapper);
}

// remove equipment row
if (document.getElementById('addEquipment')) {
    document.getElementById('addEquipment').addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('remove-eq')) {
            event.target.closest('.added-item').remove();
        }
    });
}



// --- STOCK --- //

function getQtySto() {
    const get = document.getElementById('stock');
    const stoInput = document.getElementById("sto");

    if (get && stoInput) {
        const idData = get.options[get.selectedIndex].value;
        const forQty = idData.slice(idData.indexOf(",") + 1);
        stoInput.value = forQty;
    } else if (stoInput) {
        stoInput.value = '';
    }
}

function checkInputSto() {
    const input = document.getElementById("sto");
    const get = document.getElementById('stock');
    if (!input || !get) return;

    if (input.value.trim() === "") {
        alert("Input is empty");
        return;
    }

    const selectedOption = get.options[get.selectedIndex];
    const nameData = selectedOption.text.trim();
    const idData = selectedOption.value.split(",")[0];

    const wrapper = document.createElement('div');
    wrapper.classList.add('row', 'g-2', 'align-items-end', 'mb-2', 'added-item');

    wrapper.innerHTML = `
        <div class="col-md-6">
            <label class="form-label fw-semibold text-secondary">Stock</label>
            <input type="text" class="form-control" value="${nameData}" readonly>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold text-secondary">Stock Qty</label>
            <input type="number" class="form-control" name="stockQty[]" placeholder="Stock Qty">
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-outline-danger w-100 remove-sto mt-4">
                <i class="bi bi-x-circle"></i> Remove
            </button>
        </div>
        <input type="hidden" name="stock[]" value="${idData}">
    `;

    document.getElementById('addStock').appendChild(wrapper);
}

// remove stock row
if (document.getElementById('addStock')) {
    document.getElementById('addStock').addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('remove-sto')) {
            event.target.closest('.added-item').remove();
        }
    });
}



// ===============================
// Table Search Filtering
// ===============================
const searchInput = document.getElementById('searchInput');
const clearSearch = document.getElementById('clearSearch');

if (searchInput && clearSearch) {
    searchInput.addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#tableBody tr");

        rows.forEach(row => {
            const address = row.cells[0].innerText.toLowerCase();
            const qty = row.cells[1].innerText.toLowerCase();
            if (address.includes(filter) || qty.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    clearSearch.addEventListener('click', function () {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input')); // reset table
    });
}
