<?php
require_once './service_class.php';

$service = new Service;
$type = $_GET['type'];
switch ($type) {
    case 'loadCourse':
		{
			$response = $service->loadCourse();
			echo $response;
		}
        break;
	case 'loadYear':
		{
			//the course user chooses
			$SelectCourseId = $_GET['SelectCourseId'];

			$response = $service->loadYear($SelectCourseId);
			echo $response;
		}
		break;
	case 'loadSemester':
		{
			//the course and year user chooses
			$SelectCourseId = $_GET['SelectCourseId'];
			$SelectYearId = $_GET['SelectYearId'];

			$response = $service->loadSemester($SelectCourseId, $SelectYearId);
			echo $response;
		}
		break;
	case 'loadAssignment':
		{
			//the course, year, semester user chooses
			$SelectCourseId = $_GET['SelectCourseId'];
			$SelectYearId = $_GET['SelectYearId'];
			$SelectSemesterId= $_GET['SelectSemesterId'];

			$response = $service->loadAssignment($SelectCourseId, $SelectYearId, $SelectSemesterId);
			echo $response;
		}
		break;
	case 'submissionTimeDistribution5Days':
		{
			//the course, year, semester, assignment user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];
			$SelectAssignment = $_GET['SelectAssignment'];

			$response = $service->submissionTimeDistribution5Days($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment);
			echo $response;
		}
		break;
	case 'submissionTimeDistribution5DaysStudent':
		{
			//the course, year, semester, assignment user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];
			$SelectAssignment = $_GET['SelectAssignment'];

			$response = $service->submissionTimeDistribution5DaysStudent($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment);
			echo $response;
		}
		break;
	case 'submissionTimeDistribution96Hours':
		{
			//the course, year, semester, assignment user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];
			$SelectAssignment = $_GET['SelectAssignment'];

			$response = $service->submissionTimeDistribution96Hours($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment);
			echo $response;
		}
		break;
	case 'submissionTimeDistribution96HoursStudent':
		{
			//the course, year, semester, assignment user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];
			$SelectAssignment = $_GET['SelectAssignment'];

			$response = $service->submissionTimeDistribution96HoursStudent($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment);
			echo $response;
		}
		break;
	case 'submissionTimeDistributionSubmission':
		{
			//the course, year, semester, assignment user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];
			$SelectAssignment = $_GET['SelectAssignment'];

			$response = $service->submissionTimeDistributionSubmission($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment);
			echo $response;
		}
		break;
	case 'submissionTimeDistributionStudent':
		{
			//the course, year, semester, assignment user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];
			$SelectAssignment = $_GET['SelectAssignment'];

			$response = $service->submissionTimeDistributionStudent($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment);
			echo $response;
		}
		break;
	case 'firstSubmissionTimeDistribution':
		{
			//the course, year, semester, assignment user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];
			$SelectAssignment = $_GET['SelectAssignment'];

			$response = $service->firstSubmissionTimeDistribution($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment);
			echo $response;
		}
		break;
	case 'lastSubmissionTimeDistribution':
		{
			//the course, year, semester, assignment user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];
			$SelectAssignment = $_GET['SelectAssignment'];

			$response = $service->lastSubmissionTimeDistribution($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment);
			echo $response;
		}
		break;
	case 'numberOfSubmissionsOfEachStudent':
		{
			//the course, year, semester, assignment, presentation order user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];
			$SelectAssignment = $_GET['SelectAssignment'];
			$order = intval($_GET['order']);

			$response = $service->numberOfSubmissionsOfEachStudent($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment, $order);
			echo $response;
		}
		break;
	case 'markDistribution':
		{
			//the course, year, semester, assignment, configuration option user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];
			$SelectAssignment = $_GET['SelectAssignment'];
			//1: by GPA 2: by 10% step
			$MarkDistributionSelect= $_GET['MarkDistributionSelect'];

			$response = $service->markDistribution($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment, $MarkDistributionSelect);
			echo $response;
		}
		break;
	case 'studentActivitiesOverview':
		{
			//the course, start day, end day, presentation order, threshold user chooses
			$CourseName=$_GET['CourseName'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->studentActivitiesOverview($CourseName, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
}
?>