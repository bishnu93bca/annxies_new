/*
Copyright (c) 2008-2010 Yahoo! Inc.  All rights reserved.
The copyrights embodied in the content of this file are licensed by
Yahoo! Inc. under the BSD (revised) open source license

@author Vlad Dan Dascalescu <dandv@yahoo-inc.com>


Tokenizer for PHP code

References:
  + http://php.net/manual/en/reserved.php
  + http://php.net/tokens
  + get_defined_constants(), get_defined_functions(), get_declared_classes()
      executed on a realistic (not vanilla) PHP installation with typical LAMP modules.
      Specifically, the PHP bundled with the Uniform Web Server (www.uniformserver.com).

*/


// add the forEach method for JS engines that don't support it (e.g. IE)
// code from https://developer.mozilla.org/En/Core_JavaScript_1.5_Reference:Objects:Array:forEach
if (!Array.prototype.forEach)
{
  Array.prototype.forEach = function(fun /*, thisp*/)
  {
    var len = this.length;
    if (typeof fun != "function")
      throw new TypeError();

    var thisp = arguments[1];
    for (var i = 0; i < len; i++)
    {
      if (i in this)
        fun.call(thisp, this[i], i, this);
    }
  };
}


var tokenizePHP = (function() {
  /* A map of PHP's reserved words (keywords, predefined classes, functions and
     constants. Each token has a type ('keyword', 'operator' etc.) and a style.
     The style corresponds to the CSS span class in phpcolors.css.

     Keywords can be of three types:
     a - takes an expression and forms a statement - e.g. if
     b - takes just a statement - e.g. else
     c - takes an optinoal expression, but no statement - e.g. return
     This distinction gives the parser enough information to parse
     correct code correctly (we don't care that much how we parse
     incorrect code).

     Reference: http://us.php.net/manual/en/reserved.php
  */
  var keywords = function(){
    function token(type, style){
      return {type: type, style: style};
    }
    var result = {};

    // for each(var element in ["...", "..."]) can pick up elements added to
    // Array.prototype, so we'll use the loop structure below. See also
    // http://developer.mozilla.org/en/Core_JavaScript_1.5_Reference/Statements/for_each...in

    // keywords that take an expression and form a statement
    ["if", "elseif", "while", "declare"].forEach(function(element, index, array) {
      result[element] = token("keyword a", "php-keyword");
    });

    // keywords that take just a statement
    ["do", "else", "try" ].forEach(function(element, index, array) {
      result[element] = token("keyword b", "php-keyword");
    });

    // keywords that take an optional expression, but no statement
    ["return", "break", "continue",  // the expression is optional
      "new", "clone", "throw"  // the expression is mandatory
   