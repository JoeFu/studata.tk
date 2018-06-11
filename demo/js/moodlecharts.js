$('#username').load('../backend/APIs.php?option=postName');
var name = $.get('../backend/APIs.php?option=Name',
    function getMessage(name) {
        var message = 'Dear ' + name + ', please choose datasets below:';
        document.getElementById("notice").innerHTML = message;
    });//Ajax Loading Assignment
function DataFormatChange(Original_date)
{
    var str = Original_date.toString();
    var Year_format = str.substr(0,4);
    var Month_format = str.substr(4,2);
    var Day_format = str.substr(6,2);
    if (Month_format==01)
    {
        Month_format ="Jan";
    }
    else if(Month_format==02)
    {
        Month_format ="Feb";
    }
    else if (Month_format==03)
    {
        Month_format ="Mar";
    }
    else if(Month_format==04)
    {
        Month_format="Apr"
    }
    else if(Month_format==05)
    {
        Month_format="May"
    }
    else if(Month_format==06)
    {
        Month_format="Jun"
    }
    else if(Month_format==07)
    {
        Month_format="July"
    }
    else if(Month_format==08)
    {
        Month_format="Aug"
    }
    else if(Month_format==09)
    {
        Month_format="Sep"
    }
    else if(Month_format==10)
    {
        Month_format="Oct"
    }
    else if(Month_format==11)
    {
        Month_format="Nov"
    }
    else if(Month_format==12)
    {
        Month_format="Dec"
    }
    return  Day_format +" / " + Month_format +" / " +Year_format;
}
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

})
$('#SelectSemester').change(function () {
    var SelectCourseId = $("#SelectCourse option:selected").attr("id");
    var SelectYearId = $("#SelectYear option:selected").attr("id");
    var SelectSemesterId = $("#SelectSemester option:selected").attr("id");
    var PeriodFrom;
    var PeriodTo;
    switch (SelectYearId) {
        //the start day and end day of semesters in different years are different
        case "2004":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0301";
                PeriodTo = SelectYearId + "0630";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0726";
                PeriodTo = SelectYearId + "1120";
            }
            break;
        case "2005":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0228";
                PeriodTo = SelectYearId + "0702";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0725";
                PeriodTo = SelectYearId + "1119";
            }
            break;
        case "2006":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0227";
                PeriodTo = SelectYearId + "0701";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0724";
                PeriodTo = SelectYearId + "1118";
            }
            break;
        case "2007":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0226";
                PeriodTo = SelectYearId + "0630";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0723";
                PeriodTo = SelectYearId + "1117";
            }
            break;
        case "2008":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0303";
                PeriodTo = SelectYearId + "0705";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0728";
                PeriodTo = SelectYearId + "1122";
            }
            break;
        case "2009":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0302";
                PeriodTo = SelectYearId + "0704";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0727";
                PeriodTo = SelectYearId + "1121";
            }
            break;
        case "2010":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0301";
                PeriodTo = SelectYearId + "0703";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0726";
                PeriodTo = SelectYearId + "1120";
            }
            break;
        case "2011":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0228";
                PeriodTo = SelectYearId + "0702";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0725";
                PeriodTo = SelectYearId + "1129";
            }
            break;
        case "2012":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0227";
                PeriodTo = SelectYearId + "0630";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0723";
                PeriodTo = SelectYearId + "1117";
            }
            break;
        case "2013":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0304";
                PeriodTo = SelectYearId + "0705";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0729";
                PeriodTo = SelectYearId + "1122";
            }
            break;
        case "2014":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0303";
                PeriodTo = SelectYearId + "0704";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0728";
                PeriodTo = SelectYearId + "1121";
            }
            break;
        case "2015":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0302";
                PeriodTo = SelectYearId + "0703";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0727";
                PeriodTo = SelectYearId + "1120";
            }
            break;
        case "2016":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0229";
                PeriodTo = SelectYearId + "0702";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0725";
                PeriodTo = SelectYearId + "1119";
            }
            break;
        case "2017":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0227";
                PeriodTo = SelectYearId + "0701";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0724";
                PeriodTo = SelectYearId + "1118";
            }
            break;
        case "2018":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0226";
                PeriodTo = SelectYearId + "0630";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0723";
                PeriodTo = SelectYearId + "1117";
            }
            break;
        case "2019":
            if (SelectSemesterId == "Semester 1") {
                PeriodFrom = SelectYearId + "0304";
                PeriodTo = SelectYearId + "0706";
            } else if (SelectSemesterId == "Semester 2") {
                PeriodFrom = SelectYearId + "0729";
                PeriodTo = SelectYearId + "1123";
            }
            break;
    }

    SemesterStartDay = DataFormatChange(PeriodFrom);
    SemesterEndDay = DataFormatChange(PeriodTo);
    $("#StudentActivitiesOverviewFrom").val(PeriodFrom);
    $("#StudentActivitiesOverviewTo").val(PeriodTo);
    $("#AllActivitiesOverviewFrom").val(PeriodFrom);
    $("#AllActivitiesOverviewTo").val(PeriodTo);
    $("#EventNamesOverviewFrom").val(PeriodFrom);
    $("#EventNamesOverviewTo").val(PeriodTo);
    $("#SpecificEventNameOverviewFrom").val(PeriodFrom);
    $("#SpecificEventNameOverviewTo").val(PeriodTo);
    $("#EventContextsOverviewFrom").val(PeriodFrom);
    $("#EventContextsOverviewTo").val(PeriodTo);
    $("#SpecificEventContextOverviewFrom").val(PeriodFrom);
    $("#SpecificEventContextOverviewTo").val(PeriodTo);
    $("#SemesterStartDay").html(SemesterStartDay);
    $("#SemesterEndDay").html(SemesterEndDay);
    displayAssignmentInformation();
})
$('#SelectAssignment').change(function () {
    getAssignmentStartDueDayAndUpdateAllCharts();
})


function displayAssignmentInformation() {
    var SelectCourse = $("#SelectCourse option:selected").attr("id");
    var SelectYear = $("#SelectYear option:selected").attr("id");
    var SelectSemester = $("#SelectSemester option:selected").attr("id");

    $.ajax({
        type: "get",
        async: true, //asynchronous
        url: "../../dashboard/controller.php?type=getAssignmentInformation",
        dataType: "json", //return JSON data
        data: { "SelectCourse": SelectCourse, "SelectYear": SelectYear, "SelectSemester": SelectSemester },
        success: function (result) {
            $("#AssignmentInformation").empty();
            $.each(result, function (i, p) {
                $("#AssignmentInformation").append(
                    "<lable>" + p['AssignmentName'] + " starts at: &nbsp;&nbsp;&nbsp; " + 
                    DataFormatChange(p['StartDate']) + "</lable>"
                );
                $("#AssignmentInformation").append("<lable>" +" &nbsp;&nbsp;&nbsp; Dues in:  &nbsp;&nbsp;&nbsp;" + DataFormatChange(p['DueDate']) + " &nbsp;&nbsp;&nbsp;</lable>");
            });
        }//success
    });//ajax
}

function getAssignmentStartDueDayAndUpdateAllCharts() {
    var SelectCourse = $("#SelectCourse option:selected").attr("id");
    var SelectYear = $("#SelectYear option:selected").attr("id");
    var SelectSemester = $("#SelectSemester option:selected").attr("id");
    var SelectAssignment = $("#SelectAssignment option:selected").attr("id");
    $.ajax({
        type: "get",
        async: true, //asynchronous
        url: "../../dashboard/controller.php?type=getAssignmentStartAndDueDay",
        dataType: "json", //return JSON data
        data: { "SelectCourse": SelectCourse, "SelectYear": SelectYear, "SelectSemester": SelectSemester, "SelectAssignment": SelectAssignment },
        success: function (result) {
            $.each(result, function (i, p) {
                $("#StudentActivitiesOverviewFrom").val(p['StartDate']);
                $("#StudentActivitiesOverviewTo").val(p['DueDate']);
                $("#AllActivitiesOverviewFrom").val(p['StartDate']);
                $("#AllActivitiesOverviewTo").val(p['DueDate']);
                $("#EventNamesOverviewFrom").val(p['StartDate']);
                $("#EventNamesOverviewTo").val(p['DueDate']);
                $("#SpecificEventNameOverviewFrom").val(p['StartDate']);
                $("#SpecificEventNameOverviewTo").val(p['DueDate']);
                $("#EventContextsOverviewFrom").val(p['StartDate']);
                $("#EventContextsOverviewTo").val(p['DueDate']);
                $("#SpecificEventContextOverviewFrom").val(p['StartDate']);
                $("#SpecificEventContextOverviewTo").val(p['DueDate']);
            });
        }//success
    });//ajax
}

$(document).ready(function () {
    $("#StudentActivitiesOverviewFrom").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function (selectedDate) {
            $("#StudentActivitiesOverviewTo").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#StudentActivitiesOverviewTo").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function (selectedDate) {
            $("#StudentActivitiesOverviewFrom").datepicker("option", "maxDate", selectedDate);
        }
    });

    //set the format (YYYYMMDD) of start date and end date for the chart "Student Activities Overview" 
    $("#StudentActivitiesOverviewFrom").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD
    $("#StudentActivitiesOverviewTo").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD
})

var myChartStudentActivitiesOverview = echarts.init(document.getElementById('StudentActivitiesOverview'));
//configuration item and data for the chart
var option = {
	title: {
		// text: 'Student activities overview'
	},
	tooltip: {},
	xAxis: {
		name: 'User',
		data: []
	},
	yAxis: {
		name: 'Amount of activities'
	},
	grid: {
		x: 100,
		y2: 100
	},
	dataZoom: [
		{   // dataZoom component controls x-axis by default
			type: 'slider',
			start: 0, // left position 0%
			end: 100  // right position 100%
		}
	],
	series: [{
		name: 'Amount of activities',
		type: 'bar',
		data: []
	}],
	toolbox: {
		show: true,
		feature: {
			dataView: { readOnly: false },
			magicType: { type: ['line', 'bar'] },
			restore: {},
			saveAsImage: {}
		}
	}
};
// display the chart based on the configuration item and data
myChartStudentActivitiesOverview.setOption(option);


var StudentActivitiesOverviewAmount;//number of bars (number of records)
var StudentActivitiesOverviewDiff = 100;

function studentActivitiesOverviewUpdate() {
	var SelectCourse = $("#SelectCourse option:selected").attr("id");
	var from = $("#StudentActivitiesOverviewFrom").val();
	var to = $("#StudentActivitiesOverviewTo").val();
	var order = $('#StudentActivitiesOverviewPresentationOrder').val();
	var ThresholdSelect = $('#StudentActivitiesOverviewThresholdSelect').val();
    var Threshold = $('#StudentActivitiesOverviewThreshold').val(); 
	$.ajax({
		type: "get",
		async: true, //asynchronous
		url: "../../dashboard/controller.php?type=studentActivitiesOverview",
		dataType: "json", //return JSON data
		data: { "from": from, "to": to, "order": order, "ThresholdSelect": ThresholdSelect, "Threshold": Threshold, "SelectCourse": SelectCourse},
		success: function (result) {
			var name = [];
			var count = [];
			var amount = [];
			$.each(result, function (i, p) {
				name[i] = p['name'];
				count[i] = p['count'];
				amount[i] = p['amount'];
			});
		StudentActivitiesOverviewAmount = amount[0];
		myChartStudentActivitiesOverview.hideLoading();
		var StudentActivitiesOverviewRelativeAmount = StudentActivitiesOverviewDiff * StudentActivitiesOverviewAmount / 100;
		// the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will determine which stage we are at when loading the data: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
		if (StudentActivitiesOverviewRelativeAmount <= 8.15) {
			myChartStudentActivitiesOverview.setOption({
				xAxis: {
					data: name,
					axisLabel: {
						show: true,
						interval: 'auto',
						rotate: 0
					}
				},
				series: [{
					name: 'Amount of activities',
					data: count
				}]
			});
		} else if (StudentActivitiesOverviewRelativeAmount <= 16.3) {
			myChartStudentActivitiesOverview.setOption({
				xAxis: {
					data: name,
					axisLabel: {
						show: true,
						interval: 0,
						rotate: 40
					}
				},
				series: [{
					name: 'Amount of activities',
					data: count
				}]
			});
		} else if (StudentActivitiesOverviewRelativeAmount <= 48.9) {
			myChartStudentActivitiesOverview.setOption({
				xAxis: {
					data: name,
					axisLabel: {
						show: true,
						interval: 0,
						rotate: 90
					}
				},
				series: [{
					name: 'Amount of activities',
					data: count
				}]
			});
		} else if (StudentActivitiesOverviewRelativeAmount > 48.9) {
			myChartStudentActivitiesOverview.setOption({
				xAxis: {
					data: name,
					axisLabel: {
						show: false
					}
				},
				series: [{
					name: 'Amount of activities',
					data: count
				}]
			});
		}
		}//success
	});//ajax
}
//after user sets presentation order/period/threshold, update the chart "StudentActivitiesOverview"
$(document).ready(function () {
	$('#StudentActivitiesOverviewPresentationOrder').change(function () {
		studentActivitiesOverviewUpdate();
	})
	$('#StudentActivitiesOverviewSetPeriod').click(function () {
		studentActivitiesOverviewUpdate();
	})
	$('#StudentActivitiesOverviewSetThreshold').click(function () {
        studentActivitiesOverviewUpdate();
	})

	//export the data in CSV format according to the configuration options that user chooses, also these configuration options are included in the file name
	$('#StudentActivitiesOverviewCSV').click(function () {
		var SelectCourse = $("#SelectCourse option:selected").attr("id");
		var SelectYear = $("#SelectYear option:selected").attr("id");
		var SelectSemester = $("#SelectSemester option:selected").attr("id");
		var from = $("#StudentActivitiesOverviewFrom").val();
		var to = $("#StudentActivitiesOverviewTo").val();
		var order = $('#StudentActivitiesOverviewPresentationOrder').val();
		var ThresholdSelect = $('#StudentActivitiesOverviewThresholdSelect').val();
		var Threshold = $('#StudentActivitiesOverviewThreshold').val();
		// dynamically concatenate url
		var url = '../../dashboard/controller.php?type=studentActivitiesOverviewCSV&from=' + from + '&to=' + to + '&order=' + order + '&ThresholdSelect=' + ThresholdSelect + '&Threshold=' + Threshold + '&SelectCourse=' + SelectCourse + '&SelectYear=' + SelectYear + '&SelectSemester=' + SelectSemester;
		window.location.href = url;
	})
})// $(document).ready

myChartStudentActivitiesOverview.on('datazoom', function (params) {
	var diff = params.end - params.start;//difference between left and right position of the slider
	StudentActivitiesOverviewDiff = diff;
	var StudentActivitiesOverviewRelativeAmount = StudentActivitiesOverviewDiff * StudentActivitiesOverviewAmount / 100;
	if (StudentActivitiesOverviewRelativeAmount < 8.15) {
		myChartStudentActivitiesOverview.setOption({
			xAxis: {
				axisLabel: {
					show: true,
					interval: 'auto',
					rotate: 0
				}

			}
		});
	} else if (StudentActivitiesOverviewRelativeAmount < 16.3) {
		myChartStudentActivitiesOverview.setOption({
			xAxis: {
				axisLabel: {
					show: true,
					interval: 0,
					rotate: 40
				}

			}
		});
	} else if (StudentActivitiesOverviewRelativeAmount < 48.9) {
		myChartStudentActivitiesOverview.setOption({
			xAxis: {
				axisLabel: {
					show: true,
					interval: 0,
					rotate: 90
				}

			}
		});
	} else if (StudentActivitiesOverviewRelativeAmount >= 48.9) {
		myChartStudentActivitiesOverview.setOption({
			xAxis: {
				axisLabel: {
					show: false
				}

			}
		});
	}
});

// After user clicks a bar (a bar represents a user), redirect to another page showing the detailed information of that user (the amount of different events of that user).
myChartStudentActivitiesOverview.on('click', function (param) {
	var from = $("#StudentActivitiesOverviewFrom").val();
	var to = $("#StudentActivitiesOverviewTo").val();
	var SelectCourseId = $("#SelectCourse option:selected").attr("id");
	var SelectYearId = $("#SelectYear option:selected").attr("id");
	var SelectSemesterId = $("#SelectSemester option:selected").attr("id");
	var url = '../../dashboard/StudentActivitiesOverviewDetails.php?user=' + param.name + '&from=' + from + '&to=' + to + '&SelectCourseId=' + SelectCourseId + '&SelectYearId=' + SelectYearId + '&SelectSemesterId=' + SelectSemesterId;
	window.open(url, "_blank");
});
$("#confirm_button").click(function () {
    studentActivitiesOverviewUpdate();
    allActivitiesOverviewUpdate();
    eventNamesOverviewUpdate();
    specificEventNameOverviewUpdate();
    eventContextsOverviewUpdate();
    specificEventContextOverviewUpdate();
})

$(document).ready(function () {
	$("#AllActivitiesOverviewFrom").datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 3,
		onClose: function (selectedDate) {
			$("#AllActivitiesOverviewTo").datepicker("option", "minDate", selectedDate);
		}
	});
	$("#AllActivitiesOverviewTo").datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 3,
		onClose: function (selectedDate) {
			$("#AllActivitiesOverviewFrom").datepicker("option", "maxDate", selectedDate);
		}
	});

	//set the format (YYYYMMDD) of start date and end date for the chart "All Activities Overview" 
	$("#AllActivitiesOverviewFrom").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD
	$("#AllActivitiesOverviewTo").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD
})



//Initialize e-charts instance
var myChartAllActivitiesOverview = echarts.init(document.getElementById('AllActivitiesOverview'));

//configuration item and data for the chart
var option = {
	title: {
		// text: 'All activities overview'
	},
	tooltip: {},
	xAxis: {
		name: 'Date',
		data: []
	},
	yAxis: {
		name: 'Amount of activities'
	},
	grid: {
		x: 100,
		y2: 110
	},
	dataZoom: [
		{   // dataZoom component controls x-axis by default
			type: 'slider',
			start: 0, // left position 0%
			end: 100  // right position 100%
		}
	],
	series: [{
		name: 'Amount of activities',
		type: 'bar',
		data: []
	}],
	toolbox: {
		show: true,
		feature: {
			dataView: { readOnly: false },
			magicType: { type: ['line', 'bar'] },
			restore: {},
			saveAsImage: {}
		}
	}
};

// display the chart based on the configuration item and data
myChartAllActivitiesOverview.setOption(option);

var AllActivitiesOverviewAmount;//number of bars (number of records)
var AllActivitiesOverviewDiff = 100;

function allActivitiesOverviewUpdate() {
	var SelectCourse = $("#SelectCourse option:selected").attr("id");
	var from = $("#AllActivitiesOverviewFrom").val();
	var to = $("#AllActivitiesOverviewTo").val();
	var order = $('#AllActivitiesOverviewPresentationOrder').val();
	var ThresholdSelect = $('#AllActivitiesOverviewThresholdSelect').val();
	var Threshold = $('#AllActivitiesOverviewThreshold').val();

	$.ajax({
		type: "get",
		async: true, //asynchronous
		url: "../../dashboard/controller.php?type=allActivitiesOverview",
		dataType: "json", //return JSON data
		data: { "from": from, "to": to, "order": order, "ThresholdSelect": ThresholdSelect, "Threshold": Threshold, "SelectCourse": SelectCourse},
		success: function (result) {
			var date = [];
			var count = [];
			var amount = [];
			$.each(result, function (i, p) {
				date[i] = p['date'];
				count[i] = p['count'];
				amount[i] = p['amount'];
			});
		AllActivitiesOverviewAmount = amount[0];
		myChartAllActivitiesOverview.hideLoading();
		var AllActivitiesOverviewRelativeAmount = AllActivitiesOverviewDiff * AllActivitiesOverviewAmount / 100;
		// the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will determine which stage we are at when loading the data: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
		if (AllActivitiesOverviewRelativeAmount <= 8.15) {
			myChartAllActivitiesOverview.setOption({
				xAxis: {
					data: date,
					axisLabel: {
						show: true,
						interval: 'auto',
						rotate: 0
					}
				},
				series: [{
					name: 'Amount of activities',
					data: count
				}]
			});
		} else if (AllActivitiesOverviewRelativeAmount <= 16.3) {
			myChartAllActivitiesOverview.setOption({
				xAxis: {
					data: date,
					axisLabel: {
						show: true,
						interval: 0,
						rotate: 40
					}
				},
				series: [{
					name: 'Amount of activities',
					data: count
				}]
			});
		} else if (AllActivitiesOverviewRelativeAmount <= 48.9) {
			myChartAllActivitiesOverview.setOption({
				xAxis: {
					data: date,
					axisLabel: {
						show: true,
						interval: 0,
						rotate: 90
					}
				},
				series: [{
					name: 'Amount of activities',
					data: count
				}]
			});
		} else if (AllActivitiesOverviewRelativeAmount > 48.9) {
			myChartAllActivitiesOverview.setOption({
				xAxis: {
					data: date,
					axisLabel: {
						show: false
					}
				},
				series: [{
					name: 'Amount of activities',
					data: count
				}]
			});
		}
		}//success
	});//ajax
}//function allActivitiesOverviewUpdate()

//after user sets presentation order/period/threshold, update the chart "AllActivitiesOverview"
$(document).ready(function () {
	$('#AllActivitiesOverviewPresentationOrder').change(function () {
		allActivitiesOverviewUpdate();
	})
	$('#AllActivitiesOverviewSetPeriod').click(function () {
		allActivitiesOverviewUpdate();
	})
	$('#AllActivitiesOverviewSetThreshold').click(function () {
		allActivitiesOverviewUpdate();
	})

	//export the data in CSV format according to the configuration options that user chooses, also these configuration options are included in the file name
	$('#AllActivitiesOverviewCSV').click(function () {
		var SelectCourse = $("#SelectCourse option:selected").attr("id");
		var SelectYear = $("#SelectYear option:selected").attr("id");
		var SelectSemester = $("#SelectSemester option:selected").attr("id");
		var from = $("#AllActivitiesOverviewFrom").val();
		var to = $("#AllActivitiesOverviewTo").val();
		var order = $('#AllActivitiesOverviewPresentationOrder').val();
		var ThresholdSelect = $('#AllActivitiesOverviewThresholdSelect').val();
		var Threshold = $('#AllActivitiesOverviewThreshold').val();
		// dynamically concatenate url
		var url = '../../dashboard/controller.php?type=allActivitiesOverviewCSV&from=' + from + '&to=' + to + '&order=' + order + '&ThresholdSelect=' + ThresholdSelect + '&Threshold=' + Threshold + '&SelectCourse=' + SelectCourse + '&SelectYear=' + SelectYear + '&SelectSemester=' + SelectSemester;
		window.location.href = url;
	})
})// $(document).ready

// the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will dynamically determine which stage we are at when the left position and right position of the slider are changed: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
myChartAllActivitiesOverview.on('datazoom', function (params) {
	var diff = params.end - params.start;//difference between left and right position of the slider
	AllActivitiesOverviewDiff = diff;
	var AllActivitiesOverviewRelativeAmount = AllActivitiesOverviewDiff * AllActivitiesOverviewAmount / 100;
	if (AllActivitiesOverviewRelativeAmount < 8.15) {
		myChartAllActivitiesOverview.setOption({
			xAxis: {
				axisLabel: {
					show: true,
					interval: 'auto',
					rotate: 0
				}

			}
		});
	} else if (AllActivitiesOverviewRelativeAmount < 16.3) {
		myChartAllActivitiesOverview.setOption({
			xAxis: {
				axisLabel: {
					show: true,
					interval: 0,
					rotate: 40
				}

			}
		});
	} else if (AllActivitiesOverviewRelativeAmount < 48.9) {
		myChartAllActivitiesOverview.setOption({
			xAxis: {
				axisLabel: {
					show: true,
					interval: 0,
					rotate: 90
				}

			}
		});
	} else if (AllActivitiesOverviewRelativeAmount >= 48.9) {
		myChartAllActivitiesOverview.setOption({
			xAxis: {
				axisLabel: {
					show: false
				}

			}
		});
	}
});


//DatePicker for the chart "Event Names Overview"
$(document).ready(function () {
    $("#EventNamesOverviewFrom").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function (selectedDate) {
            $("#EventNamesOverviewTo").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#EventNamesOverviewTo").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function (selectedDate) {
            $("#EventNamesOverviewFrom").datepicker("option", "maxDate", selectedDate);
        }
    });

    //set the format (YYYYMMDD) of start date and end date for the chart "Event Names Overview" 
    $("#EventNamesOverviewFrom").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD
    $("#EventNamesOverviewTo").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD
})

//Initialize e-charts instance
var myChartEventNamesOverview = echarts.init(document.getElementById('EventNamesOverview'));

//configuration item and data for the chart
var option = {
    title: {
        // text: 'Event names overview'
    },
    tooltip: {},
    xAxis: {
        name: 'Event name',
        data: []
    },
    yAxis: {
        name: 'Amount of activities'
    },
    grid: {
        x: 100,
        y2: 180
    },
    dataZoom: [
        {   // dataZoom component controls x-axis by default
            type: 'slider',
            start: 0, // left position 0%
            end: 100  // right position 100%
        }
    ],
    series: [{
        name: 'Amount of activities',
        type: 'bar',
        data: []
    }],
    toolbox: {
        show: true,
        feature: {
            dataView: { readOnly: false },
            magicType: { type: ['line', 'bar'] },
            restore: {},
            saveAsImage: {}
        }
    }
};

// display the chart based on the configuration item and data
myChartEventNamesOverview.setOption(option);

var EventNamesOverviewAmount;//number of bars (number of records)
var EventNamesOverviewDiff = 100;

function eventNamesOverviewUpdate() {
    var SelectCourse = $("#SelectCourse option:selected").attr("id");
    var from = $("#EventNamesOverviewFrom").val();
    var to = $("#EventNamesOverviewTo").val();
    var order = $('#EventNamesOverviewPresentationOrder').val();
    var ThresholdSelect = $('#EventNamesOverviewThresholdSelect').val();
    var Threshold = $('#EventNamesOverviewThreshold').val();

    $.ajax({
        type: "get",
        async: true, //asynchronous
        url: "../../dashboard/controller.php?type=eventNamesOverview",
        dataType: "json", //return JSON data
        data: { "from": from, "to": to, "order": order, "ThresholdSelect": ThresholdSelect, "Threshold": Threshold, "SelectCourse": SelectCourse },
        success: function (result) {
            var name = [];
            var count = [];
            var amount = [];
            $.each(result, function (i, p) {
                name[i] = p['name'];
                count[i] = p['count'];
                amount[i] = p['amount'];
            });
            EventNamesOverviewAmount = amount[0];
            myChartEventNamesOverview.hideLoading();
            var EventNamesOverviewRelativeAmount = EventNamesOverviewDiff * EventNamesOverviewAmount / 100;
            // the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will determine which stage we are at when loading the data: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
            if (EventNamesOverviewRelativeAmount <= 2.55) {
                myChartEventNamesOverview.setOption({
                    xAxis: {
                        data: name,
                        axisLabel: {
                            show: true,
                            interval: 'auto',
                            rotate: 0
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (EventNamesOverviewRelativeAmount <= 16.3) {
                myChartEventNamesOverview.setOption({
                    xAxis: {
                        data: name,
                        axisLabel: {
                            show: true,
                            interval: 0,
                            rotate: 40
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (EventNamesOverviewRelativeAmount <= 48.9) {
                myChartEventNamesOverview.setOption({
                    xAxis: {
                        data: name,
                        axisLabel: {
                            show: true,
                            interval: 0,
                            rotate: 90
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (EventNamesOverviewRelativeAmount > 48.9) {
                myChartEventNamesOverview.setOption({
                    xAxis: {
                        data: name,
                        axisLabel: {
                            show: false
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            }
        }//success
    });//ajax
}//function eventNamesOverviewUpdate()

//after user sets presentation order/period/threshold, update the chart "EventNamesOverview"
$(document).ready(function () {
    $('#EventNamesOverviewPresentationOrder').change(function () {
        eventNamesOverviewUpdate();
    })
    $('#EventNamesOverviewSetPeriod').click(function () {
        eventNamesOverviewUpdate();
    })
    $('#EventNamesOverviewSetThreshold').click(function () {
        eventNamesOverviewUpdate();
    })

    //export the data in CSV format according to the configuration options that user chooses, also these configuration options are included in the file name
    $('#EventNamesOverviewCSV').click(function () {
        var SelectCourse = $("#SelectCourse option:selected").attr("id");
        var SelectYear = $("#SelectYear option:selected").attr("id");
        var SelectSemester = $("#SelectSemester option:selected").attr("id");
        var from = $("#EventNamesOverviewFrom").val();
        var to = $("#EventNamesOverviewTo").val();
        var order = $('#EventNamesOverviewPresentationOrder').val();
        var ThresholdSelect = $('#EventNamesOverviewThresholdSelect').val();
        var Threshold = $('#EventNamesOverviewThreshold').val();
        // dynamically concatenate url
        var url = '../../dashboard/controller.php?type=eventNamesOverviewCSV&from=' + from + '&to=' + to + '&order=' + order + '&ThresholdSelect=' + ThresholdSelect + '&Threshold=' + Threshold + '&SelectCourse=' + SelectCourse + '&SelectYear=' + SelectYear + '&SelectSemester=' + SelectSemester;
        window.location.href = url;
    })
})// $(document).ready

// the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will dynamically determine which stage we are at when the left position and right position of the slider are changed: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
myChartEventNamesOverview.on('datazoom', function (params) {
    var diff = params.end - params.start;//difference between left and right position of the slider
    EventNamesOverviewDiff = diff;
    var EventNamesOverviewRelativeAmount = EventNamesOverviewDiff * EventNamesOverviewAmount / 100;
    if (EventNamesOverviewRelativeAmount < 2.55) {
        myChartEventNamesOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 'auto',
                    rotate: 0
                }

            }
        });
    } else if (EventNamesOverviewRelativeAmount < 16.3) {
        myChartEventNamesOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 0,
                    rotate: 40
                }

            }
        });
    } else if (EventNamesOverviewRelativeAmount < 48.9) {
        myChartEventNamesOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 0,
                    rotate: 90
                }

            }
        });
    } else if (EventNamesOverviewRelativeAmount >= 48.9) {
        myChartEventNamesOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: false
                }

            }
        });
    }
});



$(document).ready(function () {
    $("#SpecificEventNameOverviewFrom").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function (selectedDate) {
            $("#SpecificEventNameOverviewTo").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#SpecificEventNameOverviewTo").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function (selectedDate) {
            $("#SpecificEventNameOverviewFrom").datepicker("option", "maxDate", selectedDate);
        }
    });

    //set the format (YYYYMMDD) of start date and end date for the chart "Specific Event Name Overview" 
    $("#SpecificEventNameOverviewFrom").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD
    $("#SpecificEventNameOverviewTo").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD

    //auto-complete for the input box (id: SpecificEventNameOverviewEventName)the chart "Specific Event Name Overview" 
    var src = "../../dashboard/controller.php?type=specificEventNameOverviewAutoComplete";
    $("#SpecificEventNameOverviewEventName").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term: request.term,
                    from: $("#SpecificEventNameOverviewFrom").val(),
                    to: $("#SpecificEventNameOverviewTo").val(),
                    ThresholdSelect: $('#SpecificEventNameOverviewAutoCompleteThresholdSelect').val(),
                    Threshold: $('#SpecificEventNameOverviewAutoCompleteThreshold').val(),
                    SelectCourse: $("#SelectCourse option:selected").attr("id")
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        min_length: 3,
        delay: 300
    });
})//$(document).ready

//Initialize e-charts instance
var myChartSpecificEventNameOverview = echarts.init(document.getElementById('SpecificEventNameOverview'));

//configuration item and data for the chart
var option = {
    title: {
        // text: 'Specific event name overview'
    },
    tooltip: {},
    xAxis: {
        name: 'Date',
        data: []
    },
    yAxis: {
        name: 'Amount of activities'
    },
    grid: {
        x: 100,
        y2: 110
    },
    dataZoom: [
        {   // dataZoom component controls x-axis by default
            type: 'slider',
            start: 0, // left position 0%
            end: 100  // right position 100%
        }
    ],
    series: [{
        name: 'Amount of activities',
        type: 'bar',
        data: []
    }],
    toolbox: {
        show: true,
        feature: {
            dataView: { readOnly: false },
            magicType: { type: ['line', 'bar'] },
            restore: {},
            saveAsImage: {}
        }
    }
};

// display the chart based on the configuration item and data
myChartSpecificEventNameOverview.setOption(option);

var SpecificEventNameOverviewAmount;//number of bars (number of records)
var SpecificEventNameOverviewDiff = 100;

function specificEventNameOverviewUpdate() {
    var EventName = $('#SpecificEventNameOverviewEventName').val();
    var SelectCourse = $("#SelectCourse option:selected").attr("id");
    var from = $("#SpecificEventNameOverviewFrom").val();
    var to = $("#SpecificEventNameOverviewTo").val();
    var order = $('#SpecificEventNameOverviewPresentationOrder').val();
    var ThresholdSelect = $('#SpecificEventNameOverviewThresholdSelect').val();
    var Threshold = $('#SpecificEventNameOverviewThreshold').val();

    $.ajax({
        type: "get",
        async: true, //asynchronous
        url: "../../dashboard/controller.php?type=specificEventNameOverview",
        dataType: "json", //return JSON data
        data: { "EventName": EventName, "from": from, "to": to, "order": order, "ThresholdSelect": ThresholdSelect, "Threshold": Threshold, "SelectCourse": SelectCourse },
        success: function (result) {
            var date = [];
            var count = [];
            var amount = [];
            $.each(result, function (i, p) {
                date[i] = p['date'];
                count[i] = p['count'];
                amount[i] = p['amount'];
            });
            SpecificEventNameOverviewAmount = amount[0];
            myChartSpecificEventNameOverview.hideLoading();
            var SpecificEventNameOverviewRelativeAmount = SpecificEventNameOverviewDiff * SpecificEventNameOverviewAmount / 100;
            // the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will determine which stage we are at when loading the data: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
            if (SpecificEventNameOverviewRelativeAmount <= 8.15) {
                myChartSpecificEventNameOverview.setOption({
                    title: {
                        text: EventName
                    },
                    xAxis: {
                        data: date,
                        axisLabel: {
                            show: true,
                            interval: 'auto',
                            rotate: 0
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (SpecificEventNameOverviewRelativeAmount <= 16.3) {
                myChartSpecificEventNameOverview.setOption({
                    title: {
                        text: EventName
                    },
                    xAxis: {
                        data: date,
                        axisLabel: {
                            show: true,
                            interval: 0,
                            rotate: 40
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (SpecificEventNameOverviewRelativeAmount <= 48.9) {
                myChartSpecificEventNameOverview.setOption({
                    title: {
                        text: EventName
                    },
                    xAxis: {
                        data: date,
                        axisLabel: {
                            show: true,
                            interval: 0,
                            rotate: 90
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (SpecificEventNameOverviewRelativeAmount > 48.9) {
                myChartSpecificEventNameOverview.setOption({
                    title: {
                        text: EventName
                    },
                    xAxis: {
                        data: date,
                        axisLabel: {
                            show: false
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            }
        }//success
    });//ajax
}//function specificEventNameOverviewUpdate()

//after user sets event name, presentation order/period/threshold, update the chart "SpecificEventNameOverview"
$(document).ready(function () {
    $('#SpecificEventNameOverviewPresentationOrder').change(function () {
        specificEventNameOverviewUpdate();
    })
    $('#SpecificEventNameOverviewSetPeriod').click(function () {
        specificEventNameOverviewUpdate();
    })
    $('#SpecificEventNameOverviewSetThreshold').click(function () {
        specificEventNameOverviewUpdate();
    })
    $('#SpecificEventNameOverviewSetEventName').click(function () {
        specificEventNameOverviewUpdate();
    })

    //export the data in CSV format according to the configuration options that user chooses, also these configuration options are included in the file name
    $('#SpecificEventNameOverviewCSV').click(function () {
        var EventName = $('#SpecificEventNameOverviewEventName').val();
        var SelectCourse = $("#SelectCourse option:selected").attr("id");
        var SelectYear = $("#SelectYear option:selected").attr("id");
        var SelectSemester = $("#SelectSemester option:selected").attr("id");
        var from = $("#SpecificEventNameOverviewFrom").val();
        var to = $("#SpecificEventNameOverviewTo").val();
        var order = $('#SpecificEventNameOverviewPresentationOrder').val();
        var ThresholdSelect = $('#SpecificEventNameOverviewThresholdSelect').val();
        var Threshold = $('#SpecificEventNameOverviewThreshold').val();
        // dynamically concatenate url
        var url = '../../dashboard/controller.php?type=specificEventNameOverviewCSV&EventName=' + EventName + '&from=' + from + '&to=' + to + '&order=' + order + '&ThresholdSelect=' + ThresholdSelect + '&Threshold=' + Threshold + '&SelectCourse=' + SelectCourse + '&SelectYear=' + SelectYear + '&SelectSemester=' + SelectSemester;
        window.location.href = url;
    })
})// $(document).ready

// the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will dynamically determine which stage we are at when the left position and right position of the slider are changed: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
myChartSpecificEventNameOverview.on('datazoom', function (params) {
    var diff = params.end - params.start;//difference between left and right position of the slider
    SpecificEventNameOverviewDiff = diff;
    var SpecificEventNameOverviewRelativeAmount = SpecificEventNameOverviewDiff * SpecificEventNameOverviewAmount / 100;
    if (SpecificEventNameOverviewRelativeAmount < 8.15) {
        myChartSpecificEventNameOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 'auto',
                    rotate: 0
                }

            }
        });
    } else if (SpecificEventNameOverviewRelativeAmount < 16.3) {
        myChartSpecificEventNameOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 0,
                    rotate: 40
                }

            }
        });
    } else if (SpecificEventNameOverviewRelativeAmount < 48.9) {
        myChartSpecificEventNameOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 0,
                    rotate: 90
                }

            }
        });
    } else if (SpecificEventNameOverviewRelativeAmount >= 48.9) {
        myChartSpecificEventNameOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: false
                }

            }
        });
    }
});



//DatePicker for the chart "Event Contexts Overview"
$(document).ready(function () {
    $("#EventContextsOverviewFrom").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function (selectedDate) {
            $("#EventContextsOverviewTo").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#EventContextsOverviewTo").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function (selectedDate) {
            $("#EventContextsOverviewFrom").datepicker("option", "maxDate", selectedDate);
        }
    });

    //set the format (YYYYMMDD) of start date and end date for the chart "Event Contexts Overview" 
    $("#EventContextsOverviewFrom").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD
    $("#EventContextsOverviewTo").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD
})

//Initialize e-charts instance
var myChartEventContextsOverview = echarts.init(document.getElementById('EventContextsOverview'));

//configuration item and data for the chart
var option = {
    title: {
        // text: 'Event contexts overview'
    },
    tooltip: {},
    xAxis: {
        name: 'Event context',
        data: []
    },
    yAxis: {
        name: 'Amount of activities'
    },
    grid: {
        x: 100,
        y2: 500
    },
    dataZoom: [
        {   // dataZoom component controls x-axis by default
            type: 'slider',
            start: 0, // left position 0%
            end: 100  // right position 100%
        }
    ],
    series: [{
        name: 'Amount of activities',
        type: 'bar',
        data: []
    }],
    toolbox: {
        show: true,
        feature: {
            dataView: { readOnly: false },
            magicType: { type: ['line', 'bar'] },
            restore: {},
            saveAsImage: {}
        }
    }
};

// display the chart based on the configuration item and data
myChartEventContextsOverview.setOption(option);

var EventContextsOverviewAmount;//number of bars (number of records)
var EventContextsOverviewDiff = 100;

function eventContextsOverviewUpdate() {
    var SelectCourse = $("#SelectCourse option:selected").attr("id");
    var from = $("#EventContextsOverviewFrom").val();
    var to = $("#EventContextsOverviewTo").val();
    var order = $('#EventContextsOverviewPresentationOrder').val();
    var ThresholdSelect = $('#EventContextsOverviewThresholdSelect').val();
    var Threshold = $('#EventContextsOverviewThreshold').val();

    $.ajax({
        type: "get",
        async: true, //asynchronous
        url: "../../dashboard/controller.php?type=eventContextsOverview",
        dataType: "json", //return JSON data
        data: { "from": from, "to": to, "order": order, "ThresholdSelect": ThresholdSelect, "Threshold": Threshold, "SelectCourse": SelectCourse },
        success: function (result) {
            var name = [];
            var count = [];
            var amount = [];
            $.each(result, function (i, p) {
                name[i] = p['name'];
                count[i] = p['count'];
                amount[i] = p['amount'];
            });
            EventContextsOverviewAmount = amount[0];
            myChartEventContextsOverview.hideLoading();
            var EventContextsOverviewRelativeAmount = EventContextsOverviewDiff * EventContextsOverviewAmount / 100;
            // the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will determine which stage we are at when loading the data: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
            if (EventContextsOverviewRelativeAmount <= 0.451) {
                myChartEventContextsOverview.setOption({
                    xAxis: {
                        data: name,
                        axisLabel: {
                            show: true,
                            interval: 'auto',
                            rotate: 0
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (EventContextsOverviewRelativeAmount <= 16.3) {
                myChartEventContextsOverview.setOption({
                    xAxis: {
                        data: name,
                        axisLabel: {
                            show: true,
                            interval: 0,
                            rotate: 70
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (EventContextsOverviewRelativeAmount <= 48.9) {
                myChartEventContextsOverview.setOption({
                    xAxis: {
                        data: name,
                        axisLabel: {
                            show: true,
                            interval: 0,
                            rotate: 90
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (EventContextsOverviewRelativeAmount > 48.9) {
                myChartEventContextsOverview.setOption({
                    xAxis: {
                        data: name,
                        axisLabel: {
                            show: false
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            }
        }//success
    });//ajax
}//function eventContextsOverviewUpdate()

//after user sets presentation order/period/threshold, update the chart "EventContextsOverview"
$(document).ready(function () {
    $('#EventContextsOverviewPresentationOrder').change(function () {
        eventContextsOverviewUpdate();
    })
    $('#EventContextsOverviewSetPeriod').click(function () {
        eventContextsOverviewUpdate();
    })
    $('#EventContextsOverviewSetThreshold').click(function () {
        eventContextsOverviewUpdate();
    })

    //export the data in CSV format according to the configuration options that user chooses, also these configuration options are included in the file name
    $('#EventContextsOverviewCSV').click(function () {
        var SelectCourse = $("#SelectCourse option:selected").attr("id");
        var SelectYear = $("#SelectYear option:selected").attr("id");
        var SelectSemester = $("#SelectSemester option:selected").attr("id");
        var from = $("#EventContextsOverviewFrom").val();
        var to = $("#EventContextsOverviewTo").val();
        var order = $('#EventContextsOverviewPresentationOrder').val();
        var ThresholdSelect = $('#EventContextsOverviewThresholdSelect').val();
        var Threshold = $('#EventContextsOverviewThreshold').val();
        // dynamically concatenate url
        var url = '../../dashboard/controller.php?type=eventContextsOverviewCSV&from=' + from + '&to=' + to + '&order=' + order + '&ThresholdSelect=' + ThresholdSelect + '&Threshold=' + Threshold + '&SelectCourse=' + SelectCourse + '&SelectYear=' + SelectYear + '&SelectSemester=' + SelectSemester;
        window.location.href = url;
    })
})// $(document).ready

// the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will dynamically determine which stage we are at when the left position and right position of the slider are changed: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
myChartEventContextsOverview.on('datazoom', function (params) {
    var diff = params.end - params.start;//difference between left and right position of the slider
    EventContextsOverviewDiff = diff;
    var EventContextsOverviewRelativeAmount = EventContextsOverviewDiff * EventContextsOverviewAmount / 100;
    if (EventContextsOverviewRelativeAmount < 0.451) {
        myChartEventContextsOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 'auto',
                    rotate: 0
                }

            }
        });
    } else if (EventContextsOverviewRelativeAmount < 16.3) {
        myChartEventContextsOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 0,
                    rotate: 70
                }

            }
        });
    } else if (EventContextsOverviewRelativeAmount < 48.9) {
        myChartEventContextsOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 0,
                    rotate: 90
                }

            }
        });
    } else if (EventContextsOverviewRelativeAmount >= 48.9) {
        myChartEventContextsOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: false
                }

            }
        });
    }
});



//DatePicker for the chart "Specific Event Context Overview"
$(document).ready(function () {
    $("#SpecificEventContextOverviewFrom").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function (selectedDate) {
            $("#SpecificEventContextOverviewTo").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#SpecificEventContextOverviewTo").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function (selectedDate) {
            $("#SpecificEventContextOverviewFrom").datepicker("option", "maxDate", selectedDate);
        }
    });

    //set the format (YYYYMMDD) of start date and end date for the chart "Specific Event Context Overview" 
    $("#SpecificEventContextOverviewFrom").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD
    $("#SpecificEventContextOverviewTo").datepicker("option", "dateFormat", "yymmdd");//YYYYMMDD

    //auto-complete for the input box (id: SpecificEventContextOverviewEventName)the chart "Specific Event Context Overview" 
    var src = "../../dashboard/controller.php?type=specificEventContextOverviewAutoComplete";
	$("#SpecificEventContextOverviewEventContext").autocomplete({
		source: function (request, response) {
			$.ajax({
				url: src,
				dataType: "json",
				data: {
					term: request.term, 
					from: $("#SpecificEventContextOverviewFrom").val(), 
					to: $("#SpecificEventContextOverviewTo").val(), 
					ThresholdSelect: $('#SpecificEventContextOverviewAutoCompleteThresholdSelect').val(), 
					Threshold: $('#SpecificEventContextOverviewAutoCompleteThreshold').val(), 
					SelectCourse: $("#SelectCourse option:selected").attr("id")
				},
				success: function (data) {
					response(data);
				}
			});
		},
		min_length: 3,
		delay: 300
	});
})//$(document).ready

//Initialize e-charts instance
var myChartSpecificEventContextOverview = echarts.init(document.getElementById('SpecificEventContextOverview'));

//configuration item and data for the chart
var option = {
    title: {
        // text: 'Specific event context overview'
    },
    tooltip: {},
    xAxis: {
        name: 'Date',
        data: []
    },
    yAxis: {
        name: 'Amount of activities'
    },
    grid: {
        x: 100,
        y2: 110
    },
    dataZoom: [
        {   // dataZoom component controls x-axis by default
            type: 'slider',
            start: 0, // left position 0%
            end: 100  // right position 100%
        }
    ],
    series: [{
        name: 'Amount of activities',
        type: 'bar',
        data: []
    }],
    toolbox: {
        show: true,
        feature: {
            dataView: { readOnly: false },
            magicType: { type: ['line', 'bar'] },
            restore: {},
            saveAsImage: {}
        }
    }
};

// display the chart based on the configuration item and data
myChartSpecificEventContextOverview.setOption(option);

var SpecificEventContextOverviewAmount;//number of bars (number of records)
var SpecificEventContextOverviewDiff = 100;

function specificEventContextOverviewUpdate() {
    var EventContext = $('#SpecificEventContextOverviewEventContext').val();
    var SelectCourse = $("#SelectCourse option:selected").attr("id");
    var from = $("#SpecificEventContextOverviewFrom").val();
    var to = $("#SpecificEventContextOverviewTo").val();
    var order = $('#SpecificEventContextOverviewPresentationOrder').val();
    var ThresholdSelect = $('#SpecificEventContextOverviewThresholdSelect').val();
    var Threshold = $('#SpecificEventContextOverviewThreshold').val();

    $.ajax({
        type: "get",
        async: true, //asynchronous
        url: "../../dashboard/controller.php?type=specificEventContextOverview",
        dataType: "json", //return JSON data
        data: { "EventContext": EventContext, "from": from, "to": to, "order": order, "ThresholdSelect": ThresholdSelect, "Threshold": Threshold, "SelectCourse": SelectCourse },
        success: function (result) {
            var date = [];
            var count = [];
            var amount = [];
            $.each(result, function (i, p) {
                date[i] = p['date'];
                count[i] = p['count'];
                amount[i] = p['amount'];
            });
            SpecificEventContextOverviewAmount = amount[0];
            myChartSpecificEventContextOverview.hideLoading();
            var SpecificEventContextOverviewRelativeAmount = SpecificEventContextOverviewDiff * SpecificEventContextOverviewAmount / 100;
            // the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will determine which stage we are at when loading the data: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
            if (SpecificEventContextOverviewRelativeAmount <= 8.15) {
                myChartSpecificEventContextOverview.setOption({
                    title: {
                        text: EventContext
                    },
                    xAxis: {
                        data: date,
                        axisLabel: {
                            show: true,
                            interval: 'auto',
                            rotate: 0
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (SpecificEventContextOverviewRelativeAmount <= 16.3) {
                myChartSpecificEventContextOverview.setOption({
                    title: {
                        text: EventContext
                    },
                    xAxis: {
                        data: date,
                        axisLabel: {
                            show: true,
                            interval: 0,
                            rotate: 40
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (SpecificEventContextOverviewRelativeAmount <= 48.9) {
                myChartSpecificEventContextOverview.setOption({
                    title: {
                        text: EventContext
                    },
                    xAxis: {
                        data: date,
                        axisLabel: {
                            show: true,
                            interval: 0,
                            rotate: 90
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            } else if (SpecificEventContextOverviewRelativeAmount > 48.9) {
                myChartSpecificEventContextOverview.setOption({
                    title: {
                        text: EventContext
                    },
                    xAxis: {
                        data: date,
                        axisLabel: {
                            show: false
                        }
                    },
                    series: [{
                        name: 'Amount of activities',
                        data: count
                    }]
                });
            }
        }//success
    });//ajax
}//function specificEventContextOverviewUpdate()

//after user sets event context, presentation order/period/threshold, update the chart "SpecificEventContextOverview"
$(document).ready(function () {
    $('#SpecificEventContextOverviewPresentationOrder').change(function () {
        specificEventContextOverviewUpdate();
    })
    $('#SpecificEventContextOverviewSetPeriod').click(function () {
        specificEventContextOverviewUpdate();
    })
    $('#SpecificEventContextOverviewSetThreshold').click(function () {
        specificEventContextOverviewUpdate();
    })
    $('#SpecificEventContextOverviewSetEventContext').click(function () {
        specificEventContextOverviewUpdate();
    })

    //export the data in CSV format according to the configuration options that user chooses, also these configuration options are included in the file name
    $('#SpecificEventContextOverviewCSV').click(function () {
        var EventContext = $('#SpecificEventContextOverviewEventContext').val();
        var SelectCourse = $("#SelectCourse option:selected").attr("id");
        var SelectYear = $("#SelectYear option:selected").attr("id");
        var SelectSemester = $("#SelectSemester option:selected").attr("id");
        var from = $("#SpecificEventContextOverviewFrom").val();
        var to = $("#SpecificEventContextOverviewTo").val();
        var order = $('#SpecificEventContextOverviewPresentationOrder').val();
        var ThresholdSelect = $('#SpecificEventContextOverviewThresholdSelect').val();
        var Threshold = $('#SpecificEventContextOverviewThreshold').val();
        // encode special characters (colon, space, comma)
        EventContext = EventContext.replace(/\:/g, "%3A");
        EventContext = EventContext.replace(/\ /g, "%20");
        EventContext = EventContext.replace(/\,/g, "%2C");
        // dynamically concatenate url
        var url = '../../dashboard/controller.php?type=specificEventContextOverviewCSV&EventContext=' + EventContext + '&from=' + from + '&to=' + to + '&order=' + order + '&ThresholdSelect=' + ThresholdSelect + '&Threshold=' + Threshold + '&SelectCourse=' + SelectCourse + '&SelectYear=' + SelectYear + '&SelectSemester=' + SelectSemester;
        window.location.href = url;
    })
})// $(document).ready

// the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will dynamically determine which stage we are at when the left position and right position of the slider are changed: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
myChartSpecificEventContextOverview.on('datazoom', function (params) {
    var diff = params.end - params.start;//difference between left and right position of the slider
    SpecificEventContextOverviewDiff = diff;
    var SpecificEventContextOverviewRelativeAmount = SpecificEventContextOverviewDiff * SpecificEventContextOverviewAmount / 100;
    if (SpecificEventContextOverviewRelativeAmount < 8.15) {
        myChartSpecificEventContextOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 'auto',
                    rotate: 0
                }

            }
        });
    } else if (SpecificEventContextOverviewRelativeAmount < 16.3) {
        myChartSpecificEventContextOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 0,
                    rotate: 40
                }

            }
        });
    } else if (SpecificEventContextOverviewRelativeAmount < 48.9) {
        myChartSpecificEventContextOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: true,
                    interval: 0,
                    rotate: 90
                }

            }
        });
    } else if (SpecificEventContextOverviewRelativeAmount >= 48.9) {
        myChartSpecificEventContextOverview.setOption({
            xAxis: {
                axisLabel: {
                    show: false
                }

            }
        });
    }
});

