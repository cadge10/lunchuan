<?php
// 分页类

class page {
    // 分页栏每页显示的页数
    public $rollPage = 5;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 默认列表每页显示行数
    public $listRows = 20;
    // 起始行数
    public $firstRow	;
    // 分页总页面数
    protected $totalPages  ;
    // 总行数
    protected $totalRows  ;
    // 当前页数
    protected $nowPage    ;
    // 分页的栏的总页数
    protected $coolPages   ;
	// 是否显示记录条数
	public $isHeader = true;
    // 分页显示定制
    protected $config  =	array('header'=>'条记录','prev'=>'上一页','next'=>'下一页');
    // 默认分页变量名
    protected $varPage;

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     +----------------------------------------------------------
     */
    public function __construct($totalRows,$listRows='',$parameter='') {
        $this->totalRows = $totalRows;
        $this->parameter = $parameter;
		if (!defined('VAR_PAGE')) define('VAR_PAGE','page');
        $this->varPage = VAR_PAGE;
        if(!empty($listRows)) {
            $this->listRows = intval($listRows);
        }
        $this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages  = ceil($this->totalPages/$this->rollPage);
        $this->nowPage  = !empty($_GET[$this->varPage])?intval($_GET[$this->varPage]):1;
        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows*($this->nowPage-1);
    }

    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }

    /**
     +----------------------------------------------------------
     * 分页显示输出
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p = $this->varPage;
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
        $url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
        $parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            unset($params[$p]);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }
		$array = $this->parameter;
		$setpages =  $this->rollPage;

		$num =$this->totalRows;
		$perpage = $this->listRows;		
		$curr_page = $this->nowPage;
		
		$pageStr = '';
		if($num > $perpage) {
			$page = $setpages+1;
			$offset = ceil($setpages/2-1);
			$pages = ceil($num / $perpage);
			$from = $curr_page - $offset;
			$to = $curr_page + $offset;
			$more = 0;
			if($page >= $pages) {
				$from = 2;
				$to = $pages-1;
			} else {
				if($from <= 1) {
					$to = $page-1;
					$from = 2;
				}  elseif($to >= $pages) { 
					$from = $pages-($page-2);  
					$to = $pages-1;  
				}
				$more = 1;
			}
			
			if ($this->isHeader == true) 
				$pageStr .= '<a class="info">'.$num.$this->config['header'].'</a>';
			
			if($curr_page>0) {
				$prepage=max(1,$curr_page-1);
				if($curr_page>1) {
					$pageStr .= ' <a href="'.$url.'&'.$p.'='.$prepage.'">'.$this->config['prev'].'</a>';
				}
				if($curr_page==1) {
					$pageStr .= ' <a class="current">1</a>';
				} elseif($curr_page>3 && $more) {
					$pageStr .= ' <a href="'.$url.'&'.$p.'=1">1...</a>';
				} else {
					$pageStr .= ' <a href="'.$url.'&'.$p.'=1">1</a>';
				}
			}
			
			for($i = $from; $i <= $to; $i++) {
				if($i != $curr_page) { 
					$pageStr .= ' <a href="'.$url.'&'.$p.'='.$i.'">'.$i.'</a>'; 
				} else { 
					$pageStr .= ' <a class="current">'.$i.'</a>'; 
				} 
			}
			
			if($curr_page<$pages) {
				if($curr_page<$pages-2 && $more) {
					$pageStr .= ' <a href="'.$url.'&'.$p.'='.$pages.'">...'.$pages.'</a> <a href="'.$url.'&'.$p.'='. ($curr_page+1) .'">'.$this->config['next'].'</a>';
				} else {
					$pageStr .= ' <a href="'.$url.'&'.$p.'='.$pages.'">'.$pages.'</a> <a href="'.$url.'&'.$p.'='. ($curr_page+1) .'">'.$this->config['next'].'</a>';
				}
			} elseif ($curr_page==$pages) {
				$pageStr .= ' <a class="current">'.$pages.'</a>';
			} else {
				$pageStr .= ' <a href="'.$url.'&'.$p.'='.$pages.'">'.$pages.'</a> <a href="'.$url.'&'.$p.'='. ($curr_page+1) .'">'.$this->config['next'].'</a>';
			}
			
		}
		
		return $pageStr;
    }

}
/*
分页样式，可适当调整

.page_style{text-align:right;font-size:14px;line-height:24px; font-family:Arial;}
.page_style a,.page_style a:link,.page_style a:visited{color:#616161;text-decoration:none;outline:0 none}
.page_style a:hover{color:#FF5A00;text-decoration:none}
.page_style a,.page_style .current{border:solid 1px #CECECE;line-height:22px;padding:0 7px;font-size:14px;display:inline-block;vertical-align:middle;background:#FFF}
.page_style .current{color:#FF5A00;}

*/
?>