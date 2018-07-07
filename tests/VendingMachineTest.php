<?php
use PHPUnit\Framework\TestCase;

require('src/Model.php');

class VendingMachineTest extends TestCase
{
    protected $model;
    protected $drink;

    private $input_amount_possible = [10,50,100,500,1000];
    private $input_amount_impossible = [1,5,2000,5000,10000];

    protected function setUp() 
    {
        $this->model = new Model();
        $this->cola = new Drink('コーラ', 120, 5);
    }

    // 投入金額バリデーションチェック 
    public function testCheckInputAmount()
    {
        // テストケース: 投入可能な金
        foreach ($this->input_amount_possible as $amount ) {
            $this->assertTrue($this->model->checkInputAmount($amount));
        }

        // テストケース: 投入不可な金
        foreach ($this->input_amount_impossible as $amount ) {
            ob_start();
            $this->assertFalse($this->model->checkInputAmount($amount));
            $actual = ob_get_clean();
            $this->assertEquals('釣り銭：' . $amount, $actual);
        }
    }

    // 金額追加
    public function testAddInputAmount()
    {
        // 自販機内金額を足す
        $this->model->total_input_amount = 100;
        $this->model->addInputAmount(100);
        $this->assertEquals(200, $this->model->total_input_amount);
    }

    // 購入可能リスト
    public function testBuyableList()
    {
        // テストデータコーラ投入
        array_push($this->model->drink_list, $this->cola);
        
        // テストケース: コーラ購入可能
        $this->model->total_input_amount = 150;
        $drink_list = $this->model->buyableList();
        foreach ($drink_list as $drink) {
            if ($drink->name === 'コーラ') $cola = $drink;
        }
        $this->assertTrue($cola->buyable);

        // テストケース: コーラ購入不可
        $this->model->total_input_amount = 100;
        $drink_list = $this->model->buyableList();
        foreach ($drink_list as $drink) {
            if ($drink->name === 'コーラ') $cola = $drink;
        }
        $this->assertFalse($cola->buyable);
    }

    // 購入実行
    public function testBuyDrink()
    {
        // テストデータコーラ投入
        array_push($this->model->drink_list, $this->cola);
        
        // テストケース: 購入できる場合
        $this->model->total_input_amount = 150;
        $this->model->buyDrink($this->cola);

        // drinklistの在庫が一つ減る

        // 釣り銭のチェック

    }
}