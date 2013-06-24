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
				$updQuery = "UPDATE Transactions SET amount = \"".$_POST["fillDataAmount"]."\", comment = \"".$_POST["fillDataComment"]."\" WHERE transaction_id = \"".$_POST["saveHidId"]."\"";
				$updRes = mysql_query($updQuery);
				break;				
			case "delete":
				$delQuery = "DELETE FROM Transactions WHERE transaction_id =\"".$_POST["deleteHidId"]."\"";
				$delRes = mysql_query($delQuery);
				break;
			case "add":
				$addUserEventCheckQuery = "SELECT COUNT(*) AS recamount FROM EventsPersons WHERE ((person_id = \"".$_POST["fillDataName"]."\") AND (event_id = \"".$_POST["fillDataEvent"]."\"))";
				$addUserEventCheckRes = mysql_query($addUserEventCheckQuery);
				$addUserEventCheckRow = mysql_fetch_array($addUserEventCheckRes);
				
				if($addUserEventCheckRow["recamount"] == 0)
					echo "<script type=\"text/javascript\">alert(\"Транзакция отклонена. Указанное лицо отсутствует в спике участников указанного мероприятия.\"); </script>";
				else
				{
					$insQuery = "INSERT INTO Transactions (transaction_id, person_id, event_id, amount, comment) VALUES (NULL, \"".$_POST["fillDataName"]."\", \"".$_POST["fillDataEvent"]."\", \"".$_POST["fillDataAmount"]."\", \"".$_POST["fillDataComment"]."\")";
					$insRes = mysql_query($insQuery);		
				}
				break;
		}
	}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Джигурда : Траты</title>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="scripts/transactions.js"></script>
		<link rel="stylesheet" href="stylesheets/fonts.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="stylesheets/style.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="stylesheets/transactions.css" type="text/css" charset="utf-8">		
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
										<th id = "contentTableHeaderCellEvent">
											Мероприятие
										</th>
										<th id = "contentTableHeaderCellName">
											Имя
										</th>
										<th id = "contentTableHeaderCellAmount">
											Сумма
										</th>
										<th id = "contentTableHeaderCellComment">
											Пометка
										</th>
									</thead>
									<tbody>
										<?php

											$totalQuery = "SELECT Transactions.transaction_id AS transaction_id, Transactions.amount AS amount, Transactions.comment AS comment, Persons.person_name AS person_name, Events.event_name AS event_name FROM Transactions, Events, Persons WHERE ((Transactions.person_id = Persons.person_id) AND (Transactions.event_id = Events.event_id)) ORDER BY Events.event_name, Persons.person_name";
											$totalRes = mysql_query($totalQuery);
											
											while($totalRow	= mysql_fetch_array($totalRes))
											{
												$pid = $totalRow["transaction_id"];
												echo "<tr id = \"contentTableRow".$pid."\" class = \"contentTableRow\"><td id = \"contentTableEvent".$pid."\" class = \"contentTableEvent\">";
												echo $totalRow["event_name"];
												echo "</td><td id = \"contentTableName".$pid."\" class = \"contentTableName\">";
												echo $totalRow["person_name"];
												echo "</td><td id = \"contentTableAmount".$pid."\" class = \"contentTableAmount\">";
												echo number_format($totalRow["amount"], 0, '.', " ");
												echo "</td><td id = \"contentTableComment".$pid."\" class = \"contentTableComment\">";
												echo $totalRow["comment"];
												echo "</td></tr>";
											}								
										?>
									</tbody>
								</table>
							</td>
							<td id = "manageBox">
								<form name = "deleteLine" id = "deleteLine" method = "POST" action = "transactions.php">
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
					<form name = "updateTable" method = "POST" action = "transactions.php">
						<?php
							$allPersonsQuery = "SELECT * FROM Persons";
							$allPersonsRes = mysql_query($allPersonsQuery);
							$allPersons = "";
							while($allPersonsRow = mysql_fetch_array($allPersonsRes))
							{
								$allPersons .= $allPersonsRow["person_id"] . ":" . $allPersonsRow["person_name"] . ";";
							}
							
							$allEventsQuery = "SELECT * FROM Events";
							$allEventsRes = mysql_query($allEventsQuery);
							$allEvents = "";
							while($allEventsRow = mysql_fetch_array($allEventsRes))
							{
								$allEvents .= $allEventsRow["event_id"] . ":" . $allEventsRow["event_name"] . ";";
							}
							
							echo "<input type = \"hidden\" id = \"allPersons\" value = \"".$allPersons."\">";
							echo "<input type = \"hidden\" id = \"allEvents\" value = \"".$allEvents."\">";							
						?>
						<table id = "fillDataTable">
							<tr id = "fillDataNameRow">
								<td id = "tName">
								</td>
								<td id = "fillDataNameCell">
								</td>
							</tr>
							<tr id = "fillDataEventRow">
								<td id = "tEvent">
								</td>
								<td id = "fillDataEventCell">
								</td>
							</tr>
							<tr id = "fillDataAmountRow">
								<td id = "tAmount">
								</td>
								<td id = "fillDataAmountCell">
								</td>
							</tr>
							<tr id = "fillDataCommentRow">
								<td id = "tComment">
								</td>
								<td id = "fillDataCommentCell">
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