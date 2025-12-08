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
            <div class="col-md-3">
                <label class="form-label fw-semibold text-secondary">Item Name <span class="text-danger">*</span></label>
                <input type="text" name="itemName[]" class="form-control shadow-sm">
            </div>

            <div class="col-md-1">
                <label class="form-label fw-semibold text-secondary">Quantity <span class="text-danger">*</span></label>
                <input type="number" name="qty[]" class="form-control shadow-sm">
            </div>

            <div class="col-md-1">
                <label class="form-label fw-semibold text-secondary">Pcs/Kg/L <span class="text-danger">*</span></label>
                <input type="number" name="qtySet[]" value="1" class="form-control shadow-sm">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold text-secondary">Size <span class="text-danger">*</span></label>
                <input type="text" name="size[]" class="form-control shadow-sm">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold text-secondary">Price per Unit <span class="text-danger">*</span></label>
                <input type="text" name="unitPrice[]" class="form-control shadow-sm">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold text-secondary">
                    <i class="bi bi-weight text-success"></i> Type <span class="text-danger">*</span>
                </label>

                <select name="typeSelect[]" class="form-select shadow-sm placeType">
                    <option value="" selected>Select Type</option>
                    <option value="Consumable">Consumable</option>
                    <option value="Non-Consumable">Non-Consumable</option>

                </select>
            </div>

            <div class="col-md-1 align-items-start">
                <label class="form-label fw-semibold text-secondary">Remove</label>
                <button type="button" class="btn btn-outline-danger remove-btn">
                    <i class="bi bi-x-circle"></i>
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


// get stock

function setStock() {
    var get = document.getElementById('select_stock');


    if (!get) return;

    if (get.value.trim() === "") {
        alert("Input is empty");
        return;
    }

    if (get) {
        var idData = get.options[get.selectedIndex].value;
        let forName = idData.slice(0, idData.indexOf(","));
        let forSize = idData.slice(idData.indexOf(",") + 1);

        //const addBtn = document.getElementById('add_new');
        const pasteHere = document.getElementById('pasteHere');

        const template = `
            <div class="row g-2 mb-2 px-3 py-2 bg-light rounded-3 shadow-sm form-section">
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">
                        <i class="bi bi-receipt" style="color:#60BF4F"></i> Item Name
                    </label>
                    <input type="text" name="itemName[]" class="form-control shadow-sm" value="${forName}">
                </div>

                <div class="col-md-1">
                    <label class="form-label fw-semibold text-secondary">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="qty[]" class="form-control shadow-sm">
                </div>

                <div class="col-md-1">
                    <label class="form-label fw-semibold text-secondary">Pcs/Kg/L <span class="text-danger">*</span></label>
                    <input type="number" name="qtySet[]" value="1" class="form-control shadow-sm">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary">Size</label>
                    <input type="text" name="size[]" class="form-control shadow-sm" value="${forSize}">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary">Price per Unit <span class="text-danger">*</span></label>
                    <input type="text" name="unitPrice[]" class="form-control shadow-sm">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary">Type</label>
                    <input type="text" name="typeSelect[]" class="form-control shadow-sm" value="Consumable" readonly>
                </div>
                

                <div class="col-md-1 align-items-start">
                    <label class="form-label fw-semibold text-secondary">Remove</label>
                    <button type="button" class="btn btn-outline-danger remove-btn">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        `;

        pasteHere.insertAdjacentHTML("beforeend", template);

    } else {
        document.getElementById("itemName").value = '';
    }

}

// get equipment

function setEquipment() {

    var get = document.getElementById('select_equipment');
    if (!get) return;

    if (get.value.trim() === "") {
        alert("Input is empty");
        return;
    }
    if (get) {
        var idData = get.options[get.selectedIndex].value;
        let forName = idData.slice(0, idData.indexOf(","));
        let forSize = idData.slice(idData.indexOf(",") + 1);

        //document.getElementById("itemName").value = forQty;

        //const addBtn = document.getElementById('add_new');
        const pasteHere = document.getElementById('pasteHere');


        const template = `
            <div class="row g-2 mb-2 px-3 py-2 bg-light rounded-3 shadow-sm form-section">
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Item Name</label>
                    <input type="text" name="itemName[]" class="form-control shadow-sm" value="${forName}">
                </div>

                <div class="col-md-1">
                    <label class="form-label fw-semibold text-secondary">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="qty[]" class="form-control shadow-sm">
                </div>

                <div class="col-md-1">
                    <label class="form-label fw-semibold text-secondary">Pcs/Kg/L <span class="text-danger">*</span></label>
                    <input type="number" name="qtySet[]" value="1" class="form-control shadow-sm">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary">Size</label>
                    <input type="text" name="size[]" class="form-control shadow-sm" value="${forSize}">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary">Price per Unit <span class="text-danger">*</span></label>
                    <input type="text" name="unitPrice[]" class="form-control shadow-sm">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary">Type</label>
                    <input type="text" name="typeSelect[]" class="form-control shadow-sm" value="Non-Consumable" readonly>
                </div>
                

                <div class="col-md-1 align-items-start">
                    <label class="form-label fw-semibold text-secondary">Remove</label>
                    <button type="button" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 remove-btn">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        `;

        pasteHere.insertAdjacentHTML("beforeend", template);

    } else {
        document.getElementById("itemName").value = '';
    }

}


//set type for PO
function getType() {
    const getType = document.getElementById("placeType");
    const set = document.getElementById("setType");
    const setType = getType.options[getType.selectedIndex].value;
    set.value = setType;
}






document.addEventListener('DOMContentLoaded', function () {
    // Initialize tooltips globally
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Reinitialize tooltips each time a modal is shown (fix for modals and dynamic content)
    // document.addEventListener('shown.bs.modal', function () {
    //     var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    //     tooltipTriggerList.map(function (tooltipTriggerEl) {
    //         return new bootstrap.Tooltip(tooltipTriggerEl);
    //     });
    // });
});


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

    var idData = get.options[get.selectedIndex].value;
    let forId = idData.slice(0, idData.indexOf(","));
    let forName = idData.slice(idData.indexOf(",") + 1, idData.indexOf(":"));
    let forSize = idData.slice(idData.indexOf(":") + 1, idData.indexOf(";"));
    let forAvail = idData.slice(idData.indexOf(";") + 1);

    const wrapper = document.createElement('div');
    wrapper.classList.add('row', 'g-2', 'align-items-start', 'mb-2', 'added-item');

    wrapper.innerHTML = `
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary">Equipment</label>
            <input type="text" class="form-control" name="eqName[]" value="${forName}" readonly>
            <input type="text" name="equipment[]" value="${forId}" hidden>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary">Size</label>
            <input type="text" class="form-control" name="eqSize[]" value="${forSize}" readonly>     
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary">In Stock</label>
            <input type="text" class="form-control" name="eqAvail[]"  value="${forAvail}" readonly>
        </div>
        <div class="col-md-5">
            <label class="form-label fw-semibold text-secondary">Qty. <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="eqQty[]" value="1">     
        </div>
        <div class="col-md-5">
            <label class="form-label fw-semibold text-secondary">Pcs/Kg/L <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="eqQtySet[]" value="1">     
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold text-secondary">Remove</label>
            <button type="button" class="btn btn-outline-danger w-100 remove-eq">
                <i class="bi bi-x-circle remove-eq"></i>
            </button>
        </div>
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

    
    var idData = get.options[get.selectedIndex].value;
    let forId = idData.slice(0, idData.indexOf(","));
    let forName = idData.slice(idData.indexOf(",") + 1, idData.indexOf(":"));
    let forSize = idData.slice(idData.indexOf(":") + 1, idData.indexOf(";"));
    let forAvail = idData.slice(idData.indexOf(";") + 1);

    const wrapper = document.createElement('div');
    wrapper.classList.add('row', 'g-2', 'align-items-start', 'mb-2', 'added-item');

    wrapper.innerHTML = `
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary">Stock</label>
            <input type="text" class="form-control" name="itemName[]" value="${forName}" readonly>
            <input type="text" name="stock[]" value="${forId}" hidden>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary">Size</label>
            <input type="text" class="form-control" name="stoSize[]" value="${forSize}" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary">In Stock</label>
            <input type="text" class="form-control" name="stoAvail[]" value="${forAvail}" readonly>
        </div>
        <div class="col-md-5">
            <label class="form-label fw-semibold text-secondary">Qty. <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="stockQty[]" value="1">
        </div>
        <div class="col-md-5">
            <label class="form-label fw-semibold text-secondary">Pcs/Kg/L <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="stockQtySet[]" value="1">
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold text-secondary">Remove</label>
            <button type="button" class="btn btn-outline-danger w-100 remove-sto"><i class="bi bi-x-circle remove-sto"></i> </button>
        </div>
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

            const cells = Array.from(row.cells);
            const match = cells.some(cell => cell.innerText.toLowerCase().includes(filter));
            row.style.display = match ? '' : 'none';
        });
    });

    clearSearch.addEventListener('click', function () {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input')); // reset table
    });
}
