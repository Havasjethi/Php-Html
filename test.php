<?php

use function PHPSTORM_META\map;

require_once 'HtmlElement.php';
use HavasHtml\HtmlElement;


function __autoload ($e) {
    require_once "elements/$e.php";
}

function create () {
    return new HtmlElement('div', false, 'Hello world');
}

function div_span_span () {
    $div = new HtmlElement('div', false);
    $span1 = new HtmlElement('span', false, 'Hello');
    $span2 = new HtmlElement('span', false, ' world!');

    $div->add_child($span1);
    $div->add_child($span2);

    return $div;
}

function div_span_span2 () {
    $div = new HtmlElement('div', false);
    $span1 = new HtmlElement('span', false, 'Hello');
    $span2 = new HtmlElement('span', false, ' world!');

    $div->set_children([$span1, $span2]);

    return $div;
}

function attributes() {
    $e = new HtmlElement('div', false, 'Asd');

    // $e->add_single("required");
    $e->add_double("size", 15);
    $e->add_double("color", "red");
    $e->add_multip("class", "cl1");
    $e->add_multip("class", "class2");

    return $e;
}

function add_elemet (HtmlElement $e) {
    $element = new HtmlElement('div', false);
    $element->add_child($e);

    return $element;
}

//$element div_span_span2();
// $some = attributes();
// $element = add_elemet($some);

// $some->parent->add_child(new HtmlElement("span", false, 'Szomi'));

// $s1 = new SpanElement('1-1-1');
$s2 = new SpanElement('2-2-2');
// $s3 = new SpanElement('3-3-3');
$s = 'content';
echo $s2->$s;

// $d1 = new DivElement('', [$s1, $s2, $s3]);
// $d2 = new DivElement('', [new SpanElement('asd'), new SpanElement('fgh'), new SpanElement('jkl')]);

// $main = new HtmlElement('main', false, '', [$d1, $d2]);

// // $e = div_span_span2();
// // $ev = end($e->children)->prev;
// // $ev->remove();
// // echo $e->print();
// $s2->remove();
// $d1->add_child(new DivElement());
// $d1->add_child(new DivElement());
// echo $main->print(); 
// echo "\n";

// // $arr = [];
// // $arr = [1,2,3, 0];
// // $s = end($arr);

// // if ($s == null) {
// //     echo "Null";
// // } else {
// //     echo "Not null";
// // }

// $arr = [1];
// unset($arr[0]);
// $arr = [];
// $arr[] = 2;

// print_r($arr);
// echo count($arr);



echo "\n";
