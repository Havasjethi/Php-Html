<?php

namespace HavasHtml;
require_once './HtmlElement.php';

class Type {
    const open = 0;
    const close = 1;
    const single = 2;
    const element = 3;
}

class Characters {
    const ending = '>';
    const opening = '<';
    const slash = '/';
}

class Classificed {
    /** @var Type */
    public $type;
    /** @var HtmlElement */
    public $value;
}

class HtmlParser {
    /** @var Classificed[] */
    private $stack;
    private $was_tag;
    private $single;

    function init () {
        $this->stack = [];
        $this->was_tag = false;
        $this->single = null;
    } 

    function add_to_stack (Classificed $e) {
        $this->stack[] = $e;
    }

    function compose (string $content = '') {
        $index = count($this->stack) - 1;
        $children = [];

        do {
            $current = $this->stack[$index];

        } while ( $current->type !== Type::open && (array_unshift($children, array_splice($this->stack, $index, 1)[0]->value)) && $index--);

        $turn_to_element = $this->stack[$index];
        $turn_to_element->type = Type::element;
        if ($content !== ''){
            $turn_to_element->value->content = $content; 
        }
        $turn_to_element->value->set_children($children);
    }

    function is_single (string $text): bool {
        return preg_match('/[\w\"][\s]*\//', $text);
    }

    function parse (string $html_string): HtmlElement {
        $this->init();
        
        $inside = null;
        $context = '';
        $attribute_string = '';

        $c = '';
        $max = strlen($html_string) - 1;
        $i = -1;

        while ($i++ < $max) {
            $c = $html_string[$i];

            switch ($c) {

                case Characters::slash:
                    $rv = $this->is_single($attribute_string);
                    if ($rv) {
                        echo "a php egy geci szar nyelv";
                    } else {
                        echo "De tényleg az";
                    }
                    $this->single = $rv;
                    echo "--$this->single--";
                break;

                case Characters::ending:
                    print_r($this->single === null);
                    $type = $this->single === null ? Type::open : ($this->single ? Type::single : Type::close);
                    
                    if ($type === Type::close) {
                        echo "\nComposing\n\n";
                        $this->compose($context);
                    } else {
                        $big = $this->parse_attributes($attribute_string);

                        $e = new HtmlElement($big[0], $this->single ?? false, $context);

                        $e->set_single($big[1]);
                        $e->set_double($big[2]);
                        $e->set_multy($big[3]);
    
                        $csfd = new Classificed();
                        $csfd->value = $e;
                        $csfd->type = $type; 
    
                        echo "\n\n" . $e ->print() . "\n\n";
                        $this->add_to_stack($csfd);
                    }

                    $attribute_string = '';
                    $context = '';
                    $inside = false;
                    $this->single = null;
                break;

                case Characters::opening:
                    $inside = true;
                break;

                default:
                    if ($inside === true) {
                        $attribute_string .= $c;
                    }

                    if ($inside === false) {
                        $context .= $c;
                    }
            }
        }
        return $this->stack[0]->value; // After the process this should be and element typed stuff  
    }
    /**
     * @return (string, stirng[], (string, string)[], (string, string[])[]) tage_name, single-, double- multiple attributes
     */
    function parse_attributes (string $text) {
        $some = preg_replace('/\s+/', ' ', $text);
        $splitted = explode(' ', $some); // Fucks up class="a b c"

        /* TODO :: Redo function based on parser_solution.ts */



        // $holder = '';
        // $name_holder = '';
        // $first = '';

        // $single = [];
        // $double = [];
        // $multy = [];

        // $inside_multipe = false;
        // $inside = false;

        // $i = -1;
        // while($i++ < strlen($text)) {
        //     $c = $text[$i]; 
            
        //     if ($c === ' ' && !$inside_multipe) {
        //         if ($first === '') {
        //             $first = $holder;
        //             $holder = '';
        //         }

        //     } else if ($c === '=' && !$inside) {
        //         $name_holder = $holder;
        //         $holder = '';
        //     } else if ($c === '"') {
        //         $inside = !$inside;
        //         if (!$inside) {

        //         }
        //     } else {
        //         $holder .= $c;
        //     }
        // }

        // if (c != )

        // preg_match('', $some);


        // foreach ($splitted as $part) {

        // for ($i = 0; $i !== count($splitted); $i++ ) {
        //     $part = $splitted[$i];
        //     while (strpos($part, "\"") && substr($part, -1) !== "\"") {//$this->count_character($part, "\"") !== 2) {
        //         $i++;
        //         $part .= $splitted[$i];
        //     } 

        //     if ($part === ' ' || $part === '/'){
        //         continue;
        //     } else if ($first === '')  {
        //         $first = $part;
        //     } else if (strpos($part, '=') !== false) {
        //         $expoloded = explode('=', $part);
        //         $name = $expoloded[0];
        //         $stripped = substr($expoloded[1], 1, strlen($expoloded[1]) - 3);
        //         $stripped = trim($stripped);

        //         if (strlen($stripped) === 0) {
        //             $single[] = $name;
        //         } else {
        //             $text = explode($stripped, ' ');
        //             if (count($text) === 1) {
        //                 $double[$name] = $text;
        //             } else {
        //                 $multy[$name] = $text;
        //             }
        //         }
        //     }
        // }

        
        return [$first, $single, $double, $multy];
    }

    function count_character ($string, $char): int {
        $count = 0;
        for ($i = 0; $i != strlen($string); $i++) {
            if ($string[$i] === $char) {
                $count++;
            }
        }
        return $count;  
    }

}

