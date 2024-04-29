<?php
require_once "utils/constants.php";
ob_start(); // Start output buffering
session_start();


include "./templates/header.php";
require_once("conf/conf.php");

?>

<?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $userEmail = $_POST['email'];
          $password = $_POST['password'];
          $userType = $_POST['user_type'];


          require_once("conf/conf.php");
          if ($userType == UserType::Lecturer) {
            $userDb = 'lecturers';
            $redirectPage = 'lecturerHome.php';
          } else if ($userType == UserType::Student) {
            $userDb = 'students';
            $redirectPage = 'studentHome.php';
          }


          $sql = "SELECT * FROM " . $userDb . " WHERE email='$userEmail'";
          $result = mysqli_query($conn, $sql);
          $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
          $userId = $user['id'];

          //check success loggedin
          if ($user && password_verify($password, $user['password'])) {

            // Valid credentials - set up the session
            $_SESSION['userType'] = $userType;
            $_SESSION['userEmail'] = $userEmail;
            $_SESSION['userId'] = $userId;
            $_SESSION['loggedin'] = true;



            // Redirect to a logged-in page
            header("Location: " . $redirectPage);
            exit();
          } else {
            if (!$user) {
              echo "<div class='alert alert-danger'>User does not exists!</div>";
            } else {
              echo "<div class='alert alert-danger'>Wrong password!</div>";
            }
          }
        }


        ?>

<!--log in-->
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="images/uoj_logo.png"
                    style="width: 120px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1 pt-4">Student Feedback Management</h4>
                </div>

                <!-- form -->
                <form id="login-form" action="login.php" method="POST">
                  <p>Please login to your account</p>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control"
                      placeholder="Email address" />
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" 
                        placeholder="Password"/>
                  </div>

                  <!-- Radio box for selecting user type -->
                  <div class="text-center mb-4">
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="user_type" id="studentRadio" value="STUDENT" checked>
                      <label class="form-check-label" for="studentRadio">
                        Student
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="user_type" id="lectureRadio" value="LECTURER">
                      <label class="form-check-label" for="lectureRadio">
                        Lecturer
                      </label>
                    </div>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Log
                      in</button>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Don't have an account?</p>
                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger" onclick="window.location.href='register.php'">Create new</button>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
              <div class="text-center">
                <img src="images/login.png" style="width: 200px;" alt="login">
            </div>
                <h4 class="mb-4">Empowering Feedback in Education</h4>
                <p class="small mb-0">At the University of Jaffna, Faculty of Engineering, our student feedback system is pivotal. Your input drives our continuous improvement efforts, shaping an educational experience that prepares students for success in the dynamic field of engineering. Thank you for helping us cultivate excellence.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--log in-->


<?php include "./templates/footer.php"; ?>

<?php
ob_end_flush(); // Flush the output buffer
?>
