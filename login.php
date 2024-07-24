<?php

$ver = "1.2";

include('./layouts/head.php');
include('./model/commonmodel.php');




if (isset($_POST['submit'])) {
    $conn = dbconnect();


    $username = $_POST['username'];

    $password = $_POST['password'];

    $sql = "SELECT U_Id, U_Username, U_RoleId, U_DisplayName, U_EmpCode, U_Photo, U_Online, U_TypeId, ut.UType_Name, r.Rl_Name,Cp_Name,Cp_Email,Cp_Mobile,Cp_Location,Cp_Pin,Cp_ReraNo FROM `tbl_users` u
    INNER JOIN tbl_roles r ON r.Rl_Id = u.U_RoleId
    INNER JOIN tbl_usertype ut ON u.U_TypeId = ut.UType_Id
    LEFT JOIN tbl_channelpartner cp ON u.U_RefrenceIdCp = cp.Cp_Id
    where U_Username = '".mysqli_real_escape_string($conn,$username)."' and U_Password = '".mysqli_real_escape_string($conn,$password)."' and U_Status = 'Active'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();


      $sql = "UPDATE `tbl_users` SET `U_Online`=1 WHERE `U_Id`= ".$row['U_Id'];

      $result = $conn->query($sql);



$sql = "SELECT tm.Tm_Id, tmm.tm_m_uid AS Team_Leader_Id, tm.Tm_Name, tm.Tm_parent_team_id 
        FROM tbl_team tm 
        INNER JOIN tbl_teammap tmm ON tm.Tm_Id = tmm.team_id 
        WHERE tmm.tm_m_uid = " . $row['U_Id'];
      $result = $conn->query($sql);
      while($t = $result->fetch_assoc()){

        $team[] = [
          'Tm_Id' => $t['Tm_Id'],
          'Tm_Name' => $t['Tm_Name'],
          'Tm_parent_team_id' => $t['Tm_parent_team_id']
        ];

        $sql="WITH RECURSIVE TLHierarchy AS (
              SELECT 
                  tm.Tm_Id,
                  tm.Tm_Name,
                  tm.Tm_parent_team_id,
                  tl.tm_m_uid AS Team_Leader_Id
              FROM 
                  tbl_team tm
                  INNER JOIN tbl_teammap tmm ON tm.Tm_Id = tmm.team_id
                  LEFT JOIN 
                      (SELECT team_id, tm_m_uid FROM tbl_teammap WHERE tm_m_role = 2) AS tl ON tm.Tm_Id = tl.team_id
              WHERE 
                  tmm.tm_m_uid = ".$row['U_Id']."

              UNION ALL

              SELECT 
                  parent_tm.Tm_Id,
                  parent_tm.Tm_Name,
                  parent_tm.Tm_parent_team_id,
                  parent_tl.tm_m_uid AS Team_Leader_Id
              FROM 
                  tbl_team parent_tm
                  INNER JOIN TLHierarchy th ON parent_tm.Tm_Id = th.Tm_parent_team_id
                  LEFT JOIN 
                      (SELECT team_id, tm_m_uid FROM tbl_teammap WHERE tm_m_role = 2) AS parent_tl ON parent_tm.Tm_Id = parent_tl.team_id
              WHERE 
                  th.Team_Leader_Id IS NOT NULL
          )

            SELECT 
                Team_Leader_Id
            FROM 
                TLHierarchy
            WHERE 
                Team_Leader_Id IS NOT NULL AND Team_Leader_Id <>".$row['U_Id']." LIMIT 1";
                
        $tl = $conn->query($sql);
        while($l = $tl->fetch_assoc()){

          if ($tl && $tl->num_rows > 0) {
            $team[] = ['Team_Leader_Id' => $l['Team_Leader_Id']
            ];
          }else{
            $team[] = ['Team_Leader_Id' => NULL
          ];
          }
  
        }
        
       
      }
          $count = 0; 
          $fieldsToCheck = array('Cp_Name', 'Cp_Email', 'Cp_Mobile', 'Cp_Location', 'Cp_Pin', 'Cp_ReraNo');

          foreach ($fieldsToCheck as $field) {

              if (empty($row[$field])) {
                  $count++;
              }
          }
  
          $_SESSION['incomplete_profile']= $count;
          




      $cookie_name = "npcrm";
      $j = new stdClass();
      $j->uid = $row['U_Id'];
      $j->uname = $row['U_Username'];
      $j->roleid = $row['U_RoleId'];
      $j->rolename = $row['Rl_Name'];
      $j->typeid = $row['U_TypeId'];
      $j->typename = $row['UType_Name'];
      $j->displayname = $row['U_DisplayName'];
      $j->ecode = $row['U_EmpCode'];
      $j->photo = $row['U_Photo'];
      $j->status = 1;
      $j->team=$team;
  

      $cookie_value = encrypt(json_encode($j));

      setcookie($cookie_name, $cookie_value, time() + (86400 * 1), "/"); // 86400 = 1 day

      insertActionsLog($row['U_Id'], "Logged In", "/login");

      header('Location: dashboard.php');
      

    }else{

      echo "Error: Something Went Wrong";

    } 

    $conn->close(); 
}


?>


<link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />


</head>

<body>

<div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <h2>NP CRM</h2>
                  </span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Welcome</h4>
              <p class="mb-4">Please sign-in to your account</p>

              <form id="formAuthentication" class="mb-3" action="" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Username</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="username"
                    placeholder="Enter your username"
                    autofocus
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <!-- <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    <a href="auth-forgot-password-basic.html">
                      <small>Forgot Password?</small>
                    </a>
                  </div> -->
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <!-- <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                </div> -->
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" name="submit" type="submit">Sign in</button>
                </div>
              </form>

              <!-- <p class="text-center">
                <span>New on our platform?</span>
                <a href="auth-register-basic.html">
                  <span>Create an account</span>
                </a>
              </p> -->
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>



<?php include('layouts/foot.php') ?>
</body>

</html>