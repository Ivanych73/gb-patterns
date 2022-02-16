<?php
interface INotifier {
    public function sendMessage();
}

class Notifier implements INotifier {

    private $text;

    public function __construct($text) {
        $this->text = $text;
    }

    public function sendMessage() {
        return $this->text;
    }
}

abstract class Decorator implements INotifier {
    protected $iNotifier;

    public function __construct(INotifier $iNotifier){
        $this->iNotifier = $iNotifier;
    }

    public function sendMessage() {
        return $this->iNotifier->sendMessage();
    }
}

class SmsNotifier extends Decorator {
    public function sendMessage() {
        return "Notified by SMS: ".$this->iNotifier->sendMessage();
    }
}

class EmailNotifier extends Decorator {
    public function sendMessage() {
        return "Notified by Email: ".parent::sendMessage();
    }
}

class ViberNotifier extends Decorator {
    public function sendMessage() {
        return "Notified by Viber: ".parent::sendMessage();
    }
}

$message1 = new Notifier('Sample notifier message');
echo $message1->sendMessage()."<br>";
$message2 = new SmsNotifier($message1);
echo $message2->sendMessage()."<br>";
$message3 = new EmailNotifier($message1);
echo $message3->sendMessage()."<br>";
$message4 = new ViberNotifier($message1);
echo $message4->sendMessage()."<br>";
$message5 = new EmailNotifier($message2);
echo $message5->sendMessage()."<br>";
$message6 = new ViberNotifier($message5);
echo $message6->sendMessage()."<br>";