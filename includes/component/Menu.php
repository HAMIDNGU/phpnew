<?php

class Menu {
    // members
    public $id;
    private $items = [];
    private $sortDesc = true;


    function __construct($id) {
        $this->id = $id;
    }

    public function setDesc($yes) {
        if($yes === $this->sortDesc) {
            return;
        }
        $this->sortDesc = $yes;
        $this->sortMenu();
    }

    private function sortMenu() {
        uasort($this->items, function($a, $b) {
            if($a['order'] === $b['order']) {
                return 0;
            }
            if($this->sortDesc) {
                return $a['order'] < $b['order'] ? -1 : 1;
            } else {
                return $a['order'] > $b['order'] ? -1 : 1;
            }
        });
    }

    public function addItem($text, $page, $order=0) {
        // cleanup our page (key)
        $page = strtolower(str_replace(' ','',trim($page)));

        $this->items[$page] = ["text"=>$text, 
                                'order'=>$order, 
                                'active'=>false];
        $this->sortMenu();
    }
    // page, text, order, active
    public function render() {
        $strOut = "<ul class=\"{$this->id}\">";
       foreach($this->items as $k => $v) {
            $strOut .= "<li><a href=\"?p=$k\">{$v['text']}</a></li>";
       }
       $strOut .= "</ul>";
       return $strOut;
    }
}

?>