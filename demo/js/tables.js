$('#activitynumber').load('../backend/APIs.php?option=LoadActivityNumber');
$('#studentsnumber').load('../backend/APIs.php?option=LoadStudentsNumber');
$('#coursesnumber').load('../backend/APIs.php?option=LoadCoursesNumber');
//Ajax Loading Assignment
$(document).ready(function () {
    $.ajax({
        type: "get",
        async: true,
        url: "../backend/APIs.php?option=LoadCourse",
        dataType: "json",
        success: function (result) {
            var CourseName = [];
            $.each(result, function (i, j) {
                CourseName[i] = j['CourseName'];
                $("#SelectCourse").append(
                    " <option id='" + CourseName[i] + "'>" + CourseName[i] + "</option>"
                );
            });
        }
    });
    $("#SelectCourse").change(function () {
        $("#SelectYear option").remove();
        $("#SelectSemester option").remove();
        $("#SelectAssignment option").remove();
        $("#SelectYear").append(
            " <option id='PleaseSelectYear'>Select Year</option>");
        $("#SelectSemester").append(
            " <option id='PleaseSelectSemester'>Select Semester</option>");
        $("#SelectAssignment").append(
            " <option id='PleaseSelectAssignment'>Select Assignment</option>");
        var SelectCourseId = $("#SelectCourse option:selected").attr("id");
        $.ajax({
            type: "get",
            async: true,
            url: "../backend/APIs.php?option=LoadYear",
            dataType: "json",
            data: { "SelectCourseId": SelectCourseId },
            success: function (result) {
                var SchoolYear = [];
                $.each(result, function (i, j) {
                    SchoolYear[i] = j['SchoolYear'];
                    $("#SelectYear").append(
                        " <option id='" + SchoolYear[i] + "'>" + SchoolYear[i] + "</option>"
                    );
                });
            }
        });
    });
    $("#SelectYear").change(function () {
        $("#SelectSemester option").remove();
        $("#SelectAssignment option").remove();
        $("#SelectSemester").append(
            " <option id='PleaseSelectSemester'>Select Semester</option>");
        $("#SelectAssignment").append(
            " <option id='PleaseSelectSemester'>Select Assignment</option>");
        var SelectCourseId = $("#SelectCourse option:selected").attr("id");
        var SelectYearId = $("#SelectYear option:selected").attr("id");
        $.ajax({
            type: "get",
            async: true,
            url: "../backend/APIs.php?option=LoadSemester",
            dataType: "json",
            data: { "SelectCourseId": SelectCourseId, "SelectYearId": SelectYearId },
            success: function (result) {
                var Semester = [];
                $.each(result, function (i, j) {
                    Semester[i] = j['Semester'];
                    $("#SelectSemester").append(" <option id='" + Semester[i] + "'>"
                        + Semester[i] + "</option>");
                });
            }
        });
    });
    $("#SelectSemester").change(function() {
        $("#SelectAssignment option").remove();
        $("#SelectAssignment").append("<option id='PleaseSelectSemester'>Select Assignment</option>");
        var SelectCourseId=$("#SelectCourse option:selected").attr("id");
		var SelectYearId=$("#SelectYear option:selected").attr("id");
        var SelectSemesterId=$("#SelectSemester option:selected").attr("id");
        $.ajax({
			type: "get",
			async: true, 
			url: "../backend/APIs.php?option=LoadAssignment",
			dataType: "json", 
			data: {"SelectCourseId":SelectCourseId,"SelectYearId":SelectYearId,"SelectSemesterId":SelectSemesterId},
			success: function(result) {
				var AssignmentName = [];
				$.each(result,function(i,j){
					AssignmentName[i]=j['AssignmentName'];
					$("#SelectAssignment").append(" <option id='" + AssignmentName[i] + "'>"+ AssignmentName[i] + "</option>");
				});
			}
		});
    });
})

$(document).ready(function(){
    $("#table_search").click(function(){
            loadData();  
    })
})
function loadData()
{
    var SelectCourseId=$("#SelectCourse option:selected").attr("id");
    var SelectYearId=$("#SelectYear option:selected").attr("id");
    var SelectSemesterId=$("#SelectSemester option:selected").attr("id");
    var SelectAssignmentId=$("#SelectAssignment option:selected").attr("id");
    // console.log(SelectCourse);
    $.ajax({
        type: "get",
        async: true,
        url: "../backend/APIs.php?option=SearchTable",
        dataType: "json",
        data: {"SelectCourseId":SelectCourseId,"SelectYearId":SelectYearId,"SelectSemesterId":SelectSemesterId,"SelectAssignmentId":SelectAssignmentId},
        success: function(result)
        {
            // console.log("Sucess");
            loadTable(result);
        }
    });
}

function loadTable(data)
{
    $('#TableResult').DataTable({
        destroy: true,
        data: data,
        columns: [
            { title: "Stu_Name", data: "FKUserId" },
            { title: "Course", data: "CourseName" },
            { title: "Year", data: "SchoolYear" },
            { title: "Semster", data: "Semester"},
            { title: "Assignmnet", data: "AssignmentName" },
            { title: "Event Name", data: "Event Name" },
            { title: "Grade", data: "Grade" },
            { title: "Component", data: "Component" },
        ],
        // dom: 'Bfrtip',
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ]
    });
}
