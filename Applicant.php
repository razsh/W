<?PHP
class Applicant {
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
	
	function Applicant($db) {
		$this->db = $db;
	}
	function setFirstName($firstName) {
		$this->firstName = $firstName;
	}
	function setLastName($lastName) {
		$this->lastName = $lastName;
	}
	function setAddress($address) {
		$this->address = $address;
	}
	function setCity($city) {
		$this->city = $city;
	}
	function setProvince($province) {
		$this->province = $province;
	}
	function setPostalCode($postalCode) {
		$this->postalCode = $postalCode;
	}
	function setEmailAddress($emailAddress) {
		$this->emailAddress = $emailAddress;
	}
	function setMobilePhone($mobilePhone) {
		$this->mobilePhone = $mobilePhone;
	}
	function setHomePhone($homePhone) {
		$this->homePhone = $homePhone;
	}
	function setWorkPhone($workPhone) {
		$this->workPhone = $workPhone;
	}
	function setCoverLetter($coverLetter) {
		$this->coverLetter = $coverLetter;
	}
	function setResume($resume) {
		$this->resume = $resume;
	}
	function insert() {
		$st = $this->db->query("SELECT name FROM provinces");
		return($st->fetchAll());
	}
	function addApplicant() {
		try {
			$st = $this->db->prepare("INSERT INTO applicant (firstname, lastname, address, city, province, postalcode, emailaddress, mobilephone, homephone, workphone, coverletterfile, resumefile) VALUES (:firstname, :lastname, :address, :city, :province, :postalcode, :emailaddress, :mobilephone, :homephone, :workphone, :coverletterfile, :resumefile)");
			$st->bindParam(':firstname', $this->firstName);
			$st->bindParam(':lastname', $this->lastName);
			$st->bindParam(':address', $this->address);
			$st->bindParam(':city', $this->city);
			$st->bindParam(':province', $this->province);
			$st->bindParam(':postalcode', $this->postalCode);
			$st->bindParam(':emailaddress', $this->emailAddress);
			$st->bindParam(':mobilephone', $this->mobilePhone);
			$st->bindParam(':homephone', $this->homePhone);
			$st->bindParam(':workphone', $this->workPhone);
			$st->bindParam(':coverletterfile', $this->coverLetter);
			$st->bindParam(':resumefile', $this->resume);
			$st->execute();
		} catch (PDOException $err) {
			print_r($err);
		}
	}	
	function printAttributes() {
		print $this->firstName;
		print $this->lastName;
		print $this->address;
		print $this->city;
		print $this->province;
		print $this->postalCode;
		print $this->emailAddress;
		print $this->mobilePhone;
		print $this->homePhone;
		print $this->workPhone;
		print $this->coverLetter;
		print $this->resume;
	}
}

?>
