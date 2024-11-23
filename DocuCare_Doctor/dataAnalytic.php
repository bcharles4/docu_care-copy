<?php
  session_start();
  include ('counter.php');
  $Position = $_SESSION['Position'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Analytics| DocuCare</title>
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.png">
    <script src="https://kit.fontawesome.com/1e3d5daa34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style2.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
       .table-wrapper {
          overflow-x: auto; 
          width: 100%;
        }

        .canva-table {
            position: relative; 
        }

        .chartBox {
           position: relative;
           width: 100%; 
           height: 100%;
        }
        canvas {
            position: absolute; 
            top: 0; 
            margin-top: 15px;
            width: 100%; 
            height: 100%; 
            max-width: 100%; 
            min-width: 200px; 
            min-height: 125px;
        }
    </style>
  </head>
  <body>
    <div class="nav__toggle" id="nav-toggle">
        <i class="uil uil-bars"></i>
    </div>
    <aside class="sidebar" id="sidebar">
        <nav class="nav">
            <div class="sidebar-header">
                <img src="img/logo.png" alt="logo" />
                <h2>DocuCare</h2>
              </div>
        
              <!-- Doctor Sidebar-->
              <?php if($Position == 'Doctor') { ?>
              <ul class="sidebar-links">
                <h4>
                  <span>Main Menu</span>
                  <div class="menu-separator"></div>
                </h4>
                <li>
                  <a href="dashboard.php" class="active"><span class="material-symbols-outlined">dashboard</span>Dashboard</a>
                </li>
                <li>
                   <a href="patientList.php"><span class="material-symbols-outlined">patient_list</span>Patient List</a>
                </li>
                <li>
                   <a href="doctorsOrderList.php"><span class="material-symbols-outlined">stethoscope</span>Doctor's Order</a>
                </li>
                <li>
                    <a href="dataAnalytic.php"><span class="material-symbols-outlined">bar_chart</span>Data Analytics</a>
                </li>
                
                <h4>
                  <span>Account</span>
                  <div class="menu-separator"></div>
                </h4>
                <li>
                  <a href="Profile.php"><span class="material-symbols-outlined">account_circle</span>Profile</a>
                </li>
                <li>
                  <a href="index.php"><span class="material-symbols-outlined">logout</span>Logout</a>
                </li>
              </ul>
              <?php } ?>
        
              <div class="user-account">
                <div class="user-profile">
                  <img src="img/profile.png" alt="Profile Image" />
                  <div class="user-detail">
                    <h3><?php echo $_SESSION['User_FName'] . ' ' . $_SESSION['User_LName']; ?></h3>
                    <span><?php echo $_SESSION['Position']; ?></span>
                  </div>
                </div>
              </div>
        
              <div class="nav__close" id="nav-close">
                <i class="uil uil-times"></i>
              </div>
        </nav> 
    </aside>

<main class="main">
  <header>
    <h1>Data Analytics Report</h1>
  </header>

  <?php if($Position == 'Doctor') { ?>
    <section class="overview data-analytics-section">
      <div class="patient-volume">
      <h1>Patient Volume Analysis</h1>
      <div class="row row-1">
        <div class="card"> 
          <div class="card-content">
            <div class="text-content">
              <h3>Current Year</h3>
              <p id="totalCurrentYearPatients"><?php echo $TotalCurrentYearPatients; ?></p>
            </div>
          </div>
        </div>
        <div class="card data-analytics">
          <div class="card-content">
            <div class="text-content">
              <h3>Previous Year</h3>
              <p id="totalPreviousYearPatients"><?php echo $TotalPreviousYearPatients; ?></p>
            </div>
          </div>
        </div>
        <div class="card data-analytics"> 
          <div class="card-content">
            <div class="text-content">
              <h3>Current Month</h3>
              <p id="totalCurrentMonthPatients"><?php echo $TotalCurrentMonthPatients; ?></p>
            </div>
          </div>
        </div>
        <div class="card data-analytics"> 
          <div class="card-content">
            <div class="text-content">
              <h3>Previous Month</h3>
              <p id="totalPreviousMonthPatients"><?php echo $TotalPreviousMonthPatients; ?></p>
            </div>
          </div>
        </div>
      </div>
      </div>
      
      <div class="row row-2">
        <div class="card data-analytics">
          <div class="card-content chartBox">
            <canvas id="ageGroupChart"></canvas>
          </div>
        </div>
  
        <div class="card data-analytics">
          <div class="card-content chartBox">
            <canvas id="topDiagnosesChart"></canvas>
          </div>
        </div>
      </div>
  
    <div class="row row-3">
    <div class="card data-analytics">
    <div class="card-content">
        <div class="text-content common-diagnose">
            <h3>Barangay Common Diagnoses</h3>
            <div class="table-wrapper">
                <table>
                    <tr align="center" class="tblheader">
                        <td><b>Barangay</b></td>
                        <td><b>Top 1</b></td>
                        <td><b>Top 2</b></td>
                        <td><b>Top 3</b></td>
                    </tr>
                    <?php foreach ($barangayDiagnoses as $barangay => $diagnoses): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($barangay); ?></td>
                            <?php 
                            $topDiagnoses = array_keys(array_slice($diagnoses, 0, 3, true));
                            ?>
                            <td><?php echo isset($topDiagnoses[0]) ? htmlspecialchars($topDiagnoses[0]) : 'N/A'; ?></td>
                            <td><?php echo isset($topDiagnoses[1]) ? htmlspecialchars($topDiagnoses[1]) : 'N/A'; ?></td>
                            <td><?php echo isset($topDiagnoses[2]) ? htmlspecialchars($topDiagnoses[2]) : 'N/A'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    </div>

    <div class="card data-analytics">
    <div class="card-content">
        <div class="text-content common-diagnose">
            <h3>City Common Diagnoses</h3>
            <div class="table-wrapper">
                <table>
                    <tr align="center" class="tblheader">
                        <td><b>City</b></td>
                        <td><b>Top 1</b></td>
                        <td><b>Top 2</b></td>
                        <td><b>Top 3</b></td>
                    </tr>
                    <?php foreach ($cityDiagnoses as $city => $diagnoses): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($city); ?></td>
                            <?php 
                            $topDiagnoses = array_keys(array_slice($diagnoses, 0, 3, true));
                            ?>
                            <td><?php echo isset($topDiagnoses[0]) ? htmlspecialchars($topDiagnoses[0]) : 'N/A'; ?></td>
                            <td><?php echo isset($topDiagnoses[1]) ? htmlspecialchars($topDiagnoses[1]) : 'N/A'; ?></td>
                            <td><?php echo isset($topDiagnoses[2]) ? htmlspecialchars($topDiagnoses[2]) : 'N/A'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    </div>

    </div>
    </section>
  <?php } ?>
</main>

    <script src="main.js"></script>

    <script>
  // retrieve PHP data 
  const ageGroupData = {
      current: {
          infancy: <?php echo $TotalCurrentInfancy; ?>,
          childhood: <?php echo $TotalCurrentChildhood; ?>,
          adolescence: <?php echo $TotalCurrentAdolescence; ?>
      },
      previous: {
          infancy: <?php echo $TotalPreviousInfancy; ?>,
          childhood: <?php echo $TotalPreviousChildhood; ?>,
          adolescence: <?php echo $TotalPreviousAdolescence; ?>
      }
  };

  // Create age group bar chart
  const ageGroupCtx = document.getElementById('ageGroupChart').getContext('2d');
  const ageGroupChart = new Chart(ageGroupCtx, {
      type: 'bar',
      data: {
          labels: ['Infancy (0-2)', 'Childhood (3-12)', 'Adolescence (13-21)'],
          datasets: [
              {
                  label: 'Current Year',
                  data: [ageGroupData.current.infancy, ageGroupData.current.childhood, ageGroupData.current.adolescence],
                  backgroundColor: 'rgba(4, 108, 134, 0.6)',
                  borderColor: 'rgba(4, 108, 134, 1)',
                  borderWidth: 1
              },
              {
                  label: 'Previous Year',
                  data: [ageGroupData.previous.infancy, ageGroupData.previous.childhood, ageGroupData.previous.adolescence],
                  backgroundColor: 'rgba(13, 61, 105, 0.76)',
                  borderColor: 'rgba(13, 61, 105, 1)',
                  borderWidth: 1
              }
          ]
      },
      options: {
        maintainAspectRatio: false,
          scales: {
              y: {
                  beginAtZero: true
              },
              x: {
                  stacked: false,
                  grid: {
                      display: false 
                  }
              }
          },
          responsive: true,
          plugins: {
              legend: {
                  position: 'top',
              },
              title: {
                  display: true,
                  text: 'PEDIATRIC AGE GROUPS: Current vs Previous Year'
              }
          }
      }
  });


  // data for Current and Previous Year Top Diagnoses
  const diagnosisCountCurrentYear = <?php echo json_encode($diagnosisCountCurrentYear); ?>;
  const diagnosisCountPreviousYear = <?php echo json_encode($diagnosisCountPreviousYear); ?>;

  // Combine the diagnoses 
  const allDiagnoses = [...new Set([...Object.keys(diagnosisCountCurrentYear), ...Object.keys(diagnosisCountPreviousYear)])];
  const currentYearData = allDiagnoses.map(diagnosis => diagnosisCountCurrentYear[diagnosis] || 0);
  const previousYearData = allDiagnoses.map(diagnosis => diagnosisCountPreviousYear[diagnosis] || 0);

  const combinedCtx = document.getElementById('topDiagnosesChart').getContext('2d');
  new Chart(combinedCtx, {
      type: 'bar',
      data: {
          labels: allDiagnoses,
          datasets: [
              {
                  label: 'Current Year',
                  data: currentYearData,
                  backgroundColor: 'rgba(4, 108, 134, 0.6)',
                  borderColor: 'rgba(4, 108, 134, 1)',
                  borderWidth: 1
              },
              {
                  label: 'Previous Year',
                  data: previousYearData,
                  backgroundColor: 'rgba(13, 61, 105, 0.76)',
                  borderColor: 'rgba(13, 61, 105, 1)',
                  borderWidth: 1
              }
          ]
      },
      options: {
        maintainAspectRatio: false,
          scales: {
              y: { beginAtZero: true },
              x: {
                  stacked: false,
                  grid: { display: false }
              }
          },
          responsive: true,
          plugins: {
              legend: { position: 'top' },
              title: {
                  display: true,
                  text: 'TOP DIAGNOSES: Current vs Previous Year'
              }
          }
      }
  });

  </script>
  </body>
</html>
