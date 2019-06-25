# php-num2str
Wrapper class for solving the problem of converting a number to a string.<br><br>
correct input:<br> 1234.23<br>1 234.23<br>1,234.23<br><br>
incorrect input:<br> 12r34.23<br>1234.233 _(only cents < 100) - will be implemented later_<br><br>
You can change cents delimiter in _`MyNumberFormatter.php:10`_ (`CENTS_DELIMITER`).<br><br>
_`index.php`_ - demo 

**=========example=========**<br><br> 
**input:** 1 000 000 000 000 000 000 001 000 000 000.23<br><br>
**output:**<br> 
_1 000 000 000 000 000 000 001 000 000 000.23<br>
==================<br>
one nonillion one billion  and twenty tree cents<br>
==================_
