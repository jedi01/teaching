--TEST--
Decimal128: Special - Invalid representation treated as 0E3
--DESCRIPTION--
Generated by scripts/convert-bson-corpus-tests.php

DO NOT EDIT THIS FILE
--FILE--
<?php

require_once __DIR__ . '/../utils/tools.php';

$canonicalBson = hex2bin('18000000136400FFFFFFFFFFFFFFFFFFFFFFFFFFFF116C00');
$canonicalExtJson = '{"d" : {"$numberDecimal" : "0E+3"}}';

// Canonical BSON -> Native -> Canonical BSON 
echo bin2hex(fromPHP(toPHP($canonicalBson))), "\n";

// Canonical BSON -> Canonical extJSON 
echo json_canonicalize(toCanonicalExtendedJSON($canonicalBson)), "\n";

?>
===DONE===
<?php exit(0); ?>
--EXPECT--
18000000136400ffffffffffffffffffffffffffff116c00
{"d":{"$numberDecimal":"0E+3"}}
===DONE===