<?php 
// 数据库操作类
class Model{
    public $field;
    public $tab;
    public $where;
    public $order;
    public $limit;

// 构造函数，初始化参数
    function __construct($tab){
        mysql_connect(HOST,USER,PASS);
        mysql_select_db(DBNAME);
        mysql_query("set names utf8");
        $this->tab = $tab;
    }

// 组合字段
    function field($field){
        $this->field = $field;
        return $this;
    }

// 组合条件
    function where($where){
        $this->where = "where " . $where;
        return $this;
    }

// 组合排序
    function order($order){
        $this->order = "order by " . $order;
        return $this;
    }

// 组合输出条数
    function limit($limit){
        $this->limit = "limit " . $limit;
        return $this;
    }

// 组合查询语句
    function select(){
        $sql = "select {$this->field} from {$this->tab} {$this->where} {$this->order} {$this->limit}";
        $rst = mysql_query($sql);
        while($row = @mysql_fetch_assoc($rst)){
            $rows[] = $row;
        }
        return $rows;
    }

// 组合插入语句
    function insert($insert){        
        foreach ($insert as $key => $val) {
            $keys[] = $key;
            $vals[] = "'".$val."'";
        }
        $fields = join(',',$keys);
        $values = join(',',$vals);
        $sql = "insert into {$this->tab}({$fields}) values({$values})";
        if (mysql_query($sql)) {
            return mysql_insert_id();
        } else {
            return false;
        }
    }

// 组合删除语句
    function delete(){
        $sql = "delete from {$this->tab} {$this->where}";
        if ($this->where) {
            if (mysql_query($sql)) {
                return mysql_affected_rows();
            }else{
                return false;
            }
        } else {
            echo "<script>alert('删除操作需要指定ID！')</script>";
        }
        
        
    }

// 组合修改语句
    function update($update){
        foreach ($update as $key => $val) {
            $set[] = $key."='".$val."'";
        }
        $sets = join(',',$set);
        $sql ="update {$this->tab} set {$sets} {$this->where}";
        if ($this->where) {
            if (mysql_query($sql)) {
                return mysql_affected_rows();
            }else{
                return false;
            }
        } else {
            echo "<script>alert('修改操作需要指定ID！')</script>";
        }
        

        
    }

// 只查第一行
    function find(){
        if($this->order){
            $sql = "select * from {$this->tab} {$this->where} {$this->order} limit 1";
        }else{
            $sql = "select * from {$this->tab} {$this->where} order by id limit 1";
        }
        $rst = mysql_query($sql);
        $row = @mysql_fetch_assoc($rst);
        return $row;
    }

// 输出总条数
    function count(){
        $sql = "select count(*) from {$this->tab} {$this->where}";
        $rst = mysql_query($sql);
        $row = @mysql_fetch_row($rst);
        return $row[0];

    }

}

//Model类工厂
function M($tab){
    return new Model($tab);
}


 ?>