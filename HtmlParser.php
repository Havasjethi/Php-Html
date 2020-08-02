<?php

namespace HavasHtml;

class Type {
    const opening = 0;
    const closing = 1;
    const single = 2;
    const element = 3;
}

class Characters {
    const ending = '<';
    const opening = '>';
    const slash = '/';
}

class Classificed {
    /** @var Type */
    public $type;
    public $value;
}

class HtmlParser {
    private $stack;
    private $was_tag;
    private $single;

    function init () {
        $this->stack = [];
        $this->was_tag = false;
        $this->single = null;
    } 

    function add_to_stack (Classificed $e) {
        if ($e->type === Type::closing) {
            $this->compose($e);
        } else {
            $this->stack[] = $e;
        }
    }

    function compose (Classificed $e) {
        $index = count($this->stack) - 1;
        $children = [];

        do {
            $current = $this->stack[$index];

        } while ( $current->type !== Type::opening && $children[] = array_splice($this->stack, $index, 1)[0] );

        $e = new HtmlElement('tag', false, 'context', $children);
        $csfd = new Classificed ();
        $csfd->type = Type::element;
        $csfd->value = $e;

        $this->add_to_stack($csfd);
    }

    /**
     * @return (string, stirng[], (string, string)[], (string, string[])[]) tage_name, single-, double- multiple attributes
     */
    function parse_attributes (string $text) {
        // TODO implement
    }

    function has_tag_name (string $text): bool {
        // TODO :: 
        // If whithespace > 1 || has text in it
        return true;
    }

    function parse (string $html_string): HtmlElement {
        // TEST THIS :: And then add spaces or .. where (whitespace){2, }
        // $string = preg_replace('/\s+/', '', $string);
        $this->init();
        $inside = null;

        $context = '';
        $attribute_string = '';

        // TODO :: Iterate over string
        // TODO :: Remove unecessary whithespaces

        $c = '';

        switch ($c) {
            case Characters::slash:
                $this->single = $this->has_tag_name($attribute_string);
            break;

            case Characters::ending:
                $type = $this->single === null ? Type::opening : $this->single ? Type::single : Type::closing;
                $csfd = new Classificed();
                $csfd->value = null; // ! TODO ! 
                $csfd->type = $type; 

                $this->add_to_stack($csfd);

                $attribute_string = '';
                $context = '';
                $inside = false;
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

        return $this->stack[0]->value; // After the process this should be and element typed stuff  
    }
}
