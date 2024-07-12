/*! jQuery v3.7.1 | (c) OpenJS Foundation and other contributors | jquery.org/license */
!function(e,t){"use strict";"object"==typeof module&&"object"==typeof module.exports?module.exports=e.document?t(e,!0):function(e){if(!e.document)throw new Error("jQuery requires a window with a document");return t(e)}:t(e)}("undefined"!=typeof window?window:this,function(ie,e){"use strict";var oe=[],r=Object.getPrototypeOf,ae=oe.slice,g=oe.flat?function(e){return oe.flat.call(e)}:function(e){return oe.concat.apply([],e)},s=oe.push,se=oe.indexOf,n={},i=n.toString,ue=n.hasOwnProperty,o=ue.toString,a=o.call(Object),le={},v=function(e){return"function"==typeof e&&"number"!=typeof e.nodeType&&"function"!=typeof e.item},y=function(e){return null!=e&&e===e.window},C=ie.document,u={type:!0,src:!0,nonce:!0,noModule:!0};function m(e,t,n){var r,i,o=(n=n||C).createElement("script");if(o.text=e,t)for(r in u)(i=t[r]||t.getAttribute&&t.getAttribute(r))&&o.setAttribute(r,i);n.head.appendChild(o).parentNode.removeChild(o)}function x(e){return null==e?e+"":"object"==typeof e||"function"==typeof e?n[i.call(e)]||"object":typeof e}var t="3.7.1",l=/HTML$/i,ce=function(e,t){return new ce.fn.init(e,t)};function c(e){var t=!!e&&"length"in e&&e.length,n=x(e);return!v(e)&&!y(e)&&("array"===n||0===t||"number"==typeof t&&0<t&&t-1 in e)}function fe(e,t){return e.nodeName&&e.nodeName.toLowerCase()===t.toLowerCase()}ce.fn=ce.prototype={jquery:t,constructor:ce,length:0,toArray:function(){return ae.call(this)},get:function(e){return null==e?ae.call(this):e<0?this[e+this.length]:this[e]},pushStack:function(e){var t=ce.merge(this.constructor(),e);return t.prevObject=this,t},each:function(e){return ce.each(this,e)},map:function(n){return this.pushStack(ce.map(this,function(e,t){return n.call(e,t,e)}))},slice:function(){return this.pushStack(ae.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},even:function(){return this.pushStack(ce.grep(this,function(e,t){return(t+1)%2}))},odd:function(){return this.pushStack(ce.grep(this,function(e,t){return t%2}))},eq:function(e){var t=this.length,n=+e+(e<0?t:0);return this.pushStack(0<=n&&n<t?[this[n]]:[])},end:function(){return this.prevObject||this.constructor()},push:s,sort:oe.sort,splice:oe.splice},ce.extend=ce.fn.extend=function(){var e,t,n,r,i,o,a=arguments[0]||{},s=1,u=arguments.length,l=!1;for("boolean"==typeof a&&(l=a,a=arguments[s]||{},s++),"object"==typeof a||v(a)||(a={}),s===u&&(a=this,s--);s<u;s++)if(null!=(e=arguments[s]))for(t in e)r=e[t],"__proto__"!==t&&a!==r&&(l&&r&&(ce.isPlainObject(r)||(i=Array.isArray(r)))?(n=a[t],o=i&&!Array.isArray(n)?[]:i||ce.isPlainObject(n)?n:{},i=!1,a[t]=ce.extend(l,o,r)):void 0!==r&&(a[t]=r));return a},ce.extend({expando:"jQuery"+(t+Math.random()).replace(/\D/g,""),isReady:!0,error:function(e){throw new Error(e)},noop:function(){},isPlainObject:function(e){var t,n;return!(!e||"[object Object]"!==i.call(e))&&(!(t=r(e))||"function"==typeof(n=ue.call(t,"constructor")&&t.constructor)&&o.call(n)===a)},isEmptyObject:function(e){var t;for(t in e)return!1;return!0},globalEval:function(e,t,n){m(e,{nonce:t&&t.nonce},n)},each:function(e,t){var n,r=0;if(c(e)){for(n=e.length;r<n;r++)if(!1===t.call(e[r],r,e[r]))break}else for(r in e)if(!1===t.call(e[r],r,e[r]))break;return e},text:function(e){var t,n="",r=0,i=e.nodeType;if(!i)while(t=e[r++])n+=ce.text(t);return 1===i||11===i?e.textContent:9===i?e.documentElement.textContent:3===i||4===i?e.nodeValue:n},makeArray:function(e,t){var n=t||[];return null!=e&&(c(Object(e))?ce.merge(n,"string"==typeof e?[e]:e):s.call(n,e)),n},inArray:function(e,t,n){return null==t?-1:se.call(t,e,n)},isXMLDoc:function(e){var t=e&&e.namespaceURI,n=e&&(e.ownerDocument||e).documentElement;return!l.test(t||n&&n.nodeName||"HTML")},merge:function(e,t){for(var n=+t.length,r=0,i=e.length;r<n;r++)e[i++]=t[r];return e.length=i,e},grep:function(e,t,n){for(var r=[],i=0,o=e.length,a=!n;i<o;i++)!t(e[i],i)!==a&&r.push(e[i]);return r},map:function(e,t,n){var r,i,o=0,a=[];if(c(e))for(r=e.length;o<r;o++)null!=(i=t(e[o],o,n))&&a.push(i);else for(o in e)null!=(i=t(e[o],o,n))&&a.push(i);return g(a)},guid:1,support:le}),"function"==typeof Symbol&&(ce.fn[Symbol.iterator]=oe[Symbol.iterator]),ce.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "),function(e,t){n["[object "+t+"]"]=t.toLowerCase()});var pe=oe.pop,de=oe.sort,he=oe.splice,ge="[\\x20\\t\\r\\n\\f]",ve=new RegExp("^"+ge+"+|((?:^|[^\\\\])(?:\\\\.)*)"+ge+"+$","g");ce.contains=function(e,t){var n=t&&t.parentNode;return e===n||!(!n||1!==n.nodeType||!(e.contains?e.contains(n):e.compareDocumentPosition&&16&e.compareDocumentPosition(n)))};var f=/([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g;function p(e,t){return t?"\0"===e?"\ufffd":e.slice(0,-1)+"\\"+e.charCodeAt(e.length-1).toString(16)+" ":"\\"+e}ce.escapeSelector=function(e){return(e+"").replace(f,p)};var ye=C,me=s;!function(){var e,b,w,o,a,T,r,C,d,i,k=me,S=ce.expando,E=0,n=0,s=W(),c=W(),u=W(),h=W(),l=function(e,t){return e===t&&(a=!0),0},f="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",t="(?:\\\\[\\da-fA-F]{1,6}"+ge+"?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",p="\\["+ge+"*("+t+")(?:"+ge+"*([*^$|!~]?=)"+ge+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+t+"))|)"+ge+"*\\]",g=":("+t+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+p+")*)|.*)\\)|)",v=new RegExp(ge+"+","g"),y=new RegExp("^"+ge+"*,"+ge+"*"),m=new RegExp("^"+ge+"*([>+~]|"+ge+")"+ge+"*"),x=new RegExp(ge+"|>"),j=new RegExp(g),A=new RegExp("^"+t+"$"),D={ID:new RegExp("^#("+t+")"),CLASS:new RegExp("^\\.("+t+")"),TAG:new RegExp("^("+t+"|[*])"),ATTR:new RegExp("^"+p),PSEUDO:new RegExp("^"+g),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+ge+"*(even|odd|(([+-]|)(\\d*)n|)"+ge+"*(?:([+-]|)"+ge+"*(\\d+)|))"+ge+"*\\)|)","i"),bool:new RegExp("^(?:"+f+")$","i"),needsContext:new RegExp("^"+ge+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+ge+"*((?:-\\d)?\\d*)"+ge+"*\\)|)(?=[^-]|$)","i")},N=/^(?:input|select|textarea|button)$/i,q=/^h\d$/i,L=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,H=/[+~]/,O=new RegExp("\\\\[\\da-fA-F]{1,6}"+ge+"?|\\\\([^\\r\\n\\f])","g"),P=function(e,t){var n="0x"+e.slice(1)-65536;return t||(n<0?String.fromCharCode(n+65536):String.fromCharCode(n>>10|55296,1023&n|56320))},M=function(){V()},R=J(function(e){return!0===e.disabled&&fe(e,"fieldset")},{dir:"parentNode",next:"legend"});try{k.apply(oe=ae.call(ye.childNodes),ye.childNodes),oe[ye.childNodes.length].nodeType}catch(e){k={apply:function(e,t){me.apply(e,ae.call(t))},call:function(e){me.apply(e,ae.call(arguments,1))}}}function I(t,e,n,r){var i,o,a,s,u,l,c,f=e&&e.ownerDocument,p=e?e.nodeType:9;if(n=n||[],"string"!=typeof t||!t||1!==p&&9!==p&&11!==p)return n;if(!r&&(V(e),e=e||T,C)){if(11!==p&&(u=L.exec(t)))if(i=u[1]){if(9===p){if(!(a=e.getElementById(i)))return n;if(a.id===i)return k.call(n,a),n}else if(f&&(a=f.getElementById(i))&&I.contains(e,a)&&a.id===i)return k.call(n,a),n}else{if(u[2])return k.apply(n,e.getElementsByTagName(t)),n;if((i=u[3])&&e.getElementsByClassName)return k.apply(n,e.getElementsByClassName(i)),n}if(!(h[t+" "]||d&&d.test(t))){if(c=t,f=e,1===p&&(x.test(t)||m.test(t))){(f=H.test(t)&&U(e.parentNode)||e)==e&&le.scope||((s=e.getAttribute("id"))?s=ce.escapeSelector(s):e.setAttribute("id",s=S)),o=(l=Y(t)).length;while(o--)l[o]=(s?"#"+s:":scope")+" "+Q(l[o]);c=l.join(",")}try{return k.apply(n,f.querySelectorAll(c)),n}catch(e){h(t,!0)}finally{s===S&&e.removeAttribute("id")}}}return re(t.replace(ve,"$1"),e,n,r)}function W(){var r=[];return function e(t,n){return r.push(t+" ")>b.cacheLength&&delete e[r.shift()],e[t+" "]=n}}function F(e){return e[S]=!0,e}function $(e){var t=T.createElement("fieldset");try{return!!e(t)}catch(e){return!1}finally{t.parentNode&&t.parentNode.removeChild(t),t=null}}function B(t){return function(e){return fe(e,"input")&&e.type===t}}function _(t){return function(e){return(fe(e,"input")||fe(e,"button"))&&e.type===t}}function z(t){return function(e){return"form"in e?e.parentNode&&!1===e.disabled?"label"in e?"label"in e.parentNode?e.parentNode.disabled===t:e.disabled===t:e.isDisabled===t||e.isDisabled!==!t&&R(e)===t:e.disabled===t:"label"in e&&e.disabled===t}}function X(a){return F(function(o){return o=+o,F(function(e,t){var n,r=a([],e.length,o),i=r.length;while(i--)e[n=r[i]]&&(e[n]=!(t[n]=e[n]))})})}function U(e){return e&&"undefined"!=typeof e.getElementsByTagName&&e}function V(e){var t,n=e?e.ownerDocument||e:ye;return n!=T&&9===n.nodeType&&n.documentElement&&(r=(T=n).documentElement,C=!ce.isXMLDoc(T),i=r.matches||r.webkitMatchesSelector||r.msMatchesSelector,r.msMatchesSelector&&ye!=T&&(t=T.defaultView)&&t.top!==t&&t.addEventListener("unload",M),le.getById=$(function(e){return r.appendChild(e).id=ce.expando,!T.getElementsByName||!T.getElementsByName(ce.expando).length}),le.disconnectedMatch=$(function(e){return i.call(e,"*")}),le.scope=$(function(){return T.querySelectorAll(":scope")}),le.cssHas=$(function(){try{return T.querySelector(":has(*,:jqfake)"),!1}catch(e){return!0}}),le.getById?(b.filter.ID=function(e){var t=e.replace(O,P);return function(e){return e.getAttribute("id")===t}},b.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&C){var n=t.getElementById(e);return n?[n]:[]}}):(b.filter.ID=function(e){var n=e.replace(O,P);return function(e){var t="undefined"!=typeof e.getAttributeNode&&e.getAttributeNode("id");return t&&t.value===n}},b.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&C){var n,r,i,o=t.getElementById(e);if(o){if((n=o.getAttributeNode("id"))&&n.value===e)return[o];i=t.getElementsByName(e),r=0;while(o=i[r++])if((n=o.getAttributeNode("id"))&&n.value===e)return[o]}return[]}}),b.find.TAG=function(e,t){return"undefined"!=typeof t.getElementsByTagName?t.getElementsByTagName(e):t.querySelectorAll(e)},b.find.CLASS=function(e,t){if("undefined"!=typeof t.getElementsByClassName&&C)return t.getElementsByClassName(e)},d=[],$(function(e){var t;r.appendChild(e).innerHTML="<a id='"+S+"' href='' disabled='disabled'></a><select id='"+S+"-\r\\' disabled='disabled'><option selected=''></option></select>",e.querySelectorAll("[selected]").length||d.push("\\["+ge+"*(?:value|"+f+")"),e.querySelectorAll("[id~="+S+"-]").length||d.push("~="),e.querySelectorAll("a#"+S+"+*").length||d.push(".#.+[+~]"),e.querySelectorAll(":checked").length||d.push(":checked"),(t=T.createElement("input")).setAttribute("type","hidden"),e.appendChild(t).setAttribute("name","D"),r.appendChild(e).disabled=!0,2!==e.querySelectorAll(":disabled").length&&d.push(":enabled",":disabled"),(t=T.createElement("input")).setAttribute("name",""),e.appendChild(t),e.querySelectorAll("[name='']").length||d.push("\\["+ge+"*name"+ge+"*="+ge+"*(?:''|\"\")")}),le.cssHas||d.push(":has"),d=d.length&&new RegExp(d.join("|")),l=function(e,t){if(e===t)return a=!0,0;var n=!e.compareDocumentPosition-!t.compareDocumentPosition;return n||(1&(n=(e.ownerDocument||e)==(t.ownerDocument||t)?e.compareDocumentPosition(t):1)||!le.sortDetached&&t.compareDocumentPosition(e)===n?e===T||e.ownerDocument==ye&&I.contains(ye,e)?-1:t===T||t.ownerDocument==ye&&I.contains(ye,t)?1:o?se.call(o,e)-se.call(o,t):0:4&n?-1:1)}),T}for(e in I.matches=function(e,t){return I(e,null,null,t)},I.matchesSelector=function(e,t){if(V(e),C&&!h[t+" "]&&(!d||!d.test(t)))try{var n=i.call(e,t);if(n||le.disconnectedMatch||e.document&&11!==e.document.nodeType)return n}catch(e){h(t,!0)}return 0<I(t,T,null,[e]).length},I.contains=function(e,t){return(e.ownerDocument||e)!=T&&V(e),ce.contains(e,t)},I.attr=function(e,t){(e.ownerDocument||e)!=T&&V(e);var n=b.attrHandle[t.toLowerCase()],r=n&&ue.call(b.attrHandle,t.toLowerCase())?n(e,t,!C):void 0;return void 0!==r?r:e.getAttribute(t)},I.error=function(e){throw new Error("Syntax error, unrecognized expression: "+e)},ce.uniqueSort=function(e){var t,n=[],r=0,i=0;if(a=!le.sortStable,o=!le.sortStable&&ae.call(e,0),de.call(e,l),a){while(t=e[i++])t===e[i]&&(r=n.push(i));while(r--)he.call(e,n[r],1)}return o=null,e},ce.fn.uniqueSort=function(){return this.pushStack(ce.uniqueSort(ae.apply(this)))},(b=ce.expr={cacheLength:50,createPseudo:F,match:D,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(e){return e[1]=e[1].replace(O,P),e[3]=(e[3]||e[4]||e[5]||"").replace(O,P),"~="===e[2]&&(e[3]=" "+e[3]+" "),e.slice(0,4)},CHILD:function(e){return e[1]=e[1].toLowerCase(),"nth"===e[1].slice(0,3)?(e[3]||I.error(e[0]),e[4]=+(e[4]?e[5]+(e[6]||1):2*("even"===e[3]||"odd"===e[3])),e[5]=+(e[7]+e[8]||"odd"===e[3])):e[3]&&I.error(e[0]),e},PSEUDO:function(e){var t,n=!e[6]&&e[2];return D.CHILD.test(e[0])?null:(e[3]?e[2]=e[4]||e[5]||"":n&&j.test(n)&&(t=Y(n,!0))&&(t=n.indexOf(")",n.length-t)-n.length)&&(e[0]=e[0].slice(0,t),e[2]=n.slice(0,t)),e.slice(0,3))}},filter:{TAG:function(e){var t=e.replace(O,P).toLowerCase();return"*"===e?function(){return!0}:function(e){return fe(e,t)}},CLASS:function(e){var t=s[e+" "];return t||(t=new RegExp("(^|"+ge+")"+e+"("+ge+"|$)"))&&s(e,function(e){return t.test("string"==typeof e.className&&e.className||"undefined"!=typeof e.getAttribute&&e.getAttribute("class")||"")})},ATTR:function(n,r,i){return function(e){var t=I.attr(e,n);return null==t?"!="===r:!r||(t+="","="===r?t===i:"!="===r?t!==i:"^="===r?i&&0===t.indexOf(i):"*="===r?i&&-1<t.indexOf(i):"$="===r?i&&t.slice(-i.length)===i:"~="===r?-1<(" "+t.replace(v," ")+" ").indexOf(i):"|="===r&&(t===i||t.slice(0,i.length+1)===i+"-"))}},CHILD:function(d,e,t,h,g){var v="nth"!==d.slice(0,3),y="last"!==d.slice(-4),m="of-type"===e;return 1===h&&0===g?function(e){return!!e.parentNode}:function(e,t,n){var r,i,o,a,s,u=v!==y?"nextSibling":"previousSibling",l=e.parentNode,c=m&&e.nodeName.toLowerCase(),f=!n&&!m,p=!1;if(l){if(v){while(u){o=e;while(o=o[u])if(m?fe(o,c):1===o.nodeType)return!1;s=u="only"===d&&!s&&"nextSibling"}return!0}if(s=[y?l.firstChild:l.lastChild],y&&f){p=(a=(r=(i=l[S]||(l[S]={}))[d]||[])[0]===E&&r[1])&&r[2],o=a&&l.childNodes[a];while(o=++a&&o&&o[u]||(p=a=0)||s.pop())if(1===o.nodeType&&++p&&o===e){i[d]=[E,a,p];break}}else if(f&&(p=a=(r=(i=e[S]||(e[S]={}))[d]||[])[0]===E&&r[1]),!1===p)while(o=++a&&o&&o[u]||(p=a=0)||s.pop())if((m?fe(o,c):1===o.nodeType)&&++p&&(f&&((i=o[S]||(o[S]={}))[d]=[E,p]),o===e))break;return(p-=g)===h||p%h==0&&0<=p/h}}},PSEUDO:function(e,o){var t,a=b.pseudos[e]||b.setFilters[e.toLowerCase()]||I.error("unsupported pseudo: "+e);return a[S]?a(o):1<a.length?(t=[e,e,"",o],b.setFilters.hasOwnProperty(e.toLowerCase())?F(function(e,t){var n,r=a(e,o),i=r.length;while(i--)e[n=se.call(e,r[i])]=!(t[n]=r[i])}):function(e){return a(e,0,t)}):a}},pseudos:{not:F(function(e){var r=[],i=[],s=ne(e.replace(ve,"$1"));return s[S]?F(function(e,t,n,r){var i,o=s(e,null,r,[]),a=e.length;while(a--)(i=o[a])&&(e[a]=!(t[a]=i))}):function(e,t,n){return r[0]=e,s(r,null,n,i),r[0]=null,!i.pop()}}),has:F(function(t){return function(e){return 0<I(t,e).length}}),contains:F(function(t){return t=t.replace(O,P),function(e){return-1<(e.textContent||ce.text(e)).indexOf(t)}}),lang:F(function(n){return A.test(n||"")||I.error("unsupported lang: "+n),n=n.replace(O,P).toLowerCase(),function(e){var t;do{if(t=C?e.lang:e.getAttribute("xml:lang")||e.getAttribute("lang"))return(t=t.toLowerCase())===n||0===t.indexOf(n+"-")}while((e=e.parentNode)&&1===e.nodeType);return!1}}),target:function(e){var t=ie.location&&ie.location.hash;return t&&t.slice(1)===e.id},root:function(e){return e===r},focus:function(e){return e===function(){try{return T.activeElement}catch(e){}}()&&T.hasFocus()&&!!(e.type||e.href||~e.tabIndex)},enabled:z(!1),disabled:z(!0),checked:function(e){return fe(e,"input")&&!!e.checked||fe(e,"option")&&!!e.selected},selected:function(e){return e.parentNode&&e.parentNode.selectedIndex,!0===e.selected},empty:function(e){for(e=e.firstChild;e;e=e.nextSibling)if(e.nodeType<6)return!1;return!0},parent:function(e){return!b.pseudos.empty(e)},header:function(e){return q.test(e.nodeName)},input:function(e){return N.test(e.nodeName)},button:function(e){return fe(e,"input")&&"button"===e.type||fe(e,"button")},text:function(e){var t;return fe(e,"input")&&"text"===e.type&&(null==(t=e.getAttribute("type"))||"text"===t.toLowerCase())},first:X(function(){return[0]}),last:X(function(e,t){return[t-1]}),eq:X(function(e,t,n){return[n<0?n+t:n]}),even:X(function(e,t){for(var n=0;n<t;n+=2)e.push(n);return e}),odd:X(function(e,t){for(var n=1;n<t;n+=2)e.push(n);return e}),lt:X(function(e,t,n){var r;for(r=n<0?n+t:t<n?t:n;0<=--r;)e.push(r);return e}),gt:X(function(e,t,n){for(var r=n<0?n+t:n;++r<t;)e.push(r);return e})}}).pseudos.nth=b.pseudos.eq,{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})b.pseudos[e]=B(e);for(e in{submit:!0,reset:!0})b.pseudos[e]=_(e);function G(){}function Y(e,t){var n,r,i,o,a,s,u,l=c[e+" "];if(l)return t?0:l.slice(0);a=e,s=[],u=b.preFilter;while(a){for(o in n&&!(r=y.exec(a))||(r&&(a=a.slice(r[0].length)||a),s.push(i=[])),n=!1,(r=m.exec(a))&&(n=r.shift(),i.push({value:n,type:r[0].replace(ve," ")}),a=a.slice(n.length)),b.filter)!(r=D[o].exec(a))||u[o]&&!(r=u[o](r))||(n=r.shift(),i.push({value:n,type:o,matches:r}),a=a.slice(n.length));if(!n)break}return t?a.length:a?I.error(e):c(e,s).slice(0)}function Q(e){for(var t=0,n=e.length,r="";t<n;t++)r+=e[t].value;return r}function J(a,e,t){var s=e.dir,u=e.next,l=u||s,c=t&&"parentNode"===l,f=n++;return e.first?function(e,t,n){while(e=e[s])if(1===e.nodeType||c)return a(e,t,n);return!1}:function(e,t,n){var r,i,o=[E,f];if(n){while(e=e[s])if((1===e.nodeType||c)&&a(e,t,n))return!0}else while(e=e[s])if(1===e.nodeType||c)if(i=e[S]||(e[S]={}),u&&fe(e,u))e=e[s]||e;else{if((r=i[l])&&r[0]===E&&r[1]===f)return o[2]=r[2];if((i[l]=o)[2]=a(e,t,n))return!0}return!1}}function K(i){return 1<i.length?function(e,t,n){var r=i.length;while(r--)if(!i[r](e,t,n))return!1;return!0}:i[0]}function Z(e,t,n,r,i){for(var o,a=[],s=0,u=e.length,l=null!=t;s<u;s++)(o=e[s])&&(n&&!n(o,r,i)||(a.push(o),l&&t.push(s)));return a}function ee(d,h,g,v,y,e){return v&&!v[S]&&(v=ee(v)),y&&!y[S]&&(y=ee(y,e)),F(function(e,t,n,r){var i,o,a,s,u=[],l=[],c=t.length,f=e||function(e,t,n){for(var r=0,i=t.length;r<i;r++)I(e,t[r],n);return n}(h||"*",n.nodeType?[n]:n,[]),p=!d||!e&&h?f:Z(f,u,d,n,r);if(g?g(p,s=y||(e?d:c||v)?[]:t,n,r):s=p,v){i=Z(s,l),v(i,[],n,r),o=i.length;while(o--)(a=i[o])&&(s[l[o]]=!(p[l[o]]=a))}if(e){if(y||d){if(y){i=[],o=s.length;while(o--)(a=s[o])&&i.push(p[o]=a);y(null,s=[],i,r)}o=s.length;while(o--)(a=s[o])&&-1<(i=y?se.call(e,a):u[o])&&(e[i]=!(t[i]=a))}}else s=Z(s===t?s.splice(c,s.length):s),y?y(null,t,s,r):k.apply(t,s)})}function te(e){for(var i,t,n,r=e.length,o=b.relative[e[0].type],a=o||b.relative[" "],s=o?1:0,u=J(function(e){return e===i},a,!0),l=J(function(e){return-1<se.call(i,e)},a,!0),c=[function(e,t,n){var r=!o&&(n||t!=w)||((i=t).nodeType?u(e,t,n):l(e,t,n));return i=null,r}];s<r;s++)if(t=b.relative[e[s].type])c=[J(K(c),t)];else{if((t=b.filter[e[s].type].apply(null,e[s].matches))[S]){for(n=++s;n<r;n++)if(b.relative[e[n].type])break;return ee(1<s&&K(c),1<s&&Q(e.slice(0,s-1).concat({value:" "===e[s-2].type?"*":""})).replace(ve,"$1"),t,s<n&&te(e.slice(s,n)),n<r&&te(e=e.slice(n)),n<r&&Q(e))}c.push(t)}return K(c)}function ne(e,t){var n,v,y,m,x,r,i=[],o=[],a=u[e+" "];if(!a){t||(t=Y(e)),n=t.length;while(n--)(a=te(t[n]))[S]?i.push(a):o.push(a);(a=u(e,(v=o,m=0<(y=i).length,x=0<v.length,r=function(e,t,n,r,i){var o,a,s,u=0,l="0",c=e&&[],f=[],p=w,d=e||x&&b.find.TAG("*",i),h=E+=null==p?1:Math.random()||.1,g=d.length;for(i&&(w=t==T||t||i);l!==g&&null!=(o=d[l]);l++){if(x&&o){a=0,t||o.ownerDocument==T||(V(o),n=!C);while(s=v[a++])if(s(o,t||T,n)){k.call(r,o);break}i&&(E=h)}m&&((o=!s&&o)&&u--,e&&c.push(o))}if(u+=l,m&&l!==u){a=0;while(s=y[a++])s(c,f,t,n);if(e){if(0<u)while(l--)c[l]||f[l]||(f[l]=pe.call(r));f=Z(f)}k.apply(r,f),i&&!e&&0<f.length&&1<u+y.length&&ce.uniqueSort(r)}return i&&(E=h,w=p),c},m?F(r):r))).selector=e}return a}function re(e,t,n,r){var i,o,a,s,u,l="function"==typeof e&&e,c=!r&&Y(e=l.selector||e);if(n=n||[],1===c.length){if(2<(o=c[0]=c[0].slice(0)).length&&"ID"===(a=o[0]).type&&9===t.nodeType&&C&&b.relative[o[1].type]){if(!(t=(b.find.ID(a.matches[0].replace(O,P),t)||[])[0]))return n;l&&(t=t.parentNode),e=e.slice(o.shift().value.length)}i=D.needsContext.test(e)?0:o.length;while(i--){if(a=o[i],b.relative[s=a.type])break;if((u=b.find[s])&&(r=u(a.matches[0].replace(O,P),H.test(o[0].type)&&U(t.parentNode)||t))){if(o.splice(i,1),!(e=r.length&&Q(o)))return k.apply(n,r),n;break}}}return(l||ne(e,c))(r,t,!C,n,!t||H.test(e)&&U(t.parentNode)||t),n}G.prototype=b.filters=b.pseudos,b.setFilters=new G,le.sortStable=S.split("").sort(l).join("")===S,V(),le.sortDetached=$(function(e){return 1&e.compareDocumentPosition(T.createElement("fieldset"))}),ce.find=I,ce.expr[":"]=ce.expr.pseudos,ce.unique=ce.uniqueSort,I.compile=ne,I.select=re,I.setDocument=V,I.tokenize=Y,I.escape=ce.escapeSelector,I.getText=ce.text,I.isXML=ce.isXMLDoc,I.selectors=ce.expr,I.support=ce.support,I.uniqueSort=ce.uniqueSort}();var d=function(e,t,n){var r=[],i=void 0!==n;while((e=e[t])&&9!==e.nodeType)if(1===e.nodeType){if(i&&ce(e).is(n))break;r.push(e)}return r},h=function(e,t){for(var n=[];e;e=e.nextSibling)1===e.nodeType&&e!==t&&n.push(e);return n},b=ce.expr.match.needsContext,w=/^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;function T(e,n,r){return v(n)?ce.grep(e,function(e,t){return!!n.call(e,t,e)!==r}):n.nodeType?ce.grep(e,function(e){return e===n!==r}):"string"!=typeof n?ce.grep(e,function(e){return-1<se.call(n,e)!==r}):ce.filter(n,e,r)}ce.filter=function(e,t,n){var r=t[0];return n&&(e=":not("+e+")"),1===t.length&&1===r.nodeType?ce.find.matchesSelector(r,e)?[r]:[]:ce.find.matches(e,ce.grep(t,function(e){return 1===e.nodeType}))},ce.fn.extend({find:function(e){var t,n,r=this.length,i=this;if("string"!=typeof e)return this.pushStack(ce(e).filter(function(){for(t=0;t<r;t++)if(ce.contains(i[t],this))return!0}));for(n=this.pushStack([]),t=0;t<r;t++)ce.find(e,i[t],n);return 1<r?ce.uniqueSort(n):n},filter:function(e){return this.pushStack(T(this,e||[],!1))},not:function(e){return this.pushStack(T(this,e||[],!0))},is:function(e){return!!T(this,"string"==typeof e&&b.test(e)?ce(e):e||[],!1).length}});var k,S=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;(ce.fn.init=function(e,t,n){var r,i;if(!e)return this;if(n=n||k,"string"==typeof e){if(!(r="<"===e[0]&&">"===e[e.length-1]&&3<=e.length?[null,e,null]:S.exec(e))||!r[1]&&t)return!t||t.jquery?(t||n).find(e):this.constructor(t).find(e);if(r[1]){if(t=t instanceof ce?t[0]:t,ce.merge(this,ce.parseHTML(r[1],t&&t.nodeType?t.ownerDocument||t:C,!0)),w.test(r[1])&&ce.isPlainObject(t))for(r in t)v(this[r])?this[r](t[r]):this.attr(r,t[r]);return this}return(i=C.getElementById(r[2]))&&(this[0]=i,this.length=1),this}return e.nodeType?(this[0]=e,this.length=1,this):v(e)?void 0!==n.ready?n.ready(e):e(ce):ce.makeArray(e,this)}).prototype=ce.fn,k=ce(C);var E=/^(?:parents|prev(?:Until|All))/,j={children:!0,contents:!0,next:!0,prev:!0};function A(e,t){while((e=e[t])&&1!==e.nodeType);return e}ce.fn.extend({has:function(e){var t=ce(e,this),n=t.length;return this.filter(function(){for(var e=0;e<n;e++)if(ce.contains(this,t[e]))return!0})},closest:function(e,t){var n,r=0,i=this.length,o=[],a="string"!=typeof e&&ce(e);if(!b.test(e))for(;r<i;r++)for(n=this[r];n&&n!==t;n=n.parentNode)if(n.nodeType<11&&(a?-1<a.index(n):1===n.nodeType&&ce.find.matchesSelector(n,e))){o.push(n);break}return this.pushStack(1<o.length?ce.uniqueSort(o):o)},index:function(e){return e?"string"==typeof e?se.call(ce(e),this[0]):se.call(this,e.jquery?e[0]:e):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(e,t){return this.pushStack(ce.uniqueSort(ce.merge(this.get(),ce(e,t))))},addBack:function(e){return this.add(null==e?this.prevObject:this.prevObject.filter(e))}}),ce.each({parent:function(e){var t=e.parentNode;return t&&11!==t.nodeType?t:null},parents:function(e){return d(e,"parentNode")},parentsUntil:function(e,t,n){return d(e,"parentNode",n)},next:function(e){return A(e,"nextSibling")},prev:function(e){return A(e,"previousSibling")},nextAll:function(e){return d(e,"nextSibling")},prevAll:function(e){return d(e,"previousSibling")},nextUntil:function(e,t,n){return d(e,"nextSibling",n)},prevUntil:function(e,t,n){return d(e,"previousSibling",n)},siblings:function(e){return h((e.parentNode||{}).firstChild,e)},children:function(e){return h(e.firstChild)},contents:function(e){return null!=e.contentDocument&&r(e.contentDocument)?e.contentDocument:(fe(e,"template")&&(e=e.content||e),ce.merge([],e.childNodes))}},function(r,i){ce.fn[r]=function(e,t){var n=ce.map(this,i,e);return"Until"!==r.slice(-5)&&(t=e),t&&"string"==typeof t&&(n=ce.filter(t,n)),1<this.length&&(j[r]||ce.uniqueSort(n),E.test(r)&&n.reverse()),this.pushStack(n)}});var D=/[^\x20\t\r\n\f]+/g;function N(e){return e}function q(e){throw e}function L(e,t,n,r){var i;try{e&&v(i=e.promise)?i.call(e).done(t).fail(n):e&&v(i=e.then)?i.call(e,t,n):t.apply(void 0,[e].slice(r))}catch(e){n.apply(void 0,[e])}}ce.Callbacks=function(r){var e,n;r="string"==typeof r?(e=r,n={},ce.each(e.match(D)||[],function(e,t){n[t]=!0}),n):ce.extend({},r);var i,t,o,a,s=[],u=[],l=-1,c=function(){for(a=a||r.once,o=i=!0;u.length;l=-1){t=u.shift();while(++l<s.length)!1===s[l].apply(t[0],t[1])&&r.stopOnFalse&&(l=s.length,t=!1)}r.memory||(t=!1),i=!1,a&&(s=t?[]:"")},f={add:function(){return s&&(t&&!i&&(l=s.length-1,u.push(t)),function n(e){ce.each(e,function(e,t){v(t)?r.unique&&f.has(t)||s.push(t):t&&t.length&&"string"!==x(t)&&n(t)})}(arguments),t&&!i&&c()),this},remove:function(){return ce.each(arguments,function(e,t){var n;while(-1<(n=ce.inArray(t,s,n)))s.splice(n,1),n<=l&&l--}),this},has:function(e){return e?-1<ce.inArray(e,s):0<s.length},empty:function(){return s&&(s=[]),this},disable:function(){return a=u=[],s=t="",this},disabled:function(){return!s},lock:function(){return a=u=[],t||i||(s=t=""),this},locked:function(){return!!a},fireWith:function(e,t){return a||(t=[e,(t=t||[]).slice?t.slice():t],u.push(t),i||c()),this},fire:function(){return f.fireWith(this,arguments),this},fired:function(){return!!o}};return f},ce.extend({Deferred:function(e){var o=[["notify","progress",ce.Callbacks("memory"),ce.Callbacks("memory"),2],["resolve","done",ce.Callbacks("once memory"),ce.Callbacks("once memory"),0,"resolved"],["reject","fail",ce.Callbacks("once memory"),ce.Callbacks("once memory"),1,"rejected"]],i="pending",a={state:function(){return i},always:function(){return s.done(arguments).fail(arguments),this},"catch":function(e){return a.then(null,e)},pipe:function(){var i=arguments;return ce.Deferred(function(r){ce.each(o,function(e,t){var n=v(i[t[4]])&&i[t[4]];s[t[1]](function(){var e=n&&n.apply(this,arguments);e&&v(e.promise)?e.promise().progress(r.notify).done(r.resolve).fail(r.reject):r[t[0]+"With"](this,n?[e]:arguments)})}),i=null}).promise()},then:function(t,n,r){var u=0;function l(i,o,a,s){return function(){var n=this,r=arguments,e=function(){var e,t;if(!(i<u)){if((e=a.apply(n,r))===o.promise())throw new TypeError("Thenable self-resolution");t=e&&("object"==typeof e||"function"==typeof e)&&e.then,v(t)?s?t.call(e,l(u,o,N,s),l(u,o,q,s)):(u++,t.call(e,l(u,o,N,s),l(u,o,q,s),l(u,o,N,o.notifyWith))):(a!==N&&(n=void 0,r=[e]),(s||o.resolveWith)(n,r))}},t=s?e:function(){try{e()}catch(e){ce.Deferred.exceptionHook&&ce.Deferred.exceptionHook(e,t.error),u<=i+1&&(a!==q&&(n=void 0,r=[e]),o.rejectWith(n,r))}};i?t():(ce.Deferred.getErrorHook?t.error=ce.Deferred.getErrorHook():ce.Deferred.getStackHook&&(t.error=ce.Deferred.getStackHook()),ie.setTimeout(t))}}return ce.Deferred(function(e){o[0][3].add(l(0,e,v(r)?r:N,e.notifyWith)),o[1][3].add(l(0,e,v(t)?t:N)),o[2][3].add(l(0,e,v(n)?n:q))}).promise()},promise:function(e){return null!=e?ce.extend(e,a):a}},s={};return ce.each(o,function(e,t){var n=t[2],r=t[5];a[t[1]]=n.add,r&&n.add(function(){i=r},o[3-e][2].disable,o[3-e][3].disable,o[0][2].lock,o[0][3].lock),n.add(t[3].fire),s[t[0]]=function(){return s[t[0]+"With"](this===s?void 0:this,arguments),this},s[t[0]+"With"]=n.fireWith}),a.promise(s),e&&e.call(s,s),s},when:function(e){var n=arguments.length,t=n,r=Array(t),i=ae.call(arguments),o=ce.Deferred(),a=function(t){return function(e){r[t]=this,i[t]=1<arguments.length?ae.call(arguments):e,--n||o.resolveWith(r,i)}};if(n<=1&&(L(e,o.done(a(t)).resolve,o.reject,!n),"pending"===o.state()||v(i[t]&&i[t].then)))return o.then();while(t--)L(i[t],a(t),o.reject);return o.promise()}});var H=/^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;ce.Deferred.exceptionHook=function(e,t){ie.console&&ie.console.warn&&e&&H.test(e.name)&&ie.console.warn("jQuery.Deferred exception: "+e.message,e.stack,t)},ce.readyException=function(e){ie.setTimeout(function(){throw e})};var O=ce.Deferred();function P(){C.removeEventListener("DOMContentLoaded",P),ie.removeEventListener("load",P),ce.ready()}ce.fn.ready=function(e){return O.then(e)["catch"](function(e){ce.readyException(e)}),this},ce.extend({isReady:!1,readyWait:1,ready:function(e){(!0===e?--ce.readyWait:ce.isReady)||(ce.isReady=!0)!==e&&0<--ce.readyWait||O.resolveWith(C,[ce])}}),ce.ready.then=O.then,"complete"===C.readyState||"loading"!==C.readyState&&!C.documentElement.doScroll?ie.setTimeout(ce.ready):(C.addEventListener("DOMContentLoaded",P),ie.addEventListener("load",P));var M=function(e,t,n,r,i,o,a){var s=0,u=e.length,l=null==n;if("object"===x(n))for(s in i=!0,n)M(e,t,s,n[s],!0,o,a);else if(void 0!==r&&(i=!0,v(r)||(a=!0),l&&(a?(t.call(e,r),t=null):(l=t,t=function(e,t,n){return l.call(ce(e),n)})),t))for(;s<u;s++)t(e[s],n,a?r:r.call(e[s],s,t(e[s],n)));return i?e:l?t.call(e):u?t(e[0],n):o},R=/^-ms-/,I=/-([a-z])/g;function W(e,t){return t.toUpperCase()}function F(e){return e.replace(R,"ms-").replace(I,W)}var $=function(e){return 1===e.nodeType||9===e.nodeType||!+e.nodeType};function B(){this.expando=ce.expando+B.uid++}B.uid=1,B.prototype={cache:function(e){var t=e[this.expando];return t||(t={},$(e)&&(e.nodeType?e[this.expando]=t:Object.defineProperty(e,this.expando,{value:t,configurable:!0}))),t},set:function(e,t,n){var r,i=this.cache(e);if("string"==typeof t)i[F(t)]=n;else for(r in t)i[F(r)]=t[r];return i},get:function(e,t){return void 0===t?this.cache(e):e[this.expando]&&e[this.expando][F(t)]},access:function(e,t,n){return void 0===t||t&&"string"==typeof t&&void 0===n?this.get(e,t):(this.set(e,t,n),void 0!==n?n:t)},remove:function(e,t){var n,r=e[this.expando];if(void 0!==r){if(void 0!==t){n=(t=Array.isArray(t)?t.map(F):(t=F(t))in r?[t]:t.match(D)||[]).length;while(n--)delete r[t[n]]}(void 0===t||ce.isEmptyObject(r))&&(e.nodeType?e[this.expando]=void 0:delete e[this.expando])}},hasData:function(e){var t=e[this.expando];return void 0!==t&&!ce.isEmptyObject(t)}};var _=new B,z=new B,X=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,U=/[A-Z]/g;function V(e,t,n){var r,i;if(void 0===n&&1===e.nodeType)if(r="data-"+t.replace(U,"-$&").toLowerCase(),"string"==typeof(n=e.getAttribute(r))){try{n="true"===(i=n)||"false"!==i&&("null"===i?null:i===+i+""?+i:X.test(i)?JSON.parse(i):i)}catch(e){}z.set(e,t,n)}else n=void 0;return n}ce.extend({hasData:function(e){return z.hasData(e)||_.hasData(e)},data:function(e,t,n){return z.access(e,t,n)},removeData:function(e,t){z.remove(e,t)},_data:function(e,t,n){return _.access(e,t,n)},_removeData:function(e,t){_.remove(e,t)}}),ce.fn.extend({data:function(n,e){var t,r,i,o=this[0],a=o&&o.attributes;if(void 0===n){if(this.length&&(i=z.get(o),1===o.nodeType&&!_.get(o,"hasDataAttrs"))){t=a.length;while(t--)a[t]&&0===(r=a[t].name).indexOf("data-")&&(r=F(r.slice(5)),V(o,r,i[r]));_.set(o,"hasDataAttrs",!0)}return i}return"object"==typeof n?this.each(function(){z.set(this,n)}):M(this,function(e){var t;if(o&&void 0===e)return void 0!==(t=z.get(o,n))?t:void 0!==(t=V(o,n))?t:void 0;this.each(function(){z.set(this,n,e)})},null,e,1<arguments.length,null,!0)},removeData:function(e){return this.each(function(){z.remove(this,e)})}}),ce.extend({queue:function(e,t,n){var r;if(e)return t=(t||"fx")+"queue",r=_.get(e,t),n&&(!r||Array.isArray(n)?r=_.access(e,t,ce.makeArray(n)):r.push(n)),r||[]},dequeue:function(e,t){t=t||"fx";var n=ce.queue(e,t),r=n.length,i=n.shift(),o=ce._queueHooks(e,t);"inprogress"===i&&(i=n.shift(),r--),i&&("fx"===t&&n.unshift("inprogress"),delete o.stop,i.call(e,function(){ce.dequeue(e,t)},o)),!r&&o&&o.empty.fire()},_queueHooks:function(e,t){var n=t+"queueHooks";return _.get(e,n)||_.access(e,n,{empty:ce.Callbacks("once memory").add(function(){_.remove(e,[t+"queue",n])})})}}),ce.fn.extend({queue:function(t,n){var e=2;return"string"!=typeof t&&(n=t,t="fx",e--),arguments.length<e?ce.queue(this[0],t):void 0===n?this:this.each(function(){var e=ce.queue(this,t,n);ce._queueHooks(this,t),"fx"===t&&"inprogress"!==e[0]&&ce.dequeue(this,t)})},dequeue:function(e){return this.each(function(){ce.dequeue(this,e)})},clearQueue:function(e){return this.queue(e||"fx",[])},promise:function(e,t){var n,r=1,i=ce.Deferred(),o=this,a=this.length,s=function(){--r||i.resolveWith(o,[o])};"string"!=typeof e&&(t=e,e=void 0),e=e||"fx";while(a--)(n=_.get(o[a],e+"queueHooks"))&&n.empty&&(r++,n.empty.add(s));return s(),i.promise(t)}});var G=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,Y=new RegExp("^(?:([+-])=|)("+G+")([a-z%]*)$","i"),Q=["Top","Right","Bottom","Left"],J=C.documentElement,K=function(e){return ce.contains(e.ownerDocument,e)},Z={composed:!0};J.getRootNode&&(K=function(e){return ce.contains(e.ownerDocument,e)||e.getRootNode(Z)===e.ownerDocument});var ee=function(e,t){return"none"===(e=t||e).style.display||""===e.style.display&&K(e)&&"none"===ce.css(e,"display")};function te(e,t,n,r){var i,o,a=20,s=r?function(){return r.cur()}:function(){return ce.css(e,t,"")},u=s(),l=n&&n[3]||(ce.cssNumber[t]?"":"px"),c=e.nodeType&&(ce.cssNumber[t]||"px"!==l&&+u)&&Y.exec(ce.css(e,t));if(c&&c[3]!==l){u/=2,l=l||c[3],c=+u||1;while(a--)ce.style(e,t,c+l),(1-o)*(1-(o=s()/u||.5))<=0&&(a=0),c/=o;c*=2,ce.style(e,t,c+l),n=n||[]}return n&&(c=+c||+u||0,i=n[1]?c+(n[1]+1)*n[2]:+n[2],r&&(r.unit=l,r.start=c,r.end=i)),i}var ne={};function re(e,t){for(var n,r,i,o,a,s,u,l=[],c=0,f=e.length;c<f;c++)(r=e[c]).style&&(n=r.style.display,t?("none"===n&&(l[c]=_.get(r,"display")||null,l[c]||(r.style.display="")),""===r.style.display&&ee(r)&&(l[c]=(u=a=o=void 0,a=(i=r).ownerDocument,s=i.nodeName,(u=ne[s])||(o=a.body.appendChild(a.createElement(s)),u=ce.css(o,"display"),o.parentNode.removeChild(o),"none"===u&&(u="block"),ne[s]=u)))):"none"!==n&&(l[c]="none",_.set(r,"display",n)));for(c=0;c<f;c++)null!=l[c]&&(e[c].style.display=l[c]);return e}ce.fn.extend({show:function(){return re(this,!0)},hide:function(){return re(this)},toggle:function(e){return"boolean"==typeof e?e?this.show():this.hide():this.each(function(){ee(this)?ce(this).show():ce(this).hide()})}});var xe,be,we=/^(?:checkbox|radio)$/i,Te=/<([a-z][^\/\0>\x20\t\r\n\f]*)/i,Ce=/^$|^module$|\/(?:java|ecma)script/i;xe=C.createDocumentFragment().appendChild(C.createElement("div")),(be=C.createElement("input")).setAttribute("type","radio"),be.setAttribute("checked","checked"),be.setAttribute("name","t"),xe.appendChild(be),le.checkClone=xe.cloneNode(!0).cloneNode(!0).lastChild.checked,xe.innerHTML="<textarea>x</textarea>",le.noCloneChecked=!!xe.cloneNode(!0).lastChild.defaultValue,xe.innerHTML="<option></option>",le.option=!!xe.lastChild;var ke={thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};function Se(e,t){var n;return n="undefined"!=typeof e.getElementsByTagName?e.getElementsByTagName(t||"*"):"undefined"!=typeof e.querySelectorAll?e.querySelectorAll(t||"*"):[],void 0===t||t&&fe(e,t)?ce.merge([e],n):n}function Ee(e,t){for(var n=0,r=e.length;n<r;n++)_.set(e[n],"globalEval",!t||_.get(t[n],"globalEval"))}ke.tbody=ke.tfoot=ke.colgroup=ke.caption=ke.thead,ke.th=ke.td,le.option||(ke.optgroup=ke.option=[1,"<select multiple='multiple'>","</select>"]);var je=/<|&#?\w+;/;function Ae(e,t,n,r,i){for(var o,a,s,u,l,c,f=t.createDocumentFragment(),p=[],d=0,h=e.length;d<h;d++)if((o=e[d])||0===o)if("object"===x(o))ce.merge(p,o.nodeType?[o]:o);else if(je.test(o)){a=a||f.appendChild(t.createElement("div")),s=(Te.exec(o)||["",""])[1].toLowerCase(),u=ke[s]||ke._default,a.innerHTML=u[1]+ce.htmlPrefilter(o)+u[2],c=u[0];while(c--)a=a.lastChild;ce.merge(p,a.childNodes),(a=f.firstChild).textContent=""}else p.push(t.createTextNode(o));f.textContent="",d=0;while(o=p[d++])if(r&&-1<ce.inArray(o,r))i&&i.push(o);else if(l=K(o),a=Se(f.appendChild(o),"script"),l&&Ee(a),n){c=0;while(o=a[c++])Ce.test(o.type||"")&&n.push(o)}return f}var De=/^([^.]*)(?:\.(.+)|)/;function Ne(){return!0}function qe(){return!1}function Le(e,t,n,r,i,o){var a,s;if("object"==typeof t){for(s in"string"!=typeof n&&(r=r||n,n=void 0),t)Le(e,s,n,r,t[s],o);return e}if(null==r&&null==i?(i=n,r=n=void 0):null==i&&("string"==typeof n?(i=r,r=void 0):(i=r,r=n,n=void 0)),!1===i)i=qe;else if(!i)return e;return 1===o&&(a=i,(i=function(e){return ce().off(e),a.apply(this,arguments)}).guid=a.guid||(a.guid=ce.guid++)),e.each(function(){ce.event.add(this,t,i,r,n)})}function He(e,r,t){t?(_.set(e,r,!1),ce.event.add(e,r,{namespace:!1,handler:function(e){var t,n=_.get(this,r);if(1&e.isTrigger&&this[r]){if(n)(ce.event.special[r]||{}).delegateType&&e.stopPropagation();else if(n=ae.call(arguments),_.set(this,r,n),this[r](),t=_.get(this,r),_.set(this,r,!1),n!==t)return e.stopImmediatePropagation(),e.preventDefault(),t}else n&&(_.set(this,r,ce.event.trigger(n[0],n.slice(1),this)),e.stopPropagation(),e.isImmediatePropagationStopped=Ne)}})):void 0===_.get(e,r)&&ce.event.add(e,r,Ne)}ce.event={global:{},add:function(t,e,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,v=_.get(t);if($(t)){n.handler&&(n=(o=n).handler,i=o.selector),i&&ce.find.matchesSelector(J,i),n.guid||(n.guid=ce.guid++),(u=v.events)||(u=v.events=Object.create(null)),(a=v.handle)||(a=v.handle=function(e){return"undefined"!=typeof ce&&ce.event.triggered!==e.type?ce.event.dispatch.apply(t,arguments):void 0}),l=(e=(e||"").match(D)||[""]).length;while(l--)d=g=(s=De.exec(e[l])||[])[1],h=(s[2]||"").split(".").sort(),d&&(f=ce.event.special[d]||{},d=(i?f.delegateType:f.bindType)||d,f=ce.event.special[d]||{},c=ce.extend({type:d,origType:g,data:r,handler:n,guid:n.guid,selector:i,needsContext:i&&ce.expr.match.needsContext.test(i),namespace:h.join(".")},o),(p=u[d])||((p=u[d]=[]).delegateCount=0,f.setup&&!1!==f.setup.call(t,r,h,a)||t.addEventListener&&t.addEventListener(d,a)),f.add&&(f.add.call(t,c),c.handler.guid||(c.handler.guid=n.guid)),i?p.splice(p.delegateCount++,0,c):p.push(c),ce.event.global[d]=!0)}},remove:function(e,t,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,v=_.hasData(e)&&_.get(e);if(v&&(u=v.events)){l=(t=(t||"").match(D)||[""]).length;while(l--)if(d=g=(s=De.exec(t[l])||[])[1],h=(s[2]||"").split(".").sort(),d){f=ce.event.special[d]||{},p=u[d=(r?f.delegateType:f.bindType)||d]||[],s=s[2]&&new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"),a=o=p.length;while(o--)c=p[o],!i&&g!==c.origType||n&&n.guid!==c.guid||s&&!s.test(c.namespace)||r&&r!==c.selector&&("**"!==r||!c.selector)||(p.splice(o,1),c.selector&&p.delegateCount--,f.remove&&f.remove.call(e,c));a&&!p.length&&(f.teardown&&!1!==f.teardown.call(e,h,v.handle)||ce.removeEvent(e,d,v.handle),delete u[d])}else for(d in u)ce.event.remove(e,d+t[l],n,r,!0);ce.isEmptyObject(u)&&_.remove(e,"handle events")}},dispatch:function(e){var t,n,r,i,o,a,s=new Array(arguments.length),u=ce.event.fix(e),l=(_.get(this,"events")||Object.create(null))[u.type]||[],c=ce.event.special[u.type]||{};for(s[0]=u,t=1;t<arguments.length;t++)s[t]=arguments[t];if(u.delegateTarget=this,!c.preDispatch||!1!==c.preDispatch.call(this,u)){a=ce.event.handlers.call(this,u,l),t=0;while((i=a[t++])&&!u.isPropagationStopped()){u.currentTarget=i.elem,n=0;while((o=i.handlers[n++])&&!u.isImmediatePropagationStopped())u.rnamespace&&!1!==o.namespace&&!u.rnamespace.test(o.namespace)||(u.handleObj=o,u.data=o.data,void 0!==(r=((ce.event.special[o.origType]||{}).handle||o.handler).apply(i.elem,s))&&!1===(u.result=r)&&(u.preventDefault(),u.stopPropagation()))}return c.postDispatch&&c.postDispatch.call(this,u),u.result}},handlers:function(e,t){var n,r,i,o,a,s=[],u=t.delegateCount,l=e.target;if(u&&l.nodeType&&!("click"===e.type&&1<=e.button))for(;l!==this;l=l.parentNode||this)if(1===l.nodeType&&("click"!==e.type||!0!==l.disabled)){for(o=[],a={},n=0;n<u;n++)void 0===a[i=(r=t[n]).selector+" "]&&(a[i]=r.needsContext?-1<ce(i,this).index(l):ce.find(i,this,null,[l]).length),a[i]&&o.push(r);o.length&&s.push({elem:l,handlers:o})}return l=this,u<t.length&&s.push({elem:l,handlers:t.slice(u)}),s},addProp:function(t,e){Object.defineProperty(ce.Event.prototype,t,{enumerable:!0,configurable:!0,get:v(e)?function(){if(this.originalEvent)return e(this.originalEvent)}:function(){if(this.originalEvent)return this.originalEvent[t]},set:function(e){Object.defineProperty(this,t,{enumerable:!0,configurable:!0,writable:!0,value:e})}})},fix:function(e){return e[ce.expando]?e:new ce.Event(e)},special:{load:{noBubble:!0},click:{setup:function(e){var t=this||e;return we.test(t.type)&&t.click&&fe(t,"input")&&He(t,"click",!0),!1},trigger:function(e){var t=this||e;return we.test(t.type)&&t.click&&fe(t,"input")&&He(t,"click"),!0},_default:function(e){var t=e.target;return we.test(t.type)&&t.click&&fe(t,"input")&&_.get(t,"click")||fe(t,"a")}},beforeunload:{postDispatch:function(e){void 0!==e.result&&e.originalEvent&&(e.originalEvent.returnValue=e.result)}}}},ce.removeEvent=function(e,t,n){e.removeEventListener&&e.removeEventListener(t,n)},ce.Event=function(e,t){if(!(this instanceof ce.Event))return new ce.Event(e,t);e&&e.type?(this.originalEvent=e,this.type=e.type,this.isDefaultPrevented=e.defaultPrevented||void 0===e.defaultPrevented&&!1===e.returnValue?Ne:qe,this.target=e.target&&3===e.target.nodeType?e.target.parentNode:e.target,this.currentTarget=e.currentTarget,this.relatedTarget=e.relatedTarget):this.type=e,t&&ce.extend(this,t),this.timeStamp=e&&e.timeStamp||Date.now(),this[ce.expando]=!0},ce.Event.prototype={constructor:ce.Event,isDefaultPrevented:qe,isPropagationStopped:qe,isImmediatePropagationStopped:qe,isSimulated:!1,preventDefault:function(){var e=this.originalEvent;this.isDefaultPrevented=Ne,e&&!this.isSimulated&&e.preventDefault()},stopPropagation:function(){var e=this.originalEvent;this.isPropagationStopped=Ne,e&&!this.isSimulated&&e.stopPropagation()},stopImmediatePropagation:function(){var e=this.originalEvent;this.isImmediatePropagationStopped=Ne,e&&!this.isSimulated&&e.stopImmediatePropagation(),this.stopPropagation()}},ce.each({altKey:!0,bubbles:!0,cancelable:!0,changedTouches:!0,ctrlKey:!0,detail:!0,eventPhase:!0,metaKey:!0,pageX:!0,pageY:!0,shiftKey:!0,view:!0,"char":!0,code:!0,charCode:!0,key:!0,keyCode:!0,button:!0,buttons:!0,clientX:!0,clientY:!0,offsetX:!0,offsetY:!0,pointerId:!0,pointerType:!0,screenX:!0,screenY:!0,targetTouches:!0,toElement:!0,touches:!0,which:!0},ce.event.addProp),ce.each({focus:"focusin",blur:"focusout"},function(r,i){function o(e){if(C.documentMode){var t=_.get(this,"handle"),n=ce.event.fix(e);n.type="focusin"===e.type?"focus":"blur",n.isSimulated=!0,t(e),n.target===n.currentTarget&&t(n)}else ce.event.simulate(i,e.target,ce.event.fix(e))}ce.event.special[r]={setup:function(){var e;if(He(this,r,!0),!C.documentMode)return!1;(e=_.get(this,i))||this.addEventListener(i,o),_.set(this,i,(e||0)+1)},trigger:function(){return He(this,r),!0},teardown:function(){var e;if(!C.documentMode)return!1;(e=_.get(this,i)-1)?_.set(this,i,e):(this.removeEventListener(i,o),_.remove(this,i))},_default:function(e){return _.get(e.target,r)},delegateType:i},ce.event.special[i]={setup:function(){var e=this.ownerDocument||this.document||this,t=C.documentMode?this:e,n=_.get(t,i);n||(C.documentMode?this.addEventListener(i,o):e.addEventListener(r,o,!0)),_.set(t,i,(n||0)+1)},teardown:function(){var e=this.ownerDocument||this.document||this,t=C.documentMode?this:e,n=_.get(t,i)-1;n?_.set(t,i,n):(C.documentMode?this.removeEventListener(i,o):e.removeEventListener(r,o,!0),_.remove(t,i))}}}),ce.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(e,i){ce.event.special[e]={delegateType:i,bindType:i,handle:function(e){var t,n=e.relatedTarget,r=e.handleObj;return n&&(n===this||ce.contains(this,n))||(e.type=r.origType,t=r.handler.apply(this,arguments),e.type=i),t}}}),ce.fn.extend({on:function(e,t,n,r){return Le(this,e,t,n,r)},one:function(e,t,n,r){return Le(this,e,t,n,r,1)},off:function(e,t,n){var r,i;if(e&&e.preventDefault&&e.handleObj)return r=e.handleObj,ce(e.delegateTarget).off(r.namespace?r.origType+"."+r.namespace:r.origType,r.selector,r.handler),this;if("object"==typeof e){for(i in e)this.off(i,t,e[i]);return this}return!1!==t&&"function"!=typeof t||(n=t,t=void 0),!1===n&&(n=qe),this.each(function(){ce.event.remove(this,e,n,t)})}});var Oe=/<script|<style|<link/i,Pe=/checked\s*(?:[^=]|=\s*.checked.)/i,Me=/^\s*<!\[CDATA\[|\]\]>\s*$/g;function Re(e,t){return fe(e,"table")&&fe(11!==t.nodeType?t:t.firstChild,"tr")&&ce(e).children("tbody")[0]||e}function Ie(e){return e.type=(null!==e.getAttribute("type"))+"/"+e.type,e}function We(e){return"true/"===(e.type||"").slice(0,5)?e.type=e.type.slice(5):e.removeAttribute("type"),e}function Fe(e,t){var n,r,i,o,a,s;if(1===t.nodeType){if(_.hasData(e)&&(s=_.get(e).events))for(i in _.remove(t,"handle events"),s)for(n=0,r=s[i].length;n<r;n++)ce.event.add(t,i,s[i][n]);z.hasData(e)&&(o=z.access(e),a=ce.extend({},o),z.set(t,a))}}function $e(n,r,i,o){r=g(r);var e,t,a,s,u,l,c=0,f=n.length,p=f-1,d=r[0],h=v(d);if(h||1<f&&"string"==typeof d&&!le.checkClone&&Pe.test(d))return n.each(function(e){var t=n.eq(e);h&&(r[0]=d.call(this,e,t.html())),$e(t,r,i,o)});if(f&&(t=(e=Ae(r,n[0].ownerDocument,!1,n,o)).firstChild,1===e.childNodes.length&&(e=t),t||o)){for(s=(a=ce.map(Se(e,"script"),Ie)).length;c<f;c++)u=e,c!==p&&(u=ce.clone(u,!0,!0),s&&ce.merge(a,Se(u,"script"))),i.call(n[c],u,c);if(s)for(l=a[a.length-1].ownerDocument,ce.map(a,We),c=0;c<s;c++)u=a[c],Ce.test(u.type||"")&&!_.access(u,"globalEval")&&ce.contains(l,u)&&(u.src&&"module"!==(u.type||"").toLowerCase()?ce._evalUrl&&!u.noModule&&ce._evalUrl(u.src,{nonce:u.nonce||u.getAttribute("nonce")},l):m(u.textContent.replace(Me,""),u,l))}return n}function Be(e,t,n){for(var r,i=t?ce.filter(t,e):e,o=0;null!=(r=i[o]);o++)n||1!==r.nodeType||ce.cleanData(Se(r)),r.parentNode&&(n&&K(r)&&Ee(Se(r,"script")),r.parentNode.removeChild(r));return e}ce.extend({htmlPrefilter:function(e){return e},clone:function(e,t,n){var r,i,o,a,s,u,l,c=e.cloneNode(!0),f=K(e);if(!(le.noCloneChecked||1!==e.nodeType&&11!==e.nodeType||ce.isXMLDoc(e)))for(a=Se(c),r=0,i=(o=Se(e)).length;r<i;r++)s=o[r],u=a[r],void 0,"input"===(l=u.nodeName.toLowerCase())&&we.test(s.type)?u.checked=s.checked:"input"!==l&&"textarea"!==l||(u.defaultValue=s.defaultValue);if(t)if(n)for(o=o||Se(e),a=a||Se(c),r=0,i=o.length;r<i;r++)Fe(o[r],a[r]);else Fe(e,c);return 0<(a=Se(c,"script")).length&&Ee(a,!f&&Se(e,"script")),c},cleanData:function(e){for(var t,n,r,i=ce.event.special,o=0;void 0!==(n=e[o]);o++)if($(n)){if(t=n[_.expando]){if(t.events)for(r in t.events)i[r]?ce.event.remove(n,r):ce.removeEvent(n,r,t.handle);n[_.expando]=void 0}n[z.expando]&&(n[z.expando]=void 0)}}}),ce.fn.extend({detach:function(e){return Be(this,e,!0)},remove:function(e){return Be(this,e)},text:function(e){return M(this,function(e){return void 0===e?ce.text(this):this.empty().each(function(){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||(this.textContent=e)})},null,e,arguments.length)},append:function(){return $e(this,arguments,function(e){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||Re(this,e).appendChild(e)})},prepend:function(){return $e(this,arguments,function(e){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var t=Re(this,e);t.insertBefore(e,t.firstChild)}})},before:function(){return $e(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this)})},after:function(){return $e(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this.nextSibling)})},empty:function(){for(var e,t=0;null!=(e=this[t]);t++)1===e.nodeType&&(ce.cleanData(Se(e,!1)),e.textContent="");return this},clone:function(e,t){return e=null!=e&&e,t=null==t?e:t,this.map(function(){return ce.clone(this,e,t)})},html:function(e){return M(this,function(e){var t=this[0]||{},n=0,r=this.length;if(void 0===e&&1===t.nodeType)return t.innerHTML;if("string"==typeof e&&!Oe.test(e)&&!ke[(Te.exec(e)||["",""])[1].toLowerCase()]){e=ce.htmlPrefilter(e);try{for(;n<r;n++)1===(t=this[n]||{}).nodeType&&(ce.cleanData(Se(t,!1)),t.innerHTML=e);t=0}catch(e){}}t&&this.empty().append(e)},null,e,arguments.length)},replaceWith:function(){var n=[];return $e(this,arguments,function(e){var t=this.parentNode;ce.inArray(this,n)<0&&(ce.cleanData(Se(this)),t&&t.replaceChild(e,this))},n)}}),ce.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(e,a){ce.fn[e]=function(e){for(var t,n=[],r=ce(e),i=r.length-1,o=0;o<=i;o++)t=o===i?this:this.clone(!0),ce(r[o])[a](t),s.apply(n,t.get());return this.pushStack(n)}});var _e=new RegExp("^("+G+")(?!px)[a-z%]+$","i"),ze=/^--/,Xe=function(e){var t=e.ownerDocument.defaultView;return t&&t.opener||(t=ie),t.getComputedStyle(e)},Ue=function(e,t,n){var r,i,o={};for(i in t)o[i]=e.style[i],e.style[i]=t[i];for(i in r=n.call(e),t)e.style[i]=o[i];return r},Ve=new RegExp(Q.join("|"),"i");function Ge(e,t,n){var r,i,o,a,s=ze.test(t),u=e.style;return(n=n||Xe(e))&&(a=n.getPropertyValue(t)||n[t],s&&a&&(a=a.replace(ve,"$1")||void 0),""!==a||K(e)||(a=ce.style(e,t)),!le.pixelBoxStyles()&&_e.test(a)&&Ve.test(t)&&(r=u.width,i=u.minWidth,o=u.maxWidth,u.minWidth=u.maxWidth=u.width=a,a=n.width,u.width=r,u.minWidth=i,u.maxWidth=o)),void 0!==a?a+"":a}function Ye(e,t){return{get:function(){if(!e())return(this.get=t).apply(this,arguments);delete this.get}}}!function(){function e(){if(l){u.style.cssText="position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0",l.style.cssText="position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%",J.appendChild(u).appendChild(l);var e=ie.getComputedStyle(l);n="1%"!==e.top,s=12===t(e.marginLeft),l.style.right="60%",o=36===t(e.right),r=36===t(e.width),l.style.position="absolute",i=12===t(l.offsetWidth/3),J.removeChild(u),l=null}}function t(e){return Math.round(parseFloat(e))}var n,r,i,o,a,s,u=C.createElement("div"),l=C.createElement("div");l.style&&(l.style.backgroundClip="content-box",l.cloneNode(!0).style.backgroundClip="",le.clearCloneStyle="content-box"===l.style.backgroundClip,ce.extend(le,{boxSizingReliable:function(){return e(),r},pixelBoxStyles:function(){return e(),o},pixelPosition:function(){return e(),n},reliableMarginLeft:function(){return e(),s},scrollboxSize:function(){return e(),i},reliableTrDimensions:function(){var e,t,n,r;return null==a&&(e=C.createElement("table"),t=C.createElement("tr"),n=C.createElement("div"),e.style.cssText="position:absolute;left:-11111px;border-collapse:separate",t.style.cssText="box-sizing:content-box;border:1px solid",t.style.height="1px",n.style.height="9px",n.style.display="block",J.appendChild(e).appendChild(t).appendChild(n),r=ie.getComputedStyle(t),a=parseInt(r.height,10)+parseInt(r.borderTopWidth,10)+parseInt(r.borderBottomWidth,10)===t.offsetHeight,J.removeChild(e)),a}}))}();var Qe=["Webkit","Moz","ms"],Je=C.createElement("div").style,Ke={};function Ze(e){var t=ce.cssProps[e]||Ke[e];return t||(e in Je?e:Ke[e]=function(e){var t=e[0].toUpperCase()+e.slice(1),n=Qe.length;while(n--)if((e=Qe[n]+t)in Je)return e}(e)||e)}var et=/^(none|table(?!-c[ea]).+)/,tt={position:"absolute",visibility:"hidden",display:"block"},nt={letterSpacing:"0",fontWeight:"400"};function rt(e,t,n){var r=Y.exec(t);return r?Math.max(0,r[2]-(n||0))+(r[3]||"px"):t}function it(e,t,n,r,i,o){var a="width"===t?1:0,s=0,u=0,l=0;if(n===(r?"border":"content"))return 0;for(;a<4;a+=2)"margin"===n&&(l+=ce.css(e,n+Q[a],!0,i)),r?("content"===n&&(u-=ce.css(e,"padding"+Q[a],!0,i)),"margin"!==n&&(u-=ce.css(e,"border"+Q[a]+"Width",!0,i))):(u+=ce.css(e,"padding"+Q[a],!0,i),"padding"!==n?u+=ce.css(e,"border"+Q[a]+"Width",!0,i):s+=ce.css(e,"border"+Q[a]+"Width",!0,i));return!r&&0<=o&&(u+=Math.max(0,Math.ceil(e["offset"+t[0].toUpperCase()+t.slice(1)]-o-u-s-.5))||0),u+l}function ot(e,t,n){var r=Xe(e),i=(!le.boxSizingReliable()||n)&&"border-box"===ce.css(e,"boxSizing",!1,r),o=i,a=Ge(e,t,r),s="offset"+t[0].toUpperCase()+t.slice(1);if(_e.test(a)){if(!n)return a;a="auto"}return(!le.boxSizingReliable()&&i||!le.reliableTrDimensions()&&fe(e,"tr")||"auto"===a||!parseFloat(a)&&"inline"===ce.css(e,"display",!1,r))&&e.getClientRects().length&&(i="border-box"===ce.css(e,"boxSizing",!1,r),(o=s in e)&&(a=e[s])),(a=parseFloat(a)||0)+it(e,t,n||(i?"border":"content"),o,r,a)+"px"}function at(e,t,n,r,i){return new at.prototype.init(e,t,n,r,i)}ce.extend({cssHooks:{opacity:{get:function(e,t){if(t){var n=Ge(e,"opacity");return""===n?"1":n}}}},cssNumber:{animationIterationCount:!0,aspectRatio:!0,borderImageSlice:!0,columnCount:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,gridArea:!0,gridColumn:!0,gridColumnEnd:!0,gridColumnStart:!0,gridRow:!0,gridRowEnd:!0,gridRowStart:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,scale:!0,widows:!0,zIndex:!0,zoom:!0,fillOpacity:!0,floodOpacity:!0,stopOpacity:!0,strokeMiterlimit:!0,strokeOpacity:!0},cssProps:{},style:function(e,t,n,r){if(e&&3!==e.nodeType&&8!==e.nodeType&&e.style){var i,o,a,s=F(t),u=ze.test(t),l=e.style;if(u||(t=Ze(s)),a=ce.cssHooks[t]||ce.cssHooks[s],void 0===n)return a&&"get"in a&&void 0!==(i=a.get(e,!1,r))?i:l[t];"string"===(o=typeof n)&&(i=Y.exec(n))&&i[1]&&(n=te(e,t,i),o="number"),null!=n&&n==n&&("number"!==o||u||(n+=i&&i[3]||(ce.cssNumber[s]?"":"px")),le.clearCloneStyle||""!==n||0!==t.indexOf("background")||(l[t]="inherit"),a&&"set"in a&&void 0===(n=a.set(e,n,r))||(u?l.setProperty(t,n):l[t]=n))}},css:function(e,t,n,r){var i,o,a,s=F(t);return ze.test(t)||(t=Ze(s)),(a=ce.cssHooks[t]||ce.cssHooks[s])&&"get"in a&&(i=a.get(e,!0,n)),void 0===i&&(i=Ge(e,t,r)),"normal"===i&&t in nt&&(i=nt[t]),""===n||n?(o=parseFloat(i),!0===n||isFinite(o)?o||0:i):i}}),ce.each(["height","width"],function(e,u){ce.cssHooks[u]={get:function(e,t,n){if(t)return!et.test(ce.css(e,"display"))||e.getClientRects().length&&e.getBoundingClientRect().width?ot(e,u,n):Ue(e,tt,function(){return ot(e,u,n)})},set:function(e,t,n){var r,i=Xe(e),o=!le.scrollboxSize()&&"absolute"===i.position,a=(o||n)&&"border-box"===ce.css(e,"boxSizing",!1,i),s=n?it(e,u,n,a,i):0;return a&&o&&(s-=Math.ceil(e["offset"+u[0].toUpperCase()+u.slice(1)]-parseFloat(i[u])-it(e,u,"border",!1,i)-.5)),s&&(r=Y.exec(t))&&"px"!==(r[3]||"px")&&(e.style[u]=t,t=ce.css(e,u)),rt(0,t,s)}}}),ce.cssHooks.marginLeft=Ye(le.reliableMarginLeft,function(e,t){if(t)return(parseFloat(Ge(e,"marginLeft"))||e.getBoundingClientRect().left-Ue(e,{marginLeft:0},function(){return e.getBoundingClientRect().left}))+"px"}),ce.each({margin:"",padding:"",border:"Width"},function(i,o){ce.cssHooks[i+o]={expand:function(e){for(var t=0,n={},r="string"==typeof e?e.split(" "):[e];t<4;t++)n[i+Q[t]+o]=r[t]||r[t-2]||r[0];return n}},"margin"!==i&&(ce.cssHooks[i+o].set=rt)}),ce.fn.extend({css:function(e,t){return M(this,function(e,t,n){var r,i,o={},a=0;if(Array.isArray(t)){for(r=Xe(e),i=t.length;a<i;a++)o[t[a]]=ce.css(e,t[a],!1,r);return o}return void 0!==n?ce.style(e,t,n):ce.css(e,t)},e,t,1<arguments.length)}}),((ce.Tween=at).prototype={constructor:at,init:function(e,t,n,r,i,o){this.elem=e,this.prop=n,this.easing=i||ce.easing._default,this.options=t,this.start=this.now=this.cur(),this.end=r,this.unit=o||(ce.cssNumber[n]?"":"px")},cur:function(){var e=at.propHooks[this.prop];return e&&e.get?e.get(this):at.propHooks._default.get(this)},run:function(e){var t,n=at.propHooks[this.prop];return this.options.duration?this.pos=t=ce.easing[this.easing](e,this.options.duration*e,0,1,this.options.duration):this.pos=t=e,this.now=(this.end-this.start)*t+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),n&&n.set?n.set(this):at.propHooks._default.set(this),this}}).init.prototype=at.prototype,(at.propHooks={_default:{get:function(e){var t;return 1!==e.elem.nodeType||null!=e.elem[e.prop]&&null==e.elem.style[e.prop]?e.elem[e.prop]:(t=ce.css(e.elem,e.prop,""))&&"auto"!==t?t:0},set:function(e){ce.fx.step[e.prop]?ce.fx.step[e.prop](e):1!==e.elem.nodeType||!ce.cssHooks[e.prop]&&null==e.elem.style[Ze(e.prop)]?e.elem[e.prop]=e.now:ce.style(e.elem,e.prop,e.now+e.unit)}}}).scrollTop=at.propHooks.scrollLeft={set:function(e){e.elem.nodeType&&e.elem.parentNode&&(e.elem[e.prop]=e.now)}},ce.easing={linear:function(e){return e},swing:function(e){return.5-Math.cos(e*Math.PI)/2},_default:"swing"},ce.fx=at.prototype.init,ce.fx.step={};var st,ut,lt,ct,ft=/^(?:toggle|show|hide)$/,pt=/queueHooks$/;function dt(){ut&&(!1===C.hidden&&ie.requestAnimationFrame?ie.requestAnimationFrame(dt):ie.setTimeout(dt,ce.fx.interval),ce.fx.tick())}function ht(){return ie.setTimeout(function(){st=void 0}),st=Date.now()}function gt(e,t){var n,r=0,i={height:e};for(t=t?1:0;r<4;r+=2-t)i["margin"+(n=Q[r])]=i["padding"+n]=e;return t&&(i.opacity=i.width=e),i}function vt(e,t,n){for(var r,i=(yt.tweeners[t]||[]).concat(yt.tweeners["*"]),o=0,a=i.length;o<a;o++)if(r=i[o].call(n,t,e))return r}function yt(o,e,t){var n,a,r=0,i=yt.prefilters.length,s=ce.Deferred().always(function(){delete u.elem}),u=function(){if(a)return!1;for(var e=st||ht(),t=Math.max(0,l.startTime+l.duration-e),n=1-(t/l.duration||0),r=0,i=l.tweens.length;r<i;r++)l.tweens[r].run(n);return s.notifyWith(o,[l,n,t]),n<1&&i?t:(i||s.notifyWith(o,[l,1,0]),s.resolveWith(o,[l]),!1)},l=s.promise({elem:o,props:ce.extend({},e),opts:ce.extend(!0,{specialEasing:{},easing:ce.easing._default},t),originalProperties:e,originalOptions:t,startTime:st||ht(),duration:t.duration,tweens:[],createTween:function(e,t){var n=ce.Tween(o,l.opts,e,t,l.opts.specialEasing[e]||l.opts.easing);return l.tweens.push(n),n},stop:function(e){var t=0,n=e?l.tweens.length:0;if(a)return this;for(a=!0;t<n;t++)l.tweens[t].run(1);return e?(s.notifyWith(o,[l,1,0]),s.resolveWith(o,[l,e])):s.rejectWith(o,[l,e]),this}}),c=l.props;for(!function(e,t){var n,r,i,o,a;for(n in e)if(i=t[r=F(n)],o=e[n],Array.isArray(o)&&(i=o[1],o=e[n]=o[0]),n!==r&&(e[r]=o,delete e[n]),(a=ce.cssHooks[r])&&"expand"in a)for(n in o=a.expand(o),delete e[r],o)n in e||(e[n]=o[n],t[n]=i);else t[r]=i}(c,l.opts.specialEasing);r<i;r++)if(n=yt.prefilters[r].call(l,o,c,l.opts))return v(n.stop)&&(ce._queueHooks(l.elem,l.opts.queue).stop=n.stop.bind(n)),n;return ce.map(c,vt,l),v(l.opts.start)&&l.opts.start.call(o,l),l.progress(l.opts.progress).done(l.opts.done,l.opts.complete).fail(l.opts.fail).always(l.opts.always),ce.fx.timer(ce.extend(u,{elem:o,anim:l,queue:l.opts.queue})),l}ce.Animation=ce.extend(yt,{tweeners:{"*":[function(e,t){var n=this.createTween(e,t);return te(n.elem,e,Y.exec(t),n),n}]},tweener:function(e,t){v(e)?(t=e,e=["*"]):e=e.match(D);for(var n,r=0,i=e.length;r<i;r++)n=e[r],yt.tweeners[n]=yt.tweeners[n]||[],yt.tweeners[n].unshift(t)},prefilters:[function(e,t,n){var r,i,o,a,s,u,l,c,f="width"in t||"height"in t,p=this,d={},h=e.style,g=e.nodeType&&ee(e),v=_.get(e,"fxshow");for(r in n.queue||(null==(a=ce._queueHooks(e,"fx")).unqueued&&(a.unqueued=0,s=a.empty.fire,a.empty.fire=function(){a.unqueued||s()}),a.unqueued++,p.always(function(){p.always(function(){a.unqueued--,ce.queue(e,"fx").length||a.empty.fire()})})),t)if(i=t[r],ft.test(i)){if(delete t[r],o=o||"toggle"===i,i===(g?"hide":"show")){if("show"!==i||!v||void 0===v[r])continue;g=!0}d[r]=v&&v[r]||ce.style(e,r)}if((u=!ce.isEmptyObject(t))||!ce.isEmptyObject(d))for(r in f&&1===e.nodeType&&(n.overflow=[h.overflow,h.overflowX,h.overflowY],null==(l=v&&v.display)&&(l=_.get(e,"display")),"none"===(c=ce.css(e,"display"))&&(l?c=l:(re([e],!0),l=e.style.display||l,c=ce.css(e,"display"),re([e]))),("inline"===c||"inline-block"===c&&null!=l)&&"none"===ce.css(e,"float")&&(u||(p.done(function(){h.display=l}),null==l&&(c=h.display,l="none"===c?"":c)),h.display="inline-block")),n.overflow&&(h.overflow="hidden",p.always(function(){h.overflow=n.overflow[0],h.overflowX=n.overflow[1],h.overflowY=n.overflow[2]})),u=!1,d)u||(v?"hidden"in v&&(g=v.hidden):v=_.access(e,"fxshow",{display:l}),o&&(v.hidden=!g),g&&re([e],!0),p.done(function(){for(r in g||re([e]),_.remove(e,"fxshow"),d)ce.style(e,r,d[r])})),u=vt(g?v[r]:0,r,p),r in v||(v[r]=u.start,g&&(u.end=u.start,u.start=0))}],prefilter:function(e,t){t?yt.prefilters.unshift(e):yt.prefilters.push(e)}}),ce.speed=function(e,t,n){var r=e&&"object"==typeof e?ce.extend({},e):{complete:n||!n&&t||v(e)&&e,duration:e,easing:n&&t||t&&!v(t)&&t};return ce.fx.off?r.duration=0:"number"!=typeof r.duration&&(r.duration in ce.fx.speeds?r.duration=ce.fx.speeds[r.duration]:r.duration=ce.fx.speeds._default),null!=r.queue&&!0!==r.queue||(r.queue="fx"),r.old=r.complete,r.complete=function(){v(r.old)&&r.old.call(this),r.queue&&ce.dequeue(this,r.queue)},r},ce.fn.extend({fadeTo:function(e,t,n,r){return this.filter(ee).css("opacity",0).show().end().animate({opacity:t},e,n,r)},animate:function(t,e,n,r){var i=ce.isEmptyObject(t),o=ce.speed(e,n,r),a=function(){var e=yt(this,ce.extend({},t),o);(i||_.get(this,"finish"))&&e.stop(!0)};return a.finish=a,i||!1===o.queue?this.each(a):this.queue(o.queue,a)},stop:function(i,e,o){var a=function(e){var t=e.stop;delete e.stop,t(o)};return"string"!=typeof i&&(o=e,e=i,i=void 0),e&&this.queue(i||"fx",[]),this.each(function(){var e=!0,t=null!=i&&i+"queueHooks",n=ce.timers,r=_.get(this);if(t)r[t]&&r[t].stop&&a(r[t]);else for(t in r)r[t]&&r[t].stop&&pt.test(t)&&a(r[t]);for(t=n.length;t--;)n[t].elem!==this||null!=i&&n[t].queue!==i||(n[t].anim.stop(o),e=!1,n.splice(t,1));!e&&o||ce.dequeue(this,i)})},finish:function(a){return!1!==a&&(a=a||"fx"),this.each(function(){var e,t=_.get(this),n=t[a+"queue"],r=t[a+"queueHooks"],i=ce.timers,o=n?n.length:0;for(t.finish=!0,ce.queue(this,a,[]),r&&r.stop&&r.stop.call(this,!0),e=i.length;e--;)i[e].elem===this&&i[e].queue===a&&(i[e].anim.stop(!0),i.splice(e,1));for(e=0;e<o;e++)n[e]&&n[e].finish&&n[e].finish.call(this);delete t.finish})}}),ce.each(["toggle","show","hide"],function(e,r){var i=ce.fn[r];ce.fn[r]=function(e,t,n){return null==e||"boolean"==typeof e?i.apply(this,arguments):this.animate(gt(r,!0),e,t,n)}}),ce.each({slideDown:gt("show"),slideUp:gt("hide"),slideToggle:gt("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(e,r){ce.fn[e]=function(e,t,n){return this.animate(r,e,t,n)}}),ce.timers=[],ce.fx.tick=function(){var e,t=0,n=ce.timers;for(st=Date.now();t<n.length;t++)(e=n[t])()||n[t]!==e||n.splice(t--,1);n.length||ce.fx.stop(),st=void 0},ce.fx.timer=function(e){ce.timers.push(e),ce.fx.start()},ce.fx.interval=13,ce.fx.start=function(){ut||(ut=!0,dt())},ce.fx.stop=function(){ut=null},ce.fx.speeds={slow:600,fast:200,_default:400},ce.fn.delay=function(r,e){return r=ce.fx&&ce.fx.speeds[r]||r,e=e||"fx",this.queue(e,function(e,t){var n=ie.setTimeout(e,r);t.stop=function(){ie.clearTimeout(n)}})},lt=C.createElement("input"),ct=C.createElement("select").appendChild(C.createElement("option")),lt.type="checkbox",le.checkOn=""!==lt.value,le.optSelected=ct.selected,(lt=C.createElement("input")).value="t",lt.type="radio",le.radioValue="t"===lt.value;var mt,xt=ce.expr.attrHandle;ce.fn.extend({attr:function(e,t){return M(this,ce.attr,e,t,1<arguments.length)},removeAttr:function(e){return this.each(function(){ce.removeAttr(this,e)})}}),ce.extend({attr:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return"undefined"==typeof e.getAttribute?ce.prop(e,t,n):(1===o&&ce.isXMLDoc(e)||(i=ce.attrHooks[t.toLowerCase()]||(ce.expr.match.bool.test(t)?mt:void 0)),void 0!==n?null===n?void ce.removeAttr(e,t):i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:(e.setAttribute(t,n+""),n):i&&"get"in i&&null!==(r=i.get(e,t))?r:null==(r=ce.find.attr(e,t))?void 0:r)},attrHooks:{type:{set:function(e,t){if(!le.radioValue&&"radio"===t&&fe(e,"input")){var n=e.value;return e.setAttribute("type",t),n&&(e.value=n),t}}}},removeAttr:function(e,t){var n,r=0,i=t&&t.match(D);if(i&&1===e.nodeType)while(n=i[r++])e.removeAttribute(n)}}),mt={set:function(e,t,n){return!1===t?ce.removeAttr(e,n):e.setAttribute(n,n),n}},ce.each(ce.expr.match.bool.source.match(/\w+/g),function(e,t){var a=xt[t]||ce.find.attr;xt[t]=function(e,t,n){var r,i,o=t.toLowerCase();return n||(i=xt[o],xt[o]=r,r=null!=a(e,t,n)?o:null,xt[o]=i),r}});var bt=/^(?:input|select|textarea|button)$/i,wt=/^(?:a|area)$/i;function Tt(e){return(e.match(D)||[]).join(" ")}function Ct(e){return e.getAttribute&&e.getAttribute("class")||""}function kt(e){return Array.isArray(e)?e:"string"==typeof e&&e.match(D)||[]}ce.fn.extend({prop:function(e,t){return M(this,ce.prop,e,t,1<arguments.length)},removeProp:function(e){return this.each(function(){delete this[ce.propFix[e]||e]})}}),ce.extend({prop:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return 1===o&&ce.isXMLDoc(e)||(t=ce.propFix[t]||t,i=ce.propHooks[t]),void 0!==n?i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:e[t]=n:i&&"get"in i&&null!==(r=i.get(e,t))?r:e[t]},propHooks:{tabIndex:{get:function(e){var t=ce.find.attr(e,"tabindex");return t?parseInt(t,10):bt.test(e.nodeName)||wt.test(e.nodeName)&&e.href?0:-1}}},propFix:{"for":"htmlFor","class":"className"}}),le.optSelected||(ce.propHooks.selected={get:function(e){var t=e.parentNode;return t&&t.parentNode&&t.parentNode.selectedIndex,null},set:function(e){var t=e.parentNode;t&&(t.selectedIndex,t.parentNode&&t.parentNode.selectedIndex)}}),ce.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){ce.propFix[this.toLowerCase()]=this}),ce.fn.extend({addClass:function(t){var e,n,r,i,o,a;return v(t)?this.each(function(e){ce(this).addClass(t.call(this,e,Ct(this)))}):(e=kt(t)).length?this.each(function(){if(r=Ct(this),n=1===this.nodeType&&" "+Tt(r)+" "){for(o=0;o<e.length;o++)i=e[o],n.indexOf(" "+i+" ")<0&&(n+=i+" ");a=Tt(n),r!==a&&this.setAttribute("class",a)}}):this},removeClass:function(t){var e,n,r,i,o,a;return v(t)?this.each(function(e){ce(this).removeClass(t.call(this,e,Ct(this)))}):arguments.length?(e=kt(t)).length?this.each(function(){if(r=Ct(this),n=1===this.nodeType&&" "+Tt(r)+" "){for(o=0;o<e.length;o++){i=e[o];while(-1<n.indexOf(" "+i+" "))n=n.replace(" "+i+" "," ")}a=Tt(n),r!==a&&this.setAttribute("class",a)}}):this:this.attr("class","")},toggleClass:function(t,n){var e,r,i,o,a=typeof t,s="string"===a||Array.isArray(t);return v(t)?this.each(function(e){ce(this).toggleClass(t.call(this,e,Ct(this),n),n)}):"boolean"==typeof n&&s?n?this.addClass(t):this.removeClass(t):(e=kt(t),this.each(function(){if(s)for(o=ce(this),i=0;i<e.length;i++)r=e[i],o.hasClass(r)?o.removeClass(r):o.addClass(r);else void 0!==t&&"boolean"!==a||((r=Ct(this))&&_.set(this,"__className__",r),this.setAttribute&&this.setAttribute("class",r||!1===t?"":_.get(this,"__className__")||""))}))},hasClass:function(e){var t,n,r=0;t=" "+e+" ";while(n=this[r++])if(1===n.nodeType&&-1<(" "+Tt(Ct(n))+" ").indexOf(t))return!0;return!1}});var St=/\r/g;ce.fn.extend({val:function(n){var r,e,i,t=this[0];return arguments.length?(i=v(n),this.each(function(e){var t;1===this.nodeType&&(null==(t=i?n.call(this,e,ce(this).val()):n)?t="":"number"==typeof t?t+="":Array.isArray(t)&&(t=ce.map(t,function(e){return null==e?"":e+""})),(r=ce.valHooks[this.type]||ce.valHooks[this.nodeName.toLowerCase()])&&"set"in r&&void 0!==r.set(this,t,"value")||(this.value=t))})):t?(r=ce.valHooks[t.type]||ce.valHooks[t.nodeName.toLowerCase()])&&"get"in r&&void 0!==(e=r.get(t,"value"))?e:"string"==typeof(e=t.value)?e.replace(St,""):null==e?"":e:void 0}}),ce.extend({valHooks:{option:{get:function(e){var t=ce.find.attr(e,"value");return null!=t?t:Tt(ce.text(e))}},select:{get:function(e){var t,n,r,i=e.options,o=e.selectedIndex,a="select-one"===e.type,s=a?null:[],u=a?o+1:i.length;for(r=o<0?u:a?o:0;r<u;r++)if(((n=i[r]).selected||r===o)&&!n.disabled&&(!n.parentNode.disabled||!fe(n.parentNode,"optgroup"))){if(t=ce(n).val(),a)return t;s.push(t)}return s},set:function(e,t){var n,r,i=e.options,o=ce.makeArray(t),a=i.length;while(a--)((r=i[a]).selected=-1<ce.inArray(ce.valHooks.option.get(r),o))&&(n=!0);return n||(e.selectedIndex=-1),o}}}}),ce.each(["radio","checkbox"],function(){ce.valHooks[this]={set:function(e,t){if(Array.isArray(t))return e.checked=-1<ce.inArray(ce(e).val(),t)}},le.checkOn||(ce.valHooks[this].get=function(e){return null===e.getAttribute("value")?"on":e.value})});var Et=ie.location,jt={guid:Date.now()},At=/\?/;ce.parseXML=function(e){var t,n;if(!e||"string"!=typeof e)return null;try{t=(new ie.DOMParser).parseFromString(e,"text/xml")}catch(e){}return n=t&&t.getElementsByTagName("parsererror")[0],t&&!n||ce.error("Invalid XML: "+(n?ce.map(n.childNodes,function(e){return e.textContent}).join("\n"):e)),t};var Dt=/^(?:focusinfocus|focusoutblur)$/,Nt=function(e){e.stopPropagation()};ce.extend(ce.event,{trigger:function(e,t,n,r){var i,o,a,s,u,l,c,f,p=[n||C],d=ue.call(e,"type")?e.type:e,h=ue.call(e,"namespace")?e.namespace.split("."):[];if(o=f=a=n=n||C,3!==n.nodeType&&8!==n.nodeType&&!Dt.test(d+ce.event.triggered)&&(-1<d.indexOf(".")&&(d=(h=d.split(".")).shift(),h.sort()),u=d.indexOf(":")<0&&"on"+d,(e=e[ce.expando]?e:new ce.Event(d,"object"==typeof e&&e)).isTrigger=r?2:3,e.namespace=h.join("."),e.rnamespace=e.namespace?new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,e.result=void 0,e.target||(e.target=n),t=null==t?[e]:ce.makeArray(t,[e]),c=ce.event.special[d]||{},r||!c.trigger||!1!==c.trigger.apply(n,t))){if(!r&&!c.noBubble&&!y(n)){for(s=c.delegateType||d,Dt.test(s+d)||(o=o.parentNode);o;o=o.parentNode)p.push(o),a=o;a===(n.ownerDocument||C)&&p.push(a.defaultView||a.parentWindow||ie)}i=0;while((o=p[i++])&&!e.isPropagationStopped())f=o,e.type=1<i?s:c.bindType||d,(l=(_.get(o,"events")||Object.create(null))[e.type]&&_.get(o,"handle"))&&l.apply(o,t),(l=u&&o[u])&&l.apply&&$(o)&&(e.result=l.apply(o,t),!1===e.result&&e.preventDefault());return e.type=d,r||e.isDefaultPrevented()||c._default&&!1!==c._default.apply(p.pop(),t)||!$(n)||u&&v(n[d])&&!y(n)&&((a=n[u])&&(n[u]=null),ce.event.triggered=d,e.isPropagationStopped()&&f.addEventListener(d,Nt),n[d](),e.isPropagationStopped()&&f.removeEventListener(d,Nt),ce.event.triggered=void 0,a&&(n[u]=a)),e.result}},simulate:function(e,t,n){var r=ce.extend(new ce.Event,n,{type:e,isSimulated:!0});ce.event.trigger(r,null,t)}}),ce.fn.extend({trigger:function(e,t){return this.each(function(){ce.event.trigger(e,t,this)})},triggerHandler:function(e,t){var n=this[0];if(n)return ce.event.trigger(e,t,n,!0)}});var qt=/\[\]$/,Lt=/\r?\n/g,Ht=/^(?:submit|button|image|reset|file)$/i,Ot=/^(?:input|select|textarea|keygen)/i;function Pt(n,e,r,i){var t;if(Array.isArray(e))ce.each(e,function(e,t){r||qt.test(n)?i(n,t):Pt(n+"["+("object"==typeof t&&null!=t?e:"")+"]",t,r,i)});else if(r||"object"!==x(e))i(n,e);else for(t in e)Pt(n+"["+t+"]",e[t],r,i)}ce.param=function(e,t){var n,r=[],i=function(e,t){var n=v(t)?t():t;r[r.length]=encodeURIComponent(e)+"="+encodeURIComponent(null==n?"":n)};if(null==e)return"";if(Array.isArray(e)||e.jquery&&!ce.isPlainObject(e))ce.each(e,function(){i(this.name,this.value)});else for(n in e)Pt(n,e[n],t,i);return r.join("&")},ce.fn.extend({serialize:function(){return ce.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var e=ce.prop(this,"elements");return e?ce.makeArray(e):this}).filter(function(){var e=this.type;return this.name&&!ce(this).is(":disabled")&&Ot.test(this.nodeName)&&!Ht.test(e)&&(this.checked||!we.test(e))}).map(function(e,t){var n=ce(this).val();return null==n?null:Array.isArray(n)?ce.map(n,function(e){return{name:t.name,value:e.replace(Lt,"\r\n")}}):{name:t.name,value:n.replace(Lt,"\r\n")}}).get()}});var Mt=/%20/g,Rt=/#.*$/,It=/([?&])_=[^&]*/,Wt=/^(.*?):[ \t]*([^\r\n]*)$/gm,Ft=/^(?:GET|HEAD)$/,$t=/^\/\//,Bt={},_t={},zt="*/".concat("*"),Xt=C.createElement("a");function Ut(o){return function(e,t){"string"!=typeof e&&(t=e,e="*");var n,r=0,i=e.toLowerCase().match(D)||[];if(v(t))while(n=i[r++])"+"===n[0]?(n=n.slice(1)||"*",(o[n]=o[n]||[]).unshift(t)):(o[n]=o[n]||[]).push(t)}}function Vt(t,i,o,a){var s={},u=t===_t;function l(e){var r;return s[e]=!0,ce.each(t[e]||[],function(e,t){var n=t(i,o,a);return"string"!=typeof n||u||s[n]?u?!(r=n):void 0:(i.dataTypes.unshift(n),l(n),!1)}),r}return l(i.dataTypes[0])||!s["*"]&&l("*")}function Gt(e,t){var n,r,i=ce.ajaxSettings.flatOptions||{};for(n in t)void 0!==t[n]&&((i[n]?e:r||(r={}))[n]=t[n]);return r&&ce.extend(!0,e,r),e}Xt.href=Et.href,ce.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:Et.href,type:"GET",isLocal:/^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(Et.protocol),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":zt,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/\bxml\b/,html:/\bhtml/,json:/\bjson\b/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":JSON.parse,"text xml":ce.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(e,t){return t?Gt(Gt(e,ce.ajaxSettings),t):Gt(ce.ajaxSettings,e)},ajaxPrefilter:Ut(Bt),ajaxTransport:Ut(_t),ajax:function(e,t){"object"==typeof e&&(t=e,e=void 0),t=t||{};var c,f,p,n,d,r,h,g,i,o,v=ce.ajaxSetup({},t),y=v.context||v,m=v.context&&(y.nodeType||y.jquery)?ce(y):ce.event,x=ce.Deferred(),b=ce.Callbacks("once memory"),w=v.statusCode||{},a={},s={},u="canceled",T={readyState:0,getResponseHeader:function(e){var t;if(h){if(!n){n={};while(t=Wt.exec(p))n[t[1].toLowerCase()+" "]=(n[t[1].toLowerCase()+" "]||[]).concat(t[2])}t=n[e.toLowerCase()+" "]}return null==t?null:t.join(", ")},getAllResponseHeaders:function(){return h?p:null},setRequestHeader:function(e,t){return null==h&&(e=s[e.toLowerCase()]=s[e.toLowerCase()]||e,a[e]=t),this},overrideMimeType:function(e){return null==h&&(v.mimeType=e),this},statusCode:function(e){var t;if(e)if(h)T.always(e[T.status]);else for(t in e)w[t]=[w[t],e[t]];return this},abort:function(e){var t=e||u;return c&&c.abort(t),l(0,t),this}};if(x.promise(T),v.url=((e||v.url||Et.href)+"").replace($t,Et.protocol+"//"),v.type=t.method||t.type||v.method||v.type,v.dataTypes=(v.dataType||"*").toLowerCase().match(D)||[""],null==v.crossDomain){r=C.createElement("a");try{r.href=v.url,r.href=r.href,v.crossDomain=Xt.protocol+"//"+Xt.host!=r.protocol+"//"+r.host}catch(e){v.crossDomain=!0}}if(v.data&&v.processData&&"string"!=typeof v.data&&(v.data=ce.param(v.data,v.traditional)),Vt(Bt,v,t,T),h)return T;for(i in(g=ce.event&&v.global)&&0==ce.active++&&ce.event.trigger("ajaxStart"),v.type=v.type.toUpperCase(),v.hasContent=!Ft.test(v.type),f=v.url.replace(Rt,""),v.hasContent?v.data&&v.processData&&0===(v.contentType||"").indexOf("application/x-www-form-urlencoded")&&(v.data=v.data.replace(Mt,"+")):(o=v.url.slice(f.length),v.data&&(v.processData||"string"==typeof v.data)&&(f+=(At.test(f)?"&":"?")+v.data,delete v.data),!1===v.cache&&(f=f.replace(It,"$1"),o=(At.test(f)?"&":"?")+"_="+jt.guid+++o),v.url=f+o),v.ifModified&&(ce.lastModified[f]&&T.setRequestHeader("If-Modified-Since",ce.lastModified[f]),ce.etag[f]&&T.setRequestHeader("If-None-Match",ce.etag[f])),(v.data&&v.hasContent&&!1!==v.contentType||t.contentType)&&T.setRequestHeader("Content-Type",v.contentType),T.setRequestHeader("Accept",v.dataTypes[0]&&v.accepts[v.dataTypes[0]]?v.accepts[v.dataTypes[0]]+("*"!==v.dataTypes[0]?", "+zt+"; q=0.01":""):v.accepts["*"]),v.headers)T.setRequestHeader(i,v.headers[i]);if(v.beforeSend&&(!1===v.beforeSend.call(y,T,v)||h))return T.abort();if(u="abort",b.add(v.complete),T.done(v.success),T.fail(v.error),c=Vt(_t,v,t,T)){if(T.readyState=1,g&&m.trigger("ajaxSend",[T,v]),h)return T;v.async&&0<v.timeout&&(d=ie.setTimeout(function(){T.abort("timeout")},v.timeout));try{h=!1,c.send(a,l)}catch(e){if(h)throw e;l(-1,e)}}else l(-1,"No Transport");function l(e,t,n,r){var i,o,a,s,u,l=t;h||(h=!0,d&&ie.clearTimeout(d),c=void 0,p=r||"",T.readyState=0<e?4:0,i=200<=e&&e<300||304===e,n&&(s=function(e,t,n){var r,i,o,a,s=e.contents,u=e.dataTypes;while("*"===u[0])u.shift(),void 0===r&&(r=e.mimeType||t.getResponseHeader("Content-Type"));if(r)for(i in s)if(s[i]&&s[i].test(r)){u.unshift(i);break}if(u[0]in n)o=u[0];else{for(i in n){if(!u[0]||e.converters[i+" "+u[0]]){o=i;break}a||(a=i)}o=o||a}if(o)return o!==u[0]&&u.unshift(o),n[o]}(v,T,n)),!i&&-1<ce.inArray("script",v.dataTypes)&&ce.inArray("json",v.dataTypes)<0&&(v.converters["text script"]=function(){}),s=function(e,t,n,r){var i,o,a,s,u,l={},c=e.dataTypes.slice();if(c[1])for(a in e.converters)l[a.toLowerCase()]=e.converters[a];o=c.shift();while(o)if(e.responseFields[o]&&(n[e.responseFields[o]]=t),!u&&r&&e.dataFilter&&(t=e.dataFilter(t,e.dataType)),u=o,o=c.shift())if("*"===o)o=u;else if("*"!==u&&u!==o){if(!(a=l[u+" "+o]||l["* "+o]))for(i in l)if((s=i.split(" "))[1]===o&&(a=l[u+" "+s[0]]||l["* "+s[0]])){!0===a?a=l[i]:!0!==l[i]&&(o=s[0],c.unshift(s[1]));break}if(!0!==a)if(a&&e["throws"])t=a(t);else try{t=a(t)}catch(e){return{state:"parsererror",error:a?e:"No conversion from "+u+" to "+o}}}return{state:"success",data:t}}(v,s,T,i),i?(v.ifModified&&((u=T.getResponseHeader("Last-Modified"))&&(ce.lastModified[f]=u),(u=T.getResponseHeader("etag"))&&(ce.etag[f]=u)),204===e||"HEAD"===v.type?l="nocontent":304===e?l="notmodified":(l=s.state,o=s.data,i=!(a=s.error))):(a=l,!e&&l||(l="error",e<0&&(e=0))),T.status=e,T.statusText=(t||l)+"",i?x.resolveWith(y,[o,l,T]):x.rejectWith(y,[T,l,a]),T.statusCode(w),w=void 0,g&&m.trigger(i?"ajaxSuccess":"ajaxError",[T,v,i?o:a]),b.fireWith(y,[T,l]),g&&(m.trigger("ajaxComplete",[T,v]),--ce.active||ce.event.trigger("ajaxStop")))}return T},getJSON:function(e,t,n){return ce.get(e,t,n,"json")},getScript:function(e,t){return ce.get(e,void 0,t,"script")}}),ce.each(["get","post"],function(e,i){ce[i]=function(e,t,n,r){return v(t)&&(r=r||n,n=t,t=void 0),ce.ajax(ce.extend({url:e,type:i,dataType:r,data:t,success:n},ce.isPlainObject(e)&&e))}}),ce.ajaxPrefilter(function(e){var t;for(t in e.headers)"content-type"===t.toLowerCase()&&(e.contentType=e.headers[t]||"")}),ce._evalUrl=function(e,t,n){return ce.ajax({url:e,type:"GET",dataType:"script",cache:!0,async:!1,global:!1,converters:{"text script":function(){}},dataFilter:function(e){ce.globalEval(e,t,n)}})},ce.fn.extend({wrapAll:function(e){var t;return this[0]&&(v(e)&&(e=e.call(this[0])),t=ce(e,this[0].ownerDocument).eq(0).clone(!0),this[0].parentNode&&t.insertBefore(this[0]),t.map(function(){var e=this;while(e.firstElementChild)e=e.firstElementChild;return e}).append(this)),this},wrapInner:function(n){return v(n)?this.each(function(e){ce(this).wrapInner(n.call(this,e))}):this.each(function(){var e=ce(this),t=e.contents();t.length?t.wrapAll(n):e.append(n)})},wrap:function(t){var n=v(t);return this.each(function(e){ce(this).wrapAll(n?t.call(this,e):t)})},unwrap:function(e){return this.parent(e).not("body").each(function(){ce(this).replaceWith(this.childNodes)}),this}}),ce.expr.pseudos.hidden=function(e){return!ce.expr.pseudos.visible(e)},ce.expr.pseudos.visible=function(e){return!!(e.offsetWidth||e.offsetHeight||e.getClientRects().length)},ce.ajaxSettings.xhr=function(){try{return new ie.XMLHttpRequest}catch(e){}};var Yt={0:200,1223:204},Qt=ce.ajaxSettings.xhr();le.cors=!!Qt&&"withCredentials"in Qt,le.ajax=Qt=!!Qt,ce.ajaxTransport(function(i){var o,a;if(le.cors||Qt&&!i.crossDomain)return{send:function(e,t){var n,r=i.xhr();if(r.open(i.type,i.url,i.async,i.username,i.password),i.xhrFields)for(n in i.xhrFields)r[n]=i.xhrFields[n];for(n in i.mimeType&&r.overrideMimeType&&r.overrideMimeType(i.mimeType),i.crossDomain||e["X-Requested-With"]||(e["X-Requested-With"]="XMLHttpRequest"),e)r.setRequestHeader(n,e[n]);o=function(e){return function(){o&&(o=a=r.onload=r.onerror=r.onabort=r.ontimeout=r.onreadystatechange=null,"abort"===e?r.abort():"error"===e?"number"!=typeof r.status?t(0,"error"):t(r.status,r.statusText):t(Yt[r.status]||r.status,r.statusText,"text"!==(r.responseType||"text")||"string"!=typeof r.responseText?{binary:r.response}:{text:r.responseText},r.getAllResponseHeaders()))}},r.onload=o(),a=r.onerror=r.ontimeout=o("error"),void 0!==r.onabort?r.onabort=a:r.onreadystatechange=function(){4===r.readyState&&ie.setTimeout(function(){o&&a()})},o=o("abort");try{r.send(i.hasContent&&i.data||null)}catch(e){if(o)throw e}},abort:function(){o&&o()}}}),ce.ajaxPrefilter(function(e){e.crossDomain&&(e.contents.script=!1)}),ce.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/\b(?:java|ecma)script\b/},converters:{"text script":function(e){return ce.globalEval(e),e}}}),ce.ajaxPrefilter("script",function(e){void 0===e.cache&&(e.cache=!1),e.crossDomain&&(e.type="GET")}),ce.ajaxTransport("script",function(n){var r,i;if(n.crossDomain||n.scriptAttrs)return{send:function(e,t){r=ce("<script>").attr(n.scriptAttrs||{}).prop({charset:n.scriptCharset,src:n.url}).on("load error",i=function(e){r.remove(),i=null,e&&t("error"===e.type?404:200,e.type)}),C.head.appendChild(r[0])},abort:function(){i&&i()}}});var Jt,Kt=[],Zt=/(=)\?(?=&|$)|\?\?/;ce.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var e=Kt.pop()||ce.expando+"_"+jt.guid++;return this[e]=!0,e}}),ce.ajaxPrefilter("json jsonp",function(e,t,n){var r,i,o,a=!1!==e.jsonp&&(Zt.test(e.url)?"url":"string"==typeof e.data&&0===(e.contentType||"").indexOf("application/x-www-form-urlencoded")&&Zt.test(e.data)&&"data");if(a||"jsonp"===e.dataTypes[0])return r=e.jsonpCallback=v(e.jsonpCallback)?e.jsonpCallback():e.jsonpCallback,a?e[a]=e[a].replace(Zt,"$1"+r):!1!==e.jsonp&&(e.url+=(At.test(e.url)?"&":"?")+e.jsonp+"="+r),e.converters["script json"]=function(){return o||ce.error(r+" was not called"),o[0]},e.dataTypes[0]="json",i=ie[r],ie[r]=function(){o=arguments},n.always(function(){void 0===i?ce(ie).removeProp(r):ie[r]=i,e[r]&&(e.jsonpCallback=t.jsonpCallback,Kt.push(r)),o&&v(i)&&i(o[0]),o=i=void 0}),"script"}),le.createHTMLDocument=((Jt=C.implementation.createHTMLDocument("").body).innerHTML="<form></form><form></form>",2===Jt.childNodes.length),ce.parseHTML=function(e,t,n){return"string"!=typeof e?[]:("boolean"==typeof t&&(n=t,t=!1),t||(le.createHTMLDocument?((r=(t=C.implementation.createHTMLDocument("")).createElement("base")).href=C.location.href,t.head.appendChild(r)):t=C),o=!n&&[],(i=w.exec(e))?[t.createElement(i[1])]:(i=Ae([e],t,o),o&&o.length&&ce(o).remove(),ce.merge([],i.childNodes)));var r,i,o},ce.fn.load=function(e,t,n){var r,i,o,a=this,s=e.indexOf(" ");return-1<s&&(r=Tt(e.slice(s)),e=e.slice(0,s)),v(t)?(n=t,t=void 0):t&&"object"==typeof t&&(i="POST"),0<a.length&&ce.ajax({url:e,type:i||"GET",dataType:"html",data:t}).done(function(e){o=arguments,a.html(r?ce("<div>").append(ce.parseHTML(e)).find(r):e)}).always(n&&function(e,t){a.each(function(){n.apply(this,o||[e.responseText,t,e])})}),this},ce.expr.pseudos.animated=function(t){return ce.grep(ce.timers,function(e){return t===e.elem}).length},ce.offset={setOffset:function(e,t,n){var r,i,o,a,s,u,l=ce.css(e,"position"),c=ce(e),f={};"static"===l&&(e.style.position="relative"),s=c.offset(),o=ce.css(e,"top"),u=ce.css(e,"left"),("absolute"===l||"fixed"===l)&&-1<(o+u).indexOf("auto")?(a=(r=c.position()).top,i=r.left):(a=parseFloat(o)||0,i=parseFloat(u)||0),v(t)&&(t=t.call(e,n,ce.extend({},s))),null!=t.top&&(f.top=t.top-s.top+a),null!=t.left&&(f.left=t.left-s.left+i),"using"in t?t.using.call(e,f):c.css(f)}},ce.fn.extend({offset:function(t){if(arguments.length)return void 0===t?this:this.each(function(e){ce.offset.setOffset(this,t,e)});var e,n,r=this[0];return r?r.getClientRects().length?(e=r.getBoundingClientRect(),n=r.ownerDocument.defaultView,{top:e.top+n.pageYOffset,left:e.left+n.pageXOffset}):{top:0,left:0}:void 0},position:function(){if(this[0]){var e,t,n,r=this[0],i={top:0,left:0};if("fixed"===ce.css(r,"position"))t=r.getBoundingClientRect();else{t=this.offset(),n=r.ownerDocument,e=r.offsetParent||n.documentElement;while(e&&(e===n.body||e===n.documentElement)&&"static"===ce.css(e,"position"))e=e.parentNode;e&&e!==r&&1===e.nodeType&&((i=ce(e).offset()).top+=ce.css(e,"borderTopWidth",!0),i.left+=ce.css(e,"borderLeftWidth",!0))}return{top:t.top-i.top-ce.css(r,"marginTop",!0),left:t.left-i.left-ce.css(r,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){var e=this.offsetParent;while(e&&"static"===ce.css(e,"position"))e=e.offsetParent;return e||J})}}),ce.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(t,i){var o="pageYOffset"===i;ce.fn[t]=function(e){return M(this,function(e,t,n){var r;if(y(e)?r=e:9===e.nodeType&&(r=e.defaultView),void 0===n)return r?r[i]:e[t];r?r.scrollTo(o?r.pageXOffset:n,o?n:r.pageYOffset):e[t]=n},t,e,arguments.length)}}),ce.each(["top","left"],function(e,n){ce.cssHooks[n]=Ye(le.pixelPosition,function(e,t){if(t)return t=Ge(e,n),_e.test(t)?ce(e).position()[n]+"px":t})}),ce.each({Height:"height",Width:"width"},function(a,s){ce.each({padding:"inner"+a,content:s,"":"outer"+a},function(r,o){ce.fn[o]=function(e,t){var n=arguments.length&&(r||"boolean"!=typeof e),i=r||(!0===e||!0===t?"margin":"border");return M(this,function(e,t,n){var r;return y(e)?0===o.indexOf("outer")?e["inner"+a]:e.document.documentElement["client"+a]:9===e.nodeType?(r=e.documentElement,Math.max(e.body["scroll"+a],r["scroll"+a],e.body["offset"+a],r["offset"+a],r["client"+a])):void 0===n?ce.css(e,t,i):ce.style(e,t,n,i)},s,n?e:void 0,n)}})}),ce.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(e,t){ce.fn[t]=function(e){return this.on(t,e)}}),ce.fn.extend({bind:function(e,t,n){return this.on(e,null,t,n)},unbind:function(e,t){return this.off(e,null,t)},delegate:function(e,t,n,r){return this.on(t,e,n,r)},undelegate:function(e,t,n){return 1===arguments.length?this.off(e,"**"):this.off(t,e||"**",n)},hover:function(e,t){return this.on("mouseenter",e).on("mouseleave",t||e)}}),ce.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "),function(e,n){ce.fn[n]=function(e,t){return 0<arguments.length?this.on(n,null,e,t):this.trigger(n)}});var en=/^[\s\uFEFF\xA0]+|([^\s\uFEFF\xA0])[\s\uFEFF\xA0]+$/g;ce.proxy=function(e,t){var n,r,i;if("string"==typeof t&&(n=e[t],t=e,e=n),v(e))return r=ae.call(arguments,2),(i=function(){return e.apply(t||this,r.concat(ae.call(arguments)))}).guid=e.guid=e.guid||ce.guid++,i},ce.holdReady=function(e){e?ce.readyWait++:ce.ready(!0)},ce.isArray=Array.isArray,ce.parseJSON=JSON.parse,ce.nodeName=fe,ce.isFunction=v,ce.isWindow=y,ce.camelCase=F,ce.type=x,ce.now=Date.now,ce.isNumeric=function(e){var t=ce.type(e);return("number"===t||"string"===t)&&!isNaN(e-parseFloat(e))},ce.trim=function(e){return null==e?"":(e+"").replace(en,"$1")},"function"==typeof define&&define.amd&&define("jquery",[],function(){return ce});var tn=ie.jQuery,nn=ie.$;return ce.noConflict=function(e){return ie.$===ce&&(ie.$=nn),e&&ie.jQuery===ce&&(ie.jQuery=tn),ce},"undefined"==typeof e&&(ie.jQuery=ie.$=ce),ce});

// Validate min
/*!
 * jQuery Validation Plugin v1.19.5
 *
 * https://jqueryvalidation.org/
 *
 * Copyright (c) 2022 Jörn Zaefferer
 * Released under the MIT license
*/ !function (a) { "function" == typeof define && define.amd ? define(["jquery"], a) : "object" == typeof module && module.exports ? module.exports = a(require("jquery")) : a(jQuery) }(function ($) { $.extend($.fn, { validate: function (b) { if (!this.length) { b && b.debug && window.console && console.warn("Nothing selected, can't validate, returning nothing."); return } var a = $.data(this[0], "validator"); return a || (this.attr("novalidate", "novalidate"), a = new $.validator(b, this[0]), $.data(this[0], "validator", a), a.settings.onsubmit && (this.on("click.validate", ":submit", function (b) { a.submitButton = b.currentTarget, $(this).hasClass("cancel") && (a.cancelSubmit = !0), void 0 !== $(this).attr("formnovalidate") && (a.cancelSubmit = !0) }), this.on("submit.validate", function (c) { function b() { var b, d; return a.submitButton && (a.settings.submitHandler || a.formSubmitted) && (b = $("<input type='hidden'/>").attr("name", a.submitButton.name).val($(a.submitButton).val()).appendTo(a.currentForm)), !a.settings.submitHandler || !!a.settings.debug || (d = a.settings.submitHandler.call(a, a.currentForm, c), b && b.remove(), void 0 !== d && d) } return (a.settings.debug && c.preventDefault(), a.cancelSubmit) ? (a.cancelSubmit = !1, b()) : a.form() ? a.pendingRequest ? (a.formSubmitted = !0, !1) : b() : (a.focusInvalid(), !1) }))), a }, valid: function () { var a, b, c; return $(this[0]).is("form") ? a = this.validate().form() : (c = [], a = !0, b = $(this[0].form).validate(), this.each(function () { (a = b.element(this) && a) || (c = c.concat(b.errorList)) }), b.errorList = c), a }, rules: function (h, c) { var f, g, d, b, e, i, a = this[0], j = void 0 !== this.attr("contenteditable") && "false" !== this.attr("contenteditable"); if (null != a && (!a.form && j && (a.form = this.closest("form")[0], a.name = this.attr("name")), null != a.form)) { if (h) switch (g = (f = $.data(a.form, "validator").settings).rules, d = $.validator.staticRules(a), h) { case "add": $.extend(d, $.validator.normalizeRule(c)), delete d.messages, g[a.name] = d, c.messages && (f.messages[a.name] = $.extend(f.messages[a.name], c.messages)); break; case "remove": if (!c) return delete g[a.name], d; return i = {}, $.each(c.split(/\s/), function (b, a) { i[a] = d[a], delete d[a] }), i }return (b = $.validator.normalizeRules($.extend({}, $.validator.classRules(a), $.validator.attributeRules(a), $.validator.dataRules(a), $.validator.staticRules(a)), a)).required && (e = b.required, delete b.required, b = $.extend({ required: e }, b)), b.remote && (e = b.remote, delete b.remote, b = $.extend(b, { remote: e })), b } } }); var a, c = function (a) { return a.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "") }; $.extend($.expr.pseudos || $.expr[":"], { blank: function (a) { return !c("" + $(a).val()) }, filled: function (b) { var a = $(b).val(); return null !== a && !!c("" + a) }, unchecked: function (a) { return !$(a).prop("checked") } }), $.validator = function (a, b) { this.settings = $.extend(!0, {}, $.validator.defaults, a), this.currentForm = b, this.init() }, $.validator.format = function (b, a) { return 1 === arguments.length ? function () { var a = $.makeArray(arguments); return a.unshift(b), $.validator.format.apply(this, a) } : (void 0 === a || (arguments.length > 2 && a.constructor !== Array && (a = $.makeArray(arguments).slice(1)), a.constructor !== Array && (a = [a]), $.each(a, function (a, c) { b = b.replace(new RegExp("\\{" + a + "\\}", "g"), function () { return c }) })), b) }, $.extend($.validator, { defaults: { messages: {}, groups: {}, rules: {}, errorClass: "error", pendingClass: "pending", validClass: "valid", errorElement: "label", focusCleanup: !1, focusInvalid: !0, errorContainer: $([]), errorLabelContainer: $([]), onsubmit: !0, ignore: ":hidden", ignoreTitle: !1, onfocusin: function (a) { this.lastActive = a, this.settings.focusCleanup && (this.settings.unhighlight && this.settings.unhighlight.call(this, a, this.settings.errorClass, this.settings.validClass), this.hideThese(this.errorsFor(a))) }, onfocusout: function (a) { !this.checkable(a) && (a.name in this.submitted || !this.optional(a)) && this.element(a) }, onkeyup: function (a, b) { (9 !== b.which || "" !== this.elementValue(a)) && -1 === $.inArray(b.keyCode, [16, 17, 18, 20, 35, 36, 37, 38, 39, 40, 45, 144, 225]) && (a.name in this.submitted || a.name in this.invalid) && this.element(a) }, onclick: function (a) { a.name in this.submitted ? this.element(a) : a.parentNode.name in this.submitted && this.element(a.parentNode) }, highlight: function (a, b, c) { "radio" === a.type ? this.findByName(a.name).addClass(b).removeClass(c) : $(a).addClass(b).removeClass(c) }, unhighlight: function (a, b, c) { "radio" === a.type ? this.findByName(a.name).removeClass(b).addClass(c) : $(a).removeClass(b).addClass(c) } }, setDefaults: function (a) { $.extend($.validator.defaults, a) }, messages: { required: "This field is required.", remote: "Please fix this field.", email: "Please enter a valid email address.", url: "Please enter a valid URL.", date: "Please enter a valid date.", dateISO: "Please enter a valid date (ISO).", number: "Please enter a valid number.", digits: "Please enter only digits.", equalTo: "Please enter the same value again.", maxlength: $.validator.format("Please enter no more than {0} characters."), minlength: $.validator.format("Please enter at least {0} characters."), rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."), range: $.validator.format("Please enter a value between {0} and {1}."), max: $.validator.format("Please enter a value less than or equal to {0}."), min: $.validator.format("Please enter a value greater than or equal to {0}."), step: $.validator.format("Please enter a multiple of {0}.") }, autoCreateRanges: !1, prototype: { init: function () { this.labelContainer = $(this.settings.errorLabelContainer), this.errorContext = this.labelContainer.length && this.labelContainer || $(this.currentForm), this.containers = $(this.settings.errorContainer).add(this.settings.errorLabelContainer), this.submitted = {}, this.valueCache = {}, this.pendingRequest = 0, this.pending = {}, this.invalid = {}, this.reset(); var a, c = this.currentForm, d = this.groups = {}; function b(b) { var f = void 0 !== $(this).attr("contenteditable") && "false" !== $(this).attr("contenteditable"); if (!this.form && f && (this.form = $(this).closest("form")[0], this.name = $(this).attr("name")), c === this.form) { var d = $.data(this.form, "validator"), e = "on" + b.type.replace(/^validate/, ""), a = d.settings; a[e] && !$(this).is(a.ignore) && a[e].call(d, this, b) } } $.each(this.settings.groups, function (b, a) { "string" == typeof a && (a = a.split(/\s/)), $.each(a, function (c, a) { d[a] = b }) }), a = this.settings.rules, $.each(a, function (b, c) { a[b] = $.validator.normalizeRule(c) }), $(this.currentForm).on("focusin.validate focusout.validate keyup.validate", ":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'], [type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'], [type='radio'], [type='checkbox'], [contenteditable], [type='button']", b).on("click.validate", "select, option, [type='radio'], [type='checkbox']", b), this.settings.invalidHandler && $(this.currentForm).on("invalid-form.validate", this.settings.invalidHandler) }, form: function () { return this.checkForm(), $.extend(this.submitted, this.errorMap), this.invalid = $.extend({}, this.errorMap), this.valid() || $(this.currentForm).triggerHandler("invalid-form", [this]), this.showErrors(), this.valid() }, checkForm: function () { this.prepareForm(); for (var a = 0, b = this.currentElements = this.elements(); b[a]; a++)this.check(b[a]); return this.valid() }, element: function (d) { var b, f, e = this.clean(d), a = this.validationTargetFor(e), g = this, c = !0; return void 0 === a ? delete this.invalid[e.name] : (this.prepareElement(a), this.currentElements = $(a), (f = this.groups[a.name]) && $.each(this.groups, function (b, d) { d === f && b !== a.name && (e = g.validationTargetFor(g.clean(g.findByName(b)))) && e.name in g.invalid && (g.currentElements.push(e), c = g.check(e) && c) }), b = !1 !== this.check(a), c = c && b, b ? this.invalid[a.name] = !1 : this.invalid[a.name] = !0, this.numberOfInvalids() || (this.toHide = this.toHide.add(this.containers)), this.showErrors(), $(d).attr("aria-invalid", !b)), c }, showErrors: function (a) { if (a) { var b = this; $.extend(this.errorMap, a), this.errorList = $.map(this.errorMap, function (a, c) { return { message: a, element: b.findByName(c)[0] } }), this.successList = $.grep(this.successList, function (b) { return !(b.name in a) }) } this.settings.showErrors ? this.settings.showErrors.call(this, this.errorMap, this.errorList) : this.defaultShowErrors() }, resetForm: function () { $.fn.resetForm && $(this.currentForm).resetForm(), this.invalid = {}, this.submitted = {}, this.prepareForm(), this.hideErrors(); var a = this.elements().removeData("previousValue").removeAttr("aria-invalid"); this.resetElements(a) }, resetElements: function (b) { var a; if (this.settings.unhighlight) for (a = 0; b[a]; a++)this.settings.unhighlight.call(this, b[a], this.settings.errorClass, ""), this.findByName(b[a].name).removeClass(this.settings.validClass); else b.removeClass(this.settings.errorClass).removeClass(this.settings.validClass) }, numberOfInvalids: function () { return this.objectLength(this.invalid) }, objectLength: function (a) { var b, c = 0; for (b in a) void 0 !== a[b] && null !== a[b] && !1 !== a[b] && c++; return c }, hideErrors: function () { this.hideThese(this.toHide) }, hideThese: function (a) { a.not(this.containers).text(""), this.addWrapper(a).hide() }, valid: function () { return 0 === this.size() }, size: function () { return this.errorList.length }, focusInvalid: function () { if (this.settings.focusInvalid) try { $(this.findLastActive() || this.errorList.length && this.errorList[0].element || []).filter(":visible").trigger("focus").trigger("focusin") } catch (a) { } }, findLastActive: function () { var a = this.lastActive; return a && 1 === $.grep(this.errorList, function (b) { return b.element.name === a.name }).length && a }, elements: function () { var a = this, b = {}; return $(this.currentForm).find("input, select, textarea, [contenteditable]").not(":submit, :reset, :image, :disabled").not(this.settings.ignore).filter(function () { var c = this.name || $(this).attr("name"), d = void 0 !== $(this).attr("contenteditable") && "false" !== $(this).attr("contenteditable"); return !c && a.settings.debug && window.console && console.error("%o has no name assigned", this), d && (this.form = $(this).closest("form")[0], this.name = c), this.form === a.currentForm && !(c in b) && !!a.objectLength($(this).rules()) && (b[c] = !0, !0) }) }, clean: function (a) { return $(a)[0] }, errors: function () { var a = this.settings.errorClass.split(" ").join("."); return $(this.settings.errorElement + "." + a, this.errorContext) }, resetInternals: function () { this.successList = [], this.errorList = [], this.errorMap = {}, this.toShow = $([]), this.toHide = $([]) }, reset: function () { this.resetInternals(), this.currentElements = $([]) }, prepareForm: function () { this.reset(), this.toHide = this.errors().add(this.containers) }, prepareElement: function (a) { this.reset(), this.toHide = this.errorsFor(a) }, elementValue: function (b) { var a, e, c = $(b), d = b.type, f = void 0 !== c.attr("contenteditable") && "false" !== c.attr("contenteditable"); return "radio" === d || "checkbox" === d ? this.findByName(b.name).filter(":checked").val() : "number" === d && void 0 !== b.validity ? b.validity.badInput ? "NaN" : c.val() : (a = f ? c.text() : c.val(), "file" === d) ? "C:\\fakepath\\" === a.substr(0, 12) ? a.substr(12) : (e = a.lastIndexOf("/")) >= 0 || (e = a.lastIndexOf("\\")) >= 0 ? a.substr(e + 1) : a : "string" == typeof a ? a.replace(/\r/g, "") : a }, check: function (a) { a = this.validationTargetFor(this.clean(a)); var d, e, c, f, b = $(a).rules(), j = $.map(b, function (b, a) { return a }).length, h = !1, i = this.elementValue(a); for (e in "function" == typeof b.normalizer ? f = b.normalizer : "function" == typeof this.settings.normalizer && (f = this.settings.normalizer), f && (i = f.call(a, i), delete b.normalizer), b) { c = { method: e, parameters: b[e] }; try { if (d = $.validator.methods[e].call(this, i, a, c.parameters), "dependency-mismatch" === d && 1 === j) { h = !0; continue } if (h = !1, "pending" === d) { this.toHide = this.toHide.not(this.errorsFor(a)); return } if (!d) return this.formatAndAdd(a, c), !1 } catch (g) { throw this.settings.debug && window.console && console.log("Exception occurred when checking element " + a.id + ", check the '" + c.method + "' method.", g), g instanceof TypeError && (g.message += ".  Exception occurred when checking element " + a.id + ", check the '" + c.method + "' method."), g } } if (!h) return this.objectLength(b) && this.successList.push(a), !0 }, customDataMessage: function (a, b) { return $(a).data("msg" + b.charAt(0).toUpperCase() + b.substring(1).toLowerCase()) || $(a).data("msg") }, customMessage: function (b, c) { var a = this.settings.messages[b]; return a && (a.constructor === String ? a : a[c]) }, findDefined: function () { for (var a = 0; a < arguments.length; a++)if (void 0 !== arguments[a]) return arguments[a] }, defaultMessage: function (c, a) { "string" == typeof a && (a = { method: a }); var b = this.findDefined(this.customMessage(c.name, a.method), this.customDataMessage(c, a.method), !this.settings.ignoreTitle && c.title || void 0, $.validator.messages[a.method], "<strong>Warning: No message defined for " + c.name + "</strong>"), d = /\$?\{(\d+)\}/g; return "function" == typeof b ? b = b.call(this, a.parameters, c) : d.test(b) && (b = $.validator.format(b.replace(d, "{$1}"), a.parameters)), b }, formatAndAdd: function (a, c) { var b = this.defaultMessage(a, c); this.errorList.push({ message: b, element: a, method: c.method }), this.errorMap[a.name] = b, this.submitted[a.name] = b }, addWrapper: function (a) { return this.settings.wrapper && (a = a.add(a.parent(this.settings.wrapper))), a }, defaultShowErrors: function () { var a, c, b; for (a = 0; this.errorList[a]; a++)b = this.errorList[a], this.settings.highlight && this.settings.highlight.call(this, b.element, this.settings.errorClass, this.settings.validClass), this.showLabel(b.element, b.message); if (this.errorList.length && (this.toShow = this.toShow.add(this.containers)), this.settings.success) for (a = 0; this.successList[a]; a++)this.showLabel(this.successList[a]); if (this.settings.unhighlight) for (a = 0, c = this.validElements(); c[a]; a++)this.settings.unhighlight.call(this, c[a], this.settings.errorClass, this.settings.validClass); this.toHide = this.toHide.not(this.toShow), this.hideErrors(), this.addWrapper(this.toShow).show() }, validElements: function () { return this.currentElements.not(this.invalidElements()) }, invalidElements: function () { return $(this.errorList).map(function () { return this.element }) }, showLabel: function (b, f) { var c, i, e, h, a = this.errorsFor(b), g = this.idOrName(b), d = $(b).attr("aria-describedby"); a.length ? (a.removeClass(this.settings.validClass).addClass(this.settings.errorClass), a.html(f)) : (c = a = $("<" + this.settings.errorElement + ">").attr("id", g + "-error").addClass(this.settings.errorClass).html(f || ""), this.settings.wrapper && (c = a.hide().show().wrap("<" + this.settings.wrapper + "/>").parent()), this.labelContainer.length ? this.labelContainer.append(c) : this.settings.errorPlacement ? this.settings.errorPlacement.call(this, c, $(b)) : c.insertAfter(b), a.is("label") ? a.attr("for", g) : 0 === a.parents("label[for='" + this.escapeCssMeta(g) + "']").length && (e = a.attr("id"), d ? d.match(new RegExp("\\b" + this.escapeCssMeta(e) + "\\b")) || (d += " " + e) : d = e, $(b).attr("aria-describedby", d), (i = this.groups[b.name]) && (h = this, $.each(h.groups, function (b, c) { c === i && $("[name='" + h.escapeCssMeta(b) + "']", h.currentForm).attr("aria-describedby", a.attr("id")) })))), !f && this.settings.success && (a.text(""), "string" == typeof this.settings.success ? a.addClass(this.settings.success) : this.settings.success(a, b)), this.toShow = this.toShow.add(a) }, errorsFor: function (b) { var c = this.escapeCssMeta(this.idOrName(b)), d = $(b).attr("aria-describedby"), a = "label[for='" + c + "'], label[for='" + c + "'] *"; return d && (a = a + ", #" + this.escapeCssMeta(d).replace(/\s+/g, ", #")), this.errors().filter(a) }, escapeCssMeta: function (a) { return void 0 === a ? "" : a.replace(/([\\!"#$%&'()*+,./:;<=>?@\[\]^`{|}~])/g, "\\$1") }, idOrName: function (a) { return this.groups[a.name] || (this.checkable(a) ? a.name : a.id || a.name) }, validationTargetFor: function (a) { return this.checkable(a) && (a = this.findByName(a.name)), $(a).not(this.settings.ignore)[0] }, checkable: function (a) { return /radio|checkbox/i.test(a.type) }, findByName: function (a) { return $(this.currentForm).find("[name='" + this.escapeCssMeta(a) + "']") }, getLength: function (b, a) { switch (a.nodeName.toLowerCase()) { case "select": return $("option:selected", a).length; case "input": if (this.checkable(a)) return this.findByName(a.name).filter(":checked").length }return b.length }, depend: function (a, b) { return !this.dependTypes[typeof a] || this.dependTypes[typeof a](a, b) }, dependTypes: { boolean: function (a) { return a }, string: function (a, b) { return !!$(a, b.form).length }, function: function (a, b) { return a(b) } }, optional: function (a) { var b = this.elementValue(a); return !$.validator.methods.required.call(this, b, a) && "dependency-mismatch" }, startRequest: function (a) { this.pending[a.name] || (this.pendingRequest++, $(a).addClass(this.settings.pendingClass), this.pending[a.name] = !0) }, stopRequest: function (a, b) { this.pendingRequest--, this.pendingRequest < 0 && (this.pendingRequest = 0), delete this.pending[a.name], $(a).removeClass(this.settings.pendingClass), b && 0 === this.pendingRequest && this.formSubmitted && this.form() && 0 === this.pendingRequest ? ($(this.currentForm).trigger("submit"), this.submitButton && $("input:hidden[name='" + this.submitButton.name + "']", this.currentForm).remove(), this.formSubmitted = !1) : !b && 0 === this.pendingRequest && this.formSubmitted && ($(this.currentForm).triggerHandler("invalid-form", [this]), this.formSubmitted = !1) }, previousValue: function (b, a) { return a = "string" == typeof a && a || "remote", $.data(b, "previousValue") || $.data(b, "previousValue", { old: null, valid: !0, message: this.defaultMessage(b, { method: a }) }) }, destroy: function () { this.resetForm(), $(this.currentForm).off(".validate").removeData("validator").find(".validate-equalTo-blur").off(".validate-equalTo").removeClass("validate-equalTo-blur").find(".validate-lessThan-blur").off(".validate-lessThan").removeClass("validate-lessThan-blur").find(".validate-lessThanEqual-blur").off(".validate-lessThanEqual").removeClass("validate-lessThanEqual-blur").find(".validate-greaterThanEqual-blur").off(".validate-greaterThanEqual").removeClass("validate-greaterThanEqual-blur").find(".validate-greaterThan-blur").off(".validate-greaterThan").removeClass("validate-greaterThan-blur") } }, classRuleSettings: { required: { required: !0 }, email: { email: !0 }, url: { url: !0 }, date: { date: !0 }, dateISO: { dateISO: !0 }, number: { number: !0 }, digits: { digits: !0 }, creditcard: { creditcard: !0 } }, addClassRules: function (a, b) { a.constructor === String ? this.classRuleSettings[a] = b : $.extend(this.classRuleSettings, a) }, classRules: function (b) { var c = {}, a = $(b).attr("class"); return a && $.each(a.split(" "), function () { this in $.validator.classRuleSettings && $.extend(c, $.validator.classRuleSettings[this]) }), c }, normalizeAttributeRule: function (d, b, c, a) { /min|max|step/.test(c) && (null === b || /number|range|text/.test(b)) && isNaN(a = Number(a)) && (a = void 0), a || 0 === a ? d[c] = a : b === c && "range" !== b && (d["date" === b ? "dateISO" : c] = !0) }, attributeRules: function (d) { var b, a, c = {}, e = $(d), f = d.getAttribute("type"); for (b in $.validator.methods) "required" === b ? ("" === (a = d.getAttribute(b)) && (a = !0), a = !!a) : a = e.attr(b), this.normalizeAttributeRule(c, f, b, a); return c.maxlength && /-1|2147483647|524288/.test(c.maxlength) && delete c.maxlength, c }, dataRules: function (c) { var a, b, d = {}, e = $(c), f = c.getAttribute("type"); for (a in $.validator.methods) "" === (b = e.data("rule" + a.charAt(0).toUpperCase() + a.substring(1).toLowerCase())) && (b = !0), this.normalizeAttributeRule(d, f, a, b); return d }, staticRules: function (a) { var b = {}, c = $.data(a.form, "validator"); return c.settings.rules && (b = $.validator.normalizeRule(c.settings.rules[a.name]) || {}), b }, normalizeRules: function (a, b) { return $.each(a, function (d, c) { if (!1 === c) { delete a[d]; return } if (c.param || c.depends) { var e = !0; switch (typeof c.depends) { case "string": e = !!$(c.depends, b.form).length; break; case "function": e = c.depends.call(b, b) }e ? a[d] = void 0 === c.param || c.param : ($.data(b.form, "validator").resetElements($(b)), delete a[d]) } }), $.each(a, function (d, c) { a[d] = "function" == typeof c && "normalizer" !== d ? c(b) : c }), $.each(["minlength", "maxlength"], function () { a[this] && (a[this] = Number(a[this])) }), $.each(["rangelength", "range"], function () { var b; a[this] && (Array.isArray(a[this]) ? a[this] = [Number(a[this][0]), Number(a[this][1])] : "string" == typeof a[this] && (b = a[this].replace(/[\[\]]/g, "").split(/[\s,]+/), a[this] = [Number(b[0]), Number(b[1])])) }), $.validator.autoCreateRanges && (null != a.min && null != a.max && (a.range = [a.min, a.max], delete a.min, delete a.max), null != a.minlength && null != a.maxlength && (a.rangelength = [a.minlength, a.maxlength], delete a.minlength, delete a.maxlength)), a }, normalizeRule: function (a) { if ("string" == typeof a) { var b = {}; $.each(a.split(/\s/), function () { b[this] = !0 }), a = b } return a }, addMethod: function (a, b, c) { $.validator.methods[a] = b, $.validator.messages[a] = void 0 !== c ? c : $.validator.messages[a], b.length < 3 && $.validator.addClassRules(a, $.validator.normalizeRule(a)) }, methods: { required: function (b, a, d) { if (!this.depend(d, a)) return "dependency-mismatch"; if ("select" === a.nodeName.toLowerCase()) { var c = $(a).val(); return c && c.length > 0 } return this.checkable(a) ? this.getLength(b, a) > 0 : null != b && b.length > 0 }, email: function (a, b) { return this.optional(b) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(a) }, url: function (a, b) { return this.optional(b) || /^(?:(?:(?:https?|ftp):)?\/\/)(?:(?:[^\]\[?\/<~#`!@$^&*()+=}|:";',>{ ]|%[0-9A-Fa-f]{2})+(?::(?:[^\]\[?\/<~#`!@$^&*()+=}|:";',>{ ]|%[0-9A-Fa-f]{2})*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z0-9\u00a1-\uffff][a-z0-9\u00a1-\uffff_-]{0,62})?[a-z0-9\u00a1-\uffff]\.)+(?:[a-z\u00a1-\uffff]{2,}\.?))(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(a) }, date: (a = !1, function (b, c) { return !a && (a = !0, this.settings.debug && window.console && console.warn("The `date` method is deprecated and will be removed in version '2.0.0'.\nPlease don't use it, since it relies on the Date constructor, which\nbehaves very differently across browsers and locales. Use `dateISO`\ninstead or one of the locale specific methods in `localizations/`\nand `additional-methods.js`.")), this.optional(c) || !/Invalid|NaN/.test(new Date(b).toString()) }), dateISO: function (a, b) { return this.optional(b) || /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(a) }, number: function (a, b) { return this.optional(b) || /^(?:-?\d+|-?\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(a) }, digits: function (a, b) { return this.optional(b) || /^\d+$/.test(a) }, minlength: function (a, b, c) { var d = Array.isArray(a) ? a.length : this.getLength(a, b); return this.optional(b) || d >= c }, maxlength: function (a, b, c) { var d = Array.isArray(a) ? a.length : this.getLength(a, b); return this.optional(b) || d <= c }, rangelength: function (a, b, c) { var d = Array.isArray(a) ? a.length : this.getLength(a, b); return this.optional(b) || d >= c[0] && d <= c[1] }, min: function (a, b, c) { return this.optional(b) || a >= c }, max: function (a, b, c) { return this.optional(b) || a <= c }, range: function (a, c, b) { return this.optional(c) || a >= b[0] && a <= b[1] }, step: function (b, c, d) { var e, a = $(c).attr("type"), i = new RegExp("\\b" + a + "\\b"), j = a && !i.test("text,number,range"), f = function (b) { var a = ("" + b).match(/(?:\.(\d+))?$/); return a && a[1] ? a[1].length : 0 }, g = function (a) { return Math.round(a * Math.pow(10, e)) }, h = !0; if (j) throw new Error("Step attribute on input type " + a + " is not supported."); return e = f(d), (f(b) > e || g(b) % g(d) != 0) && (h = !1), this.optional(c) || h }, equalTo: function (b, d, c) { var a = $(c); return this.settings.onfocusout && a.not(".validate-equalTo-blur").length && a.addClass("validate-equalTo-blur").on("blur.validate-equalTo", function () { $(d).valid() }), b === a.val() }, remote: function (f, a, b, c) { if (this.optional(a)) return "dependency-mismatch"; c = "string" == typeof c && c || "remote"; var g, h, e, d = this.previousValue(a, c); return (this.settings.messages[a.name] || (this.settings.messages[a.name] = {}), d.originalMessage = d.originalMessage || this.settings.messages[a.name][c], this.settings.messages[a.name][c] = d.message, b = "string" == typeof b && { url: b } || b, e = $.param($.extend({ data: f }, b.data)), d.old === e) ? d.valid : (d.old = e, g = this, this.startRequest(a), (h = {})[a.name] = f, $.ajax($.extend(!0, { mode: "abort", port: "validate" + a.name, dataType: "json", data: h, context: g.currentForm, success: function (b) { var e, i, j, h = !0 === b || "true" === b; g.settings.messages[a.name][c] = d.originalMessage, h ? (j = g.formSubmitted, g.resetInternals(), g.toHide = g.errorsFor(a), g.formSubmitted = j, g.successList.push(a), g.invalid[a.name] = !1, g.showErrors()) : (e = {}, i = b || g.defaultMessage(a, { method: c, parameters: f }), e[a.name] = d.message = i, g.invalid[a.name] = !0, g.showErrors(e)), d.valid = h, g.stopRequest(a, h) } }, b)), "pending") } } }); var b, d = {}; return $.ajaxPrefilter ? $.ajaxPrefilter(function (b, _, c) { var a = b.port; "abort" === b.mode && (d[a] && d[a].abort(), d[a] = c) }) : (b = $.ajax, $.ajax = function (a) { var e = ("mode" in a ? a : $.ajaxSettings).mode, c = ("port" in a ? a : $.ajaxSettings).port; return "abort" === e ? (d[c] && d[c].abort(), d[c] = b.apply(this, arguments), d[c]) : b.apply(this, arguments) }), $ })

/*!
  * Bootstrap v5.3.2 (https://getbootstrap.com/)
  * Copyright 2011-2023 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */
!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):(t="undefined"!=typeof globalThis?globalThis:t||self).bootstrap=e()}(this,(function(){"use strict";const t=new Map,e={set(e,i,n){t.has(e)||t.set(e,new Map);const s=t.get(e);s.has(i)||0===s.size?s.set(i,n):console.error(`Bootstrap doesn't allow more than one instance per element. Bound instance: ${Array.from(s.keys())[0]}.`)},get:(e,i)=>t.has(e)&&t.get(e).get(i)||null,remove(e,i){if(!t.has(e))return;const n=t.get(e);n.delete(i),0===n.size&&t.delete(e)}},i="transitionend",n=t=>(t&&window.CSS&&window.CSS.escape&&(t=t.replace(/#([^\s"#']+)/g,((t,e)=>`#${CSS.escape(e)}`))),t),s=t=>{t.dispatchEvent(new Event(i))},o=t=>!(!t||"object"!=typeof t)&&(void 0!==t.jquery&&(t=t[0]),void 0!==t.nodeType),r=t=>o(t)?t.jquery?t[0]:t:"string"==typeof t&&t.length>0?document.querySelector(n(t)):null,a=t=>{if(!o(t)||0===t.getClientRects().length)return!1;const e="visible"===getComputedStyle(t).getPropertyValue("visibility"),i=t.closest("details:not([open])");if(!i)return e;if(i!==t){const e=t.closest("summary");if(e&&e.parentNode!==i)return!1;if(null===e)return!1}return e},l=t=>!t||t.nodeType!==Node.ELEMENT_NODE||!!t.classList.contains("disabled")||(void 0!==t.disabled?t.disabled:t.hasAttribute("disabled")&&"false"!==t.getAttribute("disabled")),c=t=>{if(!document.documentElement.attachShadow)return null;if("function"==typeof t.getRootNode){const e=t.getRootNode();return e instanceof ShadowRoot?e:null}return t instanceof ShadowRoot?t:t.parentNode?c(t.parentNode):null},h=()=>{},d=t=>{t.offsetHeight},u=()=>window.jQuery&&!document.body.hasAttribute("data-bs-no-jquery")?window.jQuery:null,f=[],p=()=>"rtl"===document.documentElement.dir,m=t=>{var e;e=()=>{const e=u();if(e){const i=t.NAME,n=e.fn[i];e.fn[i]=t.jQueryInterface,e.fn[i].Constructor=t,e.fn[i].noConflict=()=>(e.fn[i]=n,t.jQueryInterface)}},"loading"===document.readyState?(f.length||document.addEventListener("DOMContentLoaded",(()=>{for(const t of f)t()})),f.push(e)):e()},g=(t,e=[],i=t)=>"function"==typeof t?t(...e):i,_=(t,e,n=!0)=>{if(!n)return void g(t);const o=(t=>{if(!t)return 0;let{transitionDuration:e,transitionDelay:i}=window.getComputedStyle(t);const n=Number.parseFloat(e),s=Number.parseFloat(i);return n||s?(e=e.split(",")[0],i=i.split(",")[0],1e3*(Number.parseFloat(e)+Number.parseFloat(i))):0})(e)+5;let r=!1;const a=({target:n})=>{n===e&&(r=!0,e.removeEventListener(i,a),g(t))};e.addEventListener(i,a),setTimeout((()=>{r||s(e)}),o)},b=(t,e,i,n)=>{const s=t.length;let o=t.indexOf(e);return-1===o?!i&&n?t[s-1]:t[0]:(o+=i?1:-1,n&&(o=(o+s)%s),t[Math.max(0,Math.min(o,s-1))])},v=/[^.]*(?=\..*)\.|.*/,y=/\..*/,w=/::\d+$/,A={};let E=1;const T={mouseenter:"mouseover",mouseleave:"mouseout"},C=new Set(["click","dblclick","mouseup","mousedown","contextmenu","mousewheel","DOMMouseScroll","mouseover","mouseout","mousemove","selectstart","selectend","keydown","keypress","keyup","orientationchange","touchstart","touchmove","touchend","touchcancel","pointerdown","pointermove","pointerup","pointerleave","pointercancel","gesturestart","gesturechange","gestureend","focus","blur","change","reset","select","submit","focusin","focusout","load","unload","beforeunload","resize","move","DOMContentLoaded","readystatechange","error","abort","scroll"]);function O(t,e){return e&&`${e}::${E++}`||t.uidEvent||E++}function x(t){const e=O(t);return t.uidEvent=e,A[e]=A[e]||{},A[e]}function k(t,e,i=null){return Object.values(t).find((t=>t.callable===e&&t.delegationSelector===i))}function L(t,e,i){const n="string"==typeof e,s=n?i:e||i;let o=I(t);return C.has(o)||(o=t),[n,s,o]}function S(t,e,i,n,s){if("string"!=typeof e||!t)return;let[o,r,a]=L(e,i,n);if(e in T){const t=t=>function(e){if(!e.relatedTarget||e.relatedTarget!==e.delegateTarget&&!e.delegateTarget.contains(e.relatedTarget))return t.call(this,e)};r=t(r)}const l=x(t),c=l[a]||(l[a]={}),h=k(c,r,o?i:null);if(h)return void(h.oneOff=h.oneOff&&s);const d=O(r,e.replace(v,"")),u=o?function(t,e,i){return function n(s){const o=t.querySelectorAll(e);for(let{target:r}=s;r&&r!==this;r=r.parentNode)for(const a of o)if(a===r)return P(s,{delegateTarget:r}),n.oneOff&&N.off(t,s.type,e,i),i.apply(r,[s])}}(t,i,r):function(t,e){return function i(n){return P(n,{delegateTarget:t}),i.oneOff&&N.off(t,n.type,e),e.apply(t,[n])}}(t,r);u.delegationSelector=o?i:null,u.callable=r,u.oneOff=s,u.uidEvent=d,c[d]=u,t.addEventListener(a,u,o)}function D(t,e,i,n,s){const o=k(e[i],n,s);o&&(t.removeEventListener(i,o,Boolean(s)),delete e[i][o.uidEvent])}function $(t,e,i,n){const s=e[i]||{};for(const[o,r]of Object.entries(s))o.includes(n)&&D(t,e,i,r.callable,r.delegationSelector)}function I(t){return t=t.replace(y,""),T[t]||t}const N={on(t,e,i,n){S(t,e,i,n,!1)},one(t,e,i,n){S(t,e,i,n,!0)},off(t,e,i,n){if("string"!=typeof e||!t)return;const[s,o,r]=L(e,i,n),a=r!==e,l=x(t),c=l[r]||{},h=e.startsWith(".");if(void 0===o){if(h)for(const i of Object.keys(l))$(t,l,i,e.slice(1));for(const[i,n]of Object.entries(c)){const s=i.replace(w,"");a&&!e.includes(s)||D(t,l,r,n.callable,n.delegationSelector)}}else{if(!Object.keys(c).length)return;D(t,l,r,o,s?i:null)}},trigger(t,e,i){if("string"!=typeof e||!t)return null;const n=u();let s=null,o=!0,r=!0,a=!1;e!==I(e)&&n&&(s=n.Event(e,i),n(t).trigger(s),o=!s.isPropagationStopped(),r=!s.isImmediatePropagationStopped(),a=s.isDefaultPrevented());const l=P(new Event(e,{bubbles:o,cancelable:!0}),i);return a&&l.preventDefault(),r&&t.dispatchEvent(l),l.defaultPrevented&&s&&s.preventDefault(),l}};function P(t,e={}){for(const[i,n]of Object.entries(e))try{t[i]=n}catch(e){Object.defineProperty(t,i,{configurable:!0,get:()=>n})}return t}function M(t){if("true"===t)return!0;if("false"===t)return!1;if(t===Number(t).toString())return Number(t);if(""===t||"null"===t)return null;if("string"!=typeof t)return t;try{return JSON.parse(decodeURIComponent(t))}catch(e){return t}}function j(t){return t.replace(/[A-Z]/g,(t=>`-${t.toLowerCase()}`))}const F={setDataAttribute(t,e,i){t.setAttribute(`data-bs-${j(e)}`,i)},removeDataAttribute(t,e){t.removeAttribute(`data-bs-${j(e)}`)},getDataAttributes(t){if(!t)return{};const e={},i=Object.keys(t.dataset).filter((t=>t.startsWith("bs")&&!t.startsWith("bsConfig")));for(const n of i){let i=n.replace(/^bs/,"");i=i.charAt(0).toLowerCase()+i.slice(1,i.length),e[i]=M(t.dataset[n])}return e},getDataAttribute:(t,e)=>M(t.getAttribute(`data-bs-${j(e)}`))};class H{static get Default(){return{}}static get DefaultType(){return{}}static get NAME(){throw new Error('You have to implement the static method "NAME", for each component!')}_getConfig(t){return t=this._mergeConfigObj(t),t=this._configAfterMerge(t),this._typeCheckConfig(t),t}_configAfterMerge(t){return t}_mergeConfigObj(t,e){const i=o(e)?F.getDataAttribute(e,"config"):{};return{...this.constructor.Default,..."object"==typeof i?i:{},...o(e)?F.getDataAttributes(e):{},..."object"==typeof t?t:{}}}_typeCheckConfig(t,e=this.constructor.DefaultType){for(const[n,s]of Object.entries(e)){const e=t[n],r=o(e)?"element":null==(i=e)?`${i}`:Object.prototype.toString.call(i).match(/\s([a-z]+)/i)[1].toLowerCase();if(!new RegExp(s).test(r))throw new TypeError(`${this.constructor.NAME.toUpperCase()}: Option "${n}" provided type "${r}" but expected type "${s}".`)}var i}}class W extends H{constructor(t,i){super(),(t=r(t))&&(this._element=t,this._config=this._getConfig(i),e.set(this._element,this.constructor.DATA_KEY,this))}dispose(){e.remove(this._element,this.constructor.DATA_KEY),N.off(this._element,this.constructor.EVENT_KEY);for(const t of Object.getOwnPropertyNames(this))this[t]=null}_queueCallback(t,e,i=!0){_(t,e,i)}_getConfig(t){return t=this._mergeConfigObj(t,this._element),t=this._configAfterMerge(t),this._typeCheckConfig(t),t}static getInstance(t){return e.get(r(t),this.DATA_KEY)}static getOrCreateInstance(t,e={}){return this.getInstance(t)||new this(t,"object"==typeof e?e:null)}static get VERSION(){return"5.3.2"}static get DATA_KEY(){return`bs.${this.NAME}`}static get EVENT_KEY(){return`.${this.DATA_KEY}`}static eventName(t){return`${t}${this.EVENT_KEY}`}}const B=t=>{let e=t.getAttribute("data-bs-target");if(!e||"#"===e){let i=t.getAttribute("href");if(!i||!i.includes("#")&&!i.startsWith("."))return null;i.includes("#")&&!i.startsWith("#")&&(i=`#${i.split("#")[1]}`),e=i&&"#"!==i?n(i.trim()):null}return e},z={find:(t,e=document.documentElement)=>[].concat(...Element.prototype.querySelectorAll.call(e,t)),findOne:(t,e=document.documentElement)=>Element.prototype.querySelector.call(e,t),children:(t,e)=>[].concat(...t.children).filter((t=>t.matches(e))),parents(t,e){const i=[];let n=t.parentNode.closest(e);for(;n;)i.push(n),n=n.parentNode.closest(e);return i},prev(t,e){let i=t.previousElementSibling;for(;i;){if(i.matches(e))return[i];i=i.previousElementSibling}return[]},next(t,e){let i=t.nextElementSibling;for(;i;){if(i.matches(e))return[i];i=i.nextElementSibling}return[]},focusableChildren(t){const e=["a","button","input","textarea","select","details","[tabindex]",'[contenteditable="true"]'].map((t=>`${t}:not([tabindex^="-"])`)).join(",");return this.find(e,t).filter((t=>!l(t)&&a(t)))},getSelectorFromElement(t){const e=B(t);return e&&z.findOne(e)?e:null},getElementFromSelector(t){const e=B(t);return e?z.findOne(e):null},getMultipleElementsFromSelector(t){const e=B(t);return e?z.find(e):[]}},R=(t,e="hide")=>{const i=`click.dismiss${t.EVENT_KEY}`,n=t.NAME;N.on(document,i,`[data-bs-dismiss="${n}"]`,(function(i){if(["A","AREA"].includes(this.tagName)&&i.preventDefault(),l(this))return;const s=z.getElementFromSelector(this)||this.closest(`.${n}`);t.getOrCreateInstance(s)[e]()}))},q=".bs.alert",V=`close${q}`,K=`closed${q}`;class Q extends W{static get NAME(){return"alert"}close(){if(N.trigger(this._element,V).defaultPrevented)return;this._element.classList.remove("show");const t=this._element.classList.contains("fade");this._queueCallback((()=>this._destroyElement()),this._element,t)}_destroyElement(){this._element.remove(),N.trigger(this._element,K),this.dispose()}static jQueryInterface(t){return this.each((function(){const e=Q.getOrCreateInstance(this);if("string"==typeof t){if(void 0===e[t]||t.startsWith("_")||"constructor"===t)throw new TypeError(`No method named "${t}"`);e[t](this)}}))}}R(Q,"close"),m(Q);const X='[data-bs-toggle="button"]';class Y extends W{static get NAME(){return"button"}toggle(){this._element.setAttribute("aria-pressed",this._element.classList.toggle("active"))}static jQueryInterface(t){return this.each((function(){const e=Y.getOrCreateInstance(this);"toggle"===t&&e[t]()}))}}N.on(document,"click.bs.button.data-api",X,(t=>{t.preventDefault();const e=t.target.closest(X);Y.getOrCreateInstance(e).toggle()})),m(Y);const U=".bs.swipe",G=`touchstart${U}`,J=`touchmove${U}`,Z=`touchend${U}`,tt=`pointerdown${U}`,et=`pointerup${U}`,it={endCallback:null,leftCallback:null,rightCallback:null},nt={endCallback:"(function|null)",leftCallback:"(function|null)",rightCallback:"(function|null)"};class st extends H{constructor(t,e){super(),this._element=t,t&&st.isSupported()&&(this._config=this._getConfig(e),this._deltaX=0,this._supportPointerEvents=Boolean(window.PointerEvent),this._initEvents())}static get Default(){return it}static get DefaultType(){return nt}static get NAME(){return"swipe"}dispose(){N.off(this._element,U)}_start(t){this._supportPointerEvents?this._eventIsPointerPenTouch(t)&&(this._deltaX=t.clientX):this._deltaX=t.touches[0].clientX}_end(t){this._eventIsPointerPenTouch(t)&&(this._deltaX=t.clientX-this._deltaX),this._handleSwipe(),g(this._config.endCallback)}_move(t){this._deltaX=t.touches&&t.touches.length>1?0:t.touches[0].clientX-this._deltaX}_handleSwipe(){const t=Math.abs(this._deltaX);if(t<=40)return;const e=t/this._deltaX;this._deltaX=0,e&&g(e>0?this._config.rightCallback:this._config.leftCallback)}_initEvents(){this._supportPointerEvents?(N.on(this._element,tt,(t=>this._start(t))),N.on(this._element,et,(t=>this._end(t))),this._element.classList.add("pointer-event")):(N.on(this._element,G,(t=>this._start(t))),N.on(this._element,J,(t=>this._move(t))),N.on(this._element,Z,(t=>this._end(t))))}_eventIsPointerPenTouch(t){return this._supportPointerEvents&&("pen"===t.pointerType||"touch"===t.pointerType)}static isSupported(){return"ontouchstart"in document.documentElement||navigator.maxTouchPoints>0}}const ot=".bs.carousel",rt=".data-api",at="next",lt="prev",ct="left",ht="right",dt=`slide${ot}`,ut=`slid${ot}`,ft=`keydown${ot}`,pt=`mouseenter${ot}`,mt=`mouseleave${ot}`,gt=`dragstart${ot}`,_t=`load${ot}${rt}`,bt=`click${ot}${rt}`,vt="carousel",yt="active",wt=".active",At=".carousel-item",Et=wt+At,Tt={ArrowLeft:ht,ArrowRight:ct},Ct={interval:5e3,keyboard:!0,pause:"hover",ride:!1,touch:!0,wrap:!0},Ot={interval:"(number|boolean)",keyboard:"boolean",pause:"(string|boolean)",ride:"(boolean|string)",touch:"boolean",wrap:"boolean"};class xt extends W{constructor(t,e){super(t,e),this._interval=null,this._activeElement=null,this._isSliding=!1,this.touchTimeout=null,this._swipeHelper=null,this._indicatorsElement=z.findOne(".carousel-indicators",this._element),this._addEventListeners(),this._config.ride===vt&&this.cycle()}static get Default(){return Ct}static get DefaultType(){return Ot}static get NAME(){return"carousel"}next(){this._slide(at)}nextWhenVisible(){!document.hidden&&a(this._element)&&this.next()}prev(){this._slide(lt)}pause(){this._isSliding&&s(this._element),this._clearInterval()}cycle(){this._clearInterval(),this._updateInterval(),this._interval=setInterval((()=>this.nextWhenVisible()),this._config.interval)}_maybeEnableCycle(){this._config.ride&&(this._isSliding?N.one(this._element,ut,(()=>this.cycle())):this.cycle())}to(t){const e=this._getItems();if(t>e.length-1||t<0)return;if(this._isSliding)return void N.one(this._element,ut,(()=>this.to(t)));const i=this._getItemIndex(this._getActive());if(i===t)return;const n=t>i?at:lt;this._slide(n,e[t])}dispose(){this._swipeHelper&&this._swipeHelper.dispose(),super.dispose()}_configAfterMerge(t){return t.defaultInterval=t.interval,t}_addEventListeners(){this._config.keyboard&&N.on(this._element,ft,(t=>this._keydown(t))),"hover"===this._config.pause&&(N.on(this._element,pt,(()=>this.pause())),N.on(this._element,mt,(()=>this._maybeEnableCycle()))),this._config.touch&&st.isSupported()&&this._addTouchEventListeners()}_addTouchEventListeners(){for(const t of z.find(".carousel-item img",this._element))N.on(t,gt,(t=>t.preventDefault()));const t={leftCallback:()=>this._slide(this._directionToOrder(ct)),rightCallback:()=>this._slide(this._directionToOrder(ht)),endCallback:()=>{"hover"===this._config.pause&&(this.pause(),this.touchTimeout&&clearTimeout(this.touchTimeout),this.touchTimeout=setTimeout((()=>this._maybeEnableCycle()),500+this._config.interval))}};this._swipeHelper=new st(this._element,t)}_keydown(t){if(/input|textarea/i.test(t.target.tagName))return;const e=Tt[t.key];e&&(t.preventDefault(),this._slide(this._directionToOrder(e)))}_getItemIndex(t){return this._getItems().indexOf(t)}_setActiveIndicatorElement(t){if(!this._indicatorsElement)return;const e=z.findOne(wt,this._indicatorsElement);e.classList.remove(yt),e.removeAttribute("aria-current");const i=z.findOne(`[data-bs-slide-to="${t}"]`,this._indicatorsElement);i&&(i.classList.add(yt),i.setAttribute("aria-current","true"))}_updateInterval(){const t=this._activeElement||this._getActive();if(!t)return;const e=Number.parseInt(t.getAttribute("data-bs-interval"),10);this._config.interval=e||this._config.defaultInterval}_slide(t,e=null){if(this._isSliding)return;const i=this._getActive(),n=t===at,s=e||b(this._getItems(),i,n,this._config.wrap);if(s===i)return;const o=this._getItemIndex(s),r=e=>N.trigger(this._element,e,{relatedTarget:s,direction:this._orderToDirection(t),from:this._getItemIndex(i),to:o});if(r(dt).defaultPrevented)return;if(!i||!s)return;const a=Boolean(this._interval);this.pause(),this._isSliding=!0,this._setActiveIndicatorElement(o),this._activeElement=s;const l=n?"carousel-item-start":"carousel-item-end",c=n?"carousel-item-next":"carousel-item-prev";s.classList.add(c),d(s),i.classList.add(l),s.classList.add(l),this._queueCallback((()=>{s.classList.remove(l,c),s.classList.add(yt),i.classList.remove(yt,c,l),this._isSliding=!1,r(ut)}),i,this._isAnimated()),a&&this.cycle()}_isAnimated(){return this._element.classList.contains("slide")}_getActive(){return z.findOne(Et,this._element)}_getItems(){return z.find(At,this._element)}_clearInterval(){this._interval&&(clearInterval(this._interval),this._interval=null)}_directionToOrder(t){return p()?t===ct?lt:at:t===ct?at:lt}_orderToDirection(t){return p()?t===lt?ct:ht:t===lt?ht:ct}static jQueryInterface(t){return this.each((function(){const e=xt.getOrCreateInstance(this,t);if("number"!=typeof t){if("string"==typeof t){if(void 0===e[t]||t.startsWith("_")||"constructor"===t)throw new TypeError(`No method named "${t}"`);e[t]()}}else e.to(t)}))}}N.on(document,bt,"[data-bs-slide], [data-bs-slide-to]",(function(t){const e=z.getElementFromSelector(this);if(!e||!e.classList.contains(vt))return;t.preventDefault();const i=xt.getOrCreateInstance(e),n=this.getAttribute("data-bs-slide-to");return n?(i.to(n),void i._maybeEnableCycle()):"next"===F.getDataAttribute(this,"slide")?(i.next(),void i._maybeEnableCycle()):(i.prev(),void i._maybeEnableCycle())})),N.on(window,_t,(()=>{const t=z.find('[data-bs-ride="carousel"]');for(const e of t)xt.getOrCreateInstance(e)})),m(xt);const kt=".bs.collapse",Lt=`show${kt}`,St=`shown${kt}`,Dt=`hide${kt}`,$t=`hidden${kt}`,It=`click${kt}.data-api`,Nt="show",Pt="collapse",Mt="collapsing",jt=`:scope .${Pt} .${Pt}`,Ft='[data-bs-toggle="collapse"]',Ht={parent:null,toggle:!0},Wt={parent:"(null|element)",toggle:"boolean"};class Bt extends W{constructor(t,e){super(t,e),this._isTransitioning=!1,this._triggerArray=[];const i=z.find(Ft);for(const t of i){const e=z.getSelectorFromElement(t),i=z.find(e).filter((t=>t===this._element));null!==e&&i.length&&this._triggerArray.push(t)}this._initializeChildren(),this._config.parent||this._addAriaAndCollapsedClass(this._triggerArray,this._isShown()),this._config.toggle&&this.toggle()}static get Default(){return Ht}static get DefaultType(){return Wt}static get NAME(){return"collapse"}toggle(){this._isShown()?this.hide():this.show()}show(){if(this._isTransitioning||this._isShown())return;let t=[];if(this._config.parent&&(t=this._getFirstLevelChildren(".collapse.show, .collapse.collapsing").filter((t=>t!==this._element)).map((t=>Bt.getOrCreateInstance(t,{toggle:!1})))),t.length&&t[0]._isTransitioning)return;if(N.trigger(this._element,Lt).defaultPrevented)return;for(const e of t)e.hide();const e=this._getDimension();this._element.classList.remove(Pt),this._element.classList.add(Mt),this._element.style[e]=0,this._addAriaAndCollapsedClass(this._triggerArray,!0),this._isTransitioning=!0;const i=`scroll${e[0].toUpperCase()+e.slice(1)}`;this._queueCallback((()=>{this._isTransitioning=!1,this._element.classList.remove(Mt),this._element.classList.add(Pt,Nt),this._element.style[e]="",N.trigger(this._element,St)}),this._element,!0),this._element.style[e]=`${this._element[i]}px`}hide(){if(this._isTransitioning||!this._isShown())return;if(N.trigger(this._element,Dt).defaultPrevented)return;const t=this._getDimension();this._element.style[t]=`${this._element.getBoundingClientRect()[t]}px`,d(this._element),this._element.classList.add(Mt),this._element.classList.remove(Pt,Nt);for(const t of this._triggerArray){const e=z.getElementFromSelector(t);e&&!this._isShown(e)&&this._addAriaAndCollapsedClass([t],!1)}this._isTransitioning=!0,this._element.style[t]="",this._queueCallback((()=>{this._isTransitioning=!1,this._element.classList.remove(Mt),this._element.classList.add(Pt),N.trigger(this._element,$t)}),this._element,!0)}_isShown(t=this._element){return t.classList.contains(Nt)}_configAfterMerge(t){return t.toggle=Boolean(t.toggle),t.parent=r(t.parent),t}_getDimension(){return this._element.classList.contains("collapse-horizontal")?"width":"height"}_initializeChildren(){if(!this._config.parent)return;const t=this._getFirstLevelChildren(Ft);for(const e of t){const t=z.getElementFromSelector(e);t&&this._addAriaAndCollapsedClass([e],this._isShown(t))}}_getFirstLevelChildren(t){const e=z.find(jt,this._config.parent);return z.find(t,this._config.parent).filter((t=>!e.includes(t)))}_addAriaAndCollapsedClass(t,e){if(t.length)for(const i of t)i.classList.toggle("collapsed",!e),i.setAttribute("aria-expanded",e)}static jQueryInterface(t){const e={};return"string"==typeof t&&/show|hide/.test(t)&&(e.toggle=!1),this.each((function(){const i=Bt.getOrCreateInstance(this,e);if("string"==typeof t){if(void 0===i[t])throw new TypeError(`No method named "${t}"`);i[t]()}}))}}N.on(document,It,Ft,(function(t){("A"===t.target.tagName||t.delegateTarget&&"A"===t.delegateTarget.tagName)&&t.preventDefault();for(const t of z.getMultipleElementsFromSelector(this))Bt.getOrCreateInstance(t,{toggle:!1}).toggle()})),m(Bt);var zt="top",Rt="bottom",qt="right",Vt="left",Kt="auto",Qt=[zt,Rt,qt,Vt],Xt="start",Yt="end",Ut="clippingParents",Gt="viewport",Jt="popper",Zt="reference",te=Qt.reduce((function(t,e){return t.concat([e+"-"+Xt,e+"-"+Yt])}),[]),ee=[].concat(Qt,[Kt]).reduce((function(t,e){return t.concat([e,e+"-"+Xt,e+"-"+Yt])}),[]),ie="beforeRead",ne="read",se="afterRead",oe="beforeMain",re="main",ae="afterMain",le="beforeWrite",ce="write",he="afterWrite",de=[ie,ne,se,oe,re,ae,le,ce,he];function ue(t){return t?(t.nodeName||"").toLowerCase():null}function fe(t){if(null==t)return window;if("[object Window]"!==t.toString()){var e=t.ownerDocument;return e&&e.defaultView||window}return t}function pe(t){return t instanceof fe(t).Element||t instanceof Element}function me(t){return t instanceof fe(t).HTMLElement||t instanceof HTMLElement}function ge(t){return"undefined"!=typeof ShadowRoot&&(t instanceof fe(t).ShadowRoot||t instanceof ShadowRoot)}const _e={name:"applyStyles",enabled:!0,phase:"write",fn:function(t){var e=t.state;Object.keys(e.elements).forEach((function(t){var i=e.styles[t]||{},n=e.attributes[t]||{},s=e.elements[t];me(s)&&ue(s)&&(Object.assign(s.style,i),Object.keys(n).forEach((function(t){var e=n[t];!1===e?s.removeAttribute(t):s.setAttribute(t,!0===e?"":e)})))}))},effect:function(t){var e=t.state,i={popper:{position:e.options.strategy,left:"0",top:"0",margin:"0"},arrow:{position:"absolute"},reference:{}};return Object.assign(e.elements.popper.style,i.popper),e.styles=i,e.elements.arrow&&Object.assign(e.elements.arrow.style,i.arrow),function(){Object.keys(e.elements).forEach((function(t){var n=e.elements[t],s=e.attributes[t]||{},o=Object.keys(e.styles.hasOwnProperty(t)?e.styles[t]:i[t]).reduce((function(t,e){return t[e]="",t}),{});me(n)&&ue(n)&&(Object.assign(n.style,o),Object.keys(s).forEach((function(t){n.removeAttribute(t)})))}))}},requires:["computeStyles"]};function be(t){return t.split("-")[0]}var ve=Math.max,ye=Math.min,we=Math.round;function Ae(){var t=navigator.userAgentData;return null!=t&&t.brands&&Array.isArray(t.brands)?t.brands.map((function(t){return t.brand+"/"+t.version})).join(" "):navigator.userAgent}function Ee(){return!/^((?!chrome|android).)*safari/i.test(Ae())}function Te(t,e,i){void 0===e&&(e=!1),void 0===i&&(i=!1);var n=t.getBoundingClientRect(),s=1,o=1;e&&me(t)&&(s=t.offsetWidth>0&&we(n.width)/t.offsetWidth||1,o=t.offsetHeight>0&&we(n.height)/t.offsetHeight||1);var r=(pe(t)?fe(t):window).visualViewport,a=!Ee()&&i,l=(n.left+(a&&r?r.offsetLeft:0))/s,c=(n.top+(a&&r?r.offsetTop:0))/o,h=n.width/s,d=n.height/o;return{width:h,height:d,top:c,right:l+h,bottom:c+d,left:l,x:l,y:c}}function Ce(t){var e=Te(t),i=t.offsetWidth,n=t.offsetHeight;return Math.abs(e.width-i)<=1&&(i=e.width),Math.abs(e.height-n)<=1&&(n=e.height),{x:t.offsetLeft,y:t.offsetTop,width:i,height:n}}function Oe(t,e){var i=e.getRootNode&&e.getRootNode();if(t.contains(e))return!0;if(i&&ge(i)){var n=e;do{if(n&&t.isSameNode(n))return!0;n=n.parentNode||n.host}while(n)}return!1}function xe(t){return fe(t).getComputedStyle(t)}function ke(t){return["table","td","th"].indexOf(ue(t))>=0}function Le(t){return((pe(t)?t.ownerDocument:t.document)||window.document).documentElement}function Se(t){return"html"===ue(t)?t:t.assignedSlot||t.parentNode||(ge(t)?t.host:null)||Le(t)}function De(t){return me(t)&&"fixed"!==xe(t).position?t.offsetParent:null}function $e(t){for(var e=fe(t),i=De(t);i&&ke(i)&&"static"===xe(i).position;)i=De(i);return i&&("html"===ue(i)||"body"===ue(i)&&"static"===xe(i).position)?e:i||function(t){var e=/firefox/i.test(Ae());if(/Trident/i.test(Ae())&&me(t)&&"fixed"===xe(t).position)return null;var i=Se(t);for(ge(i)&&(i=i.host);me(i)&&["html","body"].indexOf(ue(i))<0;){var n=xe(i);if("none"!==n.transform||"none"!==n.perspective||"paint"===n.contain||-1!==["transform","perspective"].indexOf(n.willChange)||e&&"filter"===n.willChange||e&&n.filter&&"none"!==n.filter)return i;i=i.parentNode}return null}(t)||e}function Ie(t){return["top","bottom"].indexOf(t)>=0?"x":"y"}function Ne(t,e,i){return ve(t,ye(e,i))}function Pe(t){return Object.assign({},{top:0,right:0,bottom:0,left:0},t)}function Me(t,e){return e.reduce((function(e,i){return e[i]=t,e}),{})}const je={name:"arrow",enabled:!0,phase:"main",fn:function(t){var e,i=t.state,n=t.name,s=t.options,o=i.elements.arrow,r=i.modifiersData.popperOffsets,a=be(i.placement),l=Ie(a),c=[Vt,qt].indexOf(a)>=0?"height":"width";if(o&&r){var h=function(t,e){return Pe("number"!=typeof(t="function"==typeof t?t(Object.assign({},e.rects,{placement:e.placement})):t)?t:Me(t,Qt))}(s.padding,i),d=Ce(o),u="y"===l?zt:Vt,f="y"===l?Rt:qt,p=i.rects.reference[c]+i.rects.reference[l]-r[l]-i.rects.popper[c],m=r[l]-i.rects.reference[l],g=$e(o),_=g?"y"===l?g.clientHeight||0:g.clientWidth||0:0,b=p/2-m/2,v=h[u],y=_-d[c]-h[f],w=_/2-d[c]/2+b,A=Ne(v,w,y),E=l;i.modifiersData[n]=((e={})[E]=A,e.centerOffset=A-w,e)}},effect:function(t){var e=t.state,i=t.options.element,n=void 0===i?"[data-popper-arrow]":i;null!=n&&("string"!=typeof n||(n=e.elements.popper.querySelector(n)))&&Oe(e.elements.popper,n)&&(e.elements.arrow=n)},requires:["popperOffsets"],requiresIfExists:["preventOverflow"]};function Fe(t){return t.split("-")[1]}var He={top:"auto",right:"auto",bottom:"auto",left:"auto"};function We(t){var e,i=t.popper,n=t.popperRect,s=t.placement,o=t.variation,r=t.offsets,a=t.position,l=t.gpuAcceleration,c=t.adaptive,h=t.roundOffsets,d=t.isFixed,u=r.x,f=void 0===u?0:u,p=r.y,m=void 0===p?0:p,g="function"==typeof h?h({x:f,y:m}):{x:f,y:m};f=g.x,m=g.y;var _=r.hasOwnProperty("x"),b=r.hasOwnProperty("y"),v=Vt,y=zt,w=window;if(c){var A=$e(i),E="clientHeight",T="clientWidth";A===fe(i)&&"static"!==xe(A=Le(i)).position&&"absolute"===a&&(E="scrollHeight",T="scrollWidth"),(s===zt||(s===Vt||s===qt)&&o===Yt)&&(y=Rt,m-=(d&&A===w&&w.visualViewport?w.visualViewport.height:A[E])-n.height,m*=l?1:-1),s!==Vt&&(s!==zt&&s!==Rt||o!==Yt)||(v=qt,f-=(d&&A===w&&w.visualViewport?w.visualViewport.width:A[T])-n.width,f*=l?1:-1)}var C,O=Object.assign({position:a},c&&He),x=!0===h?function(t,e){var i=t.x,n=t.y,s=e.devicePixelRatio||1;return{x:we(i*s)/s||0,y:we(n*s)/s||0}}({x:f,y:m},fe(i)):{x:f,y:m};return f=x.x,m=x.y,l?Object.assign({},O,((C={})[y]=b?"0":"",C[v]=_?"0":"",C.transform=(w.devicePixelRatio||1)<=1?"translate("+f+"px, "+m+"px)":"translate3d("+f+"px, "+m+"px, 0)",C)):Object.assign({},O,((e={})[y]=b?m+"px":"",e[v]=_?f+"px":"",e.transform="",e))}const Be={name:"computeStyles",enabled:!0,phase:"beforeWrite",fn:function(t){var e=t.state,i=t.options,n=i.gpuAcceleration,s=void 0===n||n,o=i.adaptive,r=void 0===o||o,a=i.roundOffsets,l=void 0===a||a,c={placement:be(e.placement),variation:Fe(e.placement),popper:e.elements.popper,popperRect:e.rects.popper,gpuAcceleration:s,isFixed:"fixed"===e.options.strategy};null!=e.modifiersData.popperOffsets&&(e.styles.popper=Object.assign({},e.styles.popper,We(Object.assign({},c,{offsets:e.modifiersData.popperOffsets,position:e.options.strategy,adaptive:r,roundOffsets:l})))),null!=e.modifiersData.arrow&&(e.styles.arrow=Object.assign({},e.styles.arrow,We(Object.assign({},c,{offsets:e.modifiersData.arrow,position:"absolute",adaptive:!1,roundOffsets:l})))),e.attributes.popper=Object.assign({},e.attributes.popper,{"data-popper-placement":e.placement})},data:{}};var ze={passive:!0};const Re={name:"eventListeners",enabled:!0,phase:"write",fn:function(){},effect:function(t){var e=t.state,i=t.instance,n=t.options,s=n.scroll,o=void 0===s||s,r=n.resize,a=void 0===r||r,l=fe(e.elements.popper),c=[].concat(e.scrollParents.reference,e.scrollParents.popper);return o&&c.forEach((function(t){t.addEventListener("scroll",i.update,ze)})),a&&l.addEventListener("resize",i.update,ze),function(){o&&c.forEach((function(t){t.removeEventListener("scroll",i.update,ze)})),a&&l.removeEventListener("resize",i.update,ze)}},data:{}};var qe={left:"right",right:"left",bottom:"top",top:"bottom"};function Ve(t){return t.replace(/left|right|bottom|top/g,(function(t){return qe[t]}))}var Ke={start:"end",end:"start"};function Qe(t){return t.replace(/start|end/g,(function(t){return Ke[t]}))}function Xe(t){var e=fe(t);return{scrollLeft:e.pageXOffset,scrollTop:e.pageYOffset}}function Ye(t){return Te(Le(t)).left+Xe(t).scrollLeft}function Ue(t){var e=xe(t),i=e.overflow,n=e.overflowX,s=e.overflowY;return/auto|scroll|overlay|hidden/.test(i+s+n)}function Ge(t){return["html","body","#document"].indexOf(ue(t))>=0?t.ownerDocument.body:me(t)&&Ue(t)?t:Ge(Se(t))}function Je(t,e){var i;void 0===e&&(e=[]);var n=Ge(t),s=n===(null==(i=t.ownerDocument)?void 0:i.body),o=fe(n),r=s?[o].concat(o.visualViewport||[],Ue(n)?n:[]):n,a=e.concat(r);return s?a:a.concat(Je(Se(r)))}function Ze(t){return Object.assign({},t,{left:t.x,top:t.y,right:t.x+t.width,bottom:t.y+t.height})}function ti(t,e,i){return e===Gt?Ze(function(t,e){var i=fe(t),n=Le(t),s=i.visualViewport,o=n.clientWidth,r=n.clientHeight,a=0,l=0;if(s){o=s.width,r=s.height;var c=Ee();(c||!c&&"fixed"===e)&&(a=s.offsetLeft,l=s.offsetTop)}return{width:o,height:r,x:a+Ye(t),y:l}}(t,i)):pe(e)?function(t,e){var i=Te(t,!1,"fixed"===e);return i.top=i.top+t.clientTop,i.left=i.left+t.clientLeft,i.bottom=i.top+t.clientHeight,i.right=i.left+t.clientWidth,i.width=t.clientWidth,i.height=t.clientHeight,i.x=i.left,i.y=i.top,i}(e,i):Ze(function(t){var e,i=Le(t),n=Xe(t),s=null==(e=t.ownerDocument)?void 0:e.body,o=ve(i.scrollWidth,i.clientWidth,s?s.scrollWidth:0,s?s.clientWidth:0),r=ve(i.scrollHeight,i.clientHeight,s?s.scrollHeight:0,s?s.clientHeight:0),a=-n.scrollLeft+Ye(t),l=-n.scrollTop;return"rtl"===xe(s||i).direction&&(a+=ve(i.clientWidth,s?s.clientWidth:0)-o),{width:o,height:r,x:a,y:l}}(Le(t)))}function ei(t){var e,i=t.reference,n=t.element,s=t.placement,o=s?be(s):null,r=s?Fe(s):null,a=i.x+i.width/2-n.width/2,l=i.y+i.height/2-n.height/2;switch(o){case zt:e={x:a,y:i.y-n.height};break;case Rt:e={x:a,y:i.y+i.height};break;case qt:e={x:i.x+i.width,y:l};break;case Vt:e={x:i.x-n.width,y:l};break;default:e={x:i.x,y:i.y}}var c=o?Ie(o):null;if(null!=c){var h="y"===c?"height":"width";switch(r){case Xt:e[c]=e[c]-(i[h]/2-n[h]/2);break;case Yt:e[c]=e[c]+(i[h]/2-n[h]/2)}}return e}function ii(t,e){void 0===e&&(e={});var i=e,n=i.placement,s=void 0===n?t.placement:n,o=i.strategy,r=void 0===o?t.strategy:o,a=i.boundary,l=void 0===a?Ut:a,c=i.rootBoundary,h=void 0===c?Gt:c,d=i.elementContext,u=void 0===d?Jt:d,f=i.altBoundary,p=void 0!==f&&f,m=i.padding,g=void 0===m?0:m,_=Pe("number"!=typeof g?g:Me(g,Qt)),b=u===Jt?Zt:Jt,v=t.rects.popper,y=t.elements[p?b:u],w=function(t,e,i,n){var s="clippingParents"===e?function(t){var e=Je(Se(t)),i=["absolute","fixed"].indexOf(xe(t).position)>=0&&me(t)?$e(t):t;return pe(i)?e.filter((function(t){return pe(t)&&Oe(t,i)&&"body"!==ue(t)})):[]}(t):[].concat(e),o=[].concat(s,[i]),r=o[0],a=o.reduce((function(e,i){var s=ti(t,i,n);return e.top=ve(s.top,e.top),e.right=ye(s.right,e.right),e.bottom=ye(s.bottom,e.bottom),e.left=ve(s.left,e.left),e}),ti(t,r,n));return a.width=a.right-a.left,a.height=a.bottom-a.top,a.x=a.left,a.y=a.top,a}(pe(y)?y:y.contextElement||Le(t.elements.popper),l,h,r),A=Te(t.elements.reference),E=ei({reference:A,element:v,strategy:"absolute",placement:s}),T=Ze(Object.assign({},v,E)),C=u===Jt?T:A,O={top:w.top-C.top+_.top,bottom:C.bottom-w.bottom+_.bottom,left:w.left-C.left+_.left,right:C.right-w.right+_.right},x=t.modifiersData.offset;if(u===Jt&&x){var k=x[s];Object.keys(O).forEach((function(t){var e=[qt,Rt].indexOf(t)>=0?1:-1,i=[zt,Rt].indexOf(t)>=0?"y":"x";O[t]+=k[i]*e}))}return O}function ni(t,e){void 0===e&&(e={});var i=e,n=i.placement,s=i.boundary,o=i.rootBoundary,r=i.padding,a=i.flipVariations,l=i.allowedAutoPlacements,c=void 0===l?ee:l,h=Fe(n),d=h?a?te:te.filter((function(t){return Fe(t)===h})):Qt,u=d.filter((function(t){return c.indexOf(t)>=0}));0===u.length&&(u=d);var f=u.reduce((function(e,i){return e[i]=ii(t,{placement:i,boundary:s,rootBoundary:o,padding:r})[be(i)],e}),{});return Object.keys(f).sort((function(t,e){return f[t]-f[e]}))}const si={name:"flip",enabled:!0,phase:"main",fn:function(t){var e=t.state,i=t.options,n=t.name;if(!e.modifiersData[n]._skip){for(var s=i.mainAxis,o=void 0===s||s,r=i.altAxis,a=void 0===r||r,l=i.fallbackPlacements,c=i.padding,h=i.boundary,d=i.rootBoundary,u=i.altBoundary,f=i.flipVariations,p=void 0===f||f,m=i.allowedAutoPlacements,g=e.options.placement,_=be(g),b=l||(_!==g&&p?function(t){if(be(t)===Kt)return[];var e=Ve(t);return[Qe(t),e,Qe(e)]}(g):[Ve(g)]),v=[g].concat(b).reduce((function(t,i){return t.concat(be(i)===Kt?ni(e,{placement:i,boundary:h,rootBoundary:d,padding:c,flipVariations:p,allowedAutoPlacements:m}):i)}),[]),y=e.rects.reference,w=e.rects.popper,A=new Map,E=!0,T=v[0],C=0;C<v.length;C++){var O=v[C],x=be(O),k=Fe(O)===Xt,L=[zt,Rt].indexOf(x)>=0,S=L?"width":"height",D=ii(e,{placement:O,boundary:h,rootBoundary:d,altBoundary:u,padding:c}),$=L?k?qt:Vt:k?Rt:zt;y[S]>w[S]&&($=Ve($));var I=Ve($),N=[];if(o&&N.push(D[x]<=0),a&&N.push(D[$]<=0,D[I]<=0),N.every((function(t){return t}))){T=O,E=!1;break}A.set(O,N)}if(E)for(var P=function(t){var e=v.find((function(e){var i=A.get(e);if(i)return i.slice(0,t).every((function(t){return t}))}));if(e)return T=e,"break"},M=p?3:1;M>0&&"break"!==P(M);M--);e.placement!==T&&(e.modifiersData[n]._skip=!0,e.placement=T,e.reset=!0)}},requiresIfExists:["offset"],data:{_skip:!1}};function oi(t,e,i){return void 0===i&&(i={x:0,y:0}),{top:t.top-e.height-i.y,right:t.right-e.width+i.x,bottom:t.bottom-e.height+i.y,left:t.left-e.width-i.x}}function ri(t){return[zt,qt,Rt,Vt].some((function(e){return t[e]>=0}))}const ai={name:"hide",enabled:!0,phase:"main",requiresIfExists:["preventOverflow"],fn:function(t){var e=t.state,i=t.name,n=e.rects.reference,s=e.rects.popper,o=e.modifiersData.preventOverflow,r=ii(e,{elementContext:"reference"}),a=ii(e,{altBoundary:!0}),l=oi(r,n),c=oi(a,s,o),h=ri(l),d=ri(c);e.modifiersData[i]={referenceClippingOffsets:l,popperEscapeOffsets:c,isReferenceHidden:h,hasPopperEscaped:d},e.attributes.popper=Object.assign({},e.attributes.popper,{"data-popper-reference-hidden":h,"data-popper-escaped":d})}},li={name:"offset",enabled:!0,phase:"main",requires:["popperOffsets"],fn:function(t){var e=t.state,i=t.options,n=t.name,s=i.offset,o=void 0===s?[0,0]:s,r=ee.reduce((function(t,i){return t[i]=function(t,e,i){var n=be(t),s=[Vt,zt].indexOf(n)>=0?-1:1,o="function"==typeof i?i(Object.assign({},e,{placement:t})):i,r=o[0],a=o[1];return r=r||0,a=(a||0)*s,[Vt,qt].indexOf(n)>=0?{x:a,y:r}:{x:r,y:a}}(i,e.rects,o),t}),{}),a=r[e.placement],l=a.x,c=a.y;null!=e.modifiersData.popperOffsets&&(e.modifiersData.popperOffsets.x+=l,e.modifiersData.popperOffsets.y+=c),e.modifiersData[n]=r}},ci={name:"popperOffsets",enabled:!0,phase:"read",fn:function(t){var e=t.state,i=t.name;e.modifiersData[i]=ei({reference:e.rects.reference,element:e.rects.popper,strategy:"absolute",placement:e.placement})},data:{}},hi={name:"preventOverflow",enabled:!0,phase:"main",fn:function(t){var e=t.state,i=t.options,n=t.name,s=i.mainAxis,o=void 0===s||s,r=i.altAxis,a=void 0!==r&&r,l=i.boundary,c=i.rootBoundary,h=i.altBoundary,d=i.padding,u=i.tether,f=void 0===u||u,p=i.tetherOffset,m=void 0===p?0:p,g=ii(e,{boundary:l,rootBoundary:c,padding:d,altBoundary:h}),_=be(e.placement),b=Fe(e.placement),v=!b,y=Ie(_),w="x"===y?"y":"x",A=e.modifiersData.popperOffsets,E=e.rects.reference,T=e.rects.popper,C="function"==typeof m?m(Object.assign({},e.rects,{placement:e.placement})):m,O="number"==typeof C?{mainAxis:C,altAxis:C}:Object.assign({mainAxis:0,altAxis:0},C),x=e.modifiersData.offset?e.modifiersData.offset[e.placement]:null,k={x:0,y:0};if(A){if(o){var L,S="y"===y?zt:Vt,D="y"===y?Rt:qt,$="y"===y?"height":"width",I=A[y],N=I+g[S],P=I-g[D],M=f?-T[$]/2:0,j=b===Xt?E[$]:T[$],F=b===Xt?-T[$]:-E[$],H=e.elements.arrow,W=f&&H?Ce(H):{width:0,height:0},B=e.modifiersData["arrow#persistent"]?e.modifiersData["arrow#persistent"].padding:{top:0,right:0,bottom:0,left:0},z=B[S],R=B[D],q=Ne(0,E[$],W[$]),V=v?E[$]/2-M-q-z-O.mainAxis:j-q-z-O.mainAxis,K=v?-E[$]/2+M+q+R+O.mainAxis:F+q+R+O.mainAxis,Q=e.elements.arrow&&$e(e.elements.arrow),X=Q?"y"===y?Q.clientTop||0:Q.clientLeft||0:0,Y=null!=(L=null==x?void 0:x[y])?L:0,U=I+K-Y,G=Ne(f?ye(N,I+V-Y-X):N,I,f?ve(P,U):P);A[y]=G,k[y]=G-I}if(a){var J,Z="x"===y?zt:Vt,tt="x"===y?Rt:qt,et=A[w],it="y"===w?"height":"width",nt=et+g[Z],st=et-g[tt],ot=-1!==[zt,Vt].indexOf(_),rt=null!=(J=null==x?void 0:x[w])?J:0,at=ot?nt:et-E[it]-T[it]-rt+O.altAxis,lt=ot?et+E[it]+T[it]-rt-O.altAxis:st,ct=f&&ot?function(t,e,i){var n=Ne(t,e,i);return n>i?i:n}(at,et,lt):Ne(f?at:nt,et,f?lt:st);A[w]=ct,k[w]=ct-et}e.modifiersData[n]=k}},requiresIfExists:["offset"]};function di(t,e,i){void 0===i&&(i=!1);var n,s,o=me(e),r=me(e)&&function(t){var e=t.getBoundingClientRect(),i=we(e.width)/t.offsetWidth||1,n=we(e.height)/t.offsetHeight||1;return 1!==i||1!==n}(e),a=Le(e),l=Te(t,r,i),c={scrollLeft:0,scrollTop:0},h={x:0,y:0};return(o||!o&&!i)&&(("body"!==ue(e)||Ue(a))&&(c=(n=e)!==fe(n)&&me(n)?{scrollLeft:(s=n).scrollLeft,scrollTop:s.scrollTop}:Xe(n)),me(e)?((h=Te(e,!0)).x+=e.clientLeft,h.y+=e.clientTop):a&&(h.x=Ye(a))),{x:l.left+c.scrollLeft-h.x,y:l.top+c.scrollTop-h.y,width:l.width,height:l.height}}function ui(t){var e=new Map,i=new Set,n=[];function s(t){i.add(t.name),[].concat(t.requires||[],t.requiresIfExists||[]).forEach((function(t){if(!i.has(t)){var n=e.get(t);n&&s(n)}})),n.push(t)}return t.forEach((function(t){e.set(t.name,t)})),t.forEach((function(t){i.has(t.name)||s(t)})),n}var fi={placement:"bottom",modifiers:[],strategy:"absolute"};function pi(){for(var t=arguments.length,e=new Array(t),i=0;i<t;i++)e[i]=arguments[i];return!e.some((function(t){return!(t&&"function"==typeof t.getBoundingClientRect)}))}function mi(t){void 0===t&&(t={});var e=t,i=e.defaultModifiers,n=void 0===i?[]:i,s=e.defaultOptions,o=void 0===s?fi:s;return function(t,e,i){void 0===i&&(i=o);var s,r,a={placement:"bottom",orderedModifiers:[],options:Object.assign({},fi,o),modifiersData:{},elements:{reference:t,popper:e},attributes:{},styles:{}},l=[],c=!1,h={state:a,setOptions:function(i){var s="function"==typeof i?i(a.options):i;d(),a.options=Object.assign({},o,a.options,s),a.scrollParents={reference:pe(t)?Je(t):t.contextElement?Je(t.contextElement):[],popper:Je(e)};var r,c,u=function(t){var e=ui(t);return de.reduce((function(t,i){return t.concat(e.filter((function(t){return t.phase===i})))}),[])}((r=[].concat(n,a.options.modifiers),c=r.reduce((function(t,e){var i=t[e.name];return t[e.name]=i?Object.assign({},i,e,{options:Object.assign({},i.options,e.options),data:Object.assign({},i.data,e.data)}):e,t}),{}),Object.keys(c).map((function(t){return c[t]}))));return a.orderedModifiers=u.filter((function(t){return t.enabled})),a.orderedModifiers.forEach((function(t){var e=t.name,i=t.options,n=void 0===i?{}:i,s=t.effect;if("function"==typeof s){var o=s({state:a,name:e,instance:h,options:n});l.push(o||function(){})}})),h.update()},forceUpdate:function(){if(!c){var t=a.elements,e=t.reference,i=t.popper;if(pi(e,i)){a.rects={reference:di(e,$e(i),"fixed"===a.options.strategy),popper:Ce(i)},a.reset=!1,a.placement=a.options.placement,a.orderedModifiers.forEach((function(t){return a.modifiersData[t.name]=Object.assign({},t.data)}));for(var n=0;n<a.orderedModifiers.length;n++)if(!0!==a.reset){var s=a.orderedModifiers[n],o=s.fn,r=s.options,l=void 0===r?{}:r,d=s.name;"function"==typeof o&&(a=o({state:a,options:l,name:d,instance:h})||a)}else a.reset=!1,n=-1}}},update:(s=function(){return new Promise((function(t){h.forceUpdate(),t(a)}))},function(){return r||(r=new Promise((function(t){Promise.resolve().then((function(){r=void 0,t(s())}))}))),r}),destroy:function(){d(),c=!0}};if(!pi(t,e))return h;function d(){l.forEach((function(t){return t()})),l=[]}return h.setOptions(i).then((function(t){!c&&i.onFirstUpdate&&i.onFirstUpdate(t)})),h}}var gi=mi(),_i=mi({defaultModifiers:[Re,ci,Be,_e]}),bi=mi({defaultModifiers:[Re,ci,Be,_e,li,si,hi,je,ai]});const vi=Object.freeze(Object.defineProperty({__proto__:null,afterMain:ae,afterRead:se,afterWrite:he,applyStyles:_e,arrow:je,auto:Kt,basePlacements:Qt,beforeMain:oe,beforeRead:ie,beforeWrite:le,bottom:Rt,clippingParents:Ut,computeStyles:Be,createPopper:bi,createPopperBase:gi,createPopperLite:_i,detectOverflow:ii,end:Yt,eventListeners:Re,flip:si,hide:ai,left:Vt,main:re,modifierPhases:de,offset:li,placements:ee,popper:Jt,popperGenerator:mi,popperOffsets:ci,preventOverflow:hi,read:ne,reference:Zt,right:qt,start:Xt,top:zt,variationPlacements:te,viewport:Gt,write:ce},Symbol.toStringTag,{value:"Module"})),yi="dropdown",wi=".bs.dropdown",Ai=".data-api",Ei="ArrowUp",Ti="ArrowDown",Ci=`hide${wi}`,Oi=`hidden${wi}`,xi=`show${wi}`,ki=`shown${wi}`,Li=`click${wi}${Ai}`,Si=`keydown${wi}${Ai}`,Di=`keyup${wi}${Ai}`,$i="show",Ii='[data-bs-toggle="dropdown"]:not(.disabled):not(:disabled)',Ni=`${Ii}.${$i}`,Pi=".dropdown-menu",Mi=p()?"top-end":"top-start",ji=p()?"top-start":"top-end",Fi=p()?"bottom-end":"bottom-start",Hi=p()?"bottom-start":"bottom-end",Wi=p()?"left-start":"right-start",Bi=p()?"right-start":"left-start",zi={autoClose:!0,boundary:"clippingParents",display:"dynamic",offset:[0,2],popperConfig:null,reference:"toggle"},Ri={autoClose:"(boolean|string)",boundary:"(string|element)",display:"string",offset:"(array|string|function)",popperConfig:"(null|object|function)",reference:"(string|element|object)"};class qi extends W{constructor(t,e){super(t,e),this._popper=null,this._parent=this._element.parentNode,this._menu=z.next(this._element,Pi)[0]||z.prev(this._element,Pi)[0]||z.findOne(Pi,this._parent),this._inNavbar=this._detectNavbar()}static get Default(){return zi}static get DefaultType(){return Ri}static get NAME(){return yi}toggle(){return this._isShown()?this.hide():this.show()}show(){if(l(this._element)||this._isShown())return;const t={relatedTarget:this._element};if(!N.trigger(this._element,xi,t).defaultPrevented){if(this._createPopper(),"ontouchstart"in document.documentElement&&!this._parent.closest(".navbar-nav"))for(const t of[].concat(...document.body.children))N.on(t,"mouseover",h);this._element.focus(),this._element.setAttribute("aria-expanded",!0),this._menu.classList.add($i),this._element.classList.add($i),N.trigger(this._element,ki,t)}}hide(){if(l(this._element)||!this._isShown())return;const t={relatedTarget:this._element};this._completeHide(t)}dispose(){this._popper&&this._popper.destroy(),super.dispose()}update(){this._inNavbar=this._detectNavbar(),this._popper&&this._popper.update()}_completeHide(t){if(!N.trigger(this._element,Ci,t).defaultPrevented){if("ontouchstart"in document.documentElement)for(const t of[].concat(...document.body.children))N.off(t,"mouseover",h);this._popper&&this._popper.destroy(),this._menu.classList.remove($i),this._element.classList.remove($i),this._element.setAttribute("aria-expanded","false"),F.removeDataAttribute(this._menu,"popper"),N.trigger(this._element,Oi,t)}}_getConfig(t){if("object"==typeof(t=super._getConfig(t)).reference&&!o(t.reference)&&"function"!=typeof t.reference.getBoundingClientRect)throw new TypeError(`${yi.toUpperCase()}: Option "reference" provided type "object" without a required "getBoundingClientRect" method.`);return t}_createPopper(){if(void 0===vi)throw new TypeError("Bootstrap's dropdowns require Popper (https://popper.js.org)");let t=this._element;"parent"===this._config.reference?t=this._parent:o(this._config.reference)?t=r(this._config.reference):"object"==typeof this._config.reference&&(t=this._config.reference);const e=this._getPopperConfig();this._popper=bi(t,this._menu,e)}_isShown(){return this._menu.classList.contains($i)}_getPlacement(){const t=this._parent;if(t.classList.contains("dropend"))return Wi;if(t.classList.contains("dropstart"))return Bi;if(t.classList.contains("dropup-center"))return"top";if(t.classList.contains("dropdown-center"))return"bottom";const e="end"===getComputedStyle(this._menu).getPropertyValue("--bs-position").trim();return t.classList.contains("dropup")?e?ji:Mi:e?Hi:Fi}_detectNavbar(){return null!==this._element.closest(".navbar")}_getOffset(){const{offset:t}=this._config;return"string"==typeof t?t.split(",").map((t=>Number.parseInt(t,10))):"function"==typeof t?e=>t(e,this._element):t}_getPopperConfig(){const t={placement:this._getPlacement(),modifiers:[{name:"preventOverflow",options:{boundary:this._config.boundary}},{name:"offset",options:{offset:this._getOffset()}}]};return(this._inNavbar||"static"===this._config.display)&&(F.setDataAttribute(this._menu,"popper","static"),t.modifiers=[{name:"applyStyles",enabled:!1}]),{...t,...g(this._config.popperConfig,[t])}}_selectMenuItem({key:t,target:e}){const i=z.find(".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)",this._menu).filter((t=>a(t)));i.length&&b(i,e,t===Ti,!i.includes(e)).focus()}static jQueryInterface(t){return this.each((function(){const e=qi.getOrCreateInstance(this,t);if("string"==typeof t){if(void 0===e[t])throw new TypeError(`No method named "${t}"`);e[t]()}}))}static clearMenus(t){if(2===t.button||"keyup"===t.type&&"Tab"!==t.key)return;const e=z.find(Ni);for(const i of e){const e=qi.getInstance(i);if(!e||!1===e._config.autoClose)continue;const n=t.composedPath(),s=n.includes(e._menu);if(n.includes(e._element)||"inside"===e._config.autoClose&&!s||"outside"===e._config.autoClose&&s)continue;if(e._menu.contains(t.target)&&("keyup"===t.type&&"Tab"===t.key||/input|select|option|textarea|form/i.test(t.target.tagName)))continue;const o={relatedTarget:e._element};"click"===t.type&&(o.clickEvent=t),e._completeHide(o)}}static dataApiKeydownHandler(t){const e=/input|textarea/i.test(t.target.tagName),i="Escape"===t.key,n=[Ei,Ti].includes(t.key);if(!n&&!i)return;if(e&&!i)return;t.preventDefault();const s=this.matches(Ii)?this:z.prev(this,Ii)[0]||z.next(this,Ii)[0]||z.findOne(Ii,t.delegateTarget.parentNode),o=qi.getOrCreateInstance(s);if(n)return t.stopPropagation(),o.show(),void o._selectMenuItem(t);o._isShown()&&(t.stopPropagation(),o.hide(),s.focus())}}N.on(document,Si,Ii,qi.dataApiKeydownHandler),N.on(document,Si,Pi,qi.dataApiKeydownHandler),N.on(document,Li,qi.clearMenus),N.on(document,Di,qi.clearMenus),N.on(document,Li,Ii,(function(t){t.preventDefault(),qi.getOrCreateInstance(this).toggle()})),m(qi);const Vi="backdrop",Ki="show",Qi=`mousedown.bs.${Vi}`,Xi={className:"modal-backdrop",clickCallback:null,isAnimated:!1,isVisible:!0,rootElement:"body"},Yi={className:"string",clickCallback:"(function|null)",isAnimated:"boolean",isVisible:"boolean",rootElement:"(element|string)"};class Ui extends H{constructor(t){super(),this._config=this._getConfig(t),this._isAppended=!1,this._element=null}static get Default(){return Xi}static get DefaultType(){return Yi}static get NAME(){return Vi}show(t){if(!this._config.isVisible)return void g(t);this._append();const e=this._getElement();this._config.isAnimated&&d(e),e.classList.add(Ki),this._emulateAnimation((()=>{g(t)}))}hide(t){this._config.isVisible?(this._getElement().classList.remove(Ki),this._emulateAnimation((()=>{this.dispose(),g(t)}))):g(t)}dispose(){this._isAppended&&(N.off(this._element,Qi),this._element.remove(),this._isAppended=!1)}_getElement(){if(!this._element){const t=document.createElement("div");t.className=this._config.className,this._config.isAnimated&&t.classList.add("fade"),this._element=t}return this._element}_configAfterMerge(t){return t.rootElement=r(t.rootElement),t}_append(){if(this._isAppended)return;const t=this._getElement();this._config.rootElement.append(t),N.on(t,Qi,(()=>{g(this._config.clickCallback)})),this._isAppended=!0}_emulateAnimation(t){_(t,this._getElement(),this._config.isAnimated)}}const Gi=".bs.focustrap",Ji=`focusin${Gi}`,Zi=`keydown.tab${Gi}`,tn="backward",en={autofocus:!0,trapElement:null},nn={autofocus:"boolean",trapElement:"element"};class sn extends H{constructor(t){super(),this._config=this._getConfig(t),this._isActive=!1,this._lastTabNavDirection=null}static get Default(){return en}static get DefaultType(){return nn}static get NAME(){return"focustrap"}activate(){this._isActive||(this._config.autofocus&&this._config.trapElement.focus(),N.off(document,Gi),N.on(document,Ji,(t=>this._handleFocusin(t))),N.on(document,Zi,(t=>this._handleKeydown(t))),this._isActive=!0)}deactivate(){this._isActive&&(this._isActive=!1,N.off(document,Gi))}_handleFocusin(t){const{trapElement:e}=this._config;if(t.target===document||t.target===e||e.contains(t.target))return;const i=z.focusableChildren(e);0===i.length?e.focus():this._lastTabNavDirection===tn?i[i.length-1].focus():i[0].focus()}_handleKeydown(t){"Tab"===t.key&&(this._lastTabNavDirection=t.shiftKey?tn:"forward")}}const on=".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",rn=".sticky-top",an="padding-right",ln="margin-right";class cn{constructor(){this._element=document.body}getWidth(){const t=document.documentElement.clientWidth;return Math.abs(window.innerWidth-t)}hide(){const t=this.getWidth();this._disableOverFlow(),this._setElementAttributes(this._element,an,(e=>e+t)),this._setElementAttributes(on,an,(e=>e+t)),this._setElementAttributes(rn,ln,(e=>e-t))}reset(){this._resetElementAttributes(this._element,"overflow"),this._resetElementAttributes(this._element,an),this._resetElementAttributes(on,an),this._resetElementAttributes(rn,ln)}isOverflowing(){return this.getWidth()>0}_disableOverFlow(){this._saveInitialAttribute(this._element,"overflow"),this._element.style.overflow="hidden"}_setElementAttributes(t,e,i){const n=this.getWidth();this._applyManipulationCallback(t,(t=>{if(t!==this._element&&window.innerWidth>t.clientWidth+n)return;this._saveInitialAttribute(t,e);const s=window.getComputedStyle(t).getPropertyValue(e);t.style.setProperty(e,`${i(Number.parseFloat(s))}px`)}))}_saveInitialAttribute(t,e){const i=t.style.getPropertyValue(e);i&&F.setDataAttribute(t,e,i)}_resetElementAttributes(t,e){this._applyManipulationCallback(t,(t=>{const i=F.getDataAttribute(t,e);null!==i?(F.removeDataAttribute(t,e),t.style.setProperty(e,i)):t.style.removeProperty(e)}))}_applyManipulationCallback(t,e){if(o(t))e(t);else for(const i of z.find(t,this._element))e(i)}}const hn=".bs.modal",dn=`hide${hn}`,un=`hidePrevented${hn}`,fn=`hidden${hn}`,pn=`show${hn}`,mn=`shown${hn}`,gn=`resize${hn}`,_n=`click.dismiss${hn}`,bn=`mousedown.dismiss${hn}`,vn=`keydown.dismiss${hn}`,yn=`click${hn}.data-api`,wn="modal-open",An="show",En="modal-static",Tn={backdrop:!0,focus:!0,keyboard:!0},Cn={backdrop:"(boolean|string)",focus:"boolean",keyboard:"boolean"};class On extends W{constructor(t,e){super(t,e),this._dialog=z.findOne(".modal-dialog",this._element),this._backdrop=this._initializeBackDrop(),this._focustrap=this._initializeFocusTrap(),this._isShown=!1,this._isTransitioning=!1,this._scrollBar=new cn,this._addEventListeners()}static get Default(){return Tn}static get DefaultType(){return Cn}static get NAME(){return"modal"}toggle(t){return this._isShown?this.hide():this.show(t)}show(t){this._isShown||this._isTransitioning||N.trigger(this._element,pn,{relatedTarget:t}).defaultPrevented||(this._isShown=!0,this._isTransitioning=!0,this._scrollBar.hide(),document.body.classList.add(wn),this._adjustDialog(),this._backdrop.show((()=>this._showElement(t))))}hide(){this._isShown&&!this._isTransitioning&&(N.trigger(this._element,dn).defaultPrevented||(this._isShown=!1,this._isTransitioning=!0,this._focustrap.deactivate(),this._element.classList.remove(An),this._queueCallback((()=>this._hideModal()),this._element,this._isAnimated())))}dispose(){N.off(window,hn),N.off(this._dialog,hn),this._backdrop.dispose(),this._focustrap.deactivate(),super.dispose()}handleUpdate(){this._adjustDialog()}_initializeBackDrop(){return new Ui({isVisible:Boolean(this._config.backdrop),isAnimated:this._isAnimated()})}_initializeFocusTrap(){return new sn({trapElement:this._element})}_showElement(t){document.body.contains(this._element)||document.body.append(this._element),this._element.style.display="block",this._element.removeAttribute("aria-hidden"),this._element.setAttribute("aria-modal",!0),this._element.setAttribute("role","dialog"),this._element.scrollTop=0;const e=z.findOne(".modal-body",this._dialog);e&&(e.scrollTop=0),d(this._element),this._element.classList.add(An),this._queueCallback((()=>{this._config.focus&&this._focustrap.activate(),this._isTransitioning=!1,N.trigger(this._element,mn,{relatedTarget:t})}),this._dialog,this._isAnimated())}_addEventListeners(){N.on(this._element,vn,(t=>{"Escape"===t.key&&(this._config.keyboard?this.hide():this._triggerBackdropTransition())})),N.on(window,gn,(()=>{this._isShown&&!this._isTransitioning&&this._adjustDialog()})),N.on(this._element,bn,(t=>{N.one(this._element,_n,(e=>{this._element===t.target&&this._element===e.target&&("static"!==this._config.backdrop?this._config.backdrop&&this.hide():this._triggerBackdropTransition())}))}))}_hideModal(){this._element.style.display="none",this._element.setAttribute("aria-hidden",!0),this._element.removeAttribute("aria-modal"),this._element.removeAttribute("role"),this._isTransitioning=!1,this._backdrop.hide((()=>{document.body.classList.remove(wn),this._resetAdjustments(),this._scrollBar.reset(),N.trigger(this._element,fn)}))}_isAnimated(){return this._element.classList.contains("fade")}_triggerBackdropTransition(){if(N.trigger(this._element,un).defaultPrevented)return;const t=this._element.scrollHeight>document.documentElement.clientHeight,e=this._element.style.overflowY;"hidden"===e||this._element.classList.contains(En)||(t||(this._element.style.overflowY="hidden"),this._element.classList.add(En),this._queueCallback((()=>{this._element.classList.remove(En),this._queueCallback((()=>{this._element.style.overflowY=e}),this._dialog)}),this._dialog),this._element.focus())}_adjustDialog(){const t=this._element.scrollHeight>document.documentElement.clientHeight,e=this._scrollBar.getWidth(),i=e>0;if(i&&!t){const t=p()?"paddingLeft":"paddingRight";this._element.style[t]=`${e}px`}if(!i&&t){const t=p()?"paddingRight":"paddingLeft";this._element.style[t]=`${e}px`}}_resetAdjustments(){this._element.style.paddingLeft="",this._element.style.paddingRight=""}static jQueryInterface(t,e){return this.each((function(){const i=On.getOrCreateInstance(this,t);if("string"==typeof t){if(void 0===i[t])throw new TypeError(`No method named "${t}"`);i[t](e)}}))}}N.on(document,yn,'[data-bs-toggle="modal"]',(function(t){const e=z.getElementFromSelector(this);["A","AREA"].includes(this.tagName)&&t.preventDefault(),N.one(e,pn,(t=>{t.defaultPrevented||N.one(e,fn,(()=>{a(this)&&this.focus()}))}));const i=z.findOne(".modal.show");i&&On.getInstance(i).hide(),On.getOrCreateInstance(e).toggle(this)})),R(On),m(On);const xn=".bs.offcanvas",kn=".data-api",Ln=`load${xn}${kn}`,Sn="show",Dn="showing",$n="hiding",In=".offcanvas.show",Nn=`show${xn}`,Pn=`shown${xn}`,Mn=`hide${xn}`,jn=`hidePrevented${xn}`,Fn=`hidden${xn}`,Hn=`resize${xn}`,Wn=`click${xn}${kn}`,Bn=`keydown.dismiss${xn}`,zn={backdrop:!0,keyboard:!0,scroll:!1},Rn={backdrop:"(boolean|string)",keyboard:"boolean",scroll:"boolean"};class qn extends W{constructor(t,e){super(t,e),this._isShown=!1,this._backdrop=this._initializeBackDrop(),this._focustrap=this._initializeFocusTrap(),this._addEventListeners()}static get Default(){return zn}static get DefaultType(){return Rn}static get NAME(){return"offcanvas"}toggle(t){return this._isShown?this.hide():this.show(t)}show(t){this._isShown||N.trigger(this._element,Nn,{relatedTarget:t}).defaultPrevented||(this._isShown=!0,this._backdrop.show(),this._config.scroll||(new cn).hide(),this._element.setAttribute("aria-modal",!0),this._element.setAttribute("role","dialog"),this._element.classList.add(Dn),this._queueCallback((()=>{this._config.scroll&&!this._config.backdrop||this._focustrap.activate(),this._element.classList.add(Sn),this._element.classList.remove(Dn),N.trigger(this._element,Pn,{relatedTarget:t})}),this._element,!0))}hide(){this._isShown&&(N.trigger(this._element,Mn).defaultPrevented||(this._focustrap.deactivate(),this._element.blur(),this._isShown=!1,this._element.classList.add($n),this._backdrop.hide(),this._queueCallback((()=>{this._element.classList.remove(Sn,$n),this._element.removeAttribute("aria-modal"),this._element.removeAttribute("role"),this._config.scroll||(new cn).reset(),N.trigger(this._element,Fn)}),this._element,!0)))}dispose(){this._backdrop.dispose(),this._focustrap.deactivate(),super.dispose()}_initializeBackDrop(){const t=Boolean(this._config.backdrop);return new Ui({className:"offcanvas-backdrop",isVisible:t,isAnimated:!0,rootElement:this._element.parentNode,clickCallback:t?()=>{"static"!==this._config.backdrop?this.hide():N.trigger(this._element,jn)}:null})}_initializeFocusTrap(){return new sn({trapElement:this._element})}_addEventListeners(){N.on(this._element,Bn,(t=>{"Escape"===t.key&&(this._config.keyboard?this.hide():N.trigger(this._element,jn))}))}static jQueryInterface(t){return this.each((function(){const e=qn.getOrCreateInstance(this,t);if("string"==typeof t){if(void 0===e[t]||t.startsWith("_")||"constructor"===t)throw new TypeError(`No method named "${t}"`);e[t](this)}}))}}N.on(document,Wn,'[data-bs-toggle="offcanvas"]',(function(t){const e=z.getElementFromSelector(this);if(["A","AREA"].includes(this.tagName)&&t.preventDefault(),l(this))return;N.one(e,Fn,(()=>{a(this)&&this.focus()}));const i=z.findOne(In);i&&i!==e&&qn.getInstance(i).hide(),qn.getOrCreateInstance(e).toggle(this)})),N.on(window,Ln,(()=>{for(const t of z.find(In))qn.getOrCreateInstance(t).show()})),N.on(window,Hn,(()=>{for(const t of z.find("[aria-modal][class*=show][class*=offcanvas-]"))"fixed"!==getComputedStyle(t).position&&qn.getOrCreateInstance(t).hide()})),R(qn),m(qn);const Vn={"*":["class","dir","id","lang","role",/^aria-[\w-]*$/i],a:["target","href","title","rel"],area:[],b:[],br:[],col:[],code:[],div:[],em:[],hr:[],h1:[],h2:[],h3:[],h4:[],h5:[],h6:[],i:[],img:["src","srcset","alt","title","width","height"],li:[],ol:[],p:[],pre:[],s:[],small:[],span:[],sub:[],sup:[],strong:[],u:[],ul:[]},Kn=new Set(["background","cite","href","itemtype","longdesc","poster","src","xlink:href"]),Qn=/^(?!javascript:)(?:[a-z0-9+.-]+:|[^&:/?#]*(?:[/?#]|$))/i,Xn=(t,e)=>{const i=t.nodeName.toLowerCase();return e.includes(i)?!Kn.has(i)||Boolean(Qn.test(t.nodeValue)):e.filter((t=>t instanceof RegExp)).some((t=>t.test(i)))},Yn={allowList:Vn,content:{},extraClass:"",html:!1,sanitize:!0,sanitizeFn:null,template:"<div></div>"},Un={allowList:"object",content:"object",extraClass:"(string|function)",html:"boolean",sanitize:"boolean",sanitizeFn:"(null|function)",template:"string"},Gn={entry:"(string|element|function|null)",selector:"(string|element)"};class Jn extends H{constructor(t){super(),this._config=this._getConfig(t)}static get Default(){return Yn}static get DefaultType(){return Un}static get NAME(){return"TemplateFactory"}getContent(){return Object.values(this._config.content).map((t=>this._resolvePossibleFunction(t))).filter(Boolean)}hasContent(){return this.getContent().length>0}changeContent(t){return this._checkContent(t),this._config.content={...this._config.content,...t},this}toHtml(){const t=document.createElement("div");t.innerHTML=this._maybeSanitize(this._config.template);for(const[e,i]of Object.entries(this._config.content))this._setContent(t,i,e);const e=t.children[0],i=this._resolvePossibleFunction(this._config.extraClass);return i&&e.classList.add(...i.split(" ")),e}_typeCheckConfig(t){super._typeCheckConfig(t),this._checkContent(t.content)}_checkContent(t){for(const[e,i]of Object.entries(t))super._typeCheckConfig({selector:e,entry:i},Gn)}_setContent(t,e,i){const n=z.findOne(i,t);n&&((e=this._resolvePossibleFunction(e))?o(e)?this._putElementInTemplate(r(e),n):this._config.html?n.innerHTML=this._maybeSanitize(e):n.textContent=e:n.remove())}_maybeSanitize(t){return this._config.sanitize?function(t,e,i){if(!t.length)return t;if(i&&"function"==typeof i)return i(t);const n=(new window.DOMParser).parseFromString(t,"text/html"),s=[].concat(...n.body.querySelectorAll("*"));for(const t of s){const i=t.nodeName.toLowerCase();if(!Object.keys(e).includes(i)){t.remove();continue}const n=[].concat(...t.attributes),s=[].concat(e["*"]||[],e[i]||[]);for(const e of n)Xn(e,s)||t.removeAttribute(e.nodeName)}return n.body.innerHTML}(t,this._config.allowList,this._config.sanitizeFn):t}_resolvePossibleFunction(t){return g(t,[this])}_putElementInTemplate(t,e){if(this._config.html)return e.innerHTML="",void e.append(t);e.textContent=t.textContent}}const Zn=new Set(["sanitize","allowList","sanitizeFn"]),ts="fade",es="show",is=".modal",ns="hide.bs.modal",ss="hover",os="focus",rs={AUTO:"auto",TOP:"top",RIGHT:p()?"left":"right",BOTTOM:"bottom",LEFT:p()?"right":"left"},as={allowList:Vn,animation:!0,boundary:"clippingParents",container:!1,customClass:"",delay:0,fallbackPlacements:["top","right","bottom","left"],html:!1,offset:[0,6],placement:"top",popperConfig:null,sanitize:!0,sanitizeFn:null,selector:!1,template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',title:"",trigger:"hover focus"},ls={allowList:"object",animation:"boolean",boundary:"(string|element)",container:"(string|element|boolean)",customClass:"(string|function)",delay:"(number|object)",fallbackPlacements:"array",html:"boolean",offset:"(array|string|function)",placement:"(string|function)",popperConfig:"(null|object|function)",sanitize:"boolean",sanitizeFn:"(null|function)",selector:"(string|boolean)",template:"string",title:"(string|element|function)",trigger:"string"};class cs extends W{constructor(t,e){if(void 0===vi)throw new TypeError("Bootstrap's tooltips require Popper (https://popper.js.org)");super(t,e),this._isEnabled=!0,this._timeout=0,this._isHovered=null,this._activeTrigger={},this._popper=null,this._templateFactory=null,this._newContent=null,this.tip=null,this._setListeners(),this._config.selector||this._fixTitle()}static get Default(){return as}static get DefaultType(){return ls}static get NAME(){return"tooltip"}enable(){this._isEnabled=!0}disable(){this._isEnabled=!1}toggleEnabled(){this._isEnabled=!this._isEnabled}toggle(){this._isEnabled&&(this._activeTrigger.click=!this._activeTrigger.click,this._isShown()?this._leave():this._enter())}dispose(){clearTimeout(this._timeout),N.off(this._element.closest(is),ns,this._hideModalHandler),this._element.getAttribute("data-bs-original-title")&&this._element.setAttribute("title",this._element.getAttribute("data-bs-original-title")),this._disposePopper(),super.dispose()}show(){if("none"===this._element.style.display)throw new Error("Please use show on visible elements");if(!this._isWithContent()||!this._isEnabled)return;const t=N.trigger(this._element,this.constructor.eventName("show")),e=(c(this._element)||this._element.ownerDocument.documentElement).contains(this._element);if(t.defaultPrevented||!e)return;this._disposePopper();const i=this._getTipElement();this._element.setAttribute("aria-describedby",i.getAttribute("id"));const{container:n}=this._config;if(this._element.ownerDocument.documentElement.contains(this.tip)||(n.append(i),N.trigger(this._element,this.constructor.eventName("inserted"))),this._popper=this._createPopper(i),i.classList.add(es),"ontouchstart"in document.documentElement)for(const t of[].concat(...document.body.children))N.on(t,"mouseover",h);this._queueCallback((()=>{N.trigger(this._element,this.constructor.eventName("shown")),!1===this._isHovered&&this._leave(),this._isHovered=!1}),this.tip,this._isAnimated())}hide(){if(this._isShown()&&!N.trigger(this._element,this.constructor.eventName("hide")).defaultPrevented){if(this._getTipElement().classList.remove(es),"ontouchstart"in document.documentElement)for(const t of[].concat(...document.body.children))N.off(t,"mouseover",h);this._activeTrigger.click=!1,this._activeTrigger[os]=!1,this._activeTrigger[ss]=!1,this._isHovered=null,this._queueCallback((()=>{this._isWithActiveTrigger()||(this._isHovered||this._disposePopper(),this._element.removeAttribute("aria-describedby"),N.trigger(this._element,this.constructor.eventName("hidden")))}),this.tip,this._isAnimated())}}update(){this._popper&&this._popper.update()}_isWithContent(){return Boolean(this._getTitle())}_getTipElement(){return this.tip||(this.tip=this._createTipElement(this._newContent||this._getContentForTemplate())),this.tip}_createTipElement(t){const e=this._getTemplateFactory(t).toHtml();if(!e)return null;e.classList.remove(ts,es),e.classList.add(`bs-${this.constructor.NAME}-auto`);const i=(t=>{do{t+=Math.floor(1e6*Math.random())}while(document.getElementById(t));return t})(this.constructor.NAME).toString();return e.setAttribute("id",i),this._isAnimated()&&e.classList.add(ts),e}setContent(t){this._newContent=t,this._isShown()&&(this._disposePopper(),this.show())}_getTemplateFactory(t){return this._templateFactory?this._templateFactory.changeContent(t):this._templateFactory=new Jn({...this._config,content:t,extraClass:this._resolvePossibleFunction(this._config.customClass)}),this._templateFactory}_getContentForTemplate(){return{".tooltip-inner":this._getTitle()}}_getTitle(){return this._resolvePossibleFunction(this._config.title)||this._element.getAttribute("data-bs-original-title")}_initializeOnDelegatedTarget(t){return this.constructor.getOrCreateInstance(t.delegateTarget,this._getDelegateConfig())}_isAnimated(){return this._config.animation||this.tip&&this.tip.classList.contains(ts)}_isShown(){return this.tip&&this.tip.classList.contains(es)}_createPopper(t){const e=g(this._config.placement,[this,t,this._element]),i=rs[e.toUpperCase()];return bi(this._element,t,this._getPopperConfig(i))}_getOffset(){const{offset:t}=this._config;return"string"==typeof t?t.split(",").map((t=>Number.parseInt(t,10))):"function"==typeof t?e=>t(e,this._element):t}_resolvePossibleFunction(t){return g(t,[this._element])}_getPopperConfig(t){const e={placement:t,modifiers:[{name:"flip",options:{fallbackPlacements:this._config.fallbackPlacements}},{name:"offset",options:{offset:this._getOffset()}},{name:"preventOverflow",options:{boundary:this._config.boundary}},{name:"arrow",options:{element:`.${this.constructor.NAME}-arrow`}},{name:"preSetPlacement",enabled:!0,phase:"beforeMain",fn:t=>{this._getTipElement().setAttribute("data-popper-placement",t.state.placement)}}]};return{...e,...g(this._config.popperConfig,[e])}}_setListeners(){const t=this._config.trigger.split(" ");for(const e of t)if("click"===e)N.on(this._element,this.constructor.eventName("click"),this._config.selector,(t=>{this._initializeOnDelegatedTarget(t).toggle()}));else if("manual"!==e){const t=e===ss?this.constructor.eventName("mouseenter"):this.constructor.eventName("focusin"),i=e===ss?this.constructor.eventName("mouseleave"):this.constructor.eventName("focusout");N.on(this._element,t,this._config.selector,(t=>{const e=this._initializeOnDelegatedTarget(t);e._activeTrigger["focusin"===t.type?os:ss]=!0,e._enter()})),N.on(this._element,i,this._config.selector,(t=>{const e=this._initializeOnDelegatedTarget(t);e._activeTrigger["focusout"===t.type?os:ss]=e._element.contains(t.relatedTarget),e._leave()}))}this._hideModalHandler=()=>{this._element&&this.hide()},N.on(this._element.closest(is),ns,this._hideModalHandler)}_fixTitle(){const t=this._element.getAttribute("title");t&&(this._element.getAttribute("aria-label")||this._element.textContent.trim()||this._element.setAttribute("aria-label",t),this._element.setAttribute("data-bs-original-title",t),this._element.removeAttribute("title"))}_enter(){this._isShown()||this._isHovered?this._isHovered=!0:(this._isHovered=!0,this._setTimeout((()=>{this._isHovered&&this.show()}),this._config.delay.show))}_leave(){this._isWithActiveTrigger()||(this._isHovered=!1,this._setTimeout((()=>{this._isHovered||this.hide()}),this._config.delay.hide))}_setTimeout(t,e){clearTimeout(this._timeout),this._timeout=setTimeout(t,e)}_isWithActiveTrigger(){return Object.values(this._activeTrigger).includes(!0)}_getConfig(t){const e=F.getDataAttributes(this._element);for(const t of Object.keys(e))Zn.has(t)&&delete e[t];return t={...e,..."object"==typeof t&&t?t:{}},t=this._mergeConfigObj(t),t=this._configAfterMerge(t),this._typeCheckConfig(t),t}_configAfterMerge(t){return t.container=!1===t.container?document.body:r(t.container),"number"==typeof t.delay&&(t.delay={show:t.delay,hide:t.delay}),"number"==typeof t.title&&(t.title=t.title.toString()),"number"==typeof t.content&&(t.content=t.content.toString()),t}_getDelegateConfig(){const t={};for(const[e,i]of Object.entries(this._config))this.constructor.Default[e]!==i&&(t[e]=i);return t.selector=!1,t.trigger="manual",t}_disposePopper(){this._popper&&(this._popper.destroy(),this._popper=null),this.tip&&(this.tip.remove(),this.tip=null)}static jQueryInterface(t){return this.each((function(){const e=cs.getOrCreateInstance(this,t);if("string"==typeof t){if(void 0===e[t])throw new TypeError(`No method named "${t}"`);e[t]()}}))}}m(cs);const hs={...cs.Default,content:"",offset:[0,8],placement:"right",template:'<div class="popover" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',trigger:"click"},ds={...cs.DefaultType,content:"(null|string|element|function)"};class us extends cs{static get Default(){return hs}static get DefaultType(){return ds}static get NAME(){return"popover"}_isWithContent(){return this._getTitle()||this._getContent()}_getContentForTemplate(){return{".popover-header":this._getTitle(),".popover-body":this._getContent()}}_getContent(){return this._resolvePossibleFunction(this._config.content)}static jQueryInterface(t){return this.each((function(){const e=us.getOrCreateInstance(this,t);if("string"==typeof t){if(void 0===e[t])throw new TypeError(`No method named "${t}"`);e[t]()}}))}}m(us);const fs=".bs.scrollspy",ps=`activate${fs}`,ms=`click${fs}`,gs=`load${fs}.data-api`,_s="active",bs="[href]",vs=".nav-link",ys=`${vs}, .nav-item > ${vs}, .list-group-item`,ws={offset:null,rootMargin:"0px 0px -25%",smoothScroll:!1,target:null,threshold:[.1,.5,1]},As={offset:"(number|null)",rootMargin:"string",smoothScroll:"boolean",target:"element",threshold:"array"};class Es extends W{constructor(t,e){super(t,e),this._targetLinks=new Map,this._observableSections=new Map,this._rootElement="visible"===getComputedStyle(this._element).overflowY?null:this._element,this._activeTarget=null,this._observer=null,this._previousScrollData={visibleEntryTop:0,parentScrollTop:0},this.refresh()}static get Default(){return ws}static get DefaultType(){return As}static get NAME(){return"scrollspy"}refresh(){this._initializeTargetsAndObservables(),this._maybeEnableSmoothScroll(),this._observer?this._observer.disconnect():this._observer=this._getNewObserver();for(const t of this._observableSections.values())this._observer.observe(t)}dispose(){this._observer.disconnect(),super.dispose()}_configAfterMerge(t){return t.target=r(t.target)||document.body,t.rootMargin=t.offset?`${t.offset}px 0px -30%`:t.rootMargin,"string"==typeof t.threshold&&(t.threshold=t.threshold.split(",").map((t=>Number.parseFloat(t)))),t}_maybeEnableSmoothScroll(){this._config.smoothScroll&&(N.off(this._config.target,ms),N.on(this._config.target,ms,bs,(t=>{const e=this._observableSections.get(t.target.hash);if(e){t.preventDefault();const i=this._rootElement||window,n=e.offsetTop-this._element.offsetTop;if(i.scrollTo)return void i.scrollTo({top:n,behavior:"smooth"});i.scrollTop=n}})))}_getNewObserver(){const t={root:this._rootElement,threshold:this._config.threshold,rootMargin:this._config.rootMargin};return new IntersectionObserver((t=>this._observerCallback(t)),t)}_observerCallback(t){const e=t=>this._targetLinks.get(`#${t.target.id}`),i=t=>{this._previousScrollData.visibleEntryTop=t.target.offsetTop,this._process(e(t))},n=(this._rootElement||document.documentElement).scrollTop,s=n>=this._previousScrollData.parentScrollTop;this._previousScrollData.parentScrollTop=n;for(const o of t){if(!o.isIntersecting){this._activeTarget=null,this._clearActiveClass(e(o));continue}const t=o.target.offsetTop>=this._previousScrollData.visibleEntryTop;if(s&&t){if(i(o),!n)return}else s||t||i(o)}}_initializeTargetsAndObservables(){this._targetLinks=new Map,this._observableSections=new Map;const t=z.find(bs,this._config.target);for(const e of t){if(!e.hash||l(e))continue;const t=z.findOne(decodeURI(e.hash),this._element);a(t)&&(this._targetLinks.set(decodeURI(e.hash),e),this._observableSections.set(e.hash,t))}}_process(t){this._activeTarget!==t&&(this._clearActiveClass(this._config.target),this._activeTarget=t,t.classList.add(_s),this._activateParents(t),N.trigger(this._element,ps,{relatedTarget:t}))}_activateParents(t){if(t.classList.contains("dropdown-item"))z.findOne(".dropdown-toggle",t.closest(".dropdown")).classList.add(_s);else for(const e of z.parents(t,".nav, .list-group"))for(const t of z.prev(e,ys))t.classList.add(_s)}_clearActiveClass(t){t.classList.remove(_s);const e=z.find(`${bs}.${_s}`,t);for(const t of e)t.classList.remove(_s)}static jQueryInterface(t){return this.each((function(){const e=Es.getOrCreateInstance(this,t);if("string"==typeof t){if(void 0===e[t]||t.startsWith("_")||"constructor"===t)throw new TypeError(`No method named "${t}"`);e[t]()}}))}}N.on(window,gs,(()=>{for(const t of z.find('[data-bs-spy="scroll"]'))Es.getOrCreateInstance(t)})),m(Es);const Ts=".bs.tab",Cs=`hide${Ts}`,Os=`hidden${Ts}`,xs=`show${Ts}`,ks=`shown${Ts}`,Ls=`click${Ts}`,Ss=`keydown${Ts}`,Ds=`load${Ts}`,$s="ArrowLeft",Is="ArrowRight",Ns="ArrowUp",Ps="ArrowDown",Ms="Home",js="End",Fs="active",Hs="fade",Ws="show",Bs=".dropdown-toggle",zs=`:not(${Bs})`,Rs='[data-bs-toggle="tab"], [data-bs-toggle="pill"], [data-bs-toggle="list"]',qs=`.nav-link${zs}, .list-group-item${zs}, [role="tab"]${zs}, ${Rs}`,Vs=`.${Fs}[data-bs-toggle="tab"], .${Fs}[data-bs-toggle="pill"], .${Fs}[data-bs-toggle="list"]`;class Ks extends W{constructor(t){super(t),this._parent=this._element.closest('.list-group, .nav, [role="tablist"]'),this._parent&&(this._setInitialAttributes(this._parent,this._getChildren()),N.on(this._element,Ss,(t=>this._keydown(t))))}static get NAME(){return"tab"}show(){const t=this._element;if(this._elemIsActive(t))return;const e=this._getActiveElem(),i=e?N.trigger(e,Cs,{relatedTarget:t}):null;N.trigger(t,xs,{relatedTarget:e}).defaultPrevented||i&&i.defaultPrevented||(this._deactivate(e,t),this._activate(t,e))}_activate(t,e){t&&(t.classList.add(Fs),this._activate(z.getElementFromSelector(t)),this._queueCallback((()=>{"tab"===t.getAttribute("role")?(t.removeAttribute("tabindex"),t.setAttribute("aria-selected",!0),this._toggleDropDown(t,!0),N.trigger(t,ks,{relatedTarget:e})):t.classList.add(Ws)}),t,t.classList.contains(Hs)))}_deactivate(t,e){t&&(t.classList.remove(Fs),t.blur(),this._deactivate(z.getElementFromSelector(t)),this._queueCallback((()=>{"tab"===t.getAttribute("role")?(t.setAttribute("aria-selected",!1),t.setAttribute("tabindex","-1"),this._toggleDropDown(t,!1),N.trigger(t,Os,{relatedTarget:e})):t.classList.remove(Ws)}),t,t.classList.contains(Hs)))}_keydown(t){if(![$s,Is,Ns,Ps,Ms,js].includes(t.key))return;t.stopPropagation(),t.preventDefault();const e=this._getChildren().filter((t=>!l(t)));let i;if([Ms,js].includes(t.key))i=e[t.key===Ms?0:e.length-1];else{const n=[Is,Ps].includes(t.key);i=b(e,t.target,n,!0)}i&&(i.focus({preventScroll:!0}),Ks.getOrCreateInstance(i).show())}_getChildren(){return z.find(qs,this._parent)}_getActiveElem(){return this._getChildren().find((t=>this._elemIsActive(t)))||null}_setInitialAttributes(t,e){this._setAttributeIfNotExists(t,"role","tablist");for(const t of e)this._setInitialAttributesOnChild(t)}_setInitialAttributesOnChild(t){t=this._getInnerElement(t);const e=this._elemIsActive(t),i=this._getOuterElement(t);t.setAttribute("aria-selected",e),i!==t&&this._setAttributeIfNotExists(i,"role","presentation"),e||t.setAttribute("tabindex","-1"),this._setAttributeIfNotExists(t,"role","tab"),this._setInitialAttributesOnTargetPanel(t)}_setInitialAttributesOnTargetPanel(t){const e=z.getElementFromSelector(t);e&&(this._setAttributeIfNotExists(e,"role","tabpanel"),t.id&&this._setAttributeIfNotExists(e,"aria-labelledby",`${t.id}`))}_toggleDropDown(t,e){const i=this._getOuterElement(t);if(!i.classList.contains("dropdown"))return;const n=(t,n)=>{const s=z.findOne(t,i);s&&s.classList.toggle(n,e)};n(Bs,Fs),n(".dropdown-menu",Ws),i.setAttribute("aria-expanded",e)}_setAttributeIfNotExists(t,e,i){t.hasAttribute(e)||t.setAttribute(e,i)}_elemIsActive(t){return t.classList.contains(Fs)}_getInnerElement(t){return t.matches(qs)?t:z.findOne(qs,t)}_getOuterElement(t){return t.closest(".nav-item, .list-group-item")||t}static jQueryInterface(t){return this.each((function(){const e=Ks.getOrCreateInstance(this);if("string"==typeof t){if(void 0===e[t]||t.startsWith("_")||"constructor"===t)throw new TypeError(`No method named "${t}"`);e[t]()}}))}}N.on(document,Ls,Rs,(function(t){["A","AREA"].includes(this.tagName)&&t.preventDefault(),l(this)||Ks.getOrCreateInstance(this).show()})),N.on(window,Ds,(()=>{for(const t of z.find(Vs))Ks.getOrCreateInstance(t)})),m(Ks);const Qs=".bs.toast",Xs=`mouseover${Qs}`,Ys=`mouseout${Qs}`,Us=`focusin${Qs}`,Gs=`focusout${Qs}`,Js=`hide${Qs}`,Zs=`hidden${Qs}`,to=`show${Qs}`,eo=`shown${Qs}`,io="hide",no="show",so="showing",oo={animation:"boolean",autohide:"boolean",delay:"number"},ro={animation:!0,autohide:!0,delay:5e3};class ao extends W{constructor(t,e){super(t,e),this._timeout=null,this._hasMouseInteraction=!1,this._hasKeyboardInteraction=!1,this._setListeners()}static get Default(){return ro}static get DefaultType(){return oo}static get NAME(){return"toast"}show(){N.trigger(this._element,to).defaultPrevented||(this._clearTimeout(),this._config.animation&&this._element.classList.add("fade"),this._element.classList.remove(io),d(this._element),this._element.classList.add(no,so),this._queueCallback((()=>{this._element.classList.remove(so),N.trigger(this._element,eo),this._maybeScheduleHide()}),this._element,this._config.animation))}hide(){this.isShown()&&(N.trigger(this._element,Js).defaultPrevented||(this._element.classList.add(so),this._queueCallback((()=>{this._element.classList.add(io),this._element.classList.remove(so,no),N.trigger(this._element,Zs)}),this._element,this._config.animation)))}dispose(){this._clearTimeout(),this.isShown()&&this._element.classList.remove(no),super.dispose()}isShown(){return this._element.classList.contains(no)}_maybeScheduleHide(){this._config.autohide&&(this._hasMouseInteraction||this._hasKeyboardInteraction||(this._timeout=setTimeout((()=>{this.hide()}),this._config.delay)))}_onInteraction(t,e){switch(t.type){case"mouseover":case"mouseout":this._hasMouseInteraction=e;break;case"focusin":case"focusout":this._hasKeyboardInteraction=e}if(e)return void this._clearTimeout();const i=t.relatedTarget;this._element===i||this._element.contains(i)||this._maybeScheduleHide()}_setListeners(){N.on(this._element,Xs,(t=>this._onInteraction(t,!0))),N.on(this._element,Ys,(t=>this._onInteraction(t,!1))),N.on(this._element,Us,(t=>this._onInteraction(t,!0))),N.on(this._element,Gs,(t=>this._onInteraction(t,!1)))}_clearTimeout(){clearTimeout(this._timeout),this._timeout=null}static jQueryInterface(t){return this.each((function(){const e=ao.getOrCreateInstance(this,t);if("string"==typeof t){if(void 0===e[t])throw new TypeError(`No method named "${t}"`);e[t](this)}}))}}return R(ao),m(ao),{Alert:Q,Button:Y,Carousel:xt,Collapse:Bt,Dropdown:qi,Modal:On,Offcanvas:qn,Popover:us,ScrollSpy:Es,Tab:Ks,Toast:ao,Tooltip:cs}}));
//# sourceMappingURL=bootstrap.bundle.min.js.map


/*
     _ _      _       _
 ___| (_) ___| | __  (_)___
/ __| | |/ __| |/ /  | / __|
\__ \ | | (__|   < _ | \__ \
|___/_|_|\___|_|\_(_)/ |___/
                   |__/

 Version: 1.9.0
  Author: Ken Wheeler
 Website: http://kenwheeler.github.io
    Docs: http://kenwheeler.github.io/slick
    Repo: http://github.com/kenwheeler/slick
  Issues: http://github.com/kenwheeler/slick/issues

 */
(function (i) { "use strict"; "function" == typeof define && define.amd ? define(["jquery"], i) : "undefined" != typeof exports ? module.exports = i(require("jquery")) : i(jQuery) })(function (i) {
    "use strict"; var e = window.Slick || {}; e = function () { function e(e, o) { var s, n = this; n.defaults = { accessibility: !0, adaptiveHeight: !1, appendArrows: i(e), appendDots: i(e), arrows: !0, asNavFor: null, prevArrow: '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>', nextArrow: '<button class="slick-next" aria-label="Next" type="button">Next</button>', autoplay: !1, autoplaySpeed: 3e3, centerMode: !1, centerPadding: "50px", cssEase: "ease", customPaging: function (e, t) { return i('<button type="button" />').text(t + 1) }, dots: !1, dotsClass: "slick-dots", draggable: !0, easing: "linear", edgeFriction: .35, fade: !1, focusOnSelect: !1, focusOnChange: !1, infinite: !0, initialSlide: 0, lazyLoad: "ondemand", mobileFirst: !1, pauseOnHover: !0, pauseOnFocus: !0, pauseOnDotsHover: !1, respondTo: "window", responsive: null, rows: 1, rtl: !1, slide: "", slidesPerRow: 1, slidesToShow: 1, slidesToScroll: 1, speed: 500, swipe: !0, swipeToSlide: !1, touchMove: !0, touchThreshold: 5, useCSS: !0, useTransform: !0, variableWidth: !1, vertical: !1, verticalSwiping: !1, waitForAnimate: !0, zIndex: 1e3 }, n.initials = { animating: !1, dragging: !1, autoPlayTimer: null, currentDirection: 0, currentLeft: null, currentSlide: 0, direction: 1, $dots: null, listWidth: null, listHeight: null, loadIndex: 0, $nextArrow: null, $prevArrow: null, scrolling: !1, slideCount: null, slideWidth: null, $slideTrack: null, $slides: null, sliding: !1, slideOffset: 0, swipeLeft: null, swiping: !1, $list: null, touchObject: {}, transformsEnabled: !1, unslicked: !1 }, i.extend(n, n.initials), n.activeBreakpoint = null, n.animType = null, n.animProp = null, n.breakpoints = [], n.breakpointSettings = [], n.cssTransitions = !1, n.focussed = !1, n.interrupted = !1, n.hidden = "hidden", n.paused = !0, n.positionProp = null, n.respondTo = null, n.rowCount = 1, n.shouldClick = !0, n.$slider = i(e), n.$slidesCache = null, n.transformType = null, n.transitionType = null, n.visibilityChange = "visibilitychange", n.windowWidth = 0, n.windowTimer = null, s = i(e).data("slick") || {}, n.options = i.extend({}, n.defaults, o, s), n.currentSlide = n.options.initialSlide, n.originalSettings = n.options, "undefined" != typeof document.mozHidden ? (n.hidden = "mozHidden", n.visibilityChange = "mozvisibilitychange") : "undefined" != typeof document.webkitHidden && (n.hidden = "webkitHidden", n.visibilityChange = "webkitvisibilitychange"), n.autoPlay = i.proxy(n.autoPlay, n), n.autoPlayClear = i.proxy(n.autoPlayClear, n), n.autoPlayIterator = i.proxy(n.autoPlayIterator, n), n.changeSlide = i.proxy(n.changeSlide, n), n.clickHandler = i.proxy(n.clickHandler, n), n.selectHandler = i.proxy(n.selectHandler, n), n.setPosition = i.proxy(n.setPosition, n), n.swipeHandler = i.proxy(n.swipeHandler, n), n.dragHandler = i.proxy(n.dragHandler, n), n.keyHandler = i.proxy(n.keyHandler, n), n.instanceUid = t++, n.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/, n.registerBreakpoints(), n.init(!0) } var t = 0; return e }(), e.prototype.activateADA = function () { var i = this; i.$slideTrack.find(".slick-active").attr({ "aria-hidden": "false" }).find("a, input, button, select").attr({ tabindex: "0" }) }, e.prototype.addSlide = e.prototype.slickAdd = function (e, t, o) { var s = this; if ("boolean" == typeof t) o = t, t = null; else if (t < 0 || t >= s.slideCount) return !1; s.unload(), "number" == typeof t ? 0 === t && 0 === s.$slides.length ? i(e).appendTo(s.$slideTrack) : o ? i(e).insertBefore(s.$slides.eq(t)) : i(e).insertAfter(s.$slides.eq(t)) : o === !0 ? i(e).prependTo(s.$slideTrack) : i(e).appendTo(s.$slideTrack), s.$slides = s.$slideTrack.children(this.options.slide), s.$slideTrack.children(this.options.slide).detach(), s.$slideTrack.append(s.$slides), s.$slides.each(function (e, t) { i(t).attr("data-slick-index", e) }), s.$slidesCache = s.$slides, s.reinit() }, e.prototype.animateHeight = function () { var i = this; if (1 === i.options.slidesToShow && i.options.adaptiveHeight === !0 && i.options.vertical === !1) { var e = i.$slides.eq(i.currentSlide).outerHeight(!0); i.$list.animate({ height: e }, i.options.speed) } }, e.prototype.animateSlide = function (e, t) { var o = {}, s = this; s.animateHeight(), s.options.rtl === !0 && s.options.vertical === !1 && (e = -e), s.transformsEnabled === !1 ? s.options.vertical === !1 ? s.$slideTrack.animate({ left: e }, s.options.speed, s.options.easing, t) : s.$slideTrack.animate({ top: e }, s.options.speed, s.options.easing, t) : s.cssTransitions === !1 ? (s.options.rtl === !0 && (s.currentLeft = -s.currentLeft), i({ animStart: s.currentLeft }).animate({ animStart: e }, { duration: s.options.speed, easing: s.options.easing, step: function (i) { i = Math.ceil(i), s.options.vertical === !1 ? (o[s.animType] = "translate(" + i + "px, 0px)", s.$slideTrack.css(o)) : (o[s.animType] = "translate(0px," + i + "px)", s.$slideTrack.css(o)) }, complete: function () { t && t.call() } })) : (s.applyTransition(), e = Math.ceil(e), s.options.vertical === !1 ? o[s.animType] = "translate3d(" + e + "px, 0px, 0px)" : o[s.animType] = "translate3d(0px," + e + "px, 0px)", s.$slideTrack.css(o), t && setTimeout(function () { s.disableTransition(), t.call() }, s.options.speed)) }, e.prototype.getNavTarget = function () { var e = this, t = e.options.asNavFor; return t && null !== t && (t = i(t).not(e.$slider)), t }, e.prototype.asNavFor = function (e) { var t = this, o = t.getNavTarget(); null !== o && "object" == typeof o && o.each(function () { var t = i(this).slick("getSlick"); t.unslicked || t.slideHandler(e, !0) }) }, e.prototype.applyTransition = function (i) { var e = this, t = {}; e.options.fade === !1 ? t[e.transitionType] = e.transformType + " " + e.options.speed + "ms " + e.options.cssEase : t[e.transitionType] = "opacity " + e.options.speed + "ms " + e.options.cssEase, e.options.fade === !1 ? e.$slideTrack.css(t) : e.$slides.eq(i).css(t) }, e.prototype.autoPlay = function () { var i = this; i.autoPlayClear(), i.slideCount > i.options.slidesToShow && (i.autoPlayTimer = setInterval(i.autoPlayIterator, i.options.autoplaySpeed)) }, e.prototype.autoPlayClear = function () { var i = this; i.autoPlayTimer && clearInterval(i.autoPlayTimer) }, e.prototype.autoPlayIterator = function () { var i = this, e = i.currentSlide + i.options.slidesToScroll; i.paused || i.interrupted || i.focussed || (i.options.infinite === !1 && (1 === i.direction && i.currentSlide + 1 === i.slideCount - 1 ? i.direction = 0 : 0 === i.direction && (e = i.currentSlide - i.options.slidesToScroll, i.currentSlide - 1 === 0 && (i.direction = 1))), i.slideHandler(e)) }, e.prototype.buildArrows = function () { var e = this; e.options.arrows === !0 && (e.$prevArrow = i(e.options.prevArrow).addClass("slick-arrow"), e.$nextArrow = i(e.options.nextArrow).addClass("slick-arrow"), e.slideCount > e.options.slidesToShow ? (e.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.prependTo(e.options.appendArrows), e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.appendTo(e.options.appendArrows), e.options.infinite !== !0 && e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : e.$prevArrow.add(e.$nextArrow).addClass("slick-hidden").attr({ "aria-disabled": "true", tabindex: "-1" })) }, e.prototype.buildDots = function () { var e, t, o = this; if (o.options.dots === !0 && o.slideCount > o.options.slidesToShow) { for (o.$slider.addClass("slick-dotted"), t = i("<ul />").addClass(o.options.dotsClass), e = 0; e <= o.getDotCount(); e += 1)t.append(i("<li />").append(o.options.customPaging.call(this, o, e))); o.$dots = t.appendTo(o.options.appendDots), o.$dots.find("li").first().addClass("slick-active") } }, e.prototype.buildOut = function () { var e = this; e.$slides = e.$slider.children(e.options.slide + ":not(.slick-cloned)").addClass("slick-slide"), e.slideCount = e.$slides.length, e.$slides.each(function (e, t) { i(t).attr("data-slick-index", e).data("originalStyling", i(t).attr("style") || "") }), e.$slider.addClass("slick-slider"), e.$slideTrack = 0 === e.slideCount ? i('<div class="slick-track"/>').appendTo(e.$slider) : e.$slides.wrapAll('<div class="slick-track"/>').parent(), e.$list = e.$slideTrack.wrap('<div class="slick-list"/>').parent(), e.$slideTrack.css("opacity", 0), e.options.centerMode !== !0 && e.options.swipeToSlide !== !0 || (e.options.slidesToScroll = 1), i("img[data-lazy]", e.$slider).not("[src]").addClass("slick-loading"), e.setupInfinite(), e.buildArrows(), e.buildDots(), e.updateDots(), e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0), e.options.draggable === !0 && e.$list.addClass("draggable") }, e.prototype.buildRows = function () { var i, e, t, o, s, n, r, l = this; if (o = document.createDocumentFragment(), n = l.$slider.children(), l.options.rows > 0) { for (r = l.options.slidesPerRow * l.options.rows, s = Math.ceil(n.length / r), i = 0; i < s; i++) { var d = document.createElement("div"); for (e = 0; e < l.options.rows; e++) { var a = document.createElement("div"); for (t = 0; t < l.options.slidesPerRow; t++) { var c = i * r + (e * l.options.slidesPerRow + t); n.get(c) && a.appendChild(n.get(c)) } d.appendChild(a) } o.appendChild(d) } l.$slider.empty().append(o), l.$slider.children().children().children().css({ width: 100 / l.options.slidesPerRow + "%", display: "inline-block" }) } }, e.prototype.checkResponsive = function (e, t) { var o, s, n, r = this, l = !1, d = r.$slider.width(), a = window.innerWidth || i(window).width(); if ("window" === r.respondTo ? n = a : "slider" === r.respondTo ? n = d : "min" === r.respondTo && (n = Math.min(a, d)), r.options.responsive && r.options.responsive.length && null !== r.options.responsive) { s = null; for (o in r.breakpoints) r.breakpoints.hasOwnProperty(o) && (r.originalSettings.mobileFirst === !1 ? n < r.breakpoints[o] && (s = r.breakpoints[o]) : n > r.breakpoints[o] && (s = r.breakpoints[o])); null !== s ? null !== r.activeBreakpoint ? (s !== r.activeBreakpoint || t) && (r.activeBreakpoint = s, "unslick" === r.breakpointSettings[s] ? r.unslick(s) : (r.options = i.extend({}, r.originalSettings, r.breakpointSettings[s]), e === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(e)), l = s) : (r.activeBreakpoint = s, "unslick" === r.breakpointSettings[s] ? r.unslick(s) : (r.options = i.extend({}, r.originalSettings, r.breakpointSettings[s]), e === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(e)), l = s) : null !== r.activeBreakpoint && (r.activeBreakpoint = null, r.options = r.originalSettings, e === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(e), l = s), e || l === !1 || r.$slider.trigger("breakpoint", [r, l]) } }, e.prototype.changeSlide = function (e, t) { var o, s, n, r = this, l = i(e.currentTarget); switch (l.is("a") && e.preventDefault(), l.is("li") || (l = l.closest("li")), n = r.slideCount % r.options.slidesToScroll !== 0, o = n ? 0 : (r.slideCount - r.currentSlide) % r.options.slidesToScroll, e.data.message) { case "previous": s = 0 === o ? r.options.slidesToScroll : r.options.slidesToShow - o, r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide - s, !1, t); break; case "next": s = 0 === o ? r.options.slidesToScroll : o, r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide + s, !1, t); break; case "index": var d = 0 === e.data.index ? 0 : e.data.index || l.index() * r.options.slidesToScroll; r.slideHandler(r.checkNavigable(d), !1, t), l.children().trigger("focus"); break; default: return } }, e.prototype.checkNavigable = function (i) { var e, t, o = this; if (e = o.getNavigableIndexes(), t = 0, i > e[e.length - 1]) i = e[e.length - 1]; else for (var s in e) { if (i < e[s]) { i = t; break } t = e[s] } return i }, e.prototype.cleanUpEvents = function () { var e = this; e.options.dots && null !== e.$dots && (i("li", e.$dots).off("click.slick", e.changeSlide).off("mouseenter.slick", i.proxy(e.interrupt, e, !0)).off("mouseleave.slick", i.proxy(e.interrupt, e, !1)), e.options.accessibility === !0 && e.$dots.off("keydown.slick", e.keyHandler)), e.$slider.off("focus.slick blur.slick"), e.options.arrows === !0 && e.slideCount > e.options.slidesToShow && (e.$prevArrow && e.$prevArrow.off("click.slick", e.changeSlide), e.$nextArrow && e.$nextArrow.off("click.slick", e.changeSlide), e.options.accessibility === !0 && (e.$prevArrow && e.$prevArrow.off("keydown.slick", e.keyHandler), e.$nextArrow && e.$nextArrow.off("keydown.slick", e.keyHandler))), e.$list.off("touchstart.slick mousedown.slick", e.swipeHandler), e.$list.off("touchmove.slick mousemove.slick", e.swipeHandler), e.$list.off("touchend.slick mouseup.slick", e.swipeHandler), e.$list.off("touchcancel.slick mouseleave.slick", e.swipeHandler), e.$list.off("click.slick", e.clickHandler), i(document).off(e.visibilityChange, e.visibility), e.cleanUpSlideEvents(), e.options.accessibility === !0 && e.$list.off("keydown.slick", e.keyHandler), e.options.focusOnSelect === !0 && i(e.$slideTrack).children().off("click.slick", e.selectHandler), i(window).off("orientationchange.slick.slick-" + e.instanceUid, e.orientationChange), i(window).off("resize.slick.slick-" + e.instanceUid, e.resize), i("[draggable!=true]", e.$slideTrack).off("dragstart", e.preventDefault), i(window).off("load.slick.slick-" + e.instanceUid, e.setPosition) }, e.prototype.cleanUpSlideEvents = function () { var e = this; e.$list.off("mouseenter.slick", i.proxy(e.interrupt, e, !0)), e.$list.off("mouseleave.slick", i.proxy(e.interrupt, e, !1)) }, e.prototype.cleanUpRows = function () { var i, e = this; e.options.rows > 0 && (i = e.$slides.children().children(), i.removeAttr("style"), e.$slider.empty().append(i)) }, e.prototype.clickHandler = function (i) { var e = this; e.shouldClick === !1 && (i.stopImmediatePropagation(), i.stopPropagation(), i.preventDefault()) }, e.prototype.destroy = function (e) { var t = this; t.autoPlayClear(), t.touchObject = {}, t.cleanUpEvents(), i(".slick-cloned", t.$slider).detach(), t.$dots && t.$dots.remove(), t.$prevArrow && t.$prevArrow.length && (t.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.prevArrow) && t.$prevArrow.remove()), t.$nextArrow && t.$nextArrow.length && (t.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.nextArrow) && t.$nextArrow.remove()), t.$slides && (t.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function () { i(this).attr("style", i(this).data("originalStyling")) }), t.$slideTrack.children(this.options.slide).detach(), t.$slideTrack.detach(), t.$list.detach(), t.$slider.append(t.$slides)), t.cleanUpRows(), t.$slider.removeClass("slick-slider"), t.$slider.removeClass("slick-initialized"), t.$slider.removeClass("slick-dotted"), t.unslicked = !0, e || t.$slider.trigger("destroy", [t]) }, e.prototype.disableTransition = function (i) { var e = this, t = {}; t[e.transitionType] = "", e.options.fade === !1 ? e.$slideTrack.css(t) : e.$slides.eq(i).css(t) }, e.prototype.fadeSlide = function (i, e) { var t = this; t.cssTransitions === !1 ? (t.$slides.eq(i).css({ zIndex: t.options.zIndex }), t.$slides.eq(i).animate({ opacity: 1 }, t.options.speed, t.options.easing, e)) : (t.applyTransition(i), t.$slides.eq(i).css({ opacity: 1, zIndex: t.options.zIndex }), e && setTimeout(function () { t.disableTransition(i), e.call() }, t.options.speed)) }, e.prototype.fadeSlideOut = function (i) { var e = this; e.cssTransitions === !1 ? e.$slides.eq(i).animate({ opacity: 0, zIndex: e.options.zIndex - 2 }, e.options.speed, e.options.easing) : (e.applyTransition(i), e.$slides.eq(i).css({ opacity: 0, zIndex: e.options.zIndex - 2 })) }, e.prototype.filterSlides = e.prototype.slickFilter = function (i) { var e = this; null !== i && (e.$slidesCache = e.$slides, e.unload(), e.$slideTrack.children(this.options.slide).detach(), e.$slidesCache.filter(i).appendTo(e.$slideTrack), e.reinit()) }, e.prototype.focusHandler = function () { var e = this; e.$slider.off("focus.slick blur.slick").on("focus.slick", "*", function (t) { var o = i(this); setTimeout(function () { e.options.pauseOnFocus && o.is(":focus") && (e.focussed = !0, e.autoPlay()) }, 0) }).on("blur.slick", "*", function (t) { i(this); e.options.pauseOnFocus && (e.focussed = !1, e.autoPlay()) }) }, e.prototype.getCurrent = e.prototype.slickCurrentSlide = function () { var i = this; return i.currentSlide }, e.prototype.getDotCount = function () { var i = this, e = 0, t = 0, o = 0; if (i.options.infinite === !0) if (i.slideCount <= i.options.slidesToShow) ++o; else for (; e < i.slideCount;)++o, e = t + i.options.slidesToScroll, t += i.options.slidesToScroll <= i.options.slidesToShow ? i.options.slidesToScroll : i.options.slidesToShow; else if (i.options.centerMode === !0) o = i.slideCount; else if (i.options.asNavFor) for (; e < i.slideCount;)++o, e = t + i.options.slidesToScroll, t += i.options.slidesToScroll <= i.options.slidesToShow ? i.options.slidesToScroll : i.options.slidesToShow; else o = 1 + Math.ceil((i.slideCount - i.options.slidesToShow) / i.options.slidesToScroll); return o - 1 }, e.prototype.getLeft = function (i) { var e, t, o, s, n = this, r = 0; return n.slideOffset = 0, t = n.$slides.first().outerHeight(!0), n.options.infinite === !0 ? (n.slideCount > n.options.slidesToShow && (n.slideOffset = n.slideWidth * n.options.slidesToShow * -1, s = -1, n.options.vertical === !0 && n.options.centerMode === !0 && (2 === n.options.slidesToShow ? s = -1.5 : 1 === n.options.slidesToShow && (s = -2)), r = t * n.options.slidesToShow * s), n.slideCount % n.options.slidesToScroll !== 0 && i + n.options.slidesToScroll > n.slideCount && n.slideCount > n.options.slidesToShow && (i > n.slideCount ? (n.slideOffset = (n.options.slidesToShow - (i - n.slideCount)) * n.slideWidth * -1, r = (n.options.slidesToShow - (i - n.slideCount)) * t * -1) : (n.slideOffset = n.slideCount % n.options.slidesToScroll * n.slideWidth * -1, r = n.slideCount % n.options.slidesToScroll * t * -1))) : i + n.options.slidesToShow > n.slideCount && (n.slideOffset = (i + n.options.slidesToShow - n.slideCount) * n.slideWidth, r = (i + n.options.slidesToShow - n.slideCount) * t), n.slideCount <= n.options.slidesToShow && (n.slideOffset = 0, r = 0), n.options.centerMode === !0 && n.slideCount <= n.options.slidesToShow ? n.slideOffset = n.slideWidth * Math.floor(n.options.slidesToShow) / 2 - n.slideWidth * n.slideCount / 2 : n.options.centerMode === !0 && n.options.infinite === !0 ? n.slideOffset += n.slideWidth * Math.floor(n.options.slidesToShow / 2) - n.slideWidth : n.options.centerMode === !0 && (n.slideOffset = 0, n.slideOffset += n.slideWidth * Math.floor(n.options.slidesToShow / 2)), e = n.options.vertical === !1 ? i * n.slideWidth * -1 + n.slideOffset : i * t * -1 + r, n.options.variableWidth === !0 && (o = n.slideCount <= n.options.slidesToShow || n.options.infinite === !1 ? n.$slideTrack.children(".slick-slide").eq(i) : n.$slideTrack.children(".slick-slide").eq(i + n.options.slidesToShow), e = n.options.rtl === !0 ? o[0] ? (n.$slideTrack.width() - o[0].offsetLeft - o.width()) * -1 : 0 : o[0] ? o[0].offsetLeft * -1 : 0, n.options.centerMode === !0 && (o = n.slideCount <= n.options.slidesToShow || n.options.infinite === !1 ? n.$slideTrack.children(".slick-slide").eq(i) : n.$slideTrack.children(".slick-slide").eq(i + n.options.slidesToShow + 1), e = n.options.rtl === !0 ? o[0] ? (n.$slideTrack.width() - o[0].offsetLeft - o.width()) * -1 : 0 : o[0] ? o[0].offsetLeft * -1 : 0, e += (n.$list.width() - o.outerWidth()) / 2)), e }, e.prototype.getOption = e.prototype.slickGetOption = function (i) { var e = this; return e.options[i] }, e.prototype.getNavigableIndexes = function () { var i, e = this, t = 0, o = 0, s = []; for (e.options.infinite === !1 ? i = e.slideCount : (t = e.options.slidesToScroll * -1, o = e.options.slidesToScroll * -1, i = 2 * e.slideCount); t < i;)s.push(t), t = o + e.options.slidesToScroll, o += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow; return s }, e.prototype.getSlick = function () { return this }, e.prototype.getSlideCount = function () { var e, t, o, s, n = this; return s = n.options.centerMode === !0 ? Math.floor(n.$list.width() / 2) : 0, o = n.swipeLeft * -1 + s, n.options.swipeToSlide === !0 ? (n.$slideTrack.find(".slick-slide").each(function (e, s) { var r, l, d; if (r = i(s).outerWidth(), l = s.offsetLeft, n.options.centerMode !== !0 && (l += r / 2), d = l + r, o < d) return t = s, !1 }), e = Math.abs(i(t).attr("data-slick-index") - n.currentSlide) || 1) : n.options.slidesToScroll }, e.prototype.goTo = e.prototype.slickGoTo = function (i, e) { var t = this; t.changeSlide({ data: { message: "index", index: parseInt(i) } }, e) }, e.prototype.init = function (e) { var t = this; i(t.$slider).hasClass("slick-initialized") || (i(t.$slider).addClass("slick-initialized"), t.buildRows(), t.buildOut(), t.setProps(), t.startLoad(), t.loadSlider(), t.initializeEvents(), t.updateArrows(), t.updateDots(), t.checkResponsive(!0), t.focusHandler()), e && t.$slider.trigger("init", [t]), t.options.accessibility === !0 && t.initADA(), t.options.autoplay && (t.paused = !1, t.autoPlay()) }, e.prototype.initADA = function () { var e = this, t = Math.ceil(e.slideCount / e.options.slidesToShow), o = e.getNavigableIndexes().filter(function (i) { return i >= 0 && i < e.slideCount }); e.$slides.add(e.$slideTrack.find(".slick-cloned")).attr({ "aria-hidden": "true", tabindex: "-1" }).find("a, input, button, select").attr({ tabindex: "-1" }), null !== e.$dots && (e.$slides.not(e.$slideTrack.find(".slick-cloned")).each(function (t) { var s = o.indexOf(t); if (i(this).attr({ role: "tabpanel", id: "slick-slide" + e.instanceUid + t, tabindex: -1 }), s !== -1) { var n = "slick-slide-control" + e.instanceUid + s; i("#" + n).length && i(this).attr({ "aria-describedby": n }) } }), e.$dots.attr("role", "tablist").find("li").each(function (s) { var n = o[s]; i(this).attr({ role: "presentation" }), i(this).find("button").first().attr({ role: "tab", id: "slick-slide-control" + e.instanceUid + s, "aria-controls": "slick-slide" + e.instanceUid + n, "aria-label": s + 1 + " of " + t, "aria-selected": null, tabindex: "-1" }) }).eq(e.currentSlide).find("button").attr({ "aria-selected": "true", tabindex: "0" }).end()); for (var s = e.currentSlide, n = s + e.options.slidesToShow; s < n; s++)e.options.focusOnChange ? e.$slides.eq(s).attr({ tabindex: "0" }) : e.$slides.eq(s).removeAttr("tabindex"); e.activateADA() }, e.prototype.initArrowEvents = function () { var i = this; i.options.arrows === !0 && i.slideCount > i.options.slidesToShow && (i.$prevArrow.off("click.slick").on("click.slick", { message: "previous" }, i.changeSlide), i.$nextArrow.off("click.slick").on("click.slick", { message: "next" }, i.changeSlide), i.options.accessibility === !0 && (i.$prevArrow.on("keydown.slick", i.keyHandler), i.$nextArrow.on("keydown.slick", i.keyHandler))) }, e.prototype.initDotEvents = function () { var e = this; e.options.dots === !0 && e.slideCount > e.options.slidesToShow && (i("li", e.$dots).on("click.slick", { message: "index" }, e.changeSlide), e.options.accessibility === !0 && e.$dots.on("keydown.slick", e.keyHandler)), e.options.dots === !0 && e.options.pauseOnDotsHover === !0 && e.slideCount > e.options.slidesToShow && i("li", e.$dots).on("mouseenter.slick", i.proxy(e.interrupt, e, !0)).on("mouseleave.slick", i.proxy(e.interrupt, e, !1)) }, e.prototype.initSlideEvents = function () { var e = this; e.options.pauseOnHover && (e.$list.on("mouseenter.slick", i.proxy(e.interrupt, e, !0)), e.$list.on("mouseleave.slick", i.proxy(e.interrupt, e, !1))) }, e.prototype.initializeEvents = function () { var e = this; e.initArrowEvents(), e.initDotEvents(), e.initSlideEvents(), e.$list.on("touchstart.slick mousedown.slick", { action: "start" }, e.swipeHandler), e.$list.on("touchmove.slick mousemove.slick", { action: "move" }, e.swipeHandler), e.$list.on("touchend.slick mouseup.slick", { action: "end" }, e.swipeHandler), e.$list.on("touchcancel.slick mouseleave.slick", { action: "end" }, e.swipeHandler), e.$list.on("click.slick", e.clickHandler), i(document).on(e.visibilityChange, i.proxy(e.visibility, e)), e.options.accessibility === !0 && e.$list.on("keydown.slick", e.keyHandler), e.options.focusOnSelect === !0 && i(e.$slideTrack).children().on("click.slick", e.selectHandler), i(window).on("orientationchange.slick.slick-" + e.instanceUid, i.proxy(e.orientationChange, e)), i(window).on("resize.slick.slick-" + e.instanceUid, i.proxy(e.resize, e)), i("[draggable!=true]", e.$slideTrack).on("dragstart", e.preventDefault), i(window).on("load.slick.slick-" + e.instanceUid, e.setPosition), i(e.setPosition) }, e.prototype.initUI = function () { var i = this; i.options.arrows === !0 && i.slideCount > i.options.slidesToShow && (i.$prevArrow.show(), i.$nextArrow.show()), i.options.dots === !0 && i.slideCount > i.options.slidesToShow && i.$dots.show() }, e.prototype.keyHandler = function (i) { var e = this; i.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === i.keyCode && e.options.accessibility === !0 ? e.changeSlide({ data: { message: e.options.rtl === !0 ? "next" : "previous" } }) : 39 === i.keyCode && e.options.accessibility === !0 && e.changeSlide({ data: { message: e.options.rtl === !0 ? "previous" : "next" } })) }, e.prototype.lazyLoad = function () { function e(e) { i("img[data-lazy]", e).each(function () { var e = i(this), t = i(this).attr("data-lazy"), o = i(this).attr("data-srcset"), s = i(this).attr("data-sizes") || r.$slider.attr("data-sizes"), n = document.createElement("img"); n.onload = function () { e.animate({ opacity: 0 }, 100, function () { o && (e.attr("srcset", o), s && e.attr("sizes", s)), e.attr("src", t).animate({ opacity: 1 }, 200, function () { e.removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading") }), r.$slider.trigger("lazyLoaded", [r, e, t]) }) }, n.onerror = function () { e.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), r.$slider.trigger("lazyLoadError", [r, e, t]) }, n.src = t }) } var t, o, s, n, r = this; if (r.options.centerMode === !0 ? r.options.infinite === !0 ? (s = r.currentSlide + (r.options.slidesToShow / 2 + 1), n = s + r.options.slidesToShow + 2) : (s = Math.max(0, r.currentSlide - (r.options.slidesToShow / 2 + 1)), n = 2 + (r.options.slidesToShow / 2 + 1) + r.currentSlide) : (s = r.options.infinite ? r.options.slidesToShow + r.currentSlide : r.currentSlide, n = Math.ceil(s + r.options.slidesToShow), r.options.fade === !0 && (s > 0 && s--, n <= r.slideCount && n++)), t = r.$slider.find(".slick-slide").slice(s, n), "anticipated" === r.options.lazyLoad) for (var l = s - 1, d = n, a = r.$slider.find(".slick-slide"), c = 0; c < r.options.slidesToScroll; c++)l < 0 && (l = r.slideCount - 1), t = t.add(a.eq(l)), t = t.add(a.eq(d)), l--, d++; e(t), r.slideCount <= r.options.slidesToShow ? (o = r.$slider.find(".slick-slide"), e(o)) : r.currentSlide >= r.slideCount - r.options.slidesToShow ? (o = r.$slider.find(".slick-cloned").slice(0, r.options.slidesToShow), e(o)) : 0 === r.currentSlide && (o = r.$slider.find(".slick-cloned").slice(r.options.slidesToShow * -1), e(o)) }, e.prototype.loadSlider = function () { var i = this; i.setPosition(), i.$slideTrack.css({ opacity: 1 }), i.$slider.removeClass("slick-loading"), i.initUI(), "progressive" === i.options.lazyLoad && i.progressiveLazyLoad() }, e.prototype.next = e.prototype.slickNext = function () { var i = this; i.changeSlide({ data: { message: "next" } }) }, e.prototype.orientationChange = function () { var i = this; i.checkResponsive(), i.setPosition() }, e.prototype.pause = e.prototype.slickPause = function () { var i = this; i.autoPlayClear(), i.paused = !0 }, e.prototype.play = e.prototype.slickPlay = function () { var i = this; i.autoPlay(), i.options.autoplay = !0, i.paused = !1, i.focussed = !1, i.interrupted = !1 }, e.prototype.postSlide = function (e) { var t = this; if (!t.unslicked && (t.$slider.trigger("afterChange", [t, e]), t.animating = !1, t.slideCount > t.options.slidesToShow && t.setPosition(), t.swipeLeft = null, t.options.autoplay && t.autoPlay(), t.options.accessibility === !0 && (t.initADA(), t.options.focusOnChange))) { var o = i(t.$slides.get(t.currentSlide)); o.attr("tabindex", 0).focus() } }, e.prototype.prev = e.prototype.slickPrev = function () { var i = this; i.changeSlide({ data: { message: "previous" } }) }, e.prototype.preventDefault = function (i) { i.preventDefault() }, e.prototype.progressiveLazyLoad = function (e) { e = e || 1; var t, o, s, n, r, l = this, d = i("img[data-lazy]", l.$slider); d.length ? (t = d.first(), o = t.attr("data-lazy"), s = t.attr("data-srcset"), n = t.attr("data-sizes") || l.$slider.attr("data-sizes"), r = document.createElement("img"), r.onload = function () { s && (t.attr("srcset", s), n && t.attr("sizes", n)), t.attr("src", o).removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading"), l.options.adaptiveHeight === !0 && l.setPosition(), l.$slider.trigger("lazyLoaded", [l, t, o]), l.progressiveLazyLoad() }, r.onerror = function () { e < 3 ? setTimeout(function () { l.progressiveLazyLoad(e + 1) }, 500) : (t.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), l.$slider.trigger("lazyLoadError", [l, t, o]), l.progressiveLazyLoad()) }, r.src = o) : l.$slider.trigger("allImagesLoaded", [l]) }, e.prototype.refresh = function (e) { var t, o, s = this; o = s.slideCount - s.options.slidesToShow, !s.options.infinite && s.currentSlide > o && (s.currentSlide = o), s.slideCount <= s.options.slidesToShow && (s.currentSlide = 0), t = s.currentSlide, s.destroy(!0), i.extend(s, s.initials, { currentSlide: t }), s.init(), e || s.changeSlide({ data: { message: "index", index: t } }, !1) }, e.prototype.registerBreakpoints = function () { var e, t, o, s = this, n = s.options.responsive || null; if ("array" === i.type(n) && n.length) { s.respondTo = s.options.respondTo || "window"; for (e in n) if (o = s.breakpoints.length - 1, n.hasOwnProperty(e)) { for (t = n[e].breakpoint; o >= 0;)s.breakpoints[o] && s.breakpoints[o] === t && s.breakpoints.splice(o, 1), o--; s.breakpoints.push(t), s.breakpointSettings[t] = n[e].settings } s.breakpoints.sort(function (i, e) { return s.options.mobileFirst ? i - e : e - i }) } }, e.prototype.reinit = function () { var e = this; e.$slides = e.$slideTrack.children(e.options.slide).addClass("slick-slide"), e.slideCount = e.$slides.length, e.currentSlide >= e.slideCount && 0 !== e.currentSlide && (e.currentSlide = e.currentSlide - e.options.slidesToScroll), e.slideCount <= e.options.slidesToShow && (e.currentSlide = 0), e.registerBreakpoints(), e.setProps(), e.setupInfinite(), e.buildArrows(), e.updateArrows(), e.initArrowEvents(), e.buildDots(), e.updateDots(), e.initDotEvents(), e.cleanUpSlideEvents(), e.initSlideEvents(), e.checkResponsive(!1, !0), e.options.focusOnSelect === !0 && i(e.$slideTrack).children().on("click.slick", e.selectHandler), e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0), e.setPosition(), e.focusHandler(), e.paused = !e.options.autoplay, e.autoPlay(), e.$slider.trigger("reInit", [e]) }, e.prototype.resize = function () { var e = this; i(window).width() !== e.windowWidth && (clearTimeout(e.windowDelay), e.windowDelay = window.setTimeout(function () { e.windowWidth = i(window).width(), e.checkResponsive(), e.unslicked || e.setPosition() }, 50)) }, e.prototype.removeSlide = e.prototype.slickRemove = function (i, e, t) { var o = this; return "boolean" == typeof i ? (e = i, i = e === !0 ? 0 : o.slideCount - 1) : i = e === !0 ? --i : i, !(o.slideCount < 1 || i < 0 || i > o.slideCount - 1) && (o.unload(), t === !0 ? o.$slideTrack.children().remove() : o.$slideTrack.children(this.options.slide).eq(i).remove(), o.$slides = o.$slideTrack.children(this.options.slide), o.$slideTrack.children(this.options.slide).detach(), o.$slideTrack.append(o.$slides), o.$slidesCache = o.$slides, void o.reinit()) }, e.prototype.setCSS = function (i) { var e, t, o = this, s = {}; o.options.rtl === !0 && (i = -i), e = "left" == o.positionProp ? Math.ceil(i) + "px" : "0px", t = "top" == o.positionProp ? Math.ceil(i) + "px" : "0px", s[o.positionProp] = i, o.transformsEnabled === !1 ? o.$slideTrack.css(s) : (s = {}, o.cssTransitions === !1 ? (s[o.animType] = "translate(" + e + ", " + t + ")", o.$slideTrack.css(s)) : (s[o.animType] = "translate3d(" + e + ", " + t + ", 0px)", o.$slideTrack.css(s))) }, e.prototype.setDimensions = function () { var i = this; i.options.vertical === !1 ? i.options.centerMode === !0 && i.$list.css({ padding: "0px " + i.options.centerPadding }) : (i.$list.height(i.$slides.first().outerHeight(!0) * i.options.slidesToShow), i.options.centerMode === !0 && i.$list.css({ padding: i.options.centerPadding + " 0px" })), i.listWidth = i.$list.width(), i.listHeight = i.$list.height(), i.options.vertical === !1 && i.options.variableWidth === !1 ? (i.slideWidth = Math.ceil(i.listWidth / i.options.slidesToShow), i.$slideTrack.width(Math.ceil(i.slideWidth * i.$slideTrack.children(".slick-slide").length))) : i.options.variableWidth === !0 ? i.$slideTrack.width(5e3 * i.slideCount) : (i.slideWidth = Math.ceil(i.listWidth), i.$slideTrack.height(Math.ceil(i.$slides.first().outerHeight(!0) * i.$slideTrack.children(".slick-slide").length))); var e = i.$slides.first().outerWidth(!0) - i.$slides.first().width(); i.options.variableWidth === !1 && i.$slideTrack.children(".slick-slide").width(i.slideWidth - e) }, e.prototype.setFade = function () { var e, t = this; t.$slides.each(function (o, s) { e = t.slideWidth * o * -1, t.options.rtl === !0 ? i(s).css({ position: "relative", right: e, top: 0, zIndex: t.options.zIndex - 2, opacity: 0 }) : i(s).css({ position: "relative", left: e, top: 0, zIndex: t.options.zIndex - 2, opacity: 0 }) }), t.$slides.eq(t.currentSlide).css({ zIndex: t.options.zIndex - 1, opacity: 1 }) }, e.prototype.setHeight = function () { var i = this; if (1 === i.options.slidesToShow && i.options.adaptiveHeight === !0 && i.options.vertical === !1) { var e = i.$slides.eq(i.currentSlide).outerHeight(!0); i.$list.css("height", e) } }, e.prototype.setOption = e.prototype.slickSetOption = function () { var e, t, o, s, n, r = this, l = !1; if ("object" === i.type(arguments[0]) ? (o = arguments[0], l = arguments[1], n = "multiple") : "string" === i.type(arguments[0]) && (o = arguments[0], s = arguments[1], l = arguments[2], "responsive" === arguments[0] && "array" === i.type(arguments[1]) ? n = "responsive" : "undefined" != typeof arguments[1] && (n = "single")), "single" === n) r.options[o] = s; else if ("multiple" === n) i.each(o, function (i, e) { r.options[i] = e }); else if ("responsive" === n) for (t in s) if ("array" !== i.type(r.options.responsive)) r.options.responsive = [s[t]]; else { for (e = r.options.responsive.length - 1; e >= 0;)r.options.responsive[e].breakpoint === s[t].breakpoint && r.options.responsive.splice(e, 1), e--; r.options.responsive.push(s[t]) } l && (r.unload(), r.reinit()) }, e.prototype.setPosition = function () { var i = this; i.setDimensions(), i.setHeight(), i.options.fade === !1 ? i.setCSS(i.getLeft(i.currentSlide)) : i.setFade(), i.$slider.trigger("setPosition", [i]) }, e.prototype.setProps = function () {
        var i = this, e = document.body.style; i.positionProp = i.options.vertical === !0 ? "top" : "left",
            "top" === i.positionProp ? i.$slider.addClass("slick-vertical") : i.$slider.removeClass("slick-vertical"), void 0 === e.WebkitTransition && void 0 === e.MozTransition && void 0 === e.msTransition || i.options.useCSS === !0 && (i.cssTransitions = !0), i.options.fade && ("number" == typeof i.options.zIndex ? i.options.zIndex < 3 && (i.options.zIndex = 3) : i.options.zIndex = i.defaults.zIndex), void 0 !== e.OTransform && (i.animType = "OTransform", i.transformType = "-o-transform", i.transitionType = "OTransition", void 0 === e.perspectiveProperty && void 0 === e.webkitPerspective && (i.animType = !1)), void 0 !== e.MozTransform && (i.animType = "MozTransform", i.transformType = "-moz-transform", i.transitionType = "MozTransition", void 0 === e.perspectiveProperty && void 0 === e.MozPerspective && (i.animType = !1)), void 0 !== e.webkitTransform && (i.animType = "webkitTransform", i.transformType = "-webkit-transform", i.transitionType = "webkitTransition", void 0 === e.perspectiveProperty && void 0 === e.webkitPerspective && (i.animType = !1)), void 0 !== e.msTransform && (i.animType = "msTransform", i.transformType = "-ms-transform", i.transitionType = "msTransition", void 0 === e.msTransform && (i.animType = !1)), void 0 !== e.transform && i.animType !== !1 && (i.animType = "transform", i.transformType = "transform", i.transitionType = "transition"), i.transformsEnabled = i.options.useTransform && null !== i.animType && i.animType !== !1
    }, e.prototype.setSlideClasses = function (i) { var e, t, o, s, n = this; if (t = n.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true"), n.$slides.eq(i).addClass("slick-current"), n.options.centerMode === !0) { var r = n.options.slidesToShow % 2 === 0 ? 1 : 0; e = Math.floor(n.options.slidesToShow / 2), n.options.infinite === !0 && (i >= e && i <= n.slideCount - 1 - e ? n.$slides.slice(i - e + r, i + e + 1).addClass("slick-active").attr("aria-hidden", "false") : (o = n.options.slidesToShow + i, t.slice(o - e + 1 + r, o + e + 2).addClass("slick-active").attr("aria-hidden", "false")), 0 === i ? t.eq(t.length - 1 - n.options.slidesToShow).addClass("slick-center") : i === n.slideCount - 1 && t.eq(n.options.slidesToShow).addClass("slick-center")), n.$slides.eq(i).addClass("slick-center") } else i >= 0 && i <= n.slideCount - n.options.slidesToShow ? n.$slides.slice(i, i + n.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : t.length <= n.options.slidesToShow ? t.addClass("slick-active").attr("aria-hidden", "false") : (s = n.slideCount % n.options.slidesToShow, o = n.options.infinite === !0 ? n.options.slidesToShow + i : i, n.options.slidesToShow == n.options.slidesToScroll && n.slideCount - i < n.options.slidesToShow ? t.slice(o - (n.options.slidesToShow - s), o + s).addClass("slick-active").attr("aria-hidden", "false") : t.slice(o, o + n.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false")); "ondemand" !== n.options.lazyLoad && "anticipated" !== n.options.lazyLoad || n.lazyLoad() }, e.prototype.setupInfinite = function () { var e, t, o, s = this; if (s.options.fade === !0 && (s.options.centerMode = !1), s.options.infinite === !0 && s.options.fade === !1 && (t = null, s.slideCount > s.options.slidesToShow)) { for (o = s.options.centerMode === !0 ? s.options.slidesToShow + 1 : s.options.slidesToShow, e = s.slideCount; e > s.slideCount - o; e -= 1)t = e - 1, i(s.$slides[t]).clone(!0).attr("id", "").attr("data-slick-index", t - s.slideCount).prependTo(s.$slideTrack).addClass("slick-cloned"); for (e = 0; e < o + s.slideCount; e += 1)t = e, i(s.$slides[t]).clone(!0).attr("id", "").attr("data-slick-index", t + s.slideCount).appendTo(s.$slideTrack).addClass("slick-cloned"); s.$slideTrack.find(".slick-cloned").find("[id]").each(function () { i(this).attr("id", "") }) } }, e.prototype.interrupt = function (i) { var e = this; i || e.autoPlay(), e.interrupted = i }, e.prototype.selectHandler = function (e) { var t = this, o = i(e.target).is(".slick-slide") ? i(e.target) : i(e.target).parents(".slick-slide"), s = parseInt(o.attr("data-slick-index")); return s || (s = 0), t.slideCount <= t.options.slidesToShow ? void t.slideHandler(s, !1, !0) : void t.slideHandler(s) }, e.prototype.slideHandler = function (i, e, t) { var o, s, n, r, l, d = null, a = this; if (e = e || !1, !(a.animating === !0 && a.options.waitForAnimate === !0 || a.options.fade === !0 && a.currentSlide === i)) return e === !1 && a.asNavFor(i), o = i, d = a.getLeft(o), r = a.getLeft(a.currentSlide), a.currentLeft = null === a.swipeLeft ? r : a.swipeLeft, a.options.infinite === !1 && a.options.centerMode === !1 && (i < 0 || i > a.getDotCount() * a.options.slidesToScroll) ? void (a.options.fade === !1 && (o = a.currentSlide, t !== !0 && a.slideCount > a.options.slidesToShow ? a.animateSlide(r, function () { a.postSlide(o) }) : a.postSlide(o))) : a.options.infinite === !1 && a.options.centerMode === !0 && (i < 0 || i > a.slideCount - a.options.slidesToScroll) ? void (a.options.fade === !1 && (o = a.currentSlide, t !== !0 && a.slideCount > a.options.slidesToShow ? a.animateSlide(r, function () { a.postSlide(o) }) : a.postSlide(o))) : (a.options.autoplay && clearInterval(a.autoPlayTimer), s = o < 0 ? a.slideCount % a.options.slidesToScroll !== 0 ? a.slideCount - a.slideCount % a.options.slidesToScroll : a.slideCount + o : o >= a.slideCount ? a.slideCount % a.options.slidesToScroll !== 0 ? 0 : o - a.slideCount : o, a.animating = !0, a.$slider.trigger("beforeChange", [a, a.currentSlide, s]), n = a.currentSlide, a.currentSlide = s, a.setSlideClasses(a.currentSlide), a.options.asNavFor && (l = a.getNavTarget(), l = l.slick("getSlick"), l.slideCount <= l.options.slidesToShow && l.setSlideClasses(a.currentSlide)), a.updateDots(), a.updateArrows(), a.options.fade === !0 ? (t !== !0 ? (a.fadeSlideOut(n), a.fadeSlide(s, function () { a.postSlide(s) })) : a.postSlide(s), void a.animateHeight()) : void (t !== !0 && a.slideCount > a.options.slidesToShow ? a.animateSlide(d, function () { a.postSlide(s) }) : a.postSlide(s))) }, e.prototype.startLoad = function () { var i = this; i.options.arrows === !0 && i.slideCount > i.options.slidesToShow && (i.$prevArrow.hide(), i.$nextArrow.hide()), i.options.dots === !0 && i.slideCount > i.options.slidesToShow && i.$dots.hide(), i.$slider.addClass("slick-loading") }, e.prototype.swipeDirection = function () { var i, e, t, o, s = this; return i = s.touchObject.startX - s.touchObject.curX, e = s.touchObject.startY - s.touchObject.curY, t = Math.atan2(e, i), o = Math.round(180 * t / Math.PI), o < 0 && (o = 360 - Math.abs(o)), o <= 45 && o >= 0 ? s.options.rtl === !1 ? "left" : "right" : o <= 360 && o >= 315 ? s.options.rtl === !1 ? "left" : "right" : o >= 135 && o <= 225 ? s.options.rtl === !1 ? "right" : "left" : s.options.verticalSwiping === !0 ? o >= 35 && o <= 135 ? "down" : "up" : "vertical" }, e.prototype.swipeEnd = function (i) { var e, t, o = this; if (o.dragging = !1, o.swiping = !1, o.scrolling) return o.scrolling = !1, !1; if (o.interrupted = !1, o.shouldClick = !(o.touchObject.swipeLength > 10), void 0 === o.touchObject.curX) return !1; if (o.touchObject.edgeHit === !0 && o.$slider.trigger("edge", [o, o.swipeDirection()]), o.touchObject.swipeLength >= o.touchObject.minSwipe) { switch (t = o.swipeDirection()) { case "left": case "down": e = o.options.swipeToSlide ? o.checkNavigable(o.currentSlide + o.getSlideCount()) : o.currentSlide + o.getSlideCount(), o.currentDirection = 0; break; case "right": case "up": e = o.options.swipeToSlide ? o.checkNavigable(o.currentSlide - o.getSlideCount()) : o.currentSlide - o.getSlideCount(), o.currentDirection = 1 }"vertical" != t && (o.slideHandler(e), o.touchObject = {}, o.$slider.trigger("swipe", [o, t])) } else o.touchObject.startX !== o.touchObject.curX && (o.slideHandler(o.currentSlide), o.touchObject = {}) }, e.prototype.swipeHandler = function (i) { var e = this; if (!(e.options.swipe === !1 || "ontouchend" in document && e.options.swipe === !1 || e.options.draggable === !1 && i.type.indexOf("mouse") !== -1)) switch (e.touchObject.fingerCount = i.originalEvent && void 0 !== i.originalEvent.touches ? i.originalEvent.touches.length : 1, e.touchObject.minSwipe = e.listWidth / e.options.touchThreshold, e.options.verticalSwiping === !0 && (e.touchObject.minSwipe = e.listHeight / e.options.touchThreshold), i.data.action) { case "start": e.swipeStart(i); break; case "move": e.swipeMove(i); break; case "end": e.swipeEnd(i) } }, e.prototype.swipeMove = function (i) { var e, t, o, s, n, r, l = this; return n = void 0 !== i.originalEvent ? i.originalEvent.touches : null, !(!l.dragging || l.scrolling || n && 1 !== n.length) && (e = l.getLeft(l.currentSlide), l.touchObject.curX = void 0 !== n ? n[0].pageX : i.clientX, l.touchObject.curY = void 0 !== n ? n[0].pageY : i.clientY, l.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(l.touchObject.curX - l.touchObject.startX, 2))), r = Math.round(Math.sqrt(Math.pow(l.touchObject.curY - l.touchObject.startY, 2))), !l.options.verticalSwiping && !l.swiping && r > 4 ? (l.scrolling = !0, !1) : (l.options.verticalSwiping === !0 && (l.touchObject.swipeLength = r), t = l.swipeDirection(), void 0 !== i.originalEvent && l.touchObject.swipeLength > 4 && (l.swiping = !0, i.preventDefault()), s = (l.options.rtl === !1 ? 1 : -1) * (l.touchObject.curX > l.touchObject.startX ? 1 : -1), l.options.verticalSwiping === !0 && (s = l.touchObject.curY > l.touchObject.startY ? 1 : -1), o = l.touchObject.swipeLength, l.touchObject.edgeHit = !1, l.options.infinite === !1 && (0 === l.currentSlide && "right" === t || l.currentSlide >= l.getDotCount() && "left" === t) && (o = l.touchObject.swipeLength * l.options.edgeFriction, l.touchObject.edgeHit = !0), l.options.vertical === !1 ? l.swipeLeft = e + o * s : l.swipeLeft = e + o * (l.$list.height() / l.listWidth) * s, l.options.verticalSwiping === !0 && (l.swipeLeft = e + o * s), l.options.fade !== !0 && l.options.touchMove !== !1 && (l.animating === !0 ? (l.swipeLeft = null, !1) : void l.setCSS(l.swipeLeft)))) }, e.prototype.swipeStart = function (i) { var e, t = this; return t.interrupted = !0, 1 !== t.touchObject.fingerCount || t.slideCount <= t.options.slidesToShow ? (t.touchObject = {}, !1) : (void 0 !== i.originalEvent && void 0 !== i.originalEvent.touches && (e = i.originalEvent.touches[0]), t.touchObject.startX = t.touchObject.curX = void 0 !== e ? e.pageX : i.clientX, t.touchObject.startY = t.touchObject.curY = void 0 !== e ? e.pageY : i.clientY, void (t.dragging = !0)) }, e.prototype.unfilterSlides = e.prototype.slickUnfilter = function () { var i = this; null !== i.$slidesCache && (i.unload(), i.$slideTrack.children(this.options.slide).detach(), i.$slidesCache.appendTo(i.$slideTrack), i.reinit()) }, e.prototype.unload = function () { var e = this; i(".slick-cloned", e.$slider).remove(), e.$dots && e.$dots.remove(), e.$prevArrow && e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.remove(), e.$nextArrow && e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.remove(), e.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "") }, e.prototype.unslick = function (i) { var e = this; e.$slider.trigger("unslick", [e, i]), e.destroy() }, e.prototype.updateArrows = function () { var i, e = this; i = Math.floor(e.options.slidesToShow / 2), e.options.arrows === !0 && e.slideCount > e.options.slidesToShow && !e.options.infinite && (e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), e.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === e.currentSlide ? (e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : e.currentSlide >= e.slideCount - e.options.slidesToShow && e.options.centerMode === !1 ? (e.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : e.currentSlide >= e.slideCount - 1 && e.options.centerMode === !0 && (e.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"))) }, e.prototype.updateDots = function () { var i = this; null !== i.$dots && (i.$dots.find("li").removeClass("slick-active").end(), i.$dots.find("li").eq(Math.floor(i.currentSlide / i.options.slidesToScroll)).addClass("slick-active")) }, e.prototype.visibility = function () { var i = this; i.options.autoplay && (document[i.hidden] ? i.interrupted = !0 : i.interrupted = !1) }, i.fn.slick = function () { var i, t, o = this, s = arguments[0], n = Array.prototype.slice.call(arguments, 1), r = o.length; for (i = 0; i < r; i++)if ("object" == typeof s || "undefined" == typeof s ? o[i].slick = new e(o[i], s) : t = o[i].slick[s].apply(o[i].slick, n), "undefined" != typeof t) return t; return o }
});

// @fancyapps/ui/Fancybox v4.0.31
!function (t, e) { "object" == typeof exports && "undefined" != typeof module ? e(exports) : "function" == typeof define && define.amd ? define(["exports"], e) : e((t = "undefined" != typeof globalThis ? globalThis : t || self).window = t.window || {}) }(this, (function (t) { "use strict"; function e(t, e) { var i = Object.keys(t); if (Object.getOwnPropertySymbols) { var n = Object.getOwnPropertySymbols(t); e && (n = n.filter((function (e) { return Object.getOwnPropertyDescriptor(t, e).enumerable }))), i.push.apply(i, n) } return i } function i(t) { for (var i = 1; i < arguments.length; i++) { var n = null != arguments[i] ? arguments[i] : {}; i % 2 ? e(Object(n), !0).forEach((function (e) { r(t, e, n[e]) })) : Object.getOwnPropertyDescriptors ? Object.defineProperties(t, Object.getOwnPropertyDescriptors(n)) : e(Object(n)).forEach((function (e) { Object.defineProperty(t, e, Object.getOwnPropertyDescriptor(n, e)) })) } return t } function n(t) { return n = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) { return typeof t } : function (t) { return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t }, n(t) } function o(t, e) { if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function") } function a(t, e) { for (var i = 0; i < e.length; i++) { var n = e[i]; n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(t, n.key, n) } } function s(t, e, i) { return e && a(t.prototype, e), i && a(t, i), Object.defineProperty(t, "prototype", { writable: !1 }), t } function r(t, e, i) { return e in t ? Object.defineProperty(t, e, { value: i, enumerable: !0, configurable: !0, writable: !0 }) : t[e] = i, t } function l(t, e) { if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function"); t.prototype = Object.create(e && e.prototype, { constructor: { value: t, writable: !0, configurable: !0 } }), Object.defineProperty(t, "prototype", { writable: !1 }), e && h(t, e) } function c(t) { return c = Object.setPrototypeOf ? Object.getPrototypeOf : function (t) { return t.__proto__ || Object.getPrototypeOf(t) }, c(t) } function h(t, e) { return h = Object.setPrototypeOf || function (t, e) { return t.__proto__ = e, t }, h(t, e) } function d(t) { if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); return t } function u(t, e) { if (e && ("object" == typeof e || "function" == typeof e)) return e; if (void 0 !== e) throw new TypeError("Derived constructors may only return object or undefined"); return d(t) } function f(t) { var e = function () { if ("undefined" == typeof Reflect || !Reflect.construct) return !1; if (Reflect.construct.sham) return !1; if ("function" == typeof Proxy) return !0; try { return Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], (function () { }))), !0 } catch (t) { return !1 } }(); return function () { var i, n = c(t); if (e) { var o = c(this).constructor; i = Reflect.construct(n, arguments, o) } else i = n.apply(this, arguments); return u(this, i) } } function v(t, e) { for (; !Object.prototype.hasOwnProperty.call(t, e) && null !== (t = c(t));); return t } function p() { return p = "undefined" != typeof Reflect && Reflect.get ? Reflect.get : function (t, e, i) { var n = v(t, e); if (n) { var o = Object.getOwnPropertyDescriptor(n, e); return o.get ? o.get.call(arguments.length < 3 ? t : i) : o.value } }, p.apply(this, arguments) } function g(t, e) { return function (t) { if (Array.isArray(t)) return t }(t) || function (t, e) { var i = null == t ? null : "undefined" != typeof Symbol && t[Symbol.iterator] || t["@@iterator"]; if (null == i) return; var n, o, a = [], s = !0, r = !1; try { for (i = i.call(t); !(s = (n = i.next()).done) && (a.push(n.value), !e || a.length !== e); s = !0); } catch (t) { r = !0, o = t } finally { try { s || null == i.return || i.return() } finally { if (r) throw o } } return a }(t, e) || y(t, e) || function () { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.") }() } function m(t) { return function (t) { if (Array.isArray(t)) return b(t) }(t) || function (t) { if ("undefined" != typeof Symbol && null != t[Symbol.iterator] || null != t["@@iterator"]) return Array.from(t) }(t) || y(t) || function () { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.") }() } function y(t, e) { if (t) { if ("string" == typeof t) return b(t, e); var i = Object.prototype.toString.call(t).slice(8, -1); return "Object" === i && t.constructor && (i = t.constructor.name), "Map" === i || "Set" === i ? Array.from(t) : "Arguments" === i || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(i) ? b(t, e) : void 0 } } function b(t, e) { (null == e || e > t.length) && (e = t.length); for (var i = 0, n = new Array(e); i < e; i++)n[i] = t[i]; return n } function x(t, e) { var i = "undefined" != typeof Symbol && t[Symbol.iterator] || t["@@iterator"]; if (!i) { if (Array.isArray(t) || (i = y(t)) || e && t && "number" == typeof t.length) { i && (t = i); var n = 0, o = function () { }; return { s: o, n: function () { return n >= t.length ? { done: !0 } : { done: !1, value: t[n++] } }, e: function (t) { throw t }, f: o } } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.") } var a, s = !0, r = !1; return { s: function () { i = i.call(t) }, n: function () { var t = i.next(); return s = t.done, t }, e: function (t) { r = !0, a = t }, f: function () { try { s || null == i.return || i.return() } finally { if (r) throw a } } } } var w = function (t) { return "object" === n(t) && null !== t && t.constructor === Object && "[object Object]" === Object.prototype.toString.call(t) }, k = function t() { for (var e = !1, i = arguments.length, o = new Array(i), a = 0; a < i; a++)o[a] = arguments[a]; "boolean" == typeof o[0] && (e = o.shift()); var s = o[0]; if (!s || "object" !== n(s)) throw new Error("extendee must be an object"); for (var r = o.slice(1), l = r.length, c = 0; c < l; c++) { var h = r[c]; for (var d in h) if (h.hasOwnProperty(d)) { var u = h[d]; if (e && (Array.isArray(u) || w(u))) { var f = Array.isArray(u) ? [] : {}; s[d] = t(!0, s.hasOwnProperty(d) ? s[d] : f, u) } else s[d] = u } } return s }, S = function (t) { var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 1e4; return t = parseFloat(t) || 0, Math.round((t + Number.EPSILON) * e) / e }, C = function t(e) { return !!(e && "object" === n(e) && e instanceof Element && e !== document.body) && (!e.__Panzoom && (function (t) { var e = getComputedStyle(t)["overflow-y"], i = getComputedStyle(t)["overflow-x"], n = ("scroll" === e || "auto" === e) && Math.abs(t.scrollHeight - t.clientHeight) > 1, o = ("scroll" === i || "auto" === i) && Math.abs(t.scrollWidth - t.clientWidth) > 1; return n || o }(e) ? e : t(e.parentNode))) }, $ = "undefined" != typeof window && window.ResizeObserver || function () { function t(e) { o(this, t), this.observables = [], this.boundCheck = this.check.bind(this), this.boundCheck(), this.callback = e } return s(t, [{ key: "observe", value: function (t) { if (!this.observables.some((function (e) { return e.el === t }))) { var e = { el: t, size: { height: t.clientHeight, width: t.clientWidth } }; this.observables.push(e) } } }, { key: "unobserve", value: function (t) { this.observables = this.observables.filter((function (e) { return e.el !== t })) } }, { key: "disconnect", value: function () { this.observables = [] } }, { key: "check", value: function () { var t = this.observables.filter((function (t) { var e = t.el.clientHeight, i = t.el.clientWidth; if (t.size.height !== e || t.size.width !== i) return t.size.height = e, t.size.width = i, !0 })).map((function (t) { return t.el })); t.length > 0 && this.callback(t), window.requestAnimationFrame(this.boundCheck) } }]), t }(), E = s((function t(e) { o(this, t), this.id = self.Touch && e instanceof Touch ? e.identifier : -1, this.pageX = e.pageX, this.pageY = e.pageY, this.clientX = e.clientX, this.clientY = e.clientY })), P = function (t, e) { return e ? Math.sqrt(Math.pow(e.clientX - t.clientX, 2) + Math.pow(e.clientY - t.clientY, 2)) : 0 }, T = function (t, e) { return e ? { clientX: (t.clientX + e.clientX) / 2, clientY: (t.clientY + e.clientY) / 2 } : t }, L = function (t) { return "changedTouches" in t }, _ = function () { function t(e) { var i = this, n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}, a = n.start, s = void 0 === a ? function () { return !0 } : a, r = n.move, l = void 0 === r ? function () { } : r, c = n.end, h = void 0 === c ? function () { } : c; o(this, t), this._element = e, this.startPointers = [], this.currentPointers = [], this._pointerStart = function (t) { if (!(t.buttons > 0 && 0 !== t.button)) { var e = new E(t); i.currentPointers.some((function (t) { return t.id === e.id })) || i._triggerPointerStart(e, t) && (window.addEventListener("mousemove", i._move), window.addEventListener("mouseup", i._pointerEnd)) } }, this._touchStart = function (t) { for (var e = 0, n = Array.from(t.changedTouches || []); e < n.length; e++) { var o = n[e]; i._triggerPointerStart(new E(o), t) } }, this._move = function (t) { var e, n = i.currentPointers.slice(), o = L(t) ? Array.from(t.changedTouches).map((function (t) { return new E(t) })) : [new E(t)], a = [], s = x(o); try { var r = function () { var t = e.value, n = i.currentPointers.findIndex((function (e) { return e.id === t.id })); if (n < 0) return "continue"; a.push(t), i.currentPointers[n] = t }; for (s.s(); !(e = s.n()).done;)r() } catch (t) { s.e(t) } finally { s.f() } i._moveCallback(n, i.currentPointers.slice(), t) }, this._triggerPointerEnd = function (t, e) { var n = i.currentPointers.findIndex((function (e) { return e.id === t.id })); return !(n < 0) && (i.currentPointers.splice(n, 1), i.startPointers.splice(n, 1), i._endCallback(t, e), !0) }, this._pointerEnd = function (t) { t.buttons > 0 && 0 !== t.button || i._triggerPointerEnd(new E(t), t) && (window.removeEventListener("mousemove", i._move, { passive: !1 }), window.removeEventListener("mouseup", i._pointerEnd, { passive: !1 })) }, this._touchEnd = function (t) { for (var e = 0, n = Array.from(t.changedTouches || []); e < n.length; e++) { var o = n[e]; i._triggerPointerEnd(new E(o), t) } }, this._startCallback = s, this._moveCallback = l, this._endCallback = h, this._element.addEventListener("mousedown", this._pointerStart, { passive: !1 }), this._element.addEventListener("touchstart", this._touchStart, { passive: !1 }), this._element.addEventListener("touchmove", this._move, { passive: !1 }), this._element.addEventListener("touchend", this._touchEnd), this._element.addEventListener("touchcancel", this._touchEnd) } return s(t, [{ key: "stop", value: function () { this._element.removeEventListener("mousedown", this._pointerStart, { passive: !1 }), this._element.removeEventListener("touchstart", this._touchStart, { passive: !1 }), this._element.removeEventListener("touchmove", this._move, { passive: !1 }), this._element.removeEventListener("touchend", this._touchEnd), this._element.removeEventListener("touchcancel", this._touchEnd), window.removeEventListener("mousemove", this._move), window.removeEventListener("mouseup", this._pointerEnd) } }, { key: "_triggerPointerStart", value: function (t, e) { return !!this._startCallback(t, e) && (this.currentPointers.push(t), this.startPointers.push(t), !0) } }]), t }(), A = function (t, e) { return t.split(".").reduce((function (t, e) { return t && t[e] }), e) }, O = function () { function t() { var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {}; o(this, t), this.options = k(!0, {}, e), this.plugins = [], this.events = {}; for (var i = 0, n = ["on", "once"]; i < n.length; i++)for (var a = n[i], s = 0, r = Object.entries(this.options[a] || {}); s < r.length; s++) { var l = r[s]; this[a].apply(this, m(l)) } } return s(t, [{ key: "option", value: function (t, e) { t = String(t); var i = A(t, this.options); if ("function" == typeof i) { for (var n, o = arguments.length, a = new Array(o > 2 ? o - 2 : 0), s = 2; s < o; s++)a[s - 2] = arguments[s]; i = (n = i).call.apply(n, [this, this].concat(a)) } return void 0 === i ? e : i } }, { key: "localize", value: function (t) { var e = this, i = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : []; return t = (t = String(t).replace(/\{\{(\w+).?(\w+)?\}\}/g, (function (t, n, o) { var a = ""; o ? a = e.option("".concat(n[0] + n.toLowerCase().substring(1), ".l10n.").concat(o)) : n && (a = e.option("l10n.".concat(n))), a || (a = t); for (var s = 0; s < i.length; s++)a = a.split(i[s][0]).join(i[s][1]); return a }))).replace(/\{\{(.*)\}\}/, (function (t, e) { return e })) } }, { key: "on", value: function (t, e) { var i = this; if (w(t)) { for (var n = 0, o = Object.entries(t); n < o.length; n++) { var a = o[n]; this.on.apply(this, m(a)) } return this } return String(t).split(" ").forEach((function (t) { var n = i.events[t] = i.events[t] || []; -1 == n.indexOf(e) && n.push(e) })), this } }, { key: "once", value: function (t, e) { var i = this; if (w(t)) { for (var n = 0, o = Object.entries(t); n < o.length; n++) { var a = o[n]; this.once.apply(this, m(a)) } return this } return String(t).split(" ").forEach((function (t) { var n = function n() { i.off(t, n); for (var o = arguments.length, a = new Array(o), s = 0; s < o; s++)a[s] = arguments[s]; e.call.apply(e, [i, i].concat(a)) }; n._ = e, i.on(t, n) })), this } }, { key: "off", value: function (t, e) { var i = this; if (!w(t)) return t.split(" ").forEach((function (t) { var n = i.events[t]; if (!n || !n.length) return i; for (var o = -1, a = 0, s = n.length; a < s; a++) { var r = n[a]; if (r && (r === e || r._ === e)) { o = a; break } } -1 != o && n.splice(o, 1) })), this; for (var n = 0, o = Object.entries(t); n < o.length; n++) { var a = o[n]; this.off.apply(this, m(a)) } } }, { key: "trigger", value: function (t) { for (var e = arguments.length, i = new Array(e > 1 ? e - 1 : 0), n = 1; n < e; n++)i[n - 1] = arguments[n]; var o, a = x(m(this.events[t] || []).slice()); try { for (a.s(); !(o = a.n()).done;) { var s = o.value; if (s && !1 === s.call.apply(s, [this, this].concat(i))) return !1 } } catch (t) { a.e(t) } finally { a.f() } var r, l = x(m(this.events["*"] || []).slice()); try { for (l.s(); !(r = l.n()).done;) { var c = r.value; if (c && !1 === c.call.apply(c, [this, t, this].concat(i))) return !1 } } catch (t) { l.e(t) } finally { l.f() } return !0 } }, { key: "attachPlugins", value: function (t) { for (var e = {}, i = 0, n = Object.entries(t || {}); i < n.length; i++) { var o = g(n[i], 2), a = o[0], s = o[1]; !1 === this.options[a] || this.plugins[a] || (this.options[a] = k({}, s.defaults || {}, this.options[a]), e[a] = new s(this)) } for (var r = 0, l = Object.entries(e); r < l.length; r++) { var c = g(l[r], 2); c[0], c[1].attach(this) } return this.plugins = Object.assign({}, this.plugins, e), this } }, { key: "detachPlugins", value: function () { for (var t in this.plugins) { var e = void 0; (e = this.plugins[t]) && "function" == typeof e.detach && e.detach(this) } return this.plugins = {}, this } }]), t }(), z = { touch: !0, zoom: !0, pinchToZoom: !0, panOnlyZoomed: !1, lockAxis: !1, friction: .64, decelFriction: .88, zoomFriction: .74, bounceForce: .2, baseScale: 1, minScale: 1, maxScale: 2, step: .5, textSelection: !1, click: "toggleZoom", wheel: "zoom", wheelFactor: 42, wheelLimit: 5, draggableClass: "is-draggable", draggingClass: "is-dragging", ratio: 1 }, M = function (t) { l(n, t); var e = f(n); function n(t) { var i, a = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}; o(this, n), (i = e.call(this, k(!0, {}, z, a))).state = "init", i.$container = t; for (var s = 0, r = ["onLoad", "onWheel", "onClick"]; s < r.length; s++) { var l = r[s]; i[l] = i[l].bind(d(i)) } return i.initLayout(), i.resetValues(), i.attachPlugins(n.Plugins), i.trigger("init"), i.updateMetrics(), i.attachEvents(), i.trigger("ready"), !1 === i.option("centerOnStart") ? i.state = "ready" : i.panTo({ friction: 0 }), t.__Panzoom = d(i), i } return s(n, [{ key: "initLayout", value: function () { var t = this.$container; if (!(t instanceof HTMLElement)) throw new Error("Panzoom: Container not found"); var e = this.option("content") || t.querySelector(".panzoom__content"); if (!e) throw new Error("Panzoom: Content not found"); this.$content = e; var i, n = this.option("viewport") || t.querySelector(".panzoom__viewport"); n || !1 === this.option("wrapInner") || ((n = document.createElement("div")).classList.add("panzoom__viewport"), (i = n).append.apply(i, m(t.childNodes)), t.appendChild(n)); this.$viewport = n || e.parentNode } }, { key: "resetValues", value: function () { this.updateRate = this.option("updateRate", /iPhone|iPad|iPod|Android/i.test(navigator.userAgent) ? 250 : 24), this.container = { width: 0, height: 0 }, this.viewport = { width: 0, height: 0 }, this.content = { origWidth: 0, origHeight: 0, width: 0, height: 0, x: this.option("x", 0), y: this.option("y", 0), scale: this.option("baseScale") }, this.transform = { x: 0, y: 0, scale: 1 }, this.resetDragPosition() } }, { key: "onLoad", value: function (t) { this.updateMetrics(), this.panTo({ scale: this.option("baseScale"), friction: 0 }), this.trigger("load", t) } }, { key: "onClick", value: function (t) { if (!(t.defaultPrevented || document.activeElement && document.activeElement.closest("[contenteditable]"))) if (!this.option("textSelection") || !window.getSelection().toString().length || t.target && t.target.hasAttribute("data-fancybox-close")) { var e = this.$content.getClientRects()[0]; if ("ready" !== this.state && (this.dragPosition.midPoint || Math.abs(e.top - this.dragStart.rect.top) > 1 || Math.abs(e.left - this.dragStart.rect.left) > 1)) return t.preventDefault(), void t.stopPropagation(); !1 !== this.trigger("click", t) && this.option("zoom") && "toggleZoom" === this.option("click") && (t.preventDefault(), t.stopPropagation(), this.zoomWithClick(t)) } else t.stopPropagation() } }, { key: "onWheel", value: function (t) { !1 !== this.trigger("wheel", t) && this.option("zoom") && this.option("wheel") && this.zoomWithWheel(t) } }, { key: "zoomWithWheel", value: function (t) { void 0 === this.changedDelta && (this.changedDelta = 0); var e = Math.max(-1, Math.min(1, -t.deltaY || -t.deltaX || t.wheelDelta || -t.detail)), i = this.content.scale, n = i * (100 + e * this.option("wheelFactor")) / 100; if (e < 0 && Math.abs(i - this.option("minScale")) < .01 || e > 0 && Math.abs(i - this.option("maxScale")) < .01 ? (this.changedDelta += Math.abs(e), n = i) : (this.changedDelta = 0, n = Math.max(Math.min(n, this.option("maxScale")), this.option("minScale"))), !(this.changedDelta > this.option("wheelLimit")) && (t.preventDefault(), n !== i)) { var o = this.$content.getBoundingClientRect(), a = t.clientX - o.left, s = t.clientY - o.top; this.zoomTo(n, { x: a, y: s }) } } }, { key: "zoomWithClick", value: function (t) { var e = this.$content.getClientRects()[0], i = t.clientX - e.left, n = t.clientY - e.top; this.toggleZoom({ x: i, y: n }) } }, { key: "attachEvents", value: function () { var t = this; this.$content.addEventListener("load", this.onLoad), this.$container.addEventListener("wheel", this.onWheel, { passive: !1 }), this.$container.addEventListener("click", this.onClick, { passive: !1 }), this.initObserver(); var e = new _(this.$container, { start: function (i, n) { if (!t.option("touch")) return !1; if (t.velocity.scale < 0) return !1; var o = n.composedPath()[0]; if (!e.currentPointers.length) { if (-1 !== ["BUTTON", "TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO"].indexOf(o.nodeName)) return !1; if (t.option("textSelection") && function (t, e, i) { for (var n = t.childNodes, o = document.createRange(), a = 0; a < n.length; a++) { var s = n[a]; if (s.nodeType === Node.TEXT_NODE) { o.selectNodeContents(s); var r = o.getBoundingClientRect(); if (e >= r.left && i >= r.top && e <= r.right && i <= r.bottom) return s } } return !1 }(o, i.clientX, i.clientY)) return !1 } return !C(o) && (!1 !== t.trigger("touchStart", n) && ("mousedown" === n.type && n.preventDefault(), t.state = "pointerdown", t.resetDragPosition(), t.dragPosition.midPoint = null, t.dragPosition.time = Date.now(), !0)) }, move: function (i, n, o) { if ("pointerdown" === t.state) if (!1 !== t.trigger("touchMove", o)) { if (!(n.length < 2 && !0 === t.option("panOnlyZoomed") && t.content.width <= t.viewport.width && t.content.height <= t.viewport.height && t.transform.scale <= t.option("baseScale")) && (!(n.length > 1) || t.option("zoom") && !1 !== t.option("pinchToZoom"))) { var a = T(i[0], i[1]), s = T(n[0], n[1]), r = s.clientX - a.clientX, l = s.clientY - a.clientY, c = P(i[0], i[1]), h = P(n[0], n[1]), d = c && h ? h / c : 1; t.dragOffset.x += r, t.dragOffset.y += l, t.dragOffset.scale *= d, t.dragOffset.time = Date.now() - t.dragPosition.time; var u = 1 === t.dragStart.scale && t.option("lockAxis"); if (u && !t.lockAxis) { if (Math.abs(t.dragOffset.x) < 6 && Math.abs(t.dragOffset.y) < 6) return void o.preventDefault(); var f = Math.abs(180 * Math.atan2(t.dragOffset.y, t.dragOffset.x) / Math.PI); t.lockAxis = f > 45 && f < 135 ? "y" : "x" } if ("xy" === u || "y" !== t.lockAxis) { if (o.preventDefault(), o.stopPropagation(), o.stopImmediatePropagation(), t.lockAxis && (t.dragOffset["x" === t.lockAxis ? "y" : "x"] = 0), t.$container.classList.add(t.option("draggingClass")), t.transform.scale === t.option("baseScale") && "y" === t.lockAxis || (t.dragPosition.x = t.dragStart.x + t.dragOffset.x), t.transform.scale === t.option("baseScale") && "x" === t.lockAxis || (t.dragPosition.y = t.dragStart.y + t.dragOffset.y), t.dragPosition.scale = t.dragStart.scale * t.dragOffset.scale, n.length > 1) { var v = T(e.startPointers[0], e.startPointers[1]), p = v.clientX - t.dragStart.rect.x, g = v.clientY - t.dragStart.rect.y, m = t.getZoomDelta(t.content.scale * t.dragOffset.scale, p, g), y = m.deltaX, b = m.deltaY; t.dragPosition.x -= y, t.dragPosition.y -= b, t.dragPosition.midPoint = s } else t.setDragResistance(); t.transform = { x: t.dragPosition.x, y: t.dragPosition.y, scale: t.dragPosition.scale }, t.startAnimation() } } } else o.preventDefault() }, end: function (n, o) { if ("pointerdown" === t.state) if (t._dragOffset = i({}, t.dragOffset), e.currentPointers.length) t.resetDragPosition(); else if (t.state = "decel", t.friction = t.option("decelFriction"), t.recalculateTransform(), t.$container.classList.remove(t.option("draggingClass")), !1 !== t.trigger("touchEnd", o) && "decel" === t.state) { var a = t.option("minScale"); if (t.transform.scale < a) t.zoomTo(a, { friction: .64 }); else { var s = t.option("maxScale"); if (t.transform.scale - s > .01) { var r = t.dragPosition.midPoint || n, l = t.$content.getClientRects()[0]; t.zoomTo(s, { friction: .64, x: r.clientX - l.left, y: r.clientY - l.top }) } else; } } } }); this.pointerTracker = e } }, { key: "initObserver", value: function () { var t = this; this.resizeObserver || (this.resizeObserver = new $((function () { t.updateTimer || (t.updateTimer = setTimeout((function () { var e = t.$container.getBoundingClientRect(); e.width && e.height ? ((Math.abs(e.width - t.container.width) > 1 || Math.abs(e.height - t.container.height) > 1) && (t.isAnimating() && t.endAnimation(!0), t.updateMetrics(), t.panTo({ x: t.content.x, y: t.content.y, scale: t.option("baseScale"), friction: 0 })), t.updateTimer = null) : t.updateTimer = null }), t.updateRate)) })), this.resizeObserver.observe(this.$container)) } }, { key: "resetDragPosition", value: function () { this.lockAxis = null, this.friction = this.option("friction"), this.velocity = { x: 0, y: 0, scale: 0 }; var t = this.content, e = t.x, n = t.y, o = t.scale; this.dragStart = { rect: this.$content.getBoundingClientRect(), x: e, y: n, scale: o }, this.dragPosition = i(i({}, this.dragPosition), {}, { x: e, y: n, scale: o }), this.dragOffset = { x: 0, y: 0, scale: 1, time: 0 } } }, { key: "updateMetrics", value: function (t) { !0 !== t && this.trigger("beforeUpdate"); var e, n = this.$container, o = this.$content, a = this.$viewport, s = o instanceof HTMLImageElement, r = this.option("zoom"), l = this.option("resizeParent", r), c = this.option("width"), h = this.option("height"), d = c || (e = o, Math.max(parseFloat(e.naturalWidth || 0), parseFloat(e.width && e.width.baseVal && e.width.baseVal.value || 0), parseFloat(e.offsetWidth || 0), parseFloat(e.scrollWidth || 0))), u = h || function (t) { return Math.max(parseFloat(t.naturalHeight || 0), parseFloat(t.height && t.height.baseVal && t.height.baseVal.value || 0), parseFloat(t.offsetHeight || 0), parseFloat(t.scrollHeight || 0)) }(o); Object.assign(o.style, { width: c ? "".concat(c, "px") : "", height: h ? "".concat(h, "px") : "", maxWidth: "", maxHeight: "" }), l && Object.assign(a.style, { width: "", height: "" }); var f = this.option("ratio"); c = d = S(d * f), h = u = S(u * f); var v = o.getBoundingClientRect(), p = a.getBoundingClientRect(), g = a == n ? p : n.getBoundingClientRect(), m = Math.max(a.offsetWidth, S(p.width)), y = Math.max(a.offsetHeight, S(p.height)), b = window.getComputedStyle(a); if (m -= parseFloat(b.paddingLeft) + parseFloat(b.paddingRight), y -= parseFloat(b.paddingTop) + parseFloat(b.paddingBottom), this.viewport.width = m, this.viewport.height = y, r) { if (Math.abs(d - v.width) > .1 || Math.abs(u - v.height) > .1) { var x = function (t, e, i, n) { var o = Math.min(i / t || 0, n / e); return { width: t * o || 0, height: e * o || 0 } }(d, u, Math.min(d, v.width), Math.min(u, v.height)); c = S(x.width), h = S(x.height) } Object.assign(o.style, { width: "".concat(c, "px"), height: "".concat(h, "px"), transform: "" }) } if (l && (Object.assign(a.style, { width: "".concat(c, "px"), height: "".concat(h, "px") }), this.viewport = i(i({}, this.viewport), {}, { width: c, height: h })), s && r && "function" != typeof this.options.maxScale) { var w = this.option("maxScale"); this.options.maxScale = function () { return this.content.origWidth > 0 && this.content.fitWidth > 0 ? this.content.origWidth / this.content.fitWidth : w } } this.content = i(i({}, this.content), {}, { origWidth: d, origHeight: u, fitWidth: c, fitHeight: h, width: c, height: h, scale: 1, isZoomable: r }), this.container = { width: g.width, height: g.height }, !0 !== t && this.trigger("afterUpdate") } }, { key: "zoomIn", value: function (t) { this.zoomTo(this.content.scale + (t || this.option("step"))) } }, { key: "zoomOut", value: function (t) { this.zoomTo(this.content.scale - (t || this.option("step"))) } }, { key: "toggleZoom", value: function () { var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {}, e = this.option("maxScale"), i = this.option("baseScale"), n = this.content.scale > i + .5 * (e - i) ? i : e; this.zoomTo(n, t) } }, { key: "zoomTo", value: function () { var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : this.option("baseScale"), e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}, i = e.x, n = void 0 === i ? null : i, o = e.y, a = void 0 === o ? null : o; t = Math.max(Math.min(t, this.option("maxScale")), this.option("minScale")); var s = S(this.content.scale / (this.content.width / this.content.fitWidth), 1e7); null === n && (n = this.content.width * s * .5), null === a && (a = this.content.height * s * .5); var r = this.getZoomDelta(t, n, a), l = r.deltaX, c = r.deltaY; n = this.content.x - l, a = this.content.y - c, this.panTo({ x: n, y: a, scale: t, friction: this.option("zoomFriction") }) } }, { key: "getZoomDelta", value: function (t) { var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 0, i = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 0, n = this.content.fitWidth * this.content.scale, o = this.content.fitHeight * this.content.scale, a = e > 0 && n ? e / n : 0, s = i > 0 && o ? i / o : 0, r = this.content.fitWidth * t, l = this.content.fitHeight * t, c = (r - n) * a, h = (l - o) * s; return { deltaX: c, deltaY: h } } }, { key: "panTo", value: function () { var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {}, e = t.x, n = void 0 === e ? this.content.x : e, o = t.y, a = void 0 === o ? this.content.y : o, s = t.scale, r = t.friction, l = void 0 === r ? this.option("friction") : r, c = t.ignoreBounds, h = void 0 !== c && c; if (s = s || this.content.scale || 1, !h) { var d = this.getBounds(s), u = d.boundX, f = d.boundY; u && (n = Math.max(Math.min(n, u.to), u.from)), f && (a = Math.max(Math.min(a, f.to), f.from)) } this.friction = l, this.transform = i(i({}, this.transform), {}, { x: n, y: a, scale: s }), l ? (this.state = "panning", this.velocity = { x: (1 / this.friction - 1) * (n - this.content.x), y: (1 / this.friction - 1) * (a - this.content.y), scale: (1 / this.friction - 1) * (s - this.content.scale) }, this.startAnimation()) : this.endAnimation() } }, { key: "startAnimation", value: function () { var t = this; this.rAF ? cancelAnimationFrame(this.rAF) : this.trigger("startAnimation"), this.rAF = requestAnimationFrame((function () { return t.animate() })) } }, { key: "animate", value: function () { var t = this; if (this.setEdgeForce(), this.setDragForce(), this.velocity.x *= this.friction, this.velocity.y *= this.friction, this.velocity.scale *= this.friction, this.content.x += this.velocity.x, this.content.y += this.velocity.y, this.content.scale += this.velocity.scale, this.isAnimating()) this.setTransform(); else if ("pointerdown" !== this.state) return void this.endAnimation(); this.rAF = requestAnimationFrame((function () { return t.animate() })) } }, { key: "getBounds", value: function (t) { var e = this.boundX, i = this.boundY; if (void 0 !== e && void 0 !== i) return { boundX: e, boundY: i }; e = { from: 0, to: 0 }, i = { from: 0, to: 0 }, t = t || this.transform.scale; var n = this.content.fitWidth * t, o = this.content.fitHeight * t, a = this.viewport.width, s = this.viewport.height; if (n < a) { var r = S(.5 * (a - n)); e.from = r, e.to = r } else e.from = S(a - n); if (o < s) { var l = .5 * (s - o); i.from = l, i.to = l } else i.from = S(s - o); return { boundX: e, boundY: i } } }, { key: "setEdgeForce", value: function () { if ("decel" === this.state) { var t, e, i, n, o = this.option("bounceForce"), a = this.getBounds(Math.max(this.transform.scale, this.content.scale)), s = a.boundX, r = a.boundY; if (s && (t = this.content.x < s.from, e = this.content.x > s.to), r && (i = this.content.y < r.from, n = this.content.y > r.to), t || e) { var l = ((t ? s.from : s.to) - this.content.x) * o, c = this.content.x + (this.velocity.x + l) / this.friction; c >= s.from && c <= s.to && (l += this.velocity.x), this.velocity.x = l, this.recalculateTransform() } if (i || n) { var h = ((i ? r.from : r.to) - this.content.y) * o, d = this.content.y + (h + this.velocity.y) / this.friction; d >= r.from && d <= r.to && (h += this.velocity.y), this.velocity.y = h, this.recalculateTransform() } } } }, { key: "setDragResistance", value: function () { if ("pointerdown" === this.state) { var t, e, i, n, o = this.getBounds(this.dragPosition.scale), a = o.boundX, s = o.boundY; if (a && (t = this.dragPosition.x < a.from, e = this.dragPosition.x > a.to), s && (i = this.dragPosition.y < s.from, n = this.dragPosition.y > s.to), (t || e) && (!t || !e)) { var r = t ? a.from : a.to, l = r - this.dragPosition.x; this.dragPosition.x = r - .3 * l } if ((i || n) && (!i || !n)) { var c = i ? s.from : s.to, h = c - this.dragPosition.y; this.dragPosition.y = c - .3 * h } } } }, { key: "setDragForce", value: function () { "pointerdown" === this.state && (this.velocity.x = this.dragPosition.x - this.content.x, this.velocity.y = this.dragPosition.y - this.content.y, this.velocity.scale = this.dragPosition.scale - this.content.scale) } }, { key: "recalculateTransform", value: function () { this.transform.x = this.content.x + this.velocity.x / (1 / this.friction - 1), this.transform.y = this.content.y + this.velocity.y / (1 / this.friction - 1), this.transform.scale = this.content.scale + this.velocity.scale / (1 / this.friction - 1) } }, { key: "isAnimating", value: function () { return !(!this.friction || !(Math.abs(this.velocity.x) > .05 || Math.abs(this.velocity.y) > .05 || Math.abs(this.velocity.scale) > .05)) } }, { key: "setTransform", value: function (t) { var e, n, o, a, s; (t ? (e = S(this.transform.x), n = S(this.transform.y), o = this.transform.scale, this.content = i(i({}, this.content), {}, { x: e, y: n, scale: o })) : (e = S(this.content.x), n = S(this.content.y), o = this.content.scale / (this.content.width / this.content.fitWidth), this.content = i(i({}, this.content), {}, { x: e, y: n })), this.trigger("beforeTransform"), e = S(this.content.x), n = S(this.content.y), t && this.option("zoom")) ? (a = S(this.content.fitWidth * o), s = S(this.content.fitHeight * o), this.content.width = a, this.content.height = s, this.transform = i(i({}, this.transform), {}, { width: a, height: s, scale: o }), Object.assign(this.$content.style, { width: "".concat(a, "px"), height: "".concat(s, "px"), maxWidth: "none", maxHeight: "none", transform: "translate3d(".concat(e, "px, ").concat(n, "px, 0) scale(1)") })) : this.$content.style.transform = "translate3d(".concat(e, "px, ").concat(n, "px, 0) scale(").concat(o, ")"); this.trigger("afterTransform") } }, { key: "endAnimation", value: function (t) { cancelAnimationFrame(this.rAF), this.rAF = null, this.velocity = { x: 0, y: 0, scale: 0 }, this.setTransform(!0), this.state = "ready", this.handleCursor(), !0 !== t && this.trigger("endAnimation") } }, { key: "handleCursor", value: function () { var t = this.option("draggableClass"); t && this.option("touch") && (1 == this.option("panOnlyZoomed") && this.content.width <= this.viewport.width && this.content.height <= this.viewport.height && this.transform.scale <= this.option("baseScale") ? this.$container.classList.remove(t) : this.$container.classList.add(t)) } }, { key: "detachEvents", value: function () { this.$content.removeEventListener("load", this.onLoad), this.$container.removeEventListener("wheel", this.onWheel, { passive: !1 }), this.$container.removeEventListener("click", this.onClick, { passive: !1 }), this.pointerTracker && (this.pointerTracker.stop(), this.pointerTracker = null), this.resizeObserver && (this.resizeObserver.disconnect(), this.resizeObserver = null) } }, { key: "destroy", value: function () { "destroy" !== this.state && (this.state = "destroy", clearTimeout(this.updateTimer), this.updateTimer = null, cancelAnimationFrame(this.rAF), this.rAF = null, this.detachEvents(), this.detachPlugins(), this.resetDragPosition()) } }]), n }(O); M.version = "4.0.31", M.Plugins = {}; var I = function (t, e) { var i = 0; return function () { var n = (new Date).getTime(); if (!(n - i < e)) return i = n, t.apply(void 0, arguments) } }, R = function () { function t(e) { o(this, t), this.$container = null, this.$prev = null, this.$next = null, this.carousel = e, this.onRefresh = this.onRefresh.bind(this) } return s(t, [{ key: "option", value: function (t) { return this.carousel.option("Navigation.".concat(t)) } }, { key: "createButton", value: function (t) { var e, i = this, n = document.createElement("button"); n.setAttribute("title", this.carousel.localize("{{".concat(t.toUpperCase(), "}}"))); var o = this.option("classNames.button") + " " + this.option("classNames.".concat(t)); return (e = n.classList).add.apply(e, m(o.split(" "))), n.setAttribute("tabindex", "0"), n.innerHTML = this.carousel.localize(this.option("".concat(t, "Tpl"))), n.addEventListener("click", (function (e) { e.preventDefault(), e.stopPropagation(), i.carousel["slide".concat("next" === t ? "Next" : "Prev")]() })), n } }, { key: "build", value: function () { var t; this.$container || (this.$container = document.createElement("div"), (t = this.$container.classList).add.apply(t, m(this.option("classNames.main").split(" "))), this.carousel.$container.appendChild(this.$container)); this.$next || (this.$next = this.createButton("next"), this.$container.appendChild(this.$next)), this.$prev || (this.$prev = this.createButton("prev"), this.$container.appendChild(this.$prev)) } }, { key: "onRefresh", value: function () { var t = this.carousel.pages.length; t <= 1 || t > 1 && this.carousel.elemDimWidth < this.carousel.wrapDimWidth && !Number.isInteger(this.carousel.option("slidesPerPage")) ? this.cleanup() : (this.build(), this.$prev.removeAttribute("disabled"), this.$next.removeAttribute("disabled"), this.carousel.option("infiniteX", this.carousel.option("infinite")) || (this.carousel.page <= 0 && this.$prev.setAttribute("disabled", ""), this.carousel.page >= t - 1 && this.$next.setAttribute("disabled", ""))) } }, { key: "cleanup", value: function () { this.$prev && this.$prev.remove(), this.$prev = null, this.$next && this.$next.remove(), this.$next = null, this.$container && this.$container.remove(), this.$container = null } }, { key: "attach", value: function () { this.carousel.on("refresh change", this.onRefresh) } }, { key: "detach", value: function () { this.carousel.off("refresh change", this.onRefresh), this.cleanup() } }]), t }(); R.defaults = { prevTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M15 3l-9 9 9 9"/></svg>', nextTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M9 3l9 9-9 9"/></svg>', classNames: { main: "carousel__nav", button: "carousel__button", next: "is-next", prev: "is-prev" } }; var F = function () { function t(e) { o(this, t), this.carousel = e, this.$list = null, this.events = { change: this.onChange.bind(this), refresh: this.onRefresh.bind(this) } } return s(t, [{ key: "buildList", value: function () { var t = this; if (!(this.carousel.pages.length < this.carousel.option("Dots.minSlideCount"))) { var e = document.createElement("ol"); return e.classList.add("carousel__dots"), e.addEventListener("click", (function (e) { if ("page" in e.target.dataset) { e.preventDefault(), e.stopPropagation(); var i = parseInt(e.target.dataset.page, 10), n = t.carousel; i !== n.page && (n.pages.length < 3 && n.option("infinite") ? n[0 == i ? "slidePrev" : "slideNext"]() : n.slideTo(i)) } })), this.$list = e, this.carousel.$container.appendChild(e), this.carousel.$container.classList.add("has-dots"), e } } }, { key: "removeList", value: function () { this.$list && (this.$list.parentNode.removeChild(this.$list), this.$list = null), this.carousel.$container.classList.remove("has-dots") } }, { key: "rebuildDots", value: function () { var t = this, e = this.$list, i = !!e, n = this.carousel.pages.length; if (n < 2) i && this.removeList(); else { i || (e = this.buildList()); var o = this.$list.children.length; if (o > n) for (var a = n; a < o; a++)this.$list.removeChild(this.$list.lastChild); else { for (var s = function (e) { var i = document.createElement("li"); i.classList.add("carousel__dot"), i.dataset.page = e, i.setAttribute("role", "button"), i.setAttribute("tabindex", "0"), i.setAttribute("title", t.carousel.localize("{{GOTO}}", [["%d", e + 1]])), i.addEventListener("keydown", (function (t) { var e, n = t.code; "Enter" === n || "NumpadEnter" === n ? e = i : "ArrowRight" === n ? e = i.nextSibling : "ArrowLeft" === n && (e = i.previousSibling), e && e.click() })), t.$list.appendChild(i) }, r = o; r < n; r++)s(r); this.setActiveDot() } } } }, { key: "setActiveDot", value: function () { if (this.$list) { this.$list.childNodes.forEach((function (t) { t.classList.remove("is-selected") })); var t = this.$list.childNodes[this.carousel.page]; t && t.classList.add("is-selected") } } }, { key: "onChange", value: function () { this.setActiveDot() } }, { key: "onRefresh", value: function () { this.rebuildDots() } }, { key: "attach", value: function () { this.carousel.on(this.events) } }, { key: "detach", value: function () { this.removeList(), this.carousel.off(this.events), this.carousel = null } }]), t }(), N = function () { function t(e) { o(this, t), this.carousel = e, this.selectedIndex = null, this.friction = 0, this.onNavReady = this.onNavReady.bind(this), this.onNavClick = this.onNavClick.bind(this), this.onNavCreateSlide = this.onNavCreateSlide.bind(this), this.onTargetChange = this.onTargetChange.bind(this) } return s(t, [{ key: "addAsTargetFor", value: function (t) { this.target = this.carousel, this.nav = t, this.attachEvents() } }, { key: "addAsNavFor", value: function (t) { this.target = t, this.nav = this.carousel, this.attachEvents() } }, { key: "attachEvents", value: function () { this.nav.options.initialSlide = this.target.options.initialPage, this.nav.on("ready", this.onNavReady), this.nav.on("createSlide", this.onNavCreateSlide), this.nav.on("Panzoom.click", this.onNavClick), this.target.on("change", this.onTargetChange), this.target.on("Panzoom.afterUpdate", this.onTargetChange) } }, { key: "onNavReady", value: function () { this.onTargetChange(!0) } }, { key: "onNavClick", value: function (t, e, i) { var n = i.target.closest(".carousel__slide"); if (n) { i.stopPropagation(); var o = parseInt(n.dataset.index, 10), a = this.target.findPageForSlide(o); this.target.page !== a && this.target.slideTo(a, { friction: this.friction }), this.markSelectedSlide(o) } } }, { key: "onNavCreateSlide", value: function (t, e) { e.index === this.selectedIndex && this.markSelectedSlide(e.index) } }, { key: "onTargetChange", value: function () { var t = this.target.pages[this.target.page].indexes[0], e = this.nav.findPageForSlide(t); this.nav.slideTo(e), this.markSelectedSlide(t) } }, { key: "markSelectedSlide", value: function (t) { this.selectedIndex = t, m(this.nav.slides).filter((function (t) { return t.$el && t.$el.classList.remove("is-nav-selected") })); var e = this.nav.slides[t]; e && e.$el && e.$el.classList.add("is-nav-selected") } }, { key: "attach", value: function (t) { var e = t.options.Sync; (e.target || e.nav) && (e.target ? this.addAsNavFor(e.target) : e.nav && this.addAsTargetFor(e.nav), this.friction = e.friction) } }, { key: "detach", value: function () { this.nav && (this.nav.off("ready", this.onNavReady), this.nav.off("Panzoom.click", this.onNavClick), this.nav.off("createSlide", this.onNavCreateSlide)), this.target && (this.target.off("Panzoom.afterUpdate", this.onTargetChange), this.target.off("change", this.onTargetChange)) } }]), t }(); N.defaults = { friction: .92 }; var D = { Navigation: R, Dots: F, Sync: N }, B = { slides: [], preload: 0, slidesPerPage: "auto", initialPage: null, initialSlide: null, friction: .92, center: !0, infinite: !0, fill: !0, dragFree: !1, prefix: "", classNames: { viewport: "carousel__viewport", track: "carousel__track", slide: "carousel__slide", slideSelected: "is-selected" }, l10n: { NEXT: "Next slide", PREV: "Previous slide", GOTO: "Go to slide #%d" } }, H = function (t) { l(n, t); var e = f(n); function n(t) { var i, a = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}; if (o(this, n), a = k(!0, {}, B, a), (i = e.call(this, a)).state = "init", i.$container = t, !(i.$container instanceof HTMLElement)) throw new Error("No root element provided"); return i.slideNext = I(i.slideNext.bind(d(i)), 250), i.slidePrev = I(i.slidePrev.bind(d(i)), 250), i.init(), t.__Carousel = d(i), i } return s(n, [{ key: "init", value: function () { this.pages = [], this.page = this.pageIndex = null, this.prevPage = this.prevPageIndex = null, this.attachPlugins(n.Plugins), this.trigger("init"), this.initLayout(), this.initSlides(), this.updateMetrics(), this.$track && this.pages.length && (this.$track.style.transform = "translate3d(".concat(-1 * this.pages[this.page].left, "px, 0px, 0) scale(1)")), this.manageSlideVisiblity(), this.initPanzoom(), this.state = "ready", this.trigger("ready") } }, { key: "initLayout", value: function () { var t, e, i, n, o = this.option("prefix"), a = this.option("classNames"); (this.$viewport = this.option("viewport") || this.$container.querySelector(".".concat(o).concat(a.viewport)), this.$viewport) || (this.$viewport = document.createElement("div"), (t = this.$viewport.classList).add.apply(t, m((o + a.viewport).split(" "))), (e = this.$viewport).append.apply(e, m(this.$container.childNodes)), this.$container.appendChild(this.$viewport)); (this.$track = this.option("track") || this.$container.querySelector(".".concat(o).concat(a.track)), this.$track) || (this.$track = document.createElement("div"), (i = this.$track.classList).add.apply(i, m((o + a.track).split(" "))), (n = this.$track).append.apply(n, m(this.$viewport.childNodes)), this.$viewport.appendChild(this.$track)) } }, { key: "initSlides", value: function () { var t = this; this.slides = [], this.$viewport.querySelectorAll(".".concat(this.option("prefix")).concat(this.option("classNames.slide"))).forEach((function (e) { var i = { $el: e, isDom: !0 }; t.slides.push(i), t.trigger("createSlide", i, t.slides.length) })), Array.isArray(this.options.slides) && (this.slides = k(!0, m(this.slides), this.options.slides)) } }, { key: "updateMetrics", value: function () { var t, e = this, n = 0, o = []; this.slides.forEach((function (i, a) { var s = i.$el, r = i.isDom || !t ? e.getSlideMetrics(s) : t; i.index = a, i.width = r, i.left = n, t = r, n += r, o.push(a) })); var a = Math.max(this.$track.offsetWidth, S(this.$track.getBoundingClientRect().width)), s = getComputedStyle(this.$track); a -= parseFloat(s.paddingLeft) + parseFloat(s.paddingRight), this.contentWidth = n, this.viewportWidth = a; var r = [], l = this.option("slidesPerPage"); if (Number.isInteger(l) && n > a) for (var c = 0; c < this.slides.length; c += l)r.push({ indexes: o.slice(c, c + l), slides: this.slides.slice(c, c + l) }); else for (var h = 0, d = 0, u = 0; u < this.slides.length; u += 1) { var f = this.slides[u]; (!r.length || d + f.width > a) && (r.push({ indexes: [], slides: [] }), h = r.length - 1, d = 0), d += f.width, r[h].indexes.push(u), r[h].slides.push(f) } var v = this.option("center"), p = this.option("fill"); r.forEach((function (t, i) { t.index = i, t.width = t.slides.reduce((function (t, e) { return t + e.width }), 0), t.left = t.slides[0].left, v && (t.left += .5 * (a - t.width) * -1), p && !e.option("infiniteX", e.option("infinite")) && n > a && (t.left = Math.max(t.left, 0), t.left = Math.min(t.left, n - a)) })); var g, y = []; r.forEach((function (t) { var e = i({}, t); g && e.left === g.left ? (g.width += e.width, g.slides = [].concat(m(g.slides), m(e.slides)), g.indexes = [].concat(m(g.indexes), m(e.indexes))) : (e.index = y.length, g = e, y.push(e)) })), this.pages = y; var b = this.page; if (null === b) { var x = this.option("initialSlide"); b = null !== x ? this.findPageForSlide(x) : parseInt(this.option("initialPage", 0), 10) || 0, y[b] || (b = y.length && b > y.length ? y[y.length - 1].index : 0), this.page = b, this.pageIndex = b } this.updatePanzoom(), this.trigger("refresh") } }, { key: "getSlideMetrics", value: function (t) { if (!t) { var e, i, n = this.slides[0]; if ((t = document.createElement("div")).dataset.isTestEl = 1, t.style.visibility = "hidden", (e = t.classList).add.apply(e, m((this.option("prefix") + this.option("classNames.slide")).split(" "))), n.customClass) (i = t.classList).add.apply(i, m(n.customClass.split(" "))); this.$track.prepend(t) } var o = Math.max(t.offsetWidth, S(t.getBoundingClientRect().width)), a = t.currentStyle || window.getComputedStyle(t); return o = o + (parseFloat(a.marginLeft) || 0) + (parseFloat(a.marginRight) || 0), t.dataset.isTestEl && t.remove(), o } }, { key: "findPageForSlide", value: function (t) { t = parseInt(t, 10) || 0; var e = this.pages.find((function (e) { return e.indexes.indexOf(t) > -1 })); return e ? e.index : null } }, { key: "slideNext", value: function () { this.slideTo(this.pageIndex + 1) } }, { key: "slidePrev", value: function () { this.slideTo(this.pageIndex - 1) } }, { key: "slideTo", value: function (t) { var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}, i = e.x, n = void 0 === i ? -1 * this.setPage(t, !0) : i, o = e.y, a = void 0 === o ? 0 : o, s = e.friction, r = void 0 === s ? this.option("friction") : s; this.Panzoom.content.x === n && !this.Panzoom.velocity.x && r || (this.Panzoom.panTo({ x: n, y: a, friction: r, ignoreBounds: !0 }), "ready" === this.state && "ready" === this.Panzoom.state && this.trigger("settle")) } }, { key: "initPanzoom", value: function () { var t = this; this.Panzoom && this.Panzoom.destroy(); var e = k(!0, {}, { content: this.$track, wrapInner: !1, resizeParent: !1, zoom: !1, click: !1, lockAxis: "x", x: this.pages.length ? -1 * this.pages[this.page].left : 0, centerOnStart: !1, textSelection: function () { return t.option("textSelection", !1) }, panOnlyZoomed: function () { return this.content.width <= this.viewport.width } }, this.option("Panzoom")); this.Panzoom = new M(this.$container, e), this.Panzoom.on({ "*": function (e) { for (var i = arguments.length, n = new Array(i > 1 ? i - 1 : 0), o = 1; o < i; o++)n[o - 1] = arguments[o]; return t.trigger.apply(t, ["Panzoom.".concat(e)].concat(n)) }, afterUpdate: function () { t.updatePage() }, beforeTransform: this.onBeforeTransform.bind(this), touchEnd: this.onTouchEnd.bind(this), endAnimation: function () { t.trigger("settle") } }), this.updateMetrics(), this.manageSlideVisiblity() } }, { key: "updatePanzoom", value: function () { this.Panzoom && (this.Panzoom.content = i(i({}, this.Panzoom.content), {}, { fitWidth: this.contentWidth, origWidth: this.contentWidth, width: this.contentWidth }), this.pages.length > 1 && this.option("infiniteX", this.option("infinite")) ? this.Panzoom.boundX = null : this.pages.length && (this.Panzoom.boundX = { from: -1 * this.pages[this.pages.length - 1].left, to: -1 * this.pages[0].left }), this.option("infiniteY", this.option("infinite")) ? this.Panzoom.boundY = null : this.Panzoom.boundY = { from: 0, to: 0 }, this.Panzoom.handleCursor()) } }, { key: "manageSlideVisiblity", value: function () { var t = this, e = this.contentWidth, i = this.viewportWidth, n = this.Panzoom ? -1 * this.Panzoom.content.x : this.pages.length ? this.pages[this.page].left : 0, o = this.option("preload"), a = this.option("infiniteX", this.option("infinite")), s = parseFloat(getComputedStyle(this.$viewport, null).getPropertyValue("padding-left")), r = parseFloat(getComputedStyle(this.$viewport, null).getPropertyValue("padding-right")); this.slides.forEach((function (l) { var c, h, d = 0; c = n - s, h = n + i + r, c -= o * (i + s + r), h += o * (i + s + r); var u = l.left + l.width > c && l.left < h; c = n + e - s, h = n + e + i + r, c -= o * (i + s + r); var f = a && l.left + l.width > c && l.left < h; c = n - e - s, h = n - e + i + r, c -= o * (i + s + r); var v = a && l.left + l.width > c && l.left < h; f || u || v ? (t.createSlideEl(l), u && (d = 0), f && (d = -1), v && (d = 1), l.left + l.width > n && l.left <= n + i + r && (d = 0)) : t.removeSlideEl(l), l.hasDiff = d })); var l = 0, c = 0; this.slides.forEach((function (t, i) { var n = 0; t.$el ? (i !== l || t.hasDiff ? n = c + t.hasDiff * e : c = 0, t.$el.style.left = Math.abs(n) > .1 ? "".concat(c + t.hasDiff * e, "px") : "", l++) : c += t.width })), this.markSelectedSlides() } }, { key: "createSlideEl", value: function (t) { var e; if (t) { if (!t.$el) { var i, n = document.createElement("div"); if (n.dataset.index = t.index, (e = n.classList).add.apply(e, m((this.option("prefix") + this.option("classNames.slide")).split(" "))), t.customClass) (i = n.classList).add.apply(i, m(t.customClass.split(" "))); t.html && (n.innerHTML = t.html); var o = []; this.slides.forEach((function (t, e) { t.$el && o.push(e) })); var a = t.index, s = null; if (o.length) { var r = o.reduce((function (t, e) { return Math.abs(e - a) < Math.abs(t - a) ? e : t })); s = this.slides[r] } return this.$track.insertBefore(n, s && s.$el ? s.index < t.index ? s.$el.nextSibling : s.$el : null), t.$el = n, this.trigger("createSlide", t, a), t } var l, c = t.$el.dataset.index; c && parseInt(c, 10) === t.index || (t.$el.dataset.index = t.index, t.$el.querySelectorAll("[data-lazy-srcset]").forEach((function (t) { t.srcset = t.dataset.lazySrcset })), t.$el.querySelectorAll("[data-lazy-src]").forEach((function (t) { var e = t.dataset.lazySrc; t instanceof HTMLImageElement ? t.src = e : t.style.backgroundImage = "url('".concat(e, "')") })), (l = t.$el.dataset.lazySrc) && (t.$el.style.backgroundImage = "url('".concat(l, "')")), t.state = "ready") } } }, { key: "removeSlideEl", value: function (t) { t.$el && !t.isDom && (this.trigger("removeSlide", t), t.$el.remove(), t.$el = null) } }, { key: "markSelectedSlides", value: function () { var t = this, e = this.option("classNames.slideSelected"), i = "aria-hidden"; this.slides.forEach((function (n, o) { var a = n.$el; if (a) { var s = t.pages[t.page]; s && s.indexes && s.indexes.indexOf(o) > -1 ? (e && !a.classList.contains(e) && (a.classList.add(e), t.trigger("selectSlide", n)), a.removeAttribute(i)) : (e && a.classList.contains(e) && (a.classList.remove(e), t.trigger("unselectSlide", n)), a.setAttribute(i, !0)) } })) } }, { key: "updatePage", value: function () { this.updateMetrics(), this.slideTo(this.page, { friction: 0 }) } }, { key: "onBeforeTransform", value: function () { this.option("infiniteX", this.option("infinite")) && this.manageInfiniteTrack(), this.manageSlideVisiblity() } }, { key: "manageInfiniteTrack", value: function () { var t = this.contentWidth, e = this.viewportWidth; if (!(!this.option("infiniteX", this.option("infinite")) || this.pages.length < 2 || t < e)) { var i = this.Panzoom, n = !1; return i.content.x < -1 * (t - e) && (i.content.x += t, this.pageIndex = this.pageIndex - this.pages.length, n = !0), i.content.x > e && (i.content.x -= t, this.pageIndex = this.pageIndex + this.pages.length, n = !0), n && "pointerdown" === i.state && i.resetDragPosition(), n } } }, { key: "onTouchEnd", value: function (t, e) { var i = this.option("dragFree"); if (!i && this.pages.length > 1 && t.dragOffset.time < 350 && Math.abs(t.dragOffset.y) < 1 && Math.abs(t.dragOffset.x) > 5) this[t.dragOffset.x < 0 ? "slideNext" : "slidePrev"](); else if (i) { var n = g(this.getPageFromPosition(-1 * t.transform.x), 2)[1]; this.setPage(n) } else this.slideToClosest() } }, { key: "slideToClosest", value: function () { var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {}, e = this.getPageFromPosition(-1 * this.Panzoom.content.x), i = g(e, 2), n = i[1]; this.slideTo(n, t) } }, { key: "getPageFromPosition", value: function (t) { var e = this.pages.length; this.option("center") && (t += .5 * this.viewportWidth); var i = Math.floor(t / this.contentWidth); t -= i * this.contentWidth; var n = this.slides.find((function (e) { return e.left <= t && e.left + e.width > t })); if (n) { var o = this.findPageForSlide(n.index); return [o, o + i * e] } return [0, 0] } }, { key: "setPage", value: function (t, e) { var i = 0, n = parseInt(t, 10) || 0, o = this.page, a = this.pageIndex, s = this.pages.length, r = this.contentWidth, l = this.viewportWidth; if (t = (n % s + s) % s, this.option("infiniteX", this.option("infinite")) && r > l) { var c = Math.floor(n / s) || 0, h = r; if (i = this.pages[t].left + c * h, !0 === e && s > 2) { var d = -1 * this.Panzoom.content.x, u = i - h, f = i + h, v = Math.abs(d - i), p = Math.abs(d - u), g = Math.abs(d - f); g < v && g <= p ? (i = f, n += s) : p < v && p < g && (i = u, n -= s) } } else t = n = Math.max(0, Math.min(n, s - 1)), i = this.pages.length ? this.pages[t].left : 0; return this.page = t, this.pageIndex = n, null !== o && t !== o && (this.prevPage = o, this.prevPageIndex = a, this.trigger("change", t, o)), i } }, { key: "destroy", value: function () { var t = this; this.state = "destroy", this.slides.forEach((function (e) { t.removeSlideEl(e) })), this.slides = [], this.Panzoom.destroy(), this.detachPlugins() } }]), n }(O); H.version = "4.0.31", H.Plugins = D; var W = !("undefined" == typeof window || !window.document || !window.document.createElement), j = null, X = ["a[href]", "area[href]", 'input:not([disabled]):not([type="hidden"]):not([aria-hidden])', "select:not([disabled]):not([aria-hidden])", "textarea:not([disabled]):not([aria-hidden])", "button:not([disabled]):not([aria-hidden])", "iframe", "object", "embed", "video", "audio", "[contenteditable]", '[tabindex]:not([tabindex^="-"]):not([disabled]):not([aria-hidden])'], q = function (t) { if (t && W) { null === j && document.createElement("div").focus({ get preventScroll() { return j = !0, !1 } }); try { if (t.setActive) t.setActive(); else if (j) t.focus({ preventScroll: !0 }); else { var e = window.pageXOffset || document.body.scrollTop, i = window.pageYOffset || document.body.scrollLeft; t.focus(), document.body.scrollTo({ top: e, left: i, behavior: "auto" }) } } catch (t) { } } }, U = function () { function t(e) { o(this, t), this.fancybox = e, this.viewport = null, this.pendingUpdate = null; for (var i = 0, n = ["onReady", "onResize", "onTouchstart", "onTouchmove"]; i < n.length; i++) { var a = n[i]; this[a] = this[a].bind(this) } } return s(t, [{ key: "onReady", value: function () { var t = window.visualViewport; t && (this.viewport = t, this.startY = 0, t.addEventListener("resize", this.onResize), this.updateViewport()), window.addEventListener("touchstart", this.onTouchstart, { passive: !1 }), window.addEventListener("touchmove", this.onTouchmove, { passive: !1 }), window.addEventListener("wheel", this.onWheel, { passive: !1 }) } }, { key: "onResize", value: function () { this.updateViewport() } }, { key: "updateViewport", value: function () { var t = this.fancybox, e = this.viewport, i = e.scale || 1, n = t.$container; if (n) { var o = "", a = "", s = ""; i - 1 > .1 && (o = "".concat(e.width * i, "px"), a = "".concat(e.height * i, "px"), s = "translate3d(".concat(e.offsetLeft, "px, ").concat(e.offsetTop, "px, 0) scale(").concat(1 / i, ")")), n.style.width = o, n.style.height = a, n.style.transform = s } } }, { key: "onTouchstart", value: function (t) { this.startY = t.touches ? t.touches[0].screenY : t.screenY } }, { key: "onTouchmove", value: function (t) { var e = this.startY, i = window.innerWidth / window.document.documentElement.clientWidth; if (t.cancelable && !(t.touches.length > 1 || 1 !== i)) { var n = C(t.composedPath()[0]); if (n) { var o = window.getComputedStyle(n), a = parseInt(o.getPropertyValue("height"), 10), s = t.touches ? t.touches[0].screenY : t.screenY, r = e <= s && 0 === n.scrollTop, l = e >= s && n.scrollHeight - n.scrollTop === a; (r || l) && t.preventDefault() } else t.preventDefault() } } }, { key: "onWheel", value: function (t) { C(t.composedPath()[0]) || t.preventDefault() } }, { key: "cleanup", value: function () { this.pendingUpdate && (cancelAnimationFrame(this.pendingUpdate), this.pendingUpdate = null); var t = this.viewport; t && (t.removeEventListener("resize", this.onResize), this.viewport = null), window.removeEventListener("touchstart", this.onTouchstart, !1), window.removeEventListener("touchmove", this.onTouchmove, !1), window.removeEventListener("wheel", this.onWheel, { passive: !1 }) } }, { key: "attach", value: function () { this.fancybox.on("initLayout", this.onReady) } }, { key: "detach", value: function () { this.fancybox.off("initLayout", this.onReady), this.cleanup() } }]), t }(), Y = function () { function t(e) { o(this, t), this.fancybox = e, this.$container = null, this.state = "init"; for (var i = 0, n = ["onPrepare", "onClosing", "onKeydown"]; i < n.length; i++) { var a = n[i]; this[a] = this[a].bind(this) } this.events = { prepare: this.onPrepare, closing: this.onClosing, keydown: this.onKeydown } } return s(t, [{ key: "onPrepare", value: function () { this.getSlides().length < this.fancybox.option("Thumbs.minSlideCount") ? this.state = "disabled" : !0 === this.fancybox.option("Thumbs.autoStart") && this.fancybox.Carousel.Panzoom.content.height >= this.fancybox.option("Thumbs.minScreenHeight") && this.build() } }, { key: "onClosing", value: function () { this.Carousel && this.Carousel.Panzoom.detachEvents() } }, { key: "onKeydown", value: function (t, e) { e === t.option("Thumbs.key") && this.toggle() } }, { key: "build", value: function () { var t = this; if (!this.$container) { var e = document.createElement("div"); e.classList.add("fancybox__thumbs"), this.fancybox.$carousel.parentNode.insertBefore(e, this.fancybox.$carousel.nextSibling), this.Carousel = new H(e, k(!0, { Dots: !1, Navigation: !1, Sync: { friction: 0 }, infinite: !1, center: !0, fill: !0, dragFree: !0, slidesPerPage: 1, preload: 1 }, this.fancybox.option("Thumbs.Carousel"), { Sync: { target: this.fancybox.Carousel }, slides: this.getSlides() })), this.Carousel.Panzoom.on("wheel", (function (e, i) { i.preventDefault(), t.fancybox[i.deltaY < 0 ? "prev" : "next"]() })), this.$container = e, this.state = "visible" } } }, { key: "getSlides", value: function () { var t, e = [], i = x(this.fancybox.items); try { for (i.s(); !(t = i.n()).done;) { var n = t.value, o = n.thumb; o && e.push({ html: this.fancybox.option("Thumbs.tpl").replace(/\{\{src\}\}/gi, o), customClass: "has-thumb has-".concat(n.type || "image") }) } } catch (t) { i.e(t) } finally { i.f() } return e } }, { key: "toggle", value: function () { "visible" === this.state ? this.hide() : "hidden" === this.state ? this.show() : this.build() } }, { key: "show", value: function () { "hidden" === this.state && (this.$container.style.display = "", this.Carousel.Panzoom.attachEvents(), this.state = "visible") } }, { key: "hide", value: function () { "visible" === this.state && (this.Carousel.Panzoom.detachEvents(), this.$container.style.display = "none", this.state = "hidden") } }, { key: "cleanup", value: function () { this.Carousel && (this.Carousel.destroy(), this.Carousel = null), this.$container && (this.$container.remove(), this.$container = null), this.state = "init" } }, { key: "attach", value: function () { this.fancybox.on(this.events) } }, { key: "detach", value: function () { this.fancybox.off(this.events), this.cleanup() } }]), t }(); Y.defaults = { minSlideCount: 2, minScreenHeight: 500, autoStart: !0, key: "t", Carousel: {}, tpl: '<div class="fancybox__thumb" style="background-image:url(\'{{src}}\')"></div>' }; var V = function (t, e) { for (var i = new URL(t), n = new URLSearchParams(i.search), o = new URLSearchParams, a = 0, s = [].concat(m(n), m(Object.entries(e))); a < s.length; a++) { var r = g(s[a], 2), l = r[0], c = r[1]; "t" === l ? o.set("start", parseInt(c)) : o.set(l, c) } o = o.toString(); var h = t.match(/#t=((.*)?\d+s)/); return h && (o += "#t=".concat(h[1])), o }, Z = { video: { autoplay: !0, ratio: 16 / 9 }, youtube: { autohide: 1, fs: 1, rel: 0, hd: 1, wmode: "transparent", enablejsapi: 1, html5: 1 }, vimeo: { hd: 1, show_title: 1, show_byline: 1, show_portrait: 0, fullscreen: 1 }, html5video: { tpl: '<video class="fancybox__html5video" playsinline controls controlsList="nodownload" poster="{{poster}}">\n  <source src="{{src}}" type="{{format}}" />Sorry, your browser doesn\'t support embedded videos.</video>', format: "" } }, G = function () { function t(e) { o(this, t), this.fancybox = e; for (var i = 0, n = ["onInit", "onReady", "onCreateSlide", "onRemoveSlide", "onSelectSlide", "onUnselectSlide", "onRefresh", "onMessage"]; i < n.length; i++) { var a = n[i]; this[a] = this[a].bind(this) } this.events = { init: this.onInit, ready: this.onReady, "Carousel.createSlide": this.onCreateSlide, "Carousel.removeSlide": this.onRemoveSlide, "Carousel.selectSlide": this.onSelectSlide, "Carousel.unselectSlide": this.onUnselectSlide, "Carousel.refresh": this.onRefresh } } return s(t, [{ key: "onInit", value: function () { var t, e = x(this.fancybox.items); try { for (e.s(); !(t = e.n()).done;) { var i = t.value; this.processType(i) } } catch (t) { e.e(t) } finally { e.f() } } }, { key: "processType", value: function (t) { if (t.html) return t.src = t.html, t.type = "html", void delete t.html; var e = t.src || "", i = t.type || this.fancybox.options.type, n = null; if (!e || "string" == typeof e) { if (n = e.match(/(?:youtube\.com|youtu\.be|youtube\-nocookie\.com)\/(?:watch\?(?:.*&)?v=|v\/|u\/|embed\/?)?(videoseries\?list=(?:.*)|[\w-]{11}|\?listType=(?:.*)&list=(?:.*))(?:.*)/i)) { var o = V(e, this.fancybox.option("Html.youtube")), a = encodeURIComponent(n[1]); t.videoId = a, t.src = "https://www.youtube-nocookie.com/embed/".concat(a, "?").concat(o), t.thumb = t.thumb || "https://i.ytimg.com/vi/".concat(a, "/mqdefault.jpg"), t.vendor = "youtube", i = "video" } else if (n = e.match(/^.+vimeo.com\/(?:\/)?([\d]+)(.*)?/)) { var s = V(e, this.fancybox.option("Html.vimeo")), r = encodeURIComponent(n[1]); t.videoId = r, t.src = "https://player.vimeo.com/video/".concat(r, "?").concat(s), t.vendor = "vimeo", i = "video" } else (n = e.match(/(?:maps\.)?google\.([a-z]{2,3}(?:\.[a-z]{2})?)\/(?:(?:(?:maps\/(?:place\/(?:.*)\/)?\@(.*),(\d+.?\d+?)z))|(?:\?ll=))(.*)?/i)) ? (t.src = "//maps.google.".concat(n[1], "/?ll=").concat((n[2] ? n[2] + "&z=" + Math.floor(n[3]) + (n[4] ? n[4].replace(/^\//, "&") : "") : n[4] + "").replace(/\?/, "&"), "&output=").concat(n[4] && n[4].indexOf("layer=c") > 0 ? "svembed" : "embed"), i = "map") : (n = e.match(/(?:maps\.)?google\.([a-z]{2,3}(?:\.[a-z]{2})?)\/(?:maps\/search\/)(.*)/i)) && (t.src = "//maps.google.".concat(n[1], "/maps?q=").concat(n[2].replace("query=", "q=").replace("api=1", ""), "&output=embed"), i = "map"); i || ("#" === e.charAt(0) ? i = "inline" : (n = e.match(/\.(mp4|mov|ogv|webm)((\?|#).*)?$/i)) ? (i = "html5video", t.format = t.format || "video/" + ("ogv" === n[1] ? "ogg" : n[1])) : e.match(/(^data:image\/[a-z0-9+\/=]*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg|ico)((\?|#).*)?$)/i) ? i = "image" : e.match(/\.(pdf)((\?|#).*)?$/i) && (i = "pdf")), t.type = i || this.fancybox.option("defaultType", "image"), "html5video" !== i && "video" !== i || (t.video = k({}, this.fancybox.option("Html.video"), t.video), t._width && t._height ? t.ratio = parseFloat(t._width) / parseFloat(t._height) : t.ratio = t.ratio || t.video.ratio || Z.video.ratio) } } }, { key: "onReady", value: function () { var t = this; this.fancybox.Carousel.slides.forEach((function (e) { e.$el && (t.setContent(e), e.index === t.fancybox.getSlide().index && t.playVideo(e)) })) } }, { key: "onCreateSlide", value: function (t, e, i) { "ready" === this.fancybox.state && this.setContent(i) } }, { key: "loadInlineContent", value: function (t) { var e; if (t.src instanceof HTMLElement) e = t.src; else if ("string" == typeof t.src) { var i = t.src.split("#", 2), n = 2 === i.length && "" === i[0] ? i[1] : i[0]; e = document.getElementById(n) } if (e) { if ("clone" === t.type || e.$placeHolder) { var o = (e = e.cloneNode(!0)).getAttribute("id"); o = o ? "".concat(o, "--clone") : "clone-".concat(this.fancybox.id, "-").concat(t.index), e.setAttribute("id", o) } else { var a = document.createElement("div"); a.classList.add("fancybox-placeholder"), e.parentNode.insertBefore(a, e), e.$placeHolder = a } this.fancybox.setContent(t, e) } else this.fancybox.setError(t, "{{ELEMENT_NOT_FOUND}}") } }, { key: "loadAjaxContent", value: function (t) { var e = this.fancybox, i = new XMLHttpRequest; e.showLoading(t), i.onreadystatechange = function () { i.readyState === XMLHttpRequest.DONE && "ready" === e.state && (e.hideLoading(t), 200 === i.status ? e.setContent(t, i.responseText) : e.setError(t, 404 === i.status ? "{{AJAX_NOT_FOUND}}" : "{{AJAX_FORBIDDEN}}")) }; var n = t.ajax || null; i.open(n ? "POST" : "GET", t.src), i.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), i.setRequestHeader("X-Requested-With", "XMLHttpRequest"), i.send(n), t.xhr = i } }, { key: "loadIframeContent", value: function (t) { var e = this, i = this.fancybox, n = document.createElement("iframe"); if (n.className = "fancybox__iframe", n.setAttribute("id", "fancybox__iframe_".concat(i.id, "_").concat(t.index)), n.setAttribute("allow", "autoplay; fullscreen"), n.setAttribute("scrolling", "auto"), t.$iframe = n, "iframe" !== t.type || !1 === t.preload) return n.setAttribute("src", t.src), this.fancybox.setContent(t, n), void this.resizeIframe(t); i.showLoading(t); var o = document.createElement("div"); o.style.visibility = "hidden", this.fancybox.setContent(t, o), o.appendChild(n), n.onerror = function () { i.setError(t, "{{IFRAME_ERROR}}") }, n.onload = function () { i.hideLoading(t); var o = !1; n.isReady || (n.isReady = !0, o = !0), n.src.length && (n.parentNode.style.visibility = "", e.resizeIframe(t), o && i.revealContent(t)) }, n.setAttribute("src", t.src) } }, { key: "setAspectRatio", value: function (t) { var e = t.$content, i = t.ratio; if (e) { var n = t._width, o = t._height; if (i || n && o) { Object.assign(e.style, { width: n && o ? "100%" : "", height: n && o ? "100%" : "", maxWidth: "", maxHeight: "" }); var a = e.offsetWidth, s = e.offsetHeight; if (o = o || s, (n = n || a) > a || o > s) { var r = Math.min(a / n, s / o); n *= r, o *= r } Math.abs(n / o - i) > .01 && (i < n / o ? n = o * i : o = n / i), Object.assign(e.style, { width: "".concat(n, "px"), height: "".concat(o, "px") }) } } } }, { key: "resizeIframe", value: function (t) { var e = t.$iframe; if (e) { var i = t._width || 0, n = t._height || 0; i && n && (t.autoSize = !1); var o = e.parentNode, a = o && o.style; if (!1 !== t.preload && !1 !== t.autoSize && a) try { var s = window.getComputedStyle(o), r = parseFloat(s.paddingLeft) + parseFloat(s.paddingRight), l = parseFloat(s.paddingTop) + parseFloat(s.paddingBottom), c = e.contentWindow.document, h = c.getElementsByTagName("html")[0], d = c.body; a.width = "", d.style.overflow = "hidden", i = i || h.scrollWidth + r, a.width = "".concat(i, "px"), d.style.overflow = "", a.flex = "0 0 auto", a.height = "".concat(d.scrollHeight, "px"), n = h.scrollHeight + l } catch (t) { } if (i || n) { var u = { flex: "0 1 auto" }; i && (u.width = "".concat(i, "px")), n && (u.height = "".concat(n, "px")), Object.assign(a, u) } } } }, { key: "onRefresh", value: function (t, e) { var i = this; e.slides.forEach((function (t) { t.$el && (t.$iframe && i.resizeIframe(t), t.ratio && i.setAspectRatio(t)) })) } }, { key: "setContent", value: function (t) { if (t && !t.isDom) { switch (t.type) { case "html": this.fancybox.setContent(t, t.src); break; case "html5video": this.fancybox.setContent(t, this.fancybox.option("Html.html5video.tpl").replace(/\{\{src\}\}/gi, t.src).replace("{{format}}", t.format || t.html5video && t.html5video.format || "").replace("{{poster}}", t.poster || t.thumb || "")); break; case "inline": case "clone": this.loadInlineContent(t); break; case "ajax": this.loadAjaxContent(t); break; case "pdf": case "video": case "map": t.preload = !1; case "iframe": this.loadIframeContent(t) }t.ratio && this.setAspectRatio(t) } } }, { key: "onSelectSlide", value: function (t, e, i) { "ready" === t.state && this.playVideo(i) } }, { key: "playVideo", value: function (t) { if ("html5video" === t.type && t.video.autoplay) try { var e = t.$el.querySelector("video"); if (e) { var i = e.play(); void 0 !== i && i.then((function () { })).catch((function (t) { e.muted = !0, e.play() })) } } catch (t) { } if ("video" === t.type && t.$iframe && t.$iframe.contentWindow) { !function e() { if ("done" === t.state && t.$iframe && t.$iframe.contentWindow) { var i; if (t.$iframe.isReady) return t.video && t.video.autoplay && (i = "youtube" == t.vendor ? { event: "command", func: "playVideo" } : { method: "play", value: "true" }), void (i && t.$iframe.contentWindow.postMessage(JSON.stringify(i), "*")); "youtube" === t.vendor && (i = { event: "listening", id: t.$iframe.getAttribute("id") }, t.$iframe.contentWindow.postMessage(JSON.stringify(i), "*")) } t.poller = setTimeout(e, 250) }() } } }, { key: "onUnselectSlide", value: function (t, e, i) { if ("html5video" !== i.type) { var n = !1; "vimeo" == i.vendor ? n = { method: "pause", value: "true" } : "youtube" === i.vendor && (n = { event: "command", func: "pauseVideo" }), n && i.$iframe && i.$iframe.contentWindow && i.$iframe.contentWindow.postMessage(JSON.stringify(n), "*"), clearTimeout(i.poller) } else try { i.$el.querySelector("video").pause() } catch (t) { } } }, { key: "onRemoveSlide", value: function (t, e, i) { i.xhr && (i.xhr.abort(), i.xhr = null), i.$iframe && (i.$iframe.onload = i.$iframe.onerror = null, i.$iframe.src = "//about:blank", i.$iframe = null); var n = i.$content; "inline" === i.type && n && (n.classList.remove("fancybox__content"), "none" !== n.style.display && (n.style.display = "none")), i.$closeButton && (i.$closeButton.remove(), i.$closeButton = null); var o = n && n.$placeHolder; o && (o.parentNode.insertBefore(n, o), o.remove(), n.$placeHolder = null) } }, { key: "onMessage", value: function (t) { try { var e = JSON.parse(t.data); if ("https://player.vimeo.com" === t.origin) { if ("ready" === e.event) { var i, n = x(document.getElementsByClassName("fancybox__iframe")); try { for (n.s(); !(i = n.n()).done;) { var o = i.value; o.contentWindow === t.source && (o.isReady = 1) } } catch (t) { n.e(t) } finally { n.f() } } } else "https://www.youtube-nocookie.com" === t.origin && "onReady" === e.event && (document.getElementById(e.id).isReady = 1) } catch (t) { } } }, { key: "attach", value: function () { this.fancybox.on(this.events), window.addEventListener("message", this.onMessage, !1) } }, { key: "detach", value: function () { this.fancybox.off(this.events), window.removeEventListener("message", this.onMessage, !1) } }]), t }(); G.defaults = Z; var K = function () { function t(e) { o(this, t), this.fancybox = e; for (var i = 0, n = ["onReady", "onClosing", "onDone", "onPageChange", "onCreateSlide", "onRemoveSlide", "onImageStatusChange"]; i < n.length; i++) { var a = n[i]; this[a] = this[a].bind(this) } this.events = { ready: this.onReady, closing: this.onClosing, done: this.onDone, "Carousel.change": this.onPageChange, "Carousel.createSlide": this.onCreateSlide, "Carousel.removeSlide": this.onRemoveSlide } } return s(t, [{ key: "onReady", value: function () { var t = this; this.fancybox.Carousel.slides.forEach((function (e) { e.$el && t.setContent(e) })) } }, { key: "onDone", value: function (t, e) { this.handleCursor(e) } }, { key: "onClosing", value: function (t) { clearTimeout(this.clickTimer), this.clickTimer = null, t.Carousel.slides.forEach((function (t) { t.$image && (t.state = "destroy"), t.Panzoom && t.Panzoom.detachEvents() })), "closing" === this.fancybox.state && this.canZoom(t.getSlide()) && this.zoomOut() } }, { key: "onCreateSlide", value: function (t, e, i) { "ready" === this.fancybox.state && this.setContent(i) } }, { key: "onRemoveSlide", value: function (t, e, i) { i.$image && (i.$el.classList.remove(t.option("Image.canZoomInClass")), i.$image.remove(), i.$image = null), i.Panzoom && (i.Panzoom.destroy(), i.Panzoom = null), i.$el && i.$el.dataset && delete i.$el.dataset.imageFit } }, { key: "setContent", value: function (t) { var e = this; if (!(t.isDom || t.html || t.type && "image" !== t.type || t.$image)) { t.type = "image", t.state = "loading"; var i = document.createElement("div"); i.style.visibility = "hidden"; var n = document.createElement("img"); n.addEventListener("load", (function (i) { i.stopImmediatePropagation(), e.onImageStatusChange(t) })), n.addEventListener("error", (function () { e.onImageStatusChange(t) })), n.src = t.src, n.alt = "", n.draggable = !1, n.classList.add("fancybox__image"), t.srcset && n.setAttribute("srcset", t.srcset), t.sizes && n.setAttribute("sizes", t.sizes), t.$image = n; var o = this.fancybox.option("Image.wrap"); if (o) { var a = document.createElement("div"); a.classList.add("string" == typeof o ? o : "fancybox__image-wrap"), a.appendChild(n), i.appendChild(a), t.$wrap = a } else i.appendChild(n); t.$el.dataset.imageFit = this.fancybox.option("Image.fit"), this.fancybox.setContent(t, i), n.complete || n.error ? this.onImageStatusChange(t) : this.fancybox.showLoading(t) } } }, { key: "onImageStatusChange", value: function (t) { var e = this, i = t.$image; i && "loading" === t.state && (i.complete && i.naturalWidth && i.naturalHeight ? (this.fancybox.hideLoading(t), "contain" === this.fancybox.option("Image.fit") && this.initSlidePanzoom(t), t.$el.addEventListener("wheel", (function (i) { return e.onWheel(t, i) }), { passive: !1 }), t.$content.addEventListener("click", (function (i) { return e.onClick(t, i) }), { passive: !1 }), this.revealContent(t)) : this.fancybox.setError(t, "{{IMAGE_ERROR}}")) } }, { key: "initSlidePanzoom", value: function (t) { var e = this; t.Panzoom || (t.Panzoom = new M(t.$el, k(!0, this.fancybox.option("Image.Panzoom", {}), { viewport: t.$wrap, content: t.$image, width: t._width, height: t._height, wrapInner: !1, textSelection: !0, touch: this.fancybox.option("Image.touch"), panOnlyZoomed: !0, click: !1, wheel: !1 })), t.Panzoom.on("startAnimation", (function () { e.fancybox.trigger("Image.startAnimation", t) })), t.Panzoom.on("endAnimation", (function () { "zoomIn" === t.state && e.fancybox.done(t), e.handleCursor(t), e.fancybox.trigger("Image.endAnimation", t) })), t.Panzoom.on("afterUpdate", (function () { e.handleCursor(t), e.fancybox.trigger("Image.afterUpdate", t) }))) } }, { key: "revealContent", value: function (t) { null === this.fancybox.Carousel.prevPage && t.index === this.fancybox.options.startIndex && this.canZoom(t) ? this.zoomIn() : this.fancybox.revealContent(t) } }, { key: "getZoomInfo", value: function (t) { var e = t.$thumb.getBoundingClientRect(), i = e.width, n = e.height, o = t.$content.getBoundingClientRect(), a = o.width, s = o.height, r = o.top - e.top, l = o.left - e.left, c = this.fancybox.option("Image.zoomOpacity"); return "auto" === c && (c = Math.abs(i / n - a / s) > .1), { top: r, left: l, scale: a && i ? i / a : 1, opacity: c } } }, { key: "canZoom", value: function (t) { var e = this.fancybox, i = e.$container; if (window.visualViewport && 1 !== window.visualViewport.scale) return !1; if (t.Panzoom && !t.Panzoom.content.width) return !1; if (!e.option("Image.zoom") || "contain" !== e.option("Image.fit")) return !1; var n = t.$thumb; if (!n || "loading" === t.state) return !1; i.classList.add("fancybox__no-click"); var o, a = n.getBoundingClientRect(); if (this.fancybox.option("Image.ignoreCoveredThumbnail")) { var s = document.elementFromPoint(a.left + 1, a.top + 1) === n, r = document.elementFromPoint(a.right - 1, a.bottom - 1) === n; o = s && r } else o = document.elementFromPoint(a.left + .5 * a.width, a.top + .5 * a.height) === n; return i.classList.remove("fancybox__no-click"), o } }, { key: "zoomIn", value: function () { var t = this.fancybox, e = t.getSlide(), i = e.Panzoom, n = this.getZoomInfo(e), o = n.top, a = n.left, s = n.scale, r = n.opacity; t.trigger("reveal", e), i.panTo({ x: -1 * a, y: -1 * o, scale: s, friction: 0, ignoreBounds: !0 }), e.$content.style.visibility = "", e.state = "zoomIn", !0 === r && i.on("afterTransform", (function (t) { "zoomIn" !== e.state && "zoomOut" !== e.state || (t.$content.style.opacity = Math.min(1, 1 - (1 - t.content.scale) / (1 - s))) })), i.panTo({ x: 0, y: 0, scale: 1, friction: this.fancybox.option("Image.zoomFriction") }) } }, { key: "zoomOut", value: function () { var t = this, e = this.fancybox, i = e.getSlide(), n = i.Panzoom; if (n) { i.state = "zoomOut", e.state = "customClosing", i.$caption && (i.$caption.style.visibility = "hidden"); var o = this.fancybox.option("Image.zoomFriction"), a = function (e) { var a = t.getZoomInfo(i), s = a.top, r = a.left, l = a.scale, c = a.opacity; e || c || (o *= .82), n.panTo({ x: -1 * r, y: -1 * s, scale: l, friction: o, ignoreBounds: !0 }), o *= .98 }; window.addEventListener("scroll", a), n.once("endAnimation", (function () { window.removeEventListener("scroll", a), e.destroy() })), a() } } }, { key: "handleCursor", value: function (t) { if ("image" === t.type && t.$el) { var e = t.Panzoom, i = this.fancybox.option("Image.click", !1, t), n = this.fancybox.option("Image.touch"), o = t.$el.classList, a = this.fancybox.option("Image.canZoomInClass"), s = this.fancybox.option("Image.canZoomOutClass"); if (o.remove(s), o.remove(a), e && "toggleZoom" === i) e && 1 === e.content.scale && e.option("maxScale") - e.content.scale > .01 ? o.add(a) : e.content.scale > 1 && !n && o.add(s); else "close" === i && o.add(s) } } }, { key: "onWheel", value: function (t, e) { if ("ready" === this.fancybox.state && !1 !== this.fancybox.trigger("Image.wheel", e)) switch (this.fancybox.option("Image.wheel")) { case "zoom": "done" === t.state && t.Panzoom && t.Panzoom.zoomWithWheel(e); break; case "close": this.fancybox.close(); break; case "slide": this.fancybox[e.deltaY < 0 ? "prev" : "next"]() } } }, { key: "onClick", value: function (t, e) { var i = this; if ("ready" === this.fancybox.state) { var n = t.Panzoom; if (!n || !n.dragPosition.midPoint && 0 === n.dragOffset.x && 0 === n.dragOffset.y && 1 === n.dragOffset.scale) { if (this.fancybox.Carousel.Panzoom.lockAxis) return !1; var o = function (n) { switch (n) { case "toggleZoom": e.stopPropagation(), t.Panzoom && t.Panzoom.zoomWithClick(e); break; case "close": i.fancybox.close(); break; case "next": e.stopPropagation(), i.fancybox.next() } }, a = this.fancybox.option("Image.click"), s = this.fancybox.option("Image.doubleClick"); s ? this.clickTimer ? (clearTimeout(this.clickTimer), this.clickTimer = null, o(s)) : this.clickTimer = setTimeout((function () { i.clickTimer = null, o(a) }), 300) : o(a) } } } }, { key: "onPageChange", value: function (t, e) { var i = t.getSlide(); e.slides.forEach((function (t) { t.Panzoom && "done" === t.state && t.index !== i.index && t.Panzoom.panTo({ x: 0, y: 0, scale: 1, friction: .8 }) })) } }, { key: "attach", value: function () { this.fancybox.on(this.events) } }, { key: "detach", value: function () { this.fancybox.off(this.events) } }]), t }(); K.defaults = { canZoomInClass: "can-zoom_in", canZoomOutClass: "can-zoom_out", zoom: !0, zoomOpacity: "auto", zoomFriction: .82, ignoreCoveredThumbnail: !1, touch: !0, click: "toggleZoom", doubleClick: null, wheel: "zoom", fit: "contain", wrap: !1, Panzoom: { ratio: 1 } }; var J = function () { function t(e) { o(this, t), this.fancybox = e; for (var i = 0, n = ["onChange", "onClosing"]; i < n.length; i++) { var a = n[i]; this[a] = this[a].bind(this) } this.events = { initCarousel: this.onChange, "Carousel.change": this.onChange, closing: this.onClosing }, this.hasCreatedHistory = !1, this.origHash = "", this.timer = null } return s(t, [{ key: "onChange", value: function (t) { var e = this, i = t.Carousel; this.timer && clearTimeout(this.timer); var n = null === i.prevPage, o = t.getSlide(), a = new URL(document.URL).hash, s = !1; if (o.slug) s = "#" + o.slug; else { var r = o.$trigger && o.$trigger.dataset, l = t.option("slug") || r && r.fancybox; l && l.length && "true" !== l && (s = "#" + l + (i.slides.length > 1 ? "-" + (o.index + 1) : "")) } n && (this.origHash = a !== s ? a : ""), s && a !== s && (this.timer = setTimeout((function () { try { window.history[n ? "pushState" : "replaceState"]({}, document.title, window.location.pathname + window.location.search + s), n && (e.hasCreatedHistory = !0) } catch (t) { } }), 300)) } }, { key: "onClosing", value: function () { if (this.timer && clearTimeout(this.timer), !0 !== this.hasSilentClose) try { return void window.history.replaceState({}, document.title, window.location.pathname + window.location.search + (this.origHash || "")) } catch (t) { } } }, { key: "attach", value: function (t) { t.on(this.events) } }, { key: "detach", value: function (t) { t.off(this.events) } }], [{ key: "startFromUrl", value: function () { var e = t.Fancybox; if (e && !e.getInstance() && !1 !== e.defaults.Hash) { var i = t.getParsedURL(), n = i.hash, o = i.slug, a = i.index; if (o) { var s = document.querySelector('[data-slug="'.concat(n, '"]')); if (s && s.dispatchEvent(new CustomEvent("click", { bubbles: !0, cancelable: !0 })), !e.getInstance()) { var r = document.querySelectorAll('[data-fancybox="'.concat(o, '"]')); r.length && (null === a && 1 === r.length ? s = r[0] : a && (s = r[a - 1]), s && s.dispatchEvent(new CustomEvent("click", { bubbles: !0, cancelable: !0 }))) } } } } }, { key: "onHashChange", value: function () { var e = t.getParsedURL(), i = e.slug, n = e.index, o = t.Fancybox, a = o && o.getInstance(); if (a && a.plugins.Hash) { if (i) { var s = a.Carousel; if (i === a.option("slug")) return s.slideTo(n - 1); var r, l = x(s.slides); try { for (l.s(); !(r = l.n()).done;) { var c = r.value; if (c.slug && c.slug === i) return s.slideTo(c.index) } } catch (t) { l.e(t) } finally { l.f() } var h = a.getSlide(), d = h.$trigger && h.$trigger.dataset; if (d && d.fancybox === i) return s.slideTo(n - 1) } a.plugins.Hash.hasSilentClose = !0, a.close() } t.startFromUrl() } }, { key: "create", value: function (e) { function i() { window.addEventListener("hashchange", t.onHashChange, !1), t.startFromUrl() } t.Fancybox = e, W && window.requestAnimationFrame((function () { /complete|interactive|loaded/.test(document.readyState) ? i() : document.addEventListener("DOMContentLoaded", i) })) } }, { key: "destroy", value: function () { window.removeEventListener("hashchange", t.onHashChange, !1) } }, { key: "getParsedURL", value: function () { var t = window.location.hash.substr(1), e = t.split("-"), i = e.length > 1 && /^\+?\d+$/.test(e[e.length - 1]) && parseInt(e.pop(-1), 10) || null; return { hash: t, slug: e.join("-"), index: i } } }]), t }(), Q = { pageXOffset: 0, pageYOffset: 0, element: function () { return document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement }, activate: function (t) { Q.pageXOffset = window.pageXOffset, Q.pageYOffset = window.pageYOffset, t.requestFullscreen ? t.requestFullscreen() : t.mozRequestFullScreen ? t.mozRequestFullScreen() : t.webkitRequestFullscreen ? t.webkitRequestFullscreen() : t.msRequestFullscreen && t.msRequestFullscreen() }, deactivate: function () { document.exitFullscreen ? document.exitFullscreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitExitFullscreen && document.webkitExitFullscreen() } }, tt = function () { function t(e) { o(this, t), this.fancybox = e, this.active = !1, this.handleVisibilityChange = this.handleVisibilityChange.bind(this) } return s(t, [{ key: "isActive", value: function () { return this.active } }, { key: "setTimer", value: function () { var t = this; if (this.active && !this.timer) { var e = this.fancybox.option("slideshow.delay", 3e3); this.timer = setTimeout((function () { t.timer = null, t.fancybox.option("infinite") || t.fancybox.getSlide().index !== t.fancybox.Carousel.slides.length - 1 ? t.fancybox.next() : t.fancybox.jumpTo(0, { friction: 0 }) }), e); var i = this.$progress; i || ((i = document.createElement("div")).classList.add("fancybox__progress"), this.fancybox.$carousel.parentNode.insertBefore(i, this.fancybox.$carousel), this.$progress = i, i.offsetHeight), i.style.transitionDuration = "".concat(e, "ms"), i.style.transform = "scaleX(1)" } } }, { key: "clearTimer", value: function () { clearTimeout(this.timer), this.timer = null, this.$progress && (this.$progress.style.transitionDuration = "", this.$progress.style.transform = "", this.$progress.offsetHeight) } }, { key: "activate", value: function () { this.active || (this.active = !0, this.fancybox.$container.classList.add("has-slideshow"), "done" === this.fancybox.getSlide().state && this.setTimer(), document.addEventListener("visibilitychange", this.handleVisibilityChange, !1)) } }, { key: "handleVisibilityChange", value: function () { this.deactivate() } }, { key: "deactivate", value: function () { this.active = !1, this.clearTimer(), this.fancybox.$container.classList.remove("has-slideshow"), document.removeEventListener("visibilitychange", this.handleVisibilityChange, !1) } }, { key: "toggle", value: function () { this.active ? this.deactivate() : this.fancybox.Carousel.slides.length > 1 && this.activate() } }]), t }(), et = { display: ["counter", "zoom", "slideshow", "fullscreen", "thumbs", "close"], autoEnable: !0, items: { counter: { position: "left", type: "div", class: "fancybox__counter", html: '<span data-fancybox-index=""></span>&nbsp;/&nbsp;<span data-fancybox-count=""></span>', attr: { tabindex: -1 } }, prev: { type: "button", class: "fancybox__button--prev", label: "PREV", html: '<svg viewBox="0 0 24 24"><path d="M15 4l-8 8 8 8"/></svg>', attr: { "data-fancybox-prev": "" } }, next: { type: "button", class: "fancybox__button--next", label: "NEXT", html: '<svg viewBox="0 0 24 24"><path d="M8 4l8 8-8 8"/></svg>', attr: { "data-fancybox-next": "" } }, fullscreen: { type: "button", class: "fancybox__button--fullscreen", label: "TOGGLE_FULLSCREEN", html: '<svg viewBox="0 0 24 24">\n                <g><path d="M3 8 V3h5"></path><path d="M21 8V3h-5"></path><path d="M8 21H3v-5"></path><path d="M16 21h5v-5"></path></g>\n                <g><path d="M7 2v5H2M17 2v5h5M2 17h5v5M22 17h-5v5"/></g>\n            </svg>', click: function (t) { t.preventDefault(), Q.element() ? Q.deactivate() : Q.activate(this.fancybox.$container) } }, slideshow: { type: "button", class: "fancybox__button--slideshow", label: "TOGGLE_SLIDESHOW", html: '<svg viewBox="0 0 24 24">\n                <g><path d="M6 4v16"/><path d="M20 12L6 20"/><path d="M20 12L6 4"/></g>\n                <g><path d="M7 4v15M17 4v15"/></g>\n            </svg>', click: function (t) { t.preventDefault(), this.Slideshow.toggle() } }, zoom: { type: "button", class: "fancybox__button--zoom", label: "TOGGLE_ZOOM", html: '<svg viewBox="0 0 24 24"><circle cx="10" cy="10" r="7"></circle><path d="M16 16 L21 21"></svg>', click: function (t) { t.preventDefault(); var e = this.fancybox.getSlide().Panzoom; e && e.toggleZoom() } }, download: { type: "link", label: "DOWNLOAD", class: "fancybox__button--download", html: '<svg viewBox="0 0 24 24"><path d="M12 15V3m0 12l-4-4m4 4l4-4M2 17l.62 2.48A2 2 0 004.56 21h14.88a2 2 0 001.94-1.51L22 17"/></svg>', click: function (t) { t.stopPropagation() } }, thumbs: { type: "button", label: "TOGGLE_THUMBS", class: "fancybox__button--thumbs", html: '<svg viewBox="0 0 24 24"><circle cx="4" cy="4" r="1" /><circle cx="12" cy="4" r="1" transform="rotate(90 12 4)"/><circle cx="20" cy="4" r="1" transform="rotate(90 20 4)"/><circle cx="4" cy="12" r="1" transform="rotate(90 4 12)"/><circle cx="12" cy="12" r="1" transform="rotate(90 12 12)"/><circle cx="20" cy="12" r="1" transform="rotate(90 20 12)"/><circle cx="4" cy="20" r="1" transform="rotate(90 4 20)"/><circle cx="12" cy="20" r="1" transform="rotate(90 12 20)"/><circle cx="20" cy="20" r="1" transform="rotate(90 20 20)"/></svg>', click: function (t) { t.stopPropagation(); var e = this.fancybox.plugins.Thumbs; e && e.toggle() } }, close: { type: "button", label: "CLOSE", class: "fancybox__button--close", html: '<svg viewBox="0 0 24 24"><path d="M20 20L4 4m16 0L4 20"></path></svg>', attr: { "data-fancybox-close": "", tabindex: 0 } } } }, it = function () { function t(e) { var i = this; o(this, t), this.fancybox = e, this.$container = null, this.state = "init"; for (var n = 0, a = ["onInit", "onPrepare", "onDone", "onKeydown", "onClosing", "onChange", "onSettle", "onRefresh"]; n < a.length; n++) { var s = a[n]; this[s] = this[s].bind(this) } this.events = { init: this.onInit, prepare: this.onPrepare, done: this.onDone, keydown: this.onKeydown, closing: this.onClosing, "Carousel.change": this.onChange, "Carousel.settle": this.onSettle, "Carousel.Panzoom.touchStart": function () { return i.onRefresh() }, "Image.startAnimation": function (t, e) { return i.onRefresh(e) }, "Image.afterUpdate": function (t, e) { return i.onRefresh(e) } } } return s(t, [{ key: "onInit", value: function () { if (this.fancybox.option("Toolbar.autoEnable")) { var t, e = !1, i = x(this.fancybox.items); try { for (i.s(); !(t = i.n()).done;) { if ("image" === t.value.type) { e = !0; break } } } catch (t) { i.e(t) } finally { i.f() } if (!e) return void (this.state = "disabled") } var n, o = x(this.fancybox.option("Toolbar.display")); try { for (o.s(); !(n = o.n()).done;) { var a = n.value; if ("close" === (w(a) ? a.id : a)) { this.fancybox.options.closeButton = !1; break } } } catch (t) { o.e(t) } finally { o.f() } } }, { key: "onPrepare", value: function () { var t = this.fancybox; if ("init" === this.state && (this.build(), this.update(), this.Slideshow = new tt(t), !t.Carousel.prevPage && (t.option("slideshow.autoStart") && this.Slideshow.activate(), t.option("fullscreen.autoStart") && !Q.element()))) try { Q.activate(t.$container) } catch (t) { } } }, { key: "onFsChange", value: function () { window.scrollTo(Q.pageXOffset, Q.pageYOffset) } }, { key: "onSettle", value: function () { var t = this.fancybox, e = this.Slideshow; e && e.isActive() && (t.getSlide().index !== t.Carousel.slides.length - 1 || t.option("infinite") ? "done" === t.getSlide().state && e.setTimer() : e.deactivate()) } }, { key: "onChange", value: function () { this.update(), this.Slideshow && this.Slideshow.isActive() && this.Slideshow.clearTimer() } }, { key: "onDone", value: function (t, e) { var i = this.Slideshow; e.index === t.getSlide().index && (this.update(), i && i.isActive() && (t.option("infinite") || e.index !== t.Carousel.slides.length - 1 ? i.setTimer() : i.deactivate())) } }, { key: "onRefresh", value: function (t) { t && t.index !== this.fancybox.getSlide().index || (this.update(), !this.Slideshow || !this.Slideshow.isActive() || t && "done" !== t.state || this.Slideshow.deactivate()) } }, { key: "onKeydown", value: function (t, e, i) { " " === e && this.Slideshow && (this.Slideshow.toggle(), i.preventDefault()) } }, { key: "onClosing", value: function () { this.Slideshow && this.Slideshow.deactivate(), document.removeEventListener("fullscreenchange", this.onFsChange) } }, { key: "createElement", value: function (t) { var e, i; ("div" === t.type ? e = document.createElement("div") : (e = document.createElement("link" === t.type ? "a" : "button")).classList.add("carousel__button"), e.innerHTML = t.html, e.setAttribute("tabindex", t.tabindex || 0), t.class) && (i = e.classList).add.apply(i, m(t.class.split(" "))); for (var n in t.attr) e.setAttribute(n, t.attr[n]); t.label && e.setAttribute("title", this.fancybox.localize("{{".concat(t.label, "}}"))), t.click && e.addEventListener("click", t.click.bind(this)), "prev" === t.id && e.setAttribute("data-fancybox-prev", ""), "next" === t.id && e.setAttribute("data-fancybox-next", ""); var o = e.querySelector("svg"); return o && (o.setAttribute("role", "img"), o.setAttribute("tabindex", "-1"), o.setAttribute("xmlns", "http://www.w3.org/2000/svg")), e } }, { key: "build", value: function () { var t = this; this.cleanup(); var e, i = this.fancybox.option("Toolbar.items"), n = [{ position: "left", items: [] }, { position: "center", items: [] }, { position: "right", items: [] }], o = this.fancybox.plugins.Thumbs, a = x(this.fancybox.option("Toolbar.display")); try { var s = function () { var a = e.value, s = void 0, r = void 0; if (w(a) ? (s = a.id, r = k({}, i[s], a)) : r = i[s = a], ["counter", "next", "prev", "slideshow"].includes(s) && t.fancybox.items.length < 2) return "continue"; if ("fullscreen" === s) { if (!document.fullscreenEnabled || window.fullScreen) return "continue"; document.addEventListener("fullscreenchange", t.onFsChange) } if ("thumbs" === s && (!o || "disabled" === o.state)) return "continue"; if (!r) return "continue"; var l = r.position || "right", c = n.find((function (t) { return t.position === l })); c && c.items.push(r) }; for (a.s(); !(e = a.n()).done;)s() } catch (t) { a.e(t) } finally { a.f() } var r = document.createElement("div"); r.classList.add("fancybox__toolbar"); for (var l = 0, c = n; l < c.length; l++) { var h = c[l]; if (h.items.length) { var d = document.createElement("div"); d.classList.add("fancybox__toolbar__items"), d.classList.add("fancybox__toolbar__items--".concat(h.position)); var u, f = x(h.items); try { for (f.s(); !(u = f.n()).done;) { var v = u.value; d.appendChild(this.createElement(v)) } } catch (t) { f.e(t) } finally { f.f() } r.appendChild(d) } } this.fancybox.$carousel.parentNode.insertBefore(r, this.fancybox.$carousel), this.$container = r } }, { key: "update", value: function () { var t, e = this.fancybox.getSlide(), i = e.index, n = this.fancybox.items.length, o = e.downloadSrc || ("image" !== e.type || e.error ? null : e.src), a = x(this.fancybox.$container.querySelectorAll("a.fancybox__button--download")); try { for (a.s(); !(t = a.n()).done;) { var s = t.value; o ? (s.removeAttribute("disabled"), s.removeAttribute("tabindex"), s.setAttribute("href", o), s.setAttribute("download", o), s.setAttribute("target", "_blank")) : (s.setAttribute("disabled", ""), s.setAttribute("tabindex", -1), s.removeAttribute("href"), s.removeAttribute("download")) } } catch (t) { a.e(t) } finally { a.f() } var r, l = e.Panzoom, c = l && l.option("maxScale") > l.option("baseScale"), h = x(this.fancybox.$container.querySelectorAll(".fancybox__button--zoom")); try { for (h.s(); !(r = h.n()).done;) { var d = r.value; c ? d.removeAttribute("disabled") : d.setAttribute("disabled", "") } } catch (t) { h.e(t) } finally { h.f() } var u, f = x(this.fancybox.$container.querySelectorAll("[data-fancybox-index]")); try { for (f.s(); !(u = f.n()).done;) { u.value.innerHTML = e.index + 1 } } catch (t) { f.e(t) } finally { f.f() } var v, p = x(this.fancybox.$container.querySelectorAll("[data-fancybox-count]")); try { for (p.s(); !(v = p.n()).done;) { v.value.innerHTML = n } } catch (t) { p.e(t) } finally { p.f() } if (!this.fancybox.option("infinite")) { var g, m = x(this.fancybox.$container.querySelectorAll("[data-fancybox-prev]")); try { for (m.s(); !(g = m.n()).done;) { var y = g.value; 0 === i ? y.setAttribute("disabled", "") : y.removeAttribute("disabled") } } catch (t) { m.e(t) } finally { m.f() } var b, w = x(this.fancybox.$container.querySelectorAll("[data-fancybox-next]")); try { for (w.s(); !(b = w.n()).done;) { var k = b.value; i === n - 1 ? k.setAttribute("disabled", "") : k.removeAttribute("disabled") } } catch (t) { w.e(t) } finally { w.f() } } } }, { key: "cleanup", value: function () { this.Slideshow && this.Slideshow.isActive() && this.Slideshow.clearTimer(), this.$container && this.$container.remove(), this.$container = null } }, { key: "attach", value: function () { this.fancybox.on(this.events) } }, { key: "detach", value: function () { this.fancybox.off(this.events), this.cleanup() } }]), t }(); it.defaults = et; var nt = { ScrollLock: U, Thumbs: Y, Html: G, Toolbar: it, Image: K, Hash: J }, ot = { startIndex: 0, preload: 1, infinite: !0, showClass: "fancybox-zoomInUp", hideClass: "fancybox-fadeOut", animated: !0, hideScrollbar: !0, parentEl: null, mainClass: null, autoFocus: !0, trapFocus: !0, placeFocusBack: !0, click: "close", closeButton: "inside", dragToClose: !0, keyboard: { Escape: "close", Delete: "close", Backspace: "close", PageUp: "next", PageDown: "prev", ArrowUp: "next", ArrowDown: "prev", ArrowRight: "next", ArrowLeft: "prev" }, template: { closeButton: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M20 20L4 4m16 0L4 20"/></svg>', spinner: '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="25 25 50 50" tabindex="-1"><circle cx="50" cy="50" r="20"/></svg>', main: null }, l10n: { CLOSE: "Close", NEXT: "Next", PREV: "Previous", MODAL: "You can close this modal content with the ESC key", ERROR: "Something Went Wrong, Please Try Again Later", IMAGE_ERROR: "Image Not Found", ELEMENT_NOT_FOUND: "HTML Element Not Found", AJAX_NOT_FOUND: "Error Loading AJAX : Not Found", AJAX_FORBIDDEN: "Error Loading AJAX : Forbidden", IFRAME_ERROR: "Error Loading Page", TOGGLE_ZOOM: "Toggle zoom level", TOGGLE_THUMBS: "Toggle thumbnails", TOGGLE_SLIDESHOW: "Toggle slideshow", TOGGLE_FULLSCREEN: "Toggle full-screen mode", DOWNLOAD: "Download" } }, at = new Map, st = 0, rt = function (t) { l(i, t); var e = f(i); function i(t) { var n, a = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}; return o(this, i), t = t.map((function (t) { return t.width && (t._width = t.width), t.height && (t._height = t.height), t })), (n = e.call(this, k(!0, {}, ot, a))).bindHandlers(), n.state = "init", n.setItems(t), n.attachPlugins(i.Plugins), n.trigger("init"), !0 === n.option("hideScrollbar") && n.hideScrollbar(), n.initLayout(), n.initCarousel(), n.attachEvents(), at.set(n.id, d(n)), n.trigger("prepare"), n.state = "ready", n.trigger("ready"), n.$container.setAttribute("aria-hidden", "false"), n.option("trapFocus") && n.focus(), n } return s(i, [{ key: "option", value: function (t) { for (var e, n = this.getSlide(), o = n ? n[t] : void 0, a = arguments.length, s = new Array(a > 1 ? a - 1 : 0), r = 1; r < a; r++)s[r - 1] = arguments[r]; if (void 0 !== o) { var l; if ("function" == typeof o) o = (l = o).call.apply(l, [this, this].concat(s)); return o } return (e = p(c(i.prototype), "option", this)).call.apply(e, [this, t].concat(s)) } }, { key: "bindHandlers", value: function () { for (var t = 0, e = ["onMousedown", "onKeydown", "onClick", "onFocus", "onCreateSlide", "onSettle", "onTouchMove", "onTouchEnd", "onTransform"]; t < e.length; t++) { var i = e[t]; this[i] = this[i].bind(this) } } }, { key: "attachEvents", value: function () { document.addEventListener("mousedown", this.onMousedown), document.addEventListener("keydown", this.onKeydown, !0), this.option("trapFocus") && document.addEventListener("focus", this.onFocus, !0), this.$container.addEventListener("click", this.onClick) } }, { key: "detachEvents", value: function () { document.removeEventListener("mousedown", this.onMousedown), document.removeEventListener("keydown", this.onKeydown, !0), document.removeEventListener("focus", this.onFocus, !0), this.$container.removeEventListener("click", this.onClick) } }, { key: "initLayout", value: function () { var t = this; this.$root = this.option("parentEl") || document.body; var e = this.option("template.main"); e && (this.$root.insertAdjacentHTML("beforeend", this.localize(e)), this.$container = this.$root.querySelector(".fancybox__container")), this.$container || (this.$container = document.createElement("div"), this.$root.appendChild(this.$container)), this.$container.onscroll = function () { return t.$container.scrollLeft = 0, !1 }, Object.entries({ class: "fancybox__container", role: "dialog", tabIndex: "-1", "aria-modal": "true", "aria-hidden": "true", "aria-label": this.localize("{{MODAL}}") }).forEach((function (e) { var i; return (i = t.$container).setAttribute.apply(i, m(e)) })), this.option("animated") && this.$container.classList.add("is-animated"), this.$backdrop = this.$container.querySelector(".fancybox__backdrop"), this.$backdrop || (this.$backdrop = document.createElement("div"), this.$backdrop.classList.add("fancybox__backdrop"), this.$container.appendChild(this.$backdrop)), this.$carousel = this.$container.querySelector(".fancybox__carousel"), this.$carousel || (this.$carousel = document.createElement("div"), this.$carousel.classList.add("fancybox__carousel"), this.$container.appendChild(this.$carousel)), this.$container.Fancybox = this, this.id = this.$container.getAttribute("id"), this.id || (this.id = this.options.id || ++st, this.$container.setAttribute("id", "fancybox-" + this.id)); var i, n = this.option("mainClass"); n && (i = this.$container.classList).add.apply(i, m(n.split(" "))); return document.documentElement.classList.add("with-fancybox"), this.trigger("initLayout"), this } }, { key: "setItems", value: function (t) { var e, i = [], n = x(t); try { for (n.s(); !(e = n.n()).done;) { var o = e.value, a = o.$trigger; if (a) { var s = a.dataset || {}; o.src = s.src || a.getAttribute("href") || o.src, o.type = s.type || o.type, !o.src && a instanceof HTMLImageElement && (o.src = a.currentSrc || o.$trigger.src) } var r = o.$thumb; if (!r) { var l = o.$trigger && o.$trigger.origTarget; l && (r = l instanceof HTMLImageElement ? l : l.querySelector("img:not([aria-hidden])")), !r && o.$trigger && (r = o.$trigger instanceof HTMLImageElement ? o.$trigger : o.$trigger.querySelector("img:not([aria-hidden])")) } o.$thumb = r || null; var c = o.thumb; !c && r && !(c = r.currentSrc || r.src) && r.dataset && (c = r.dataset.lazySrc || r.dataset.src), c || "image" !== o.type || (c = o.src), o.thumb = c || null, o.caption = o.caption || "", i.push(o) } } catch (t) { n.e(t) } finally { n.f() } this.items = i } }, { key: "initCarousel", value: function () { var t = this; return this.Carousel = new H(this.$carousel, k(!0, {}, { prefix: "", classNames: { viewport: "fancybox__viewport", track: "fancybox__track", slide: "fancybox__slide" }, textSelection: !0, preload: this.option("preload"), friction: .88, slides: this.items, initialPage: this.options.startIndex, slidesPerPage: 1, infiniteX: this.option("infinite"), infiniteY: !0, l10n: this.option("l10n"), Dots: !1, Navigation: { classNames: { main: "fancybox__nav", button: "carousel__button", next: "is-next", prev: "is-prev" } }, Panzoom: { textSelection: !0, panOnlyZoomed: function () { return t.Carousel && t.Carousel.pages && t.Carousel.pages.length < 2 && !t.option("dragToClose") }, lockAxis: function () { if (t.Carousel) { var e = "x"; return t.option("dragToClose") && (e += "y"), e } } }, on: { "*": function (e) { for (var i = arguments.length, n = new Array(i > 1 ? i - 1 : 0), o = 1; o < i; o++)n[o - 1] = arguments[o]; return t.trigger.apply(t, ["Carousel.".concat(e)].concat(n)) }, init: function (e) { return t.Carousel = e }, createSlide: this.onCreateSlide, settle: this.onSettle } }, this.option("Carousel"))), this.option("dragToClose") && this.Carousel.Panzoom.on({ touchMove: this.onTouchMove, afterTransform: this.onTransform, touchEnd: this.onTouchEnd }), this.trigger("initCarousel"), this } }, { key: "onCreateSlide", value: function (t, e) { var i = e.caption || ""; if ("function" == typeof this.options.caption && (i = this.options.caption.call(this, this, this.Carousel, e)), "string" == typeof i && i.length) { var n = document.createElement("div"), o = "fancybox__caption_".concat(this.id, "_").concat(e.index); n.className = "fancybox__caption", n.innerHTML = i, n.setAttribute("id", o), e.$caption = e.$el.appendChild(n), e.$el.classList.add("has-caption"), e.$el.setAttribute("aria-labelledby", o) } } }, { key: "onSettle", value: function () { this.option("autoFocus") && this.focus() } }, { key: "onFocus", value: function (t) { this.isTopmost() && this.focus(t) } }, { key: "onClick", value: function (t) { if (!t.defaultPrevented) { var e = t.composedPath()[0]; if (e.matches("[data-fancybox-close]")) return t.preventDefault(), void i.close(!1, t); if (e.matches("[data-fancybox-next]")) return t.preventDefault(), void i.next(); if (e.matches("[data-fancybox-prev]")) return t.preventDefault(), void i.prev(); var n = document.activeElement; if (n) { if (n.closest("[contenteditable]")) return; e.matches(X) || n.blur() } if (!e.closest(".fancybox__content")) if (!getSelection().toString().length) if (!1 !== this.trigger("click", t)) switch (this.option("click")) { case "close": this.close(); break; case "next": this.next() } } } }, { key: "onTouchMove", value: function () { var t = this.getSlide().Panzoom; return !t || 1 === t.content.scale } }, { key: "onTouchEnd", value: function (t) { var e = t.dragOffset.y; Math.abs(e) >= 150 || Math.abs(e) >= 35 && t.dragOffset.time < 350 ? (this.option("hideClass") && (this.getSlide().hideClass = "fancybox-throwOut".concat(t.content.y < 0 ? "Up" : "Down")), this.close()) : "y" === t.lockAxis && t.panTo({ y: 0 }) } }, { key: "onTransform", value: function (t) { if (this.$backdrop) { var e = Math.abs(t.content.y), i = e < 1 ? "" : Math.max(.33, Math.min(1, 1 - e / t.content.fitHeight * 1.5)); this.$container.style.setProperty("--fancybox-ts", i ? "0s" : ""), this.$container.style.setProperty("--fancybox-opacity", i) } } }, { key: "onMousedown", value: function () { "ready" === this.state && document.body.classList.add("is-using-mouse") } }, { key: "onKeydown", value: function (t) { if (this.isTopmost()) { document.body.classList.remove("is-using-mouse"); var e = t.key, i = this.option("keyboard"); if (i && !t.ctrlKey && !t.altKey && !t.shiftKey) { var n = t.composedPath()[0], o = document.activeElement && document.activeElement.classList, a = o && o.contains("carousel__button"); if ("Escape" !== e && !a) if (t.target.isContentEditable || -1 !== ["BUTTON", "TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO"].indexOf(n.nodeName)) return; if (!1 !== this.trigger("keydown", e, t)) { var s = i[e]; "function" == typeof this[s] && this[s]() } } } } }, { key: "getSlide", value: function () { var t = this.Carousel; if (!t) return null; var e = null === t.page ? t.option("initialPage") : t.page, i = t.pages || []; return i.length && i[e] ? i[e].slides[0] : null } }, { key: "focus", value: function (t) { if (!(i.ignoreFocusChange || ["init", "closing", "customClosing", "destroy"].indexOf(this.state) > -1)) { var e = this.$container, n = this.getSlide(), o = "done" === n.state ? n.$el : null; if (!o || !o.contains(document.activeElement)) { t && t.preventDefault(), i.ignoreFocusChange = !0; for (var a, s = [], r = 0, l = Array.from(e.querySelectorAll(X)); r < l.length; r++) { var c = l[r], h = c.offsetParent, d = o && o.contains(c), u = !this.Carousel.$viewport.contains(c); h && (d || u) ? (s.push(c), void 0 !== c.dataset.origTabindex && (c.tabIndex = c.dataset.origTabindex, c.removeAttribute("data-orig-tabindex")), (c.hasAttribute("autoFocus") || !a && d && !c.classList.contains("carousel__button")) && (a = c)) : (c.dataset.origTabindex = void 0 === c.dataset.origTabindex ? c.getAttribute("tabindex") : c.dataset.origTabindex, c.tabIndex = -1) } t ? s.indexOf(t.target) > -1 ? this.lastFocus = t.target : this.lastFocus === e ? q(s[s.length - 1]) : q(e) : this.option("autoFocus") && a ? q(a) : s.indexOf(document.activeElement) < 0 && q(e), this.lastFocus = document.activeElement, i.ignoreFocusChange = !1 } } } }, { key: "hideScrollbar", value: function () { if (W) { var t = window.innerWidth - document.documentElement.getBoundingClientRect().width, e = "fancybox-style-noscroll", i = document.getElementById(e); i || t > 0 && ((i = document.createElement("style")).id = e, i.type = "text/css", i.innerHTML = ".compensate-for-scrollbar {padding-right: ".concat(t, "px;}"), document.getElementsByTagName("head")[0].appendChild(i), document.body.classList.add("compensate-for-scrollbar")) } } }, { key: "revealScrollbar", value: function () { document.body.classList.remove("compensate-for-scrollbar"); var t = document.getElementById("fancybox-style-noscroll"); t && t.remove() } }, { key: "clearContent", value: function (t) { this.Carousel.trigger("removeSlide", t), t.$content && (t.$content.remove(), t.$content = null), t.$closeButton && (t.$closeButton.remove(), t.$closeButton = null), t._className && t.$el.classList.remove(t._className) } }, { key: "setContent", value: function (t, e) { var i, n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {}, o = t.$el; if (e instanceof HTMLElement) ["img", "iframe", "video", "audio"].indexOf(e.nodeName.toLowerCase()) > -1 ? (i = document.createElement("div")).appendChild(e) : i = e; else { var a = document.createRange().createContextualFragment(e); (i = document.createElement("div")).appendChild(a) } if (t.filter && !t.error && (i = i.querySelector(t.filter)), i instanceof Element) return t._className = "has-".concat(n.suffix || t.type || "unknown"), o.classList.add(t._className), i.classList.add("fancybox__content"), "none" !== i.style.display && "none" !== getComputedStyle(i).getPropertyValue("display") || (i.style.display = t.display || this.option("defaultDisplay") || "flex"), t.id && i.setAttribute("id", t.id), t.$content = i, o.prepend(i), this.manageCloseButton(t), "loading" !== t.state && this.revealContent(t), i; this.setError(t, "{{ELEMENT_NOT_FOUND}}") } }, { key: "manageCloseButton", value: function (t) { var e = this, i = void 0 === t.closeButton ? this.option("closeButton") : t.closeButton; if (i && ("top" !== i || !this.$closeButton)) { var n = document.createElement("button"); n.classList.add("carousel__button", "is-close"), n.setAttribute("title", this.options.l10n.CLOSE), n.innerHTML = this.option("template.closeButton"), n.addEventListener("click", (function (t) { return e.close(t) })), "inside" === i ? (t.$closeButton && t.$closeButton.remove(), t.$closeButton = t.$content.appendChild(n)) : this.$closeButton = this.$container.insertBefore(n, this.$container.firstChild) } } }, { key: "revealContent", value: function (t) { var e = this; this.trigger("reveal", t), t.$content.style.visibility = ""; var i = !1; t.error || "loading" === t.state || null !== this.Carousel.prevPage || t.index !== this.options.startIndex || (i = void 0 === t.showClass ? this.option("showClass") : t.showClass), i ? (t.state = "animating", this.animateCSS(t.$content, i, (function () { e.done(t) }))) : this.done(t) } }, { key: "animateCSS", value: function (t, e, i) { if (t && t.dispatchEvent(new CustomEvent("animationend", { bubbles: !0, cancelable: !0 })), t && e) { t.addEventListener("animationend", (function n(o) { o.currentTarget === this && (t.removeEventListener("animationend", n), i && i(), t.classList.remove(e)) })), t.classList.add(e) } else "function" == typeof i && i() } }, { key: "done", value: function (t) { t.state = "done", this.trigger("done", t); var e = this.getSlide(); e && t.index === e.index && this.option("autoFocus") && this.focus() } }, { key: "setError", value: function (t, e) { t.error = e, this.hideLoading(t), this.clearContent(t); var i = document.createElement("div"); i.classList.add("fancybox-error"), i.innerHTML = this.localize(e || "<p>{{ERROR}}</p>"), this.setContent(t, i, { suffix: "error" }) } }, { key: "showLoading", value: function (t) { var e = this; t.state = "loading", t.$el.classList.add("is-loading"); var i = t.$el.querySelector(".fancybox__spinner"); i || ((i = document.createElement("div")).classList.add("fancybox__spinner"), i.innerHTML = this.option("template.spinner"), i.addEventListener("click", (function () { e.Carousel.Panzoom.velocity || e.close() })), t.$el.prepend(i)) } }, { key: "hideLoading", value: function (t) { var e = t.$el && t.$el.querySelector(".fancybox__spinner"); e && (e.remove(), t.$el.classList.remove("is-loading")), "loading" === t.state && (this.trigger("load", t), t.state = "ready") } }, { key: "next", value: function () { var t = this.Carousel; t && t.pages.length > 1 && t.slideNext() } }, { key: "prev", value: function () { var t = this.Carousel; t && t.pages.length > 1 && t.slidePrev() } }, { key: "jumpTo", value: function () { var t; this.Carousel && (t = this.Carousel).slideTo.apply(t, arguments) } }, { key: "isClosing", value: function () { return ["closing", "customClosing", "destroy"].includes(this.state) } }, { key: "isTopmost", value: function () { return i.getInstance().id == this.id } }, { key: "close", value: function (t) { var e = this; if (t && t.preventDefault(), !this.isClosing() && !1 !== this.trigger("shouldClose", t) && (this.state = "closing", this.Carousel.Panzoom.destroy(), this.detachEvents(), this.trigger("closing", t), "destroy" !== this.state)) { this.$container.setAttribute("aria-hidden", "true"), this.$container.classList.add("is-closing"); var i = this.getSlide(); if (this.Carousel.slides.forEach((function (t) { t.$content && t.index !== i.index && e.Carousel.trigger("removeSlide", t) })), "closing" === this.state) { var n = void 0 === i.hideClass ? this.option("hideClass") : i.hideClass; this.animateCSS(i.$content, n, (function () { e.destroy() }), !0) } } } }, { key: "destroy", value: function () { if ("destroy" !== this.state) { this.state = "destroy", this.trigger("destroy"); var t = this.option("placeFocusBack") ? this.option("triggerTarget", this.getSlide().$trigger) : null; this.Carousel.destroy(), this.detachPlugins(), this.Carousel = null, this.options = {}, this.events = {}, this.$container.remove(), this.$container = this.$backdrop = this.$carousel = null, t && q(t), at.delete(this.id); var e = i.getInstance(); e ? e.focus() : (document.documentElement.classList.remove("with-fancybox"), document.body.classList.remove("is-using-mouse"), this.revealScrollbar()) } } }], [{ key: "show", value: function (t) { var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}; return new i(t, e) } }, { key: "fromEvent", value: function (t) { var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}; if (!t.defaultPrevented && !(t.button && 0 !== t.button || t.ctrlKey || t.metaKey || t.shiftKey)) { var n, o, a, s = t.composedPath()[0], r = s; if ((r.matches("[data-fancybox-trigger]") || (r = r.closest("[data-fancybox-trigger]"))) && (e.triggerTarget = r, n = r && r.dataset && r.dataset.fancyboxTrigger), n) { var l = document.querySelectorAll('[data-fancybox="'.concat(n, '"]')), c = parseInt(r.dataset.fancyboxIndex, 10) || 0; r = l.length ? l[c] : r } Array.from(i.openers.keys()).reverse().some((function (e) { a = r || s; var i = !1; try { a instanceof Element && ("string" == typeof e || e instanceof String) && (i = a.matches(e) || (a = a.closest(e))) } catch (t) { } return !!i && (t.preventDefault(), o = e, !0) })); var h = !1; if (o) { e.event = t, e.target = a, a.origTarget = s, h = i.fromOpener(o, e); var d = i.getInstance(); d && "ready" === d.state && t.detail && document.body.classList.add("is-using-mouse") } return h } } }, { key: "fromOpener", value: function (t) { var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}, n = function (t) { for (var e = ["false", "0", "no", "null", "undefined"], i = ["true", "1", "yes"], n = Object.assign({}, t.dataset), o = {}, a = 0, s = Object.entries(n); a < s.length; a++) { var r = g(s[a], 2), l = r[0], c = r[1]; if ("fancybox" !== l) if ("width" === l || "height" === l) o["_".concat(l)] = c; else if ("string" == typeof c || c instanceof String) if (e.indexOf(c) > -1) o[l] = !1; else if (i.indexOf(o[l]) > -1) o[l] = !0; else try { o[l] = JSON.parse(c) } catch (t) { o[l] = c } else o[l] = c } return t instanceof Element && (o.$trigger = t), o }, o = [], a = e.startIndex || 0, s = e.target || null, r = void 0 !== (e = k({}, e, i.openers.get(t))).groupAll && e.groupAll, l = void 0 === e.groupAttr ? "data-fancybox" : e.groupAttr, c = l && s ? s.getAttribute("".concat(l)) : ""; if (!s || c || r) { var h = e.root || (s ? s.getRootNode() : document.body); o = [].slice.call(h.querySelectorAll(t)) } if (s && !r && (o = c ? o.filter((function (t) { return t.getAttribute("".concat(l)) === c })) : [s]), !o.length) return !1; var d = i.getInstance(); return !(d && o.indexOf(d.options.$trigger) > -1) && (a = s ? o.indexOf(s) : a, new i(o = o.map(n), k({}, e, { startIndex: a, $trigger: s }))) } }, { key: "bind", value: function (t) { var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}; function n() { document.body.addEventListener("click", i.fromEvent, !1) } W && (i.openers.size || (/complete|interactive|loaded/.test(document.readyState) ? n() : document.addEventListener("DOMContentLoaded", n)), i.openers.set(t, e)) } }, { key: "unbind", value: function (t) { i.openers.delete(t), i.openers.size || i.destroy() } }, { key: "destroy", value: function () { for (var t; t = i.getInstance();)t.destroy(); i.openers = new Map, document.body.removeEventListener("click", i.fromEvent, !1) } }, { key: "getInstance", value: function (t) { return t ? at.get(t) : Array.from(at.values()).reverse().find((function (t) { return !t.isClosing() && t })) || null } }, { key: "close", value: function () { var t = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0], e = arguments.length > 1 ? arguments[1] : void 0; if (t) { var n, o = x(at.values()); try { for (o.s(); !(n = o.n()).done;) { var a = n.value; a.close(e) } } catch (t) { o.e(t) } finally { o.f() } } else { var s = i.getInstance(); s && s.close(e) } } }, { key: "next", value: function () { var t = i.getInstance(); t && t.next() } }, { key: "prev", value: function () { var t = i.getInstance(); t && t.prev() } }]), i }(O); rt.version = "4.0.31", rt.defaults = ot, rt.openers = new Map, rt.Plugins = nt, rt.bind("[data-fancybox]"); for (var lt = 0, ct = Object.entries(rt.Plugins || {}); lt < ct.length; lt++) { var ht = g(ct[lt], 2); ht[0]; var dt = ht[1]; "function" == typeof dt.create && dt.create(rt) } t.Carousel = H, t.Fancybox = rt, t.Panzoom = M }));

/*!
   Zoom 1.7.21
   license: MIT
   http://www.jacklmoore.com/zoom
*/
(function (o) { var t = { url: !1, callback: !1, target: !1, duration: 120, on: "mouseover", touch: !0, onZoomIn: !1, onZoomOut: !1, magnify: 1 }; o.zoom = function (t, n, e, i) { var u, c, a, r, m, l, s, f = o(t), h = f.css("position"), d = o(n); return t.style.position = /(absolute|fixed)/.test(h) ? h : "relative", t.style.overflow = "hidden", e.style.width = e.style.height = "", o(e).addClass("zoomImg").css({ position: "absolute", top: 0, left: 0, opacity: 0, width: e.width * i, height: e.height * i, border: "none", maxWidth: "none", maxHeight: "none" }).appendTo(t), { init: function () { c = f.outerWidth(), u = f.outerHeight(), n === t ? (r = c, a = u) : (r = d.outerWidth(), a = d.outerHeight()), m = (e.width - c) / r, l = (e.height - u) / a, s = d.offset() }, move: function (o) { var t = o.pageX - s.left, n = o.pageY - s.top; n = Math.max(Math.min(n, a), 0), t = Math.max(Math.min(t, r), 0), e.style.left = t * -m + "px", e.style.top = n * -l + "px" } } }, o.fn.zoom = function (n) { return this.each(function () { var e = o.extend({}, t, n || {}), i = e.target && o(e.target)[0] || this, u = this, c = o(u), a = document.createElement("img"), r = o(a), m = "mousemove.zoom", l = !1, s = !1; if (!e.url) { var f = u.querySelector("img"); if (f && (e.url = f.getAttribute("data-src") || f.currentSrc || f.src), !e.url) return } c.one("zoom.destroy", function (o, t) { c.off(".zoom"), i.style.position = o, i.style.overflow = t, a.onload = null, r.remove() }.bind(this, i.style.position, i.style.overflow)), a.onload = function () { function t(t) { f.init(), f.move(t), r.stop().fadeTo(o.support.opacity ? e.duration : 0, 1, o.isFunction(e.onZoomIn) ? e.onZoomIn.call(a) : !1) } function n() { r.stop().fadeTo(e.duration, 0, o.isFunction(e.onZoomOut) ? e.onZoomOut.call(a) : !1) } var f = o.zoom(i, u, a, e.magnify); "grab" === e.on ? c.on("mousedown.zoom", function (e) { 1 === e.which && (o(document).one("mouseup.zoom", function () { n(), o(document).off(m, f.move) }), t(e), o(document).on(m, f.move), e.preventDefault()) }) : "click" === e.on ? c.on("click.zoom", function (e) { return l ? void 0 : (l = !0, t(e), o(document).on(m, f.move), o(document).one("click.zoom", function () { n(), l = !1, o(document).off(m, f.move) }), !1) }) : "toggle" === e.on ? c.on("click.zoom", function (o) { l ? n() : t(o), l = !l }) : "mouseover" === e.on && (f.init(), c.on("mouseenter.zoom", t).on("mouseleave.zoom", n).on(m, f.move)), e.touch && c.on("touchstart.zoom", function (o) { o.preventDefault(), s ? (s = !1, n()) : (s = !0, t(o.originalEvent.touches[0] || o.originalEvent.changedTouches[0])) }).on("touchmove.zoom", function (o) { o.preventDefault(), f.move(o.originalEvent.touches[0] || o.originalEvent.changedTouches[0]) }).on("touchend.zoom", function (o) { o.preventDefault(), s && (s = !1, n()) }), o.isFunction(e.callback) && e.callback.call(a) }, a.setAttribute("role", "presentation"), a.alt = "", a.src = e.url }) }, o.fn.zoom.defaults = t })(window.jQuery);


// Custom Scripts here

$.noConflict();

jQuery(document).ready(function () {

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    jQuery(".next").on('click', function () {

        current_fs = jQuery(this).parent();
        next_fs = jQuery(this).parent().next();

        //Add Class Active
        jQuery("#progressbar li").eq(jQuery("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({ 'opacity': opacity });
            },
            duration: 600
        });
    });

    jQuery(".previous").on('click', function () {

        current_fs = jQuery(this).parent();
        previous_fs = jQuery(this).parent().prev();

        //Remove class active
        jQuery("#progressbar li").eq(jQuery("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({ 'opacity': opacity });
            },
            duration: 600
        });
    });

    jQuery('.radio-group .radio').on('click', function () {
        jQuery(this).parent().find('.radio').removeClass('selected');
        jQuery(this).addClass('selected');
    });

    jQuery(".submit").on('click', function () {
        return false;
    })

});



// Tooltip
jQuery(function () {
    jQuery('[data-bs-toggle="tooltip"]').tooltip();
})
jQuery('.slide-toggle').on('click', function (event) {
    jQuery('.switcher').toggleClass('active');
});

jQuery('.se-pre-con a').on('click', function (event) {
    event.preventDefault();
    // Do other stuff if needed
});
jQuery('.se-pre-con .btn').on('click', function (event) {
    event.preventDefault();
    // Do other stuff if needed
});

//paste this code under head tag or in a seperate js file.
// Wait for window load
jQuery(window).on('load', function () {
    // Animate loader off screen

    jQuery('.se-pre-con').fadeOut("slow");
    jQuery('.wrapper').fadeIn("slow");

    jQuery(window).trigger("resize");
});

document.querySelector('[data-switch-dark]').addEventListener('click', function () {
    document.body.classList.toggle('dark');
});


// Fancy Box For Product Detail Page
jQuery(document).ready(function () {
    jQuery(".fancybox-button").fancybox({
        openEffect: 'none',
        closeEffect: 'none',
        prevEffect: 'none',
        nextEffect: 'none',
        closeBtn: true,
        margin: [20, 60, 20, 60],
        helpers: {
            title: { type: 'inside' },
            buttons: {}
        }
    });
});

jQuery(".swticher-rtl").click(function () {
    jQuery("body").toggleClass("bodyrtl");
    jQuery(".swticher-rtl").toggleClass("active");
    return false;
});

jQuery(".swticher-boxed").click(function () {

    jQuery("html").toggleClass("boxed");
    jQuery(".swticher-boxed").toggleClass("active");
    return false;
});

function notificationCart() {

    jQuery('#notificationCart').show();
    setTimeout(function () {
        jQuery('#notificationCart').hide('slow');
    }, 2000);
}
function notificationWishlist() {

    jQuery('#notificationWishlist').show();
    setTimeout(function () {
        jQuery('#notificationWishlist').hide('slow');
    }, 2000);
}
function notificationCompare() {

    jQuery('#notificationCompare').show();
    setTimeout(function () {
        jQuery('#notificationCompare').hide('slow');
    }, 2000);
}
// Color Scheme Change
jQuery(document).on("click", "#switchColor a", function () {
    var cssValue = jQuery(this).attr("id");
    console.log(cssValue);
    jQuery("#switchColor li").removeClass('active');
    jQuery(this).parent().addClass('active');

    function getCurentFileName() {
        var pagePathName = window.location.pathname;
        return pagePathName.substring(pagePathName.lastIndexOf("/") + 1);
    }
    console.log('pathname ', getCurentFileName())

    let pagename = getCurentFileName();
    if (cssValue == "default") {
        for (var i = 1; i < 15; i++) {
            if (pagename === `index-${i}.html`) {
                jQuery("body").addClass(`home${i}`);
            }
        }

        jQuery('color-theme-red').remove();
        jQuery('color-theme-green').remove();
        jQuery('color-theme-blue').remove();
        jQuery('color-theme-tan').remove();
        jQuery('color-theme-yellow').remove();
        jQuery('color-theme-navy-blue').remove();
        jQuery('color-theme-dark').remove();
        jQuery('color-theme-dark-blue').remove();
    }
    return false;
});

jQuery('#default').on('click', function (e) {
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');

})
jQuery('#blue').on('click', function (e) {
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').addClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
})
jQuery('#red').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').addClass('color-theme-red');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#green').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').addClass('color-theme-green');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');



})
jQuery('#yellow').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').addClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');



})
jQuery('#navy-blue').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').addClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');



})
jQuery('#pink').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').addClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#tan').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').addClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#indigo').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').addClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#teal').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').addClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#olive').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').addClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#scarlet').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').addClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');
    

})
jQuery('#purple').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').addClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');

})
jQuery('#sapple').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').addClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#pteal').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').addClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#skylight').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').addClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#greenlight').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').addClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#graylight').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').addClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#graydark').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').addClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#shine').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').addClass('color-theme-shine');
    jQuery('body').removeClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})
jQuery('#brown').on('click', function (e) {
    jQuery('body').removeClass('color-theme-blue');
    jQuery('body').removeClass('color-theme-red');
    jQuery('body').removeClass('color-theme-green');
    jQuery('body').removeClass('color-theme-yellow');
    jQuery('body').removeClass('color-theme-navy-blue');
    jQuery('body').removeClass('color-theme-pink');
    jQuery('body').removeClass('color-theme-tan');
    jQuery('body').removeClass('color-theme-indigo');
    jQuery('body').removeClass('color-theme-teal');
    jQuery('body').removeClass('color-theme-olive');
    jQuery('body').removeClass('color-theme-scarlet');
    jQuery('body').removeClass('color-theme-purple');
    jQuery('body').removeClass('color-theme-sapple');
    jQuery('body').removeClass('color-theme-pteal');
    jQuery('body').removeClass('color-theme-skylight');
    jQuery('body').removeClass('color-theme-greenlight');
    jQuery('body').removeClass('color-theme-graylight');
    jQuery('body').removeClass('color-theme-graydark');
    jQuery('body').removeClass('color-theme-shine');
    jQuery('body').addClass('color-theme-brown');
    jQuery('body').removeClass('home2');
    jQuery('body').removeClass('home3');
    jQuery('body').removeClass('home4');
    jQuery('body').removeClass('home5');
    jQuery('body').removeClass('home6');
    jQuery('body').removeClass('home7');
    jQuery('body').removeClass('home8');
    jQuery('body').removeClass('home9');
    jQuery('body').removeClass('home10');
    jQuery('body').removeClass('home11');
    jQuery('body').removeClass('home12');
    jQuery('body').removeClass('home13');
    jQuery('body').removeClass('home-12');
    jQuery('body').removeClass('home14');
    jQuery('body').removeClass('home15');
    jQuery('body').removeClass('home16');
    jQuery('body').removeClass('home20');
    jQuery('body').removeClass('home-21');


})

//Display grid/list 4 Column
jQuery(document).ready(function () {

    jQuery('#list_4column').on('click', function () {
        jQuery('#swap .col-12').removeClass('griding');
        jQuery('#swap .col-12').removeClass('col-lg-3');

        jQuery('#swap .col-12').removeClass('col-sm-6');
        jQuery('#swap .col-12').addClass('listing');
        jQuery(this).addClass('active');
        jQuery('#grid_4column').removeClass('active');
    });
    jQuery('#grid_4column').on('click', function () {
        jQuery('#swap .col-12').removeClass('listing');
        jQuery('#swap .col-12').addClass('col-lg-3');

        jQuery('#swap .col-12').addClass('col-sm-6');

        jQuery('#swap .col-12').addClass('griding');
        jQuery(this).addClass('active');
        jQuery('#list_4column').removeClass('active');
    });


});

//Display grid/list 3 Column
jQuery(document).ready(function () {

    jQuery('#list_3column').on('click', function () {
        jQuery('#swap .col-12').removeClass('griding');
        jQuery('#swap .col-12').removeClass('col-lg-4');
        jQuery('#swap .col-12').removeClass('col-sm-6');
        jQuery('#swap .col-12').addClass('listing');
        jQuery(this).addClass('active');
        jQuery('#grid_3column').removeClass('active');
    });
    jQuery('#grid_3column').on('click', function () {
        jQuery('#swap .col-12').removeClass('listing');
        jQuery('#swap .col-12').addClass('col-lg-4');
        jQuery('#swap .col-12').addClass('col-sm-6');

        jQuery('#swap .col-12').addClass('griding');
        jQuery(this).addClass('active');
        jQuery('#list_3column').removeClass('active');
    });


});

// Add To Cart Button Enable
jQuery(document).ready(function () {

    jQuery('.color-option .product-model li a').on('click', function () {
        jQuery('.color-option .product-model li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });
    jQuery('.color-option .product1 li a').on('click', function () {
        jQuery('.color-option .product1 li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });

    jQuery('.color-option .product3 li a').on('click', function () {
        jQuery('.color-option .product3 li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });
    jQuery('.color-option .product5 li a').on('click', function () {
        jQuery('.color-option .product5 li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });

    jQuery('.color-option .product7 li a').on('click', function () {
        jQuery('.color-option .product7 li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });

    jQuery('.size-option .product-model1 li a').on('click', function () {
        jQuery('.size-option .product-model1 li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });
    jQuery('.size-option .product2 li a').on('click', function () {
        jQuery('.size-option .product2 li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });
    jQuery('.size-option .product4 li a').on('click', function () {
        jQuery('.size-option .product4 li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });
    jQuery('.size-option .product6 li a').on('click', function () {
        jQuery('.size-option .product6  li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });
    jQuery('.size-option .product8 li a').on('click', function () {
        jQuery('.size-option .product8 li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });

    jQuery('.img-option .product11 li a').on('click', function () {
        jQuery('.img-option .product11 li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });



    jQuery('.color-option .product-page li a').on('click', function () {
        jQuery('.color-option .product-page li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });

    jQuery('.size-option .product-page1 li a').on('click', function () {
        jQuery('.size-option .product-page1 li').removeClass("active");
        jQuery(this).parent().addClass("active");
    });

});



jQuery('.cta').on('click', function () {

    jQuery(this).removeClass("active");

    jQuery(this).removeClass("show");


});

jQuery('.img_static1').on('click', function () {
    jQuery('.img_static1').hide();
    jQuery('.added_video1').show();
});

jQuery('a[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {

    var hashValue = jQuery(e.target).attr('href');

    jQuery("#pills-shipping-tab").removeClass("active");
    jQuery("#pills-billing-tab").removeClass("active");
    jQuery("#pills-method-tab").removeClass("active");
    jQuery("#pills-order-tab").removeClass("active");
    jQuery(hashValue + "-tab").addClass("active");



})

jQuery(window).on('load', function () {
    jQuery('#newsletterModal').modal('show');
});
jQuery(window).on('load', function () {
    jQuery('#newsletterModal2').modal('show');
    jQuery('#newsletterModal5').modal('show');
    jQuery('#newsletterModal6').modal('show');
    jQuery('#newsletterModal7').modal('show');
    jQuery('#newsletterModal8').modal('show');

    setTimeout(function () {
        jQuery('#alert-cookie').show();
    }, 2000);

    setTimeout(function () {
        jQuery('#alert-cookie5').show();
    }, 2000);

    setTimeout(function () {
        jQuery('#alert-cookie5a').show();
    }, 3000);

    setTimeout(function () {
        jQuery('#alert-cookie2').show();
    }, 4000);

    setTimeout(function () {
        jQuery('#alert-cookie6').show();
    }, 3000);
    setTimeout(function () {
        jQuery('#alert-cookie7').show();
    }, 3000);
    setTimeout(function () {
        jQuery('#alert-cookie8').show();
    }, 3000);
    setTimeout(function () {
        jQuery('#alert-cookie8').show();
    }, 2000);


});

jQuery(document).on("click", ".alert .close", function () {

    jQuery(this).animate({ opacity: 0 }, 1000).hide('slow');
    // jQuery(".alert").slideUp(1000, function() {
    //     jQuery(this).remove();
    // });
});
//sticky header

window.onscroll = function () { myFunction() };

var header = document.getElementById("stickyHeader");

function myFunction() {
    if (header !== null && header !== undefined) {
        if (window.pageYOffset > 100) {

            header.classList.add("sticky-header");
        } else {
            header.classList.remove("sticky-header");
        }
    }

}

// Flash Sale Counter
jQuery(document).ready(function () {
    setInterval(function time() {
        var d = new Date();
        var days = 365 - d.getDay();
        var hours = 24 - d.getHours();
        var min = 60 - d.getMinutes();
        if ((min + '').length == 1) {
            min = '0' + min;
        }
        var sec = 60 - d.getSeconds();
        if ((sec + '').length == 1) {
            sec = '0' + sec;
        }
        jQuery('.countdown .days').html(days + "<small>Days</small>");
        jQuery('.countdown .hours').html(hours + "<small>Hour</small>");
        jQuery('.countdown .mintues').html(min + "<small>Min</small>");
        jQuery('.countdown .seconds').html(sec + "<small>Sec</small>");
    }, 1000);
});

//   index-2
jQuery(document).ready(function () {
    setInterval(function time() {
        var d = new Date();
        var days = 365 - d.getDay();
        var hours = 24 - d.getHours();
        var min = 60 - d.getMinutes();
        if ((min + '').length == 1) {
            min = '0' + min;
        }
        var sec = 60 - d.getSeconds();
        if ((sec + '').length == 1) {
            sec = '0' + sec;
        }
        jQuery('.countdown2 .days').html(days + "<small>d</small>");
        jQuery('.countdown2 .hours').html(hours + "<small>h</small>");
        jQuery('.countdown2 .mintues').html(min + "<small>m</small>");
        jQuery('.countdown2 .seconds').html(sec + "<small>s</small>");
    }, 1000);
});

//   index-3
jQuery(document).ready(function () {
    setInterval(function time() {
        var d = new Date();
        var days = 365 - d.getDay();
        var hours = 24 - d.getHours();
        var min = 60 - d.getMinutes();
        if ((min + '').length == 1) {
            min = '0' + min;
        }
        var sec = 60 - d.getSeconds();
        if ((sec + '').length == 1) {
            sec = '0' + sec;
        }
        jQuery('.countdown3 .days').html(days + "<small>d</small>");
        jQuery('.countdown3 .hours').html(hours + "<small>h</small>");
        jQuery('.countdown3 .mintues').html(min + "<small>m</small>");
        jQuery('.countdown3 .seconds').html(sec + "<small>s</small>");
    }, 1000);
});

//  vendor index-6
jQuery(document).ready(function () {
    setInterval(function time() {
        var d = new Date();
        var days = 365 - d.getDay();
        var hours = 24 - d.getHours();
        var min = 60 - d.getMinutes();
        if ((min + '').length == 1) {
            min = '0' + min;
        }
        var sec = 60 - d.getSeconds();
        if ((sec + '').length == 1) {
            sec = '0' + sec;
        }
        jQuery('.countdownv6 .days').html(days + "<small>Day</small>");
        jQuery('.countdownv6 .hours').html(hours + "<small>Hrs</small>");
        jQuery('.countdownv6 .mintues').html(min + "<small>Mins</small>");
        jQuery('.countdownv6 .seconds').html(sec + "<small>Sec</small>");
    }, 1000);
});

// Scroll to top

if (jQuery('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = jQuery(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                jQuery('#back-to-top').addClass('show');
            } else {
                jQuery('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    jQuery(window).on('scroll', function () {
        backToTop();
    });
    jQuery('#back-to-top').on('click', function (e) {
        e.preventDefault();
        jQuery('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}

// Mobile Menu
jQuery(document).ready(function () {
    const targetElement = document.getElementById("popup"); //only popup can scroll

    jQuery('.navigation-mobile-toggler').on('click', function () {

        jQuery('#navigation-mobile').toggleClass('navigation-active');
        jQuery('.mobile-overlay').addClass('active');

        // //put this when popup opens, to stop body scrolling
        // bodyScrollLock.disableBodyScroll(targetElement);
        jQuery('html').css('overflow', 'hidden');
        jQuery('body').css('overflow', 'hidden');
    });

    jQuery('.mobile-overlay').on('click', function () {
        jQuery('#navigation-mobile').removeClass('navigation-active');
        jQuery('.mobile-overlay').removeClass('active');

        //put this when close popup and show scrollbar in body
        // bodyScrollLock.enableBodyScroll(targetElement);

        jQuery('html').css('overflow', 'auto');
        jQuery('body').css('overflow', 'auto');
    });
});

// Header 3 Searchbar
jQuery(document).ready(function () {
    jQuery('#dropdownSearch').on('click', function () {
        jQuery('#dropdown-searchbar').css('display', 'block');
    });

    jQuery('.close').on('click', function () {
        jQuery('#dropdown-searchbar').css('display', 'none');
    });
});

jQuery(document).ready(function () {
    var quantitiy = 0;
    jQuery('.quantity-minus').click(function (e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name

        p_id = jQuery(this).val();
        var quantity = parseInt(jQuery("#" + p_id).val());
        if (quantity != 0)
            jQuery("#" + p_id).val(quantity - 1);

        // Decrement
        console.log('p_id', p_id);
    });
    jQuery('.quantity-plus').click(function (e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name

        p_id = jQuery(this).val();
        var quantity = parseInt(jQuery("#" + p_id).val());
        jQuery("#" + p_id).val(quantity + 1);

        // Increment

    });
});
// Quantiy Counter

jQuery(document).ready(function () {
    var quantitiy = 0;
    jQuery('.quantity-left-minus').click(function (e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity').val());

        // If is not undefined

        jQuery('#quantity').val(quantity + 1);

        // Increment

    });

    jQuery('.quantity-right-plus').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity').val());

        // If is not undefined

        // Increment
        if (quantity > 0) {
            jQuery('#quantity').val(quantity - 1);
        }
    });
});

// Quantiy Counter Product
jQuery(document).ready(function () {
    var quantitiy = 0;
    jQuery('.quantity-plus').click(function (e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity').val());

        // If is not undefined

        jQuery('#quantity').val(quantity + 1);

        // Increment

    });

    jQuery('.quantity-minus').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity').val());

        // If is not undefined

        // Increment
        if (quantity > 0) {
            jQuery('#quantity').val(quantity - 1);
        }
    });
});
jQuery(document).ready(function () {
    var quantitiy = 0;
    jQuery('.quantity-plus1').click(function (e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity1').val());

        // If is not undefined

        jQuery('#quantity1').val(quantity + 1);

        // Increment

    });

    jQuery('.quantity-minus1').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity1').val());

        // If is not undefined

        // Increment
        if (quantity > 0) {
            jQuery('#quantity1').val(quantity - 1);
        }
    });
});

jQuery(document).ready(function () {
    var quantitiy = 0;
    jQuery('.quantity-plus2').click(function (e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity2').val());

        // If is not undefined

        jQuery('#quantity2').val(quantity + 1);

        // Increment

    });

    jQuery('.quantity-minus2').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity2').val());

        // If is not undefined

        // Increment
        if (quantity > 0) {
            jQuery('#quantity2').val(quantity - 1);
        }
    });
});

jQuery(document).ready(function () {
    var quantitiy = 0;
    jQuery('.quantity-plus3').click(function (e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity3').val());

        // If is not undefined

        jQuery('#quantity3').val(quantity + 1);

        // Increment

    });

    jQuery('.quantity-minus3').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity3').val());

        // If is not undefined

        // Increment
        if (quantity > 0) {
            jQuery('#quantity3').val(quantity - 1);
        }
    });
});

jQuery(document).ready(function () {
    var quantitiy = 0;
    jQuery('.quantity-plus4').click(function (e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity4').val());

        // If is not undefined

        jQuery('#quantity4').val(quantity + 1);

        // Increment

    });

    jQuery('.quantity-minus4').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(jQuery('#quantity4').val());

        // If is not undefined

        // Increment
        if (quantity > 0) {
            jQuery('#quantity4').val(quantity - 1);
        }
    });
});

// Wait for the DOM to be ready
jQuery(function () {

    jQuery.validator.addMethod("valueNotEquals", function (value, element, arg) {
        return arg !== value;
    }, "Value must not equal arg.");

    // Initialize form validation on the general-form form.
    // It has the name attribute "general-form"
    jQuery("form[name='general-form']").validate({
        // Specify validation rules



        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            fullname: "required",
            firstname: "required",
            lastname: "required",
            address: "required",

            SelectName: { valueNotEquals: "default" },
            SelectStateName: { valueNotEquals: "default" },
            postcode: "required",

            phone: "required",

            email: {
                required: true,
                // Specify that email should be validated
                // by the built-in "email" rule
                email: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        // Specify validation error messages
        messages: {
            fullname: "Please enter your fullname",
            firstname: "Please enter your firstname",
            lastname: "Please enter your lastname",
            address: "Please enter your address",

            SelectName: { valueNotEquals: "Please select an Option!" },
            SelectStateName: { valueNotEquals: "Please select an Option!" },

            postcode: "Please enter postal code",

            phone: "Please enter your phone number",

            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            email: "Please enter a valid email address"
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            form.submit();
        }
    });
});

// Wait for the DOM to be ready
jQuery(function () {

    jQuery.validator.addMethod("valueNotEquals", function (value, element, arg) {
        return arg !== value;
    }, "Value must not equal arg.");

    // Initialize form validation on the login form.
    // It has the name attribute "login"
    jQuery("form[name='login']").validate({
        // Specify validation rules



        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side

            email: {
                required: true,
                // Specify that email should be validated
                // by the built-in "email" rule
                email: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        // Specify validation error messages
        messages: {

            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            email: "Please enter a valid email address"
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            form.submit();
        }
    });
});

// Wait for the DOM to be ready
jQuery(function () {
    // Initialize form validation on the contact form.
    // It has the name attribute "contact"
    jQuery("form[name='contact']").validate({
        // Specify validation rules
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            name: "required",
            subject: "required",
            email: {
                required: true,
                // Specify that email should be validated
                // by the built-in "email" rule
                email: true
            },
            msg: "required"
        },
        // Specify validation error messages
        messages: {
            name: "Please enter your name",
            subject: "Please enter your subject",
            email: "Please enter a valid email address",
            msg: "Please enter your message",
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            jQuery.ajax({
                url: "contact.php",
                type: "POST",
                data: jQuery(form).serialize(),
                cache: false,
                processData: false,
                success: function (data) {
                    jQuery("#alert-box").show();
                    jQuery("#alert-msg").html(data);


                    //setTimeout(function(){ jQuery("#alert-msg").show(); }, 2000);


                }
            });


            return false;
        }
    });
});

// Product SLICK
jQuery('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    infinite: false,
    draggable: false,
    fade: true,
    asNavFor: '.slider-nav'
});
jQuery('.slider-nav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    centerMode: true,
    centerPadding: '30px',
    dots: false,
    arrows: true,
    focusOnSelect: true
});

//product card
jQuery('.slider-for-card').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    infinite: false,
    draggable: false,
    autoplay: true,
    autoplaySpeed: 1000,
    fade: true,
    asNavFor: '.slider-nav-card'
});
jQuery('.slider-nav-card').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.slider-for-card',
    centerMode: false,
    centerPadding: '30px',
    dots: false,
    arrows: true,
    focusOnSelect: true
});

// Product vertical SLICK
jQuery('.slider-for-vertical').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    infinite: false,
    draggable: false,
    fade: true,
    asNavFor: '.slider-nav-vertical'
});
jQuery('.slider-nav-vertical').slick({
    dots: false,
    arrows: true,
    vertical: true,
    asNavFor: '.slider-for-vertical',
    slidesToShow: 3,
    // centerMode: true,
    slidesToScroll: 1,
    verticalSwiping: true,
    focusOnSelect: true
});

jQuery(function () {
    // ZOOM
    jQuery('.ex1').zoom();

});

var tpj = jQuery;
var revapi1077;
tpj(document).ready(function () {
    if (tpj("#rev_slider_1077_1").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_1077_1");
    } else {
        revapi1077 = tpj("#rev_slider_1077_1").show().revolution({
            sliderType: "standard",
            jsFileLocation: "../revolution/js/",
            //sliderLayout:"fullscreen",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                mouseScrollReverse: "default",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                }
                ,
                bullets: {
                    enable: true,
                    hide_onmobile: true,
                    hide_under: 960,
                    style: "hermes",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "center",
                    v_align: "bottom",
                    h_offset: 0,
                    v_offset: 30,
                    space: 5,
                    tmp: ''
                }
            },
            responsiveLevels: [1400, 1200, 992, 576],
            visibilityLevels: [1400, 1200, 992, 576],
            gridwidth: [1280, 992, 676, 320],
            gridheight: [520, 380, 300, 220],
            lazyType: "none",
            parallax: {
                type: "mouse",
                origo: "slidercenter",
                speed: 2000,
                levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50, 46, 47, 48, 49, 50, 55],
                type: "mouse",
                disable_onmobile: "on"
            },
            shadow: 0,
            spinner: "off",
            stopLoop: "on",
            stopAfterLoops: 0,
            stopAtSlide: 0,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAutoWidth: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "60px",
            disableProgressBar: "on",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                nextSlideOnWindowFocus: "off",
                disableFocusListener: false,
            }
        });
        var newCall = new Object(),
            cslide;

        newCall.callback = function () {
            var proc = revapi1077.revgetparallaxproc(),
                fade = 1 + proc,
                scale = 1 + (Math.abs(proc) / 10);

            punchgs.TweenLite.set(revapi1077.find('.slotholder, .rs-background-video-layer'), { opacity: fade, scale: scale });
        }
        newCall.inmodule = "parallax";
        newCall.atposition = "start";

        // revapi1077.bind("revolution.slide.onloaded",function (e) {
        // revapi1077.revaddcallback(newCall);
        // });				
    }
});	/*ready*/


var tpj = jQuery;
tpj(document).ready(function () {
    if (tpj("#rev_slider_1077_6").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_1077_6");
    } else {
        revapi1077 = tpj("#rev_slider_1077_6").show().revolution({
            sliderType: "standard",
            jsFileLocation: "../revolution/js/",
            //sliderLayout:"fullscreen",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                mouseScrollReverse: "default",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                }
                ,
                arrows: {
                    enable: true,
                    hide_onmobile: true,
                    hide_under: 992,
                    style: "hermes",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "center",
                    v_align: "bottom",
                    h_offset: 0,
                    v_offset: 30,
                    space: 5,
                    tmp: ''
                }
            },
            responsiveLevels: [1400, 1200, 992, 576],
            visibilityLevels: [1400, 1200, 992, 576],
            gridwidth: [1280, 992, 676, 320],
            gridheight: [600, 380, 300, 220],
            lazyType: "none",
            parallax: {
                type: "mouse",
                origo: "slidercenter",
                speed: 2000,
                levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50, 46, 47, 48, 49, 50, 55],
                type: "mouse",
                disable_onmobile: "on"
            },
            shadow: 0,
            spinner: "off",
            stopLoop: "on",
            stopAfterLoops: 0,
            stopAtSlide: 0,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAutoWidth: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "60px",
            disableProgressBar: "on",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                nextSlideOnWindowFocus: "off",
                disableFocusListener: false,
            }
        });
        var newCall = new Object(),
            cslide;

        newCall.callback = function () {
            var proc = revapi1077.revgetparallaxproc(),
                fade = 1 + proc,
                scale = 1 + (Math.abs(proc) / 10);

            punchgs.TweenLite.set(revapi1077.find('.slotholder, .rs-background-video-layer'), { opacity: fade, scale: scale });
        }
        newCall.inmodule = "parallax";
        newCall.atposition = "start";

        // revapi1077.bind("revolution.slide.onloaded",function (e) {
        // revapi1077.revaddcallback(newCall);
        // });				
    }
});

// index-2

tpj(document).ready(function () {
    if (tpj("#rev_slider_1077_2").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_1077_2");
    } else {
        revapi1077 = tpj("#rev_slider_1077_2").show().revolution({
            sliderType: "standard",
            jsFileLocation: "../revolution/js/",
            // sliderLayout:"fullscreen",
            dottedOverlay: "none",
            delay: 4000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                mouseScrollReverse: "default",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                }
                ,
                bullets: {
                    enable: false,
                    hide_onmobile: true,
                    hide_under: 960,
                    style: "hermes",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "right",
                    v_align: "bottom",
                    h_offset: 150,
                    v_offset: 15,
                    space: 5,
                    tmp: ''
                }
                ,
                arrows: {
                    enable: true,
                    hide_onmobile: true,
                    hide_under: 1101,
                    style: "hermes",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "center",
                    v_align: "bottom",
                    h_offset: 0,
                    v_offset: 30,
                    space: 5,
                    tmp: ''
                }
            },
            responsiveLevels: [1400, 1200, 992, 576],
            visibilityLevels: [1400, 1200, 992, 576],
            gridwidth: [1280, 992, 676, 320],
            gridheight: [520, 380, 300, 220],
            lazyType: "none",
            parallax: {
                type: "mouse",
                origo: "slidercenter",
                speed: 2000,
                levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50, 46, 47, 48, 49, 50, 55],
                type: "mouse",
                disable_onmobile: "on"
            },
            shadow: 0,
            spinner: "off",
            stopLoop: "on",
            stopAfterLoops: 0,
            stopAtSlide: 0,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAutoWidth: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "60px",
            disableProgressBar: "on",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                nextSlideOnWindowFocus: "off",
                disableFocusListener: false,
            }
        });
        var newCall = new Object(),
            cslide;

        newCall.callback = function () {
            var proc = revapi1077.revgetparallaxproc(),
                fade = 1 + proc,
                scale = 1 + (Math.abs(proc) / 10);

            punchgs.TweenLite.set(revapi1077.find('.slotholder, .rs-background-video-layer'), { opacity: fade, scale: scale });
        }
        newCall.inmodule = "parallax";
        newCall.atposition = "start";

        revapi1077.bind("revolution.slide.onloaded", function (e) {
            revapi1077.revaddcallback(newCall);
        });
    }
});	/*ready*/

// index-4
tpj(document).ready(function () {
    if (tpj("#rev_slider_1077_4").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_1077_4");
    } else {
        revapi1077 = tpj("#rev_slider_1077_4").show().revolution({
            sliderType: "standard",
            jsFileLocation: "../revolution/js/",
            //sliderLayout:"fullscreen",
            dottedOverlay: "none",
            delay: 2000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                mouseScrollReverse: "default",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                }
                ,
                bullets: {
                    enable: false,
                    hide_onmobile: true,
                    hide_under: 960,
                    style: "hermes",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "center",
                    v_align: "bottom",
                    h_offset: 0,
                    v_offset: 30,
                    space: 5,
                    tmp: ''
                }
                ,
                arrows: {
                    enable: true,
                    hide_onmobile: true,
                    style: "hermes",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "center",
                    v_align: "bottom",
                    h_offset: 0,
                    v_offset: 30,
                    space: 5,
                    tmp: ''
                }

            },
            responsiveLevels: [1400, 1200, 992, 576],
            visibilityLevels: [1400, 1200, 992, 576],
            gridwidth: [1280, 992, 576, 320],
            gridheight: [734, 380, 300, 220],
            lazyType: "none",


            shadow: 0,
            spinner: "off",
            stopLoop: "on",
            stopAfterLoops: 0,
            stopAtSlide: 0,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAutoWidth: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "60px",
            disableProgressBar: "on",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                nextSlideOnWindowFocus: "off",
                disableFocusListener: false,
            }
        });
        var newCall = new Object(),
            cslide;

        newCall.callback = function () {
            var proc = revapi1077.revgetparallaxproc(),
                fade = 1 + proc,
                scale = 1 + (Math.abs(proc) / 10);

            punchgs.TweenLite.set(revapi1077.find('.slotholder, .rs-background-video-layer'), { opacity: fade, scale: scale });
        }
        newCall.inmodule = "parallax";
        newCall.atposition = "start";

        revapi1077.bind("revolution.slide.onloaded", function (e) {
            revapi1077.revaddcallback(newCall);
        });
    }
});	/*ready*/
// index-5
tpj(document).ready(function () {
    if (tpj("#rev_slider_1077_5").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_1077_5");
    } else {
        revapi1077 = tpj("#rev_slider_1077_5").show().revolution({
            sliderType: "standard",
            jsFileLocation: "../revolution/js/",
            //sliderLayout:"fullscreen",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                mouseScrollReverse: "default",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                }
                ,
                bullets: {
                    enable: true,
                    hide_onmobile: true,
                    hide_under: 960,
                    style: "hermes",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "center",
                    v_align: "bottom",
                    h_offset: 0,
                    v_offset: 30,
                    space: 5,
                    tmp: ''
                }
            },
            responsiveLevels: [1400, 1200, 992, 576],
            visibilityLevels: [1400, 1200, 992, 576],
            gridwidth: [1280, 992, 676, 320],
            gridheight: [600, 580, 400, 250],
            lazyType: "none",
            parallax: {
                type: "mouse",
                origo: "slidercenter",
                speed: 2000,
                levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50, 46, 47, 48, 49, 50, 55],
                type: "mouse",
                disable_onmobile: "on"
            },
            shadow: 0,
            spinner: "off",
            stopLoop: "on",
            stopAfterLoops: 0,
            stopAtSlide: 0,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAutoWidth: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "60px",
            disableProgressBar: "on",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                nextSlideOnWindowFocus: "off",
                disableFocusListener: false,
            }
        });
        var newCall = new Object(),
            cslide;

        newCall.callback = function () {
            var proc = revapi1077.revgetparallaxproc(),
                fade = 1 + proc,
                scale = 1 + (Math.abs(proc) / 10);

            punchgs.TweenLite.set(revapi1077.find('.slotholder, .rs-background-video-layer'), { opacity: fade, scale: scale });
        }
        newCall.inmodule = "parallax";
        newCall.atposition = "start";

        // revapi1077.bind("revolution.slide.onloaded",function (e) {
        // revapi1077.revaddcallback(newCall);
        // });				
    }
});	/*ready*/
// index-8	
tpj(document).ready(function () {
    if (tpj("#rev_slider_1077_8").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_1077_8");
    } else {
        revapi1077 = tpj("#rev_slider_1077_8").show().revolution({
            sliderType: "standard",
            jsFileLocation: "../revolution/js/",
            //sliderLayout:"fullscreen",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                mouseScrollReverse: "default",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                }
                ,
                arrows: {
                    enable: true,
                    hide_onmobile: true,
                    hide_under: 992,
                    style: "hermes",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "center",
                    v_align: "bottom",
                    h_offset: 0,
                    v_offset: 30,
                    space: 5,
                    tmp: ''
                }
            },
            responsiveLevels: [1400, 1200, 992, 576],
            visibilityLevels: [1400, 1200, 992, 576],
            gridwidth: [1280, 992, 676, 320],
            gridheight: [700, 580, 300, 220],
            lazyType: "none",
            parallax: {
                type: "mouse",
                origo: "slidercenter",
                speed: 2000,
                levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50, 46, 47, 48, 49, 50, 55],
                type: "mouse",
                disable_onmobile: "on"
            },
            shadow: 0,
            spinner: "off",
            stopLoop: "on",
            stopAfterLoops: 0,
            stopAtSlide: 0,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAutoWidth: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "60px",
            disableProgressBar: "on",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                nextSlideOnWindowFocus: "off",
                disableFocusListener: false,
            }
        });
        var newCall = new Object(),
            cslide;

        newCall.callback = function () {
            var proc = revapi1077.revgetparallaxproc(),
                fade = 1 + proc,
                scale = 1 + (Math.abs(proc) / 10);

            punchgs.TweenLite.set(revapi1077.find('.slotholder, .rs-background-video-layer'), { opacity: fade, scale: scale });
        }
        newCall.inmodule = "parallax";
        newCall.atposition = "start";

        // revapi1077.bind("revolution.slide.onloaded",function (e) {
        // revapi1077.revaddcallback(newCall);
        // });				
    }
});	/*ready*/

// index-9	
var revapi1077;
tpj(document).ready(function () {
    if (tpj("#rev_slider_1077_9").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_1077_9");
    } else {
        revapi1077 = tpj("#rev_slider_1077_9").show().revolution({
            sliderType: "standard",
            jsFileLocation: "../revolution/js/",
            //sliderLayout:"fullscreen",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                mouseScrollReverse: "default",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                }
                ,
                bullets: {
                    enable: true,
                    hide_onmobile: true,
                    hide_under: 960,
                    style: "hermes",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "center",
                    v_align: "bottom",
                    h_offset: 0,
                    v_offset: 30,
                    space: 5,
                    tmp: ''
                }
            },
            responsiveLevels: [1400, 1200, 992, 576],
            visibilityLevels: [1400, 1200, 992, 576],
            gridwidth: [1280, 992, 676, 320],
            gridheight: [520, 380, 300, 220],
            lazyType: "none",
            parallax: {
                type: "mouse",
                origo: "slidercenter",
                speed: 2000,
                levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50, 46, 47, 48, 49, 50, 55],
                type: "mouse",
                disable_onmobile: "on"
            },
            shadow: 0,
            spinner: "off",
            stopLoop: "on",
            stopAfterLoops: 0,
            stopAtSlide: 0,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAutoWidth: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "60px",
            disableProgressBar: "on",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                nextSlideOnWindowFocus: "off",
                disableFocusListener: false,
            }
        });
        var newCall = new Object(),
            cslide;

        newCall.callback = function () {
            var proc = revapi1077.revgetparallaxproc(),
                fade = 1 + proc,
                scale = 1 + (Math.abs(proc) / 10);

            punchgs.TweenLite.set(revapi1077.find('.slotholder, .rs-background-video-layer'), { opacity: fade, scale: scale });
        }
        newCall.inmodule = "parallax";
        newCall.atposition = "start";

        // revapi1077.bind("revolution.slide.onloaded",function (e) {
        // revapi1077.revaddcallback(newCall);
        // });				
    }
});


var revapi467;
tpj(document).ready(function () {
    if (tpj("#rev_slider_1077_7").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_1077_9");
    } else {
        revapi467 = tpj("#rev_slider_1077_7").show().revolution({
            sliderType: "standard",
            jsFileLocation: "../revolution/js/",
            // sliderLayout:"fullwidth",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                mouseScrollReverse: "default",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                }
                ,
                arrows: {
                    style: "erinyen",
                    enable: false,
                    hide_onmobile: true,
                    hide_under: 600,
                    hide_onleave: true,
                    hide_delay: 200,
                    hide_delay_mobile: 1200,
                    tmp: '<div class="tp-title-wrap">  	<div class="tp-arr-imgholder"></div>    <div class="tp-arr-img-over"></div>	<span class="tp-arr-titleholder">{{title}}</span> </div>',
                    left: {
                        h_align: "left",
                        v_align: "center",
                        h_offset: 30,
                        v_offset: 0
                    },
                    right: {
                        h_align: "right",
                        v_align: "center",
                        h_offset: 30,
                        v_offset: 0
                    }
                }
                ,
                thumbnails: {
                    style: "gyges",
                    enable: true,
                    width: 100,
                    height: 60,
                    min_width: 60,
                    wrapper_padding: 0,
                    wrapper_color: "transparent",
                    wrapper_opacity: "1",
                    tmp: '<span class="tp-thumb-img-wrap">  <span class="tp-thumb-image"></span></span>',
                    visibleAmount: 5,
                    hide_onmobile: true,
                    hide_under: 768,
                    hide_onleave: false,
                    direction: "horizontal",
                    span: false,
                    position: "inner",
                    space: 5,
                    h_align: "center",
                    v_align: "bottom",
                    h_offset: 0,
                    v_offset: 20
                }
            },
            carousel: {
                horizontal_align: "center",
                vertical_align: "center",
                fadeout: "off",
                maxVisibleItems: 3,
                infinity: "on",
                space: 0,
                stretch: "off"
            },
            viewPort: {
                enable: true,
                outof: "pause",
                visible_area: "80%",
                presize: false
            },
            responsiveLevels: [1400, 1200, 992, 576],
            visibilityLevels: [1400, 1200, 992, 576],
            gridwidth: [1280, 992, 676, 320],
            gridheight: [600, 380, 300, 220],
            lazyType: "none",
            parallax: {
                type: "mouse",
                origo: "slidercenter",
                speed: 2000,
                levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50, 46, 47, 48, 49, 50, 55],
                type: "mouse",
                disable_onmobile: "on"
            },
            shadow: 0,
            spinner: "off",
            stopLoop: "on",
            stopAfterLoops: 0,
            stopAtSlide: 0,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAutoWidth: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "60px",
            disableProgressBar: "on",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                nextSlideOnWindowFocus: "off",
                disableFocusListener: false,
            }
        });
    }
});	/*ready*/


/* Set Tabs Slick Slider Positions */

jQuery('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {

    jQuery('.tab-carousel-js').slick('setPosition');
    jQuery('.tab-carousel-js2').slick('setPosition');
    jQuery('.tab-carousel-js2-1').slick('setPosition');
    jQuery('.tab-carousel-js2-2').slick('setPosition');
    jQuery('.product-carousel').slick('setPosition');
    jQuery('.product-carousel2').slick('setPosition');
    jQuery('.best-index5-1-carousel-js').slick('setPosition');
    jQuery('.best5d-carousel-js').slick('setPosition');
    jQuery('.best5-carousel-js').slick('setPosition');
    jQuery('.best5a-carousel-js').slick('setPosition');
    jQuery('.best5b-carousel-js').slick('setPosition');
    jQuery('.best5c-carousel-js').slick('setPosition');
    jQuery('.best5e-carousel-js').slick('setPosition');
    jQuery('.top-index7-1-carousel-js').slick('setPosition');
    jQuery('.top-index7-2-carousel-js').slick('setPosition');
    jQuery('.top-index7-3-carousel-js').slick('setPosition');
    jQuery('.tab9-1-carousel-js').slick('setPosition');
    jQuery('.tab9-2-carousel-js').slick('setPosition');
    jQuery('.tab9-3-carousel-js').slick('setPosition');
    jQuery('.tab9-4-carousel-js').slick('setPosition');
    jQuery('.tab9-5-carousel-js').slick('setPosition');

});

/* End */


(function (jQuery) {
    var tabCarousel = jQuery('.tab-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.product-carousel');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [{
                    dots: true,
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 2,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.product-carousel2');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);

(function (jQuery) {
    var tabCarouselContent = jQuery('#tabCarousel');

    jQuery('a[data-bs-toggle="tab"]').length && jQuery('body').on('shown.bs.tab', 'a[data-bs-toggle="tab"]', function (e) {
        jQuery('.slick-slider').each(function () {
            jQuery(this).slick("getSlick").refresh();
        });

    });
})(jQuery);

// megadropdown

(function (jQuery) {
    var jsCarouselProducts = jQuery('.mega-dropdown-carousel-js');
    if (jsCarouselProducts.length) {
        jsCarouselProducts.each(function () {
            var slick = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');

            if (slick.item == 2) {
                slick.slick({
                    lazyLoad: 'progressive',
                    dots: false,
                    arrows: true,
                    infinite: true,
                    outline: false,
                    speed: 300,
                    slidesToShow: item,
                    slidesToScroll: item,
                    adaptiveHeight: true,
                    responsive: [{
                        breakpoint: 1240,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 791,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }]
                });
            };
            slick.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,

                infinite: true,
                speed: 300,
                slidesToShow: item || 2,
                slidesToScroll: item || 2,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);


// popular section

(function (jQuery) {
    var jsCarouselProducts = jQuery('.popular-carousel-js');
    if (jsCarouselProducts.length) {
        jsCarouselProducts.each(function () {
            var slick = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');

            if (slick.item == 2) {
                slick.slick({
                    lazyLoad: 'progressive',
                    dots: true,
                    arrows: false,
                    infinite: true,
                    outline: false,
                    speed: 300,
                    slidesToShow: item,
                    slidesToScroll: item,
                    adaptiveHeight: true,
                    responsive: [{
                        breakpoint: 1240,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 791,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }]
                });
            };
            slick.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: item || 2,
                slidesToScroll: item || 2,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.our-categories-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: true,
                arrows: false,
                infinite: false,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 6,
                slidesToScroll: item || 6,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.deal-of-the-day-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: true,
                arrows: false,
                infinite: false,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },

                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: item || 1,
                            slidesToScroll: item || 1,
                        }
                    }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.on-sale-product-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({

                centerMode: true,
                centerPadding: "97px",
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                variableWidth: false,
                slidesToShow: item || 2,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        centerMode: true,
                        centerPadding: "50px",
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                },
                {
                    breakpoint: 450,
                    settings: {
                        centerMode: true,
                        centerPadding: "20px",
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }
                ]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.stock-products-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: true,
                arrows: false,
                infinite: false,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,

                rows: 2,

                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1,




                    }
                }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.Best-Sellers-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: true,
                arrows: false,
                infinite: false,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,

                rows: 2,

                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1,




                    }
                }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.testimonial-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: true,
                arrows: false,
                infinite: false,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.top-seller-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: false,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 2,
                slidesToScroll: item || 2,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1110,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.top-seller-carousel-js-17');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: false,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1110,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.top-blog-carousel-js-17');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: false,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 2,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.flashsale-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: false,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.brands-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                autoplay: true,
                autoplaySpeed: 3000,
                dots: true,
                arrows: false,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 6,
                slidesToScroll: item || 6,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: itemmobile || 2,
                        slidesToScroll: itemmobile || 2
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.brands10-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 6,
                slidesToScroll: item || 6,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 3,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 2,
                        slidesToScroll: itemmobile || 2
                    }
                }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.fullwidth-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');

            thisCarousel.slick({

                centerMode: true,
                centerPadding: "95px",
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                prevArrow: jQuery('.prev-fullwidth'),
                nextArrow: jQuery('.next-fullwidth'),
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        dots: true,
                        arrows: true,
                        centerMode: true,
                        centerPadding: '20px',

                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.new-arrival-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.product4-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.best-sale-product-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,

                rows: 2,

                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 577,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1,
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best-sale-product-js-14');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 2,
                slidesToScroll: item || 2,
                adaptiveHeight: true,

                rows: 2,

                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 577,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1,
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best-sale-product-js-14b');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 2,
                adaptiveHeight: true,

                rows: 2,

                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 577,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1,
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best-sale-product-js-14a');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 6,
                slidesToScroll: item || 1,
                adaptiveHeight: true,

                rows: 1,

                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 577,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1,
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best-sale-product-js-20');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 8,
                slidesToScroll: item || 1,
                adaptiveHeight: true,

                rows: 1,

                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 4,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 577,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 2,
                        slidesToScroll: itemmobile || 1,
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab-carousel-js2');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                prevArrow: jQuery('.prev0'),
                nextArrow: jQuery('.next0'),
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.tab-carousel-index');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                prevArrow: jQuery('.prev1a'),
                nextArrow: jQuery('.next1a'),
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab-home-15');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                prevArrow: jQuery('.prev1b'),
                nextArrow: jQuery('.next1b'),
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab-home-tabs-15');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                prevArrow: jQuery('.prev1c'),
                nextArrow: jQuery('.next1c'),
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab-home-tabs1-15');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                prevArrow: jQuery('.prev1d'),
                nextArrow: jQuery('.next1d'),
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab-home-tabs2-15');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                prevArrow: jQuery('.prev1e'),
                nextArrow: jQuery('.next1e'),
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab-home-tabs3-15');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                prevArrow: jQuery('.prev1f'),
                nextArrow: jQuery('.next1f'),
                slidesToShow: item || 3,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab-home-tabs4-15');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                prevArrow: jQuery('.prev1g'),
                nextArrow: jQuery('.next1g'),
                slidesToShow: item || 3,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.tab-carousel-js2-1');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                prevArrow: jQuery('.prev1'),
                nextArrow: jQuery('.next1'),
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1300,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 1100,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },

                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab-carousel-js2-2');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                prevArrow: jQuery('.prev2'),
                nextArrow: jQuery('.next2'),
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1300,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 1100,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },

                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.topsale-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 2,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.blognews-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 1025,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 791,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 650,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var blogCarousel = jQuery('.blog-carousel-js');
    if (blogCarousel.length) {
        blogCarousel.each(function () {
            var thisBlogCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisBlogCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var blogCarousel = jQuery('.pro-category-carousel-js-1');
    if (blogCarousel.length) {
        blogCarousel.each(function () {
            var thisBlogCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisBlogCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var blogCarousel = jQuery('.pro-category-carousel-js-2');
    if (blogCarousel.length) {
        blogCarousel.each(function () {
            var thisBlogCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisBlogCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var blogCarousel = jQuery('.pro-category-carousel-js-3');
    if (blogCarousel.length) {
        blogCarousel.each(function () {
            var thisBlogCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisBlogCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab-category-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {

            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1901,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 5
                    }
                },
                {
                    breakpoint: 1501,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var blogCarousel = jQuery('.testimonials-carousel-js');
    if (blogCarousel.length) {
        blogCarousel.each(function () {
            var thisBlogCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisBlogCarousel.slick({
                autoplay: true,
                autoplaySpeed: 5000,
                fade: true,
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.brand-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {

            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: item || 5,
                slidesToScroll: item || 5,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1901,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 6
                    }
                },
                {
                    breakpoint: 1501,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 5
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.aboutUs-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');

            if (thisCarousel.item == 5) {
                thisCarousel.slick({
                    lazyLoad: 'progressive',
                    dots: true,
                    arrows: false,
                    infinite: true,
                    speed: 300,
                    slidesToShow: item,
                    slidesToScroll: item,
                    adaptiveHeight: true,
                    responsive: [{
                        breakpoint: 1240,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4
                        }
                    },
                    {
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 791,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    }]
                });
            };
            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 791,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: itemmobile || 2,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.about-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: true,
                arrows: false,
                infinite: false,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.insta-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: false,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 2000,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var blogCarousel = jQuery('.blog-carousel-js4');
    if (blogCarousel.length) {
        blogCarousel.each(function () {
            var thisBlogCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisBlogCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        dots: true,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best-index5-1-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                rows: 2,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best-index5-2-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best-index5-3-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best-index5-4-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best-index5-5-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best-index5-6-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.new-index5-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.featured-index5-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                rows: 3,
                slidesToShow: item || 3,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 1

                        }
                    },

                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 577,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.deal-index5-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.top-index5-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: false,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var blogCarousel = jQuery('.blog5-carousel-js');
    if (blogCarousel.length) {
        blogCarousel.each(function () {
            var thisBlogCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisBlogCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        dots: true,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var blogCarousel = jQuery('.insta5-carousel-js');
    if (blogCarousel.length) {
        blogCarousel.each(function () {
            var thisBlogCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisBlogCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: false,
                infinite: true,
                speed: 100,
                autoplay: true,
                slidesToShow: item || 6,
                slidesToScroll: item || 6,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 5,
                            slidesToScroll: 5
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 4,
                            slidesToScroll: itemmobile || 4
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 3,
                            slidesToScroll: itemmobile || 3
                        }
                    }
                ]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var blogCarousel = jQuery('.insta13-carousel-js');
    if (blogCarousel.length) {
        blogCarousel.each(function () {
            var thisBlogCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisBlogCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: false,
                infinite: true,
                speed: 100,
                autoplay: true,
                slidesToShow: item || 4,
                slidesToScroll: item || 2,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1100,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 3,
                            slidesToScroll: itemmobile || 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 2,
                            slidesToScroll: itemmobile || 1
                        }
                    }
                ]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.newst6-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.featured-index6-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                rows: 3,
                slidesToShow: item || 3,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 1

                        }
                    },

                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 577,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.offer6-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best5-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best5a-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best5b-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best5c-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best5d-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.best5e-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.cate6-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 400,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.blog6-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 2,
                slidesToScroll: item || 2,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.top-index7-1-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.top-index7-2-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.top-index7-3-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.look-index7-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.deal-index7-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 2,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 476,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.trend-index7-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.blog-index7-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 3,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [

                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.featured-index7-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                rows: 3,
                slidesToShow: item || 2,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1

                        }
                    },

                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 577,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.featured-index7a-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                rows: 3,
                slidesToShow: item || 2,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1

                        }
                    },

                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 577,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.Featured8-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.new8-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                rows: 3,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1

                        }
                    },

                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 577,
                        settings: {
                            dots: true,
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.new8-carousel-js1');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: false,
                //rtl:true,
                speed: 100,
                rows: 2,
                slidesToShow: item || 2,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1

                        }
                    },

                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 577,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.trending8-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                rows: 2,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tabone8-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tabthree8-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tabtwo8-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.trending9-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 4,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab9-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab9-1-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,

                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab9-2-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab9-3-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.tab9-4-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);



(function (jQuery) {
    var tabCarousel = jQuery('.collection9-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                rows: 4,
                responsive: [

                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            rows: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            rows: 2
                        }
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            dots: true,
                            rows: 2,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1

                        }
                    }

                ]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.collection9-1-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,

                rows: 4,
                responsive: [

                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            rows: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            rows: 2
                        }
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            dots: true,
                            rows: 2,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1

                        }
                    }

                ]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.collection9-2-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,

                rows: 4,
                responsive: [

                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            rows: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            rows: 2
                        }
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            dots: true,
                            rows: 2,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1

                        }
                    }

                ]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.lookbook9-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        dots: true,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        dots: true,
                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };
})(jQuery);


// --vendorweb
(function (jQuery) {
    var tabCarousel = jQuery('.vendor-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,

            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.v-product-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                rows: 2,
                responsive: [

                    {
                        breakpoint: 1200,
                        settings: {
                            
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            rows: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            rows: 2
                        }
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            dots: true,
                            rows: 1,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1

                        }
                    }

                ]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.v-fullwidth-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');

            thisCarousel.slick({

                centerMode: true,
                centerPadding: "95px",
                dots: true,
                arrows: false,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 3,
                slidesToScroll: item || 3,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 780,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        arrows: true,
                        centerMode: true,
                        centerPadding: '20px',

                        slidesToShow: itemmobile || 1,
                        slidesToScroll: itemmobile || 1
                    }
                }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.vsale-carousel-js');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 4,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                rows: 3,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.vendor5-carousel-js');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: false,
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,

            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.vbannercarousel');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                customPaging: function (slider, i) {
                    var thumb = jQuery(slider.$slides[i]).data();
                    return '<a>' + (i + 1) + '</a>';
                },
                arrows: true,
                infinite: true,
                //rtl:true,
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [

                    {
                        breakpoint: 1400,
                        settings: {
                            arrows: false,

                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                        }
                    },

                ]
            });
        });
    };
})(jQuery);
(function (jQuery) {
    var tabCarousel = jQuery('.vflashcarousel');
    if (tabCarousel.length) {
        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');


            thisCarousel.slick({
                lazyLoad: 'progressive',
                dots: true,
                arrows: true,
                infinite: true,
                //rtl:true, 
                speed: 300,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,

            });
        });
    };
})(jQuery);

// page10
(function (jQuery) {
    var tabCarousel = jQuery('.arrival-carousel-js10');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');

            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                rows: 2,
                slidesToShow: item || 2,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1

                        }
                    },

                    {
                        breakpoint: 992,

                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            slidesPerRow: 1,
                            rows: 1,
                        }
                    },
                    {
                        breakpoint: 577,

                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1,
                            slidesPerRow: 1,
                            rows: 1,
                        }
                    }]
            });
        });
    };

})(jQuery);

(function (jQuery) {
    var tabCarousel = jQuery('.flash-carousel-js10');
    if (tabCarousel.length) {

        tabCarousel.each(function () {
            var thisCarousel = jQuery(this),
                item = jQuery(this).data('item'),
                itemmobile = jQuery(this).data('itemmobile');



            thisCarousel.slick({
                dots: false,
                arrows: true,
                infinite: true,
                autoplay: true,
                //rtl:true,
                speed: 100,
                slidesToShow: item || 1,
                slidesToScroll: item || 1,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1

                        }
                    },

                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 577,
                        settings: {
                            dots: true,
                            slidesToShow: itemmobile || 1,
                            slidesToScroll: itemmobile || 1
                        }
                    }]
            });
        });
    };

})(jQuery);


function parallax(selector) {
    var scrolled = jQuery(window).scrollTop();
    jQuery(selector).css('background-position', "0 " + (scrolled * 1) + 'px');
}

jQuery(window).scroll(function (e) {
    parallax('.slider .item');

});







jQuery(document).ready(function () {
    jQuery(".content").slice(0, 3).show();
    jQuery("#loadMore").on("click", function (e) {
        e.preventDefault();
        jQuery(".content:hidden").slice(0, 3).slideDown();
        if (jQuery(".content:hidden").length == 0) {
            jQuery("#loadMore").text("No Content").addClass("noContent");
        }
    });

})





// tabs open with click on another page
window.onload = function () {

    var url = document.location.toString();
    if (url.match('#')) {
        jQuery('.nav-item a[href="#' + url.split('#')[1] + '"]').tab('show');
    }

    //Change hash for page-reload
    jQuery('.nav-item a[href="#' + url.split('#')[1] + '"]').on('shown', function (e) {
        window.location.hash = e.target.hash;
    });
}






