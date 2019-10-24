--TEST--
Javascript Code with Scope: Empty code string, empty scope
--DESCRIPTION--
Generated by scripts/convert-bson-corpus-tests.php

DO NOT EDIT THIS FILE
--FILE--
<?php

require_once __DIR__ . '/../utils/tools.php';

$canonicalBson = hex2bin('160000000F61000E0000000100000000050000000000');
$canonicalExtJson = '{"a" : {"$code" : "", "$scope" : {}}}';

// Canonical BSON -> Native -> Canonical BSON 
echo bin2hex(fromPHP(toPHP($canonicalBson))), "\n";

// Canonical BSON -> Canonical extJSON 
echo json_canonicalize(toCanonicalExtendedJSON($canonicalBson)), "\n";

// Canonical extJSON -> Canonical BSON 
echo bin2hex(fromJSON($canonicalExtJson)), "\n";

?>
===DONE===
<?php exit(0); ?>
--EXPECT--
160000000f61000e0000000100000000050000000000
{"a":{"$code":"","$scope":{}}}
160000000f61000e0000000100000000050000000000
===DONE===