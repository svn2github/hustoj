<?php

/**
* 数据库备份还原类
* @author 
* Class DatabaseTool
*/
class DatabaseTool
{
    private $handler;
    private $config = array(
        'host' => 'localhost',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
        'database' => 'lk2',
        'charset' => 'utf-8',
        'target' => 'sql.sql'
    );
    private $tables = array();
    private $error;
    private $begin; //开始时间

    /**
    * 架构方法
    * @param array $config
    */
    public function __construct($config = array())
    {
        $this->begin = microtime(true);
        $config = is_array($config) ? $config : array();
        $this->config = $config;
        //启动PDO连接
        if (!$this->handler instanceof PDO) {
            try {
                $this->handler = new PDO("mysql:host={$this->config['host']}:{$this->config['port']};dbname={$this->config['database']}", $this->config['user'], $this->config['password']);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
		echo $this->error;
                return false;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
		echo $this->error;
                return false;
            }
        }
    }

    /**
    * 备份
    * @param array $tables
    * @return bool
    */
    public function backup($tables = array())
    {
        //存储表定义语句的数组
        $ddl = array();
        //存储数据的数组
        $data = array();
        $this->setTables($tables);

        if (!empty($this->tables)) {
            foreach ($this->tables as $table) {
                $ddl[] = $this->getDDL($table);
                $data[] = $this->getData($table);
            }
            //开始写入

            //var_dump($data);
            $this->writeToFile($this->tables, $ddl, $data);
        } else {
            $this->error = '数据库中没有表!';
            return false;
        }
    }

    /**
    * 设置要备份的表
    * @param array $tables
    */
    private function setTables($tables = array())
    {
        if (!empty($tables) && is_array($tables)) {
            //备份指定表
            $this->tables = $tables;
        } else {
            //备份全部表
            $this->tables = $this->getTables();
        }
    }

    /**
    * 查询
    * @param string $sql
    * @return mixed
    */
    private function query($sql = '')
    {
        $stmt = $this->handler->query($sql);
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $list = $stmt->fetchAll();
        return $list;
    }

    /**
    * 获取全部表
    * @return array
    */
    private function getTables()
    {
        $sql = 'SHOW TABLES';
        $list = $this->query($sql);
        $tables = array();
        foreach ($list as $value) {
            $tables[] = $value[0];
        }
        return $tables;
    }

    /**
    * 获取表定义语句
    * @param string $table
    * @return mixed
    */
    private function getDDL($table = '')
    {
        $sql = "SHOW CREATE TABLE `{$table}`";
        $ddl = $this->query($sql)[0][1] . ';';
        return $ddl;
    }

    /**
    * 获取表数据
    * @param string $table
    * @return mixed
    */
    private function getData($table = '')
    {
        $sql = "SHOW COLUMNS FROM `{$table}`";
        $list = $this->query($sql);
        //字段
        $columns = '';
        //需要返回的SQL
        $query = '';
        foreach ($list as $value) {
            $columns .= "`{$value[0]}`,";
        }
        $columns = substr($columns, 0, -1);
        $data = $this->query("SELECT * FROM `{$table}`");
        foreach ($data as $value) {
            $dataSql = '';
            foreach ($value as $v) {
                $dataSql .= "'{$v}',";
            }
            $dataSql = substr($dataSql, 0, -1);
            $query .= "INSERT INTO `{$table}` ({$columns}) VALUES ({$dataSql});\r\n";
        }
        return $query;
    }

    /**
    * 写入文件
    * @param array $tables
    * @param array $ddl
    * @param array $data
    */
    private function writeToFile($tables = array(), $ddl = array(), $data = array())
    {
        $str = "/*\r\nMySQL Database Backup Tools\r\n";
        $str .= "Server:{$this->config['host']}:{$this->config['port']}\r\n";
        $str .= "Database:{$this->config['database']}\r\n";
        $str .= "Data:" . date('Y-m-d H:i:s', time()) . "\r\n*/\r\n";
        $str .= "SET FOREIGN_KEY_CHECKS=0;\r\n";
        $i = 0;
        foreach ($tables as $table) {
            $str .= "-- ----------------------------\r\n";
            $str .= "-- Table structure for {$table}\r\n";
            $str .= "-- ----------------------------\r\n";
            $str .= "DROP TABLE IF EXISTS `{$table}`;\r\n";
            $str .= $ddl[$i] . "\r\n";
            $str .= "-- ----------------------------\r\n";
            $str .= "-- Records of {$table}\r\n";
            $str .= "-- ----------------------------\r\n";
            $str .= $data[$i] . "\r\n";
            $i++;
        }
        echo file_put_contents($this->config['target'], $str) ? 'Backup Finished! Time' . (microtime(true) - $this->begin) . 'ms' : 'Fail!';
    }

    /**
    * 错误信息
    * @return mixed
    */
    public function getError()
    {
        return $this->error;
    }

    public function restore($path = '')
    {
        if (!file_exists($path)) {
            $this->error('SQL文件不存在!');
            return false;
        } else {
            $sql = $this->parseSQL($path);
            try {
                $this->handler->exec($sql);
                echo '还原成功!花费时间', (microtime(true) - $this->begin) . 'ms';
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }
    }

    /**
    * 解析SQL文件为SQL语句数组
    * @param string $path
    * @return array|mixed|string
    */
    private function parseSQL($path = '')
    {
        $sql = file_get_contents($path);
        $sql = explode("\r\n", $sql);
        //先消除--注释
        $sql = array_filter($sql, function ($data) {
            if (empty($data) || preg_match('/^--.*/', $data)) {
                return false;
            } else {
                return true;
            }
        });
        $sql = implode('', $sql);
        //删除/**/注释
        $sql = preg_replace('/\/\*.*\*\//', '', $sql);
        return $sql;
    }
}
