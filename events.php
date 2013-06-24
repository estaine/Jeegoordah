<?php
	$hostname = "sql-4.radyx.ru"; 
	$username = "jeegoordah617";
	$password = "sdy28infvj";
	$dbname = "jeegoordah617";			

	$dbhandle = mysql_connect($hostname, $username, $password, $dbname);
	
	mysql_select_db($dbname, $dbhandle);
	
	if(isset($_POST["actionType"]))
	{
		switch($_POST["actionType"])
		{
			case "edit":
				if(isset($_POST["fillDataName"]))
				{
					$updQuery = "UPDATE Events SET event_name = \"".$_POST["fillDataName"]."\" WHERE event_id = \"".$_POST["saveHidId"]."\"";
					$updRes = mysql_query($updQuery);
				}
				
				$alertFlag = 1;
				
				while (list($key, $val) = each($_POST))
				{
					if(strpos($key, "userDeleted") !== false)
					{
						$userId = substr($key, 11);
						if($val)
						{
							$delCheckUserQuery = "SELECT COUNT(*) AS recamount FROM Transactions WHERE ((Transactions.event_id = \"".$_POST["saveHidId"]."\") AND (Transactions.person_id = \"".$userId."\"))";
							$delCheckUserRes = mysql_query($delCheckUserQuery);
							$delCheckUserRow = mysql_fetch_array($delCheckUserRes);
							
							if($delCheckUserRow["recamount"] != 0)
							{
								if($alertFlag)
								{
									echo "<script type=\"text/javascript\">alert(\"Некоторые лица не были удалены из данного мероприятия, так как присутствуют в других таблицах.\"); </script>";
									$alertFlag = 0;
								}
							}
							else
							{
								$delUserQuery = "DELETE FROM EventsPersons WHERE ((EventsPersons.event_id = \"".$_POST["saveHidId"]."\") AND (EventsPersons.person_id = \"".$userId."\"))";
								$delUserRes = mysql_query($delUserQuery);
							}
						}
					}
				}

				break;
			case "delete":
				$delCheckQuery = "SELECT COUNT(*) AS recamount FROM EventsPersons WHERE EventsPersons.event_id = \"".$_POST["deleteHidId"]."\"";
				$delCheckRes = mysql_query($delCheckQuery);
				$delCheckRow = mysql_fetch_array($delCheckRes);
				if($delCheckRow["recamount"] == 0)
				{
					$delCheckQuery = "SELECT COUNT(*) AS recamount FROM Transactions WHERE Transactions.event_id = \"".$_POST["deleteHidId"]."\"";
					$delCheckRes = mysql_query($delCheckQuery);
					$delCheckRow = mysql_fetch_array($delCheckRes);
				}
				if($delCheckRow["recamount"] != 0)
					 echo "<script type=\"text/javascript\">alert(\"Данное мероприятие не может быть удалено, так как присутствует в других таблицах.\"); </script>";
				else
				{
					$delQuery = "DELETE FROM Events WHERE event_id =\"".$_POST["deleteHidId"]."\"";
					$delRes = mysql_query($delQuery);
				}
				break;
			case "add":
				if(isset($_POST["fillDataName"]))
				{
					$insQuery = "INSERT INTO Events (event_id, event_name) VALUES (NULL, \"".$_POST["fillDataName"]."\")";
					$insRes = mysql_query($insQuery);				
				}
				break;
			case "addUser":
				if(isset($_POST["fillDataUser"]))
				{
					$insUserQuery = "INSERT INTO EventsPersons (et_id, event_id, person_id) VALUES (NULL, \"".$_POST["addUserEventHidId"]."\", \"".$_POST["fillDataUser"]."\")";
					$insUserRes = mysql_query($insUserQuery);				
				}
				break;
		}
	}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Джигурда : Мероприятия</title>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="scripts/events.js"></script>
		<link rel="stylesheet" href="stylesheets/fonts.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="stylesheets/style.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="stylesheets/events.css" type="text/css" charset="utf-8">		
	</head>
	<body>
		<table id = "mainTable">
			<tr id = "titleRow">
				<td id = "titleCell" colspan = "5">
					ДЖИГУРДА
				</td>
			</tr>
			<tr id = "menuRow">
				<td id = "menuBox">
					<table id = "menuTable">
						<tr id = "menuTableRow">
							<td id = "menuTotal" class = "menuCell">
								<a href = "index.php">Итого</a>
							</td>
							<td id = "menuPersons" class = "menuCell">
								<a href = "persons.php">Люди</a>
							</td>
							<td id = "menuEvents" class = "menuCell">
								<a href = "events.php">Мероприятия</a>
							</td>
							<td id = "menuTransactions" class = "menuCell">
								<a href = "transactions.php">Траты</a>
							</td>
							<td id = "menuDirects" class = "menuCell">
								<a href = "directs.php">Расчёты</a>
							</td>		
						</tr>
					</table>
				</td>
			</tr>
			<tr id = "contentRow">
				<td id = "groupContentManage" colspan = "5">
					<table id = "groupContentManageTable">
						<tr id = "groupContentManageTableRow">
							<td id = "contentBox">
								<table id = "contentTable">
									<thead id = "contentTableHeader">
										<th id = "contentTableHeaderCellName">
											Название
										</th>
									</thead>
									<tbody>
										<?php

											$totalQuery = "SELECT * FROM Events";
											$totalRes = mysql_query($totalQuery);
											
											while($totalRow	= mysql_fetch_array($totalRes))
											{
												$pid = $totalRow["event_id"];
												echo "<tr id = \"contentTableRow".$pid."\" class = \"contentTableRow\"><td id = \"contentTableName".$pid."\" class = \"contentTableName\">";
												echo $totalRow["event_name"];
												$subQuery = "SELECT Persons.person_id AS person_id, Persons.person_name AS person_name FROM EventsPersons LEFT JOIN Persons ON EventsPersons.person_id = Persons.person_id WHERE event_id = \"".$pid."\" ORDER BY Persons.person_name";
												$subRes = mysql_query($subQuery);
												echo "<input type = \"hidden\" id = \"persArray".$pid."\" value = \"";
												while($subRow = mysql_fetch_array($subRes))
												{
													echo $subRow["person_id"].":".$subRow["person_name"].";";
												}
												echo "\">";
												$subNotQuery = "SELECT Persons.person_id AS person_id, Persons.person_name AS person_name FROM Persons WHERE person_id NOT IN (SELECT person_id FROM EventsPersons WHERE event_id = \"".$pid."\") ORDER BY Persons.person_name";
												$subNotRes = mysql_query($subNotQuery);
												echo "<input type = \"hidden\" id = \"persNotArray".$pid."\" value = \"";
												while($subNotRow = mysql_fetch_array($subNotRes))
												{
													echo $subNotRow["person_id"].":".$subNotRow["person_name"].";";
												}
												echo "\">";
												echo "</td></tr>";
											}								
										?>
									</tbody>
								</table>
							</td>
							<td id = "manageBox">
								<form name = "deleteLine" id = "deleteLine" method = "POST" action = "events.php">
									<table id = "manageTable">								
									</table>
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr id = "addRow">
				<td id = "addCell" colspan = "5">
					<img id = "addButton" class = "imgButton" src = "/images/Add.png"/>
				</td>
			</tr>
			<tr id = "fillDataRow">
				<td id = "fillDataBox">
					<form name = "updateTable" method = "POST" action = "events.php">
						<table id = "fillDataTable">
							<tr id = "fillDataNameRow">
								<td id = "tName">
								</td>
								<td id = "fillDataNameCell">
								</td>
							</tr>
							<tr id = "fillDataButtonsRow">
								<td>
								</td>
								<td id = "buttonCancelBox">
								</td>
								<td id = "buttonSaveBox">
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
	</body>
</html>