$('#activitynumber').load('../backend/APIs.php?option=LoadActivityNumber');
$('#studentsnumber').load('../backend/APIs.php?option=LoadStudentsNumber');
$('#coursesnumber').load('../backend/APIs.php?option=LoadCoursesNumber');
$('#username').load('../backend/APIs.php?option=postName');
var name = $.get('../backend/APIs.php?option=Name',
    function getMessage(name) {
        var message = 'Dear ' + name + ', please choose datasets below:';
        document.getElementById("notice").innerHTML = message;
    });
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
    $("#SelectSemester").change(function () {
        $("#SelectAssignment option").remove();
        $("#SelectAssignment").append("<option id='PleaseSelectSemester'>Select Assignment</option>");
        var SelectCourseId = $("#SelectCourse option:selected").attr("id");
        var SelectYearId = $("#SelectYear option:selected").attr("id");
        var SelectSemesterId = $("#SelectSemester option:selected").attr("id");
        $.ajax({
            type: "get",
            async: true,
            url: "../backend/APIs.php?option=LoadAssignment",
            dataType: "json",
            data: { "SelectCourseId": SelectCourseId, "SelectYearId": SelectYearId, "SelectSemesterId": SelectSemesterId },
            success: function (result) {
                var AssignmentName = [];
                $.each(result, function (i, j) {
                    AssignmentName[i] = j['AssignmentName'];
                    $("#SelectAssignment").append(" <option id='" + AssignmentName[i] + "'>" + AssignmentName[i] + "</option>");
                });
            }
        });
    });

    $(document).ready(function(){
        $.ajax({
            type: "get",
            async: true,
            url: "../backend/APIs.php?option=SelectYear",
            dataType: "json",
            success: function (result) {
                var SchoolYear = [];
                $.each(result, function (i, j) {
                    SchoolYear[i] = j['SchoolYear'];
                    $("#PleaseChooseYear").append(" <a id='" + SchoolYear[i] + "'>" + SchoolYear[i] + "</a>");
                })
            }
        })//Ajax 

    })
    $("#PleaseChooseYear").change(function () {
        console.log("ChooseYear");
                   
    })
    function loadData() {
        var SelectCourseId = $("#SelectCourse option:selected").attr("id");
        var SelectYearId = $("#SelectYear option:selected").attr("id");
        var SelectSemesterId = $("#SelectSemester option:selected").attr("id");
        var SelectAssignmentId = $("#SelectAssignment option:selected").attr("id");
        console.log(SelectCourse);
        $.ajax({
            type: "get",
            async: true,
            url: "../backend/APIs.php?option=allActivities",
            dataType: "json",
            data: { "SelectCourseId": SelectCourseId, "SelectYearId": SelectYearId, "SelectSemesterId": SelectSemesterId, "SelectAssignmentId": SelectAssignmentId },
            success: function (result) {
                // console.log("Sucess");
                loadTable(result);
            }
        });
    }
})


var config = {
    type: 'line',
    data: {
        labels: ["2012", "2013", "2014","2015", "2016", "2017"],
        datasets: [{
            label: "Moodle Charts",
            fill: false,
            backgroundColor: window.chartColors.blue,
            borderColor: window.chartColors.blue,
            data: [
                27884,
                317,
                3,
                25000,
                20000,
                28000,
            ],
        }, ]
    },
    options: {
        responsive: true,
        title:{
            display:true,
            // text:''
        },
        tooltips: {
            mode: 'index',
            intersect: false,
        },
        hover: {
            mode: 'nearest',
            intersect: true
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Year'
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Activities'
                }
            }]
        }
    }
};

window.onload = function() {
    var ctx = document.getElementById("AllactivityChartsByYearChartJS").getContext("2d");
    window.myLine = new Chart(ctx, config);
};