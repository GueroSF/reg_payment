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

    public $iOperation;
    public $sMoney;
    public $sDate;
    public $sComment;

    public function __construct($id)
    {
        $this->iAccountId = $id;
    }

    /**
     * Добавление платежа выбранной категории
     *
     * @return bool
     */
    public function addPayment($autoPayment = false)
    {
        $aPlaceHolder = [
            ':idAcc' => $this->iAccountId,
            ':idOp' => $this->iOperation??$_POST['operation'],
            ':idCat' => $this->iCategoryId,
            ':money' => $this->sMoney??$_POST['money'],
            ':date' => $this->sDate??$_POST['date']
        ];
        $comm = $this->sComment??$_POST['comment'];
        $oPDO = $this-> getConnect();
        try {
            $sql = 'INSERT INTO `buh_transaction`(`account`, `operations`, `category`, `money`, `date_operations`) VALUES (:idAcc,:idOp,:idCat,:money,:date)';
            $insert = $oPDO ->prepare($sql);
            $insert->execute($aPlaceHolder);
        } catch (\PDOException $e) {
            self::send($e,false);
            return false;
//            errorMessage('Ошибка при добавление платежа');
        }
        if(!empty($comm)){
            /*$sql = 'SELECT MAX(`id`) FROM `buh_transaction` WHERE
                            `account` = :idAcc AND
                            `operations` = :idOp AND 
                            `category` = :idCat AND 
                            `money` = :money AND 
                            `date_operations` = :date
                            ;';
            $s = $oPDO -> prepare($sql);
            $s -> execute($aPlaceHolder);
            $lastId = $s->fetchColumn();*/
            $lastId = $oPDO->lastInsertId();
//            var_dump($lastId);
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
        if ($autoPayment) return true;
        $url = '/account/'.$this->iAccountId.'/category/'.$this->iCategoryId;
        header("Location: $url");
        return true;
    }

    /**
     * Получение всех категорий счета (акаунта)
     *
     * @return array|bool
     */

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
    }

    /**
     * Получение массива id и name категории, или
     * если передать true возвращается только имя
     *
     * @param bool $name
     * @return bool|mixed
     */
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


    /**
     * Возвращаетсяколичество денег выбранной категории
     *
     * @return bool|mixed
     */
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

    /**
     * Возвращаются все платежи в выбранной категории
     *
     * @return array|bool
     */
    public function getPaymetsOfCategory()
    {
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

    /**
     * Добавление новой категории и платежа туда
     *
     * @return bool
     */
    public static function addNewCategory(){
        $pdo = self::getConnect();
        try {
            $sql = 'INSERT INTO `buh_category` SET `name` = :name';
            $insert = $pdo->prepare($sql);
            $insert->bindValue(':name', $_POST['category']);
            $insert->execute();
        } catch (\PDOException $e) {
            self::send($e,false);
            return false;
//            errorMessage('Ошибка добавления категории');
        }
        $oAddPayment = new Category($_POST['account']);
        $oAddPayment->iCategoryId = $pdo->lastInsertId();
        $oAddPayment->addPayment();
    }

}