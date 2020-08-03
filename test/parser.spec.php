<?php

use HavasHtml\HtmlParser;
require_once dirname(__DIR__) . '/HtmlParser.php';

$first = '
<main >
    <div>
        <span>1-1-1</span>
    </div>
    <span>2-2-2</span>
</main>';
$sec = '<main><div><span>1-1-1</span><span>3-3-3</span><div></div><div></div></div><div><span>asd</span><span>fgh</span><span>jkl</span></div></main>';
$final = '
<a class="w3-button w3-bar-item w3-light-grey" target="_blank" href="tryit.asp?filename=tryhtml_formatting_q">Formatting short quotations with the &lt;q&gt; element.</a>
<a class="w3-button w3-bar-item w3-light-grey w3-border-top" target="_blank" href="tryit.asp?filename=tryhtml_formatting_blockquote">Formatting quoted sections with the &lt;blockquote&gt; element.</a>
<a class="w3-button w3-bar-item w3-light-grey w3-border-top" target="_blank" href="tryit.asp?filename=tryhtml_formatting_address">Formatting document author/owner information with the &lt;address&gt; element</a>
<a class="w3-button w3-bar-item w3-light-grey w3-border-top" target="_blank" href="tryit.asp?filename=tryhtml_formatting_abbr">Formatting abbreviations and acronyms the &lt;abbr&gt; element</a>
<a class="w3-button w3-bar-item w3-light-grey w3-border-top" target="_blank" href="tryit.asp?filename=tryhtml_formatting_cite">Formatting work title with the &lt;cite&gt; element</a>
<a class="w3-button w3-bar-item w3-light-grey w3-border-top" target="_blank" href="tryit.asp?filename=tryhtml_formatting_bdo">Formatting text direction with the &lt;bdo&gt; element</a>
';

$parser = new HtmlParser();

$e = $parser->parse($first);


echo $e->print();