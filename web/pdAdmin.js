!function(t,e){"object"==typeof exports&&"object"==typeof module?module.exports=e():"function"==typeof define&&define.amd?define("Navigo",[],e):"object"==typeof exports?exports.Navigo=e():t.Navigo=e()}(this,function(){return function(t){function e(o){if(n[o])return n[o].exports;var r=n[o]={exports:{},id:o,loaded:!1};return t[o].call(r.exports,r,r.exports,e),r.loaded=!0,r.exports}var n={};return e.m=t,e.c=n,e.p="",e(0)}([function(t,e){"use strict";function n(t){if(Array.isArray(t)){for(var e=0,n=Array(t.length);e<t.length;e++)n[e]=t[e];return n}return Array.from(t)}function o(t){return Array.isArray(t)?t:Array.from(t)}function r(t){return t instanceof RegExp?t:t.replace(/\/+$/,"").replace(/^\/+/,"/")}function i(t,e){return 0===e.length?null:t?t.slice(1,t.length).reduce(function(t,n,o){return null===t&&(t={}),t[e[o]]=n,t},null):null}function u(t){var e,n=[];return e=t instanceof RegExp?t:new RegExp(r(t).replace(g,function(t,e,o){return n.push(o),w}).replace(m,R)+k),{regexp:e,paramNames:n}}function s(t){return t.replace(/\/$/,"").split("/").length}function a(t,e){return s(t)<s(e)}function l(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[];return e.map(function(e){var n=u(e.route),o=n.regexp,r=n.paramNames,s=t.match(o),a=i(s,r);return!!s&&{match:s,route:e,params:a}}).filter(function(t){return t})}function h(t,e){return l(t,e)[0]||!1}function c(t,e){var n=l(t,e.filter(function(t){var e=r(t.route);return""!==e&&"*"!==e})),o=r(t);return n.length>0?n.map(function(e){return r(t.substr(0,e.match.index))}).reduce(function(t,e){return e.length<t.length?e:t},o):o}function f(){return!("undefined"==typeof window||!window.history||!window.history.pushState)}function d(){return!!("undefined"!=typeof window&&"onhashchange"in window)}function p(t,e){var n=t.split(/\?(.*)?$/),r=o(n),i=r[0],u=r.slice(1);return e||(i=i.split("#")[0]),{onlyURL:i,GETParameters:u.join("")}}function _(t,e){return e&&e.hooks&&"object"===y(e.hooks)?void(e.hooks.before?e.hooks.before(function(){var n=!(arguments.length>0&&void 0!==arguments[0])||arguments[0];n&&(t(),e.hooks.after&&e.hooks.after())}):e.hooks.after&&(t(),e.hooks.after&&e.hooks.after())):void t()}function v(t,e){this.root=null,this._routes=[],this._useHash=e,this._paused=!1,this._destroyed=!1,this._lastRouteResolved=null,this._notFoundHandler=null,this._defaultHandler=null,this._usePushState=!e&&f(),t?this.root=t.replace(/\/$/,"/#"):e&&(this.root=this._cLoc().split("#")[0].replace(/\/$/,"/#")),this._listen(),this.updatePageLinks()}Object.defineProperty(e,"__esModule",{value:!0});var y="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},g=/([:*])(\w+)/g,m=/\*/g,w="([^/]+)",R="(?:.*)",k="(?:/$|$)";v.prototype={helpers:{match:h,root:c,clean:r},navigate:function(t,e){var n;return t=t||"",this._usePushState?(n=(e?"":this._getRoot()+"/")+t.replace(/^\/+/,"/"),n=n.replace(/([^:])(\/{2,})/g,"$1/"),history[this._paused?"replaceState":"pushState"]({},"",n),this.resolve()):"undefined"!=typeof window&&(window.location.href=window.location.href.replace(/#(.*)$/,"")+"#"+t),this},on:function(){for(var t=this,e=arguments.length,n=Array(e),o=0;o<e;o++)n[o]=arguments[o];if("function"==typeof n[0])this._defaultHandler={handler:n[0],hooks:n[1]};else if(n.length>=2)"/"===n[0]?this._defaultHandler={handler:n[1],hooks:n[2]}:this._add(n[0],n[1],n[2]);else if("object"===y(n[0])){var r=Object.keys(n[0]).sort(a);r.forEach(function(e){t._add(e,n[0][e])})}return this},notFound:function(t,e){return this._notFoundHandler={handler:t,hooks:e},this},resolve:function(t){var e,o,r=this,i=(t||this._cLoc()).replace(this._getRoot(),"");this._useHash&&(i=i.replace(/^\/#/,"/"));var u=p(i,this._useHash),s=u.onlyURL,a=u.GETParameters;return!(this._paused||this._lastRouteResolved&&s===this._lastRouteResolved.url&&a===this._lastRouteResolved.query)&&((o=h(s,this._routes))?(this._lastRouteResolved={url:s,query:a},e=o.route.handler,_(function(){o.route.route instanceof RegExp?e.apply(void 0,n(o.match.slice(1,o.match.length))):e(o.params,a)},o.route),o):!this._defaultHandler||""!==s&&"/"!==s&&"#"!==s?(this._notFoundHandler&&_(function(){r._lastRouteResolved={url:s,query:a},r._notFoundHandler.handler(a)},this._notFoundHandler),!1):(_(function(){r._lastRouteResolved={url:s,query:a},r._defaultHandler.handler(a)},this._defaultHandler),!0))},destroy:function(){this._routes=[],this._destroyed=!0,clearTimeout(this._listenningInterval),"undefined"!=typeof window?window.onpopstate=null:null},updatePageLinks:function(){var t=this;"undefined"!=typeof document&&this._findLinks().forEach(function(e){e.hasListenerAttached||(e.addEventListener("click",function(n){var o=e.getAttribute("href");t._destroyed||(n.preventDefault(),t.navigate(r(o)))}),e.hasListenerAttached=!0)})},generate:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return this._routes.reduce(function(n,o){var r;if(o.name===t){n=o.route;for(r in e)n=n.replace(":"+r,e[r])}return n},"")},link:function(t){return this._getRoot()+t},pause:function(){var t=!(arguments.length>0&&void 0!==arguments[0])||arguments[0];this._paused=t},resume:function(){this.pause(!1)},disableIfAPINotAvailable:function(){f()||this.destroy()},_add:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;return"object"===("undefined"==typeof e?"undefined":y(e))?this._routes.push({route:t,handler:e.uses,name:e.as,hooks:n||e.hooks}):this._routes.push({route:t,handler:e,hooks:n}),this._add},_getRoot:function(){return null!==this.root?this.root:(this.root=c(this._cLoc(),this._routes),this.root)},_listen:function(){var t=this;this._usePushState?window.onpopstate=function(){t.resolve()}:d()?window.onhashchange=function(){t.resolve()}:!function(){var e=t._cLoc(),n=void 0,o=void 0;(o=function(){n=t._cLoc(),e!==n&&(e=n,t.resolve()),t._listenningInterval=setTimeout(o,200)})()}()},_cLoc:function(){return"undefined"!=typeof window?r(window.location.href):""},_findLinks:function(){return[].slice.call(document.querySelectorAll("[data-navigo]"))}},e["default"]=v,t.exports=e["default"]}])});

/**
 * Router & Store
 */
var Store = {
  routerRoot  : CONST.ROOT_URL ? CONST.ROOT_URL : location.protocol + "//" + location.host,
  useHash     : CONST.USE_HASH,
  panels      : CONST.PANELS,
  activePanel : null,
  resId       : 'pdpanel'
}
var Router = new Navigo(Store.routerRoot, Store.useHash);

/**
 * pdAdmin Resources Element
 * @returns {Element}
 */
function loadResource() {
  let res = document.getElementById(Store.resId);
  if (!res) {
    res = document.createElement('div')
    res.id = Store.resId
    document.body.appendChild(res);
    res = document.getElementById(Store.resId)
  } else {
    res.innerHTML = ''
  }
  return res;
}

/**
 * Dynamic Load Script
 * @param href
 * @returns {Element|*}
 */
function loadScript(href) {
  script = document.createElement('script')
  script.type = 'text/javascript'
  script.src = href
  return script;
}

/**
 * Dynamic Load Style
 * @param href
 * @returns {Element|*}
 */
function loadStyle(href) {
  style = document.createElement('link')
  style.rel = 'stylesheet'
  style.href = href
  return style
}

/**
 * Change Panel
 * @param app
 */
function changeResources(app) {
  let res = loadResource()

  app.forEach(function (file) {
    let type = file.substr(file.length - 4, 4)
    res.appendChild(type.search('.js') != -1 ? loadScript(file) : loadStyle(file))
  })
}

/**
 * Router Before-End 
 * @returns {{before: before, after: after}}
 */
function routerBeforeEnd() {
  return {
    before: function (done) {
      if (r.name !== Store.activePanel) {
        done()
      }
    },
    after: function () {
    }
  }
}

/**
 * Create Panel Router
 */
function startRouter() {
  Store.panels.forEach(function (r) {
    // Change Panel
    let changePanel = function () {
      if (r.name !== Store.activePanel) {
        Store.activePanel = r.name;

        if (r.app) {
          changeResources(r.app)
        }
      }
    };

    Router.on(r.path, changePanel, routerBeforeEnd);
    Router.on(r.path + '/*', changePanel, routerBeforeEnd);
  });

  Router.resolve()
}

startRouter();