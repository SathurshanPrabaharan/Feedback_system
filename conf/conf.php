<?php
        define ('HOST','localhost');
        define ('USERNAME','root');
        define ('PW','');
        define ('DB','feedbackSystem');

        $conn = mysqli_connect (HOST,USERNAME,PW,DB);

        if (!$conn) {
            die ('check this error'. mysqli_connect_error());
        }
        else{
            // echo "Connected";
        }
?>