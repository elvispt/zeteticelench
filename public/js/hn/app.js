(window.webpackJsonp=window.webpackJsonp||[]).push([[3],{"/ztT":function(t,e,n){var s=n("SErk");"string"==typeof s&&(s=[[t.i,s,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};n("aET+")(s,a);s.locals&&(t.exports=s.locals)},"1aZf":function(t,e,n){"use strict";n.r(e);n("9Wh1");var s=n("XuX8"),a=n.n(s),o=n("jE9Z"),r=n("o0o1"),i=n.n(r),l={name:"Navigation",props:{numberOfBookmarks:{type:null|Number,required:!0}},methods:{activeSubmenu:function(t){return this.$route.name===t?"btn-primary":"btn-secondary"}}},c=n("KHd+"),u=Object(c.a)(l,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{attrs:{id:"navigation"}},[n("div",{staticClass:"row justify-content-center top-submenu"},[n("div",{staticClass:"col-12 no-gutter-xs"},[n("div",{staticClass:"btn-group d-flex mb-2"},[n("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsTop"),attrs:{to:"/"}},[t._v(t._s(t.$I18n.trans("hackernews.top")))]),t._v(" "),n("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsBest"),attrs:{to:"/best"}},[t._v(t._s(t.$I18n.trans("hackernews.best")))]),t._v(" "),n("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsBookmarks"),attrs:{to:"/bookmark"}},[t._v(t._s(t.$I18n.trans("hackernews.bookmarks"))+" "),n("span",{staticClass:"badge badge-light"},[t._v(t._s(t.numberOfBookmarks))])])],1)])])])}),[],!1,null,null,null).exports,m=n("vDqi"),d=n.n(m),p=n("yDJ3"),v=n.n(p);function f(t,e,n,s,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void n(t)}i.done?e(l):Promise.resolve(l).then(s,a)}var h={data:function(){return{nBookmarks:null,notification:null}},methods:{bookmarkPost:function(t){var e,n=this;return(e=i.a.mark((function e(){var s,a,o,r;return i.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.status.saving=!0,s={postId:t.id},(a=!t.status.bookmarked)||(s._method="delete"),e.next=6,d.a.post("/api/bookmarks",s);case 6:o=e.sent,(r=v()(o,"data.data.success",!1))&&(t.status.bookmarked=!t.status.bookmarked,n.nBookmarks+=a?1:-1),n.notifyUserOfBookmarkStatusChange(r,a,t);case 10:case"end":return e.stop()}}),e)})),function(){var t=this,n=arguments;return new Promise((function(s,a){var o=e.apply(t,n);function r(t){f(o,s,a,r,i,"next",t)}function i(t){f(o,s,a,r,i,"throw",t)}r(void 0)}))})()},notifyUserOfBookmarkStatusChange:function(t,e,n){var s={message:this.$I18n.trans("hackernews.add_failure"),type:"error"};t&&(s=e?{message:this.$I18n.trans("hackernews.added_to_bookmarks",{title:n.title}),type:"success"}:{message:this.$I18n.trans("hackernews.remove_from_bookmarks",{title:n.title}),type:"warning"}),this.notification&&!this.notification.closed&&this.notification.close(),this.notification=this.$message(s),setTimeout((function(){return n.status.saving=!1}),400)}}},k=n("Wcq6"),b=n.n(k),g=(n("Zs65"),b.a.initializeApp({databaseURL:"hacker-news.firebaseio.com"}).database().ref("/v0")),y=n("wd/R"),j=n.n(y);function x(t,e,n,s,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void n(t)}i.done?e(l):Promise.resolve(l).then(s,a)}function _(t){return function(t){if(Array.isArray(t))return C(t)}(t)||function(t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return C(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);"Object"===n&&t.constructor&&(n=t.constructor.name);if("Map"===n||"Set"===n)return Array.from(t);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return C(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function C(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,s=new Array(e);n<e;n++)s[n]=t[n];return s}var w={name:"HNPosts",mixins:[h],props:{idList:{type:Array,default:[],required:!0}},data:function(){return{loading:!0,posts:[],nBookmarks:null,firstBatchPosition:10}},methods:{fetchItems:function(t){var e=this,n=this.firstBatchPosition;t.length<n&&(n=Math.floor(t.length/2));var s=t.slice(0,n),a=t.slice(n);Promise.all(s.map((function(t){return e.fetchItem(t)}))).then((function(t){e.posts=t,e.attachBookmarked(),e.loading=!1})),this.$nextTick((function(){Promise.all(a.map((function(t){return e.fetchItem(t)}))).then((function(t){var n;(n=e.posts).push.apply(n,_(t)),e.attachBookmarked()}))}))},fetchItem:function(t){return new Promise((function(e,n){g.child("item/".concat(t)).on("value",(function(t){var n=t.val(),s={id:v()(n,"id"),title:v()(n,"title"),score:v()(n,"score"),time:j.a.unix(v()(n,"time",0)).format("YYYY-MM-DD HH:mm:ss"),url:v()(n,"url"),type:v()(n,"type"),nComments:v()(n,"descendants"),kids:v()(n,"kids",[]),status:{bookmarked:!1,saving:!1}};e(s)})),g.onDisconnect((function(t,e){this.$alert("Firebase connection lost","Lost connection",{confirmButtonText:"OK"}),console.log(t,e)}))}))},attachBookmarked:function(){var t,e=this;return(t=i.a.mark((function t(){var n,s;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,d.a.get("/api/bookmarks");case 2:n=t.sent,s=v()(n,"data.data",[]),e.nBookmarks=s.length,e.posts=e.posts.map((function(t){return t.status.bookmarked=s.includes(t.id),t}));case 6:case"end":return t.stop()}}),t)})),function(){var e=this,n=arguments;return new Promise((function(s,a){var o=t.apply(e,n);function r(t){x(o,s,a,r,i,"next",t)}function i(t){x(o,s,a,r,i,"throw",t)}r(void 0)}))})()}},watch:{idList:function(t,e){var n=this;this.loading=!0,setTimeout((function(){return n.fetchItems(t)}),400)},nBookmarks:function(t,e){this.$emit("nBookmarksChangedEvent",t)}}};n("QhOH");function O(t,e,n,s,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void n(t)}i.done?e(l):Promise.resolve(l).then(s,a)}var S={name:"HackerNews",components:{Navigation:u,HnPosts:Object(c.a)(w,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("ul",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"list-group",attrs:{id:"hn-posts"}},[t._l(Array(t.firstBatchPosition).fill(null),(function(e){return t.loading?n("li",{staticClass:"list-group-item list-group-item-action flex-column align-items-start"},[t._m(0,!0),t._v(" "),t._m(1,!0)]):t._e()})),t._v(" "),t._l(t.posts,(function(e,s){return n("li",{key:e.id,staticClass:"list-group-item list-group-item-action flex-column align-items-start",attrs:{"data-index":s+1}},[n("div",{staticClass:"d-flex w-100 justify-content-between"},[n("span",[n("router-link",{staticClass:"text-body",attrs:{to:"/post/"+e.id}},[t._v(t._s(e.title))]),t._v(" "),e.url?n("a",{staticClass:"text-body",attrs:{href:e.url,target:"_blank"}},[n("small",{staticClass:"text-muted"},[t._v("("+t._s(t._f("domainFromUrl")(e.url))+")")])]):t._e()],1),t._v(" "),n("span",{directives:[{name:"loading",rawName:"v-loading",value:e.status.saving,expression:"post.status.saving"}],staticClass:"d-block d-md-none"},[n("span",{staticClass:"bookmark-story pointer text-primary",on:{click:function(n){return t.bookmarkPost(e)}}},[t._v(t._s(e.status.bookmarked?"⚫":"⚪️")+"️")])]),t._v(" "),n("span",{staticClass:"badge d-none d-md-block",attrs:{title:e.time}},[t._v(t._s(t._f("diffForHumans")(e.time)))])]),t._v(" "),n("div",{directives:[{name:"loading",rawName:"v-loading",value:e.status.saving,expression:"post.status.saving"}],staticClass:"d-none d-md-block"},[n("small",{staticClass:"text-muted"},[t._v(t._s(t.$I18n.trans("hackernews.points",{points:e.score||""})))]),t._v("\n      |\n      "),n("small",[t._v(t._s(t.$I18n.trans("hackernews.comments",{comments:e.nComments||""})))]),t._v("\n      |\n      "),n("span",{staticClass:"bookmark-story pointer text-primary",on:{click:function(n){return t.bookmarkPost(e)}}},[t._v(t._s(e.status.bookmarked?"⚫":"⚪️"))])])])}))],2)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"d-flex w-100 justify-content-between"},[e("span",{staticClass:"loader-text loader-text-top d-block w-100"},[this._v(" ")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"d-none d-md-block"},[e("span",{staticClass:"loader-text loader-text-bottom loader-text--1x3 d-inline-block"},[e("small",[this._v(" ")])])])}],!1,null,"a147e218",null).exports},data:function(){return{idList:[],limit:100,routesMap:{HackerNewsTop:"top",HackerNewsBest:"best",HackerNewsBookmarks:"bookmarks"},numberOfBookmarks:null}},methods:{fetchStories:function(t){var e=v()(this.routesMap,t,"top");e===this.routesMap.HackerNewsBookmarks?this.fetchIdsBookmarkedFromBackend():this.fetchIdsFromFirebase(e)},fetchIdsFromFirebase:function(t){var e=this;g.child("".concat(t,"stories")).limitToFirst(this.limit).once("value",(function(t,n){var s=t.val();e.idList=Array.isArray(s)?s:[]}))},fetchIdsBookmarkedFromBackend:function(){var t,e=this;return(t=i.a.mark((function t(){var n;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,d.a.get("/api/bookmarks");case 2:n=t.sent,e.idList=v()(n,"data.data",[]);case 4:case"end":return t.stop()}}),t)})),function(){var e=this,n=arguments;return new Promise((function(s,a){var o=t.apply(e,n);function r(t){O(o,s,a,r,i,"next",t)}function i(t){O(o,s,a,r,i,"throw",t)}r(void 0)}))})()},updateNumberOfBookmarks:function(t){this.numberOfBookmarks=t}},created:function(){this.fetchStories(this.$route.name)},watch:{$route:function(t,e){this.fetchStories(t.name)}}},B=Object(c.a)(S,(function(){var t=this.$createElement,e=this._self._c||t;return e("div",{attrs:{id:"hacker-news"}},[e("navigation",{attrs:{"number-of-bookmarks":this.numberOfBookmarks}}),this._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-12 no-gutter-xs"},[e("hn-posts",{attrs:{"id-list":this.idList},on:{nBookmarksChangedEvent:this.updateNumberOfBookmarks}})],1)])],1)}),[],!1,null,null,null).exports,I={name:"HnComment",props:{comment:{type:Object,required:!0},handleCollapseToggle:{type:Function,required:!0}},data:function(){return{isShow:!0}}},z=(n("P9EP"),Object(c.a)(I,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"hn-comment card mt-3"},[n("div",{staticClass:"card-body px-2 px-md-3 shadow"},[n("h6",{staticClass:"card-subtitle bg-light text-muted d-flex justify-content-between align-items-center",class:{"opacity-5 text-line-through":t.comment.deleted}},[t.comment.id?n("span",{staticClass:"align-middle"},[t._v(t._s(t.$I18n.trans("hackernews.by",{by:t.comment.by||""})))]):t._e(),t._v(" "),n("small",{staticClass:"text-muted",attrs:{title:t.comment.time}},[t._v(t._s(t._f("diffForHumans")(t.comment.time)))]),t._v(" "),t.comment.id?n("a",{staticClass:"btn btn-sm pointer btn-collapse",attrs:{role:"button","data-toggle":"collapse"},on:{click:function(e){return t.handleCollapseToggle(t.comment)}}},[n("b",[t._v("["),t.comment.collapsed?n("span",[t._v(t._s(t.comment.kids.length))]):n("span",[t._v("-")]),t._v("]\n        ")])]):t._e()]),t._v(" "),n("transition",{attrs:{name:"slide"}},[t.comment.collapsed?t._e():n("div",{staticClass:"mt-2"},[n("p",{domProps:{innerHTML:t._s(t.comment.text)}}),t._v(" "),t._l(t.comment.comments,(function(e){return t.comment.comments.length?n("hn-comment",{key:e.id,attrs:{comment:e,"handle-collapse-toggle":t.handleCollapseToggle}}):t._e()}))],2)])],1)])}),[],!1,null,"1a92697e",null).exports),H=n("gtzJ");function N(t,e,n,s,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void n(t)}i.done?e(l):Promise.resolve(l).then(s,a)}var D={name:"HackerNewsPost",mixins:[h],components:{Navigation:u,HnComment:z},props:{id:{type:String,required:!0}},data:function(){return{loading:!0,loadingComments:!0,collapsedCommentsKey:"collapsedCommentsHackerNewsPost",collapsedComments:[],post:{id:null,by:null,title:null,text:null,score:null,time:null,url:null,type:null,nComments:null,status:{bookmarked:null,saving:null},kids:[],comments:[{id:null,by:null,kids:[],parent:null,text:null,time:null,comments:[]}]},numberOfBookmarks:null}},methods:{fetchPost:function(t){var e=this;t&&(this.fetchCollapsedComments(),g.child("item/".concat(t)).once("value",(function(t){var n=t.val();e.post.id=v()(n,"id"),e.post.by=v()(n,"by"),e.post.title=v()(n,"title"),e.post.text=v()(n,"text"),e.post.score=v()(n,"score"),e.post.time=j.a.unix(v()(n,"time",0)).format("YYYY-MM-DD HH:mm:ss"),e.post.url=v()(n,"url"),e.post.type=v()(n,"type"),e.post.nComments=v()(n,"descendants"),e.post.bookmarked=null,e.post.kids=v()(n,"kids",[]),e.post.comments=[],e.setBookmarkStatus(e.post),e.fetchComments(e.post),e.loading=!1})))},fetchComments:function(t){var e=this;t.kids.length&&t.kids.map((function(n){e.fetchComment(n).then((function(n){var s=v()(n,"kids",[]),a=v()(n,"id"),o={id:a,deleted:v()(n,"deleted"),by:v()(n,"by"),kids:s,text:v()(n,"text"),time:j.a.unix(v()(n,"time",0)).format("YYYY-MM-DD HH:mm:ss"),comments:[],collapsed:e.collapsedComments.includes(a)};e.fetchComments(o),t.comments.push(o),e.loadingComments=!1}))}))},fetchComment:function(t){return new Promise((function(e,n){g.child("item/".concat(t)).once("value",(function(t){var n=t.val();e(n)}))}))},setBookmarkStatus:function(t){var e,n=this;return(e=i.a.mark((function e(){var s,a;return i.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,d.a.get("/api/bookmarks");case 2:s=e.sent,a=v()(s,"data.data",[]),n.numberOfBookmarks=a.length,t.status.bookmarked=a.includes(t.id);case 6:case"end":return e.stop()}}),e)})),function(){var t=this,n=arguments;return new Promise((function(s,a){var o=e.apply(t,n);function r(t){N(o,s,a,r,i,"next",t)}function i(t){N(o,s,a,r,i,"throw",t)}r(void 0)}))})()},fetchCollapsedComments:function(){var t,e=localStorage.getItem(this.collapsedCommentsKey);try{t=JSON.parse(e)}catch(t){H.b(t)}t=Array.isArray(t)?t:[],this.collapsedComments=t},setCollapsedComments:function(){var t=JSON.stringify(this.collapsedComments);localStorage.setItem(this.collapsedCommentsKey,t)},handleCollapseToggle:function(t){t.collapsed=!t.collapsed,t.collapsed?this.collapsedComments.push(t.id):this.collapsedComments=this.collapsedComments.filter((function(e){return e!==t.id})),this.setCollapsedComments()}},created:function(){this.fetchPost(this.id)}},P=(n("Q0U0"),Object(c.a)(D,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{attrs:{id:"hacker-news-post"}},[n("navigation",{attrs:{"number-of-bookmarks":t.numberOfBookmarks}}),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-12 no-gutter-xs"},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[t.loading?n("p",{staticClass:"lead loader-text d-block loader-text--2x3"},[t._v(" ")]):t._e(),t._v(" "),t.post.title?n("p",{staticClass:"lead"},[t._v("\n          "+t._s(t.post.title)+"\n          "),t.post.url?n("a",{staticClass:"text-body",attrs:{href:t.post.url,target:"_blank"}},[n("small",{staticClass:"text-muted"},[t._v("("+t._s(t._f("domainFromUrl")(t.post.url))+") [↗]")])]):t._e()]):t._e(),t._v(" "),t.post.text?n("p",{domProps:{innerHTML:t._s(t.post.text)}}):t._e(),t._v(" "),t.loading?n("div",{staticClass:"loader-text d-block loader-text--1x3"},[t._v(" ")]):t._e(),t._v(" "),t.post.title?n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.post.status.saving,expression:"post.status.saving"}]},[n("small",{staticClass:"text-muted"},[t._v(t._s(t.$I18n.trans("hackernews.points",{points:t.post.score})))]),t._v(" "),n("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),n("small",{staticClass:"text-muted"},[t._v(t._s(t.$I18n.trans("hackernews.comments",{comments:t.post.nComments})))]),t._v(" "),n("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),n("small",{staticClass:"text-muted",attrs:{title:t.post.time}},[t._v(t._s(t._f("diffForHumans")(t.post.time)))]),t._v(" "),n("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),n("small",{staticClass:"text-muted"},[t._v(t._s(t.$I18n.trans("hackernews.by",{by:t.post.by})))]),t._v(" "),n("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),n("span",{staticClass:"bookmark-story pointer text-primary",on:{click:function(e){return t.bookmarkPost(t.post)}}},[t._v(t._s(t.post.status.bookmarked?"⚫":"⚪️")+"️")])]):t._e()])])]),t._v(" "),t.post.comments.length?n("div",{staticClass:"row"},[n("div",{staticClass:"col-12 no-gutter-xs"},[t.loadingComments?t._e():n("div",t._l(t.post.comments,(function(e){return n("hn-comment",{key:e.id,attrs:{comment:e,"handle-collapse-toggle":t.handleCollapseToggle}})})),1)])]):t._e()],1)}),[],!1,null,"bd575fd4",null).exports);a.a.use(o.a);var E=new o.a({routes:[{path:"/",name:"HackerNewsTop",component:B},{path:"/best",name:"HackerNewsBest",component:B},{path:"/bookmark",name:"HackerNewsBookmarks",component:B},{path:"/post/:id",name:"HackerNewsPost",component:P,props:!0}]}),R=n("XJYT"),U=n.n(R),Y=(n("D66Q"),n("RLBy"),n("D/Jt")),A=n("tSZF"),M=n("Ubvr");a.a.component("main-navigation",M.a),a.a.use(U.a),a.a.use(Y.a),a.a.prototype.$I18n=new A.a,new a.a({router:E,el:"#app"})},2:function(t,e,n){t.exports=n("1aZf")},"9Wh1":function(t,e,n){"use strict";var s=n("3CEA"),a=n("gtzJ"),o=n("vDqi"),r=n.n(o);s.a({dsn:"https://50142ad267aa4c7c9dab6ed21262d2ab@sentry.io/1504143"}),r.a.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";var i=document.head.querySelector('meta[name="csrf-token"]');if(i)r.a.defaults.headers.common["X-CSRF-TOKEN"]=i.content,r.a.interceptors.response.use(null,(function(t){t.response?401!==t.response.status&&419!==t.response.status||window.location.replace("/login"):(a.b(t),console.error("Unknown error: ".concat(t)))}));else{var l="CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token";a.b(l),console.error(l)}},J82J:function(t,e,n){(t.exports=n("I1BE")(!1)).push([t.i,"\n.slide-enter-active[data-v-1a92697e] {\n  transition-duration: 0.3s;\n  transition-timing-function: ease-in;\n}\n.slide-leave-active[data-v-1a92697e] {\n  transition-duration: 0.3s;\n  transition-timing-function: cubic-bezier(0, 1, 0.5, 1);\n}\n.slide-enter-to[data-v-1a92697e], .slide-leave[data-v-1a92697e] {\n  max-height: 1000px;\n  overflow: hidden;\n}\n.slide-enter[data-v-1a92697e], .slide-leave-to[data-v-1a92697e] {\n  overflow: hidden;\n  max-height: 0;\n}\n.text-line-through[data-v-1a92697e] {\n  text-decoration: line-through;\n}\n.btn-collapse[data-v-1a92697e] {\n  font-family: 'Inconsolata', monospace;\n  padding: 0;\n  height: 23px;\n}\n",""])},JOMe:function(t,e,n){var s=n("xK8D");"string"==typeof s&&(s=[[t.i,s,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};n("aET+")(s,a);s.locals&&(t.exports=s.locals)},P9EP:function(t,e,n){"use strict";var s=n("avtZ");n.n(s).a},Q0U0:function(t,e,n){"use strict";var s=n("JOMe");n.n(s).a},QhOH:function(t,e,n){"use strict";var s=n("/ztT");n.n(s).a},RLBy:function(t,e,n){"use strict";var s=n("XuX8"),a=n.n(s),o=n("wd/R"),r=n.n(o);a.a.filter("diffForHumans",(function(t){if(t)return r()(t,"YYYY-MM-DD hh:mm:ss").fromNow()})),a.a.filter("domainFromUrl",(function(t){if(t)return new URL(t).hostname.replace("www.","")}))},RnhZ:function(t,e,n){var s={"./af":"K/tc","./af.js":"K/tc","./ar":"jnO4","./ar-dz":"o1bE","./ar-dz.js":"o1bE","./ar-kw":"Qj4J","./ar-kw.js":"Qj4J","./ar-ly":"HP3h","./ar-ly.js":"HP3h","./ar-ma":"CoRJ","./ar-ma.js":"CoRJ","./ar-sa":"gjCT","./ar-sa.js":"gjCT","./ar-tn":"bYM6","./ar-tn.js":"bYM6","./ar.js":"jnO4","./az":"SFxW","./az.js":"SFxW","./be":"H8ED","./be.js":"H8ED","./bg":"hKrs","./bg.js":"hKrs","./bm":"p/rL","./bm.js":"p/rL","./bn":"kEOa","./bn.js":"kEOa","./bo":"0mo+","./bo.js":"0mo+","./br":"aIdf","./br.js":"aIdf","./bs":"JVSJ","./bs.js":"JVSJ","./ca":"1xZ4","./ca.js":"1xZ4","./cs":"PA2r","./cs.js":"PA2r","./cv":"A+xa","./cv.js":"A+xa","./cy":"l5ep","./cy.js":"l5ep","./da":"DxQv","./da.js":"DxQv","./de":"tGlX","./de-at":"s+uk","./de-at.js":"s+uk","./de-ch":"u3GI","./de-ch.js":"u3GI","./de.js":"tGlX","./dv":"WYrj","./dv.js":"WYrj","./el":"jUeY","./el.js":"jUeY","./en-au":"Dmvi","./en-au.js":"Dmvi","./en-ca":"OIYi","./en-ca.js":"OIYi","./en-gb":"Oaa7","./en-gb.js":"Oaa7","./en-ie":"4dOw","./en-ie.js":"4dOw","./en-il":"czMo","./en-il.js":"czMo","./en-in":"7C5Q","./en-in.js":"7C5Q","./en-nz":"b1Dy","./en-nz.js":"b1Dy","./en-sg":"t+mt","./en-sg.js":"t+mt","./eo":"Zduo","./eo.js":"Zduo","./es":"iYuL","./es-do":"CjzT","./es-do.js":"CjzT","./es-us":"Vclq","./es-us.js":"Vclq","./es.js":"iYuL","./et":"7BjC","./et.js":"7BjC","./eu":"D/JM","./eu.js":"D/JM","./fa":"jfSC","./fa.js":"jfSC","./fi":"gekB","./fi.js":"gekB","./fil":"1ppg","./fil.js":"1ppg","./fo":"ByF4","./fo.js":"ByF4","./fr":"nyYc","./fr-ca":"2fjn","./fr-ca.js":"2fjn","./fr-ch":"Dkky","./fr-ch.js":"Dkky","./fr.js":"nyYc","./fy":"cRix","./fy.js":"cRix","./ga":"USCx","./ga.js":"USCx","./gd":"9rRi","./gd.js":"9rRi","./gl":"iEDd","./gl.js":"iEDd","./gom-deva":"qvJo","./gom-deva.js":"qvJo","./gom-latn":"DKr+","./gom-latn.js":"DKr+","./gu":"4MV3","./gu.js":"4MV3","./he":"x6pH","./he.js":"x6pH","./hi":"3E1r","./hi.js":"3E1r","./hr":"S6ln","./hr.js":"S6ln","./hu":"WxRl","./hu.js":"WxRl","./hy-am":"1rYy","./hy-am.js":"1rYy","./id":"UDhR","./id.js":"UDhR","./is":"BVg3","./is.js":"BVg3","./it":"bpih","./it-ch":"bxKX","./it-ch.js":"bxKX","./it.js":"bpih","./ja":"B55N","./ja.js":"B55N","./jv":"tUCv","./jv.js":"tUCv","./ka":"IBtZ","./ka.js":"IBtZ","./kk":"bXm7","./kk.js":"bXm7","./km":"6B0Y","./km.js":"6B0Y","./kn":"PpIw","./kn.js":"PpIw","./ko":"Ivi+","./ko.js":"Ivi+","./ku":"JCF/","./ku.js":"JCF/","./ky":"lgnt","./ky.js":"lgnt","./lb":"RAwQ","./lb.js":"RAwQ","./lo":"sp3z","./lo.js":"sp3z","./lt":"JvlW","./lt.js":"JvlW","./lv":"uXwI","./lv.js":"uXwI","./me":"KTz0","./me.js":"KTz0","./mi":"aIsn","./mi.js":"aIsn","./mk":"aQkU","./mk.js":"aQkU","./ml":"AvvY","./ml.js":"AvvY","./mn":"lYtQ","./mn.js":"lYtQ","./mr":"Ob0Z","./mr.js":"Ob0Z","./ms":"6+QB","./ms-my":"ZAMP","./ms-my.js":"ZAMP","./ms.js":"6+QB","./mt":"G0Uy","./mt.js":"G0Uy","./my":"honF","./my.js":"honF","./nb":"bOMt","./nb.js":"bOMt","./ne":"OjkT","./ne.js":"OjkT","./nl":"+s0g","./nl-be":"2ykv","./nl-be.js":"2ykv","./nl.js":"+s0g","./nn":"uEye","./nn.js":"uEye","./oc-lnc":"Fnuy","./oc-lnc.js":"Fnuy","./pa-in":"8/+R","./pa-in.js":"8/+R","./pl":"jVdC","./pl.js":"jVdC","./pt":"8mBD","./pt-br":"0tRk","./pt-br.js":"0tRk","./pt.js":"8mBD","./ro":"lyxo","./ro.js":"lyxo","./ru":"lXzo","./ru.js":"lXzo","./sd":"Z4QM","./sd.js":"Z4QM","./se":"//9w","./se.js":"//9w","./si":"7aV9","./si.js":"7aV9","./sk":"e+ae","./sk.js":"e+ae","./sl":"gVVK","./sl.js":"gVVK","./sq":"yPMs","./sq.js":"yPMs","./sr":"zx6S","./sr-cyrl":"E+lV","./sr-cyrl.js":"E+lV","./sr.js":"zx6S","./ss":"Ur1D","./ss.js":"Ur1D","./sv":"X709","./sv.js":"X709","./sw":"dNwA","./sw.js":"dNwA","./ta":"PeUW","./ta.js":"PeUW","./te":"XLvN","./te.js":"XLvN","./tet":"V2x9","./tet.js":"V2x9","./tg":"Oxv6","./tg.js":"Oxv6","./th":"EOgW","./th.js":"EOgW","./tl-ph":"Dzi0","./tl-ph.js":"Dzi0","./tlh":"z3Vd","./tlh.js":"z3Vd","./tr":"DoHr","./tr.js":"DoHr","./tzl":"z1FC","./tzl.js":"z1FC","./tzm":"wQk9","./tzm-latn":"tT3J","./tzm-latn.js":"tT3J","./tzm.js":"wQk9","./ug-cn":"YRex","./ug-cn.js":"YRex","./uk":"raLr","./uk.js":"raLr","./ur":"UpQW","./ur.js":"UpQW","./uz":"Loxo","./uz-latn":"AQ68","./uz-latn.js":"AQ68","./uz.js":"Loxo","./vi":"KSF8","./vi.js":"KSF8","./x-pseudo":"/X5v","./x-pseudo.js":"/X5v","./yo":"fzPg","./yo.js":"fzPg","./zh-cn":"XDpg","./zh-cn.js":"XDpg","./zh-hk":"SatO","./zh-hk.js":"SatO","./zh-mo":"OmwH","./zh-mo.js":"OmwH","./zh-tw":"kOpN","./zh-tw.js":"kOpN"};function a(t){var e=o(t);return n(e)}function o(t){if(!n.o(s,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return s[t]}a.keys=function(){return Object.keys(s)},a.resolve=o,t.exports=a,a.id="RnhZ"},SErk:function(t,e,n){(t.exports=n("I1BE")(!1)).push([t.i,"\n.bookmark-story[data-v-a147e218] {\n  position: relative;\n  top: 2px;\n  text-decoration: none;\n}\n.loader-text[data-v-a147e218] {\n  background: #808080;\n  border-radius: 2px;\n}\n.loader-text--1x3[data-v-a147e218] {\n  width: 33%;\n}\n.loader-text-top[data-v-a147e218] {\n  height: 22px;\n  margin-bottom: 6px;\n}\n.loader-text-bottom[data-v-a147e218] {\n  height: 18px;\n}\n",""])},Ubvr:function(t,e,n){"use strict";var s=n("vDqi"),a=n.n(s),o={name:"MainNavigation",props:{route:{type:String,required:!1}},data:function(){return{menuCollapsed:!0,isNoteRoute:!1,isHackerNewsRoute:!1,isUsersRoute:!1,appRoutes:[]}},methods:{logout:function(t){t.preventDefault(),a.a.post("/logout",{}).then((function(){return window.location.href="/"}))}},created:function(){this.$router?(this.appRoutes=this.$router.options.routes.map((function(t){return t.name})),this.isNoteRoute=this.appRoutes.includes("Notes"),this.isHackerNewsRoute=this.appRoutes.includes("HackerNewsTop")):this.isUsersRoute="users"===this.route}},r=n("KHd+"),i=Object(r.a)(o,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("nav",{staticClass:"navbar navbar-expand-md navbar-light navbar-laravel",attrs:{id:"main-navigation"}},[n("div",{staticClass:"container"},[n("a",{staticClass:"navbar-brand",attrs:{href:"/"}},[t._v("Zetetic Elench")]),t._v(" "),n("button",{staticClass:"navbar-toggler",attrs:{type:"button"},on:{click:function(e){t.menuCollapsed=!t.menuCollapsed}}},[n("span",{staticClass:"navbar-toggler-icon"})]),t._v(" "),n("div",{staticClass:"navbar-collapse",class:{collapse:t.menuCollapsed}},[n("ul",{staticClass:"navbar-nav mr-auto"},[n("li",{staticClass:"nav-item"},[n("a",{staticClass:"nav-link text-right text-sm-left",class:{"text-primary":t.isNoteRoute},attrs:{href:"/notes"}},[t._v(t._s(t.$I18n.trans("notes.notes")))])]),t._v(" "),n("li",{staticClass:"nav-item"},[n("a",{staticClass:"nav-link text-right text-sm-left",class:{"text-primary":t.isHackerNewsRoute},attrs:{href:"/hn"}},[t._v(t._s(t.$I18n.trans("hackernews.hackernews")))])]),t._v(" "),n("li",{staticClass:"nav-item"},[n("a",{staticClass:"nav-link text-right text-sm-left",class:{"text-primary":t.isUsersRoute},attrs:{href:"/users"}},[t._v(t._s(t.$I18n.trans("users.users")))])])]),t._v(" "),n("ul",{staticClass:"navbar-nav ml-auto"},[n("li",{staticClass:"nav-item"},[n("a",{staticClass:"nav-link text-right text-sm-left",attrs:{href:"#"},on:{click:function(e){return t.logout(e)}}},[t._v(t._s(t.$I18n.trans("users.logout")))])])])])])])}),[],!1,null,null,null);e.a=i.exports},avtZ:function(t,e,n){var s=n("J82J");"string"==typeof s&&(s=[[t.i,s,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};n("aET+")(s,a);s.locals&&(t.exports=s.locals)},tSZF:function(t,e,n){"use strict";function s(t){return(s="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function a(t,e){return function(t){if(Array.isArray(t))return t}(t)||function(t,e){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var n=[],s=!0,a=!1,o=void 0;try{for(var r,i=t[Symbol.iterator]();!(s=(r=i.next()).done)&&(n.push(r.value),!e||n.length!==e);s=!0);}catch(t){a=!0,o=t}finally{try{s||null==i.return||i.return()}finally{if(a)throw o}}return n}(t,e)||function(t,e){if(!t)return;if("string"==typeof t)return o(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);"Object"===n&&t.constructor&&(n=t.constructor.name);if("Map"===n||"Set"===n)return Array.from(t);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return o(t,e)}(t,e)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function o(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,s=new Array(e);n<e;n++)s[n]=t[n];return s}function r(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function i(t,e){for(var n=0;n<e.length;n++){var s=e[n];s.enumerable=s.enumerable||!1,s.configurable=!0,"value"in s&&(s.writable=!0),Object.defineProperty(t,s.key,s)}}n.d(e,"a",(function(){return l}));var l=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"translations";r(this,t),this.key=e}var e,n,o;return e=t,(n=[{key:"trans",value:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return this._replace(this._extract(t),e)}},{key:"trans_choice",value:function(t){var e,n=this,s=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1,a=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{},o=this._extract(t,"|").split("|");return o.some((function(t){return e=n._match(t,s)})),e=(e=e||(s>1?o[1]:o[0])).replace(/\[.*?\]|\{.*?\}/,""),this._replace(e,a)}},{key:"_match",value:function(t,e){var n=t.match(/^[\{\[]([^\[\]\{\}]*)[\}\]](.*)/);if(n){if(n[1].includes(",")){var s=a(n[1].split(",",2),2),o=s[0],r=s[1];if("*"===r&&e>=o)return n[2];if("*"===o&&e<=r)return n[2];if(e>=o&&e<=r)return n[2]}return n[1]==e?n[2]:null}}},{key:"_replace",value:function(t,e){if("object"===s(t))return t;for(var n in e)t=t.toString().replace(":".concat(n),e[n]).replace(":".concat(n.toUpperCase()),e[n].toString().toUpperCase()).replace(":".concat(n.charAt(0).toUpperCase()).concat(n.slice(1)),e[n].toString().charAt(0).toUpperCase()+e[n].toString().slice(1));return t.toString().trim()}},{key:"_extract",value:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,n=t.toString().split("::"),s=n.pop().toString().split(".");return n.length>0&&(n[0]+="::"),n.concat(s).reduce((function(n,s){return n[s]||e||t}),window[this.key])}}])&&i(e.prototype,n),o&&i(e,o),t}()},xK8D:function(t,e,n){(t.exports=n("I1BE")(!1)).push([t.i,"\n.bookmark-story[data-v-bd575fd4] {\n  position: relative;\n  top: 2px;\n  text-decoration: none;\n}\n.loader-text[data-v-bd575fd4] {\n  background: #808080;\n  border-radius: 2px;\n}\n.loader-text--1x3[data-v-bd575fd4] {\n  width: 33%;\n}\n.loader-text--2x3[data-v-bd575fd4] {\n  width: 66%;\n}\n",""])}},[[2,0,1]]]);