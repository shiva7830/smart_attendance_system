<?php 
    require_once("config.php");

    $firstDayOfMonth = date("1-m-Y");
    $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
   
    // Fetching Students 
    $fetchingEmployee = mysqli_query($db, "SELECT * FROM attendance_employee") OR die(mysqli_error($db));
    $totalNumberOfEmployee = mysqli_num_rows($fetchingEmployee);

    $employeeNamesArray = array();
    $employeeIDsArray = array();
    $counter = 0;
    while($employees = mysqli_fetch_assoc($fetchingEmployee))
    {
        $employeeNamesArray[] = $employees['employee_name'];
        $employeeIDsArray[] = $employees['id'];
    }


?>


<table border="1" cellspacing="0">
<?php 
    for($i = 1; $i<=$totalNumberOfEmployee + 2; $i++)
    {
        if($i == 1)
        {
            echo "<tr>";
            echo "<td rowspan='2'>Names</td>";
            for($j = 1; $j<=$totalDaysInMonth; $j++)
            {
                echo "<td>$j</td>";
            }
            echo "</tr>";
        }else if($i == 2)
        {
            echo "<tr>";
            for($j = 0; $j<$totalDaysInMonth; $j++)
            {
                echo "<td>" . date("D", strtotime("+$j days", strtotime($firstDayOfMonth))) . "</td>";
            }
            echo "</tr>";
        }else 
        {
            echo "<tr>";
            echo "<td>" . $employeeNamesArray[$counter] . "</td>";
            for($j = 1; $j<=$totalDaysInMonth; $j++)
            {
                $dateOfAttendance = date("Y-m-$j");
                $fetchingEmployeeAttendance = mysqli_query($db, "SELECT attendance FROM attendance WHERE employee_id = '". $employeeIDsArray[$counter] ."' AND curr_date = '". $dateOfAttendance ."'") OR die(mysqli_error($db));
                
                $isAttendanceAdded = mysqli_num_rows($fetchingEmployeeAttendance);
                if($isAttendanceAdded > 0)
                {
                    $employeeAttendance = mysqli_fetch_assoc($fetchingEmployeeAttendance);
                    if($employeeAttendance['attendance'] == "P")
                    {
                        $color = "green";
                    }else if($employeeAttendance['attendance'] == "A")
                    {
                        $color = "red";
                    }else if($employeeAttendance['attendance'] == "H")
                    {
                        $color = "blue";
                    }else if($employeeAttendance['attendance'] == "L")
                    {
                        $color = "brown";
                    }

                    echo "<td style='background-color: $color; color:white'>" . $employeeAttendance['attendance'] . "</td>";
                }else {
                    echo "<td></td>";
                }
               

            }
            echo "</tr>";
            $counter++;
        }
    }
?>
</table>