<?php 
class Page{
    public $tot;
    public $length;
    public $page;
    public $num;
    public $offset;
    public $totpage;
    public $prepage;
    public $nextpage;

    function __construct($tot,$length,$num){
        $this->tot = $tot;
        $this->length = $length;
        $this->page = $_GET['page']?$_GET['page']:1;
        $this->num = $num;
        $this->offset = $this->offset();
        $this->totpage = $this->totpage();
        $this->prepage= $this->prepage();
        $this->nextpage = $this->nextpage();
    }

    function offset(){
        return ($this->page - 1) * $this->length;
    }

    function totpage(){
        return ceil($this->tot / $this->length);
    }

    function prepage(){
        if ($this->page <= 1) {
            return 1;
        } else {
            return $this->page - 1;
        }
    }

    function nextpage(){
        if ($this->page >= $this->totpage) {
            return $this->totpage;
        } else {
            return $this->page + 1;
        }
    }

    function outpage(){

        session_start();

        // 判断网站语言
        if ($_GET['lang']) {
            $_SESSION['lang'] = $_GET['lang'];
        } else {
            if (!isset($_SESSION['lang'])) {
                $_SESSION['lang'] = 'zh-cn';
            }
        }
        include("../lang/lang.php");

        $current_page = $_GET['page'];
        echo "<li><a href='{$_SERVER['PHP_SELF']}?page=1'>{$lang['首页']}</a></li>";
        echo "<li><a href='{$_SERVER['PHP_SELF']}?page={$this->prepage}'>{$lang['上一页']}</a></li>";

        if($this->totpage <= $this->num){
            for ($i=1; $i <= $this->totpage; $i++) { 
                if ($current_page == $i) {
                    echo "<li class='active'><span>{$i}</span></li>";           
                }else{
                    echo "<li><a href='{$_SERVER['PHP_SELF']}?page={$i}'> {$i} </a></li>";
                }
            }
        }else{
            if ($this->page <= ($this->num+1)/2) {
                for ($i = 1; $i <= $this->num ; $i++) { 
                    if ($current_page == $i) {
                        echo "<li class='active'><span>{$i}</span></li>";           
                    }else{
                        echo "<li><a href='{$_SERVER['PHP_SELF']}?page={$i}'> {$i} </a></li>";
                    }
                }
            } elseif($this->page < $this->totpage - ($this->num-1)/2) {
                for ($i = $this->page - ($this->num-1)/2; $i <= $this->page + ($this->num-1)/2 ; $i++) {
                    if ($current_page == $i) {
                        echo "<li class='active'><span>{$i}</span></li>";           
                    }else{
                        echo "<li><a href='{$_SERVER['PHP_SELF']}?page={$i}'> {$i} </a></li>";
                    }
                }
            }else{
                for ($i = $this->totpage - ($this->num-1); $i <= $this->totpage ; $i++) { 
                    if ($current_page == $i) {
                        echo "<li class='active'><span>{$i}</span></li>";           
                    }else{
                        echo "<li><a href='{$_SERVER['PHP_SELF']}?page={$i}'> {$i} </a></li>";
                    }
                }
            }
        }

        echo "<li><a href='{$_SERVER['PHP_SELF']}?page={$this->nextpage}'>{$lang['下一页']}</a></li>";
        echo "<li><a href='{$_SERVER['PHP_SELF']}?page={$this->totpage}'> {$lang['末页']}</a></li>";
        echo "<li><a>{$lang['共计']} ".$this->totpage." {$lang['页']}，".$this->tot." {$lang['条记录']}</a></li>";
        echo "<br><br>";

    }
}
 ?>