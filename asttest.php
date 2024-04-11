<?php
require __DIR__ . '/vendor/autoload.php';
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\PrettyPrinter;
$code = <<<'CODE'

<?php

function test($foo)
{
    var_dump($foo);
}

CODE;

//コードの解析を行う
$parser = (new ParserFactory())->createForNewestSupportedVersion();
try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}

//トラバース(変更・加工)する
$traverser = new NodeTraverser();
$traverser->addVisitor(new class extends NodeVisitorAbstract {
    public function enterNode(Node $node) {
        if ($node instanceof Function_) {
            // Clean out the function body
            $node->stmts = [];
        }
    }
});
$ast = $traverser->traverse($ast);

$prettyPrinter = new PrettyPrinter\Standard;
echo $prettyPrinter->prettyPrintFile($ast);


echo "\n";
echo "-----------------------------------------------------";
echo "\n";

$dumper = new NodeDumper;
echo $dumper->dump($ast) . "\n";
