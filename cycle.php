<?php
require_once("course.php");
require_once("hacoo.php");
class Cycle {
	public $sixWeeks; // 1, 2, 3,4,5, or 6
	public $grades;
	public $dom;
	
	
	/* $data can be DOM or URL */
	function __construct($data, $sixWeeks) {
		$this->sixWeeks = $sixWeeks;; // first string is sixweeks
		if(filter_var($data, FILTER_VALIDATE_URL)) {
			$dom = new DOMDocument();
			@$dom->loadHTML(file_get_contents($data));
			$this->dom = $dom;
		} else {
			$dom = new DOMDocument();
			@$dom->loadHTML($data);
			$this->dom = $dom;
		}
		
		$this->grades = $this->toArray();
	}
	
	function loadGrades() {
		return $this->loadGradesDirect();
	}
	
	function loadGradesDirect() {
		$categoriesDOMNodes = $this->getElementsByClassName('CategoryName');
		$categoriesArray = array(); // array of all of the grade categories
		for($i = 0; $i < sizeof($categoriesDOMNodes); $i++) {
			$thisCategory = array(); // holds weight and name
			$string = $categoriesDOMNodes[$i]->textContent; 
			$thisCategory['weight'] = substr($string, strpos($string, "%") - 2, 2) / 100; //decimal, like .2
			$thisCategory['name'] = substr($string, 0, strpos($string, "-")); // trust me, I'm a doctor
			
			$categoriesArray[$i] = $thisCategory;
		}
		$gradeContainer = array(); // stores an array of arrays of grades
		
		for($i = 0;  $i < sizeof($categoriesDOMNodes); $i++) {
			$gradeArray = array();
			$gradeListDOM = $this->dom->getElementsByTagName('table')->item($i + 2)->getElementsByTagName('tr');
			for($j = 1; $j < $gradeListDOM->length; $j++) {
				$gradeRow = $gradeListDOM->item($j)->getElementsByTagName('td');
				if($j == $gradeListDOM->length - 1) { $gradeArray['average'] = $gradeRow->item(3)->textContent; continue; }
				$length = $gradeRow->length;
				//echo $length; echo "<br />";
				$grade = array();
				//$grade['assigned'] = $gradeRow->item(1)->textContent;
				$assigned = $gradeRow->item(1)->textContent;
				$grade['assignedmonth'] = substr($assigned, 0, 3);
				$grade['assignedday'] = substr($assigned, 4, 2);
				//$grade['due'] = $gradeRow->item(2)->textContent;
				$due = $gradeRow->item(2)->textContent;
				$grade['duemonth'] = substr($due, 0, 3);
				$grade['dueday'] = substr($due, 4, 2);
				
				if($length == 6) { // if he calculates direct grades %
				$grade['assignmentname'] = $gradeRow->item(0)->textContent;
				$grade['grade'] = $gradeRow->item(3)->textContent;
				$grade['note'] = $gradeRow->item(4)->textContent;
				} else { // if he calculates by doing points possible vs points assigned
					$grade['assignmentname'] = $gradeRow->item(0)->textContent;
					$grade['grade'] = round((($gradeRow->item(3)->textContent) / ($gradeRow->item(4)->textContent)) * 100, 2);
					$grade['note'] = $gradeRow->item(5)->textContent;
				}
				
				$gradeArray[] = $grade;
			}
			$gradeArray['weight'] = $categoriesArray[$i]['weight'];
			$gradeArray['name'] = $categoriesArray[$i]['name'];
			$gradeContainer[] = $gradeArray;
		}
		return $gradeContainer;
	
	}
	
	function toArray() {
		$array = $this->loadGradesDirect();
		$array['cycle'] = $this->sixWeeks;
		return $array;
	}
	
	function getElementsByClassName($ClassName) {
		$Elements = $this->dom->getElementsByTagName("span");
		$Matched = array();
		for($i=0;$i<$Elements->length;$i++) {
			if($Elements->item($i)->getAttribute('class') == $ClassName) {
				$Matched[]=$Elements->item($i);
			}			
		}
		return $Matched;
	}

}

?>
