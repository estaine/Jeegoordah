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
				$updQuery = "UPDATE Directs SET amount = \"".$_POST["fillDataAmount"]."\", comment = \"".$_POST["fillDataComment"]."\" WHERE direct_id = \"".$_POST["saveHidId"]."\"";
				$updRes = mysql_query($updQuery);
				break;				
			case "delete":
				$delQuery = "DELETE FROM Directs WHERE direct_id =\"".$_POST["deleteHidId"]."\"";
				$delRes = mysql_query($delQuery);
				break;
			case "add":
				if($_POST["fillDataDebitor"] == $_POST["fillDataCreditor"])
					echo "<script type=\"text/javascript\">alert(\"Транзакция отклонена. Одно и то же лицо указано в качестве должника (получателя) и кредитора (давателя).\"); </script>";
				else
				{
					$insQuery = "INSERT INTO Directs (direct_id, debitor_id, creditor_id, amount, comment) VALUES (NULL, \"".$_POST["fillDataDebitor"]."\", \"".$_POST["fillDataCreditor"]."\", \"".$_POST["fillDataAmount"]."\", \"".$_POST["fillDataComment"]."\")";
					$insRes = mysql_query($insQuery);		
				}
				break;
		}
	}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Джигурда : Расчёты</title>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="scripts/directs.js"></script>
		<link rel="stylesheet" href="stylesheets/fonts.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="stylesheets/style.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="stylesheets/directs.css" type="text/css" charset="utf-8">		
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
										<th id = "contentTableHeaderCellDebitor">
											Должник / Получатель
										</th>
										<th id = "contentTableHeaderCellCreditor">
											Кредитор / Даватель
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

											$totalQuery = "SELECT Debits.direct_id AS direct_id, Debits.amount AS amount, Debits.comment AS comment, Debits.debitor_name AS debitor_name, Persons.person_name AS creditor_name FROM Persons, (SELECT Directs.direct_id AS direct_id, Directs.debitor_id AS debitor_id, Directs.creditor_id AS creditor_id, Directs.amount AS amount, Directs.comment AS comment, Persons.person_name AS debitor_name FROM Directs, Persons WHERE Persons.person_id = Directs.debitor_id) AS Debits WHERE Persons.person_id = Debits.creditor_id ORDER BY debitor_name, creditor_name";
											$totalRes = mysql_query($totalQuery);
											
											while($totalRow	= mysql_fetch_array($totalRes))
											{
												$pid = $totalRow["direct_id"];
												echo "<tr id = \"contentTableRow".$pid."\" class = \"contentTableRow\"><td id = \"contentTableDebitor".$pid."\" class = \"contentTableDebitor\">";
												echo $totalRow["debitor_name"];
												echo "</td><td id = \"contentTableCreditor".$pid."\" class = \"contentTableCreditor\">";
												echo $totalRow["creditor_name"];
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
								<form name = "deleteLine" id = "deleteLine" method = "POST" action = "directs.php">
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
					<form name = "updateTable" method = "POST" action = "directs.php">
						<?php
							$allPersonsQuery = "SELECT * FROM Persons";
							$allPersonsRes = mysql_query($allPersonsQuery);
							$allPersons = "";
							while($allPersonsRow = mysql_fetch_array($allPersonsRes))
							{
								$allPersons .= $allPersonsRow["person_id"] . ":" . $allPersonsRow["person_name"] . ";";
							}
														
							echo "<input type = \"hidden\" id = \"allPersons\" value = \"".$allPersons."\">";							
						?>
						<table id = "fillDataTable">
							<tr id = "fillDataDebitorRow">
								<td id = "tDebitor">
								</td>
								<td id = "fillDataDebitorCell">
								</td>
							</tr>
							<tr id = "fillDataCreditorRow">
								<td id = "tCreditor">
								</td>
								<td id = "fillDataCreditorCell">
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