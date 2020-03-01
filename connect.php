<?php
define('DSN' ,"mysql:host=localhost;dbname=api" );
define('user' ,"root" );
define('password' ,'' );
class Database
{
    private $connection;
    public function __construct()
    {
        if (empty($this->connection)):
            try {
                    $this->connection =  new PDO(DSN,user,password,[PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8']);
                    $this->connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
                    $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    die("Faild to connect " . $e->getMessage());
                }
        endif;
    }
    public function GetConnection(){
        return $this->connection;
    }
    public function Fetch(string $Query = '' , array $parameters = [] )
    {
        try {
            if ($Query == ''):
                throw new Exception("Error Processing Query", 1);
            else:                
                $stmt = $this->connection->prepare($Query);
                $stmt->execute($parameters);
                $data = $stmt->fetchAll();
                return count($data) == 1 ? $data[0] : $data;
            endif;
        }catch (PDOException $e) {
            die("Faild to connect " . $e->getMessage());
        }
    }
    public function Execute(string $Query = '' , array $parameters = [] )
    {
        try {
            if ($Query == ''):
                throw new Exception("Error Processing Query", 1);
            else:
                $stmt = $this->connection->prepare($Query);
                foreach ($parameters as $key => $value):
                    $stmt->bindValue($key , $value);
                endforeach;
                $stmt->execute();
                return $stmt->rowCount();
            endif;
        } catch (PDOException $e) {
            die("Faild to connect " . $e->getMessage());
        }
    }
    public function ExecuteAndFetchROWID(string $Query = '' , array $parameters = [] )
    {
        try {
            if ($Query == ''):
                throw new Exception("Error Processing Query", 1);
            else:
                $stmt = $this->connection->prepare($Query);
                foreach ($parameters as $key => $value):
                    $stmt->bindValue($key , $value);
                endforeach;
                $this->connection->beginTransaction(); 
                $stmt->execute();
                $id =  $this->connection->lastInsertId();
                $this->connection->commit();
                return $id;
            endif;
        } catch (PDOException $e) {
            die("Faild to connect " . $e->getMessage());
        }
    }
}
if(!function_exists('RequireAll')):
    function RequireAll($dir = '', $extention = 'php')
    {
        
        global $app ;
            try 
            {
                $glopOption = $dir .'/' . '*.' . $extention;
                foreach (glob($glopOption) as $file) {
                    require_once $file;
                }
            } catch (\Throwable $th) {
                throw $th;
            }
    }
endif;
?>