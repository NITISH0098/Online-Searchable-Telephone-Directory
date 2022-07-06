
<table class="table table-striped">
 <?php
              $fname = preg_replace('/[^A-Za-z0-9. -]/ ', '', $_POST['fname']);
              $lname = preg_replace('/[^A-Za-z0-9 -]/ ', '', $_POST['lname']);
              $designation = $_POST['designation'];
              $lid=$_POST['lid'];
              $use_field="";
              $firstse="Searched fields are ";
			$my_temp="select * from employee where ";
			if($fname!=="")
			{
					$use_field="fname like '%$fname%'";
                    $firstse = $firstse." First name = <B>$fname</B>,";
			        print($firstse);
			}
			if($lname!=="")
			{
				if($use_field=="")
                {
				      $use_field="lname like '%$lname%'";
                      $firstse = $firstse." Last name = <B>$lname</B>,";
			          print($firstse);
                }
				else
                {
				      $use_field=$use_field." and lname like '%$lname%'";
                      $firstse = " Last name = <B>$lname</B>,";
                      print($firstse);

                }
               
			}
            if($designation!=="Designation")
			{
				if($use_field=="")
                {
				      $use_field="designation='$designation'";
                      $firstse = $firstse." Designation = <B>$designation</B>,";
			          print($firstse);
                }
				else
                {
				      $use_field=$use_field." and designation='$designation'";
                      $firstse = " Designation = <B>$designation</B>,";
                      print($firstse);
                }
                
			}
           

            if($lid!=="Departments")
			{
                $queryDept="SELECT description from location where lid='$lid'";
                $resultDept= mysqli_query($con,$queryDept) or die(mysqli_errno($con));
                $rowDept = mysqli_fetch_array($resultDept);
                $deptName= $rowDept['description'];
				if($use_field=="")
                {
				      $use_field="lid='$lid'";
                      $firstse = $firstse." Department = <B>$deptName</B>,";
			          print($firstse);
                }
				else
                {
				      $use_field=$use_field." and lid='$lid'";
                      $firstse = " Department = <B>$deptName</B>,";
                      print($firstse);
                }
                
			}
            
            if($fname=="" && $lname=="" && $designation=="Designation" && $lid=="Departments")
              {
                printf ("<br>");
                printf( "\nNO DETAILS FOUND! PLEASE USE THE ABOVE FIELDS FOR SEARCH FOR SPECIFIC DETAILS");
              }
            else 
            {
                printf("<br>");
                $query=$my_temp.$use_field;
			//print("#$query#<BR>");
                           $result = mysqli_query($con,$query) or die(mysqli_errno($con));
                        if (mysqli_num_rows($result) >= 1) {
                            printf("<br>To dial an Intercom number from outside please dial +91-3712-27-xxxx (where xxxx is any 4-digit-extension number of the University)<br><br>");
                            ?>
                            <thead>
                                <tr>
                                    <th>SL.NO</th>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>DESIGNATION</th>
                                    <th>DEPARTMENTS</th>
                                    <th>OFFICIAL EMAIL</th>
                                    <th>Office Intercom</th>
                                     <th>Home Intercom</th>
                            <?php if(isset($_SESSION['email'])&& $_SESSION['userType']=='admin') 
                                  printf("<th>ACTION</th>");
                            
                            ?>        
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter =1;
                                while ($row = mysqli_fetch_array($result)) {
                                //query for echoing the official mail and  official phone number and departments corresponding to the employee 
                                $queryOM="SELECT mailid FROM emailid WHERE eid='" . $row['eid'] . "'";
                                $resultOM= mysqli_query($con,$queryOM) or die(mysqli_errno($con));
                                $rowOM = mysqli_fetch_array($resultOM);

                                $queryOP = "SELECT phone FROM callerid WHERE eid='" . $row['eid'] . "' AND callerid.locationstatus ='office'";
                                                    $resultOP = mysqli_query($con, $queryOP) or die(mysqli_errno($con));
                                                    $rowOP = mysqli_fetch_array($resultOP);

                                                    $queryOP1 = "SELECT phone FROM callerid WHERE eid='" . $row['eid'] . "' AND callerid.locationstatus ='home'";
                                                    $resultOP1 = mysqli_query($con, $queryOP1) or die(mysqli_errno($con));
                                                    $rowOP1 = mysqli_fetch_array($resultOP1);
                                                    
                                $queryD="SELECT description FROM location WHERE lid='" . $row['lid'] . "'";
                                $resultD= mysqli_query($con,$queryD) or die(mysqli_errno($con));
                                $rowD = mysqli_fetch_array($resultD);
                                   
                                    printf( "<tr><td>" . "#" . $counter . "</td>
                                    <td>" . $row["fname"] . "</td><td>" . $row["lname"] . "</td><td> " . $row["designation"] . "</td>
                                    <td>" . $rowD["description"] . "</td><td>" . $rowOM["mailid"] . "</td>
                                    <td>" . $rowOP["phone"] . "</td>
                                                    <td>" . $rowOP1["phone"] . "</td>");
                                    
                                                    if(isset($_SESSION['email'])&& $_SESSION['userType']=='admin') 
                                                    printf("
                                                        <td>
                                                         <a href='editUsersDummy.php?uid=$row[eid] & fn=$row[fname] & ln=$row[lname] & desig=$row[designation] & des=$rowD[description] & em=$rowOM[mailid] & phn=$rowOP[phone] & phn1=$rowOP1[phone] '>
                                                            <button type='button' class='btn btn-info'>Edit</button></a>

                                                            <a href='manage-users.php?uid=$row[eid] & action=del' title='Delete'>
															<button type='button' class='btn btn-danger'>Delete</button></a>

                                                    </td>
                                                    </tr>");
                                   $counter++;
                                }
                                ?>
                            </tbody>
                            <?php

                        } 
                        else 
                        {
                            printf ("<br>");
                            printf( "\nNO DETAILS FOUND!");
                        }
                        ?>
                    </table>
                

           <?PHP }?>
			