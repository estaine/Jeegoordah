function initAll()
{
	$("#manageTable").append("<tr class = \"manageTableRow\" id = \"manageTableRowPlaceholder\"><td class = \"editCellPlaceholder\" id = \"editCellPlaceholder\"></td><td class = \"deleteCellPlaceholder\" id = \"deleteCellPlaceholder\"></td><td class = \"addUserCellPlaceholder\" id = \"addUserCellPlaceholder\"></td></tr>");

	
	
	$(".contentTableRow").each(function() {
		var rnum = $(this).attr("id").replace(/\D/g, "");		
		$("#manageTable").append("<tr class = \"manageTableRow\" id = \"manageTableRow" + rnum + "\"><td class = \"editCell\" id = \"editCell" + rnum + "\"></td><td class = \"deleteCell\" id = \"deleteCell" + rnum + "\"></td><td class = \"addUserCell\" id = \"addUserCell" + rnum + "\"></td></tr>");		
	});
	
	$("#addButton").on("click", function() {

		$("#tName").empty();
		$("#fillDataNameCell").empty();
		$("#buttonCancelBox").empty();
		$("#buttonSaveBox").empty();
		$("#fillDataUserRow").remove();
		$(".editUserRow").remove();

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
		$(".addUserCell").empty();
		$("#editCell" + rnum).append("<img class = \"editButton imgButton\" id = \"editButton" + rnum + "\" src = \"http://jeegoordah.ts9.ru/images/Edit.png\"/>");
		$("#deleteCell" + rnum).append("<img class = \"deleteButton imgButton\" id = \"deleteButton" + rnum + "\" src = \"http://jeegoordah.ts9.ru/images/Delete.png\"/>");
		$("#deleteCell" + rnum).append("<input type = \"hidden\" id = \"deleteHidId\" name = \"deleteHidId\" value = \"" + rnum + "\">");
		$("#deleteCell" + rnum).append("<input type = \"hidden\" name = \"actionType\" value = \"delete\">");
		$("#addUserCell" + rnum).append("<img class = \"addUserButton imgButton\" id = \"addUserButton" + rnum + "\" src = \"http://jeegoordah.ts9.ru/images/AddUser.png\"/>");
		
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
			$("#fillDataUserRow").remove();
			$(".editUserRow").remove();
			
			var persIdNameArray = $("#persArray" + rnum).val().split(";");
			var strsParticipants = "";
			var deleteIconSwitch = new Array();
						
			for(var i = 0; i < persIdNameArray.length - 1; i++)
			{
				var persIdNameSeparated = persIdNameArray[i].split(":");
				strsParticipants += "<tr id = \"editUserRow" + persIdNameSeparated[0] + "\" class = \"editUserRow\">";
				strsParticipants += "<td></td><td id = \"editUserBox" + persIdNameSeparated[0] + "\" class = \"editUserBox\">" + persIdNameSeparated[1] + "</td>";
				strsParticipants += "<td id = \"deleteUserCell" + persIdNameSeparated[0] + "\" class = \"deleteUserCell\">";
				strsParticipants += "<img class = \"deleteUserButton imgButton\" id = \"deleteUserButton" + persIdNameSeparated[0] + "\" src = \"http://jeegoordah.ts9.ru/images/DeleteUserB.png\"/>";
				strsParticipants += "<input type = \"hidden\" value = \"0\" class = \"userDeleted\" name = \"userDeleted" + persIdNameSeparated[0] + "\" id = \"userDeleted" + persIdNameSeparated[0] + "\">";
				strsParticipants += "</td></tr>";
				deleteIconSwitch[persIdNameSeparated[0]] = false;
			}

			$("#tName").append("Название");			
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
				$("#fillDataUserRow").remove();
				$(".editUserRow").remove();
			});
			$("#fillDataNameRow").after(strsParticipants);
			

			
			
			$(".deleteUserButton").on("click", function() {
				var rnum = $(this).attr("id").replace(/\D/g, "");
				if(deleteIconSwitch[rnum])
				{
					$(this).attr("src", "http://jeegoordah.ts9.ru/images/DeleteUserB.png");
					$(this).next().attr("value", "0");
				}
				else
				{
					$(this).attr("src", "http://jeegoordah.ts9.ru/images/DeleteUserD.png");
					$(this).next().attr("value", "1");
				}
				deleteIconSwitch[rnum] = !deleteIconSwitch[rnum];				
			});
			
		});
		
		$("#addUserButton" + rnum).on("click", function() {
			var rnum = $(this).attr("id").replace(/\D/g, "");
			
			$("#tName").empty();
			$("#fillDataNameCell").empty();
			$("#buttonCancelBox").empty();
			$("#buttonSaveBox").empty();
			$("#fillDataUserRow").remove();
			$(".editUserRow").remove();
			
			$("#tName").append("Название");			
			$("#fillDataNameCell").append($("#contentTableName" + rnum).text());
			$("#fillDataNameRow").after("<tr id = \"fillDataUserRow\"><td id = \"tUser\">Участник</td><td id = \"fillDataUserCell\"></td></tr>");
			$("#fillDataUserCell").append("<select id = \"fillDataUser\" name = \"fillDataUser\" class = \"fillDataField\">");
			$("#fillDataUserCell").append("</select>");
			
			var persNotIdNameArray = $("#persNotArray" + rnum).val().split(";");
			var strsNotParticipants = "";
			
			for(var i = 0; i < persNotIdNameArray.length - 1; i++)
			{
				var persNotIdNameSeparated = persNotIdNameArray[i].split(":");
				strsNotParticipants += "<option value = \"" + persNotIdNameSeparated[0] + "\">" + persNotIdNameSeparated[1] + "</option>";
			}
			
			$("#fillDataUser").append(strsNotParticipants);
			
			$("#buttonCancelBox").append("<img class = \"cancelButton imgButton\" src = \"http://jeegoordah.ts9.ru/images/Cancel.png\"/>");
			$("#buttonSaveBox").append("<input type = \"image\" class = \"addUserButton imgButton\" id = \"addUserButton" + rnum + "\" name = \"addUserButton" + rnum + "\" src = \"http://jeegoordah.ts9.ru/images/Save.png\"/>");
			$("#buttonSaveBox").append("<input type = \"hidden\" id = \"addUserEventHidId\" name = \"addUserEventHidId\" value = \"" + rnum + "\">");
			$("#buttonSaveBox").append("<input type = \"hidden\" name = \"actionType\" value = \"addUser\">");
			$(".cancelButton").on("click", function() {
				$("#tName").empty();
				$("#fillDataNameCell").empty();
				$("#buttonCancelBox").empty();
				$("#buttonSaveBox").empty();
				$("#fillDataUserRow").remove();
				$(".editUserRow").remove();
			});			
		});

		
		
	});

	
	
}

$(document).ready(initAll);