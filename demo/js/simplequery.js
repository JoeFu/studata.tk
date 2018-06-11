var dataSet;
var dataSourceTypeId = "1";
var selectedComponentId;
var selectedEventName;
var selectedEventType;
var selectedFromStartDate;
var selectedToStartDate;
var selectedFromDueDate;
var selectedToDueDate;
var selectedUser;
var selectedFromGrade;
var selectedToGrade;
var selectedAssignment;
var selectedCourse;
var selectedSchoolYear;
var selectedSemester;

$(document).ready(function () {
    $("#parentResultDataTable").hide();
    showOrHideDatePickers(dataSourceTypeId);
    addDataSourceTypes();
    addLowerGrades(0);
    addHigherGrades(0);
    initializeData(dataSourceTypeId);

    $("#buttonSearch").click(function () {
        $("#parentResultDataTable").show();

        var selectedComponentId = $("#ComponentSelect option:selected").val();
        var selectedEventName = $("#EventNameSelect option:selected").text();
        var selectedEventType = $("#EventTypeSelect option:selected").val();
        var selectedFromStartDate = $("#FromStartDatePicker").val();
        var selectedToStartDate = $("#ToStartDatePicker").val();
        var selectedFromDueDate = $("#FromDueDatePicker").val();
        var selectedToDueDate = $("#ToDueDatePicker").val();
        var selectedUser = $("#UserSelect option:selected").text();
        var selectedFromGrade = $("#FromGradeSelect option:selected").text();
        var selectedToGrade = $("#ToGradeSelect option:selected").text();
        var selectedAssignment = $("#AssignmentSelect option:selected").text();
        var selectedCourse = $("#CourseSelect option:selected").text();
        var selectedSchoolYear = $("#SchoolYearSelect option:selected").text();
        var selectedSemester = $("#SemesterSelect option:selected").text();
        var parameters = selectedComponentId + "|" + selectedEventName + "|" + selectedEventType + "|" + selectedFromStartDate + "|" + selectedToStartDate + "|" + selectedFromDueDate + "|" + selectedToDueDate + "|" + selectedUser + "|" + selectedFromGrade + "|" + selectedToGrade + "|" + selectedAssignment + "|" + selectedCourse + "|" + selectedSchoolYear + "|" + selectedSemester + "|" + dataSourceTypeId;

        $.ajax({
            type: "get",
            dataType: "json",
            url: "http://studata.tk/slimapp/public/index.php/api/events/search",
            data: { "parameters": parameters },
            success: function (result) {
                loadResult(result);
            }
        });
    });

    // On change of data source
    $("#DataSourceSelect").change(function () {
        dataSourceTypeId = this.value;
        showOrHideDatePickers(dataSourceTypeId);
        initializeData(dataSourceTypeId);
    })

    $("#FromGradeSelect").change(function () {
        var currentGrade = this.value;
        addHigherGrades(currentGrade);
    });

    $("#ToGradeSelect").change(function () {
        var currentGrade = this.value;
        addLowerGrades(currentGrade);
    });
});

function initializeData(dataSourceType) {
    getEventNames(dataSourceType);
    getEventTypes();
    getComponents();
    getUsers();
    getCourses();
    getSchoolYears();
    getSemesters();
    getAssignments();
    initDatePickers();
}

function showOrHideDatePickers(dataSourceType) {
    switch (dataSourceType) {
        case "1": // Moodle Forum
            $("#tableDatePicker").hide();
            break;
        case "2": // WebSubmission
            $("#tableDatePicker").show();
            break;
        default:
            break;
    }

}

function getEventNames(dataSourceType) {
    $.ajax({
        type: "get",
        dataType: "json",
        url: "http://studata.tk/slimapp/public/index.php/api/eventnames/" + dataSourceType,
        success: function (data) {
            $("#EventNameSelect option").remove();
            var $select = $('#EventNameSelect');
            $select.append(
                "<option id='SelectEventName'></option>");
            $.each(data, function (index, o) {
                var $option = $("<option/>").attr("value", index).text(o.Name);
                $select.append($option);
            });
        }
    });
}

function getEventTypes() {
    $.ajax({
        type: "get",
        dataType: "json",
        url: "http://studata.tk/slimapp/public/index.php/api/eventtypes",
        success: function (data) {
            $("#EventTypeSelect option").remove();
            var $select = $('#EventTypeSelect');
            $("#EventTypeSelect").append(
                "<option id='SelectEventType'></option>");
            $.each(data, function (index, o) {
                var $option = $("<option/>").attr("value", o.Id).text(o.Name);
                $select.append($option);
            });
        }
    });
}

function getComponents() {
    $.ajax({
        type: "get",
        dataType: "json",
        url: "http://studata.tk/slimapp/public/index.php/api/components",
        success: function (data) {
            $("#ComponentSelect option").remove();
            var $select = $('#ComponentSelect');
            $("#ComponentSelect").append(
                "<option id='SelectComponent'></option>");
            $.each(data, function (index, o) {
                var $option = $("<option/>").attr("value", o.Id).text(o.Name);
                $select.append($option);
            });
        }
    });
}

function getUsers() {
    $.ajax({
        type: "get",
        dataType: "json",
        url: "http://studata.tk/slimapp/public/index.php/api/users",
        success: function (data) {
            $("#UserSelect option").remove();
            var $select = $('#UserSelect');
            $("#UserSelect").append(
                "<option id='SelectUser'></option>");
            $.each(data, function (index, o) {
                var $option = $("<option/>").attr("value", index).text(o.Id);
                $select.append($option);
            });
        }
    });
}

function getCourses() {
    $.ajax({
        type: "get",
        dataType: "json",
        url: "http://studata.tk/slimapp/public/index.php/api/courses",
        success: function (data) {
            $("#CourseSelect option").remove();
            var $select = $('#CourseSelect');
            $("#CourseSelect").append(
                "<option id='SelectCourse'></option>");
            $.each(data, function (index, o) {
                var $option = $("<option/>").attr("value", index).text(o.CourseName);
                $select.append($option);
            });
        }
    });
}

function getSchoolYears() {
    $.ajax({
        type: "get",
        dataType: "json",
        url: "http://studata.tk/slimapp/public/index.php/api/schoolyears",
        success: function (data) {
            $("#SchoolYearSelect option").remove();
            var $select = $('#SchoolYearSelect');
            $("#SchoolYearSelect").append(
                "<option id='SelectSchoolYear'></option>");
            $.each(data, function (index, o) {
                var $option = $("<option/>").attr("value", index).text(o.SchoolYear);
                $select.append($option);
            });
        }
    });
}

function getSemesters() {
    $.ajax({
        type: "get",
        dataType: "json",
        url: "http://studata.tk/slimapp/public/index.php/api/semesters",
        success: function (data) {
            $("#SemesterSelect option").remove();
            var $select = $('#SemesterSelect');
            $select.append(
                "<option id='SelectSemester'></option>");
            $.each(data, function (index, o) {
                var $option = $("<option/>").attr("value", index).text(o.Semester);
                $select.append($option);
            });
        }
    });
}

function getAssignments() {
    $.ajax({
        type: "get",
        dataType: "json",
        url: "http://studata.tk/slimapp/public/index.php/api/assignments",
        success: function (data) {
            $("#AssignmentSelect option").remove();
            var $select = $('#AssignmentSelect');
            $select.append(
                "<option id='SelectAssignment'></option>");
            $.each(data, function (index, o) {
                var $option = $("<option/>").attr("value", index).text(o.AssignmentName);
                $select.append($option);
            });
        }
    });

}

function addHigherGrades(currentGrade) {
    var selected = $('#ToGradeSelect').val();
    $('#ToGradeSelect option').remove();

    $("#ToGradeSelect").append(
        "<option id='ToGradeSelect'></option>");
    var grades = [50, 64, 74, 89];
    // if the value is zero, add the whole array
    if (currentGrade == 0) {
        for (var i = 0; i < grades.length; i++) {
            $("#ToGradeSelect").append(
                "<option id='ToGradeSelect'>" + grades[i] + "</option>");
        }
        return;
    }

    // Find the position of currentGrade
    var pos = -1;
    for (var i = 0; i < grades.length; i++) {
        if (grades[i] == currentGrade) {
            pos = i;
            break;
        }
    }

    // Bind values for ToGradeSelect
    for (var i = pos; i < grades.length; i++) {
        $("#ToGradeSelect").append(
            "<option id='ToGradeSelect'>" + grades[i] + "</option>");
    }

    var options = $("#ToGradeSelect option");
    sortGradeSelect(options, "#ToGradeSelect");
    $("#ToGradeSelect").val(selected);
}

function sortGradeSelect(options, gradeSelectId) {
    $(gradeSelectId).html($(gradeSelectId + ' option').sort(function (x, y) {
        return $(x).text() < $(y).text() ? -1 : 1;
    }));
    //$(gradeSelectId).get(0).selectedIndex = 0;
}

function addLowerGrades(currentGrade) {
    var selected = $("#FromGradeSelect").val();
    $('#FromGradeSelect option').remove();
    $("#FromGradeSelect").append(
        "<option id='FromGradeSelect'></option>");

    var grades = [50, 64, 74, 89];
    // if the value is zero, add the whole array
    if (currentGrade == 0) {
        for (var i = 0; i < grades.length; i++) {
            $("#FromGradeSelect").append(
                "<option id='FromGradeSelect'>" + grades[i] + "</option>");
        }
        return;
    }

    // Find the position of currentGrade
    var pos = -1;
    for (var i = 0; i < grades.length; i++) {
        if (grades[i] == currentGrade) {
            pos = i;
            break;
        }
    }

    // Bind values for ToGradeSelect
    for (var i = pos; i >= 0; i--) {
        $("#FromGradeSelect").append(
            "<option id='FromGradeSelect'>" + grades[i] + "</option>");
    }

    var options = $("#FromGradeSelect option");
    sortGradeSelect(options, "#FromGradeSelect");
    $("#FromGradeSelect").val(selected);
}

function addDataSourceTypes() {
    var $select = $('#DataSourceSelect');
    var $option = $("<option/>").attr("value", 1).text("Moodle Forum");
    $select.append($option);
    $option = $("<option/>").attr("value", 2).text("WebSubmission");
    $select.append($option);
}

function initDatePickers() {
    $("#FromStartDatePicker").datepicker({ dateFormat: "yy/mm/dd" });
    $("#ToStartDatePicker").datepicker({ dateFormat: "yy/mm/dd" });
    $("#FromDueDatePicker").datepicker({ dateFormat: "yy/mm/dd" });
    $("#ToDueDatePicker").datepicker({ dateFormat: "yy/mm/dd" });
}

function loadResult(data) {
    var dataTable = $('#ResultDataTable').DataTable({
        destroy: true,
        data: data,
        columns: [
            { title: "Assignment", data: "AssignmentName" },
            { title: "Course", data: "CourseName" },
            { title: "Description", data: "Description" },
            { title: "Due date", data: "DueDate", visible: false },
            { title: "User", data: "FKUserId" },
            { title: "Grade", data: "Grade" },
            { title: "Name", data: "Name" },
            { title: "School Year", data: "SchoolYear" },
            { title: "Semester", data: "Semester" },
            { title: "Start date", data: "StartDate", visible: false }
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    var startDateColumn = table.column($(this).attr('StartDate'));
    var dueDateColumn = table.column($(this).attr('DueDate'));
    switch (dataSourceType) {
        case "1":
            startDateColumn.visible(false);
            dueDateColumn.visible(false);
            break;
        case "2":
            startDateColumn.visible(true);
            dueDateColumn.visible(true);
            break;
        default:
            startDateColumn.visible(false);
            dueDateColumn.visible(false);
            break;
    }
}