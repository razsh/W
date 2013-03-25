<?php

require_once 'constants.php';
require_once 'Province.php';
require_once 'Applicant.php';
require_once 'SR_View.php';

class JobAppController {
	private $db;
	private $firstName;
	private $lastName;
	private $address;
	private $city;
	private $province;
	private $postalCode;
	private $emailAddress;
	private $mobilePhone;
	private $homePhone;
	private $workPhone;
	private $coverLetter;
	private $resume;

	function JobAppController() {
		$this->db = new PDO(DB_PATH, DB_USER, DB_PASS);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	function index() {
		if (!isset($_POST['submit'])) {
			$this->_displayFormView();
			return;
		}
		
		// The form was submitted
		if (isset($_POST['fName']) && $_POST['fName'] != '') {
			$this->firstName = $_POST['fName'];
		}
		if (isset($_POST['lName']) && $_POST['lName'] != '') {
			$this->lastName = $_POST['lName'];
		}
		if (isset($_POST['Stnum']) && $_POST['Stnum'] != '') {
			$this->address = $_POST['Stnum'];
		}
		if (isset($_POST['City']) && $_POST['City'] != '') {
			$this->city = $_POST['City'];
		}
		if (isset($_POST['Prov']) && $_POST['Prov'] != '') {
			$this->province = $_POST['Prov'];
		}
		if (isset($_POST['Pcode']) && $_POST['Pcode'] != '') {
			$this->postalCode = $_POST['Pcode'];
		}
		if (isset($_POST['Email']) && $_POST['Email'] != '') {
			$this->emailAddress = $_POST['Email'];
		}
		if (isset($_POST['Phone1']) && $_POST['Phone1'] != '') {
			$this->mobilePhone = $_POST['Phone1'];
		}
		if (isset($_POST['Phone2']) && $_POST['Phone2'] != '') {
			$this->homePhone = $_POST['Phone2'];
		}
		if (isset($_POST['Phone3']) && $_POST['Phone3'] != '') {
			$this->workPhone = $_POST['Phone3'];
		}
		
		// validate
		if ($this->firstName == '') {
			$this->_displayFormView('Please enter your first name', 1);
			return;
		}
		if ($this->lastName == '') {
			$this->_displayFormView('Please enter your last name', 1);
			return;
		}
		if ($this->address == '') {
			$this->_displayFormView('Please enter your address', 1);
			return;
		}
		if ($this->city == '') {
			$this->_displayFormView('Please enter your city', 1);
			return;
		}
		if ($this->postalCode == '') {
			$this->_displayFormView('Please enter your pstal code', 1);
			return;
		}
		if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $this->emailAddress)) {
			$this->_displayFormView('Please enter a valid email address', 1);
			return;
		}
		if ($this->mobilePhone == '') {
			$this->_displayFormView('Please enter your mobile phone number', 1);
			return;
		}
		if (isset($_FILES['Cover']) && $_FILES['Cover']['name'] != '') {
			$this->coverLetter = $_FILES['Cover']['name'];
			move_uploaded_file($_FILES['Cover']['tmp_name'], 'Uploads/' . $_FILES['Cover']['name']);
		}
		if (isset($_FILES['Resume']) && $_FILES['Resume']['name'] != '') {
			$this->resume = $_FILES['Resume']['name'];
			move_uploaded_file($_FILES['Resume']['tmp_name'], 'Uploads/' . $_FILES['Resume']['name']);
		} else {
			$this->_displayFormView('Please upload your resume', 1);
			return;
		}
		
		// valid request
		$applicant = new Applicant($this->db);
		$applicant->setFirstName($this->firstName);
		$applicant->setLastName($this->lastName);
		$applicant->setAddress($this->address);
		$applicant->setCity($this->city);
		$applicant->setProvince($this->province);
		$applicant->setPostalCode($this->postalCode);
		$applicant->setEmailAddress($this->emailAddress);
		$applicant->setMobilePhone($this->mobilePhone);
		$applicant->setHomePhone($this->homePhone);
		$applicant->setWorkPhone($this->workPhone);
		$applicant->setCoverLetter($this->coverLetter);
		$applicant->setResume($this->resume);

		// insert new record to Applicant table
		$applicant->addApplicant();
		//$applicant->printAttributes();
		
		// say thank you
		$this->_displayThankYou();
	}
	
	function _displayFormView($message = 'Please fill in your details', $error = 0) {
		$view = new SR_View('JobAppView.html');
		if ($error) {
			$view->set('msgclass', 'error');
		} else {
			$view->set('msgclass', 'normal');
		}
		$view->set('msg', $message);	
		$view->set('prov', (new Province($this->db))->getAll());

		$view->set('fName', $this->firstName);
		$view->set('lName', $this->lastName);
		$view->set('Stnum', $this->address);
		$view->set('City',  $this->city);
		$view->set('Pcode', $this->postalCode);
		$view->set('Email', $this->emailAddress);
		$view->set('Phone1', $this->mobilePhone);
		echo $view->output();
	}
	function _displayThankYou() {
		$view = new SR_View('JobAppThankYou.html');
		echo $view->output();
	}
} 

$c = new JobAppController();
$c->index();
?>