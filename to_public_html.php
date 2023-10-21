<!--Test Oracle file for UBC CPSC304 2018 Winter Term 1
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  This file shows the very basics of how to execute PHP commands
  on Oracle.
  Specifically, it will drop a table, create a table, insert values
  update values, and then query for values

  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the
  OCILogon below to be your ORACLE username and password -->

  <html>
    <head>
        <title>CPSC 304 PHP/Oracle Demonstration</title>
        <style>
            html * {
                line-height: 1.625;
                color: #2020131;
                font-family: Nunito, sans-serif;
            }
            /* Style inputs */
            input[type=text], input[type=number], select {
                width: 250px;
                padding: 2px 5px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            /* Style the submit button */
            input[type=submit] {
                width: 100px;
                background-color: #4281cf;
                color: white;
                padding: 2px 5px;
                margin: 8px 0;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .tip {
                opacity: 50%;
            }

            .flex-form  { display: table;      }
            .flex-form p     { display: table-row;  }
            .flex-form label { display: table-cell; }
            .flex-form input[type=text], .flex-form input[type=number], select { display: table-cell; margin-left: 25px; }

            table, th, td {
                border: 1px solid;
                background-color: white;
            }

            h1 { text-align: center; }

            .infoContainer {
                padding: 10px;
                display: flex;
                flex-wrap: wrap;
                text-align: center;
                justify-content: center;
            }

            .playerinfoDiv {
                width: 400px;
                background-color: #abd3f5;
                border-radius: 10px;
                margin: 10px;
                padding: 15px;
            }

            .gameinfoDiv {
                width: 400px;
                background-color: #b1e0c6;
                border-radius: 10px;
                margin: 10px;
                padding: 15px;
            }

        </style>
    </head>

    <body>
        <h1>Player Information </h1>

        <div class="infoContainer">

            <div class = "playerinfoDiv">
                <h2>Sign up as a Player</h2>
                <form method="POST" action="to_public_html.php"> <!--refresh page when submitted-->
                    <div class="flex-form">
                        <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
                        <p><label>Email:</label> <input type="text" name="insEmail"></p>
                        <p><label>Password:</label> <input type="text" name="insPassword"></p>
                        <p><label>Username:</label> <input type="text" name="insUsername"></p>
                    </div>
                    <input type="submit" value="Sign Up" name="insertSubmit">
                </form>
                <p class="tip">NOTICE: A random accountID Value will be assigned to the player with a default rank and subrank.</p>
            </div>

            <div class = "playerinfoDiv">
                <h2>Delete Account</h2>
                <form method="POST" action="to_public_html.php"> <!--refresh page when submitted-->
                    <div class="flex-form">
                        <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
                        <p><label>ID:</label> <input type="text" name="delID"></p>
                        <p><label>Password:</label> <input type="text" name="delPassword"></p>
                    </div>
                    <input type = "submit" value = "Delete" name = "deleteSubmit"></p>
                </form>
                <p class="tip">NOTICE: The values are case sensitive and if you enter in the wrong case, your account will not be removed (User must know their password).</p>
            </div>

            <div class = "playerinfoDiv" >
                <h2>Update Player Email</h2>
                <form method="POST" action="to_public_html.php"> <!--refresh page when submitted-->
                    <div class="flex-form">
                        <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
                        <p><label>Player Name:</label> <input type="text" name="oldName"></p>
                        <p><label>New Email:</label> <input type="text" name="newEmail"></p>
                    </div>
                    <input type="submit" value="Update" name="updateSubmit"></p>
                </form>
                <p class="tip">NOTICE: The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>
            </div>
        </div>
        
        <h1>Player Table Information:</h1>
        <div class="infoContainer">
            <div class = "playerinfoDiv" style="width:auto; min-width:400px;">
                <h2>Tables:</h2>
                <form method="GET" action="to_public_html.php"> <!--refresh page when submitted-->
                    <input type="hidden" id="getTablesRequest" name="getTablesRequest">
                    <input type="submit" value = "Show Tables" name="getTables"></p>
                    
                </form>
                <div style="display:flex;">
                    <?php
                        //PHP CODE to call request
                        if(isset($_GET['getTablesRequest'])) {
                            debug_to_console("Submit clicked");
                            handleGETRequest();
                        }
                        ?>
                </div>
            </div>
        </div>
        
        <h1> GamePlay Information</h1>

        <div class="infoContainer">
            <div class = "gameinfoDiv">
                <h2>Enemies with reward greater than:</h2>
                <form method="GET" action="to_public_html.php"> <!--refresh page when submitted-->
                    <div class="flex-form">
                        <input type="hidden" id="selectionRequest" name="selectionRequest">
                        <p><label>Gold reward:</label> <input type="number" name="goldInput"></p>
                    </div>
                    
                    <input type="submit" name="selectTuples"></p>
                </form>
                <?php
                if(isset($_GET['selectionRequest'])) {
                    handleGETRequest();
                }
                ?>
            </div>

            <div class = "gameinfoDiv">
                <h2>Return Inventory by type:</h2>
                <form method="GET" action="to_public_html.php"> <!--refresh page when submitted-->
                    <div class="flex-form">
                        <input type="hidden" id="projectionRequest" name="projectionRequest">
                        <p><label for="values">Select a value:</label>
                        <select id="values" name="values">
                            <option value="PlayerOwnerID">PlayerID</option>
                            <option value="Skin">Skin</option>
                            <option value="Currency">Currency</option>
                            <option value="AccountID">AccountID</option>
                        </select></p>
                    </div>
                        
                    <input type="submit" name="selectedValue"></p>
                </form>
                <?php
                if(isset($_GET['projectionRequest'])) {
                    debug_to_console("Isset passed");
                    handleGETRequest();
                }
                ?>
            </div>

            <div class = "gameinfoDiv">
                <h2>Champions played at Rank (Track the balancing of Champions)</h2>
                <form method="GET" action="to_public_html.php"> <!--refresh page when submitted-->
                    <div class="flex-form">
                        <input type="hidden" id="joinRequest" name="joinRequest">
                        <p><label for="Rankvalues">Select a rank:</label>
                        <select id="Rankvalues" name="Rankvalues">
                            <option value= 1>Rank1</option>
                            <option value= 2>Rank2</option>
                            <option value= 3>Rank3</option>
                            <option value= 4>Rank4</option>
                            <option value= 5>Rank5</option>
                        </select></p>
                    </div>
                    <input type="submit" name="joinTuples"></p>
                </form>
                <?php
                //PHP CODE to call request
                if(isset($_GET['joinRequest'])) {
                    handleGETRequest(); 
                }
                ?>
            </div>


            <div class = "gameinfoDiv">
                <h2>Champions earned average:</h2>
                <form method="GET" action="to_public_html.php"> <!--refresh page when submitted-->
                    <input type="hidden" id="groupByRequest" name="groupByRequest">
                    <input type="submit" name="groupByTuples">
                </form>
                <?php
                if(isset($_GET['groupByRequest'])) {
                    handleGETRequest();
                }
                ?>
            </div>

            <div class = "gameinfoDiv">
                <h2>Champions Item Count</h2>
                <form method="GET" action="to_public_html.php"> <!--refresh page when submitted-->
                    <div class="flex-form">
                        <input type="hidden" id="groupByHavingRequest" name="groupByHavingRequest">
                        <p><label>Number of Items:</label><input type = "number" name = "itemAmount"></p>
                    </div>
                    <input type="submit" name="groupByHavingTuples"></p>
                </form>
                <?php
                if(isset($_GET['groupByHavingRequest'])) {
                    handleGETRequest();
                }
                ?>
            </div>

            <div class = "gameinfoDiv">
                <h2>Champions with over/equal to an amount of health</h2>
                <form method="GET" action="to_public_html.php"> <!--refresh page when submitted-->
                    <div class="flex-form">
                        <input type="hidden" id="nestedAggreatedRequest" name="nestedAggreatedRequest">
                        <p><label>Health Value:</label> <input type="number" name="healthInput"></p>
                    </div>
                    <input type="submit" name="nestedAggreatedRequestTuples"></p>
                </form>

                <?php
                //PHP CODE to call request
                if(isset($_GET['nestedAggreatedRequest'])) {
                    handleGETRequest(); 
                }
                ?>
            </div>

            <div class = "gameinfoDiv">
            <h2>Players not matched with Player X! (by Account ID)</h2>
            <form method="GET" action="to_public_html.php"> <!--refresh page when submitted-->
                <input type="hidden" id="differenceRequest" name="differenceRequest">
                <input type="submit" name="differenceTuples"></p>
                AccountID: <input type = "text" name = "diffID"></p><br/><br/>
                <?php
                if(isset($_GET['differenceRequest'])) {
                    debug_to_console("Passed ISSET");
                    handleGETRequest();
                }
                ?>
            </form>
            </div>
        </div>

       
        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = true; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "";
                echo "<script type='text/javascript'>
                        alert('" . $message . "');
                      </script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
           // echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            debug_to_console("BEFORE PARSE");
            $statement = OCIParse($db_conn, $cmdstr);
            debug_to_console("AFTER PARSE");
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work
            if (!$statement) {
                // echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                echo "<br/>";
                debugAlertMessage("Query could not be executed.");
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                // echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                echo "<br/>";
                debugAlertMessage("Query could not be executed.");
                $success = False;
            }


			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                debugAlertMessage($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    debugAlertMessage($e['message']);
                    $success = False;
                }
            }
            return $success;
        }

        function printResult($result) { //prints results from a select statement
            echo "<div style='margin:10px;'><br>Retrieved data from table Player table:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Email</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>". $row[2] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table></div>";
        }

        function printResultRank($result) {
            echo "<div style='margin:10px;'><br>Retrieved data from table Rank_Is table:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Tier</th><th>Subrank</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>". $row[2] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table></div>";
        }


        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_", "a", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                // debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            // debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        //START OF OUR FUNCTIONS:

        function handleUpdateRequest() {
            global $db_conn;

            $player_name = $_POST['oldName'];
            $new_email = $_POST['newEmail'];

            $result_email = executePlainSQL("SELECT Email FROM Player WHERE Username = '".$player_name."'");
            if (($row = oci_fetch_row($result_email)) != false) {
                // you need the wrap the old name and new name values with single quotations
                executePlainSQL("UPDATE Player SET email='" . $new_email . "' WHERE username='" . $player_name . "'");
                debugAlertMessage("User " . $player_name . " updated.");
            } else {
                debugAlertMessage("User " . $player_name . " not found.");
            }

            OCICommit($db_conn);
        }

        function handleDeleteRequest() {
            global $db_conn; 
            //First we check that we password is correct to the ID: 
            $deleted_ID = $_POST['delID'];
            $deleted_password = strval($_POST['delPassword']);

            //Return the password for the given ID: 
                $result_password = executePlainSQL("SELECT Password_Player FROM Player WHERE AccountID = '".$deleted_ID."'");
                if(($row = oci_fetch_row($result_password)) != false) {
                    //Check if user inputted correct password.
                    if(strcmp(trim($row[0]), trim($deleted_password)) == 0) {
                        executePlainSQL("DELETE FROM Player WHERE AccountID ='".$deleted_ID."'");
                        debugAlertMessage("User " . $deleted_ID . " successfully deleted.");
                    } else {
                        debugAlertMessage("Password incorrect.");
                    }
                } else {
                    debugAlertMessage("User " . $deleted_ID . " not found.");
                }

            OCICommit($db_conn);
        }
        
        function handleInsertRequest() {
            global $db_conn;
            
    
            $account_id = rand(0, 100);

            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind0" => $account_id,
                ":bind1" => $_POST['insEmail'],
                ":bind2" => $_POST['insPassword'],
                ":bind3" => $_POST['insUsername']
            );

            $tupleRank = array(
                ":bind0" => $account_id,
                ":bind1" => 0,
                ":bind2" => "StarterRank"
            );

            $allRankTuples = array(
                $tupleRank
            );

            $alltuples = array (
                $tuple
            );

          executeBoundSQL("insert into Player values (:bind0, :bind1, :bind2, :bind3)", $alltuples);
          executeBoundSQL("insert into Rank_is values(:bind0, :bind1, :bind2)", $allRankTuples);
          debugAlertMessage("Player " . $_POST['insUsername'] . " inserted with values.");

  
        OCICommit($db_conn);
    }

    function handleSelectionRequest() {
        global $db_conn; 

        $gold_threshold = $_GET['goldInput'];

        
       
        debug_to_console($gold_threshold);
        if($gold_threshold !== null) {
        $statement = executePlainSQL("SELECT name FROM Enemies WHERE gold_reward >='". $gold_threshold . "'");
        echo "The enemies with gold greater than ". $gold_threshold." :<br>";
        while($row = oci_fetch_array($statement, OCI_BOTH)) {
            echo $row[0] . "<br>";
        }
        debug_to_console("After Execution");
    }
   
        OCICommit($db_conn);
    }

    function handleProjectionRequest() {
        global $db_conn;

        debug_to_console("projection Called");
        $drop_select = $_GET['values'];

        debug_to_console($drop_select);

        $statement = executePlainSQL("SELECT $drop_select FROM PlayerInventory_1");
        
      
        echo "<br>Retrieved Data from the Inventory:<br>";
        echo "<table>";
        echo "<tr><th>$drop_select</th></tr>";
        while($row = oci_fetch_array($statement, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td></tr>";
        }

        echo "</table>";
    }
    function handleJoinRequest() {
        global $db_conn; 

        $drop_select = $_GET['Rankvalues'];
        debug_to_console($drop_select);

        $statement = executePlainSQL("SELECT C.Name, R.Tier FROM Champion C, Rank_Is R, Picks S WHERE S.AccountID = R.AccountID AND S.Champ_name = C.Name AND R.Tier >= $drop_select");
        echo "<br>Retrived Data:<br>";
        echo "<table>";
        echo "<tr><th>Champion</th><th>Tier</th></tr>";
        while($row = oci_fetch_array($statement, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>";
        }

        echo "</table>";

        OCICommit($db_conn);
    }

    function handleAggregateGroupBy() {
        global $db_conn; 
        $health_select = $_GET['healthInput'];

        $statement = executePlainSQL("SELECT Ch.Name from Champion Ch where Ch.Name In (Select Name from Character Where Health In (Select Health from Character group By Health Having Health >= $health_select))");
        
        echo "Champions with health greater than or equal to ". $health_select.":<br>";
        while($row = oci_fetch_array($statement, OCI_BOTH)) {
            echo $row[0] . "<br>";
        }

        OCICommit($db_conn);
    }
    
    function handleGroupByRequest() {
        global $db_conn; 

        $statement = executePlainSQL("SELECT Name, AVG(coin) FROM Inventory_holds GROUP BY Name");
        echo "<br>Retrived Data:<br>";
        echo "<table>";
        echo "<tr><th>Champion</th><th>Average Coins</th></tr>";
        while($row = oci_fetch_array($statement, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>";
        }

        echo "</table>";

        OCICommit($db_conn);
    }

    function handleGroupByHavingRequest() {
        global $db_conn;
        $item_amount = $_GET['itemAmount'];
        $statement = executePlainSQL("SELECT C.Name, Count(T.ItemID) FROM Champion C, Inventory_holds I, Item_Contains T 
        WHERE C.Name = I.Name AND I.OwnerID = T.OwnerID GROUP BY C.Name Having Count(T.ItemId) >= $item_amount");
        echo "<br>Retrived Data:<br>";
        echo "<table>";
        echo "<tr><th>Champion</th><th>Number of Items</th></tr>";
          while($row = oci_fetch_array($statement, OCI_BOTH)) {
              echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>";
          }
  
        echo "</table>";

        OCICommit($db_conn);

    }

    function handleDifferenceRequest() {
        global $db_conn;

        $difference_id = $_GET['diffID'];

        //This is an error handling check. Meant for any random input of a none player in the text
        $check_statement = executePlainSQL("SELECT Player2 FROM Matches WHERE Player1 ='".$difference_id."' UNION SELECT Player1 FROM Matches WHERE Player2 ='".$difference_id."'");
        $check_row = oci_fetch_row($check_statement);
        if(empty($check_row) == 0) {
        $statement = executePlainSQL("SELECT AccountID FROM Player WHERE AccountID != '".$difference_id."' AND AccountID NOT IN (
            SELECT Player2 FROM Matches WHERE Player1 ='".$difference_id."' UNION SELECT Player1 FROM Matches WHERE Player2 = '".$difference_id."')");

        echo "<br>Players that have not played $difference_id <br>";
        echo "<table>";
        echo "<tr><th>Players</th></tr>";
        while($row = oci_fetch_array($statement, OCI_BOTH)) {
        echo "<tr><td>" . $row[0] ."</td></tr>";
        }

        echo "</table>";
        }

        OCICommit($db_conn);
    }

    function handleGetTables() {
        global $db_conn;

        $resultPlayer = executePlainSQL("SELECT AccountID, Username, Email FROM Player");
        printResult($resultPlayer);

        $resultRank = executePlainSQL("SELECT AccountID, Tier, Subrank FROM Rank_Is");
        printResultRank($resultRank);

        OCICommit($db_conn);

    }

    


        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                 if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if(array_key_exists('deleteQueryRequest', $_POST)) {
                    handleDeleteRequest(); 
                } 

                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('selectTuples', $_GET)) {
                    handleSelectionRequest();
                } else if(array_key_exists('getTables', $_GET)) {
                    handleGetTables();
                } else if (array_key_exists('joinTuples', $_GET)) {
                    handleJoinRequest();
                } else if(array_key_exists('selectedValue', $_GET)) {
                    handleProjectionRequest(); 
                } else if (array_key_exists('nestedAggreatedRequest', $_GET)) {
                    handleAggregateGroupBy();
                } else if(array_key_exists('groupByRequest', $_GET)) {
                    handleGroupByRequest();
                } else if(array_key_exists('groupByHavingTuples', $_GET)) {
                    handleGroupByHavingRequest();
                } else if (array_key_exists('differenceTuples', $_GET)) {
                    handleDifferenceRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
             handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest'])) {
            handleGETRequest();
        }

          //https://stackoverflow.com/questions/4323411/how-can-i-write-to-the-console-in-php
          function debug_to_console($data) {
            $output = $data;
            if (is_array($output))
                $output = implode(',', $output);
        
            echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
        }
		?>
	</body>
</html>