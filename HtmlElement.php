<?php

namespace HavasHtml;

class HtmlElement {
    public $tag;
    public $single;

    public $content;

    /**
     * @var HtmlElement
     */
    public $parent; 

    /**
     * @var HtmlElement
     */
    public $next;

    /**
     * @var HtmlElement
     */
    public $prev;

    /**
     * @var HtmlElement[]
     */
    public $children;
    protected $child_id;    // Old:: nth_child 

    public $attr_single;
    public $attr_double;

    /**
     * @var stirng[][]
     */
    public $attr_multip;
    
    function __construct(string $tag, bool $single = false, string $content = '', array $children = []) {
        $this->tag = $tag;

        $this->single = $single;
        $this->content = $content;

        $this->parent = null;
        $this->next = null;
        $this->prev = null;
        
        $this->attr_single = [];
        $this->attr_double = [];
        $this->attr_multip = [];

        $this->set_children($children);
    } 

    function add_child (HtmlElement $element) {
        $element->parent = $this;
        $element->prev = count($this->children) === 0 ? null : end($this->children);
        $element->next = null;
        
        if ($element->prev !== null) {
            $element->prev->next = $element;
        }

        $element->child_id = end($this->children) ? end($this->children)->child_id + 1 : 0 ; 
        $this->children[] = $element;
    }

    /** @param HtmlElement[] $element */
    function add_children (array $elements) {
        foreach ($elements as $e) {
            $this->add_child($e);
        }
    }

    /** @param HtmlElement[] $element */
    public function set_children (array $elements) {
        $this->children = [];
        $this->add_children($elements);
    }

    public function remove() {
        if ($this->prev !== null) {
            $this->prev->next = $this->next;
        }
        
        if ($this->next !== null) {
            $this->next->prev = $this->prev;
        }

        if ($this->parent !== null) {
            unset($this->parent->children[$this->child_id]);
            if (count ($this->parent->children) === 0) {
                $this->parent->children = [];
            }
        }
    }
    
    public function add_single (string $attribute) {
        $this->attr_single[] = $attribute;
    }

    public function remove_single_attributes (string ...$attributes) {
        $this->attr_single = array_diff($this->attr_single, $attributes);
    }

    public function remove_single (string $attribute) {
        $this->remove_attribute('attr_single', $attribute);
    } 



    public function add_double (string $attribute, $value) {
        $this->attr_double[$attribute] = $value;
    }

    public function remove_double () { }
    public function remove_double_attributes () { }

    public function add_multip (string $attribute, $value) {
        if (!array_key_exists($attribute, $this->attr_multip)) {
            $this->attr_multip[$attribute] = [];
        }

        array_push($this->attr_multip[$attribute], $value);
    }

    public function clear_multip (string $attribute, $value) { }
    public function remove_multip ($key, $value) { }

    private function remove_attribute (string $attribure_array, $value) {
        $key = array_search($value, $this->$attribure_array);

        if ( $key !== false ) {
            unset($this->$attribure_array[$key]);
        }
    }

    public function print (): string {
        $attributes = $this->build_attributes();
        
        $opening = '<' . $this->tag . ($attributes ? ' ' . $attributes : '');
        $ending = $this->single 
                    ? '/>'
                    : '>' . $this->content . $this->print_children() .  '</' . $this->tag . '>';

        return $opening . $ending;
    }

    protected function build_attributes (): string {
        $single_builder = '';
        foreach ($this->attr_single as $value) {
            $single_builder.= "$value ";
        }

        $double_builder = '';
        foreach ($this->attr_double as $key => $value) {
            $double_builder.= "$key=\"$value\" ";
        }

        $mulitp_builder = '';
        foreach ($this->attr_multip as $attr => $arr) {
            $values = '';
            foreach ($arr as $value) {
                $values .= "$value ";
            } 
            $mulitp_builder .= "$attr=\"$values\" ";
        }

        return $mulitp_builder . $double_builder. $single_builder; 
    } 

    protected function print_children (): string {
        $string_builder = '';
        foreach ($this->children as $child) {
            $string_builder .= $child->print();
        }

        return $string_builder;
    }
}
