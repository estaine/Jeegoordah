function initAll()
{
	$("#manageTable").append("<tr class = \"manageTableRow\" id = \"manageTableRowPlaceholder\"><td class = \"editCellPlaceholder\" id = \"editCellPlaceholder\"></td><td class = \"deleteCellPlaceholder\" id = \"deleteCellPlaceholder\"></td></tr>");

	
	
	$(".contentTableRow").each(function() {
		var rnum = $(this).attr("id").replace(/\D/g, "");		
		$("#manageTable").append("<tr class = \"manageTableRow\" id = \"manageTableRow" + rnum + "\"><td class = \"editCell\" id = \"editCell" + rnum + "\"></td><td class = \"deleteCell\" id = \"deleteCell" + rnum + "\"></td></tr>");		
	});
	
	$("#addButton").on("click", function() {

		$("#tName").empty();
		$("#fillDataNameCell").empty();
		$("#buttonCancelBox").empty();
		$("#buttonSaveBox").empty();

		$("#tName").append("Имя");
		$("#fillDataNameCell").append("<input type = \"text\" id = \"fillDataName\" name = \"fillDataName\" class = \"fillDataField\">");
		$("#buttonCancelBox").append("<img class = \"cancelButton imgButton\" src = \"http://jeegoordah.ts9.ru/images/Cancel.png\"/>");
		$("#buttonSaveBox").append("<input type = \"image\" class = \"insertButton imgButton\" src = \"http://jeegoordah.ts9.ru/images/Save.png\"/>");
		$("#buttonSaveBox").append("<input type = \"hidden\" name = \"actionType\" value = \"add\">");
			$(".cancelButton").on("click", function() {
				$("#tName").empty();
				$("#fillDataNameCell").empty();
				$("#buttonCancelBox").empty();
				$("#buttonSaveBox").empty();
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
			
			$("#tName").empty();
			$("#fillDataNameCell").empty();
			$("#buttonCancelBox").empty();
			$("#buttonSaveBox").empty();
			
			$("#tName").append("Имя");			
			$("#fillDataNameCell").append("<input type = \"text\" id = \"fillDataName\" name = \"fillDataName\" class = \"fillDataField\" value = \"" + $("#contentTableName" + rnum).text() + "\">");
			$("#buttonCancelBox").append("<img class = \"cancelButton imgButton\" src = \"http://jeegoordah.ts9.ru/images/Cancel.png\"/>");
			$("#buttonSaveBox").append("<input type = \"image\" class = \"saveButton imgButton\" id = \"saveButton" + rnum + "\" name = \"saveButton" + rnum + "\" src = \"http://jeegoordah.ts9.ru/images/Save.png\"/>");
			$("#buttonSaveBox").append("<input type = \"hidden\" id = \"saveHidId\" name = \"saveHidId\" value = \"" + rnum + "\">");
			$("#buttonSaveBox").append("<input type = \"hidden\" name = \"actionType\" value = \"edit\">");
			$(".cancelButton").on("click", function() {
				$("#tName").empty();
				$("#fillDataNameCell").empty();
				$("#buttonCancelBox").empty();
				$("#buttonSaveBox").empty();
			});			
		});
		

		
		
	});

	
	
}

$(document).ready(initAll);