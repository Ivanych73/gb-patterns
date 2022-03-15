<?php

class Vacancy {
    private string $employer;
    private string $position;
    private string $salary;
    private string $experience;

    public function __construct(string $employer, string $position, string $salary, string $experience) {
        $this->employer = $employer;
        $this->position = $position;
        $this->salary = $salary;
        $this->experience = $experience;
    }

    public function getEmployer() {
        return $this->employer;
    }
    public function getPosition() {
        return $this->position;
    }
    public function getSalary() {
        return $this->salary;
    }
    public function getExperience() {
        return $this->experience;
    }
}

class VacanciesSite implements SplSubject {
    private $vacancies;

    private $applicants;

    private $lastUpdate;

    public function __construct() {
        $this->applicants = new SplObjectStorage();
    }

    public function attach(SplObserver $applicant): void
    {
        $this->applicants->attach($applicant);
    }

    public function detach(SplObserver $applicant): void
    {
        $this->applicants->detach($applicant);
    }

    public function notify(): void
    {
        foreach ($this->applicants as $applicant) {
            $applicant->update($this);
        }
    }

    public function addVacancy (Vacancy $vacancy){
        $this->vacancies[] = $vacancy;
        echo $vacancy->getEmployer()." opened new vacancy for ".$vacancy->getPosition()."<br>";
        $this->lastUpdate = ['vacancy' => $vacancy, 'new' => true];
        $this->notify();
    }

    public function removeVacancy (Vacancy $vacancy){

        foreach ($this->vacancies as $key=>$value) {
            if ($vacancy === $value) {
                unset($this->vacancies[$key]);
            }
        }
        $this->lastUpdate = ['vacancy' => $vacancy, 'new' => false];
        $this->notify();
    }

    public function getLastUpdate() {
        return $this->lastUpdate;
    }
}

abstract class Applicant implements SplObserver{
    protected string $name;
    protected string $email;
    protected string $experience;

    public function __construct($name, $email, $experience) {
        $this->name = $name;
        $this->email = $email;
        $this->experience = $experience;
    }

    public function getName() {
        return $this->name;
    }

    public function validateVacancy(VacanciesSite $vacanciesSite) {
        if ($vacanciesSite->getLastUpdate()['new']){
            $vacancy = $vacanciesSite->getLastUpdate()['vacancy'];
            if ($vacancy->getExperience()<= $this->experience) {
                return $vacancy;
            } else return false;
        } else return false;
    }

    public function apply(Vacancy $vacancy) {
        $level = substr(get_class($this), 0, stripos(get_class($this), 'Applicant'));
        echo "$level ".$this->getName()." applies for ".$vacancy->getPosition()." at ".$vacancy->getEmployer()."<br>";
    }

    abstract public function update(SplSubject $vacanciesSite);
}

class JuniorApplicant extends Applicant {
    public function update(SplSubject $vacanciesSite){
        $vacancy = $this->validateVacancy($vacanciesSite);
        if ($vacancy) $this->apply($vacancy);
    }
}

class MiddleApplicant extends Applicant {
    protected $desiredSalary = '100000';
    public function update(SplSubject $vacanciesSite){
        $vacancy = $this->validateVacancy($vacanciesSite);
        if ($vacancy && $vacancy->getSalary() >= $this->desiredSalary) $this->apply($vacancy);  
    }
}

class SeniorApplicant extends Applicant {
    protected $desiredSalary = '150000';
    public function update(SplSubject $vacanciesSite){
        $vacancy = $this->validateVacancy($vacanciesSite);
        if ($vacancy && $vacancy->getSalary() >= $this->desiredSalary) $this->apply($vacancy);  
    }
}

$vacanciesSite = new VacanciesSite;

$applicant1 = new JuniorApplicant("Leonard Hofstadter", "experimental@physicist.com", "1");
$applicant2 = new MiddleApplicant("Rajesh Koothrappali", "astro@physicist.com", "3");
$applicant3 = new SeniorApplicant("Sheldon Cooper", "theoretical@physicist.com", "6");

$vacanciesSite->attach($applicant1);
$vacanciesSite->attach($applicant2);
$vacanciesSite->attach($applicant3);
$vacancy1 = new Vacancy("Rostelecom", "PHP developer", "30000", "1");
$vacanciesSite->addVacancy($vacancy1);
$vacancy2 = new Vacancy("Yandex", "PHP developer", "120000", "3");
$vacanciesSite->addVacancy($vacancy2);
$vacancy3 = new Vacancy("Google", "PHP developer", "220000", "3");
$vacanciesSite->addVacancy($vacancy3);