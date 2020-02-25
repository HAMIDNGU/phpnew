<?php

class Menu {
    // members
    public $id;
    private $items = [];
    private $sortDesc = true;


    function __construct($id) {
        $this->id = $id;
    }


    public function addItem($text, $page) {
        // cleanup our page (key)
        $page = strtolower(str_replace(' ','',trim($page)));

        $this->items[$page] = ["text"=>$text, 
                                'active'=>false];

    }
    // page, text, order, active
    public function render() {
        $strOut = "<nav><ul id=\"{$this->id}\">";
       foreach($this->items as $k => $v) {
            $strOut .= "<li><a href=\"?p=$k\">{$v['text']}	&nbsp; </a></li>";
       }
       $strOut .= "</ul></nav>";
       return $strOut;
    }
}

?>