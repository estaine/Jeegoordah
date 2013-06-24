<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Джигурда : Итого</title>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<link rel="stylesheet" href="stylesheets/fonts.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="stylesheets/style.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="stylesheets/index.css" type="text/css" charset="utf-8">
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
				<td id = "contentBox" colspan = "5">
					<table id = "contentTable">
						<thead id = "contentTableHeader">
							<th id = "contentTableHeaderCellName">
								Имя
							</th>
							<th id = "contentTableHeaderCellBalance">
								Баланс
							</th>
						</thead>
						<tbody>
							<?php
								$hostname = "sql-4.radyx.ru"; 
								$username = "jeegoordah617";
								$password = "sdy28infvj";
								$dbname = "jeegoordah617";			

								$dbhandle = mysql_connect($hostname, $username, $password, $dbname);

								mysql_select_db($dbname, $dbhandle);
															
								$totalQuery = "
								SELECT
									Persons.person_id,
									Persons.person_name,
									ROUND((IFNULL(PersRawResult.balance, 0) + IFNULL(PersRawDirects.balance, 0)), -2) AS total
								FROM
									Persons,
									(SELECT
										Persons.person_id,
										RawResult.balance
									FROM
										Persons
										LEFT JOIN
										(SELECT
											ResultEvents.person_id AS person_id,
											SUM(ResultEvents.balance) AS balance
										FROM											
											(SELECT
												ExpPart.event_id,
												ExpPart.person_id AS person_id,
												(IFNULL(TransSum.sumpers, 0) - ExpPart.expected) AS balance
											FROM
												(SELECT
													EventsPersons.event_id,
													EventsPersons.person_id,
													TotalPart.expected,
													TotalPart.participants
												FROM
													EventsPersons
													LEFT JOIN
													(SELECT
														Transactions.event_id,
														(SUM(Transactions.amount) / Part.participants) AS expected,
														Part.participants
													FROM
														Transactions
														LEFT JOIN
														(SELECT
															event_id,
															COUNT(*) AS participants
														FROM
															EventsPersons
														GROUP BY
															event_id)
														AS Part
														ON
															Transactions.event_id = Part.event_id
														GROUP BY
															Transactions.event_id)
													AS TotalPart
												ON
													EventsPersons.event_id = TotalPart.event_id)
												AS
													ExpPart
													LEFT JOIN
													(SELECT
														event_id,
														person_id,
														SUM(amount) AS sumpers
													FROM
														Transactions
													GROUP BY
														event_id,
														person_id)
													AS TransSum
													ON
														((ExpPart.event_id = TransSum.event_id) AND
														(ExpPart.person_id = TransSum.person_id)))
												AS ResultEvents
											GROUP BY
												ResultEvents.person_id)
										AS RawResult
										ON
											Persons.person_id = RawResult.person_id)
									AS PersRawResult,
									(SELECT
										Persons.person_id,
										RawDirects.balance
									FROM
										Persons
										LEFT JOIN
										(SELECT
											PersDeb.person_id AS person_id,
											(IFNULL(Credits.totalplus, 0) - IFNULL(PersDeb.totalminus, 0)) AS balance
										FROM
											(SELECT
												Persons.person_id,
												Debits.totalminus AS totalminus
											FROM
												Persons
												LEFT JOIN
												(SELECT
													debitor_id,
													SUM(amount) AS totalminus
												FROM
													Directs
												GROUP BY
													debitor_id)
												AS Debits
												ON
													Persons.person_id = Debits.debitor_id)
											AS
												PersDeb
												LEFT JOIN
												(SELECT
													creditor_id,
													SUM(amount) AS totalplus
												FROM
													Directs
												GROUP BY
													creditor_id)
												AS Credits
												ON
													PersDeb.person_id = Credits.creditor_id)
										AS RawDirects
										ON
											Persons.person_id = RawDirects.person_id)
									AS PersRawDirects
								WHERE
									((Persons.person_id = PersRawResult.person_id) AND
									(Persons.person_id = PersRawDirects.person_id))
								ORDER BY
									Persons.person_name
								";
								$totalRes = mysql_query($totalQuery);
								
								while($totalRow	= mysql_fetch_array($totalRes))
								{
									$pid = $totalRow["person_id"];
									echo "<tr id = \"contentTableRow".$pid."\" class = \"contentTableRow\"><td id = \"contentTableName".$pid."\" class = \"contentTableName\">";
									echo $totalRow["person_name"];
									echo "</td><td id = \"contentTableBalance".$pid."\" class = \"contentTableBalance";
									if($totalRow["total"] > 0)
										echo " positiveAmount\">+";
									else
										echo " negativeAmount\">";
									echo number_format($totalRow["total"], 0, '.', " ");
									echo "</td></tr>";
								}
								
							?>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>