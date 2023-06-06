<?php

namespace App\Service;

class Stack
{
    public $top;
    public $stack = array();

    function __construct()
    {
        $this->top = -1;
    }

    public function isEmpty()
    {
        if ($this->top == -1) {
            return true;
        } else {
            return false;
        }
    }

    public function push($x)
    {
        $this->stack[++$this->top] = $x;
    }

    public function pop()
    {
        if ($this->top >= 0) {
            unset($this->stack[$this->top--]);
        }
    }

    public function topElement()
    {
        if ($this->top >= 0) {
            return $this->stack[$this->top];
        }
    }
}
