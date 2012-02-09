<?php
require_once("hacoo.php");
require_once("cycle.php");
class Course {
	public $higherLevelCourse; //boolean
	public $countsOnGPA;
	public $cycles; // array
	public $courseID;
	public $courseName;
	public $teacherName;
	
	function __construct($higherLevel, $countsOnGPA, $teacherName, $data, $info, $courseName) {
		$this->higherLevelCourse = $higherLevel;
		$this->countsOnGPA = $countsOnGPA;
		$this->courseID = $info['courseID'];
		$this->courseName = $courseName;
		
		for($cyclenumber = 1; $cyclenumber <= 6; $cyclenumber++) {
			$cycledata = $data[$cyclenumber - 1];
			if($cycledata == false) { continue; }
			$this->cycles[] = new Cycle($cycledata, $cyclenumber);
		}
	}
	
	function toArray() {
		$array = array();
		$array['higherLevel'] = $this->higherLevelCourse;
		$array['countsOnGPA'] = $this->countsOnGPA;
		$array['courseID'] = $this->courseID;
		$array['courseName'] = $this->courseName;
		for($i = 0; $i < sizeof($this->cycles); $i++) {
			$array[$i] = $this->cycles[$i]->grades;
		}
		
		return $array;
	}
}


