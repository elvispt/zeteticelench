(window.webpackJsonp=window.webpackJsonp||[]).push([[2],{"+h1f":function(e,t,s){"use strict";s.r(t);var n=s("XJYT"),a=s.n(n);s("D66Q"),s("RLBy");s("9Wh1"),window.Vue=s("XuX8"),Vue.component("inspire",s("PxJ3").default),Vue.component("system-info",s("1ZmV").default),Vue.component("next-holidays",s("LvOa").default),Vue.component("weather",s("VebN").default),Vue.use(a.a);new Vue({el:"#app"})},"/txl":function(e,t,s){var n=s("r3tC");"string"==typeof n&&(n=[[e.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};s("aET+")(n,a);n.locals&&(e.exports=n.locals)},0:function(e,t,s){s("+h1f"),e.exports=s("pyCd")},"1ZmV":function(e,t,s){"use strict";s.r(t);var n=s("o0o1"),a=s.n(n),r=s("yDJ3"),i=s.n(r);function o(e,t,s,n,a,r,i){try{var o=e[r](i),l=o.value}catch(e){return void s(e)}o.done?t(l):Promise.resolve(l).then(n,a)}var l={name:"SystemInfo",props:["langSystemInfo","langSince","langNumberQueueWorkers","langMemoryInfo","langUsed","langFree","langTotal"],data:function(){return{loading:!0,memory:{free:"",used:"",total:""},nQueueWorkersRunning:0,up:"",upSince:""}},created:function(){this.fetchSystemInfo(),setInterval(this.fetchSystemInfo,1e4)},methods:{fetchSystemInfo:function(){var e,t=this;return(e=a.a.mark((function e(){var s,n;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,axios.get("/api/system-info");case 2:s=e.sent,(n=i()(s,"data.data",null))&&(t.memory.free=i()(n,"memory.free"),t.memory.used=i()(n,"memory.used"),t.memory.total=i()(n,"memory.total"),t.nQueueWorkersRunning=i()(n,"nQueueWorkersRunning"),t.up=i()(n,"up"),t.upSince=i()(n,"upSince")),setTimeout((function(){return t.loading=!1}),500);case 6:case"end":return e.stop()}}),e)})),function(){var t=this,s=arguments;return new Promise((function(n,a){var r=e.apply(t,s);function i(e){o(r,n,a,i,l,"next",e)}function l(e){o(r,n,a,i,l,"throw",e)}i(void 0)}))})()}},filters:{capitalize:function(e){if(e)return(e=e.toString()).charAt(0).toUpperCase()+e.slice(1)}}},c=(s("dcHU"),s("KHd+")),d=Object(c.a)(l,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"card mb-3 shadow"},[s("div",{staticClass:"card-header"},[e._v(e._s(e.langSystemInfo))]),e._v(" "),s("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticClass:"card-body"},[s("transition",{attrs:{name:"slide-fade",mode:"out-in"}},[s("p",{key:e.up,staticClass:"alert-info"},[e._v("\n        "+e._s(e._f("capitalize")(e.up))+" "+e._s(e.langSince)+" "+e._s(e.upSince)+"\n      ")])]),e._v(" "),s("p",{class:{"alert-success":e.nQueueWorkersRunning,"alert-danger":!e.nQueueWorkersRunning}},[e._v("\n      "+e._s(e.langNumberQueueWorkers)+": "+e._s(e.nQueueWorkersRunning)+"\n    ")]),e._v(" "),s("div",{staticClass:"pt-4"},[s("table",{staticClass:"table table-sm"},[s("caption",[e._v(e._s(e.langMemoryInfo))]),e._v(" "),s("thead",[s("tr",[s("th",[e._v(e._s(e.langUsed))]),e._v(" "),s("th",[e._v(e._s(e.langFree))]),e._v(" "),s("th",[e._v(e._s(e.langTotal))])])]),e._v(" "),s("tbody",[s("transition",{attrs:{name:"slide-fade",mode:"out-in"}},[s("tr",{key:e.memory.used},[s("td",[e.memory.used?e._e():s("span",[e._v(" ")]),e._v(e._s(e.memory.used))]),e._v(" "),s("td",[e._v(e._s(e.memory.free))]),e._v(" "),s("td",[e._v(e._s(e.memory.total))])])])],1)])])],1)])}),[],!1,null,"2b9823c0",null);t.default=d.exports},"9Wh1":function(e,t,s){"use strict";s.r(t);var n=s("3CEA"),a=s("gtzJ");n.a({dsn:"https://50142ad267aa4c7c9dab6ed21262d2ab@sentry.io/1504143"}),window.axios=s("vDqi"),window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";var r=document.head.querySelector('meta[name="csrf-token"]');if(r)window.axios.defaults.headers.common["X-CSRF-TOKEN"]=r.content,window.axios.interceptors.response.use(null,(function(e){e.response?401!==e.response.status&&419!==e.response.status||window.location.replace("/login"):(a.b(e),console.error("Unknown error: ".concat(e)))}));else{var i="CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token";a.b(i),console.error(i)}},CbGa:function(e,t,s){var n=s("HPB2");"string"==typeof n&&(n=[[e.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};s("aET+")(n,a);n.locals&&(e.exports=n.locals)},HPB2:function(e,t,s){(e.exports=s("I1BE")(!1)).push([e.i,"\n.divider[data-v-01380892] {\n  border-left: 1px solid #ccc;\n}\n",""])},L7bX:function(e,t,s){"use strict";var n=s("CbGa");s.n(n).a},LvOa:function(e,t,s){"use strict";s.r(t);var n=s("o0o1"),a=s.n(n),r=s("yDJ3"),i=s.n(r);function o(e,t,s,n,a,r,i){try{var o=e[r](i),l=o.value}catch(e){return void s(e)}o.done?t(l):Promise.resolve(l).then(n,a)}var l={name:"NextHolidays",props:["langNextHoliday"],data:function(){return{loading:!0,nextHolidays:[{name:"",date:"",type:"",description:""},{name:"",date:"",type:"",description:""},{name:"",date:"",type:"",description:""}]}},methods:{fetchNextHolidays:function(){var e,t=this;return(e=a.a.mark((function e(){var s,n;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,axios.get("/api/next-holidays");case 2:return s=e.sent,(n=i()(s,"data.data",[])).length&&(t.nextHolidays=n.map((function(e){return{name:e.name,description:e.description,date:e.date.iso,type:Array.isArray(e.type)?e.type[0]:""}})),t.loading=!1),e.abrupt("return",!0);case 6:case"end":return e.stop()}}),e)})),function(){var t=this,s=arguments;return new Promise((function(n,a){var r=e.apply(t,s);function i(e){o(r,n,a,i,l,"next",e)}function l(e){o(r,n,a,i,l,"throw",e)}i(void 0)}))})()}},created:function(){this.fetchNextHolidays()}},c=s("KHd+"),d=Object(c.a)(l,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"card shadow mb-3"},[s("div",{staticClass:"card-header"},[e._v(e._s(e.langNextHoliday))]),e._v(" "),s("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticClass:"card-body"},e._l(e.nextHolidays,(function(t){return s("div",[s("p",[s("span",{staticClass:"badge badge-dark"},[e._v("#")]),e._v("\n        "+e._s(t.name)+",\n        "+e._s(e._f("diffForHumans")(t.date))+"\n        at "+e._s(t.date)+"\n        "),s("small",[e._v(e._s(t.type))])]),e._v(" "),s("p",[t.description?e._e():s("span",[e._v(" ")]),e._v(" "),s("small",[e._v(e._s(t.description))])])])})),0)])}),[],!1,null,null,null);t.default=d.exports},PxJ3:function(e,t,s){"use strict";s.r(t);var n=s("o0o1"),a=s.n(n),r=s("yDJ3"),i=s.n(r);function o(e,t,s,n,a,r,i){try{var o=e[r](i),l=o.value}catch(e){return void s(e)}o.done?t(l):Promise.resolve(l).then(n,a)}var l={name:"Inspire",data:function(){return{inspire:null,fallbackLines:["The hardest part of building software is deciding what to build.","Everything not specified will be specified by the programmer, on the fly.","Design is also specification.","Everything that is public-facing defines the significant part of the business logic.","The open office plan is the best way to destroy productivity.","Don’t multitask. Focus on one task at a time.","There is work time and there is personal time. Don’t mix the two.","Everyone writes bad code except for you. /s"]}},computed:{fallback:function(){return this.fallbackLines[Math.floor(Math.random()*this.fallbackLines.length)]}},created:function(){this.fetchInspire()},methods:{fetchInspire:function(){var e,t=this;return(e=a.a.mark((function e(){var s;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,axios.get("/api/inspire");case 2:s=e.sent,t.inspire=i()(s,"data.data");case 4:case"end":return e.stop()}}),e)})),function(){var t=this,s=arguments;return new Promise((function(n,a){var r=e.apply(t,s);function i(e){o(r,n,a,i,l,"next",e)}function l(e){o(r,n,a,i,l,"throw",e)}i(void 0)}))})()}}},c=s("KHd+"),d=Object(c.a)(l,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"card mb-3 shadow"},[s("div",{staticClass:"card-body"},[s("small",[e.inspire?e._e():s("span",[e._v(e._s(e.fallback))]),e._v(e._s(e.inspire))])])])}),[],!1,null,null,null);t.default=d.exports},RLBy:function(e,t,s){"use strict";var n=s("XuX8"),a=s.n(n),r=s("wd/R"),i=s.n(r);a.a.filter("diffForHumans",(function(e){if(e)return i()(e,"YYYY-MM-DD hh:mm:ss").fromNow()})),a.a.filter("domainFromUrl",(function(e){if(e)return new URL(e).hostname.replace("www.","")}))},RnhZ:function(e,t,s){var n={"./af":"K/tc","./af.js":"K/tc","./ar":"jnO4","./ar-dz":"o1bE","./ar-dz.js":"o1bE","./ar-kw":"Qj4J","./ar-kw.js":"Qj4J","./ar-ly":"HP3h","./ar-ly.js":"HP3h","./ar-ma":"CoRJ","./ar-ma.js":"CoRJ","./ar-sa":"gjCT","./ar-sa.js":"gjCT","./ar-tn":"bYM6","./ar-tn.js":"bYM6","./ar.js":"jnO4","./az":"SFxW","./az.js":"SFxW","./be":"H8ED","./be.js":"H8ED","./bg":"hKrs","./bg.js":"hKrs","./bm":"p/rL","./bm.js":"p/rL","./bn":"kEOa","./bn.js":"kEOa","./bo":"0mo+","./bo.js":"0mo+","./br":"aIdf","./br.js":"aIdf","./bs":"JVSJ","./bs.js":"JVSJ","./ca":"1xZ4","./ca.js":"1xZ4","./cs":"PA2r","./cs.js":"PA2r","./cv":"A+xa","./cv.js":"A+xa","./cy":"l5ep","./cy.js":"l5ep","./da":"DxQv","./da.js":"DxQv","./de":"tGlX","./de-at":"s+uk","./de-at.js":"s+uk","./de-ch":"u3GI","./de-ch.js":"u3GI","./de.js":"tGlX","./dv":"WYrj","./dv.js":"WYrj","./el":"jUeY","./el.js":"jUeY","./en-au":"Dmvi","./en-au.js":"Dmvi","./en-ca":"OIYi","./en-ca.js":"OIYi","./en-gb":"Oaa7","./en-gb.js":"Oaa7","./en-ie":"4dOw","./en-ie.js":"4dOw","./en-il":"czMo","./en-il.js":"czMo","./en-in":"7C5Q","./en-in.js":"7C5Q","./en-nz":"b1Dy","./en-nz.js":"b1Dy","./en-sg":"t+mt","./en-sg.js":"t+mt","./eo":"Zduo","./eo.js":"Zduo","./es":"iYuL","./es-do":"CjzT","./es-do.js":"CjzT","./es-us":"Vclq","./es-us.js":"Vclq","./es.js":"iYuL","./et":"7BjC","./et.js":"7BjC","./eu":"D/JM","./eu.js":"D/JM","./fa":"jfSC","./fa.js":"jfSC","./fi":"gekB","./fi.js":"gekB","./fil":"1ppg","./fil.js":"1ppg","./fo":"ByF4","./fo.js":"ByF4","./fr":"nyYc","./fr-ca":"2fjn","./fr-ca.js":"2fjn","./fr-ch":"Dkky","./fr-ch.js":"Dkky","./fr.js":"nyYc","./fy":"cRix","./fy.js":"cRix","./ga":"USCx","./ga.js":"USCx","./gd":"9rRi","./gd.js":"9rRi","./gl":"iEDd","./gl.js":"iEDd","./gom-deva":"qvJo","./gom-deva.js":"qvJo","./gom-latn":"DKr+","./gom-latn.js":"DKr+","./gu":"4MV3","./gu.js":"4MV3","./he":"x6pH","./he.js":"x6pH","./hi":"3E1r","./hi.js":"3E1r","./hr":"S6ln","./hr.js":"S6ln","./hu":"WxRl","./hu.js":"WxRl","./hy-am":"1rYy","./hy-am.js":"1rYy","./id":"UDhR","./id.js":"UDhR","./is":"BVg3","./is.js":"BVg3","./it":"bpih","./it-ch":"bxKX","./it-ch.js":"bxKX","./it.js":"bpih","./ja":"B55N","./ja.js":"B55N","./jv":"tUCv","./jv.js":"tUCv","./ka":"IBtZ","./ka.js":"IBtZ","./kk":"bXm7","./kk.js":"bXm7","./km":"6B0Y","./km.js":"6B0Y","./kn":"PpIw","./kn.js":"PpIw","./ko":"Ivi+","./ko.js":"Ivi+","./ku":"JCF/","./ku.js":"JCF/","./ky":"lgnt","./ky.js":"lgnt","./lb":"RAwQ","./lb.js":"RAwQ","./lo":"sp3z","./lo.js":"sp3z","./lt":"JvlW","./lt.js":"JvlW","./lv":"uXwI","./lv.js":"uXwI","./me":"KTz0","./me.js":"KTz0","./mi":"aIsn","./mi.js":"aIsn","./mk":"aQkU","./mk.js":"aQkU","./ml":"AvvY","./ml.js":"AvvY","./mn":"lYtQ","./mn.js":"lYtQ","./mr":"Ob0Z","./mr.js":"Ob0Z","./ms":"6+QB","./ms-my":"ZAMP","./ms-my.js":"ZAMP","./ms.js":"6+QB","./mt":"G0Uy","./mt.js":"G0Uy","./my":"honF","./my.js":"honF","./nb":"bOMt","./nb.js":"bOMt","./ne":"OjkT","./ne.js":"OjkT","./nl":"+s0g","./nl-be":"2ykv","./nl-be.js":"2ykv","./nl.js":"+s0g","./nn":"uEye","./nn.js":"uEye","./oc-lnc":"Fnuy","./oc-lnc.js":"Fnuy","./pa-in":"8/+R","./pa-in.js":"8/+R","./pl":"jVdC","./pl.js":"jVdC","./pt":"8mBD","./pt-br":"0tRk","./pt-br.js":"0tRk","./pt.js":"8mBD","./ro":"lyxo","./ro.js":"lyxo","./ru":"lXzo","./ru.js":"lXzo","./sd":"Z4QM","./sd.js":"Z4QM","./se":"//9w","./se.js":"//9w","./si":"7aV9","./si.js":"7aV9","./sk":"e+ae","./sk.js":"e+ae","./sl":"gVVK","./sl.js":"gVVK","./sq":"yPMs","./sq.js":"yPMs","./sr":"zx6S","./sr-cyrl":"E+lV","./sr-cyrl.js":"E+lV","./sr.js":"zx6S","./ss":"Ur1D","./ss.js":"Ur1D","./sv":"X709","./sv.js":"X709","./sw":"dNwA","./sw.js":"dNwA","./ta":"PeUW","./ta.js":"PeUW","./te":"XLvN","./te.js":"XLvN","./tet":"V2x9","./tet.js":"V2x9","./tg":"Oxv6","./tg.js":"Oxv6","./th":"EOgW","./th.js":"EOgW","./tl-ph":"Dzi0","./tl-ph.js":"Dzi0","./tlh":"z3Vd","./tlh.js":"z3Vd","./tr":"DoHr","./tr.js":"DoHr","./tzl":"z1FC","./tzl.js":"z1FC","./tzm":"wQk9","./tzm-latn":"tT3J","./tzm-latn.js":"tT3J","./tzm.js":"wQk9","./ug-cn":"YRex","./ug-cn.js":"YRex","./uk":"raLr","./uk.js":"raLr","./ur":"UpQW","./ur.js":"UpQW","./uz":"Loxo","./uz-latn":"AQ68","./uz-latn.js":"AQ68","./uz.js":"Loxo","./vi":"KSF8","./vi.js":"KSF8","./x-pseudo":"/X5v","./x-pseudo.js":"/X5v","./yo":"fzPg","./yo.js":"fzPg","./zh-cn":"XDpg","./zh-cn.js":"XDpg","./zh-hk":"SatO","./zh-hk.js":"SatO","./zh-mo":"OmwH","./zh-mo.js":"OmwH","./zh-tw":"kOpN","./zh-tw.js":"kOpN"};function a(e){var t=r(e);return s(t)}function r(e){if(!s.o(n,e)){var t=new Error("Cannot find module '"+e+"'");throw t.code="MODULE_NOT_FOUND",t}return n[e]}a.keys=function(){return Object.keys(n)},a.resolve=r,e.exports=a,a.id="RnhZ"},VebN:function(e,t,s){"use strict";s.r(t);var n=s("o0o1"),a=s.n(n),r=s("yDJ3"),i=s.n(r),o=s("wd/R"),l=s.n(o);function c(e,t,s,n,a,r,i){try{var o=e[r](i),l=o.value}catch(e){return void s(e)}o.done?t(l):Promise.resolve(l).then(n,a)}var d={name:"Weather",data:function(){return{loading:!0,weather:{icon:"",tempFeelsLike:"",humidity:"",description:"",sunrise:"",sunset:""}}},methods:{fetchWeather:function(){var e,t=this;return(e=a.a.mark((function e(){var s,n,r,o,l;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:s="openweather--currentweather",r=localStorage.getItem(s);try{n=JSON.parse(r)}catch(e){n=null}if(n&&n.data&&!(n.saved+6e5<Date.now())){e.next=12;break}return n={data:{},saved:Date.now()},e.next=7,fetch("http://api.openweathermap.org/data/2.5/weather?q=Funchal,PT&appid=fe66d26d5b01501290be42a4809bbc4e&units=metric&lang=pt");case 7:return o=e.sent,e.next=10,o.json();case 10:n.data=e.sent,localStorage.setItem(s,JSON.stringify(n));case 12:l=i()(n,"data.weather[0].icon"),t.weather.icon="http://openweathermap.org/img/wn/".concat(l,".png"),t.weather.tempFeelsLike=i()(n,"data.main.feels_like"),t.weather.temp=i()(n,"data.main.temp"),t.weather.description=i()(n,"data.weather[0].description"),t.weather.humidity=i()(n,"data.main.humidity"),t.weather.sunrise=i()(n,"data.sys.sunrise"),t.weather.sunset=i()(n,"data.sys.sunset"),setTimeout((function(){return t.loading=!1}),500);case 21:case"end":return e.stop()}}),e)})),function(){var t=this,s=arguments;return new Promise((function(n,a){var r=e.apply(t,s);function i(e){c(r,n,a,i,o,"next",e)}function o(e){c(r,n,a,i,o,"throw",e)}i(void 0)}))})()}},filters:{capitalize:function(e){if(e){var t=e.toString();return t.charAt(0).toUpperCase()+t.slice(1)}},localTimeFromUnixTimestamp:function(e){if(e)return l.a.unix(e).format("HH:mm")}},created:function(){this.fetchWeather(),setInterval(this.fetchWeather,6e5)}},u=(s("L7bX"),s("KHd+")),v=Object(u.a)(d,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],attrs:{id:"weather"}},[s("div",{staticClass:"card mb-3 shadow"},[s("div",{staticClass:"card-body d-flex flex-wrap"},[s("div",{staticClass:"align-self-center"},[s("a",{attrs:{href:"https://openweathermap.org/city/2267827",target:"_blank"}},[s("img",{attrs:{src:e.weather.icon,alt:e.weather.description}})])]),e._v(" "),s("div",{staticClass:"divider align-items-stretch mx-2"}),e._v(" "),s("div",{staticClass:"align-self-center ml-2"},[e._v("\n        "+e._s(e._f("capitalize")(e.weather.description))+"\n      ")]),e._v(" "),s("div",{staticClass:"divider align-items-stretch mx-2"}),e._v(" "),s("div",{staticClass:"align-self-center"},[s("div",{staticClass:"d-flex"},[s("div",{staticClass:"align-items-stretch align-self-center"},[e._v("Temps:")]),e._v(" "),s("div",{staticClass:"d-flex flex-column ml-1"},[s("div",{attrs:{title:"Feels like"}},[e._v(e._s(e.weather.tempFeelsLike)+" ℃")]),e._v(" "),s("div",{attrs:{title:"Temperature"}},[s("small",[e._v(e._s(e.weather.temp)+" ℃")])])])])]),e._v(" "),s("div",{staticClass:"divider align-items-stretch mx-2"}),e._v(" "),s("div",{staticClass:"align-self-center"},[s("div",{staticClass:"d-flex"},[s("div",{staticClass:"flex-column"},[s("div",[e._v("Humidade")]),e._v(" "),s("div",{staticClass:"text-center"},[e._v(e._s(e.weather.humidity)+"%")])])])]),e._v(" "),s("div",{staticClass:"divider align-items-stretch mx-2"}),e._v(" "),s("div",{staticClass:"align-self-center"},[s("div",{staticClass:"d-flex"},[s("div",{staticClass:"flex-column ml-1"},[s("div",{attrs:{title:"Sunrise"}},[e._v(e._s(e._f("localTimeFromUnixTimestamp")(e.weather.sunrise)))]),e._v(" "),s("div",{attrs:{title:"Sunset"}},[e._v(e._s(e._f("localTimeFromUnixTimestamp")(e.weather.sunset)))])])])])])])])}),[],!1,null,"01380892",null);t.default=v.exports},dcHU:function(e,t,s){"use strict";var n=s("/txl");s.n(n).a},pyCd:function(e,t){},r3tC:function(e,t,s){(e.exports=s("I1BE")(!1)).push([e.i,"\n.slide-fade-enter-active[data-v-2b9823c0] {\n  transition: all .3s ease;\n}\n.slide-fade-leave-active[data-v-2b9823c0] {\n  transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);\n}\n.slide-fade-enter[data-v-2b9823c0], .slide-fade-leave-to[data-v-2b9823c0] {\n  background-color: #ffef0029;\n}\n",""])}},[[0,0,1]]]);