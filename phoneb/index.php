<?php
	//start the session
	session_start();

	// include db configuration
	include('include/db_connect.php');

	// user's information
	$member_id = $_SESSION['id'];
	$member_name = $_SESSION['name'];

?>
    <!DOCTYPE html>
    <html>
    <head="en">

        <title>Phonebook | Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap-3.3.7/css/bootstrap.min.css">
        <link href="bootstrap-3.3.7/css/mystyle.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
        <script src="bootstrap-3.3.7/js/jquery.min.js"></script>
        <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
        <link href="bootstrap-3.3.7/images/logo.png" rel=icon>
        </head>

        <body style="background-image:url('bootstrap-3.3.7/images/whitebackground.jpg'); background-size:cover; background-repeat:no-repeat;">
            <div class="background">
                <nav class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <img style="float:left;" alt="My Phonebook Brand " src="bootstrap-3.3.7/images/logo.png" width="90" height="90">

                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <br>
                            <li class=""><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
                            <li class=""><a href="insert_contact.php">Add Contact <span class="sr-only">&gt;</span></a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome <?php echo $member_name; ?> <span <!--span class="caret"--></span></a>
                                <ul class="dropdown-menu">
                                    <li id="logout"><a href="login.php"> Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                    <!-- /.container-fluid -->
                </nav>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="row">	
				<div class="col-sm-4" style="text-align: right;">
					<select class="custom-select" id="SearchBy" style="height: 35px; width: 120px;">
						<option value="0">ID</option>
						<option value="1" selected>First Name</option>
						<option value="2">Last Name</option>
						<option value="3">Phone No.</option>
						<option value="4">City</option>
					</select>
				</div>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="myInput" onkeyup="Search()">
				</div>
			</div>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <table class="table table-striped table-inverse table-responsive" id="myTable">
                        <thead class="thead-inverse">
                            <tr>
                                <br>
                                <br>
                                <th onclick="sortTable(0)">ID</th>
                                <th onclick="sortTable(1)">First Name</th>
                                <th onclick="sortTable(2)">Last Name</th>
                                <th onclick="sortTable(3)">Phone No.</th>
                                <th onclick="sortTable(4)">City</th>
                                <th>Operation</th>
                            </tr>
                        </thead>

                        <!-- data here -->
                        <tbody>

                            <?php 
							$sortby;
							$count='0';
							$sql = "select * from contacts where member_id = '$member_id'";
							$result = mysqli_query($conn, $sql);
							while ($row = mysqli_fetch_array($result)) { 
								$count++;
								?>
                                <tr>
                                    <td>
                                        <?php echo $count; ?>
                                    </td>
                                    <td>
                                        <?php echo $row[1]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row[2]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row[3]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row[4]; ?>
                                    </td>
                                    <!-- <td> <a class="btn btn-info" href="view-contact.php?id=<?php echo $row[0] ?>">View </a> </td> -->
                                    <td> <a class="btn btn-warning" href="update_contact.php?id=<?php echo $row[0]; ?>">Update </a> </td>
                                    <td> <a class="btn btn-danger" href="delete-contact.php?id=<?php echo $row[0];  ?>">Delete</a> </td>
                                </tr>

                                <?php
							}

							?>

                        </tbody>

                       
                    </table>
                </div>

            </div>

            <!-- View Contact -->
            <?php
			if(isset($_GET['view_contact_id']) == 1 ){ ?>
                <?php include('view_contact.php'); ?>
                    <script type='text/javascript'>
                        $('#view_contact').fadeIn();

                        window.onclick = function(event) {
                            if (event.target == modal) {
                                $('#view_contact').fadeOut();
                            }
                        }
                    </script>
                    <?php } 
			?>

            <!-- Delete Contact -->
            <?php
			if(isset($_GET['delete_contact_id']) == 1 ){ ?>
	            <?php include('delete_contact.php'); ?>
	                <script type='text/javascript'>
	                    $('#delete_contact_id').fadeIn();

	                    window.onclick = function(event) {
	                        if (event.target == modal) {
	                            $('#delete_contact_id').fadeOut();
	                        }
	                    }
	                </script>
	                <?php } ?>
       
       <script type="text/javascript">
       		// Sort Table
			function sortTable(n)
			{
				var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
				table = document.getElementById("myTable");
				switching = true;
				//Set the sorting direction to ascending:
				dir = "asc"; 
				/*Make a loop that will continue until
				no switching has been done:*/
				while (switching)
				{
					//start by saying: no switching is done:
					switching = false;
					rows = table.rows;
					/*Loop through all table rows (except the
					first, which contains table headers):*/
					for (i = 1; i < (rows.length - 1); i++)
					{
						//start by saying there should be no switching:
						shouldSwitch = false;
						/*Get the two elements you want to compare,
						one from current row and one from the next:*/
						x = rows[i].getElementsByTagName("TD")[n];
						y = rows[i + 1].getElementsByTagName("TD")[n];
						/*check if the two rows should switch place,
						based on the direction, asc or desc:*/
						if (dir == "asc")
						{
							if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase())
							{
								//if so, mark as a switch and break the loop:
								shouldSwitch= true;
								break;
							}
						}
						else if (dir == "desc")
						{
							if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase())
							{
								//if so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						}
					}
					if (shouldSwitch)
					{
						/*If a switch has been marked, make the switch
						and mark that a switch has been done:*/
						rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
						switching = true;
						//Each time a switch is done, increase this count by 1:
						switchcount ++;
					}
					else
					{
						/*If no switching has been done AND the direction is "asc",
						set the direction to "desc" and run the while loop again.*/
						if (switchcount == 0 && dir == "asc")
						{
							dir = "desc";
							switching = true;
						}
					}
				}
			}
			// Search Table
			function Search()
			{
				var input, filter, table, tr, td, i, txtValue;
				SearchBy = document.getElementById("SearchBy").value;
				input = document.getElementById("myInput");
				filter = input.value.toUpperCase();
				table = document.getElementById("myTable");
				tr = table.getElementsByTagName("tr");
				for (i = 0; i < tr.length; i++)
				{
					td = tr[i].getElementsByTagName("td")[SearchBy];
					if (td)
					{
						txtValue = td.textContent || td.innerText;
						if (txtValue.toUpperCase().indexOf(filter) > -1)
						{
							tr[i].style.display = "";
						}
						else
						{
							tr[i].style.display = "none";
						}
					}
				}
			}
       </script>
        </body>
    
    </html>