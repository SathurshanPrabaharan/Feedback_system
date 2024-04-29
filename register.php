<?php
ob_start(); // Start output buffering
session_start();


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

                <div class="text-center">
                  <img src="images/uoj_logo.png"
                    style="width: 120px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1 pt-4">Student Feedback Management</h4>
                </div>

                <form>
                  <p>Please login to your account</p>

                  <div class="row">
                    <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="first_name" class="form-control" placeholder="First name" />
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="last_name" class="form-control" placeholder="Last name"/>
                        </div>
                    </div>
                   </div>

                   <div class="row">
                    <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="user_name" class="form-control" placeholder="User name" />
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="reg_no" class="form-control" placeholder="Registration Number"/>
                        </div>
                    </div>
                   </div>

                   <div class="row">
    <div class="col-md-6 mb-4">
        <div data-mdb-input-init class="form-outline">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" id="dob" class="form-control" />
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div data-mdb-input-init class="form-outline">
            <label for="batch" class="form-label">Select Batch</label>
            <select id="batch" class="form-select">
                <option selected disabled>Select Batch</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <!-- Add more options as needed -->
            </select>
        </div>
    </div>
</div>



                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="form2Example11" class="form-control"
                      placeholder="Email address" />
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="form2Example22" class="form-control" 
                        placeholder="Password"/>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="button">Log
                      in</button>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Don't have an account?</p>
                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Create new</button>
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