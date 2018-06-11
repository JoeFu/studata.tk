<?php
require 'DataQuery.php';
use PHPUnit\Framework\TestCase;
 
class DataQueryTests extends TestCase
{
    private $dataQuery;
 
    protected function setUp()
    {
    	$this->dataQuery= new DataQuery();
    }
 
    protected function tearDown()
    {
    	$this->dataQuery= NULL;
    }
 
    // Test the api of getting the event names
    public function testEventNames()
    {
    	// expected value
    	$expectedResult = '[{"Name":"marks"},{"Name":"submitted"}]';
    	
    	// actual value
    	$result = $this->dataQuery->callAPI('http://studata.tk/slimapp/public/index.php/api/eventnames/2', null);
    	
    	// assert if two values are equal
    	$this->assertEquals($expectedResult, $result);
    	
    	// expected value
    	$expectedResult = '[{"Name":"blog_view"},{"Name":"choice_add"},{"Name":"choice_choose"},{"Name":"choice_choose again"},{"Name":"choice_report"},{"Name":"choice_view"},{"Name":"choice_view all"},{"Name":"course_add mod"},{"Name":"course_delete mod"},{"Name":"course_editsection"},{"Name":"course_enrol"},{"Name":"course_move"},{"Name":"course_recent"},{"Name":"course_report log"},{"Name":"course_unenrol"},{"Name":"course_update"},{"Name":"course_update mod"},{"Name":"course_user report"},{"Name":"course_view"},{"Name":"discussion_mark read"},{"Name":"forum_add discussion"},{"Name":"forum_add post"},{"Name":"forum_delete discussi"},{"Name":"forum_delete post"},{"Name":"forum_mark read"},{"Name":"forum_search"},{"Name":"forum_subscribe"},{"Name":"forum_subscribeall"},{"Name":"forum_unsubscribe"},{"Name":"forum_unsubscribeall"},{"Name":"forum_update post"},{"Name":"forum_user report"},{"Name":"forum_view discussion"},{"Name":"forum_view forum"},{"Name":"forum_view forums"},{"Name":"forum_view subscriber"},{"Name":"quiz_add"},{"Name":"quiz_attempt"},{"Name":"quiz_close attempt"},{"Name":"quiz_continue attemp"},{"Name":"quiz_editquestions"},{"Name":"quiz_preview"},{"Name":"quiz_report"},{"Name":"quiz_review"},{"Name":"quiz_update"},{"Name":"quiz_view"},{"Name":"quiz_view all"},{"Name":"resource_add"},{"Name":"resource_update"},{"Name":"resource_view"},{"Name":"resource_view all"},{"Name":"role_assign"},{"Name":"role_unassign"},{"Name":"upload_upload"},{"Name":"user_update"},{"Name":"user_view"},{"Name":"user_view all"}]';
    	
    	// actual value
    	$result = $this->dataQuery->callAPI('http://studata.tk/slimapp/public/index.php/api/eventnames/1', null);
    	
    	// assert if two values are equal
    	$this->assertEquals($expectedResult, $result);
    }
 
    // Test the api of getting the event types
    public function testEventTypes()
    {
    	// expected value
    	$expectedResult = '[{"Id":"2","Name":"Assignment"},{"Id":"1","Name":"Course"},{"Id":"4","Name":"Forum"},{"Id":"5","Name":"Marking"},{"Id":"3","Name":"Quiz"},{"Id":"6","Name":"Submission"}]';
    	
    	// actual value
    	$result = $this->dataQuery->callAPI('http://studata.tk/slimapp/public/index.php/api/eventtypes', null);
    	
    	// assert if two values are equal
    	$this->assertEquals($expectedResult, $result);
    }
    
    // Test the api of getting the components
    public function testComponents()
    {
    	// expected value
    	$expectedResult = '[{"Id":"4","Name":"Choice"},{"Id":"2","Name":"File"},{"Id":"3","Name":"Forum"},{"Id":"6","Name":"mod_course"},{"Id":"7","Name":"mod_discussion"},{"Id":"5","Name":"Quiz"},{"Id":"1","Name":"System"}]';
    	
    	// actual value
    	$result = $this->dataQuery->callAPI('http://studata.tk/slimapp/public/index.php/api/components', null);
    	
    	// assert if two values are equal
    	$this->assertEquals($expectedResult, $result);
    }
    
    // Test the api of getting the users
    public function testUsers()
    {
    	// expected value
    	$expectedResult = '[{"Id":"077b3"},{"Id":"0827f"},{"Id":"09e8a"},{"Id":"0ddd7f51-160e-11e7-aeac-705a0f1aec02"},{"Id":"0e1750b9-160e-11e7-aeac-705a0f1aec02"},{"Id":"1ae20"},{"Id":"1bb1f"},{"Id":"22021"},{"Id":"24486"},{"Id":"25967"},{"Id":"2cb4e"},{"Id":"3218c"},{"Id":"3e556"},{"Id":"40d30"},{"Id":"41f69"},{"Id":"4acb9"},{"Id":"4c676"},{"Id":"4ed5e"},{"Id":"53bef"},{"Id":"571ae"},{"Id":"5a332"},{"Id":"5f46d"},{"Id":"60476"},{"Id":"638bd"},{"Id":"659a1"},{"Id":"6c2ce"},{"Id":"6d284"},{"Id":"75ede"},{"Id":"78a9a"},{"Id":"79e45"},{"Id":"7c352"},{"Id":"7d850"},{"Id":"7dc77"},{"Id":"7f24a"},{"Id":"7fedf"},{"Id":"878c9"},{"Id":"87ec7"},{"Id":"9bbe0"},{"Id":"ad18f"},{"Id":"add82"},{"Id":"ae030"},{"Id":"b4d6e"},{"Id":"bb160"},{"Id":"c59ec"},{"Id":"cabfe"},{"Id":"cb2a9"},{"Id":"cb3f6"},{"Id":"cc3de"},{"Id":"d3814"},{"Id":"d7ced"},{"Id":"d7efa"},{"Id":"def5c"},{"Id":"e04fa"},{"Id":"e16cb"},{"Id":"e29f2"},{"Id":"e7e4c"},{"Id":"e8871"},{"Id":"ecc62"},{"Id":"f0c7d"},{"Id":"f62a8"},{"Id":"fc451"},{"Id":"ffc77"},{"Id":"USER0001"},{"Id":"USER0002"},{"Id":"USER0003"},{"Id":"USER0004"},{"Id":"USER0005"},{"Id":"USER0006"},{"Id":"USER0007"},{"Id":"USER0008"},{"Id":"USER0009"},{"Id":"USER0010"},{"Id":"USER0011"},{"Id":"USER0012"},{"Id":"USER0013"},{"Id":"USER0014"},{"Id":"USER0015"},{"Id":"USER0016"},{"Id":"USER0017"},{"Id":"USER0018"},{"Id":"USER0019"},{"Id":"USER0020"},{"Id":"USER0021"},{"Id":"USER0022"},{"Id":"USER0023"},{"Id":"USER0024"},{"Id":"USER0025"},{"Id":"USER0026"},{"Id":"USER0027"},{"Id":"USER0028"},{"Id":"USER0029"},{"Id":"USER0030"},{"Id":"USER0031"},{"Id":"USER0032"},{"Id":"USER0033"},{"Id":"USER0034"},{"Id":"USER0035"},{"Id":"USER0036"},{"Id":"USER0037"},{"Id":"USER0038"},{"Id":"USER0039"},{"Id":"USER0040"},{"Id":"USER0041"},{"Id":"USER0042"},{"Id":"USER0043"},{"Id":"USER0044"},{"Id":"USER0045"},{"Id":"USER0046"},{"Id":"USER0047"},{"Id":"USER0048"},{"Id":"USER0049"},{"Id":"USER0050"},{"Id":"USER0051"},{"Id":"USER0052"},{"Id":"USER0053"},{"Id":"USER0054"},{"Id":"USER0055"},{"Id":"USER0056"},{"Id":"USER0057"},{"Id":"USER0058"},{"Id":"USER0059"},{"Id":"USER0060"},{"Id":"USER0061"},{"Id":"USER0062"},{"Id":"USER0063"},{"Id":"USER0064"},{"Id":"USER0065"},{"Id":"USER0066"},{"Id":"USER0067"},{"Id":"USER0068"},{"Id":"USER0069"},{"Id":"USER0070"},{"Id":"USER0071"},{"Id":"USER0072"},{"Id":"USER0073"},{"Id":"USER0074"},{"Id":"USER0075"},{"Id":"USER0076"},{"Id":"USER0077"},{"Id":"USER0078"},{"Id":"USER0079"},{"Id":"USER0080"},{"Id":"USER0081"},{"Id":"USER0082"},{"Id":"USER0083"},{"Id":"USER0084"},{"Id":"USER0085"},{"Id":"USER0086"},{"Id":"USER0087"},{"Id":"USER0088"},{"Id":"USER0089"},{"Id":"USER0090"},{"Id":"USER0091"},{"Id":"USER0092"},{"Id":"USER0093"},{"Id":"USER0094"},{"Id":"USER0095"},{"Id":"USER0096"},{"Id":"USER0097"},{"Id":"USER0098"},{"Id":"USER0099"},{"Id":"USER0100"},{"Id":"USER0101"},{"Id":"USER0102"},{"Id":"USER0103"},{"Id":"USER0104"},{"Id":"USER0105"},{"Id":"USER0106"},{"Id":"USER0107"},{"Id":"USER0108"},{"Id":"USER0109"},{"Id":"USER0110"},{"Id":"USER0111"},{"Id":"USER0112"},{"Id":"USER0113"},{"Id":"USER0114"},{"Id":"USER0115"},{"Id":"USER0116"},{"Id":"USER0117"},{"Id":"USER0118"},{"Id":"USER0119"},{"Id":"USER0120"},{"Id":"USER0121"},{"Id":"USER0122"},{"Id":"USER0123"},{"Id":"USER0124"},{"Id":"USER0125"},{"Id":"USER0126"},{"Id":"USER0127"},{"Id":"USER0128"},{"Id":"USER0129"},{"Id":"USER0130"},{"Id":"USER0131"},{"Id":"USER0132"},{"Id":"USER0133"},{"Id":"USER0134"},{"Id":"USER0135"},{"Id":"USER0137"},{"Id":"USER0138"},{"Id":"USER0139"},{"Id":"USER0140"},{"Id":"USER0141"},{"Id":"USER0142"},{"Id":"USER0143"},{"Id":"USER0144"},{"Id":"USER0145"},{"Id":"USER0146"},{"Id":"USER0147"},{"Id":"USER0148"},{"Id":"USER0149"},{"Id":"USER0150"},{"Id":"USER0151"},{"Id":"USER0152"},{"Id":"USER0153"},{"Id":"USER0154"},{"Id":"USER0155"},{"Id":"USER0156"}]';
    	
    	// actual value
    	$result = $this->dataQuery->callAPI('http://studata.tk/slimapp/public/index.php/api/users', null);
    	
    	// assert if two values are equal
    	$this->assertEquals($expectedResult, $result);
    }
    
    // Test the api of getting the courses
    public function testCourses()
    {
    	// expected value
    	$expectedResult = '[{"CourseName":"Distributed Systems"},{"CourseName":"MSE"}]';
    	
    	// actual value
    	$result = $this->dataQuery->callAPI('http://studata.tk/slimapp/public/index.php/api/courses', null);
    	
    	// assert if two values are equal
    	$this->assertEquals($expectedResult, $result);
    }
    
    // Test the api of getting the school years
    public function testSchoolYears()
    {
    	// expected value
    	$expectedResult = '[{"SchoolYear":"2012"},{"SchoolYear":"2013"},{"SchoolYear":"2014"}]';
    	
    	// actual value
    	$result = $this->dataQuery->callAPI('http://studata.tk/slimapp/public/index.php/api/schoolyears', null);
    	
    	// assert if two values are equal
    	$this->assertEquals($expectedResult, $result);
    }
    
    // Test the api of getting the semesters
    public function testSemesters()
    {
    	// expected value
    	$expectedResult = '[{"Semester":"Semester 1"},{"Semester":"Semester 2"}]';
    	
    	// actual value
    	$result = $this->dataQuery->callAPI('http://studata.tk/slimapp/public/index.php/api/semesters', null);
    	
    	// assert if two values are equal
    	$this->assertEquals($expectedResult, $result);
    }
    
    // Test the api of getting the assignments
    public function testAssignments()
    {
    	// expected value
    	$expectedResult = '[{"AssignmentName":"Assignment 1"},{"AssignmentName":"Assignment 2"}]';
    	
    	// actual value
    	$result = $this->dataQuery->callAPI('http://studata.tk/slimapp/public/index.php/api/assignments', null);
    	
    	// assert if two values are equal
    	$this->assertEquals($expectedResult, $result);
    }
    
    // Test the api of querying the data
    public function testQueryData()
    {
    	// expected value
    	$expectedResult = '[{"Name":"resource_view","Description":"resource view 4906","FKUserId":"USER0019","Grade":"60","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"resource_view","Description":"resource view 4850","FKUserId":"USER0019","Grade":"60","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"forum_view forum","Description":"forum view forum 1248","FKUserId":"USER0019","Grade":"70","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"resource_view","Description":"resource view 4795","FKUserId":"USER0019","Grade":"70","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"resource_view","Description":"resource view 4795","FKUserId":"USER0019","Grade":"60","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"resource_view","Description":"resource view 4795","FKUserId":"USER0019","Grade":"70","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"resource_view","Description":"resource view 4855","FKUserId":"USER0019","Grade":"60","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"resource_view","Description":"resource view 4793","FKUserId":"USER0019","Grade":"70","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"resource_view","Description":"resource view 4795","FKUserId":"USER0019","Grade":"60","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"resource_view","Description":"resource view 4151","FKUserId":"USER0019","Grade":"60","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"resource_view","Description":"resource view 4151","FKUserId":"USER0019","Grade":"60","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"resource_view","Description":"resource view 4896","FKUserId":"USER0019","Grade":"70","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"},{"Name":"resource_view","Description":"resource view 4904","FKUserId":"USER0019","Grade":"70","StartDate":null,"DueDate":null,"AssignmentName":"Assignment 2","CourseName":"MSE","Semester":"Semester 2","SchoolYear":"2013"}]';
    	
    	// actual value
    	$parameters = '7%7C%7C%7C%7C%7C%7C%7C%7C%7C%7CAssignment%202%7CMSE%7C2013%7CSemester%202%7C1';
    	$curl_post_data = array(
    			"parameters" => $parameters
    	);
    	
    	$url = 'http://studata.tk/slimapp/public/index.php/api/events/search?parameters=' . $parameters;
    	$result = $this->dataQuery->callAPI($url, null);
    	
    	// assert if two values are equal
    	$this->assertEquals($expectedResult, $result);
    }
}