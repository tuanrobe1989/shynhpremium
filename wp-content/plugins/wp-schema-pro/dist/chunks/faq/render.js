(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{37:function(t,e,n){"use strict";var o,a=function(){var t={};return function(e){if(void 0===t[e]){var n=document.querySelector(e);if(window.HTMLIFrameElement&&n instanceof window.HTMLIFrameElement)try{n=n.contentDocument.head}catch(t){n=null}t[e]=n}return t[e]}}(),i=[];function r(t){for(var e=-1,n=0;n<i.length;n++)if(i[n].identifier===t){e=n;break}return e}function c(t,e){for(var n={},o=[],a=0;a<t.length;a++){var c=t[a],s=e.base?c[0]+e.base:c[0],l=n[s]||0,u="".concat(s," ").concat(l);n[s]=l+1;var p=r(u),d={css:c[1],media:c[2],sourceMap:c[3]};-1!==p?(i[p].references++,i[p].updater(d)):i.push({identifier:u,updater:h(d,e),references:1}),o.push(u)}return o}function s(t){var e=document.createElement("style"),o=t.attributes||{};if(void 0===o.nonce){var i=n.nc;i&&(o.nonce=i)}if(Object.keys(o).forEach((function(t){e.setAttribute(t,o[t])})),"function"==typeof t.insert)t.insert(e);else{var r=a(t.insert||"head");if(!r)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");r.appendChild(e)}return e}var l,u=(l=[],function(t,e){return l[t]=e,l.filter(Boolean).join("\n")});function p(t,e,n,o){var a=n?"":o.media?"@media ".concat(o.media," {").concat(o.css,"}"):o.css;if(t.styleSheet)t.styleSheet.cssText=u(e,a);else{var i=document.createTextNode(a),r=t.childNodes;r[e]&&t.removeChild(r[e]),r.length?t.insertBefore(i,r[e]):t.appendChild(i)}}function d(t,e,n){var o=n.css,a=n.media,i=n.sourceMap;if(a?t.setAttribute("media",a):t.removeAttribute("media"),i&&"undefined"!=typeof btoa&&(o+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(i))))," */")),t.styleSheet)t.styleSheet.cssText=o;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(o))}}var f=null,b=0;function h(t,e){var n,o,a;if(e.singleton){var i=b++;n=f||(f=s(e)),o=p.bind(null,n,i,!1),a=p.bind(null,n,i,!0)}else n=s(e),o=d.bind(null,n,e),a=function(){!function(t){if(null===t.parentNode)return!1;t.parentNode.removeChild(t)}(n)};return o(t),function(e){if(e){if(e.css===t.css&&e.media===t.media&&e.sourceMap===t.sourceMap)return;o(t=e)}else a()}}t.exports=function(t,e){(e=e||{}).singleton||"boolean"==typeof e.singleton||(e.singleton=(void 0===o&&(o=Boolean(window&&document&&document.all&&!window.atob)),o));var n=c(t=t||[],e);return function(t){if(t=t||[],"[object Array]"===Object.prototype.toString.call(t)){for(var o=0;o<n.length;o++){var a=r(n[o]);i[a].references--}for(var s=c(t,e),l=0;l<n.length;l++){var u=r(n[l]);0===i[u].references&&(i[u].updater(),i.splice(u,1))}n=s}}}},38:function(t,e,n){"use strict";t.exports=function(t){var e=[];return e.toString=function(){return this.map((function(e){var n=function(t,e){var n,o,a,i=t[1]||"",r=t[3];if(!r)return i;if(e&&"function"==typeof btoa){var c=(n=r,o=btoa(unescape(encodeURIComponent(JSON.stringify(n)))),a="sourceMappingURL=data:application/json;charset=utf-8;base64,".concat(o),"/*# ".concat(a," */")),s=r.sources.map((function(t){return"/*# sourceURL=".concat(r.sourceRoot||"").concat(t," */")}));return[i].concat(s).concat([c]).join("\n")}return[i].join("\n")}(e,t);return e[2]?"@media ".concat(e[2]," {").concat(n,"}"):n})).join("")},e.i=function(t,n,o){"string"==typeof t&&(t=[[null,t,""]]);var a={};if(o)for(var i=0;i<this.length;i++){var r=this[i][0];null!=r&&(a[r]=!0)}for(var c=0;c<t.length;c++){var s=[].concat(t[c]);o&&a[s[0]]||(n&&(s[2]?s[2]="".concat(n," and ").concat(s[2]):s[2]=n),e.push(s))}},e}},73:function(t,e,n){(e=n(38)(!1)).push([t.i,'.edit-post-visual-editor [data-type="wpsp/faq"] .block-editor-inner-blocks > .block-editor-block-list__layout > .wp-block {\n  width: auto;\n  padding-left: 0;\n  padding-right: 0;\n  margin-top: 0;\n  margin-bottom: 0; }\n\n.edit-post-visual-editor [data-type="wpsp/faq"] .block-editor-inner-blocks > .block-editor-block-list__layout {\n  padding: 11px;\n  border: 1px solid #d2d2d2;\n  display: block; }\n\n.edit-post-visual-editor [data-type="wpsp/faq"] .wpsp-faq-layout-grid .block-editor-inner-blocks > .block-editor-block-list__layout {\n  display: grid; }\n\n.edit-post-visual-editor [data-type="wpsp/faq"] .wpsp-faq-layout-grid.wpsp-faq-equal-height .block-editor-inner-blocks > .block-editor-block-list__layout .block-editor-block-list__block,\n.edit-post-visual-editor [data-type="wpsp/faq"] .wpsp-faq-layout-grid.wpsp-faq-equal-height .block-editor-inner-blocks > .block-editor-block-list__layout .wpsp-faq-child__outer-wrap,\n.edit-post-visual-editor [data-type="wpsp/faq"] .wpsp-faq-layout-grid.wpsp-faq-equal-height .block-editor-inner-blocks > .block-editor-block-list__layout .wpsp-faq-child__wrapper,\n.edit-post-visual-editor [data-type="wpsp/faq"] .wpsp-faq-layout-grid.wpsp-faq-equal-height .block-editor-inner-blocks > .block-editor-block-list__layout .wpsp-faq-item {\n  height: 100%; }\n',""]),t.exports=e},83:function(t,e,n){"use strict";n.r(e);var o,a=n(0),i=n(4),r=n.n(i),c=n(3),s=n.n(c),l=n(7),u=n(2),p=n(37),d=n.n(p),f=n(73),b=n.n(f),h=0,v={injectType:"lazySingletonStyleTag",attributes:{id:"wpsp-editor-styles"},insert:"head",singleton:!0},w={};w.locals=b.a.locals||{},w.use=function(){return h++||(o=d()(b.a,v)),w},w.unuse=function(){h>0&&!--h&&(o(),o=null)};var m=w,y=[],g=["wpsp/faq-child"];e.default=s.a.memo((function(t){Object(c.useLayoutEffect)((function(){return m.use(),function(){m.unuse()}}),[]);var e=(t=t.parentProps).attributes.equalHeight?"wpsp-faq-equal-height":"";return Object(a.createElement)("div",{className:r()("wpsp-faq__outer-wrap","wpsp-block-".concat(t.clientId.substr(0,8)),"wpsp-faq-icon-".concat(t.attributes.iconAlign),"wpsp-faq-layout-".concat(t.attributes.layout),"wpsp-faq-expand-first-".concat(t.attributes.expandFirstItem),"wpsp-faq-inactive-other-".concat(t.attributes.inactiveOtherItems),e),"data-faqtoggle":t.attributes.enableToggle},Object(a.createElement)(c.Suspense,{fallback:Object(l.a)()},Object(a.createElement)(u.InnerBlocks,{template:function(t,e){for(var n=0,o=[];n<2;)o.push(["wpsp/faq-child",e[n]]),n+=1;return o}(0,y),templateLock:!1,allowedBlocks:g,__experimentalMoverDirection:"vertical"})))}))}}]);