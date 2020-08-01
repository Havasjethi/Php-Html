<?php

use HavasHtml\HtmlElement;

class SpanElement extends HtmlElement {

    function __construct(string $context = '', array $children = [])
    {
        parent::__construct('span', false, $context, $children);
    }
}