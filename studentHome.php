<?php
ob_start(); // Start output buffering
session_start();
require_once "utils/constants.php";
require_once "conf/conf.php";


// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Check if a remember user cookie exists
    if (!isset($_COOKIE['remember_user_email'])) {
        // Redirect the user to the login page if not logged in and no remember user cookie
        header("Location: login.php");
        exit();
    } 
}


include "./templates/header.php";
include "./user-components/userNavbar.php";

?>




<!-- Dynamically fetch data -> staffs, pref_date, pref_time -->
<script>
    $(document).ready(function() {

        function fetchstaffs() {
            $.ajax({
                url: 'utils/fetch_staffs.php',
                method: 'GET',
                success: function(data) {
                    data.forEach(staff => $('#staffsDropdown').append(`<option value="${staff.id}">${staff.first_name} ${staff.last_name} ${staff.profession}</option>`));
                },
                error: function() {
                    console.error('Error fetching staff names.');
                }
            });
        }

        function fetchStaffAvailableDate(selectedStaffId) {
            $.ajax({
                url: 'utils/fetch_staff_available_date_data.php',
                method: 'GET',
                data: {
                    staff_id: selectedStaffId
                },
                dataType: 'json',
                success: function(data) {
                    $('#dateDropdown').empty(); // Clear existing options

                    if (!data.error) {
                        $('#dateDropdown').prop('disabled', false);
                        $('#timeDropdown').prop('disabled', false);

                        data.forEach(result => $('#dateDropdown').append(`<option value="${result.available_date}">${result.available_date}</option>`));

                        // Automatically trigger the change event to fetch available times for the first date (if available)
                        const firstDate = $('#dateDropdown').val();
                        if (firstDate) {
                            fetchStaffAvailableTime(selectedStaffId, firstDate);
                        }
                    } else {
                        // Disable the dropdown and set a default value
                        $('#dateDropdown').prop('disabled', true).append('<option value="">No dates available</option>');
                        $('#timeDropdown').empty(); // Clear existing options
                        $('#timeDropdown').prop('disabled', true).append('<option value="">No time available</option>');
                    }
                },
                error: function() {
                    console.error('Error fetching staff available date.');
                }
            });
        }

        function fetchStaffAvailableTime(selectedStaffId, selectedDate) {
            $.ajax({
                url: 'utils/fetch_staff_available_time_data.php',
                method: 'GET',
                data: {
                    staff_id: selectedStaffId,
                    available_date: selectedDate
                },
                dataType: 'json',
                success: function(result) {

                    $('#timeDropdown').prop('disabled', false);
                    $('#timeDropdown').empty(); // Clear existing options

                    // data.forEach(result => {
                    if (parseInt(result.time_0830) === 1) $('#timeDropdown').append(`<option value="<?php echo TimeSlot::Time_0830 ?>"><?php echo TimeSlot::Time_0830 ?></option>`);
                    if (parseInt(result.time_0930) === 1) $('#timeDropdown').append(`<option value="<?php echo TimeSlot::Time_0930 ?>"><?php echo TimeSlot::Time_0930 ?></option>`);
                    if (parseInt(result.time_1030) === 1) $('#timeDropdown').append(`<option value="<?php echo TimeSlot::Time_1030 ?>"><?php echo TimeSlot::Time_1030 ?></option>`);
                    if (parseInt(result.time_1130) === 1) $('#timeDropdown').append(`<option value="<?php echo TimeSlot::Time_1130 ?>"><?php echo TimeSlot::Time_1130 ?></option>`);
                    if (parseInt(result.time_1230) === 1) $('#timeDropdown').append(`<option value="<?php echo TimeSlot::Time_1230 ?>"><?php echo TimeSlot::Time_1230 ?></option>`);
                    if (parseInt(result.time_1330) === 1) $('#timeDropdown').append(`<option value="<?php echo TimeSlot::Time_1330 ?>"><?php echo TimeSlot::Time_1330 ?></option>`);
                    if (parseInt(result.time_1430) === 1) $('#timeDropdown').append(`<option value="<?php echo TimeSlot::Time_1430 ?>"><?php echo TimeSlot::Time_1430 ?></option>`);
                    if (parseInt(result.time_1530) === 1) $('#timeDropdown').append(`<option value="<?php echo TimeSlot::Time_1530 ?>"><?php echo TimeSlot::Time_1530 ?></option>`);

                    // };

                    if ($('#timeDropdown option').length == 0) {
                        $('#timeDropdown').empty(); // Clear existing options
                        $('#timeDropdown').prop('disabled', true).append('<option value="">No time available</option>');

                    }


                },
                error: function() {
                    console.error('Error fetching staff available time.');
                }
            });
        }

        $('#staffsDropdown').change(function() {
            const selectedStaffId = $(this).val();
            fetchStaffAvailableDate(selectedStaffId);
        });

        $('#dateDropdown').change(function() {
            const selectedStaffId = $('#staffsDropdown').val();
            const selectedDate = $(this).val();
            fetchStaffAvailableTime(selectedStaffId, selectedDate);
        });

        // Fetch the staffs
        fetchstaffs();



    });
</script>

<!-- Status & Notifications -->
<script>
    $(document).ready(function() {


        // Function to fetch and show data
        function fetchDataAndUpdateUserMeetings() {

            var studentId = "<?php echo $_SESSION['userId']; ?>";

            $.ajax({
                url: 'utils/fetch_user_meetings.php',
                method: 'GET',
                data: {
                    orderBy: 'updated_at',
                    orderMethod: 'DESC',
                    whereBy: 'student_id',
                    whereValue: studentId
                },
                success: function(data) {
                    updateUserMeetings(data); // Function to update Appointment view with the fetched data
                },
                error: function() {
                    console.error('Error fetching data.');
                }
            });

        }



        // Function to update the table with new data
        function updateUserMeetings(data) {
            var userMeetingsDiv = $('#userMeetings');
            // var moreLessButtonCode = $('#moreLessButtonCode');
            userMeetingsDiv.empty();



            // Loop through the fetched data and append rows to the table
            data.forEach(meeting => {

                // Action Buttons
                // const collapseId = `meetingDetails-${meeting.meeting_id}`; // Unique ID for each collapse element
                let textColor = "";
                let icon = "";

                if (meeting.meeting_status === <?php echo json_encode(MeetingStatus::Pending); ?>) {
                    textColor = "text-warning";
                    icon = "fas fa-clock";
                } else if (meeting.meeting_status === <?php echo json_encode(MeetingStatus::Approved); ?>) {
                    textColor = "text-success";
                    icon = "fas fa-check-circle";
                } else if (meeting.meeting_status === <?php echo json_encode(MeetingStatus::Rejected); ?>) {
                    textColor = "text-danger";
                    icon = "fas fa-times-circle";
                }


                var row = `<div class="user-notification" id="user-notification1">
                        <div class="alert alert-light border-primary" id="user-notificationContent-${meeting.meeting_id}">
                            <div class="mb-1 mt-3 ">
                                <h5 class="d-flex p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3">
                                    <!--<span class="text-primary mr-2"><i class="fas fa-heading"></i></span>-->
                                    <span class="text-primary pr-2 h3 ">Title :&nbsp; </span>
                                    <span class="text-primary h3"><b> ${meeting.meeting_heading} </b></span>
                                    <!-- Add the button here -->
                                    <button type="button" class="btn btn-sm ml-2" data-bs-toggle="modal" data-id="${meeting.meeting_id}" data-bs-target="#detailsModal">
                                        <i class="fas fa-question-circle"></i>
                                    </button>
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4 h5">
                                    <span class="text-black mr-2"><i class="fas fa-calendar"></i></span>
                                    <span class="text-black">&nbsp;${meeting.meeting_pref_date}</span>
                                </div>
                                <div class="col-12 col-sm-4 h5">
                                    <span class="text-black mr-2"><i class="fas fa-clock"></i></span>
                                    <span class="text-black">&nbsp;${meeting.meeting_pref_time}</span>
                                </div>
                            </div> 

                           <!-- <div class="my-3">
                                <p class="d-flex align-items-center h5">
                                    <span class="text-black mr-2"><i class="fas fa-calendar"></i></span>
                                    <span class="text-black">&nbsp;${meeting.meeting_pref_date}</span>
                                </p>
                            </div>

                            <div class="my-3">
                                <p class="d-flex align-items-center h5">
                                    <span class="text-black mr-2"><i class="fas fa-clock"></i></span>
                                    <span class="text-black">&nbsp;${meeting.meeting_pref_time}</span>
                                </p>
                            </div>-->

                            <div class="row">
                                <div class="col-12 col-sm-4 h5">
                                    <span class="text-black mr-2"><i class="fas fa-user"></i></span>
                                    <span class="text-black">&nbsp;${meeting.staff_first_name} ${meeting.staff_last_name}</span>
                                </div>
                                <div class="col-12 col-sm-4 h5">
                                    <span class="text-black mr-2"><i class="fas fa-briefcase"></i></span>
                                    <span class="text-black">&nbsp;${meeting.staff_profession}</span>
                                </div>
                                <div class="col-12 col-sm-4 ${textColor} h5">
                                    <b><span class="mr-2"><i class="${icon}"></i></span>
                                    <span>&nbsp;${meeting.meeting_status}</span></b>
                                </div>
                            </div>
                            
                           
                            <div class="mt-3">
                                <p class="d-flex align-items-center">
                                    <span class="text-muted mr-2"><i class="fas fa-comment"></i></span>
                                    <span class="text-muted">&nbsp;${meeting.meeting_reject_reason}</span>
                                </p>
                            </div>
                        </div>
                    </div>`;

                userMeetingsDiv.append(row);
            });

        }

        // Fetch and update data initially on page load
        fetchDataAndUpdateUserMeetings();

        // Set interval to periodically fetch and update data (every 5 seconds in this example)
        setInterval(fetchDataAndUpdateUserMeetings, 5000);
    });
</script>
<!-- End Status & Notifications -->

<!-- Meeting information Modal -->
<script>
    $(document).ready(function() {
        $('#detailsModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            $.ajax({
                url: 'utils/fetch_user_meeting_data.php',
                method: 'GET',
                data: {
                    whereBy: 'id',
                    whereValue: id
                },
                dataType: 'json',
                success: function(meeting) {
                    $('#showMeetingHeading').text(meeting.meeting_heading);
                    $('#showMeetingPurpose').text(meeting.meeting_purpose);
                    $('#showMeetingOutline').text(meeting.meeting_outline);
                    $('#showMeetingAddInfo').text(meeting.meeting_add_info);

                    if (meeting.meeting_file_data_exist) {
                        $('#showMeetingAttachment').html(`<a href="utils/fetch_meeting_attachment.php?id=${meeting.meeting_id}" download="${meeting.meeting_filename}">${meeting.meeting_filename}</a>`);

                    } else {
                        $('#showMeetingAttachment').html(`<span class="text-danger">No attachment</span>`);
                    }

                },
                error: function() {
                    console.error('Error fetching data.');
                }
            });
        });
    });
</script>
<!-- End Meeting information Modal -->

<!-- user dashboard typing animation -->
<script>
    const sentences = [
        "<strong>B</strong>ook your <strong>A</strong>ppointment <strong>E</strong>asily and <strong>S</strong>ecurely.",
        "<strong>M</strong>ake connections <strong>S</strong>imply.",
        "Welcome to <strong>S</strong>chedule<strong>M</strong>e <strong>A</strong>pp."
    ];

    let index = 0;
    let sentenceIndex = 0;

    function type() {
        const currentText = sentences[sentenceIndex];
        document.getElementById('sentence').innerHTML = currentText.substring(0, index + 1);
        index++;

        if (index <= currentText.length) {
            setTimeout(type, 50);
        } else {
            setTimeout(() => {
                index = 0;
                sentenceIndex = (sentenceIndex + 1) % sentences.length;
                type();
            }, 1000); // Delay before starting the next sentence
        }
    }

    window.onload = function() {
        type();
    };
</script>
<!-- END user dashboard typing animation -->

<!-- User Dashborad meeting data -->

<script>
    $(document).ready(function() {


        function fetchDataAndUpdateUserTodayMeetings() {
            var studentId = "<?php echo $_SESSION['userId']; ?>";

            const todayDate = new Date();
            const formattedTodayDate = `${todayDate.getFullYear()}-${String(todayDate.getMonth() + 1).padStart(2, '0')}-${String(todayDate.getDate()).padStart(2, '0')}`;
            $.ajax({
                url: 'utils/fetch_user_today_meetings.php',
                method: 'GET',
                data: {
                    date: formattedTodayDate,
                    whereBy: 'student_id',
                    whereValue: studentId
                },

                success: function(data) {
                    var userTodayMeetingsDiv = $('#userTodayMeetings');
                    // var moreLessButtonCode = $('#moreLessButtonCode');
                    userTodayMeetingsDiv.empty();



                    // Loop through the fetched data and append rows to the table
                    data.forEach(meeting => {



                        var row = ` <div class="alert alert-light border-primary">
                            <div class="mb-1 mt-3 ">
                                <h5 class="d-flex p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3">
                                   
                                
                                <!--<span class="text-primary mr-2"><i class="fas fa-heading"></i></span>-->
                                    <span class="text-primary pr-2 h3 ">Title :&nbsp; </span>
                                    <span class="text-primary h3"><b>  ${meeting.meeting_heading} </b></span>
                                    
                                    
                                </h5>
                            </div>
                            
                            <div class="row">
                                <div class="col-12 col-sm-4 h5">
                                    <span class="text-black mr-2"><i class="fas fa-user"></i></span>
                                    <span class="text-black">&nbsp;${meeting.staff_first_name} ${meeting.staff_last_name} </span>
                                </div>
                                <div class="col-12 col-sm-4 h5">
                                    <span class="text-black mr-2"><i class="fas fa-briefcase"></i></span>
                                    <span class="text-black">&nbsp;${meeting.staff_profession}</span>
                                </div>
                                <div class="col-12 col-sm-4 h5">
                                <span class="text-black mr-2"><i class="fas fa-clock"></i></span>
                                    <span>&nbsp;${meeting.meeting_pref_time}</span></b>
                                </div>
                            </div>
                            


                    </div>`;

                        userTodayMeetingsDiv.append(row);
                    });
                },
                error: function() {
                    console.error('Error fetching data.');
                }
            });

        }


        fetchDataAndUpdateUserTodayMeetings();

        // Set interval to periodically fetch and update data (every 5 seconds in this example)
        setInterval(fetchDataAndUpdateUserTodayMeetings, 5000);
    });
</script>


<?php include "./templates/footer.php"; ?>

<?php
ob_end_flush(); // Flush the output buffer
?>