<?php

class Context {
    private $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function setStrategy(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function payForOrder(User $user, Order $order) {
        echo "User ".$user->getName()." is ready to pay for his order<br>";
        $paymentReturn = $this->paymentMethod->makePayment($order->getTotalSum());
        if ($this->paymentMethod->validateReturn($paymentReturn)) {
            echo "Order for ".$user->getName()." is succefully paid and will be delivered shortly<br>";
        }
    }
}

class User {
    protected $name;
    protected $phone;

    public function __construct($name, $phone) {
        $this->name = $name;
        $this->phone = $phone;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getName() {
        return $this->name;
    }
}

class Order {
    protected $totalSum;

    public function __construct($totalSum){
        $this->totalSum = $totalSum;
    }

    public function getTotalSum(){
        return $this->totalSum;
    }
}

interface PaymentMethod
{
    public function makePayment(float $amount): bool;

    public function validateReturn(bool $paymentMethodReturn): bool;
}

class QiwiPayment implements PaymentMethod {

    public function makePayment(float $amount): bool{
        echo "Paying $amount by QIWI...<br>";
        return true;
    }

    public function validateReturn(bool $paymentMethodReturn): bool {
        if ($paymentMethodReturn) {
            echo "Payment by QIWI successful!<br>";
            return true;
        }else return false;
    }
}

class YandexPayment implements PaymentMethod {

    public function makePayment(float $amount): bool{
        echo "Paying $amount by Yandex...<br>";
        return true;
    }

    public function validateReturn(bool $paymentMethodReturn): bool {
        if ($paymentMethodReturn) {
            echo "Payment by Yandex successful!<br>";
            return true;
        }else return false;
    }
}

class WebmoneyPayment implements PaymentMethod {

    public function makePayment(float $amount): bool{
        echo "Paying $amount by Webmoney...<br>";
        return true;
    }

    public function validateReturn(bool $paymentMethodReturn): bool {
        if ($paymentMethodReturn) {
            echo "Payment by Webmoney successful!<br>";
            return true;
        }else return false;
    }
}

$customer1 = new User("Leonard Hofstadter", "+11234567890");
$order1 = new Order(10000);
$customer2 = new User("Rajesh Koothrappali", "+11357902468");
$order2 = new Order(20000);
$customer3 = new User("Sheldon Cooper", "+11246803579");
$order3 = new Order(30000);
$paymentMethod1 = new QiwiPayment;
$context1 = new Context($paymentMethod1);
$context1->payForOrder($customer1, $order1);
$paymentMethod2 = new YandexPayment;
$context1->setStrategy($paymentMethod2);
$context1->payForOrder($customer2, $order2);
$paymentMethod3 = new WebmoneyPayment;
$context1->setStrategy($paymentMethod3);
$context1->payForOrder($customer3, $order3);