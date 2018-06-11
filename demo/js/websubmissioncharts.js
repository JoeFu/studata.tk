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

})

$("#confirm_button").click(function () {
    submissionTimeDistribution5Days();
    submissionTimeDistribution5DaysStudent();
    submissionTimeDistribution96Hours();
    submissionTimeDistribution96HoursStudent();
    submissionTimeDistributionSubmission();
    submissionTimeDistributionStudent();
    firstSubmissionTimeDistribution();
    lastSubmissionTimeDistribution();
    markDistributionUpdate();
    submissionTimesOfEachStudentUpdate();
})

var myChartSubmissionTimeDistribution5Days = echarts.init(document.getElementById('SubmissionTimeDistribution5Days'));
// configuration and data of chart
var option = {
    title: {
        // text: 'Submission Time Distribution 5 Days (Submissions)'
    },
    tooltip: {},
    xAxis: {
        data: []
    },
    yAxis: {
        name: 'Number of submissions',
    },
    dataZoom: [
        {   // dataZoom component controls x-axis by default
            type: 'slider',
            start: 0, // left
            end: 100  // right
        }
    ],
    series: [
        {
            name: 'Number of submissions',
            type: 'bar',
            data: []
        }
    ],
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
myChartSubmissionTimeDistribution5Days.setOption(option);


var myChartSubmissionTimeDistribution5DaysStudent = echarts.init(document.getElementById('SubmissionTimeDistribution5DaysStudent'));
// configuration and data of chart
var option = {
	title: {
		// text: 'Submission Time Distribution 5 Days (Students)'
	},
	tooltip: {},
	xAxis: {
		data: []
	},
	yAxis: {
		name: 'Number of students',
	},
	dataZoom: [
		{   // dataZoom component controls x-axis by default
			type: 'slider', 
			start: 0, // left
			end: 100  // right
		}
	],
	series: [
		{
			name: 'Number of students',
			type: 'bar',
			data: []
		}
	],
	toolbox: {
		show: true,
		feature: {
			dataView: {readOnly: false},
			magicType: {type: ['line', 'bar']},
			restore: {},
			saveAsImage: {}
		}
	}
};
myChartSubmissionTimeDistribution5DaysStudent.setOption(option);

var myChartSubmissionTimeDistribution96Hours = echarts.init(document.getElementById('SubmissionTimeDistribution96Hours'));
// configuration and data of chart
var option = {
	title: {
		// text: 'Submission Time Distribution 96 Hours (Submissions)'
	},
	tooltip: {},
	xAxis: {
		data: []
	},
	yAxis: {
		name: 'Number of submissions',
	},
	dataZoom: [
		{   // dataZoom component controls x-axis by default
			type: 'slider', 
			start: 0, // left
			end: 100  // right
		}
	],
	series: [
		{
			name: 'Number of submissions',
			type: 'bar',
			data: []
		}
	],
	toolbox: {
		show: true,
		feature: {
			dataView: {readOnly: false},
			magicType: {type: ['line', 'bar']},
			restore: {},
			saveAsImage: {}
		}
	}
};
myChartSubmissionTimeDistribution96Hours.setOption(option);

var myChartSubmissionTimeDistribution96HoursStudent = echarts.init(document.getElementById('SubmissionTimeDistribution96HoursStudent'));
// configuration and data of chart
var option = {
	title: {
		// text: 'Submission Time Distribution 96 Hours (Students)'
	},
	tooltip: {},
	xAxis: {
		data: []
	},
	yAxis: {
		name: 'Number of students',
	},
	dataZoom: [
		{   // dataZoom component controls x-axis by default
			type: 'slider', 
			start: 0, // left
			end: 100  // right
		}
	],
	series: [
		{
			name: 'Number of students',
			type: 'bar',
			data: []
		}
	],
	toolbox: {
		show: true,
		feature: {
			dataView: {readOnly: false},
			magicType: {type: ['line', 'bar']},
			restore: {},
			saveAsImage: {}
		}
	}
};
myChartSubmissionTimeDistribution96HoursStudent.setOption(option);

var myChartSubmissionTimeDistributionSubmission= echarts.init(document.getElementById('SubmissionTimeDistributionSubmission'));
// configuration and data of chart
var option = {
	title: {
		// text: 'Submission Time Distribution (Submissions)'
	},
	tooltip: {},
	xAxis: {
		data: []
	},
	yAxis: {
		name: 'Number of submissions',
	},
	dataZoom: [
		{   // dataZoom component controls x-axis by default
			type: 'slider', 
			start: 0, // left
			end: 100  // right
		}
	],
	series: [
		{
			name: 'Number of submissions',
			type: 'bar',
			data: []
		}
	],
	toolbox: {
		show: true,
		feature: {
			dataView: {readOnly: false},
			magicType: {type: ['line', 'bar']},
			restore: {},
			saveAsImage: {}
		}
	}
};

myChartSubmissionTimeDistributionSubmission.setOption(option);

var myChartSubmissionTimeDistributionStudent= echarts.init(document.getElementById('SubmissionTimeDistributionStudent'));
// configuration and data of chart
var option = {
	title: {
		// text: 'Submission Time Distribution (Students)'
	},
	tooltip: {},
	xAxis: {
		data: []
	},
	yAxis: {
		name: 'Number of students',
	},
	dataZoom: [
		{   // dataZoom component controls x-axis by default
			type: 'slider', 
			start: 0, // left
			end: 100  // right
		}
	],
	series: [
		{
			name: 'Number of students',
			type: 'bar',
			data: []
		}
	],
	toolbox: {
		show: true,
		feature: {
			dataView: {readOnly: false},
			magicType: {type: ['line', 'bar']},
			restore: {},
			saveAsImage: {}
		}
	}
};
myChartSubmissionTimeDistributionStudent.setOption(option);

var myChartFirstSubmissionTimeDistribution= echarts.init(document.getElementById('FirstSubmissionTimeDistribution'));
// configuration and data of chart
var option = {
	title: {
		// text: 'First Submission Time Distribution'
	},
	tooltip: {},
	xAxis: {
		data: []
	},
	yAxis: {
		name: 'Number of submissions',
	},
	dataZoom: [
		{   // dataZoom component controls x-axis by default
			type: 'slider', 
			start: 0, // left
			end: 100  // right
		}
	],
	series: [
		{
			name: 'Number of submissions',
			type: 'bar',
			data: []
		}
	],
	toolbox: {
		show: true,
		feature: {
			dataView: {readOnly: false},
			magicType: {type: ['line', 'bar']},
			restore: {},
			saveAsImage: {}
		}
	}
};
myChartFirstSubmissionTimeDistribution.setOption(option);

var myChartLastSubmissionTimeDistribution= echarts.init(document.getElementById('LastSubmissionTimeDistribution'));
// configuration and data of chart
var option = {
	title: {
		// text: 'Last Submission Time Distribution'
	},
	tooltip: {},
	xAxis: {
		data: []
	},
	yAxis: {
		name: 'Number of submissions',
	},
	dataZoom: [
		{   // dataZoom component controls x-axis by default
			type: 'slider', 
			start: 0, // left
			end: 100  // right
		}
	],
	series: [
		{
			name: 'Number of submissions',
			type: 'bar',
			data: []
		}
	],
	toolbox: {
		show: true,
		feature: {
			dataView: {readOnly: false},
			magicType: {type: ['line', 'bar']},
			restore: {},
			saveAsImage: {}
		}
	}
};
myChartLastSubmissionTimeDistribution.setOption(option);

var myChartSubmissionTimesOfEachStudent = echarts.init(document.getElementById('SubmissionTimesOfEachStudent'));
// set configuration items and data
var option = {
	title: {
		// text: 'Number Of Submissions Of Each Student'
	},
	tooltip: {},
	xAxis: {
		name: 'User',
		data: []
	},
	yAxis: {
		name: 'Number of submissions'
	},
	grid: {
		x: 100,
		y2: 100
	},
	dataZoom: [
		{   //dataZoom component controls x-axis by default
			type: 'slider', 
			start: 0, // left position 0%
			end: 100  // right position 100%
		}
	],
	series: [
		{
			name: 'Number of submissions',
			type: 'bar',
			data: []
		}
	],
	toolbox: {
		show: true,
		feature: {
			dataView: {readOnly: false},
			magicType: {type: ['line', 'bar']},
			restore: {},
			saveAsImage: {}
		}
	}
};
// display chart using the configuration items and data set
myChartSubmissionTimesOfEachStudent.setOption(option);

var myChartMarkDistribution = echarts.init(document.getElementById('MarkDistribution'));

// configure items and data
var option = {
	title: {
		// text: 'Mark Distribution'
	},
	tooltip: {},
	xAxis: {
		data: []
	},
	yAxis: {
		name: 'Number of students'
	},
	dataZoom: [
		{   //dataZoom component controls x-axis by default
			type: 'slider', 
			start: 0,      // left position 0% 
			end: 100         // right position 100% 
		}
	],
	series: [{
		name: 'Mark',
		type: 'bar',
		data: []
	}],
	toolbox: {
		show: true,
		feature: {
			dataView: {readOnly: false},
			magicType: {type: ['line', 'bar']},
			restore: {},
			saveAsImage: {}
		}
	}
};

// display chart using the configuration items and data set
myChartMarkDistribution.setOption(option);


function submissionTimeDistribution5Days() {
    var SelectCourse = $("#SelectCourse option:selected").attr("id");
    var SelectYear = $("#SelectYear option:selected").attr("id");
    var SelectSemester = $("#SelectSemester option:selected").attr("id");
    var SelectAssignment = $("#SelectAssignment option:selected").attr("id");
    console.log(SelectAssignment);
    $.ajax({
        type: "get",
        async: true,
        url: "../../dashboard/controller.php?type=submissionTimeDistribution5Days",
        data: { "SelectCourse": SelectCourse, "SelectYear": SelectYear, "SelectSemester": SelectSemester, "SelectAssignment": SelectAssignment },
        dataType: "json",
        success: function (result) {
            var days = [];
            var count = [];
            var dueDate = [];
            $.each(result, function (i, p) {
                days[i] = p['days'];
                count[i] = p['count'];
                dueDate[i] = p['dueDate'];
            });
            myChartSubmissionTimeDistribution5Days.hideLoading();
            myChartSubmissionTimeDistribution5Days.setOption({
                xAxis: {
                    axisLabel: {
                        interval: 'auto',
                        rotate: 0
                    },
                    name: 'Day',
                    data: days,
                },
                series: [
                    {
                        name: 'Number of submissions',
                        data: count,
                        markArea: {
                            data: [
                                [{
                                    name: 'Due day',
                                    xAxis: 5
                                }, {
                                    xAxis: 5
                                }]
                            ]
                        },
                        markLine: {
                            label: {
                                normal: {
                                    show: false,
                                }
                            },
                            lineStyle: {
                                normal: {
                                    type: 'solid',
                                    color: 'blue'
                                }
                            },
                            data: [
                                {
                                    xAxis: 5
                                }
                            ]
                        }//markLine
                    }
                ]
            });
        }
    })//ajax
}

function submissionTimeDistribution5DaysStudent(){
	var SelectCourse=$("#SelectCourse option:selected").attr("id");
	var SelectYear=$("#SelectYear option:selected").attr("id");
	var SelectSemester=$("#SelectSemester option:selected").attr("id");
	var SelectAssignment=$("#SelectAssignment option:selected").attr("id");
	$.ajax({
		type: "get",
		async: true, 
		url: "../../dashboard/controller.php?type=submissionTimeDistribution5DaysStudent",
		data: {"SelectCourse":SelectCourse,"SelectYear":SelectYear,"SelectSemester":SelectSemester,"SelectAssignment":SelectAssignment},
		dataType: "json", 
		success: function(result) {
			var days = [];
			var count = [];
			$.each(result,function(i,p){
				days[i]=p['days'];
				count[i]=p['count'];
			});
			myChartSubmissionTimeDistribution5DaysStudent.hideLoading();
			myChartSubmissionTimeDistribution5DaysStudent.setOption({
				xAxis: {
					axisLabel :{
						interval: 'auto', 
						rotate:0
					},
					name: 'Day',
					data: days,
				},
				series: [
					{
						name: 'Number of students',
						data: count,
						markArea: {
							data: [ 
								[{
									name: 'Due day',
									xAxis: 5
								}, {
									xAxis: 5
								}]
							]
						},
						markLine : {
							label:{
								normal:{
									show:false,
								}
							},
							lineStyle: {
								normal: {
									type: 'solid',
									color: 'blue'
								}
							},
							data : [
								{ 
									xAxis: 5 
								}
							]
						}//markLine
					}
				]
			});
		}
	})//ajax
}

function submissionTimeDistribution96Hours(){
	var SelectCourse=$("#SelectCourse option:selected").attr("id");
	var SelectYear=$("#SelectYear option:selected").attr("id");
	var SelectSemester=$("#SelectSemester option:selected").attr("id");
	var SelectAssignment=$("#SelectAssignment option:selected").attr("id");

	$.ajax({
		type: "get",
		async: true, 
		url: "../../dashboard/controller.php?type=submissionTimeDistribution96Hours",
		data: {"SelectCourse":SelectCourse,"SelectYear":SelectYear,"SelectSemester":SelectSemester,"SelectAssignment":SelectAssignment},
		dataType: "json", 
		success: function(result) {
			var days = [];
			var count = [];
			$.each(result,function(i,p){
				days[i]=p['days'];
				count[i]=p['count'];
			});
			myChartSubmissionTimeDistribution96Hours.hideLoading();
			myChartSubmissionTimeDistribution96Hours.setOption({
				xAxis: {
					axisLabel :{
						interval: 'auto', 
						rotate:0
					},
					name: 'Hour',
					data: days,
				},
				series: [
					{
						name: 'Number of submissions',
						data: count,
						markArea: {
							data: [ 
								[{
									name: 'Due hour',
									xAxis: 96
								}, {
									xAxis: 96
								}]
							]
						},
						markLine : {
							label:{
								normal:{
									show:false,
								}
							},
							lineStyle: {
								normal: {
									type: 'solid',
									color: 'blue'
								}
							},
							data : [
								{ 
									xAxis: 96 
								}
							]
						}//markLine
					}
				]
			});
		}
	})//ajax
}

function submissionTimeDistribution96HoursStudent(){
	var SelectCourse=$("#SelectCourse option:selected").attr("id");
	var SelectYear=$("#SelectYear option:selected").attr("id");
	var SelectSemester=$("#SelectSemester option:selected").attr("id");
	var SelectAssignment=$("#SelectAssignment option:selected").attr("id");

	$.ajax({
		type: "get",
		async: true, 
		url: "../../dashboard/controller.php?type=submissionTimeDistribution96HoursStudent",
		data: {"SelectCourse":SelectCourse,"SelectYear":SelectYear,"SelectSemester":SelectSemester,"SelectAssignment":SelectAssignment},
		dataType: "json", 
		success: function(result) {
			var days = [];
			var count = [];
			$.each(result,function(i,p){
				days[i]=p['days'];
				count[i]=p['count'];
			});
			myChartSubmissionTimeDistribution96HoursStudent.hideLoading();
			myChartSubmissionTimeDistribution96HoursStudent.setOption({
				xAxis: {
					axisLabel :{
						interval: 'auto', 
						rotate:0
					},
					name: 'Hour',
					data: days,
				},
				series: [
					{
						name: 'Number of students',
						data: count,
						markArea: {
							data: [ 
								[{
									name: 'Due hour',
									xAxis: 96
								}, {
									xAxis: 96
								}]
							]
						},
						markLine : {
							label:{
								normal:{
									show:false,
								}
							},
							lineStyle: {
								normal: {
									type: 'solid',
									color: 'blue'
								}
							},
							data : [
								{ 
									xAxis: 96 
								}
							]
						}//markLine
					}
				]
			});
		}
	})//ajax
}

function submissionTimeDistributionSubmission(){
	var SelectCourse=$("#SelectCourse option:selected").attr("id");
	var SelectYear=$("#SelectYear option:selected").attr("id");
	var SelectSemester=$("#SelectSemester option:selected").attr("id");
	var SelectAssignment=$("#SelectAssignment option:selected").attr("id");

	$.ajax({
		type: "get",
		async: true, 
		url: "../../dashboard/controller.php?type=submissionTimeDistributionSubmission",
		data: {"SelectCourse":SelectCourse,"SelectYear":SelectYear,"SelectSemester":SelectSemester,"SelectAssignment":SelectAssignment},
		dataType: "json", 
		success: function(result) {
			var days = [];
			var count = [];
			var dueDay= [];
			$.each(result,function(i,p){
				days[i]=p['days'];
				count[i]=p['count'];
				dueDay[i]=p['dueDay'];
			});
			myChartSubmissionTimeDistributionSubmission.hideLoading();
			myChartSubmissionTimeDistributionSubmission.setOption({
				xAxis: {
					axisLabel :{
						interval: 'auto', 
						rotate:0
					},
					name: 'Day',
					data: days,
				},
				series: [
					{
						name: 'Number of submissions',
						data: count,
						markArea: {
							data: [ 
								[
									{
										name: 'Start day',
										xAxis: 0
									}, {
										xAxis: 0
									}
								],
								[
									{
										name: 'Due day',
										xAxis: dueDay[0]
									}, {
										xAxis: dueDay[0]
									}
								]
							]
						},
						markLine : {
							label:{
								normal:{
									show:false
								}
							},
							lineStyle: {
								normal: {
									type: 'solid',
									color: 'blue'
								}
							},
							data : [
								{ xAxis: 0 },
								{ xAxis: dueDay[0] }
							]
						}//markLine
					}
				]
			});
		}
	})//ajax
}

function submissionTimeDistributionStudent(){
	var SelectCourse=$("#SelectCourse option:selected").attr("id");
	var SelectYear=$("#SelectYear option:selected").attr("id");
	var SelectSemester=$("#SelectSemester option:selected").attr("id");
	var SelectAssignment=$("#SelectAssignment option:selected").attr("id");

	$.ajax({
		type: "get",
		async: true, 
		url: "../../dashboard/controller.php?type=submissionTimeDistributionStudent",
		data: {"SelectCourse":SelectCourse,"SelectYear":SelectYear,"SelectSemester":SelectSemester,"SelectAssignment":SelectAssignment},
		dataType: "json", 
		success: function(result) {
			var days = [];
			var count = [];
			var dueDay= [];
			$.each(result,function(i,p){
				days[i]=p['days'];
				count[i]=p['count'];
				dueDay[i]=p['dueDay'];
			});
			myChartSubmissionTimeDistributionStudent.hideLoading();
			myChartSubmissionTimeDistributionStudent.setOption({
				xAxis: {
					axisLabel :{
						interval: 'auto', 
						rotate:0
					},
					name: 'Day',
					data: days,
				},
				series: [
					{
						name: 'Number of students',
						data: count,
						markArea: {
							data: [ 
								[
									{
										name: 'Start day',
										xAxis: 0
									}, {
										xAxis: 0
									}
								],
								[
									{
										name: 'Due day',
										xAxis: dueDay[0]
									}, {
										xAxis: dueDay[0]
									}
								]
							]
						},
						markLine : {
							label:{
								normal:{
									show:false
								}
							},
							lineStyle: {
								normal: {
									type: 'solid',
									color: 'blue'
								}
							},
							data : [
								{ xAxis: 0 },
								{ xAxis: dueDay[0] }
							]
						}//markLine
					}
				]
			});
		}
	})//ajax
}

function firstSubmissionTimeDistribution(){
	var SelectCourse=$("#SelectCourse option:selected").attr("id");
	var SelectYear=$("#SelectYear option:selected").attr("id");
	var SelectSemester=$("#SelectSemester option:selected").attr("id");
	var SelectAssignment=$("#SelectAssignment option:selected").attr("id");

	$.ajax({
		type: "get",
		async: true, 
		url: "../../dashboard/controller.php?type=firstSubmissionTimeDistribution",
		data: {"SelectCourse":SelectCourse,"SelectYear":SelectYear,"SelectSemester":SelectSemester,"SelectAssignment":SelectAssignment},
		dataType: "json", 
		success: function(result) {
			var days = [];
			var count = [];
			var dueDay= [];
			$.each(result,function(i,p){
				days[i]=p['days'];
				count[i]=p['count'];
				dueDay[i]=p['dueDay'];
			});
			myChartFirstSubmissionTimeDistribution.hideLoading();
			myChartFirstSubmissionTimeDistribution.setOption({
				xAxis: {
					axisLabel :{
						interval: 'auto', 
						rotate:0
					},
					name: 'Day',
					data: days,
				},
				series: [
					{
						name: 'Number of submissions',
						data: count,
						markArea: {
							data: [ 
								[
									{
										name: 'Start day',
										xAxis: 0
									}, {
										xAxis: 0
									}
								],
								[
									{
										name: 'Due day',
										xAxis: dueDay[0]
									}, {
										xAxis: dueDay[0]
									}
								]
							]
						},
						markLine : {
							label:{
								normal:{
									show:false
								}
							},
							lineStyle: {
								normal: {
									type: 'solid',
									color: 'blue'
								}
							},
							data : [
								{ xAxis: 0 },
								{ xAxis: dueDay[0] }
							]
						}//markLine
					}
				]
			});
		}
	})//ajax
}

function lastSubmissionTimeDistribution(){
	var SelectCourse=$("#SelectCourse option:selected").attr("id");
	var SelectYear=$("#SelectYear option:selected").attr("id");
	var SelectSemester=$("#SelectSemester option:selected").attr("id");
	var SelectAssignment=$("#SelectAssignment option:selected").attr("id");

	$.ajax({
		type: "get",
		async: true, 
		url: "../../dashboard/controller.php?type=lastSubmissionTimeDistribution",
		data: {"SelectCourse":SelectCourse,"SelectYear":SelectYear,"SelectSemester":SelectSemester,"SelectAssignment":SelectAssignment},
		dataType: "json", 
		success: function(result) {
			var days = [];
			var count = [];
			var dueDay= [];
			$.each(result,function(i,p){
				days[i]=p['days'];
				count[i]=p['count'];
				dueDay[i]=p['dueDay'];
			});
			myChartLastSubmissionTimeDistribution.hideLoading();
			myChartLastSubmissionTimeDistribution.setOption({
				xAxis: {
					axisLabel :{
						interval: 'auto', 
						rotate:0
					},
					name: 'Day',
					data: days,
				},
				series: [
					{
						name: 'Number of submissions',
						data: count,
						markArea: {
							data: [ 
								[
									{
										name: 'Start day',
										xAxis: 0
									}, {
										xAxis: 0
									}
								],
								[
									{
										name: 'Due day',
										xAxis: dueDay[0]
									}, {
										xAxis: dueDay[0]
									}
								]
							]
						},
						markLine : {
							label:{
								normal:{
									show:false
								}
							},
							lineStyle: {
								normal: {
									type: 'solid',
									color: 'blue'
								}
							},
							data : [
								{ xAxis: 0 },
								{ xAxis: dueDay[0] }
							]
						}//markLine
					}
				]
			});
		}
	})//ajax
}

var SubmissionTimesOfEachStudentAmount;//number of bars (number of records)
var SubmissionTimesOfEachStudentDiff = 100;

function submissionTimesOfEachStudentUpdate(){
	var order=$('#SubmissionTimesOfEachStudentSelect').val();
	var SelectCourse=$("#SelectCourse option:selected").attr("id");
	var SelectYear=$("#SelectYear option:selected").attr("id");
	var SelectSemester=$("#SelectSemester option:selected").attr("id");
	var SelectAssignment=$("#SelectAssignment option:selected").attr("id");

	$.ajax({
		type: "get",
		async: true, //asynchronous
		url: "../../dashboard/controller.php?type=numberOfSubmissionsOfEachStudent",
		data: {"SelectCourse":SelectCourse,"SelectYear":SelectYear,"SelectSemester":SelectSemester,"SelectAssignment":SelectAssignment,"order":order},
		dataType: "json", //return data in JSON format
		success: function(result) {
			var FKParentId = [];
			var count = [];
			var amount = [];
			$.each(result,function(i,p){
				FKParentId[i]=p['FKParentId'];
				count[i]=p['count'];
				amount[i] = p['amount'];
			});
			SubmissionTimesOfEachStudentAmount = amount[0];
			myChartSubmissionTimesOfEachStudent.hideLoading();
			var SubmissionTimesOfEachStudentRelativeAmount = SubmissionTimesOfEachStudentDiff * SubmissionTimesOfEachStudentAmount / 100;
			// the purpose of the following code is to solve the x-label issue to ensure the accuracy and correctness of information, it will determine which stage we are at when loading the data: at the first stage, display no x-label (e-charts display some of the labels by default because there is not enough space to accommodate all the x-labels, this will provide misleading information); at the second stage, display all x-labels at a 90 degree; at the third stage, display all x-labels at a 40 degree; at the last stage, display all x-labels normally (at a 0 degree).
			if (SubmissionTimesOfEachStudentRelativeAmount <= 8.15) {
				myChartSubmissionTimesOfEachStudent.setOption({
					xAxis: {
						data: FKParentId,
						axisLabel: {
							show: true,
							interval: 'auto',
							rotate: 0
						}
					},
					series: [{
						name: 'Number of submissions',
						data: count
					}]
				});
			} else if (SubmissionTimesOfEachStudentRelativeAmount <= 16.3) {
				myChartSubmissionTimesOfEachStudent.setOption({
					xAxis: {
						data: FKParentId,
						axisLabel: {
							show: true,
							interval: 0,
							rotate: 40
						}
					},
					series: [{
						name: 'Number of submissions',
						data: count
					}]
				});
			} else if (SubmissionTimesOfEachStudentRelativeAmount <= 48.9) {
				myChartSubmissionTimesOfEachStudent.setOption({
					xAxis: {
						data: FKParentId,
						axisLabel: {
							show: true,
							interval: 0,
							rotate: 90
						}
					},
					series: [{
						name: 'Number of submissions',
						data: count
					}]
				});
			} else if (SubmissionTimesOfEachStudentRelativeAmount > 48.9) {
				myChartSubmissionTimesOfEachStudent.setOption({
					xAxis: {
						data: FKParentId,
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
$(document).ready(function(){ 
	$('#SubmissionTimesOfEachStudentSelect').change(function(){ 
		submissionTimesOfEachStudentUpdate();
	}) 
})
myChartSubmissionTimesOfEachStudent.on('datazoom', function (params) {
	var diff = params.end - params.start;//difference between left and right position of the slider
	SubmissionTimesOfEachStudentDiff = diff;
	var SubmissionTimesOfEachStudentRelativeAmount = SubmissionTimesOfEachStudentDiff * SubmissionTimesOfEachStudentAmount / 100;
	if (SubmissionTimesOfEachStudentRelativeAmount <= 8.15) {
		myChartSubmissionTimesOfEachStudent.setOption({
			xAxis: {
				axisLabel: {
					show: true,
					interval: 'auto',
					rotate: 0
				}
			}
		});
	} else if (SubmissionTimesOfEachStudentRelativeAmount <= 16.3) {
		myChartSubmissionTimesOfEachStudent.setOption({
			xAxis: {
				axisLabel: {
					show: true,
					interval: 0,
					rotate: 40
				}
			}
		});
	} else if (SubmissionTimesOfEachStudentRelativeAmount <= 48.9) {
		myChartSubmissionTimesOfEachStudent.setOption({
			xAxis: {
				axisLabel: {
					show: true,
					interval: 0,
					rotate: 90
				}
			}
		});
	} else if (SubmissionTimesOfEachStudentRelativeAmount > 48.9) {
		myChartSubmissionTimesOfEachStudent.setOption({
			xAxis: {
				axisLabel: {
					show: false
				}
			}
		});
	}
});

function markDistributionUpdate(){
	var SelectCourse=$("#SelectCourse option:selected").attr("id");
	var SelectYear=$("#SelectYear option:selected").attr("id");
	var SelectSemester=$("#SelectSemester option:selected").attr("id");
	var SelectAssignment=$("#SelectAssignment option:selected").attr("id");
	var MarkDistributionSelect=$('#MarkDistributionSelect').val();

	$.ajax({
		type: "get",
		async: true, //asynchronous
		url: "../../dashboard/controller.php?type=markDistribution",
		data: {"SelectCourse":SelectCourse,"SelectYear":SelectYear,"SelectSemester":SelectSemester,"SelectAssignment":SelectAssignment,"MarkDistributionSelect":MarkDistributionSelect},
		dataType: "json", //return data in JSON format
		success: function(result) {
			var grade = [];
			var count = [];
			$.each(result,function(i,p){
				grade[i]=p['grade'];
				count[i]=p['count'];
			});
			myChartMarkDistribution.hideLoading();
			myChartMarkDistribution.setOption({
				xAxis: {
					axisLabel :{
						interval: 'auto', 
						rotate:0
					},
					name: 'Mark',
					data: grade
				},
				series: [{
					name: 'Number of students',
					data: count
				}]
			});
		}
	});//ajax
}

//after user chooses configuration option for Mark Distribution Chart, update the Mark Distribution Chart
$(document).ready(function(){ 
	$('#MarkDistributionSelect').change(function(){ 
		markDistributionUpdate();
	}) 
}) 