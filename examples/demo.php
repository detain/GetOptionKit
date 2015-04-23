#!/usr/bin/env php
<?php
/*
 * This file is part of the GetOptionKit package.
 *
 * (c) Yo-An Lin <cornelius.howl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */
require 'vendor/autoload.php';

use GetOptionKit\OptionCollection;
use GetOptionKit\OptionParser;

$specs = new OptionCollection;
$specs->add('f|foo:', 'option requires a value.' )
    ->isa('String');

$specs->add('b|bar+', 'option with multiple value.' )
    ->isa('Number');

$specs->add('z|zoo?', 'option with optional value.' )
    ->isa('Boolean')
    ;

$specs->add('o|output?', 'option with optional value.' )
    ->isa('File')
    ->defaultValue('output.txt')
    ;

$specs->add('file:', 'option value should be a file.' )
    ->trigger(function($value) {
        echo "Set value to :";
        var_dump($value);
    })
    ->isa('File');

$specs->add('v|verbose', 'verbose message.' );
$specs->add('d|debug', 'debug message.' );
$specs->add('long', 'long option name only.' );
$specs->add('s', 'short option name only.' );

$printer = new GetOptionKit\OptionPrinter\ConsoleOptionPrinter;
echo $printer->render($specs);


$parser = new OptionParser($specs);

echo "Enabled options: \n";
try {
    $result = $parser->parse( $argv );
    foreach ($result as $key => $spec) {
        echo $spec . "\n";
    }
} catch( Exception $e ) {
    echo $e->getMessage();
}
