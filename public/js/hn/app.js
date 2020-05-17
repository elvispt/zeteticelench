(window.webpackJsonp=window.webpackJsonp||[]).push([[3],{"1aZf":function(t,s,e){"use strict";e.r(s);var n=e("XuX8"),a=e.n(n),o=e("jE9Z"),r=e("o0o1"),i=e.n(r),l={name:"Navigation",props:{numberOfBookmarks:{type:null|Number,required:!0}},methods:{activeSubmenu:function(t){return this.$route.name===t?"btn-primary":"btn-secondary"}}},c=e("KHd+"),u=Object(c.a)(l,(function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{attrs:{id:"navigation"}},[e("div",{staticClass:"row justify-content-center top-submenu"},[e("div",{staticClass:"col-12 no-gutter-xs"},[e("div",{staticClass:"btn-group d-flex mb-2"},[e("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsTop"),attrs:{to:"/"}},[t._v("Top")]),t._v(" "),e("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsBest"),attrs:{to:"/best"}},[t._v("Best")]),t._v(" "),e("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsBookmarks"),attrs:{to:"/bookmark"}},[t._v("Saved "),e("span",{staticClass:"badge badge-light"},[t._v(t._s(t.numberOfBookmarks))])])],1)])])])}),[],!1,null,null,null).exports,m=e("vDqi"),d=e.n(m),v=e("yDJ3"),p=e.n(v);function f(t,s,e,n,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void e(t)}i.done?s(l):Promise.resolve(l).then(n,a)}var h={data:function(){return{nBookmarks:null,notification:null}},methods:{bookmarkPost:function(t){var s,e=this;return(s=i.a.mark((function s(){var n,a,o,r;return i.a.wrap((function(s){for(;;)switch(s.prev=s.next){case 0:return t.status.saving=!0,n={postId:t.id},(a=!t.status.bookmarked)||(n._method="delete"),s.next=6,d.a.post("/api/bookmarks",n);case 6:o=s.sent,(r=p()(o,"data.data.success",!1))&&(t.status.bookmarked=!t.status.bookmarked,e.nBookmarks+=a?1:-1),e.notifyUserOfBookmarkStatusChange(r,a,t);case 10:case"end":return s.stop()}}),s)})),function(){var t=this,e=arguments;return new Promise((function(n,a){var o=s.apply(t,e);function r(t){f(o,n,a,r,i,"next",t)}function i(t){f(o,n,a,r,i,"throw",t)}r(void 0)}))})()},notifyUserOfBookmarkStatusChange:function(t,s,e){var n={message:"'Something went wrong when calling bookmarks.'",type:"error"};t&&(n=s?{message:'"'.concat(e.title,'" added to bookmarks!'),type:"success"}:{message:'"'.concat(e.title,'" removed from bookmarks!'),type:"warning"}),this.notification&&!this.notification.closed&&this.notification.close(),this.notification=this.$message(n),setTimeout((function(){return e.status.saving=!1}),400)}}},k=e("Wcq6"),b=e.n(k),g=(e("Zs65"),b.a.initializeApp({databaseURL:"hacker-news.firebaseio.com"}).database().ref("/v0")),j=e("wd/R"),x=e.n(j);function C(t,s,e,n,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void e(t)}i.done?s(l):Promise.resolve(l).then(n,a)}function y(t){return function(t){if(Array.isArray(t))return _(t)}(t)||function(t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}(t)||function(t,s){if(!t)return;if("string"==typeof t)return _(t,s);var e=Object.prototype.toString.call(t).slice(8,-1);"Object"===e&&t.constructor&&(e=t.constructor.name);if("Map"===e||"Set"===e)return Array.from(t);if("Arguments"===e||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(e))return _(t,s)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function _(t,s){(null==s||s>t.length)&&(s=t.length);for(var e=0,n=new Array(s);e<s;e++)n[e]=t[e];return n}var w={name:"HNPosts",mixins:[h],props:{idList:{type:Array,default:[],required:!0}},data:function(){return{loading:!0,posts:[],nBookmarks:null,firstBatchPosition:10}},methods:{fetchItems:function(t){var s=this,e=this.firstBatchPosition;t.length<e&&(e=Math.floor(t.length/2));var n=t.slice(0,e),a=t.slice(e);Promise.all(n.map((function(t){return s.fetchItem(t)}))).then((function(t){s.posts=t,s.attachBookmarked(),s.loading=!1})),this.$nextTick((function(){Promise.all(a.map((function(t){return s.fetchItem(t)}))).then((function(t){var e;(e=s.posts).push.apply(e,y(t)),s.attachBookmarked()}))}))},fetchItem:function(t){return new Promise((function(s,e){g.child("item/".concat(t)).on("value",(function(t){var e=t.val(),n={id:p()(e,"id"),title:p()(e,"title"),score:p()(e,"score"),time:x.a.unix(p()(e,"time",0)).format("YYYY-MM-DD HH:mm:ss"),url:p()(e,"url"),type:p()(e,"type"),nComments:p()(e,"descendants"),kids:p()(e,"kids",[]),status:{bookmarked:!1,saving:!1}};s(n)})),g.onDisconnect((function(t,s){this.$alert("Firebase connection lost","Lost connection",{confirmButtonText:"OK"}),console.log(t,s)}))}))},attachBookmarked:function(){var t,s=this;return(t=i.a.mark((function t(){var e,n;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,d.a.get("/api/bookmarks");case 2:e=t.sent,n=p()(e,"data.data",[]),s.nBookmarks=n.length,s.posts=s.posts.map((function(t){return t.status.bookmarked=n.includes(t.id),t}));case 6:case"end":return t.stop()}}),t)})),function(){var s=this,e=arguments;return new Promise((function(n,a){var o=t.apply(s,e);function r(t){C(o,n,a,r,i,"next",t)}function i(t){C(o,n,a,r,i,"throw",t)}r(void 0)}))})()}},watch:{idList:function(t,s){var e=this;this.loading=!0,setTimeout((function(){return e.fetchItems(t)}),400)},nBookmarks:function(t,s){this.$emit("nBookmarksChangedEvent",t)}}};e("YhZz");function B(t,s,e,n,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void e(t)}i.done?s(l):Promise.resolve(l).then(n,a)}var O={name:"HackerNews",components:{Navigation:u,HnPosts:Object(c.a)(w,(function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("ul",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"list-group",attrs:{id:"hn-posts"}},[t._l(Array(t.firstBatchPosition).fill(null),(function(s){return t.loading?e("li",{staticClass:"list-group-item list-group-item-action flex-column align-items-start"},[t._m(0,!0),t._v(" "),t._m(1,!0)]):t._e()})),t._v(" "),t._l(t.posts,(function(s,n){return e("li",{key:s.id,staticClass:"list-group-item list-group-item-action flex-column align-items-start",attrs:{"data-index":n+1}},[e("div",{staticClass:"d-flex w-100 justify-content-between"},[e("span",[e("router-link",{staticClass:"text-body",attrs:{to:"/post/"+s.id}},[t._v(t._s(s.title))]),t._v(" "),s.url?e("a",{staticClass:"text-body",attrs:{href:s.url,target:"_blank"}},[e("small",{staticClass:"text-muted"},[t._v("("+t._s(t._f("domainFromUrl")(s.url))+")")])]):t._e()],1),t._v(" "),e("span",{directives:[{name:"loading",rawName:"v-loading",value:s.status.saving,expression:"post.status.saving"}],staticClass:"d-block d-md-none"},[e("span",{staticClass:"bookmark-story pointer text-primary",on:{click:function(e){return t.bookmarkPost(s)}}},[t._v(t._s(s.status.bookmarked?"⚫":"⚪️")+"️")])]),t._v(" "),e("span",{staticClass:"badge d-none d-md-block"},[t._v(t._s(t._f("diffForHumans")(s.time)))])]),t._v(" "),e("div",{directives:[{name:"loading",rawName:"v-loading",value:s.status.saving,expression:"post.status.saving"}],staticClass:"d-none d-md-block"},[e("small",{staticClass:"text-muted"},[t._v(t._s(s.score)+" points")]),t._v("\n      |\n      "),e("small",[t._v(t._s(s.nComments)+" comments")]),t._v("\n      |\n      "),e("span",{staticClass:"bookmark-story pointer text-primary",on:{click:function(e){return t.bookmarkPost(s)}}},[t._v(t._s(s.status.bookmarked?"⚫":"⚪️"))])])])}))],2)}),[function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"d-flex w-100 justify-content-between"},[s("span",{staticClass:"loader-text loader-text-top d-block w-100"},[this._v(" ")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"d-none d-md-block"},[s("span",{staticClass:"loader-text loader-text-bottom loader-text--1x3 d-inline-block"},[s("small",[this._v(" ")])])])}],!1,null,"14c6dd0a",null).exports},data:function(){return{idList:[],limit:100,routesMap:{HackerNewsTop:"top",HackerNewsBest:"best",HackerNewsBookmarks:"bookmarks"},numberOfBookmarks:null}},methods:{fetchStories:function(t){var s=p()(this.routesMap,t,"top");s===this.routesMap.HackerNewsBookmarks?this.fetchIdsBookmarkedFromBackend():this.fetchIdsFromFirebase(s)},fetchIdsFromFirebase:function(t){var s=this;g.child("".concat(t,"stories")).limitToFirst(this.limit).once("value",(function(t,e){var n=t.val();s.idList=Array.isArray(n)?n:[]}))},fetchIdsBookmarkedFromBackend:function(){var t,s=this;return(t=i.a.mark((function t(){var e;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,d.a.get("/api/bookmarks");case 2:e=t.sent,s.idList=p()(e,"data.data",[]);case 4:case"end":return t.stop()}}),t)})),function(){var s=this,e=arguments;return new Promise((function(n,a){var o=t.apply(s,e);function r(t){B(o,n,a,r,i,"next",t)}function i(t){B(o,n,a,r,i,"throw",t)}r(void 0)}))})()},updateNumberOfBookmarks:function(t){this.numberOfBookmarks=t}},created:function(){this.fetchStories(this.$route.name)},watch:{$route:function(t,s){this.fetchStories(t.name)}}},z=Object(c.a)(O,(function(){var t=this.$createElement,s=this._self._c||t;return s("div",{attrs:{id:"hacker-news"}},[s("navigation",{attrs:{"number-of-bookmarks":this.numberOfBookmarks}}),this._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-12 no-gutter-xs"},[s("hn-posts",{attrs:{"id-list":this.idList},on:{nBookmarksChangedEvent:this.updateNumberOfBookmarks}})],1)])],1)}),[],!1,null,null,null).exports,N={name:"HnComment",props:{comment:{type:Object,required:!0},handleCollapseToggle:{type:Function,required:!0}},data:function(){return{isShow:!0}}},H=(e("zS51"),Object(c.a)(N,(function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"hn-comment card mt-3"},[e("div",{staticClass:"card-body px-2 px-md-3 shadow"},[e("h6",{staticClass:"card-subtitle bg-light text-muted d-flex justify-content-between align-items-center",class:{"opacity-5 text-line-through":t.comment.deleted}},[t.comment.id?e("span",{staticClass:"align-middle"},[t._v("by "+t._s(t.comment.by))]):t._e(),t._v(" "),e("small",{staticClass:"text-muted"},[t._v(t._s(t._f("diffForHumans")(t.comment.time)))]),t._v(" "),t.comment.id?e("a",{staticClass:"btn btn-sm btn-outline-secondary pointer btn-collapse",attrs:{role:"button","data-toggle":"collapse"},on:{click:function(s){return t.handleCollapseToggle(t.comment)}}},[e("b",[t.comment.collapsed?e("span",[t._v("+")]):t._e(),t._v(" "),t.comment.collapsed?t._e():e("span",[t._v("-")])])]):t._e()]),t._v(" "),e("transition",{attrs:{name:"slide"}},[t.comment.collapsed?t._e():e("div",{staticClass:"mt-2"},[e("p",{domProps:{innerHTML:t._s(t.comment.text)}}),t._v(" "),t._l(t.comment.comments,(function(s){return t.comment.comments.length?e("hn-comment",{key:s.id,attrs:{comment:s,"handle-collapse-toggle":t.handleCollapseToggle}}):t._e()}))],2)])],1)])}),[],!1,null,"b53b4be6",null).exports),D=e("gtzJ");function S(t,s,e,n,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void e(t)}i.done?s(l):Promise.resolve(l).then(n,a)}var R={name:"HackerNewsPost",mixins:[h],components:{Navigation:u,HnComment:H},props:{id:{type:String,required:!0}},data:function(){return{loading:!0,loadingComments:!0,collapsedCommentsKey:"collapsedCommentsHackerNewsPost",collapsedComments:[],post:{id:null,by:null,title:null,text:null,score:null,time:null,url:null,type:null,nComments:null,status:{bookmarked:null,saving:null},kids:[],comments:[{id:null,by:null,kids:[],parent:null,text:null,time:null,comments:[]}]},numberOfBookmarks:null}},methods:{fetchPost:function(t){var s=this;t&&(this.fetchCollapsedComments(),g.child("item/".concat(t)).once("value",(function(t){var e=t.val();s.post.id=p()(e,"id"),s.post.by=p()(e,"by"),s.post.title=p()(e,"title"),s.post.text=p()(e,"text"),s.post.score=p()(e,"score"),s.post.time=x.a.unix(p()(e,"time",0)).format("YYYY-MM-DD HH:mm:ss"),s.post.url=p()(e,"url"),s.post.type=p()(e,"type"),s.post.nComments=p()(e,"descendants"),s.post.bookmarked=null,s.post.kids=p()(e,"kids",[]),s.post.comments=[],s.setBookmarkStatus(s.post),s.fetchComments(s.post),s.loading=!1})))},fetchComments:function(t){var s=this;t.kids.length&&t.kids.map((function(e){s.fetchComment(e).then((function(e){var n=p()(e,"kids",[]),a=p()(e,"id"),o={id:a,deleted:p()(e,"deleted"),by:p()(e,"by"),kids:n,text:p()(e,"text"),time:x.a.unix(p()(e,"time",0)).format("YYYY-MM-DD HH:mm:ss"),comments:[],collapsed:s.collapsedComments.includes(a)};s.fetchComments(o),t.comments.push(o),s.loadingComments=!1}))}))},fetchComment:function(t){return new Promise((function(s,e){g.child("item/".concat(t)).once("value",(function(t){var e=t.val();s(e)}))}))},setBookmarkStatus:function(t){var s,e=this;return(s=i.a.mark((function s(){var n,a;return i.a.wrap((function(s){for(;;)switch(s.prev=s.next){case 0:return s.next=2,d.a.get("/api/bookmarks");case 2:n=s.sent,a=p()(n,"data.data",[]),e.numberOfBookmarks=a.length,t.status.bookmarked=a.includes(t.id);case 6:case"end":return s.stop()}}),s)})),function(){var t=this,e=arguments;return new Promise((function(n,a){var o=s.apply(t,e);function r(t){S(o,n,a,r,i,"next",t)}function i(t){S(o,n,a,r,i,"throw",t)}r(void 0)}))})()},fetchCollapsedComments:function(){var t,s=localStorage.getItem(this.collapsedCommentsKey);try{t=JSON.parse(s)}catch(t){D.b(t)}t=Array.isArray(t)?t:[],this.collapsedComments=t},setCollapsedComments:function(){var t=JSON.stringify(this.collapsedComments);localStorage.setItem(this.collapsedCommentsKey,t)},handleCollapseToggle:function(t){t.collapsed=!t.collapsed,t.collapsed?this.collapsedComments.push(t.id):this.collapsedComments=this.collapsedComments.filter((function(s){return s!==t.id})),this.setCollapsedComments()}},created:function(){this.fetchPost(this.id)}},P=(e("u3+z"),Object(c.a)(R,(function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{attrs:{id:"hacker-news-post"}},[e("navigation",{attrs:{"number-of-bookmarks":t.numberOfBookmarks}}),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-12 no-gutter-xs"},[e("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[t.loading?e("p",{staticClass:"lead loader-text d-block loader-text--2x3"},[t._v(" ")]):t._e(),t._v(" "),t.post.title?e("p",{staticClass:"lead"},[t._v("\n          "+t._s(t.post.title)+"\n          "),t.post.url?e("a",{staticClass:"text-body",attrs:{href:t.post.url,target:"_blank"}},[e("small",{staticClass:"text-muted"},[t._v("("+t._s(t._f("domainFromUrl")(t.post.url))+") [↗]")])]):t._e()]):t._e(),t._v(" "),t.post.text?e("p",{domProps:{innerHTML:t._s(t.post.text)}}):t._e(),t._v(" "),t.loading?e("div",{staticClass:"loader-text d-block loader-text--1x3"},[t._v(" ")]):t._e(),t._v(" "),t.post.title?e("div",{directives:[{name:"loading",rawName:"v-loading",value:t.post.status.saving,expression:"post.status.saving"}]},[e("small",{staticClass:"text-muted"},[t._v(t._s(t.post.score)+" points")]),t._v(" "),e("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),e("small",{staticClass:"text-muted"},[t._v(t._s(t.post.nComments)+" comments")]),t._v(" "),e("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),e("small",{staticClass:"text-muted"},[t._v(t._s(t._f("diffForHumans")(t.post.time)))]),t._v(" "),e("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),e("small",{staticClass:"text-muted"},[t._v("by "+t._s(t.post.by))]),t._v(" "),e("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),e("span",{staticClass:"bookmark-story pointer text-primary",on:{click:function(s){return t.bookmarkPost(t.post)}}},[t._v(t._s(t.post.status.bookmarked?"⚫":"⚪️")+"️")])]):t._e()])])]),t._v(" "),t.post.comments.length?e("div",{staticClass:"row"},[e("div",{staticClass:"col-12 no-gutter-xs"},[t.loadingComments?t._e():e("div",t._l(t.post.comments,(function(s){return e("hn-comment",{key:s.id,attrs:{comment:s,"handle-collapse-toggle":t.handleCollapseToggle}})})),1)])]):t._e()],1)}),[],!1,null,"12d0ce54",null).exports);a.a.use(o.a);var E=new o.a({routes:[{path:"/",name:"HackerNewsTop",component:z},{path:"/best",name:"HackerNewsBest",component:z},{path:"/bookmark",name:"HackerNewsBookmarks",component:z},{path:"/post/:id",name:"HackerNewsPost",component:P,props:!0}]}),Y=e("XJYT"),I=e.n(Y),U=(e("D66Q"),e("RLBy"),e("D/Jt"));e("9Wh1"),window.Vue=e("XuX8"),Vue.component("main-navigation",e("Ubvr").default),Vue.use(I.a),Vue.use(U.a);new Vue({router:E,el:"#app"})},2:function(t,s,e){t.exports=e("1aZf")},"9Wh1":function(t,s,e){"use strict";e.r(s);var n=e("3CEA"),a=e("gtzJ");n.a({dsn:"https://50142ad267aa4c7c9dab6ed21262d2ab@sentry.io/1504143"}),window.axios=e("vDqi"),window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";var o=document.head.querySelector('meta[name="csrf-token"]');if(o)window.axios.defaults.headers.common["X-CSRF-TOKEN"]=o.content,window.axios.interceptors.response.use(null,(function(t){t.response?401!==t.response.status&&419!==t.response.status||window.location.replace("/login"):(a.b(t),console.error("Unknown error: ".concat(t)))}));else{var r="CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token";a.b(r),console.error(r)}},"DW/y":function(t,s,e){var n=e("SV0r");"string"==typeof n&&(n=[[t.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};e("aET+")(n,a);n.locals&&(t.exports=n.locals)},RLBy:function(t,s,e){"use strict";var n=e("XuX8"),a=e.n(n),o=e("wd/R"),r=e.n(o);a.a.filter("diffForHumans",(function(t){if(t)return r()(t,"YYYY-MM-DD hh:mm:ss").fromNow()})),a.a.filter("domainFromUrl",(function(t){if(t)return new URL(t).hostname.replace("www.","")}))},RnhZ:function(t,s,e){var n={"./af":"K/tc","./af.js":"K/tc","./ar":"jnO4","./ar-dz":"o1bE","./ar-dz.js":"o1bE","./ar-kw":"Qj4J","./ar-kw.js":"Qj4J","./ar-ly":"HP3h","./ar-ly.js":"HP3h","./ar-ma":"CoRJ","./ar-ma.js":"CoRJ","./ar-sa":"gjCT","./ar-sa.js":"gjCT","./ar-tn":"bYM6","./ar-tn.js":"bYM6","./ar.js":"jnO4","./az":"SFxW","./az.js":"SFxW","./be":"H8ED","./be.js":"H8ED","./bg":"hKrs","./bg.js":"hKrs","./bm":"p/rL","./bm.js":"p/rL","./bn":"kEOa","./bn.js":"kEOa","./bo":"0mo+","./bo.js":"0mo+","./br":"aIdf","./br.js":"aIdf","./bs":"JVSJ","./bs.js":"JVSJ","./ca":"1xZ4","./ca.js":"1xZ4","./cs":"PA2r","./cs.js":"PA2r","./cv":"A+xa","./cv.js":"A+xa","./cy":"l5ep","./cy.js":"l5ep","./da":"DxQv","./da.js":"DxQv","./de":"tGlX","./de-at":"s+uk","./de-at.js":"s+uk","./de-ch":"u3GI","./de-ch.js":"u3GI","./de.js":"tGlX","./dv":"WYrj","./dv.js":"WYrj","./el":"jUeY","./el.js":"jUeY","./en-au":"Dmvi","./en-au.js":"Dmvi","./en-ca":"OIYi","./en-ca.js":"OIYi","./en-gb":"Oaa7","./en-gb.js":"Oaa7","./en-ie":"4dOw","./en-ie.js":"4dOw","./en-il":"czMo","./en-il.js":"czMo","./en-in":"7C5Q","./en-in.js":"7C5Q","./en-nz":"b1Dy","./en-nz.js":"b1Dy","./en-sg":"t+mt","./en-sg.js":"t+mt","./eo":"Zduo","./eo.js":"Zduo","./es":"iYuL","./es-do":"CjzT","./es-do.js":"CjzT","./es-us":"Vclq","./es-us.js":"Vclq","./es.js":"iYuL","./et":"7BjC","./et.js":"7BjC","./eu":"D/JM","./eu.js":"D/JM","./fa":"jfSC","./fa.js":"jfSC","./fi":"gekB","./fi.js":"gekB","./fil":"1ppg","./fil.js":"1ppg","./fo":"ByF4","./fo.js":"ByF4","./fr":"nyYc","./fr-ca":"2fjn","./fr-ca.js":"2fjn","./fr-ch":"Dkky","./fr-ch.js":"Dkky","./fr.js":"nyYc","./fy":"cRix","./fy.js":"cRix","./ga":"USCx","./ga.js":"USCx","./gd":"9rRi","./gd.js":"9rRi","./gl":"iEDd","./gl.js":"iEDd","./gom-deva":"qvJo","./gom-deva.js":"qvJo","./gom-latn":"DKr+","./gom-latn.js":"DKr+","./gu":"4MV3","./gu.js":"4MV3","./he":"x6pH","./he.js":"x6pH","./hi":"3E1r","./hi.js":"3E1r","./hr":"S6ln","./hr.js":"S6ln","./hu":"WxRl","./hu.js":"WxRl","./hy-am":"1rYy","./hy-am.js":"1rYy","./id":"UDhR","./id.js":"UDhR","./is":"BVg3","./is.js":"BVg3","./it":"bpih","./it-ch":"bxKX","./it-ch.js":"bxKX","./it.js":"bpih","./ja":"B55N","./ja.js":"B55N","./jv":"tUCv","./jv.js":"tUCv","./ka":"IBtZ","./ka.js":"IBtZ","./kk":"bXm7","./kk.js":"bXm7","./km":"6B0Y","./km.js":"6B0Y","./kn":"PpIw","./kn.js":"PpIw","./ko":"Ivi+","./ko.js":"Ivi+","./ku":"JCF/","./ku.js":"JCF/","./ky":"lgnt","./ky.js":"lgnt","./lb":"RAwQ","./lb.js":"RAwQ","./lo":"sp3z","./lo.js":"sp3z","./lt":"JvlW","./lt.js":"JvlW","./lv":"uXwI","./lv.js":"uXwI","./me":"KTz0","./me.js":"KTz0","./mi":"aIsn","./mi.js":"aIsn","./mk":"aQkU","./mk.js":"aQkU","./ml":"AvvY","./ml.js":"AvvY","./mn":"lYtQ","./mn.js":"lYtQ","./mr":"Ob0Z","./mr.js":"Ob0Z","./ms":"6+QB","./ms-my":"ZAMP","./ms-my.js":"ZAMP","./ms.js":"6+QB","./mt":"G0Uy","./mt.js":"G0Uy","./my":"honF","./my.js":"honF","./nb":"bOMt","./nb.js":"bOMt","./ne":"OjkT","./ne.js":"OjkT","./nl":"+s0g","./nl-be":"2ykv","./nl-be.js":"2ykv","./nl.js":"+s0g","./nn":"uEye","./nn.js":"uEye","./oc-lnc":"Fnuy","./oc-lnc.js":"Fnuy","./pa-in":"8/+R","./pa-in.js":"8/+R","./pl":"jVdC","./pl.js":"jVdC","./pt":"8mBD","./pt-br":"0tRk","./pt-br.js":"0tRk","./pt.js":"8mBD","./ro":"lyxo","./ro.js":"lyxo","./ru":"lXzo","./ru.js":"lXzo","./sd":"Z4QM","./sd.js":"Z4QM","./se":"//9w","./se.js":"//9w","./si":"7aV9","./si.js":"7aV9","./sk":"e+ae","./sk.js":"e+ae","./sl":"gVVK","./sl.js":"gVVK","./sq":"yPMs","./sq.js":"yPMs","./sr":"zx6S","./sr-cyrl":"E+lV","./sr-cyrl.js":"E+lV","./sr.js":"zx6S","./ss":"Ur1D","./ss.js":"Ur1D","./sv":"X709","./sv.js":"X709","./sw":"dNwA","./sw.js":"dNwA","./ta":"PeUW","./ta.js":"PeUW","./te":"XLvN","./te.js":"XLvN","./tet":"V2x9","./tet.js":"V2x9","./tg":"Oxv6","./tg.js":"Oxv6","./th":"EOgW","./th.js":"EOgW","./tl-ph":"Dzi0","./tl-ph.js":"Dzi0","./tlh":"z3Vd","./tlh.js":"z3Vd","./tr":"DoHr","./tr.js":"DoHr","./tzl":"z1FC","./tzl.js":"z1FC","./tzm":"wQk9","./tzm-latn":"tT3J","./tzm-latn.js":"tT3J","./tzm.js":"wQk9","./ug-cn":"YRex","./ug-cn.js":"YRex","./uk":"raLr","./uk.js":"raLr","./ur":"UpQW","./ur.js":"UpQW","./uz":"Loxo","./uz-latn":"AQ68","./uz-latn.js":"AQ68","./uz.js":"Loxo","./vi":"KSF8","./vi.js":"KSF8","./x-pseudo":"/X5v","./x-pseudo.js":"/X5v","./yo":"fzPg","./yo.js":"fzPg","./zh-cn":"XDpg","./zh-cn.js":"XDpg","./zh-hk":"SatO","./zh-hk.js":"SatO","./zh-mo":"OmwH","./zh-mo.js":"OmwH","./zh-tw":"kOpN","./zh-tw.js":"kOpN"};function a(t){var s=o(t);return e(s)}function o(t){if(!e.o(n,t)){var s=new Error("Cannot find module '"+t+"'");throw s.code="MODULE_NOT_FOUND",s}return n[t]}a.keys=function(){return Object.keys(n)},a.resolve=o,t.exports=a,a.id="RnhZ"},SV0r:function(t,s,e){(t.exports=e("I1BE")(!1)).push([t.i,"\n.bookmark-story[data-v-12d0ce54] {\n  position: relative;\n  top: 2px;\n  text-decoration: none;\n}\n.loader-text[data-v-12d0ce54] {\n  background: #808080;\n  border-radius: 2px;\n}\n.loader-text--1x3[data-v-12d0ce54] {\n  width: 33%;\n}\n.loader-text--2x3[data-v-12d0ce54] {\n  width: 66%;\n}\n",""])},Ubvr:function(t,s,e){"use strict";e.r(s);var n=e("vDqi"),a=e.n(n),o={name:"MainNavigation",data:function(){return{menuCollapsed:!0,isNoteRoute:!1,isHackerNewsRoute:!1,isUsersRoute:!1,appRoutes:[]}},methods:{logout:function(t){t.preventDefault(),a.a.post("/logout",{}).then((function(){return window.location.href="/"}))}},created:function(){this.appRoutes=this.$router.options.routes.map((function(t){return t.name})),this.isNoteRoute=this.appRoutes.includes("Notes"),this.isHackerNewsRoute=this.appRoutes.includes("HackerNewsTop"),this.isUsersRoute=!this.isNoteRoute&&!this.isHackerNewsRoute}},r=e("KHd+"),i=Object(r.a)(o,(function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("nav",{staticClass:"navbar navbar-expand-md navbar-light navbar-laravel",attrs:{id:"main-navigation"}},[e("div",{staticClass:"container"},[e("a",{staticClass:"navbar-brand",attrs:{href:"/"}},[t._v("Zetetic Elench")]),t._v(" "),e("button",{staticClass:"navbar-toggler",attrs:{type:"button"},on:{click:function(s){t.menuCollapsed=!t.menuCollapsed}}},[e("span",{staticClass:"navbar-toggler-icon"})]),t._v(" "),e("div",{staticClass:"navbar-collapse",class:{collapse:t.menuCollapsed}},[e("ul",{staticClass:"navbar-nav mr-auto"},[e("li",{staticClass:"nav-item"},[e("a",{staticClass:"nav-link text-right text-sm-left",class:{"text-primary":t.isNoteRoute},attrs:{href:"/notes"}},[t._v("Notes")])]),t._v(" "),e("li",{staticClass:"nav-item"},[e("a",{staticClass:"nav-link text-right text-sm-left",class:{"text-primary":t.isHackerNewsRoute},attrs:{href:"/hn"}},[t._v("HackerNews")])]),t._v(" "),e("li",{staticClass:"nav-item"},[e("a",{staticClass:"nav-link text-right text-sm-left",class:{"text-primary":t.isUsersRoute},attrs:{href:"/users"}},[t._v("Users")])])]),t._v(" "),e("ul",{staticClass:"navbar-nav ml-auto"},[e("li",{staticClass:"nav-item"},[e("a",{staticClass:"nav-link text-right text-sm-left",attrs:{href:"#"},on:{click:function(s){return t.logout(s)}}},[t._v("Logout")])])])])])])}),[],!1,null,null,null);s.default=i.exports},XEtG:function(t,s,e){var n=e("iAxQ");"string"==typeof n&&(n=[[t.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};e("aET+")(n,a);n.locals&&(t.exports=n.locals)},YhZz:function(t,s,e){"use strict";var n=e("XEtG");e.n(n).a},iAxQ:function(t,s,e){(t.exports=e("I1BE")(!1)).push([t.i,"\n.bookmark-story[data-v-14c6dd0a] {\n  position: relative;\n  top: 2px;\n  text-decoration: none;\n}\n.loader-text[data-v-14c6dd0a] {\n  background: #808080;\n  border-radius: 2px;\n}\n.loader-text--1x3[data-v-14c6dd0a] {\n  width: 33%;\n}\n.loader-text-top[data-v-14c6dd0a] {\n  height: 22px;\n  margin-bottom: 6px;\n}\n.loader-text-bottom[data-v-14c6dd0a] {\n  height: 18px;\n}\n",""])},"ko/k":function(t,s,e){(t.exports=e("I1BE")(!1)).push([t.i,"\n.slide-enter-active[data-v-b53b4be6] {\n  transition-duration: 0.3s;\n  transition-timing-function: ease-in;\n}\n.slide-leave-active[data-v-b53b4be6] {\n  transition-duration: 0.3s;\n  transition-timing-function: cubic-bezier(0, 1, 0.5, 1);\n}\n.slide-enter-to[data-v-b53b4be6], .slide-leave[data-v-b53b4be6] {\n  max-height: 1000px;\n  overflow: hidden;\n}\n.slide-enter[data-v-b53b4be6], .slide-leave-to[data-v-b53b4be6] {\n  overflow: hidden;\n  max-height: 0;\n}\n.text-line-through[data-v-b53b4be6] {\n  text-decoration: line-through;\n}\n.btn-collapse[data-v-b53b4be6] {\n  width: 1.8rem;\n  padding-top: 2px;\n  padding-bottom: 2px;\n}\n.btn-collapse[data-v-b53b4be6]:hover {\n  color: #fff;\n}\n",""])},luwV:function(t,s,e){var n=e("ko/k");"string"==typeof n&&(n=[[t.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};e("aET+")(n,a);n.locals&&(t.exports=n.locals)},"u3+z":function(t,s,e){"use strict";var n=e("DW/y");e.n(n).a},zS51:function(t,s,e){"use strict";var n=e("luwV");e.n(n).a}},[[2,0,1]]]);