<?php

class Database
{

    private static $instance = null;
    private $conn;

    private $server = "localhost";
    private $currentDB = "upload";
    private $user = "homestead";
    private $pass = "secret";

    private function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->server;dbname=$this->currentDB", $this->user, $this->pass
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec('set names utf8');
            $this->createImageTable();
            $this->createAttrsTable();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die;
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }


    public function getSelectQueryResult($query = '', $list = true)
    {
        try {
            $query = $this->conn->prepare($query);
            $query->execute();
            if($list){
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $query->fetchColumn();
            }
        } catch (PDOException $e) {
            print_r($e);
            echo $query . "<br>" . $e->getMessage();
        }
    }

    public function insertAttrsData(array $data)
    {
        $sql = "INSERT INTO `attrs` (`image_id`, `key`, `value`) VALUES (?,?,?)";
        $this->conn->prepare($sql)->execute($data);
        return $this->conn->lastInsertId();
    }
    public function insertImagesData(array $data)
    {
        $sql = "INSERT INTO `images` (`name`) VALUES (?)";
        $this->conn->prepare($sql)->execute($data);
        return $this->conn->lastInsertId();
    }

    public function createImageTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS `images` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `name` varchar(200) NOT NULL,            
            PRIMARY KEY (`id`)) 
            CHARACTER SET utf8 COLLATE utf8_general_ci
        ";
        $this->conn->exec($sql);

    }

    public function createAttrsTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS `attrs` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `image_id` INT NOT NULL,
            `key` varchar(200),
            `value` varchar(200),            
            PRIMARY KEY (`id`))            
            CHARACTER SET utf8 COLLATE utf8_general_ci
        ";
        $this->conn->exec($sql);
    }

    public function getMaxPages($perPage = 10){
        $sql = "SELECT COUNT(*) AS `total` FROM `images`";
        $totalPages = $this->getSelectQueryResult($sql, false);
        return ceil($totalPages/$perPage);
    }

    public function getHtml ($page=1, $perPage = 10){
        $paged = 10*($page-1);

        $query = "SELECT i.id, i.name, 
            GROUP_CONCAT(a.key SEPARATOR '||') AS `keys`,
            GROUP_CONCAT(a.value SEPARATOR '||') AS `values` 
            FROM `images` AS `i` INNER JOIN `attrs` AS `a`
            ON i.ID = a.image_id GROUP BY i.id ORDER BY i.id DESC LIMIT 10 OFFSET {$paged}";
        $result = $this->getSelectQueryResult($query);
        $total_pages = $this->getMaxPages($perPage);

        ob_start(); ?>
        <div class="row">
            <?php foreach ($result as $value) { ?>
                <?php $values = explode('||', $value['values']);  ?>
                <?php $keys = explode('||', $value['keys']); $combine = (array_combine($keys , $values)) ?>
                <div class="col-md-2" data-toggle="modal" data-target=".myModal">
                    <div class="card mb-4 box-shadow">
                        <img data-id="<?= $value['id'] ?>" class="card-img-top" style="height: 100px; width: 100%; display: block;" src="/upload/<?= $combine['name'] ?>" data-holder-rendered="true">
                    </div>
                </div>
            <?php } ?>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php for($i=1; $i <= $total_pages; $i++) { ?>
                    <?php $class = ($i==$page)?'active':'' ?>
                    <li class="page-item <?= $class ?>"><a class="page-link " href="#"><?= $i; ?></a></li>
                <?php } ?>
            </ul>
        </nav>
        <?php return ob_get_clean();
    }

    public function viewImageById($id){
        $query = "SELECT `value` FROM `attrs` WHERE `key` = 'name' AND `image_id` = '{$id}'";
        $update = "UPDATE attrs SET `value` = ? WHERE `image_id` = ? AND `key` = ?";
        $this->conn->prepare($update)->execute([10,38,'views']);
        return $this->getSelectQueryResult($query, false);
    }
}