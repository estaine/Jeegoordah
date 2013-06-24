function initAll()
{
	$("#manageTable").append("<tr class = \"manageTableRow\" id = \"manageTableRowPlaceholder\"><td class = \"editCellPlaceholder\" id = \"editCellPlaceholder\"></td><td class = \"deleteCellPlaceholder\" id = \"deleteCellPlaceholder\"></td></tr>");

	
	
	$(".contentTableRow").each(function() {
		var rnum = $(this).attr("id").replace(/\D/g, "");		
		$("#manageTable").append("<tr class = \"manageTableRow\" id = \"manageTableRow" + rnum + "\"><td class = \"editCell\" id = \"editCell" + rnum + "\"></td><td class = \"deleteCell\" id = \"deleteCell" + rnum + "\"></td></tr>");		
	});
	
	$("#addButton").on("click", function() {

		$("#fillDataTable").children().children().children().empty();

		$("#tEvent").append("Мероприятие");
		$("#fillDataEventCell").append("<select id = \"fillDataEvent\" name = \"fillDataEvent\" class = \"fillDataField\">");
		$("#fillDataEventCell").append("</select>");
		var allEvents = $("#allEvents").val().split(";");
		var strsEvents = "";
		var i;
		for(i = 0; i < allEvents.length - 1; i++)
		{
			var allEventsSeparated = allEvents[i].split(":");
			strsEvents += "<option value = \"" + allEventsSeparated[0] + "\">" + allEventsSeparated[1] + "</option>";
		}
		$("#fillDataEvent").append(strsEvents);
		
		
		
		$("#tName").append("Имя");
		$("#fillDataNameCell").append("<select id = \"fillDataName\" name = \"fillDataName\" class = \"fillDataField\">");
		$("#fillDataNameCell").append("</select>");
		var allPersons = $("#allPersons").val().split(";");
		var strsPersons = "";

		
		for(i = 0; i < allPersons.length - 1; i++)
		{
			var allPersonsSeparated = allPersons[i].split(":");
			strsPersons += "<option value = \"" + allPersonsSeparated[0] + "\">" + allPersonsSeparated[1] + "</option>";
		}
		$("#fillDataName").append(strsPersons);
		
		
		$("#tAmount").append("Сумма");
		$("#fillDataAmountCell").append("<input type = \"text\" id = \"fillDataAmount\" name = \"fillDataAmount\" class = \"fillDataField\">");
		$("#tComment").append("Пометка");
		$("#fillDataCommentCell").append("<input type = \"text\" id = \"fillDataComment\" name = \"fillDataComment\" class = \"fillDataField\">");
		$("#buttonCancelBox").append("<img class = \"cancelButton imgButton\" src = \"http://jeegoordah.ts9.ru/images/Cancel.png\"/>");
		$("#buttonSaveBox").append("<input type = \"image\" class = \"insertButton imgButton\" src = \"http://jeegoordah.ts9.ru/images/Save.png\"/>");
		$("#buttonSaveBox").append("<input type = \"hidden\" name = \"actionType\" value = \"add\">");
			$(".cancelButton").on("click", function() {
				$("#fillDataTable").children().children().children().empty();
			});			
	});	
	
	
	$(".contentTableRow").hover(function () {
		var rnum = $(this).attr("id").replace(/\D/g, "");
		$(".editCell").empty();
		$(".deleteCell").empty();
		$("#editCell" + rnum).append("<img class = \"editButton imgButton\" id = \"editButton" + rnum + "\" src = \"http://jeegoordah.ts9.ru/images/Edit.png\"/>");
		$("#deleteCell" + rnum).append("<img class = \"deleteButton imgButton\" id = \"deleteButton" + rnum + "\" src = \"http://jeegoordah.ts9.ru/images/Delete.png\"/>");
		$("#deleteCell" + rnum).append("<input type = \"hidden\" id = \"deleteHidId\" name = \"deleteHidId\" value = \"" + rnum + "\">");
		$("#deleteCell" + rnum).append("<input type = \"hidden\" name = \"actionType\" value = \"delete\">");
		
		$("#deleteButton" + rnum).on("click", function() {
			if(confirm("Точно удаляем?"))
				$("#deleteLine").submit();
		});
		
		
		$("#editButton" + rnum).on("click", function() {
			var rnum = $(this).attr("id").replace(/\D/g, "");
			
			$("#fillDataTable").children().children().children().empty();
			
			$("#tEvent").append("Мероприятие");
			$("#fillDataEventCell").text($("#contentTableEvent" + rnum).text());
			$("#tName").append("Имя");
			$("#fillDataNameCell").text($("#contentTableName" + rnum).text());
			$("#tAmount").append("Сумма");
			$("#fillDataAmountCell").append("<input type = \"text\" id = \"fillDataAmount\" name = \"fillDataAmount\" class = \"fillDataField\" value = \"" + $("#contentTableAmount" + rnum).text() + "\">");
			$("#tComment").append("Пометка");
			$("#fillDataCommentCell").append("<input type = \"text\" id = \"fillDataComment\" name = \"fillDataComment\" class = \"fillDataField\" value = \"" + $("#contentTableComment" + rnum).text() + "\">");
			$("#buttonCancelBox").append("<img class = \"cancelButton imgButton\" src = \"http://jeegoordah.ts9.ru/images/Cancel.png\"/>");
			$("#buttonSaveBox").append("<input type = \"image\" class = \"saveButton imgButton\" id = \"saveButton" + rnum + "\" name = \"saveButton" + rnum + "\" src = \"http://jeegoordah.ts9.ru/images/Save.png\"/>");
			$("#buttonSaveBox").append("<input type = \"hidden\" id = \"saveHidId\" name = \"saveHidId\" value = \"" + rnum + "\">");
			$("#buttonSaveBox").append("<input type = \"hidden\" name = \"actionType\" value = \"edit\">");
			$(".cancelButton").on("click", function() {
				$("#fillDataTable").children().children().children().empty();
			});			
		});
		

		
		
	});

	
	
}

$(document).ready(initAll);