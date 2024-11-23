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

/*===== ADD_REMOVE ROW =====*/
document.addEventListener('DOMContentLoaded', (event) => {
    // endorsement add button
    document.getElementById('add-row-button-endorsement').addEventListener('click', function() {
        const endorsementContainer = document.querySelectorAll('.form-row-container')[1]; 
        
        if (endorsementContainer) {
            const newRow = document.createElement('div');
            newRow.className = 'form-row';
            newRow.innerHTML = `
                <div class="form-group short">
                    <label for="date">DATE:</label>
                    <input type="date" name="endorsedate">
                </div>
                <div class="form-group">
                    <label for="specialEndorsement">SPECIAL ENDORSEMENT:</label>
                    <input type="text" name="specialEndorsement" placeholder="Enter special endorsement">
                </div>
                <div class="form-group">
                    <label for="remarks">REMARKS:</label>
                    <input type="text" name="remarks" placeholder="Enter remarks">
                </div>
                <div class="remove-row-button">
                    <i class="fas fa-trash-alt" onclick="removeRow(this)"></i>
                </div>
            `;
            endorsementContainer.appendChild(newRow);
        }
    });

    // IVF add button
    document.getElementById('add-row-button-ivf').addEventListener('click', function() {
        const ivfContainer = document.querySelectorAll('.form-row-container')[2]; 
        
        if (ivfContainer) {
            const newRow = document.createElement('div');
            newRow.className = 'form-row';
            newRow.innerHTML = `
                <div class="form-group">
                    <label for="ivfdate">DATE:</label>
                    <input type="date" name="ivfdate">
                </div>
                <div class="form-group">
                    <label for="ivf">IVF:</label>
                    <input type="text" name="ivf" placeholder="Enter IVF">
                </div>
                <div class="remove-row-button">
                    <i class="fas fa-trash-alt" onclick="removeRow(this)"></i>
                </div>
            `;
            ivfContainer.appendChild(newRow);
        }
    });

    // side drips add button
    document.getElementById('add-row-button-sideDrips').addEventListener('click', function() {
        const sideDripsContainer = document.querySelectorAll('.form-row-container')[3]; 
        
        if (sideDripsContainer) {
            const newRow = document.createElement('div');
            newRow.className = 'form-row';
            newRow.innerHTML = `
                <div class="form-group">
                    <label for="sideDripsDate">DATE:</label>
                    <input type="date" name="sideDripsDate">
                </div>
                <div class="form-group">
                    <label for="sideDrips">SIDE DRIPS/BLOOD TRANSFUSION:</label>
                    <input type="text" name="sideDrips" placeholder="Enter side drips/blood transfusion">
                </div>
                <div class="remove-row-button">
                    <i class="fas fa-trash-alt" onclick="removeRow(this)"></i>
                </div>
            `;
            sideDripsContainer.appendChild(newRow);
        }
    });

     // diagnostics add button
     document.getElementById('add-row-button-diagnostics').addEventListener('click', function() {
        const diagnosticsContainer = document.querySelectorAll('.form-row-container')[6];

        if (diagnosticsContainer) {
            const newRow = document.createElement('div');
            newRow.className = 'form-row';
            newRow.innerHTML = `
                <div class="form-group short">
                    <label for="date">DATE:</label>
                    <input type="date" name="diagnosticsDate">
                </div>
                <div class="form-group">
                    <label for="diagnostics">DIAGNOSTIC DETAILS:</label>
                    <input type="text" name="diagnostics" placeholder="Enter diagnostic details">
                </div>
                <div class="checkbox-group row">
                    <label>Options:</label>
                    <div class="checkboxes">
                        <label><input type="checkbox" name="diagnosticOption1"> 1</label>
                        <label><input type="checkbox" name="diagnosticOption2"> 2</label>
                        <label><input type="checkbox" name="diagnosticOption3"> 3</label>
                        <label><input type="checkbox" name="diagnosticOption4"> 4</label>
                        <label><input type="checkbox" name="diagnosticOption5"> 5</label>
                    </div>
                </div>
                <div class="remove-row-button">
                    <i class="fas fa-trash-alt" onclick="removeRow(this)"></i>
                </div>
            `;
            diagnosticsContainer.appendChild(newRow);
        }
    });

    // medications add button
    document.getElementById('add-row-button-medications').addEventListener('click', function() {
    const medicationsContainer = document.querySelectorAll('.form-row-container')[10];

        if (medicationsContainer) {
          const newRow = document.createElement('div');
          newRow.className = 'form-row';
          newRow.innerHTML = `
            <div class="form-group">
                <label for="generic-name">GENERIC NAME:</label>
                <input type="text" name="generic-name" placeholder="Enter generic name">
            </div>
            <div class="form-group">
                <label for="remarks">REMARKS:</label>
                <input type="text" name="medremarks" placeholder="Enter remarks">
            </div>
            <div class="remove-row-button">
                <i class="fas fa-trash-alt" onclick="removeRow(this)"></i>
            </div>
          `;
          medicationsContainer.appendChild(newRow);
        }
    });

    // Function to remove a row
    window.removeRow = function(element) {
        const row = element.closest('.form-row');
        row.remove();
    }
});

// intake add button
document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('add-row-button-intake').addEventListener('click', function() {
        // Select the table
        const table = document.querySelector('table');
        
        // Create a new tbody element
        const newTbody = document.createElement('tbody');
        
        // Set the inner HTML of the new tbody to your provided structure
        newTbody.innerHTML = `
            <tr>
                <td rowspan="3"><input type="date" name="date"></td>
                <td style="font-weight: bold; color: #000;">AM</td>
                <td><input type="text" name="oral-am"></td>
                <td><input type="text" name="parental-am"></td>
                <td><input type="text" name="other-am"></td>
                <td><input type="text" name="intake_total-am" style="font-weight: bold;"></td>
                <td><input type="text" name="urine-am"></td>
                <td><input type="text" name="stool-am"></td>
                <td><input type="text" name="drainage-am"></td>
                <td><input type="text" name="output_total-am" style="font-weight: bold;"></td>
                <td><input type="text" name="intakeOutputremarks-am"></td>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #000;">PM</td>
                <td><input type="text" name="oral-pm"></td>
                <td><input type="text" name="parental-pm"></td>
                <td><input type="text" name="other-pm"></td>
                <td><input type="text" name="intake_total-pm" style="font-weight: bold;"></td>
                <td><input type="text" name="urine-pm"></td>
                <td><input type="text" name="stool-pm"></td>
                <td><input type="text" name="drainage-pm"></td>
                <td><input type="text" name="output_total-pm" style="font-weight: bold;"></td>
                <td><input type="text" name="intakeOutputremarks-pm"></td>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #000;">NIGHT</td>
                <td><input type="text" name="oral-nt"></td>
                <td><input type="text" name="parental-nt"></td>
                <td><input type="text" name="other-nt"></td>
                <td><input type="text" name="intake_total-nt" style="font-weight: bold;"></td>
                <td><input type="text" name="urine-nt"></td>
                <td><input type="text" name="stool-nt"></td>
                <td><input type="text" name="drainage-nt"></td>
                <td><input type="text" name="output_total-nt" style="font-weight: bold;"></td>
                <td><input type="text" name="intakeOutputremarks-nt"></td>
            </tr>
            <tr style="font-weight: bold;">
                <td colspan="2" style="color: #000;">TOTAL</td>
                <td><input type="text" name="oral-total" style="font-weight: bold;" readonly></td>
                <td><input type="text" name="parental-total" style="font-weight: bold;" readonly></td>
                <td><input type="text" name="other-total" style="font-weight: bold;" readonly></td>
                <td><input type="text" name="intake-total" style="font-weight: bold;" readonly></td>
                <td><input type="text" name="urine-total" style="font-weight: bold;" readonly></td>
                <td><input type="text" name="stool-total" style="font-weight: bold;" readonly></td>
                <td><input type="text" name="drainage-total" style="font-weight: bold;" readonly></td>
                <td><input type="text" name="output-total" style="font-weight: bold;" readonly></td>
                <td><input type="text" name="intakeOutputremarks-total"></td>
                <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td>    
            </tr>
        `;

        // Append the new tbody to the table
        table.appendChild(newTbody);

        // Reattach event listeners for new inputs
        attachInputListeners();
    });

    // Remove tbody
    document.querySelector('table').addEventListener('click', function (event) {
        if (event.target && event.target.closest('.remove-row-button')) {
            const row = event.target.closest('tbody'); // Find the closest <tbody> element and remove it
            if (row) {
                row.remove();
                calculateOverallTotals();
            }
        }
    });

    function attachInputListeners() {
        document.querySelectorAll('input[type="text"]').forEach(input => {
            input.addEventListener('input', function () {
                calculateTotals(input);
                calculateOverallTotals();
            });
        });
    }

    // Initial attachment of listeners
    attachInputListeners();

});

// Calculate totals 
function calculateTotals(inputElement) {
    const tbody = inputElement.closest('tbody');
    const shifts = ['am', 'pm', 'nt'];

    let totalOral = 0;
    let totalParental = 0;
    let totalOther = 0;
    let totalIntake = 0;
    let totalUrine = 0;
    let totalStool = 0;
    let totalDrainage = 0;
    let totalOutput = 0;

    shifts.forEach(shift => {
        // Intake calculations
        const oral = parseFloat(tbody.querySelector(`input[name="oral-${shift}"]`).value) || 0;
        const parental = parseFloat(tbody.querySelector(`input[name="parental-${shift}"]`).value) || 0;
        const other = parseFloat(tbody.querySelector(`input[name="other-${shift}"]`).value) || 0;
        const intakeTotal = oral + parental + other;
        tbody.querySelector(`input[name="intake_total-${shift}"]`).value = intakeTotal.toFixed(2); // Format to 2 decimals

        // totals for each intake
        totalOral += oral;
        totalParental += parental;
        totalOther += other;
        totalIntake += intakeTotal;

        // Output calculations
        const urine = parseFloat(tbody.querySelector(`input[name="urine-${shift}"]`).value) || 0;
        const stool = parseFloat(tbody.querySelector(`input[name="stool-${shift}"]`).value) || 0;
        const drainage = parseFloat(tbody.querySelector(`input[name="drainage-${shift}"]`).value) || 0;
        const outputTotal = urine + stool + drainage;
        tbody.querySelector(`input[name="output_total-${shift}"]`).value = outputTotal.toFixed(2); // Format to 2 decimals

        // totals for each output 
        totalUrine += urine;
        totalStool += stool;
        totalDrainage += drainage;
        totalOutput += outputTotal;
    });

    // Set the totals in the final row with 2 decimals
    tbody.querySelector(`input[name="oral-total"]`).value = totalOral.toFixed(2);
    tbody.querySelector(`input[name="parental-total"]`).value = totalParental.toFixed(2);
    tbody.querySelector(`input[name="other-total"]`).value = totalOther.toFixed(2);
    tbody.querySelector(`input[name="intake-total"]`).value = totalIntake.toFixed(2);
    tbody.querySelector(`input[name="urine-total"]`).value = totalUrine.toFixed(2);
    tbody.querySelector(`input[name="stool-total"]`).value = totalStool.toFixed(2);
    tbody.querySelector(`input[name="drainage-total"]`).value = totalDrainage.toFixed(2);
    tbody.querySelector(`input[name="output-total"]`).value = totalOutput.toFixed(2);
}

// Calculate overall totals 
function calculateOverallTotals() {
    let overallOral = 0;
    let overallParental = 0;
    let overallOther = 0;
    let overallIntake = 0;
    let overallUrine = 0;
    let overallStool = 0;
    let overallDrainage = 0;
    let overallOutput = 0;

    document.querySelectorAll('tbody').forEach(tbody => {
        overallOral += parseFloat(tbody.querySelector(`input[name="oral-total"]`).value) || 0;
        overallParental += parseFloat(tbody.querySelector(`input[name="parental-total"]`).value) || 0;
        overallOther += parseFloat(tbody.querySelector(`input[name="other-total"]`).value) || 0;
        overallIntake += parseFloat(tbody.querySelector(`input[name="intake-total"]`).value) || 0;
        overallUrine += parseFloat(tbody.querySelector(`input[name="urine-total"]`).value) || 0;
        overallStool += parseFloat(tbody.querySelector(`input[name="stool-total"]`).value) || 0;
        overallDrainage += parseFloat(tbody.querySelector(`input[name="drainage-total"]`).value) || 0;
        overallOutput += parseFloat(tbody.querySelector(`input[name="output-total"]`).value) || 0;
    });

    document.querySelector('input[name="oral-total-overall"]').value = overallOral.toFixed(2);
    document.querySelector('input[name="parental-total-overall"]').value = overallParental.toFixed(2);
    document.querySelector('input[name="other-total-overall"]').value = overallOther.toFixed(2);
    document.querySelector('input[name="intake-total-overall"]').value = overallIntake.toFixed(2);
    document.querySelector('input[name="urine-total-overall"]').value = overallUrine.toFixed(2);
    document.querySelector('input[name="stool-total-overall"]').value = overallStool.toFixed(2);
    document.querySelector('input[name="drainage-total-overall"]').value = overallDrainage.toFixed(2);
    document.querySelector('input[name="output-total-overall"]').value = overallOutput.toFixed(2);
}


// vital signs add button
document.addEventListener('DOMContentLoaded', (event) => {
    // Function to add a new row
    document.getElementById('add-row-button-vitalSign').addEventListener('click', function() {
        const tbody = document.querySelector('table tbody');
        
        if (tbody) {
            // Create a new row element
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="datetime-local" name="date-vitalSign"></td>
                <td><input type="text" name="bp"></td>
                <td><input type="text" name="rr"></td>
                <td><input type="text" name="pr"></td>
                <td><input type="text" name="temp"></td>
                <td><input type="text" name="spo2"></td>
                <td><input type="text" name="wt"></td>
                <td><input type="number" name="pain" min="0" max="10"></td>
                <td><input type="text" name="interventions"></td>
                <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td>
            `;
            
            // Append the new row to the tbody
            tbody.appendChild(newRow);
        }
    });

    // remove a row
    document.querySelector('table').addEventListener('click', function(event) {
        if (event.target && event.target.closest('.remove-row-button')) {
            const row = event.target.closest('tr'); // Find the closest <tr> element and remove it
            if (row) {
                row.remove();
            }
        }
    });
});


// IV Fluid, Side Drips, Stat Fast Drip add button
document.addEventListener('DOMContentLoaded', () => {
    // Add a new row to IV Fluid
    document.getElementById('add-row-button-IVfluid').addEventListener('click', function() {
        const tbody = document.querySelector('#iv-fluid-table tbody');
        
        if (tbody) {
            // Create a new row element
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="date" name="date"></td>
                <td><input type="text" name="bottle-no"></td>
                <td><input type="text" name="iv-solution"></td>
                <td><input type="text" name="volume"></td>
                <td><input type="text" name="incorporation"></td>
                <td><input type="text" name="regulation"></td>
                <td><input type="time" name="time-started"></td>
                <td><input type="datetime-local" name="date-time-consumed"></td>
                <td><input type="text" name="remark"></td>
                <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td> 
            `;
            
            // Append the new row to the tbody
            tbody.appendChild(newRow);
        }
    });

    // Add a new row to Side Drips
    document.getElementById('add-row-button-sideDrips').addEventListener('click', function() {
        const tbody = document.querySelector('#side-drips-table tbody');
        
        if (tbody) {
            // Create a new row element
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="date" name="date-sideDrips"></td>
                <td><input type="text" name="bottle-no-sideDrips"></td>
                <td><input type="text" name="iv-solution-sideDrips"></td>
                <td><input type="text" name="volume-sideDrips"></td>
                <td><input type="text" name="incorporation-sideDrips"></td>
                <td><input type="text" name="regulation-sideDrips"></td>
                <td><input type="time" name="time-started-sideDrips"></td>
                <td><input type="datetime-local" name="date-time-consumed-sideDrips"></td>
                <td><input type="text" name="remark-sideDrips"></td>
                <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td> 
            `;
            
            // Append the new row to the tbody
            tbody.appendChild(newRow);
        }
    });

     // Add a new row to Stat Fast Drip
     document.getElementById('add-row-button-fastDrip').addEventListener('click', function() {
        const tbody = document.querySelector('#fast-drip-table tbody');
        
        if (tbody) {
            // Create a new row element
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                 <td><input type="date" name="date-fastDrip"></td>
                 <td><input type="text" name="ivf-fastDrip"></td>
                 <td><input type="text" name="volume-fastDrip"></td>
                 <td><input type="text" name="incorporation-fastDrip"></td>
                 <td><input type="time" name="time-fastDrip"></td>
                 <td><input type="text" name="remark-fastDrip"></td>
                 <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td> 
            `;
            
            // Append the new row to the tbody
            tbody.appendChild(newRow);
        }
    });

    // remove row
    document.addEventListener('click', function(event) {
        if (event.target && event.target.closest('.remove-row-button')) {
            const row = event.target.closest('tr'); // Find the closest <tr> element
            if (row) {
                row.remove(); // Remove the row
            }
        }
    });
});

// nurses notes add button
document.addEventListener('DOMContentLoaded', (event) => {
    // Function to add a new row
    document.getElementById('add-row-button-nurseNotes').addEventListener('click', function() {
        const tbody = document.querySelector('#nurses-notes-table tbody');
        
        if (tbody) {
            // Create a new row element
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                 <td><input type="datetime-local" name="date-time-nurseNote" placeholder="Date Time"></td>
                 <td class="short">
                    <select name="shift">
                        <option value="">Select Shift</option>
                        <option value="AM-shift">AM</option>
                        <option value="PM-shift">PM</option>
                        <option value="NIGHT-shift">NIGHT</option>
                    </select>
                </td>
                <td><input type="text" name="focus-nurseNote" placeholder="Focus"></td>
                <td><textarea name="data-nurseNote" placeholder="Data"></textarea></td>
                <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td> 
            `;
            
            // Append the new row to the tbody
            tbody.appendChild(newRow);
        }
    });

    // remove a row
    document.querySelector('table').addEventListener('click', function(event) {
        if (event.target && event.target.closest('.remove-row-button')) {
            const row = event.target.closest('tr'); // Find the closest <tr> element and remove it
            if (row) {
                row.remove();
            }
        }
    });
});

// standing order add button
document.addEventListener('DOMContentLoaded', (event) => {
    // Function to add a new row
    document.getElementById('add-row-button-standingOrder').addEventListener('click', function() {
        const tbody = document.querySelector('#standing-order-table tbody');
        
        if (tbody) {
            // Create a new row element
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                 <td><input type="date" name="date_ordered-stdOrder"></td>
                 <td><input type="text" name="medication-stdOrder"></td>
                 <td><input type="date" name="date_started-stdOrder"></td>
                 <td><input type="date" name="date_discontinued-stdOrder"></td>
                 <td><input type="text" name="remarks-stdOrder"></td>
                 <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td>  
            `;
            
            // Append the new row to the tbody
            tbody.appendChild(newRow);
        }
    });

    // remove a row
    document.querySelector('table').addEventListener('click', function(event) {
        if (event.target && event.target.closest('.remove-row-button')) {
            const row = event.target.closest('tr'); // Find the closest <tr> element and remove it
            if (row) {
                row.remove();
            }
        }
    });
});

// med record add button
document.addEventListener('DOMContentLoaded', (event) => {
    // Standing Order add a new row
    document.getElementById('add-row-button-medRecordSO').addEventListener('click', function() {
        const tbody = document.querySelector('#medRecord-SO-table tbody');
        
        if (tbody) {
            // Create a new row element
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                 <td><input type="date" name="med-date-SO" /></td>  
                    <td>
                     <select name="hospital_day1">
                        <option value="">Select Day</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                     </select>
                    </td>       
                <td><input type="text" name="standing_order" /></td>
                <td><input type="text" name="SO_10_6" /></td>
                <td><input type="text" name="SO_6_2" /></td>
                <td><input type="text" name="SO_2_10" /></td>
                <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td> 
            `;
            
            // Append the new row to the tbody
            tbody.appendChild(newRow);
        }
    });

     // PRN Medication add a new row
     document.getElementById('add-row-button-medRecordPRN').addEventListener('click', function() {
        const tbody = document.querySelector('#medRecord-PRN-table tbody');
        
        if (tbody) {
            // Create a new row element
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="date" name="med-date-PRN" /></td>        
                <td><input type="text" name="PRN-Med" /></td>
                <td><input type="text" name="PRN_10_6" /></td>
                <td><input type="text" name="PRN_6_2" /></td>
                <td><input type="text" name="PRN_2_10" /></td>
                <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td> 
            `;
            
            // Append the new row to the tbody
            tbody.appendChild(newRow);
        }
    });

     // STAT Order Medication add a new row
     document.getElementById('add-row-button-medRecordSTAT').addEventListener('click', function() {
        const tbody = document.querySelector('#medRecord-STAT-table tbody');
        
        if (tbody) {
            // Create a new row element
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                 <td><input type="date" name="med-date-STAT" /></td>        
                 <td><input type="text" name="stat_order" /></td>
                 <td><input type="text" name="STAT_10_6" /></td>
                 <td><input type="text" name="STAT_6_2" /></td>
                 <td><input type="text" name="STAT_2_10" /></td>   
                 <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td>  
            `;
            
            // Append the new row to the tbody
            tbody.appendChild(newRow);
        }
    });


    // remove a row
     document.addEventListener('click', function(event) {
        if (event.target && event.target.closest('.remove-row-button')) {
            const row = event.target.closest('tr'); // Find the closest <tr> element
            if (row) {
                row.remove(); // Remove the row
            }
        }
    });
});


// room management add button
document.addEventListener('DOMContentLoaded', (event) => {
    // room info table
    document.getElementById('add-row-button-roomInfo').addEventListener('click', function() {
        const tbody = document.querySelector('#room-info-table tbody');
        
        if (tbody) {
            // Create a new row element
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                 <td><input type="text" name="assignedPatientID" placeholder="Patient ID"></td>
                 <td><input type="text" name="dayShiftNurseID" placeholder="Day Shift Nurse ID"></td>
                 <td><input type="text" name="nightShiftNurseID" placeholder="Night Shift Nurse ID"></td>  
                 <td><input type="datetime-local" name="admissionDateTime"></td>
                 <td><input type="datetime-local" name="dischargeDateTime"></td>
                 <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td>
            `;
            
            // Append the new row to the tbody
            tbody.appendChild(newRow);
        }
    });

      // room maintenance table
      document.getElementById('add-row-button-roomMaintain').addEventListener('click', function() {
        const tbody = document.querySelector('#room-maintenance-table tbody');
        
        if (tbody) {
            // Create a new row element
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                 <td><input type="datetime-local" name="maintenanceDateTime"></td>
                 <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td>
            `;
            
            // Append the new row to the tbody
            tbody.appendChild(newRow);
        }
    });


    // remove a row
     document.addEventListener('click', function(event) {
        if (event.target && event.target.closest('.remove-row-button')) {
            const row = event.target.closest('tr'); // Find the closest <tr> element
            if (row) {
                row.remove(); // Remove the row
            }
        }
    });
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

