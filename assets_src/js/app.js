/*
  Automatically instantiates modules based on data-attrubiutes
  specifying module file-names.
*/

var moduleElements = document.querySelectorAll('[data-module]')



for (var i = 0; i < moduleElements.length; i++) {
  var el = moduleElements[i];
  var name = el.getAttribute('data-module');
  var Module = require('./src/'+name).default;
}
/*
  Usage:
  ======

  html
  ----
  <button data-module="disappear">disappear!</button>

  js
  --
  // modules/disappear.js
  export default class Disappear {
    constructor(el) {
      el.style.display = none
    }
  }
*/



