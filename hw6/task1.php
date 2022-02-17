<?php

class Vacancy {
    private string $employer;
    private string $position;
    private string $salary;
    private string $experience;

    public function __construct(string $employer, string $position, string $salary, string $experience) {
        $this->$employer = $employer;
        $this->$position = $position;
        $this->$salary = $salary;
        $this->$experience = $experience;
        $this->$skills = $skills;
    }
}

class VacanciesSite implements SplSubject {
    public $vacancies;

    private $applicants;

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
            $applicant->update($vacancy, $state);
        }
    }

    public function addVacancy (Vacancy $vacancy){
        $this->vacancies[] = $vacancy;
        $this->notify();
    }

    public function removeVacancy (Vacancy $vacancy){

        foreach ($this->vacancies as $key=>$value) {
            if ($vacancy === $value) {
                unset($this->vacancies[$key]);
            }
        }
        $this->notify();
    }
}

abstract class Applicant implements SplObserver{
    protected string $name;
    protected string $email;
    protected string $experience;
    protected array $desiredVacancies;

    public function __construct($name, $email, $experience) {
        $this->$name = $name;
        $this->$email = $email;
        $this->$experience = $experience;
    }

    abstract public function update();
}

class JuniorApplicant extends Applicant {
    public function update(Vacancy $vacancy, string $state){
        echo "Jun ".$this->name." applies for ".$vacancy->position." at ".$vacancy->employer."<br>";
    }
}

class MiddleApplicant extends Applicant {
    public function update(Vacancy $vacancy, string $state){
        echo "Middle ".$this->name." applies for ".$vacancy->position." at ".$vacancy->employer."<br>";
    }
}

class SeniorApplicant extends Applicant {
    public function update(Vacancy $vacancy, string $state){
        echo "Senior ".$this->name." applies for ".$vacancy->position." at ".$vacancy->employer."<br>";
    }
}

$vacanciesSite = new VacanciesSite;

$applicant1 = new JuniorApplicant("Leonard Hofstadter", "experimental@physicist.com", "1");
$applicant2 = new MiddleApplicant("Rajesh Koothrappali", "astro@physicist.com", "3");
$applicant3 = new SeniorApplicant("Sheldon Cooper", "theoretical@physicist.com", "6");

$vacancy1 = new Vacancy("Rostelecom", "PHP developer", "30000", "10");
$vacanciesSite->attach($applicant1);
$vacanciesSite->attach($applicant2);
$vacanciesSite->addVacancy($vacancy1);