<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HtmlElement2
 *
 * @author cl2811
 */

class HtmlObject {
    public $tag;
    public $properties = array();
    public $html;
    
    protected function render_html(){
        $html = '<' . $this->tag . ' ';
        $i=0;
		foreach ($this->properties as $prop_k => $prop_v){
            $html .= $prop_k .'="'. $prop_v .'" ';
		$t[$i]=$prop_v;
		$i++;
        }
        $html .= '>';
        $this->html = $html;
    }
    
    public function attr($property, $value) {
        $this->properties[$property] = $value;
    }
    
    public function get_html(){
        $this->render_html();
        return $this->html;
    }


    public function print_html() {
        $this->render_html();
        echo $this->html;
    }
    
    public function __construct($html_tag) {
        $this->tag = $html_tag;
    }
}
