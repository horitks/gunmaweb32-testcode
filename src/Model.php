<?php

class Drink 
{
    public $name;
    public $price;
    public $stock;

    function __construct(string $name, int $price, int $stock){
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }
}

class Model
{
    public $total_input_amount = 0;
    public $drink_list = [];

    /**
     * 投入金額バリデーション check
     * @param int $amount
     * @return boolean
     */
    public function checkInputAmount(int $amount)
    {
        if ($amount === 10 || $amount === 50 || $amount === 100 || $amount === 500 || $amount === 1000) return true;
        print('釣り銭：' . $amount);
        return false;
    }

    /**
     * 金額の付け足し
     * @param int $amount
     */
    public function addInputAmount(int $amount)
    {
        $this->total_input_amount =  $this->total_input_amount + $amount;
    }

    /**
     * 購入可能可否の一覧返却
     * @return array $res 商品リスト
     */
    public function buyableList ()
    {
        $res = [];
        foreach ($this->drink_list as $drink) {
            if ($this->total_input_amount > $drink->price) {
                $drink->buyable = true;
            } else {
                $drink->buyable = false;
            }
            array_push($res, $drink);
        }
        return $res;
    }

    /**
     * 商品購入の実行
     * @param Drink 
     * @return boolean
     */
    public static function buyDrink(Drink $drink)
    {
        
    }
}