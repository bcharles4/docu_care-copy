<?php
    $server = 'localhost:3307';
    $user = 'root';
    $pass ='';
    $db = 'docudata';

    $connection = mysqli_connect($server, $user, $pass)
    or die ('Could not connect to the server ...\n'.mysqli_error());

    mysqli_select_db($connection, $db)
    or die ('Could not connect to the server ...\n'.mysqli_error());

    $table = $_GET['table'] ?? NULL;

    $allowed_tables = [
        'iv_fluid_records' => [
            'ivfr_fast_drip', 'ivfr_iv', 'ivfr_side_drips'
        ],
        'kardex_records' => [
            'kardex_diagnostics', 'kardex_diagnostics_categories', 'kardex_diet', 'kardex_diet_categories', 
            'kardex_diet_last_meal', 'kardex_drips_transfusion', 'kardex_endorsements', 'kardex_io', 'kardex_io_categories',
            'kardex_iv', 'kardex_medications', 'kardex_notes', 'kardex_tbl', 'kardex_vitals', 'kardex_vitals_categories'
        ],
        'medication_records' => [
            'medication_record_prn_response', 'medication_record_so_response', 'medication_record_stat_response'
        ],
        'nurse_records' => [
            'nurse_notes', 'nurse_sched', 'standing_order_response'
        ],
        'patient_records' => [
            'outpatient_info', 'patient_contacts', 'patient_emergency_contact', 'patient_info', 'patient_info_notes',
            'patient_intake', 'patient_output', 'patient_lab_results', 'patient_scan_results', 'patient_vital_signs'
        ],
        'rooms_records' => [
            'rooms', 'rooms_information', 'rooms_maintenance'
        ],
        'tpr_records' => [
            'tpr_initial_vitals', 'tpr_vital_signs', 'tpr_vital_signs_output'
        ],
        'user_records' => [
            'user_tbl'
        ]
    ];

    // Tables that do not have `status` and `deletion_date` columns
    $tables_without_status_and_deletion = [
        'kardex_diagnostics_categories',
        'kardex_diet_categories',
        'kardex_io_categories',
        'kardex_vitals_categories',
        'medication_record_prn_response',
        'medication_record_so_response',
        'medication_record_stat_response',
        'outpatient_info',
        'standing_order_response'
    ];

    // Flatten the allowed tables for easy checking
    $flat_tables = [];
    function flattenTables($tables) {
        global $flat_tables;
        foreach ($tables as $group => $tables) {
            if (is_array($tables)) {
                flattenTables($tables);
            } else {
                $flat_tables[] = $tables;
            }
        }
    }

    flattenTables($allowed_tables);

    if (in_array($table, $flat_tables)) {
        // Start building the query
        $query = "SELECT * FROM `$table`";

        // Check if the table has status or deletion_date columns
        if (!in_array($table, $tables_without_status_and_deletion)) {
            $query .= " WHERE status <> 'x'"; // or adjust based on your conditions
        }
        
        $result = mysqli_query($connection, $query);
        
        if (!$result) {
            echo json_encode(['error' => 'Database query failed.']);
            exit;
        }
        
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Invalid table requested.']);
    }
?>
