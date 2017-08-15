<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 15.08.17
 * Time: 10:20
 */

namespace model;


class Category
{
    use ConnectDB;
    use ErrorOutput;

    public $iAccountId;
    public $iCategoryId;

    public $sCategoryName;

    public function __construct($id)
    {
        $this->iAccountId = $id;
    }

    public function addPayment(){
        $aPlaceHolder = [
            ':idAcc' => $this->iAccountId,
            ':idOp' => $_POST['operation'],
            ':idCat' => $this->iCategoryId,
            ':money' => $_POST['money'],
            ':date' => $_POST['date']
        ];
        $idOp = $_POST['operation'];
        $money = $_POST['money'];
        $date = $_POST['date'];
        $comm = $_POST['comment'];
        try {
            $sql = 'INSERT INTO `buh_transaction`(`account`, `operations`, `category`, `money`, `date_operations`) VALUES (:idAcc,:idOp,:idCat,:money,:date)';
            $insert = $this-> getConnect() ->prepare($sql);
            /*$insert->bindValue(':idAcc', $this->iAccountId);
            $insert->bindValue(':idOp', $idOp);
            $insert->bindValue(':idCat', $this->iCategoryId);
            $insert->bindValue(':money', $money);
            $insert->bindValue(':date', $date);*/
            $insert->execute($aPlaceHolder);
        } catch (\PDOException $e) {
            self::send($e,false);
            return false;
//            errorMessage('Ошибка при добавление платежа');
        }
        if(!empty($comm)){
            $sql = 'SELECT MAX(`id`) FROM `buh_transaction` WHERE 
                            `account` = :idAcc AND
                            `operations` = :idOp AND 
                            `category` = :idCat AND 
                            `money` = :money AND 
                            `date_operations` = :data
                            ';
            $s = $this-> getConnect() -> prepare($sql);
            $s -> execute($aPlaceHolder);
            $lastId = $s->fetchColumn();
            var_dump($lastId);
            try {
                $sql = 'INSERT INTO `buh_comment_payment`(`transaction_id`, `comment`) VALUES (:id, :text)';
                $insert = self::getConnect() ->prepare($sql);
                $insert->bindValue(':id', $lastId);
                $insert->bindValue(':text', $comm);
                $insert->execute();
            } catch (\PDOException $e) {
                self::send($e,false);
                return false;
//                errorMessage('Ошибка при добавлении комментария к платежу');
            }
        }
        return true;
        $url = $_SERVER['HTTP_REFERER'];
        header("Location: $url");
        exit();
    }

    public function getCategory()
    {
        try {
            $s = $this->getConnect()->query("SELECT DISTINCT category id, name FROM `buh_transaction`
							INNER JOIN buh_category ON buh_category.id = buh_transaction.category
							WHERE `account` = {$this->iAccountId}");
        } catch (\PDOException $e) {
            $this->send($e,false);
            return false;
//            errorMessage('Ошибка получения категорий счета');
        }
        $aCategorys = $s->fetchALL();
        try {
            $sql = 'SELECT IFNULL(SUM(money),0) - (SELECT IFNULL(SUM(money),0) FROM `buh_transaction` WHERE `operations` = 2 AND `account` = :account AND `category` = :cat) sum FROM `buh_transaction` WHERE `operations` = 1 AND `account` = :account AND `category` = :cat';
            $result = $this->getConnect()->prepare($sql);
            foreach ($aCategorys as $key =>$cat) {
                $result -> bindValue(':account', $this->iAccountId);
                $result -> bindValue(':cat', $cat['id']);
                $result -> execute();
                $aCategorys[$key]['sum'] = $result->fetchCOLUMN();
            }
        } catch (\PDOException $e) {
            $this->send($e,false);
            return false;
//            errorMessage('Ошибка подсчета сумм категорий');
        }
        return $aCategorys;
        include 'category_page.html.php';
    }

    public function getCategoryName($name = false){
        try {
            $s = $this->getConnect()->query("SELECT * FROM `buh_category` WHERE `id` = {$this->iCategoryId}");
        } catch (\PDOException $e) {
            $this->send($e,false);
            return false;
//            errorMessage('Ошибка получения name категории');
        }
        $category = $s->fetch();
        if ($name) {
            return $category['name'];
        }
        return $category;
    }

    public function getMoneyOfCategory(){
        try {
            $sql = 'SELECT IFNULL(SUM(money),0) - (SELECT IFNULL(SUM(`money`),0) FROM `buh_transaction` WHERE `operations` = 2 AND `account` = :account AND `category` = :cat) sum FROM `buh_transaction` WHERE `operations` = 1 AND `account` = :account AND `category` = :cat';
            $result = $this->getConnect()->prepare($sql);
            $result -> bindValue(':account', $this->iAccountId);
            $result -> bindValue(':cat', $this->iCategoryId);
            $result -> execute();
        } catch (\PDOException $e) {
            $this->send($e,false);
            return false;
//            errorMessage('Ошибка подсчета сумм категорий');
        }
        return $result->fetchCOLUMN();
    }


    public function getPaymetsOfCategory()
    {
//        $accountName = selectAccount($idAccount);

//        $operations = selectOper();
//        $titleName = $category['name'];
//        include 'head_page.html.php';

        try {
            $sql = 'SELECT `buh_transaction`.`id`,`name`, `money`,`date_operations` `date`, IFNULL(`comment`,\'false\') `comm`
				FROM `buh_transaction`
				INNER JOIN buh_operation ON buh_operation.id = buh_transaction.`operations`
				LEFT JOIN `buh_comment_payment` ON `buh_comment_payment`.`transaction_id` = `buh_transaction`.`id`
				WHERE `account` = :acc AND `category` = :cat
				ORDER BY `date_operations` DESC ,`buh_transaction`.`id` DESC';
            $result = $this->getConnect()->prepare($sql);
            $result -> bindValue(':acc', $this->iAccountId);
            $result -> bindValue(':cat', $this->iCategoryId);
            $result -> execute();
        } catch (\PDOException $e) {
            $this->send($e,false);
            return false;
//            errorMessage('Ошибка получения инфо о платежах в категории');
        }
        return $result->fetchALL();
    }
}