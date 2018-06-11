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
	case 'getAssignmentInformation':
		{
			//the course, year, semester user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];

			$response = $service->getAssignmentInformation($SelectCourse, $SelectYear, $SelectSemester);
			echo $response;
		}
		break;
	case 'getAssignmentStartAndDueDay':
		{
			//the course, year, semester user chooses
			$SelectCourse = $_GET['SelectCourse'];
			$SelectYear = $_GET['SelectYear'];
			$SelectSemester = $_GET['SelectSemester'];
			$SelectAssignment = $_GET['SelectAssignment'];

			$response = $service->getAssignmentStartAndDueDay($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment);
			echo $response;
		}
		break;
	case 'studentActivitiesOverview':
		{
			//the course, start day, end day, presentation order, threshold user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->studentActivitiesOverview($SelectCourse, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'studentActivitiesOverviewCSV':
		{
			//the course, year, semester, start day, end day, presentation order, threshold user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$SelectYear=$_GET['SelectYear'];
			$SelectSemester=$_GET['SelectSemester'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->studentActivitiesOverviewCSV($SelectCourse, $SelectYear, $SelectSemester, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'allActivitiesOverview':
		{
			//the course, start day, end day, presentation order, threshold user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->allActivitiesOverview($SelectCourse, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'allActivitiesOverviewCSV':
		{
			//the course, year, semester, start day, end day, presentation order, threshold user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$SelectYear=$_GET['SelectYear'];
			$SelectSemester=$_GET['SelectSemester'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->allActivitiesOverviewCSV($SelectCourse, $SelectYear, $SelectSemester, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'eventNamesOverview':
		{
			//the course, start day, end day, presentation order, threshold user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->eventNamesOverview($SelectCourse, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'eventNamesOverviewCSV':
		{
			//the course, year, semester, start day, end day, presentation order, threshold user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$SelectYear=$_GET['SelectYear'];
			$SelectSemester=$_GET['SelectSemester'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->eventNamesOverviewCSV($SelectCourse, $SelectYear, $SelectSemester, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'specificEventNameOverviewAutoComplete':
		{
			//the text user inputs
			$term = strtolower($_GET["term"]);
			
			//the course, start day, end day, threshold user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->specificEventNameOverviewAutoComplete($term, $SelectCourse, $from, $to, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'specificEventNameOverview':
		{
			//the event name, course, start day, end day, presentation order, threshold user chooses
			$EventName=$_GET['EventName'];
			$SelectCourse=$_GET['SelectCourse'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->specificEventNameOverview($EventName, $SelectCourse, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'specificEventNameOverviewCSV':
		{
			//the event name, course, year, semester, start day, end day, presentation order, threshold user chooses
			$EventName=$_GET['EventName'];
			$SelectCourse=$_GET['SelectCourse'];
			$SelectYear=$_GET['SelectYear'];
			$SelectSemester=$_GET['SelectSemester'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->specificEventNameOverviewCSV($EventName, $SelectCourse, $SelectYear, $SelectSemester, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'eventContextsOverview':
		{
			//the course, start day, end day, presentation order, threshold user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->eventContextsOverview($SelectCourse, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'eventContextsOverviewCSV':
		{
			//the course, year, semester, start day, end day, presentation order, threshold user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$SelectYear=$_GET['SelectYear'];
			$SelectSemester=$_GET['SelectSemester'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->eventContextsOverviewCSV($SelectCourse, $SelectYear, $SelectSemester, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'specificEventContextOverviewAutoComplete':
		{
			//the text user inputs
			$term = strtolower($_GET["term"]);
			
			//the course, start day, end day, threshold user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->specificEventContextOverviewAutoComplete($term, $SelectCourse, $from, $to, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'specificEventContextOverview':
		{
			//the event context, course, start day, end day, presentation order, threshold user chooses
			$EventContext=$_GET['EventContext'];
			$SelectCourse=$_GET['SelectCourse'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->specificEventContextOverview($EventContext, $SelectCourse, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'specificEventContextOverviewCSV':
		{
			//the event context, course, year, semester, start day, end day, presentation order, threshold user chooses
			$EventContext=$_GET['EventContext'];
			$SelectCourse=$_GET['SelectCourse'];
			$SelectYear=$_GET['SelectYear'];
			$SelectSemester=$_GET['SelectSemester'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$order = intval($_GET['order']);
			$ThresholdSelect = $_GET['ThresholdSelect'];
			$Threshold = $_GET['Threshold'];

			$response = $service->specificEventContextOverviewCSV($EventContext, $SelectCourse, $SelectYear, $SelectSemester, $from, $to, $order, $ThresholdSelect, $Threshold);
			echo $response;
		}
		break;
	case 'loadEventNameBasedOnCourseAndPeriod':
		{
			//the course, start day, end day user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$from = $_GET['from'];
			$to = $_GET['to'];

			$response = $service->loadEventNameBasedOnCourseAndPeriod($SelectCourse, $from, $to);
			echo $response;
		}
		break;
	case 'loadEventContextBasedOnCourseAndPeriod':
		{
			//the course, start day, end day user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$from = $_GET['from'];
			$to = $_GET['to'];

			$response = $service->loadEventContextBasedOnCourseAndPeriod($SelectCourse, $from, $to);
			echo $response;
		}
		break;
	case 'criticalQuestionOneEventName':
		{
			//the course, year, semester, assignment, start day, end day, event name user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$SelectYear=$_GET['SelectYear'];
			$SelectSemester=$_GET['SelectSemester'];
			$SelectAssignment=$_GET['SelectAssignment'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$event = $_GET['event'];

			$response = $service->criticalQuestionOneEventName($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment, $from, $to, $event);
			echo $response;
		}
		break;
	case 'criticalQuestionOneEventContext':
		{
			//the course, year, semester, assignment, start day, end day, event context user chooses
			$SelectCourse=$_GET['SelectCourse'];
			$SelectYear=$_GET['SelectYear'];
			$SelectSemester=$_GET['SelectSemester'];
			$SelectAssignment=$_GET['SelectAssignment'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			$event = $_GET['event'];

			$response = $service->criticalQuestionOneEventContext($SelectCourse, $SelectYear, $SelectSemester, $SelectAssignment, $from, $to, $event);
			echo $response;
		}
		break;
}
?>