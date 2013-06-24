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
				if(isset($_POST['fillDataName']))
				{
					$updQuery = "UPDATE Persons SET person_name = \"".$_POST["fillDataName"]."\" WHERE person_id = \"".$_POST["saveHidId"]."\"";
					$updRes = mysql_query($updQuery);
				}
				break;				
			case "delete":
				$delCheckQuery = "SELECT COUNT(*) AS recamount FROM Directs WHERE ((Directs.debitor_id = \"".$_POST["deleteHidId"]."\") OR (Directs.creditor_id = \"".$_POST["deleteHidId"]."\"))";
				$delCheckRes = mysql_query($delCheckQuery);
				$delCheckRow = mysql_fetch_array($delCheckRes);
				if($delCheckRow["recamount"] == 0)
				{
					$delCheckQuery = "SELECT COUNT(*) AS recamount FROM Transactions WHERE Transaction.person_id = \"".$_POST["deleteHidId"]."\"";
					$delCheckRes = mysql_query($delCheckQuery);
					$delCheckRow = mysql_fetch_array($delCheckRes);
					if($delCheckRow["recamount"] == 0)
					{
						$delCheckQuery = "SELECT COUNT(*) AS recamount FROM EventsPersons WHERE EventsPersons.person_id = \"".$_POST["deleteHidId"]."\"";
						$delCheckRes = mysql_query($delCheckQuery);
						$delCheckRow = mysql_fetch_array($delCheckRes);	
					}
				}
				if($delCheckRow["recamount"] != 0)
					 echo "<script type=\"text/javascript\">alert(\"Данное лицо не может быть удалено, так как присутствует в других таблицах.\"); </script>";
				else
				{
					$delQuery = "DELETE FROM Persons WHERE person_id =\"".$_POST["deleteHidId"]."\"";
					$delRes = mysql_query($delQuery);
				}
				break;
			case "add":
				if(isset($_POST['fillDataName']))
				{
					$insQuery = "INSERT INTO Persons (person_id, person_name) VALUES (NULL, \"".$_POST['fillDataName']."\")";
					$insRes = mysql_query($insQuery);				
				}
				break;
		}
	}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Джигурда : Люди</title>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="scripts/persons.js"></script>
		<link rel="stylesheet" href="stylesheets/fonts.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="stylesheets/style.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="stylesheets/persons.css" type="text/css" charset="utf-8">		
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
											Имя
										</th>
									</thead>
									<tbody>
										<?php

											$totalQuery = "SELECT * FROM Persons";
											$totalRes = mysql_query($totalQuery);
											
											while($totalRow	= mysql_fetch_array($totalRes))
											{
												$pid = $totalRow["person_id"];
												echo "<tr id = \"contentTableRow".$pid."\" class = \"contentTableRow\"><td id = \"contentTableName".$pid."\" class = \"contentTableName\">";
												echo $totalRow["person_name"];
												echo "</td></tr>";
											}								
										?>
									</tbody>
								</table>
							</td>
							<td id = "manageBox">
								<form name = "deleteLine" id = "deleteLine" method = "POST" action = "persons.php">
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
					<form name = "updateTable" method = "POST" action = "persons.php">
						<table id = "fillDataTable">
							<tr id = "fillDataNameRow">
								<td id = "tName">
								</td>
								<td id = "fillDataNameCell">
								</td>
							</tr>
							<tr id = "fillDataButtonsRow">
								<td id = "buttonCancelBox">
								</td>
								<td id = "buttonSaveBox">
								</td>
							</td>
						</table>
					</form>
				</td>
			</tr>
		</table>
	</body>
</html>