<?php

/**
 * @author electric
 * @copyright 2010
 */

class pagerAjax{
    var $url=null;
    var $total_record=null;
    var $total_page=null;
    var $scoll_page=null;
    var $per_page=null;
    var $curent_page=null;
    var $start=null;
    var $page_link=null;
    var $previous_page=null;
    var $next_page=null;
    var $firt_page=null;
    var $last_page=null;
    function total_pages($url,$total_record,$scoll_page,$per_page,$curent_page){
        $this->url=$url;
        $this->total_record=$total_record;
        $this->scoll_page=$scoll_page;
        $this->per_page=$per_page;
        if(!is_numeric($curent_page)){
            $this->curent_page=1;
        }else{
            $this->curent_page=$curent_page;
        }
        if($this->curent_page==1){
            $this->start=0;
        }else{
            $this->start=($this->curent_page-1)*$this->per_page;
        }
        $this->total_page=ceil($this->total_record/$this->per_page);
    }
    //thiet lap link cho cac nut chuyen trang
    function page_link($inaction_page,$page_url_lart,$class_li){
        if($this->total_page<=$this->scoll_page){
            if($this->total_record<=$this->per_page){
                $loop_start=1;
                $loop_finish=$this->total_page;
            }else{
                $loop_start=1;
                $loop_finish=$this->total_page;
            }
        }else{
            if($this->curent_page<intval(($this->scoll_page/2)+1)){
                $loop_start=1;
                $loop_finish=$this->scoll_page;
            }else{
                $loop_start=$this->curent_page-intval($this->scoll_page/2);
                 $loop_finish=$this->curent_page+intval($this->scoll_page/2);
                 if($loop_finish>$this->total_page){
                    $loop_finish=$this->total_page;
                 }
            }
        }
        for($i=$loop_start;$i<=$loop_finish;$i++){
            if($i==$this->curent_page){
                $this->page_link.='<li '.$inaction_page.'><a>'.$i.'</a></li>';
            }else{
                $this->page_link.='<li><a href="javascript:void(0)" title="'.$this->url.$i.$page_url_lart.'" class="'.$class_li.'">'.$i.'</a></li>';
            }
        }
    }
    function previous_page($previous_page_text,$page_url_last,$class_li){
        if($this->curent_page>1){
            $this->previous_page='<li><a href="javascript:void(0)" title="'.$this->url.($this->curent_page-1).$page_url_last.'" class="'.$class_li.'">'.$previous_page_text.'</a></li>';
        }
    }
     function next_page($next_page_text,$page_url_last,$class_li){
        if($this->curent_page<$this->total_page){
            $this->next_page='<li><a href="javascript:void(0)" title="'.$this->url.($this->curent_page+1).$page_url_last.'" class="'.$class_li.'">'.$next_page_text.'</a></li>';
        }
    }
    function firt_page($firt_page_text,$page_url_last,$class_li){
         if($this->curent_page>1){
            $this->firt_page='<li><a href="javascript:void(0)" title="'.$this->url.'1'.$page_url_last.'" class="'.$class_li.'">'.$firt_page_text.'</a></li>';
        }
    }
    function last_page($last_page_text,$page_url_last,$class_li){
         if($this->curent_page<$this->total_page){
            $this->last_page='<li><a href="javascript:void(0)" title="'.$this->url.$this->total_page.$page_url_last.'" class="'.$class_li.'">'.$last_page_text.'</a></li>';
        }
    }
    function page_set($url,$total_record,$scroll_page,$per_page,$current_page,$inaction_page,$previous_page_text,$next_page_text,$firt_page_text,$last_page_text,$class_li='',$page_url_last=''){
        $this->total_pages($url,$total_record,$scroll_page,$per_page,$current_page);
        $this->page_link($inaction_page,$page_url_lart,$class_li);
        $this-> previous_page($previous_page_text,$page_url_last,$class_li);
        $this-> next_page($next_page_text,$page_url_last,$class_li);
        $this->firt_page($firt_page_text,$page_url_last,$class_li);
        $this->last_page($last_page_text,$page_url_last,$class_li);
    }
}

?>