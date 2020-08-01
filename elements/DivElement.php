<?php

use HavasHtml\HtmlElement;

class DivElement extends HtmlElement {

    function __construct(string $context = '', array $children = [])
    {
        parent::__construct('div', false, $context, $children);
    }
}