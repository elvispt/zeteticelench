(window.webpackJsonp=window.webpackJsonp||[]).push([[3],{"+RVh":function(t,s,e){"use strict";var n=e("FtNK");e.n(n).a},"1aZf":function(t,s,e){"use strict";e.r(s);var n=e("XuX8"),a=e.n(n),o=e("jE9Z"),r=e("o0o1"),i=e.n(r),c={name:"Navigation",props:{numberOfBookmarks:{type:null|Number,required:!0}},methods:{activeSubmenu:function(t){return this.$route.name===t?"btn-primary":"btn-secondary"}}},l=e("KHd+"),u=Object(l.a)(c,(function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{attrs:{id:"navigation"}},[e("div",{staticClass:"row justify-content-center top-submenu"},[e("div",{staticClass:"col-12 no-gutter-xs"},[e("div",{staticClass:"btn-group d-flex mb-2"},[e("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsTop"),attrs:{to:"/"}},[t._v("Top")]),t._v(" "),e("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsBest"),attrs:{to:"/best"}},[t._v("Best")]),t._v(" "),e("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsBookmarks"),attrs:{to:"/bookmark"}},[t._v("Saved "),e("span",{staticClass:"badge badge-light"},[t._v(t._s(t.numberOfBookmarks))])])],1)])])])}),[],!1,null,null,null).exports,d=e("Wcq6"),m=e.n(d),f=(e("Zs65"),m.a.initializeApp({databaseURL:"hacker-news.firebaseio.com"}).database().ref("/v0")),k=e("yDJ3"),j=e.n(k),p=e("wd/R"),v=e.n(p),h=e("vDqi"),b=e.n(h);function w(t,s,e,n,a,o,r){try{var i=t[o](r),c=i.value}catch(t){return void e(t)}i.done?s(c):Promise.resolve(c).then(n,a)}function x(t){return function(){var s=this,e=arguments;return new Promise((function(n,a){var o=t.apply(s,e);function r(t){w(o,n,a,r,i,"next",t)}function i(t){w(o,n,a,r,i,"throw",t)}r(void 0)}))}}var g={name:"HNPosts",props:{idList:{type:Array,default:[],required:!0}},data:function(){return{loading:!0,posts:[],nBookmarks:null}},methods:{fetchItems:function(t){var s=this;Promise.all(t.map((function(t){return s.fetchItem(t)}))).then((function(t){s.posts=t,s.attachBookmarked(),s.loading=!1}))},fetchItem:function(t){return new Promise((function(s,e){f.child("item/".concat(t)).on("value",(function(t){var e=t.val(),n={id:j()(e,"id"),title:j()(e,"title"),score:j()(e,"score"),time:v.a.unix(j()(e,"time",0)).format("YYYY-MM-DD HH:mm:ss"),url:j()(e,"url"),type:j()(e,"type"),nComments:j()(e,"descendants"),bookmarked:!1};s(n)})),f.onDisconnect((function(t,s){this.$alert("Firebase connection lost","Lost connection",{confirmButtonText:"OK"}),console.log(t,s)}))}))},attachBookmarked:function(){var t=this;return x(i.a.mark((function s(){var e,n;return i.a.wrap((function(s){for(;;)switch(s.prev=s.next){case 0:return s.next=2,b.a.get("/api/bookmarks");case 2:e=s.sent,n=j()(e,"data.data",[]),t.nBookmarks=n.length,t.posts=t.posts.map((function(t){return t.bookmarked=n.includes(t.id),t}));case 6:case"end":return s.stop()}}),s)})))()},bookmarkPost:function(t,s){var e=this;return x(i.a.mark((function t(){var n,a;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return n={postId:s.id},s.bookmarked&&(n._method="delete"),t.next=4,b.a.post("/api/bookmarks",n);case 4:a=t.sent,j()(a,"data.data.success",!1)&&(e.nBookmarks+=s.bookmarked?-1:1,e.posts.find((function(t){t.id===s.id&&(t.bookmarked=!t.bookmarked)})));case 6:case"end":return t.stop()}}),t)})))()}},watch:{idList:function(t,s){this.loading=!0,this.fetchItems(t)},nBookmarks:function(t,s){this.$emit("nBookmarksChangedEvent",t)}}};e("+RVh");function y(t,s,e,n,a,o,r){try{var i=t[o](r),c=i.value}catch(t){return void e(t)}i.done?s(c):Promise.resolve(c).then(n,a)}var C={name:"HackerNews",components:{Navigation:u,HnPosts:Object(l.a)(g,(function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("ul",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"list-group",attrs:{id:"hn-posts"}},[t._l(Array(10).fill(null),(function(s){return t.loading?e("li",{staticClass:"list-group-item list-group-item-action flex-column align-items-start"},[t._m(0,!0),t._v(" "),t._m(1,!0)]):t._e()})),t._v(" "),e("transition-group",{attrs:{name:"slide-fade",mode:"out-in"}},t._l(t.posts,(function(s,n){return e("li",{key:s.id,staticClass:"list-group-item list-group-item-action flex-column align-items-start",attrs:{"data-index":n+1}},[e("div",{staticClass:"d-flex w-100 justify-content-between"},[e("span",[e("router-link",{staticClass:"text-body",attrs:{to:"/post/"+s.id}},[t._v(t._s(s.title))]),t._v(" "),s.url?e("a",{staticClass:"text-body",attrs:{href:s.url,target:"_blank"}},[e("small",{staticClass:"text-muted"},[t._v("("+t._s(t._f("domainFromUrl")(s.url))+")")])]):t._e()],1),t._v(" "),e("span",{staticClass:"d-block d-md-none"},[e("span",{staticClass:"bookmark-story pointer text-primary",on:{click:function(e){return t.bookmarkPost(e,s)}}},[t._v(t._s(s.bookmarked?"⚫":"⚪️")+"️")])]),t._v(" "),e("span",{staticClass:"badge d-none d-md-block"},[t._v(t._s(t._f("diffForHumans")(s.time)))])]),t._v(" "),e("div",{staticClass:"d-none d-md-block"},[e("small",{staticClass:"text-muted"},[t._v(t._s(s.score)+" points")]),t._v("\n      |\n      "),e("small",[t._v(t._s(s.nComments)+" comments")]),t._v("\n      |\n      "),e("span",{staticClass:"bookmark-story pointer text-primary",on:{click:function(e){return t.bookmarkPost(e,s)}}},[t._v(t._s(s.bookmarked?"⚫":"⚪️"))])])])})),0)],2)}),[function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"d-flex w-100 justify-content-between"},[s("span",{staticClass:"loader-text loader-text-top d-block w-100"},[this._v(" ")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"d-none d-md-block"},[s("span",{staticClass:"loader-text loader-text-bottom loader-text--1x3 d-inline-block"},[s("small",[this._v(" ")])])])}],!1,null,"6df1a9b4",null).exports},data:function(){return{idList:[],limit:100,routesMap:{HackerNewsTop:"top",HackerNewsBest:"best",HackerNewsBookmarks:"bookmarks"},numberOfBookmarks:null}},methods:{fetchStories:function(t){var s=j()(this.routesMap,t,"top");s===this.routesMap.HackerNewsBookmarks?this.fetchIdsBookmarkedFromBackend():this.fetchIdsFromFirebase(s)},fetchIdsFromFirebase:function(t){var s=this;f.child("".concat(t,"stories")).limitToFirst(this.limit).on("value",(function(t){var e=t.val();s.idList=Array.isArray(e)?e:[]}))},fetchIdsBookmarkedFromBackend:function(){var t,s=this;return(t=i.a.mark((function t(){var e;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,b.a.get("/api/bookmarks");case 2:e=t.sent,s.idList=j()(e,"data.data",[]);case 4:case"end":return t.stop()}}),t)})),function(){var s=this,e=arguments;return new Promise((function(n,a){var o=t.apply(s,e);function r(t){y(o,n,a,r,i,"next",t)}function i(t){y(o,n,a,r,i,"throw",t)}r(void 0)}))})()},updateNumberOfBookmarks:function(t){this.numberOfBookmarks=t}},created:function(){this.fetchStories(this.$route.name)},watch:{$route:function(t,s){this.fetchStories(t.name)}}},_=Object(l.a)(C,(function(){var t=this.$createElement,s=this._self._c||t;return s("div",{attrs:{id:"hacker-news"}},[s("navigation",{attrs:{"number-of-bookmarks":this.numberOfBookmarks}}),this._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-12 no-gutter-xs"},[s("hn-posts",{attrs:{"id-list":this.idList},on:{nBookmarksChangedEvent:this.updateNumberOfBookmarks}})],1)])],1)}),[],!1,null,null,null).exports,z={name:"HackerNewsPost",components:{Navigation:u},props:{id:{type:Number,required:!0}},data:function(){return{post:{id:null,title:null,score:null,time:null,url:null,type:null,nComments:null,bookmarked:null,kids:[],comments:[]}}},methods:{},created:function(){}},B=Object(l.a)(z,(function(){var t=this.$createElement,s=this._self._c||t;return s("div",{attrs:{id:"hacker-news-post"}},[s("navigation"),this._v(" "),this._m(0)],1)}),[function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"row"},[s("div",{staticClass:"col-12 no-gutter-xs"})])}],!1,null,"49ae01db",null).exports;a.a.use(o.a);var O=new o.a({routes:[{path:"/",name:"HackerNewsTop",component:_},{path:"/best",name:"HackerNewsBest",component:_},{path:"/bookmark",name:"HackerNewsBookmarks",component:_},{path:"/post/:id",name:"HackerNewsPost",component:B,props:!0}]}),D=e("XJYT"),N=e.n(D);e("D66Q");a.a.filter("diffForHumans",(function(t){if(t)return v()(t,"YYYY-MM-DD hh:mm:ss").fromNow()})),a.a.filter("domainFromUrl",(function(t){if(t)return new URL(t).hostname.replace("www.","")}));var F=e("D/Jt");e("9Wh1"),window.Vue=e("XuX8"),Vue.use(N.a),Vue.use(F.a);new Vue({router:O,el:"#app"})},2:function(t,s,e){t.exports=e("1aZf")},"9Wh1":function(t,s,e){"use strict";e.r(s);var n=e("3CEA"),a=e("gtzJ");n.a({dsn:"https://50142ad267aa4c7c9dab6ed21262d2ab@sentry.io/1504143"});try{window.Popper=e("8L3F").default,window.$=window.jQuery=e("EVdn"),e("SYky")}catch(t){a.a(t)}window.axios=e("vDqi"),window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";var o=document.head.querySelector('meta[name="csrf-token"]');if(o)window.axios.defaults.headers.common["X-CSRF-TOKEN"]=o.content,window.axios.interceptors.response.use(null,(function(t){t.response?401!==t.response.status&&419!==t.response.status||window.location.replace("/login"):(a.b(t),console.error("Unknown error: ".concat(t)))})),window.$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}});else{var r="CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token";a.b(r),console.error(r)}},FtNK:function(t,s,e){var n=e("d3FC");"string"==typeof n&&(n=[[t.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};e("aET+")(n,a);n.locals&&(t.exports=n.locals)},RnhZ:function(t,s,e){var n={"./af":"K/tc","./af.js":"K/tc","./ar":"jnO4","./ar-dz":"o1bE","./ar-dz.js":"o1bE","./ar-kw":"Qj4J","./ar-kw.js":"Qj4J","./ar-ly":"HP3h","./ar-ly.js":"HP3h","./ar-ma":"CoRJ","./ar-ma.js":"CoRJ","./ar-sa":"gjCT","./ar-sa.js":"gjCT","./ar-tn":"bYM6","./ar-tn.js":"bYM6","./ar.js":"jnO4","./az":"SFxW","./az.js":"SFxW","./be":"H8ED","./be.js":"H8ED","./bg":"hKrs","./bg.js":"hKrs","./bm":"p/rL","./bm.js":"p/rL","./bn":"kEOa","./bn.js":"kEOa","./bo":"0mo+","./bo.js":"0mo+","./br":"aIdf","./br.js":"aIdf","./bs":"JVSJ","./bs.js":"JVSJ","./ca":"1xZ4","./ca.js":"1xZ4","./cs":"PA2r","./cs.js":"PA2r","./cv":"A+xa","./cv.js":"A+xa","./cy":"l5ep","./cy.js":"l5ep","./da":"DxQv","./da.js":"DxQv","./de":"tGlX","./de-at":"s+uk","./de-at.js":"s+uk","./de-ch":"u3GI","./de-ch.js":"u3GI","./de.js":"tGlX","./dv":"WYrj","./dv.js":"WYrj","./el":"jUeY","./el.js":"jUeY","./en-au":"Dmvi","./en-au.js":"Dmvi","./en-ca":"OIYi","./en-ca.js":"OIYi","./en-gb":"Oaa7","./en-gb.js":"Oaa7","./en-ie":"4dOw","./en-ie.js":"4dOw","./en-il":"czMo","./en-il.js":"czMo","./en-in":"7C5Q","./en-in.js":"7C5Q","./en-nz":"b1Dy","./en-nz.js":"b1Dy","./en-sg":"t+mt","./en-sg.js":"t+mt","./eo":"Zduo","./eo.js":"Zduo","./es":"iYuL","./es-do":"CjzT","./es-do.js":"CjzT","./es-us":"Vclq","./es-us.js":"Vclq","./es.js":"iYuL","./et":"7BjC","./et.js":"7BjC","./eu":"D/JM","./eu.js":"D/JM","./fa":"jfSC","./fa.js":"jfSC","./fi":"gekB","./fi.js":"gekB","./fil":"1ppg","./fil.js":"1ppg","./fo":"ByF4","./fo.js":"ByF4","./fr":"nyYc","./fr-ca":"2fjn","./fr-ca.js":"2fjn","./fr-ch":"Dkky","./fr-ch.js":"Dkky","./fr.js":"nyYc","./fy":"cRix","./fy.js":"cRix","./ga":"USCx","./ga.js":"USCx","./gd":"9rRi","./gd.js":"9rRi","./gl":"iEDd","./gl.js":"iEDd","./gom-deva":"qvJo","./gom-deva.js":"qvJo","./gom-latn":"DKr+","./gom-latn.js":"DKr+","./gu":"4MV3","./gu.js":"4MV3","./he":"x6pH","./he.js":"x6pH","./hi":"3E1r","./hi.js":"3E1r","./hr":"S6ln","./hr.js":"S6ln","./hu":"WxRl","./hu.js":"WxRl","./hy-am":"1rYy","./hy-am.js":"1rYy","./id":"UDhR","./id.js":"UDhR","./is":"BVg3","./is.js":"BVg3","./it":"bpih","./it-ch":"bxKX","./it-ch.js":"bxKX","./it.js":"bpih","./ja":"B55N","./ja.js":"B55N","./jv":"tUCv","./jv.js":"tUCv","./ka":"IBtZ","./ka.js":"IBtZ","./kk":"bXm7","./kk.js":"bXm7","./km":"6B0Y","./km.js":"6B0Y","./kn":"PpIw","./kn.js":"PpIw","./ko":"Ivi+","./ko.js":"Ivi+","./ku":"JCF/","./ku.js":"JCF/","./ky":"lgnt","./ky.js":"lgnt","./lb":"RAwQ","./lb.js":"RAwQ","./lo":"sp3z","./lo.js":"sp3z","./lt":"JvlW","./lt.js":"JvlW","./lv":"uXwI","./lv.js":"uXwI","./me":"KTz0","./me.js":"KTz0","./mi":"aIsn","./mi.js":"aIsn","./mk":"aQkU","./mk.js":"aQkU","./ml":"AvvY","./ml.js":"AvvY","./mn":"lYtQ","./mn.js":"lYtQ","./mr":"Ob0Z","./mr.js":"Ob0Z","./ms":"6+QB","./ms-my":"ZAMP","./ms-my.js":"ZAMP","./ms.js":"6+QB","./mt":"G0Uy","./mt.js":"G0Uy","./my":"honF","./my.js":"honF","./nb":"bOMt","./nb.js":"bOMt","./ne":"OjkT","./ne.js":"OjkT","./nl":"+s0g","./nl-be":"2ykv","./nl-be.js":"2ykv","./nl.js":"+s0g","./nn":"uEye","./nn.js":"uEye","./oc-lnc":"Fnuy","./oc-lnc.js":"Fnuy","./pa-in":"8/+R","./pa-in.js":"8/+R","./pl":"jVdC","./pl.js":"jVdC","./pt":"8mBD","./pt-br":"0tRk","./pt-br.js":"0tRk","./pt.js":"8mBD","./ro":"lyxo","./ro.js":"lyxo","./ru":"lXzo","./ru.js":"lXzo","./sd":"Z4QM","./sd.js":"Z4QM","./se":"//9w","./se.js":"//9w","./si":"7aV9","./si.js":"7aV9","./sk":"e+ae","./sk.js":"e+ae","./sl":"gVVK","./sl.js":"gVVK","./sq":"yPMs","./sq.js":"yPMs","./sr":"zx6S","./sr-cyrl":"E+lV","./sr-cyrl.js":"E+lV","./sr.js":"zx6S","./ss":"Ur1D","./ss.js":"Ur1D","./sv":"X709","./sv.js":"X709","./sw":"dNwA","./sw.js":"dNwA","./ta":"PeUW","./ta.js":"PeUW","./te":"XLvN","./te.js":"XLvN","./tet":"V2x9","./tet.js":"V2x9","./tg":"Oxv6","./tg.js":"Oxv6","./th":"EOgW","./th.js":"EOgW","./tl-ph":"Dzi0","./tl-ph.js":"Dzi0","./tlh":"z3Vd","./tlh.js":"z3Vd","./tr":"DoHr","./tr.js":"DoHr","./tzl":"z1FC","./tzl.js":"z1FC","./tzm":"wQk9","./tzm-latn":"tT3J","./tzm-latn.js":"tT3J","./tzm.js":"wQk9","./ug-cn":"YRex","./ug-cn.js":"YRex","./uk":"raLr","./uk.js":"raLr","./ur":"UpQW","./ur.js":"UpQW","./uz":"Loxo","./uz-latn":"AQ68","./uz-latn.js":"AQ68","./uz.js":"Loxo","./vi":"KSF8","./vi.js":"KSF8","./x-pseudo":"/X5v","./x-pseudo.js":"/X5v","./yo":"fzPg","./yo.js":"fzPg","./zh-cn":"XDpg","./zh-cn.js":"XDpg","./zh-hk":"SatO","./zh-hk.js":"SatO","./zh-mo":"OmwH","./zh-mo.js":"OmwH","./zh-tw":"kOpN","./zh-tw.js":"kOpN"};function a(t){var s=o(t);return e(s)}function o(t){if(!e.o(n,t)){var s=new Error("Cannot find module '"+t+"'");throw s.code="MODULE_NOT_FOUND",s}return n[t]}a.keys=function(){return Object.keys(n)},a.resolve=o,t.exports=a,a.id="RnhZ"},d3FC:function(t,s,e){(t.exports=e("I1BE")(!1)).push([t.i,"\n.bookmark-story[data-v-6df1a9b4] {\n  position: relative;\n  top: 2px;\n  text-decoration: none;\n}\n.loader-text[data-v-6df1a9b4] {\n  background: #808080;\n  border-radius: 2px;\n}\n.loader-text--1x3[data-v-6df1a9b4] {\n  width: 33%;\n}\n.loader-text--1x2[data-v-6df1a9b4] {\n  width: 50%;\n}\n.loader-text-top[data-v-6df1a9b4] {\n  height: 22px;\n  margin-bottom: 6px;\n}\n.loader-text-bottom[data-v-6df1a9b4] {\n  height: 18px;\n}\n.slide-fade-enter-active[data-v-6df1a9b4] {\n  transition: all .3s ease;\n}\n.slide-fade-leave-active[data-v-6df1a9b4] {\n  transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);\n}\n.slide-fade-enter[data-v-6df1a9b4], .slide-fade-leave-to[data-v-6df1a9b4] {\n  background-color: #ffef0029;\n}\n",""])}},[[2,0,1]]]);