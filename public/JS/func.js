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

// For Po
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



// For service request

function getQty() {
    var get = document.getElementById('equipment');
    if (get) {
        var idData = get.options[get.selectedIndex].value;
        let forQty = idData.slice(idData.indexOf(",") + 1);
        document.getElementById("avail").value = forQty;
    } else {
        document.getElementById("avail").value = '';
    }

}


if (document.getElementById('equipment')) {
    document.getElementById('add_eq').addEventListener('click', () => {

        var get = document.getElementById('equipment');

        var nameData = get.options[get.selectedIndex].innerText;
        var idData = get.options[get.selectedIndex].value;

        let forId = idData.slice(0, idData.indexOf(","));

        const wrapper = document.createElement('div');
        wrapper.classList.add('input-group-eq');

        wrapper.innerHTML = `
            <input type="text" name=""  value="` + nameData + `">
            <input type="text" name="equipment[]" value="`+ forId + `">      
            <input type="number" name="eqQty[]" placeholder="qty">
            <button type="button" class="remove-eq">Remove</button>
        `;

        document.getElementById('addEquipment').appendChild(wrapper);
    });

    document.getElementById('addEquipment').addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('remove-eq')) {
            event.target.closest('.input-group-eq').remove();
        }
    });
}

// for stock 
function getQtySto() {
    var get = document.getElementById('stock');
    if (get) {
        var idData = get.options[get.selectedIndex].value;
        let forQty = idData.slice(idData.indexOf(",") + 1);
        document.getElementById("sto").value = forQty;
    } else {
        document.getElementById("sto").value = '';
    }

}

if (document.getElementById('add_sto')) {
    document.getElementById('add_sto').addEventListener('click', () => {

        var get = document.getElementById('stock');

        var nameData = get.options[get.selectedIndex].innerText;
        var idData = get.options[get.selectedIndex].value;

        let forId = idData.slice(0, idData.indexOf(","));

        const wrapper = document.createElement('div');
        wrapper.classList.add('input-group-sto');

        wrapper.innerHTML = `
            <input type="text" name=""  value="` + nameData + `">
            <input type="text" name="stock[]" value="`+ forId + `">      
            <input type="number" name="stockQty[]" placeholder="Stock Qty">
            <button type="button" class="remove-sto">Remove</button>
        `;

        document.getElementById('addStock').appendChild(wrapper);
    });

    document.getElementById('addStock').addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('remove-sto')) {
            event.target.closest('.input-group-sto').remove();
        }
    });
}

// stop

document.getElementById('searchInput').addEventListener('input', function () {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll("#tableBody tr");

    rows.forEach(row => {
        const address = row.cells[0].innerText.toLowerCase();
        const qty = row.cells[1].innerText.toLowerCase();
        if (address.includes(filter)) {
            row.style.display = '';
        }
        if (qty.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });
});

document.getElementById('clearSearch').addEventListener('click', function () {
    const searchInput = document.getElementById('searchInput');
    searchInput.value = '';
    searchInput.dispatchEvent(new Event('input')); // Trigger the input event to reset the table
});