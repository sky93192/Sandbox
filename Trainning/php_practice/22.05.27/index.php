<?php
echo "<h1>CLASS PRACTICE</h1>";
class Person {

    private $first_name;
    public $last_name;
    protected $gender;

    public function __construct($first_name, $last_name, $gender = 'f')
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->gender = $gender;
    }

    public function sayHello() {
        return "Hello my name is $this->first_name $this->last_name.";
    }

    public function getGender() {
        return $this->gender;
    }
}

$tom = new Person('Tom', 'Ben', 'm');
echo $tom->sayHello();
echo "<hr>";

// class Employee {

//     public $jobTitle;

//     public function __construct($jobTitle)
//     {
//         $this->jobTitle = $jobTitle;
//     }

//     public function getJobTitle() {
//         return $this->jobTitle;
//     }
// }

// $employee = new Employee('Backend Developer');
// echo $employee->getJobTitle();
// echo "<hr>";

class Employee extends Person {

    const COMPANY_NAME = 'ACME';

    static $employeeNumber = 100;

    private $jobTitle;

    public function __construct($jobTitle, $first_name, $last_name, $gender = 'f')
    {
        $this->jobTitle = $jobTitle;
        parent::__construct($first_name, $last_name, $gender);
        echo self::COMPANY_NAME."<br>";
    }

    public function getJobTitle() {
        return $this->jobTitle;
    }

    public static function getEmployeeNumber() {
        return self::$employeeNumber;
    }
}

$jane = new Employee('Backend Developer', 'Jane', 'Ben');
echo $jane->getJobTitle();
echo "<br>";
echo $jane->getGender();
echo "<hr>";

// $jane->jobTitle = 'Frontend Developer'; // Uncaught Error: Cannot access private property
// echo $jane->jobTitle;
echo "private properties and functions can't be called from outside";
echo "<hr>";

// echo $jane->first_name; // will get undefined error
// echo $tom->first_name; // Uncaught Error: Cannot access private property
// echo $jane->gender; // Uncaught Error: Cannot access protected property
echo "protected properties and functions can't be called from outside, but can be called by other public properties and functions";
echo "<hr>";

echo Employee::COMPANY_NAME;
echo "<hr>";

echo Employee::$employeeNumber;
echo "<br>";
echo $jane->getEmployeeNumber();
// echo $jane->COMPANY_NAME; // Undefined property: Employee::$COMPANY_NAME
echo "<br>";
echo '$val->property === Class::$property ; $val->CONST !== Class::CONST';
echo "<hr>";

// __get and __set