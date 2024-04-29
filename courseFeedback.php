<?php
ob_start(); // Start output buffering
session_start();

include "./templates/header.php"; // Include header
require_once("conf/conf.php"); // Include configuration file

?>

<!-- Course feedback section -->
<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="card-body p-md-5 mx-md-4">

                        <!-- Title and logo -->
                        <div class="text-center">
                            <img src="images/uoj_logo.png" style="width: 90px;" alt="logo">
                            <h4 class="mt-1 mb-5 pb-1 pt-3">Course Feedback</h4>
                        </div>

                        <!-- Course feedback form -->
                        <form method="post" action="process_course_feedback.php">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <!-- Course name field -->
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="course_name" name="course_name" class="form-control" placeholder="Course name" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Date field -->
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="date" id="feedback_date" name="feedback_date" class="form-control" required />
                                    </div>
                                </div>
                            </div>
                            <!-- Overall satisfaction level -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="overall_satisfaction" class="form-label">Overall Satisfaction Level</label>
                                    <select id="overall_satisfaction" name="overall_satisfaction" class="form-select" required>
                                        <option value="" selected disabled>Select overall satisfaction level</option>
                                        <option value="very_dissatisfied">Very Dissatisfied</option>
                                        <option value="dissatisfied">Dissatisfied</option>
                                        <option value="neutral">Neutral</option>
                                        <option value="satisfied">Satisfied</option>
                                        <option value="very_satisfied">Very Satisfied</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Student feedback field -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="student_feedback" class="form-label">Student Feedback</label>
                                    <textarea id="student_feedback" name="student_feedback" class="form-control" rows="4" placeholder="Enter your feedback"></textarea>
                                </div>
                            </div>

                            <!-- Title 1 and questions -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5>Title 1</h5>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="question1" class="form-label">Question 1</label>
                                    <select id="question1" name="question1" class="form-select" required>
                                        <option value="" selected disabled>Select satisfaction level</option>
                                        <option value="strongly_disagree">Strongly Disagree</option>
                                        <option value="disagree">Disagree</option>
                                        <option value="not_sure">Not Sure</option>
                                        <option value="agree">Agree</option>
                                        <option value="strongly_agree">Strongly Agree</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="question2" class="form-label">Question 2</label>
                                    <select id="question2" name="question2" class="form-select" required>
                                        <option value="" selected disabled>Select satisfaction level</option>
                                        <option value="strongly_disagree">Strongly Disagree</option>
                                        <option value="disagree">Disagree</option>
                                        <option value="not_sure">Not Sure</option>
                                        <option value="agree">Agree</option>
                                        <option value="strongly_agree">Strongly Agree</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Title 2 and questions -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5>Title 2</h5>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="question3" class="form-label">Question 3</label>
                                    <select id="question3" name="question3" class="form-select" required>
                                        <option value="" selected disabled>Select satisfaction level</option>
                                        <option value="strongly_disagree">Strongly Disagree</option>
                                        <option value="disagree">Disagree</option>
                                        <option value="not_sure">Not Sure</option>
                                        <option value="agree">Agree</option>
                                        <option value="strongly_agree">Strongly Agree</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="question4" class="form-label">Question 4</label>
                                    <select id="question4" name="question4" class="form-select" required>
                                        <option value="" selected disabled>Select satisfaction level</option>
                                        <option value="strongly_disagree">Strongly Disagree</option>
                                        <option value="disagree">Disagree</option>
                                        <option value="not_sure">Not Sure</option>
                                        <option value="agree">Agree</option>
                                        <option value="strongly_agree">Strongly Agree</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <div class="text-center pt-1 mb-5 pb-1">
                                <button type="submit" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">Submit Feedback</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of course feedback section -->

<?php include "./templates/footer.php"; ?>

<?php
ob_end_flush(); // Flush the output buffer
?>