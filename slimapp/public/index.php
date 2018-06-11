<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../config/Connection.php';
require '../src/routes/dataquery.php';

$app = new \Slim\App;
// Get event names
$app->get('/api/eventnames/{datasourcetype}', function(Request $request, Response $response){
	$datasourcetype = $request->getAttribute('datasourcetype');
	$sql = "SELECT distinct Name FROM event WHERE DataSourceType = $datasourcetype order by Name asc";
	try{
		// Get database object
		$connection = new Connection();
		// Connect
		$connection = $connection->connect();
		$stmt = $connection->query($sql);
		$eventnames = $stmt->fetchAll(PDO::FETCH_OBJ);
		$connectionn = null;
		echo json_encode($eventnames);
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}}';
	}
});

$app->get('/api/eventtypes', function(Request $request, Response $response){
	$sql = "SELECT Id, Name FROM eventtype order by Name asc";
	try{
		// Get database object
		$connection = new Connection();
		// Connect
		$connection = $connection->connect();
		$stmt = $connection->query($sql);
		$eventtypes = $stmt->fetchAll(PDO::FETCH_OBJ);
		$connectionn = null;
		echo json_encode($eventtypes);
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}}';
	}
});

$app->get('/api/components', function(Request $request, Response $response){
	$sql = "SELECT Id, Name FROM component order by Name asc";
	try{
		// Get database object
		$connection = new Connection();
		// Connect
		$connection = $connection->connect();
		$stmt = $connection->query($sql);
		$components = $stmt->fetchAll(PDO::FETCH_OBJ);
		$connectionn = null;
		echo json_encode($components);
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}}';
	}
});

$app->get('/api/users', function(Request $request, Response $response){
	$sql = "SELECT Id FROM user order by Id asc";
	try{
		// Get database object
		$connection = new Connection();
		// Connect
		$connection = $connection->connect();
		$stmt = $connection->query($sql);
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$connectionn = null;
		echo json_encode($users);
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}}';
	}
});

$app->get('/api/courses', function(Request $request, Response $response){
	$sql = "SELECT distinct CourseName FROM event order by CourseName asc";
	try{
		// Get database object
		$connection = new Connection();
		// Connect
		$connection = $connection->connect();
		$stmt = $connection->query($sql);
		$courses = $stmt->fetchAll(PDO::FETCH_OBJ);
		$connectionn = null;
		echo json_encode($courses);
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}}';
	}
});

$app->get('/api/schoolyears', function(Request $request, Response $response){
	$sql = "SELECT distinct SchoolYear FROM event order by SchoolYear asc";
	try{
		// Get database object
		$connection = new Connection();
		// Connect
		$connection = $connection->connect();
		$stmt = $connection->query($sql);
		$schoolyears = $stmt->fetchAll(PDO::FETCH_OBJ);
		$connectionn = null;
		echo json_encode($schoolyears);
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}}';
	}
});

$app->get('/api/semesters', function(Request $request, Response $response){
	$sql = "SELECT distinct Semester FROM event order by Semester asc";
	try{
		// Get database object
		$connection = new Connection();
		// Connect
		$connection = $connection->connect();
		$stmt = $connection->query($sql);
		$semesters = $stmt->fetchAll(PDO::FETCH_OBJ);
		$connectionn = null;
		echo json_encode($semesters);
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}}';
	}
});

$app->get('/api/assignments', function(Request $request, Response $response){
	$sql = "SELECT distinct AssignmentName FROM event order by AssignmentName asc";
	try{
		// Get database object
		$connection = new Connection();
		// Connect
		$connection = $connection->connect();
		$stmt = $connection->query($sql);
		$assignments = $stmt->fetchAll(PDO::FETCH_OBJ);
		$connectionn = null;
		echo json_encode($assignments);
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}}';
	}
});

$app->get('/api/events/search', function(Request $request, Response $response){
	$baseSql = "SELECT Name, Description, FKUserId, Grade, StartDate, DueDate, AssignmentName, CourseName, Semester, SchoolYear FROM event";
	//$parameters = $request->getAttribute('parameters');
	$parameters = $_GET['parameters'];
	$plist = explode("|", $parameters);
	$componentId = $plist[0];
	$eventName = $plist[1];
	$eventType = $plist[2];
	$fromStartDate = $plist[3];
	$toStartDate = $plist[4];
	$fromDueDate = $plist[5];
	$toDueDate = $plist[6];
	$user = $plist[7];
	$fromGrade = $plist[8];
	$toGrade = $plist[9];
	$assignment = $plist[10];
	$course = $plist[11];
	$schoolYear = $plist[12];
	$semester = $plist[13];
	$datasourcetype = $plist[14];
	
	$whereSql = " WHERE DataSourceType = $datasourcetype";
	$extraSql = "";
	if (!strictEmpty($componentId)){
		$extraSql = " AND FKComponentId = $componentId";
	}
	if (!strictEmpty($eventName)){
		$extraSql = $extraSql . " AND Name = " . "'$eventName'";
	}
	
	if (!strictEmpty($eventType)){
		$extraSql = $extraSql . " AND FKEventTypeId = " . "'$eventType'";
	}
	
	if ((''.$fromStartDate) != '' && (''.($toStartDate)) != ''){
		$extraSql = $extraSql . " AND StartDate >= STR_TO_DATE(" . "'$fromStartDate'" . ",'%Y/%m/%d') AND StartDate <= STR_TO_DATE(" . "'$toStartDate'" . ",'%Y/%m/%d')";
	}

	if ((''.$fromDueDate) != '' && (''.($toDueDate)) != ''){
		$extraSql = $extraSql . " AND DueDate >= STR_TO_DATE(" . "'$fromDueDate'" . ",'%Y/%m/%d') AND DueDate <= STR_TO_DATE(" . "'$toDueDate'" . ",'%Y/%m/%d')";
	}
	
	if ((''.$user) != ''){
		$extraSql = $extraSql . " AND FKUserId = " . "'$user'";
	}
	
	if (!strictEmpty($fromGrade) && !strictEmpty($toGrade)){
		$extraSql = $extraSql . " AND Grade >= "."'$fromGrade'"." AND Grade <= "."'$toGrade'";
	}
	
	if ((''.$assignment) != ''){
		$extraSql = $extraSql . " AND AssignmentName = " . "'$assignment'";
	}

	if ((''.$course) != ''){
		$extraSql = $extraSql . " AND CourseName = " . "'$course'";
	}
	
	if (!strictEmpty($schoolYear)){
		$extraSql = $extraSql . " AND SchoolYear = " . "'$schoolYear'";
	}

	if ((''.$semester) != ''){
		$extraSql = $extraSql . " AND Semester = " . "'$semester'";
	}

	$sql = $baseSql . $whereSql . $extraSql;
	
	try{
		// Get database object
		$connection = new Connection();
		// Connect
		$connection = $connection->connect();
		$stmt = $connection->query($sql);
		$events = $stmt->fetchAll(PDO::FETCH_OBJ);
		$connectionn = null;
		echo json_encode($events);
		//echo json_encode($sql);		
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}}';
	}
});



$app->post('/api/event/add', function(Request $request, Response $response){
	$id = $request->getParam('id');
	$name = $request->getParam('name');
	
	$sql = "SELECT distinct Name FROM event WHERE name = $name";
	try{
		// Get database object
		$connection = new Connection();
		// Connect
		$connection = $connection->connect();
		$stmt = $connection->query($sql);
		$eventnames = $stmt->fetchAll(PDO::FETCH_OBJ);
		$connectionn = null;
		echo json_encode($eventnames);
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}}';
	}
});

function strictEmpty($var) {
    // Delete this line if you want space(s) to count as not empty
    $var = trim($var);    
    if((isset($var) === true && $var === '') || (isset($var) === true && $var === 'undefined')) { 		
        return true;    
    }
    else {    
        return false;
    }
}
$app->run();