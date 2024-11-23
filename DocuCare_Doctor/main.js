/*=============== SHOW SIDEBAR ===============*/
const navMenu = document.getElementById('sidebar'),
      navToggle = document.getElementById('nav-toggle'),
      navClose = document.getElementById('nav-close');

/*===== SIDEBAR SHOW =====*/
if(navToggle){
    navToggle.addEventListener("click", () => {
        navMenu.classList.add('show-sidebar');
    });
}

/*===== SIDEBAR HIDDEN =====*/
if(navClose){
    navClose.addEventListener("click", () => {
        navMenu.classList.remove('show-sidebar');
    });
}


/*===== CALCULATE INTAKE OUTPUT =====*/
// Calculate totals for all tbody sections on load
function calculateAllTotalsOnLoad() {
    const tbodies = document.querySelectorAll('tbody:not(.IOempty)'); // Exclude empty sections 
    tbodies.forEach(tbody => {
        calculateTotals(tbody); // Calculate for each tbody
    });
}

// Calculate totals for a given tbody
function calculateTotals(tbody) {
    const shifts = ['am', 'pm', 'nt']; 

    let totalOral = 0;
    let totalParental = 0;
    let totalOther = 0;
    let totalIntake = 0;
    let totalUrine = 0;
    let totalStool = 0;
    let totalDrainage = 0;
    let totalOutput = 0;

    // Loop through each shift (am, pm, nt)
    for (let i = 0; i < shifts.length; i++) {
        const shift = shifts[i];

        // Intake calculations
        const oral = parseFloat(tbody.querySelector(`input[name="oral-${shift}"]`)?.value) || 0;
        const parental = parseFloat(tbody.querySelector(`input[name="parental-${shift}"]`)?.value) || 0;
        const other = parseFloat(tbody.querySelector(`input[name="other-${shift}"]`)?.value) || 0;
        const intakeTotal = oral + parental + other;

        // Set intake total for current shift
        tbody.querySelector(`input[name="intake_total-${shift}"]`).value = intakeTotal.toFixed(2);

        // Update total counts
        totalOral += oral;
        totalParental += parental;
        totalOther += other;
        totalIntake += intakeTotal;

        // Output calculations
        const urine = parseFloat(tbody.querySelector(`input[name="urine-${shift}"]`)?.value) || 0;
        const stool = parseFloat(tbody.querySelector(`input[name="stool-${shift}"]`)?.value) || 0;
        const drainage = parseFloat(tbody.querySelector(`input[name="drainage-${shift}"]`)?.value) || 0;
        const outputTotal = urine + stool + drainage;

        // Set output total for current shift
        tbody.querySelector(`input[name="output_total-${shift}"]`).value = outputTotal.toFixed(2);

        // Update total counts
        totalUrine += urine;
        totalStool += stool;
        totalDrainage += drainage;
        totalOutput += outputTotal;
    }

    // Set total values
    tbody.querySelector(`input[name="oral-total"]`).value = totalOral.toFixed(2);
    tbody.querySelector(`input[name="parental-total"]`).value = totalParental.toFixed(2);
    tbody.querySelector(`input[name="other-total"]`).value = totalOther.toFixed(2);
    tbody.querySelector(`input[name="intake-total"]`).value = totalIntake.toFixed(2);
    tbody.querySelector(`input[name="urine-total"]`).value = totalUrine.toFixed(2);
    tbody.querySelector(`input[name="stool-total"]`).value = totalStool.toFixed(2);
    tbody.querySelector(`input[name="drainage-total"]`).value = totalDrainage.toFixed(2);
    tbody.querySelector(`input[name="output-total"]`).value = totalOutput.toFixed(2);
}

// Trigger calculation for all tbody sections on page load
window.addEventListener('load', () => {
    calculateAllTotalsOnLoad(); // Calculate totals on page load
    setupEventListeners();
});

// Setup event listeners for tbody with class IOempty
document.addEventListener('DOMContentLoaded', function() {
    const emptyDiv = document.querySelector('.IOempty'); 
    if (emptyDiv) {
        emptyDiv.addEventListener('input', function(event) {
            if (event.target.tagName === 'INPUT') {
                calculateTotals(emptyDiv); // Calculate totals 
            }
        });
    }
});


/*===== CALCULATE AGE =====*/
document.getElementById('DoB').addEventListener('input', function() {
    const dob = new Date(this.value); // Get DOB
    const today = new Date();         // Get today's date

    // Calculate age in years
    let age = today.getFullYear() - dob.getFullYear();
    const monthDifference = today.getMonth() - dob.getMonth();

    // If the birthday hasn't occurred yet this year
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
        age--;
    }

    document.getElementById('age').value = age;
});


/*===== FILTER PATIENT INFORMATION TYPE =====*/ 
function updateFormAction() {
    const patientType = document.getElementById("patientType").value;
    const inpatientFields = document.querySelector(".inpatientFields");
    const outpatientFields = document.querySelector(".outpatientFields");

    if (patientType === "inpatient") {
        inpatientFields.style.display = "block";
        outpatientFields.style.display = "none";
    } else {
        inpatientFields.style.display = "none";
        outpatientFields.style.display = "block";
    }
}

/*===== RADIO BTN (Travel History-Outpatient) =====*/ 
const yesRadio = document.getElementById('travelHistoryYes');
const noRadio = document.getElementById('travelHistoryNo');
const travelWhereGroup = document.getElementById('travelWhereGroup');
const travelWhenGroup = document.getElementById('travelWhenGroup');

yesRadio.addEventListener('change', function() {
    if (yesRadio.checked) {
        travelWhereGroup.style.display = 'block';
        travelWhenGroup.style.display = 'block';
    }
});

noRadio.addEventListener('change', function() {
    if (noRadio.checked) {
        travelWhereGroup.style.display = 'none';
        travelWhenGroup.style.display = 'none';
    }
});

/*===== FILTER PATIENT TYPE (Dropdown) =====*/ 
function filterPatients() {
    const filter = document.getElementById('patientTypeFilter').value;
    const rows = document.querySelectorAll('.search-result table tr:not(.tblheader)');

    rows.forEach(row => {
        const patientType = row.querySelector('td:nth-child(3)').textContent.trim(); // Trim whitespace

        // Check if the filter is "all" to show all patients
        if (filter === 'all' || patientType === filter) {
            row.style.display = '';  // show row  
        } else {
            row.style.display = 'none'; // hide row
        }
    });
}

