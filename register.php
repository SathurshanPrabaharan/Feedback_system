<?php
ob_start(); // Start output buffering
session_start();

require_once "utils/constants.php";


include "./templates/header.php";
require_once("conf/conf.php");

?>

<!--log in-->
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          
            
              <div class="card-body p-md-5 mx-md-4">

              <?php
                require_once("conf/conf.php");

                
                $message = "";

                // Check if the form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $firstName = $_POST["first_name"];
                    $lastName = $_POST["last_name"];
                    $userName = $_POST["user_name"];
                    $regNo = $_POST["reg_no"];
                    $dob = $_POST["dob"];
                    $age = $_POST["age"];
                    $batch = $_POST["batch"];
                    $academicYear = $_POST["academic_year"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $status = Status::PENDING;
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $errors = array();

                    // Validation checks
                    // if (empty($firstName) || empty($lastName) || empty($userName) || empty($regNo) || empty($dob) || empty($batch) || empty($academicYear) || empty($email) || empty($password) ) {
                    //     array_push($errors, "All fields are required");
                    // }
                    require_once "conf/conf.php";  
                    $sql = "SELECT * FROM students WHERE email = '$email'";
                    $resultEmail = $conn->query($sql);
                    
                    if ($resultEmail->num_rows > 0) {
                        array_push($errors,"Email already exists!");
                    }
                  
                    if(count($errors)>0){
                        foreach($errors as $error){
                        echo "<div class='alert alert-danger'>$error</div>";
                        }
                    }else{

                        $query = "INSERT INTO `students`( `reg_no`, `user_name`, `password`, `first_name`, `last_name`, `age`, `batch`, `academic_year`, `dob`, `email`, `Status`) 
                                  VALUES ('$regNo','$userName','$hashedPassword','$firstName','$lastName','$age','$batch','$academicYear','$dob','$email','$status')";
    
                        $result = mysqli_query($conn, $query);
    
                        if ($result) {
                            $message = "Query executed successfully.";
                            session_start();
                            $_SESSION['loggedin'] = true;
                            $_SESSION['userEmail'] = $email;
                            $_SESSION['userType'] = UserType::Student;
                            header("Location: login.php");
                            exit();
                        } else {
                            $message = "Error: " . mysqli_error($connect);
                        }
                    } 


                }
                ?>

                <div class="text-center">
                  <img src="images/uoj_logo.png"
                    style="width: 90px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1 pt-3">Student Feedback Management</h4>
                </div>

                <form id="register-form" action="register.php" method="POST">
                  <p>Please create your account</p>

                  <div class="row">
                    <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First name" />
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last name"/>
                        </div>
                    </div>
                   </div>

                   <div class="row">
                    <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="user_name" name="user_name" class="form-control" placeholder="User name" />
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="reg_no" name="reg_no" class="form-control" placeholder="Registration Number"/>
                        </div>
                    </div>
                   </div>

                   <div class="row">
                        <div class="col-md-4 mb-4">
                            <div data-mdb-input-init class="form-outline">
                                <input type="date" id="dob" name="dob" class="form-control" placeholder="Date of Birth" />
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div data-mdb-input-init class="form-outline">
                                <input type="number" id="age" name="age" class="form-control" placeholder="Age" />
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div data-mdb-input-init class="form-outline">
                                <select id="batch" name="batch" class="form-select">
                                    <option selected disabled>Select Batch</option>
                                    <option value="E18">E18</option>
                                    <option value="E19">E19</option>
                                    <option value="E20">E20</option>
                                    <option value="E21">E21</option>
                                    <option value="E22">E22</option>
                                    <option value="E23">E23</option>
                                    <option value="E24">E24</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <select id="academic_year" name="academic_year" class="form-select" style="margin-bottom: 10px;">
                            <option selected disabled>Select Academic Year</option>
                            <option value="2022">2020/2019</option>
                            <option value="2023">2019/2018</option>
                            <option value="2024">2018/2017</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" name="email" class="form-control" placeholder="Email address" />
                    </div>


                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" 
                        placeholder="Password"/>
                  </div>



                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Create Account</button>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Already have an account?</p>
                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger" onclick="window.location.href='login.php'">Login</button>
                  </div>

                </form>

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