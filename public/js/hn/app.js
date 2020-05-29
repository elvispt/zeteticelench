(window.webpackJsonp=window.webpackJsonp||[]).push([[3],{"/ztT":function(t,e,s){var n=s("SErk");"string"==typeof n&&(n=[[t.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};s("aET+")(n,a);n.locals&&(t.exports=n.locals)},"1aZf":function(t,e,s){"use strict";s.r(e);s("9Wh1");var n=s("XuX8"),a=s.n(n),o=s("jE9Z"),r=s("o0o1"),i=s.n(r),l={name:"Navigation",props:{numberOfBookmarks:{type:null|Number,required:!0}},methods:{activeSubmenu:function(t){return this.$route.name===t?"btn-primary":"btn-secondary"}}},c=s("KHd+"),u=Object(c.a)(l,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{attrs:{id:"navigation"}},[s("div",{staticClass:"row justify-content-center top-submenu"},[s("div",{staticClass:"col-12 no-gutter-xs"},[s("div",{staticClass:"btn-group d-flex mb-2"},[s("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsTop"),attrs:{to:"/"}},[t._v(t._s(t.$I18n.trans("hackernews.top")))]),t._v(" "),s("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsBest"),attrs:{to:"/best"}},[t._v(t._s(t.$I18n.trans("hackernews.best")))]),t._v(" "),s("router-link",{staticClass:"btn btn-group-sm w-100",class:t.activeSubmenu("HackerNewsBookmarks"),attrs:{to:"/bookmark"}},[t._v(t._s(t.$I18n.trans("hackernews.bookmarks"))+" "),s("span",{staticClass:"badge badge-light"},[t._v(t._s(t.numberOfBookmarks))])])],1)])])])}),[],!1,null,null,null).exports,m=s("vDqi"),d=s.n(m),p=s("yDJ3"),v=s.n(p);function f(t,e,s,n,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void s(t)}i.done?e(l):Promise.resolve(l).then(n,a)}var h={data:function(){return{nBookmarks:null,notification:null}},methods:{bookmarkPost:function(t){var e,s=this;return(e=i.a.mark((function e(){var n,a,o,r;return i.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.status.saving=!0,n={postId:t.id},(a=!t.status.bookmarked)||(n._method="delete"),e.next=6,d.a.post("/api/bookmarks",n);case 6:o=e.sent,(r=v()(o,"data.data.success",!1))&&(t.status.bookmarked=!t.status.bookmarked,s.nBookmarks+=a?1:-1),s.notifyUserOfBookmarkStatusChange(r,a,t);case 10:case"end":return e.stop()}}),e)})),function(){var t=this,s=arguments;return new Promise((function(n,a){var o=e.apply(t,s);function r(t){f(o,n,a,r,i,"next",t)}function i(t){f(o,n,a,r,i,"throw",t)}r(void 0)}))})()},notifyUserOfBookmarkStatusChange:function(t,e,s){var n={message:this.$I18n.trans("hackernews.add_failure"),type:"error"};t&&(n=e?{message:this.$I18n.trans("hackernews.added_to_bookmarks",{title:s.title}),type:"success"}:{message:this.$I18n.trans("hackernews.remove_from_bookmarks",{title:s.title}),type:"warning"}),this.notification&&!this.notification.closed&&this.notification.close(),this.notification=this.$message(n),setTimeout((function(){return s.status.saving=!1}),400)}}},k=s("Wcq6"),b=s.n(k),g=(s("Zs65"),b.a.initializeApp({databaseURL:"hacker-news.firebaseio.com"}).database().ref("/v0")),y=s("wd/R"),j=s.n(y);function x(t,e,s,n,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void s(t)}i.done?e(l):Promise.resolve(l).then(n,a)}function _(t){return function(t){if(Array.isArray(t))return C(t)}(t)||function(t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return C(t,e);var s=Object.prototype.toString.call(t).slice(8,-1);"Object"===s&&t.constructor&&(s=t.constructor.name);if("Map"===s||"Set"===s)return Array.from(t);if("Arguments"===s||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(s))return C(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function C(t,e){(null==e||e>t.length)&&(e=t.length);for(var s=0,n=new Array(e);s<e;s++)n[s]=t[s];return n}var w={name:"HNPosts",mixins:[h],props:{idList:{type:Array,default:[],required:!0}},data:function(){return{loading:!0,posts:[],nBookmarks:null,firstBatchPosition:10}},methods:{fetchItems:function(t){var e=this,s=this.firstBatchPosition;t.length<s&&(s=Math.floor(t.length/2));var n=t.slice(0,s),a=t.slice(s);Promise.all(n.map((function(t){return e.fetchItem(t)}))).then((function(t){e.posts=t,e.attachBookmarked(),e.loading=!1})),this.$nextTick((function(){Promise.all(a.map((function(t){return e.fetchItem(t)}))).then((function(t){var s;(s=e.posts).push.apply(s,_(t)),e.attachBookmarked()}))}))},fetchItem:function(t){return new Promise((function(e,s){g.child("item/".concat(t)).on("value",(function(t){var s=t.val(),n={id:v()(s,"id"),title:v()(s,"title"),score:v()(s,"score"),time:j.a.unix(v()(s,"time",0)).format("YYYY-MM-DD HH:mm:ss"),url:v()(s,"url"),type:v()(s,"type"),nComments:v()(s,"descendants"),kids:v()(s,"kids",[]),status:{bookmarked:!1,saving:!1}};e(n)})),g.onDisconnect((function(t,e){this.$alert("Firebase connection lost","Lost connection",{confirmButtonText:"OK"}),console.log(t,e)}))}))},attachBookmarked:function(){var t,e=this;return(t=i.a.mark((function t(){var s,n;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,d.a.get("/api/bookmarks");case 2:s=t.sent,n=v()(s,"data.data",[]),e.nBookmarks=n.length,e.posts=e.posts.map((function(t){return t.status.bookmarked=n.includes(t.id),t}));case 6:case"end":return t.stop()}}),t)})),function(){var e=this,s=arguments;return new Promise((function(n,a){var o=t.apply(e,s);function r(t){x(o,n,a,r,i,"next",t)}function i(t){x(o,n,a,r,i,"throw",t)}r(void 0)}))})()}},watch:{idList:function(t,e){var s=this;this.loading=!0,setTimeout((function(){return s.fetchItems(t)}),400)},nBookmarks:function(t,e){this.$emit("nBookmarksChangedEvent",t)}}};s("QhOH");function O(t,e,s,n,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void s(t)}i.done?e(l):Promise.resolve(l).then(n,a)}var S={name:"HackerNews",components:{Navigation:u,HnPosts:Object(c.a)(w,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("ul",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"list-group",attrs:{id:"hn-posts"}},[t._l(Array(t.firstBatchPosition).fill(null),(function(e){return t.loading?s("li",{staticClass:"list-group-item list-group-item-action flex-column align-items-start"},[t._m(0,!0),t._v(" "),t._m(1,!0)]):t._e()})),t._v(" "),t._l(t.posts,(function(e,n){return s("li",{key:e.id,staticClass:"list-group-item list-group-item-action flex-column align-items-start",attrs:{"data-index":n+1}},[s("div",{staticClass:"d-flex w-100 justify-content-between"},[s("span",[s("router-link",{staticClass:"text-body",attrs:{to:"/post/"+e.id}},[t._v(t._s(e.title))]),t._v(" "),e.url?s("a",{staticClass:"text-body",attrs:{href:e.url,target:"_blank"}},[s("small",{staticClass:"text-muted"},[t._v("("+t._s(t._f("domainFromUrl")(e.url))+")")])]):t._e()],1),t._v(" "),s("span",{directives:[{name:"loading",rawName:"v-loading",value:e.status.saving,expression:"post.status.saving"}],staticClass:"d-block d-md-none"},[s("span",{staticClass:"bookmark-story pointer text-primary",on:{click:function(s){return t.bookmarkPost(e)}}},[t._v(t._s(e.status.bookmarked?"⚫":"⚪️")+"️")])]),t._v(" "),s("span",{staticClass:"badge d-none d-md-block",attrs:{title:e.time}},[t._v(t._s(t._f("diffForHumans")(e.time)))])]),t._v(" "),s("div",{directives:[{name:"loading",rawName:"v-loading",value:e.status.saving,expression:"post.status.saving"}],staticClass:"d-none d-md-block"},[s("small",{staticClass:"text-muted"},[t._v(t._s(t.$I18n.trans("hackernews.points",{points:e.score||""})))]),t._v("\n      |\n      "),s("small",[t._v(t._s(t.$I18n.trans("hackernews.comments",{comments:e.nComments||""})))]),t._v("\n      |\n      "),s("span",{staticClass:"bookmark-story pointer text-primary",on:{click:function(s){return t.bookmarkPost(e)}}},[t._v(t._s(e.status.bookmarked?"⚫":"⚪️"))])])])}))],2)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"d-flex w-100 justify-content-between"},[e("span",{staticClass:"loader-text loader-text-top d-block w-100"},[this._v(" ")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"d-none d-md-block"},[e("span",{staticClass:"loader-text loader-text-bottom loader-text--1x3 d-inline-block"},[e("small",[this._v(" ")])])])}],!1,null,"a147e218",null).exports},data:function(){return{idList:[],limit:100,routesMap:{HackerNewsTop:"top",HackerNewsBest:"best",HackerNewsBookmarks:"bookmarks"},numberOfBookmarks:null}},methods:{fetchStories:function(t){var e=v()(this.routesMap,t,"top");e===this.routesMap.HackerNewsBookmarks?this.fetchIdsBookmarkedFromBackend():this.fetchIdsFromFirebase(e)},fetchIdsFromFirebase:function(t){var e=this;g.child("".concat(t,"stories")).limitToFirst(this.limit).once("value",(function(t,s){var n=t.val();e.idList=Array.isArray(n)?n:[]}))},fetchIdsBookmarkedFromBackend:function(){var t,e=this;return(t=i.a.mark((function t(){var s;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,d.a.get("/api/bookmarks");case 2:s=t.sent,e.idList=v()(s,"data.data",[]);case 4:case"end":return t.stop()}}),t)})),function(){var e=this,s=arguments;return new Promise((function(n,a){var o=t.apply(e,s);function r(t){O(o,n,a,r,i,"next",t)}function i(t){O(o,n,a,r,i,"throw",t)}r(void 0)}))})()},updateNumberOfBookmarks:function(t){this.numberOfBookmarks=t}},created:function(){this.fetchStories(this.$route.name)},watch:{$route:function(t,e){this.fetchStories(t.name)}}},B=Object(c.a)(S,(function(){var t=this.$createElement,e=this._self._c||t;return e("div",{attrs:{id:"hacker-news"}},[e("navigation",{attrs:{"number-of-bookmarks":this.numberOfBookmarks}}),this._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-12 no-gutter-xs"},[e("hn-posts",{attrs:{"id-list":this.idList},on:{nBookmarksChangedEvent:this.updateNumberOfBookmarks}})],1)])],1)}),[],!1,null,null,null).exports,I={name:"HnComment",props:{comment:{type:Object,required:!0},handleCollapseToggle:{type:Function,required:!0}},data:function(){return{isShow:!0}}},z=(s("P9EP"),Object(c.a)(I,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"hn-comment card mt-3"},[s("div",{staticClass:"card-body px-2 px-md-3 shadow"},[s("h6",{staticClass:"card-subtitle bg-light text-muted d-flex justify-content-between align-items-center",class:{"opacity-5 text-line-through":t.comment.deleted}},[t.comment.id?s("span",{staticClass:"align-middle"},[t._v(t._s(t.$I18n.trans("hackernews.by",{by:t.comment.by||""})))]):t._e(),t._v(" "),s("small",{staticClass:"text-muted",attrs:{title:t.comment.time}},[t._v(t._s(t._f("diffForHumans")(t.comment.time)))]),t._v(" "),t.comment.id?s("a",{staticClass:"btn btn-sm pointer btn-collapse",attrs:{role:"button","data-toggle":"collapse"},on:{click:function(e){return t.handleCollapseToggle(t.comment)}}},[s("b",[t._v("["),t.comment.collapsed?s("span",[t._v(t._s(t.comment.kids.length))]):s("span",[t._v("-")]),t._v("]\n        ")])]):t._e()]),t._v(" "),s("transition",{attrs:{name:"slide"}},[t.comment.collapsed?t._e():s("div",{staticClass:"mt-2"},[s("p",{domProps:{innerHTML:t._s(t.comment.text)}}),t._v(" "),t._l(t.comment.comments,(function(e){return t.comment.comments.length?s("hn-comment",{key:e.id,attrs:{comment:e,"handle-collapse-toggle":t.handleCollapseToggle}}):t._e()}))],2)])],1)])}),[],!1,null,"1a92697e",null).exports),H=s("gtzJ");function N(t,e,s,n,a,o,r){try{var i=t[o](r),l=i.value}catch(t){return void s(t)}i.done?e(l):Promise.resolve(l).then(n,a)}var D={name:"HackerNewsPost",mixins:[h],components:{Navigation:u,HnComment:z},props:{id:{type:String,required:!0}},data:function(){return{loading:!0,loadingComments:!0,collapsedCommentsKey:"collapsedCommentsHackerNewsPost",collapsedComments:[],post:{id:null,by:null,title:null,text:null,score:null,time:null,url:null,type:null,nComments:null,status:{bookmarked:null,saving:null},kids:[],comments:[{id:null,by:null,kids:[],parent:null,text:null,time:null,comments:[]}]},numberOfBookmarks:null}},methods:{fetchPost:function(t){var e=this;t&&(this.fetchCollapsedComments(),g.child("item/".concat(t)).once("value",(function(t){var s=t.val();e.post.id=v()(s,"id"),e.post.by=v()(s,"by"),e.post.title=v()(s,"title"),e.post.text=v()(s,"text"),e.post.score=v()(s,"score"),e.post.time=j.a.unix(v()(s,"time",0)).format("YYYY-MM-DD HH:mm:ss"),e.post.url=v()(s,"url"),e.post.type=v()(s,"type"),e.post.nComments=v()(s,"descendants"),e.post.bookmarked=null,e.post.kids=v()(s,"kids",[]),e.post.comments=[],e.setBookmarkStatus(e.post),e.fetchComments(e.post),e.loading=!1})))},fetchComments:function(t){var e=this;t.kids.length&&t.kids.map((function(s){e.fetchComment(s).then((function(s){var n=v()(s,"kids",[]),a=v()(s,"id"),o={id:a,deleted:v()(s,"deleted"),by:v()(s,"by"),kids:n,text:v()(s,"text"),time:j.a.unix(v()(s,"time",0)).format("YYYY-MM-DD HH:mm:ss"),comments:[],collapsed:e.collapsedComments.includes(a)};e.fetchComments(o),t.comments.push(o),e.loadingComments=!1}))}))},fetchComment:function(t){return new Promise((function(e,s){g.child("item/".concat(t)).once("value",(function(t){var s=t.val();e(s)}))}))},setBookmarkStatus:function(t){var e,s=this;return(e=i.a.mark((function e(){var n,a;return i.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,d.a.get("/api/bookmarks");case 2:n=e.sent,a=v()(n,"data.data",[]),s.numberOfBookmarks=a.length,t.status.bookmarked=a.includes(t.id);case 6:case"end":return e.stop()}}),e)})),function(){var t=this,s=arguments;return new Promise((function(n,a){var o=e.apply(t,s);function r(t){N(o,n,a,r,i,"next",t)}function i(t){N(o,n,a,r,i,"throw",t)}r(void 0)}))})()},fetchCollapsedComments:function(){var t,e=localStorage.getItem(this.collapsedCommentsKey);try{t=JSON.parse(e)}catch(t){H.b(t)}t=Array.isArray(t)?t:[],this.collapsedComments=t},setCollapsedComments:function(){var t=JSON.stringify(this.collapsedComments);localStorage.setItem(this.collapsedCommentsKey,t)},handleCollapseToggle:function(t){t.collapsed=!t.collapsed,t.collapsed?this.collapsedComments.push(t.id):this.collapsedComments=this.collapsedComments.filter((function(e){return e!==t.id})),this.setCollapsedComments()}},created:function(){this.fetchPost(this.id)}},P=(s("Q0U0"),Object(c.a)(D,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{attrs:{id:"hacker-news-post"}},[s("navigation",{attrs:{"number-of-bookmarks":t.numberOfBookmarks}}),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-12 no-gutter-xs"},[s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[t.loading?s("p",{staticClass:"lead loader-text d-block loader-text--2x3"},[t._v(" ")]):t._e(),t._v(" "),t.post.title?s("p",{staticClass:"lead"},[t._v("\n          "+t._s(t.post.title)+"\n          "),t.post.url?s("a",{staticClass:"text-body",attrs:{href:t.post.url,target:"_blank"}},[s("small",{staticClass:"text-muted"},[t._v("("+t._s(t._f("domainFromUrl")(t.post.url))+") [↗]")])]):t._e()]):t._e(),t._v(" "),t.post.text?s("p",{domProps:{innerHTML:t._s(t.post.text)}}):t._e(),t._v(" "),t.loading?s("div",{staticClass:"loader-text d-block loader-text--1x3"},[t._v(" ")]):t._e(),t._v(" "),t.post.title?s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.post.status.saving,expression:"post.status.saving"}]},[s("small",{staticClass:"text-muted"},[t._v(t._s(t.$I18n.trans("hackernews.points",{points:t.post.score})))]),t._v(" "),s("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),s("small",{staticClass:"text-muted"},[t._v(t._s(t.$I18n.trans("hackernews.comments",{comments:t.post.nComments})))]),t._v(" "),s("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),s("small",{staticClass:"text-muted",attrs:{title:t.post.time}},[t._v(t._s(t._f("diffForHumans")(t.post.time)))]),t._v(" "),s("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),s("small",{staticClass:"text-muted"},[t._v(t._s(t.$I18n.trans("hackernews.by",{by:t.post.by})))]),t._v(" "),s("span",{staticClass:"text-muted"},[t._v("|")]),t._v(" "),s("span",{staticClass:"bookmark-story pointer text-primary",on:{click:function(e){return t.bookmarkPost(t.post)}}},[t._v(t._s(t.post.status.bookmarked?"⚫":"⚪️")+"️")])]):t._e()])])]),t._v(" "),t.post.comments.length?s("div",{staticClass:"row"},[s("div",{staticClass:"col-12 no-gutter-xs"},[t.loadingComments?t._e():s("div",t._l(t.post.comments,(function(e){return s("hn-comment",{key:e.id,attrs:{comment:e,"handle-collapse-toggle":t.handleCollapseToggle}})})),1)])]):t._e()],1)}),[],!1,null,"bd575fd4",null).exports);a.a.use(o.a);var E=new o.a({routes:[{path:"/",name:"HackerNewsTop",component:B},{path:"/best",name:"HackerNewsBest",component:B},{path:"/bookmark",name:"HackerNewsBookmarks",component:B},{path:"/post/:id",name:"HackerNewsPost",component:P,props:!0}]}),R=s("XJYT"),U=s.n(R),Y=(s("D66Q"),s("RLBy"),s("D/Jt")),A=s("tSZF"),M=s("Ubvr");a.a.component("main-navigation",M.a),a.a.use(U.a),a.a.use(Y.a),a.a.prototype.$I18n=new A.a,new a.a({router:E,el:"#app"})},2:function(t,e,s){t.exports=s("1aZf")},"9Wh1":function(t,e,s){"use strict";var n=s("3CEA"),a=s("gtzJ"),o=s("vDqi"),r=s.n(o);n.a({dsn:"https://50142ad267aa4c7c9dab6ed21262d2ab@sentry.io/1504143"}),r.a.defaults.headers.common["X-Requested-With"]="XMLHttpRequest",r.a.defaults.withCredentials=!0;var i=document.head.querySelector('meta[name="csrf-token"]');if(i)r.a.defaults.headers.common["X-CSRF-TOKEN"]=i.content,r.a.interceptors.response.use(null,(function(t){t.response?401!==t.response.status&&419!==t.response.status||window.location.replace("/login"):(a.b(t),console.error("Unknown error: ".concat(t)))}));else{var l="CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token";a.b(l),console.error(l)}},J82J:function(t,e,s){(t.exports=s("I1BE")(!1)).push([t.i,"\n.slide-enter-active[data-v-1a92697e] {\n  transition-duration: 0.3s;\n  transition-timing-function: ease-in;\n}\n.slide-leave-active[data-v-1a92697e] {\n  transition-duration: 0.3s;\n  transition-timing-function: cubic-bezier(0, 1, 0.5, 1);\n}\n.slide-enter-to[data-v-1a92697e], .slide-leave[data-v-1a92697e] {\n  max-height: 1000px;\n  overflow: hidden;\n}\n.slide-enter[data-v-1a92697e], .slide-leave-to[data-v-1a92697e] {\n  overflow: hidden;\n  max-height: 0;\n}\n.text-line-through[data-v-1a92697e] {\n  text-decoration: line-through;\n}\n.btn-collapse[data-v-1a92697e] {\n  font-family: 'Inconsolata', monospace;\n  padding: 0;\n  height: 23px;\n}\n",""])},JOMe:function(t,e,s){var n=s("xK8D");"string"==typeof n&&(n=[[t.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};s("aET+")(n,a);n.locals&&(t.exports=n.locals)},P9EP:function(t,e,s){"use strict";var n=s("avtZ");s.n(n).a},Q0U0:function(t,e,s){"use strict";var n=s("JOMe");s.n(n).a},QhOH:function(t,e,s){"use strict";var n=s("/ztT");s.n(n).a},RLBy:function(t,e,s){"use strict";var n=s("XuX8"),a=s.n(n),o=s("wd/R"),r=s.n(o);a.a.filter("diffForHumans",(function(t){if(t)return r()(t,"YYYY-MM-DD hh:mm:ss").fromNow()})),a.a.filter("domainFromUrl",(function(t){if(t)return new URL(t).hostname.replace("www.","")}))},RnhZ:function(t,e,s){var n={"./af":"K/tc","./af.js":"K/tc","./ar":"jnO4","./ar-dz":"o1bE","./ar-dz.js":"o1bE","./ar-kw":"Qj4J","./ar-kw.js":"Qj4J","./ar-ly":"HP3h","./ar-ly.js":"HP3h","./ar-ma":"CoRJ","./ar-ma.js":"CoRJ","./ar-sa":"gjCT","./ar-sa.js":"gjCT","./ar-tn":"bYM6","./ar-tn.js":"bYM6","./ar.js":"jnO4","./az":"SFxW","./az.js":"SFxW","./be":"H8ED","./be.js":"H8ED","./bg":"hKrs","./bg.js":"hKrs","./bm":"p/rL","./bm.js":"p/rL","./bn":"kEOa","./bn.js":"kEOa","./bo":"0mo+","./bo.js":"0mo+","./br":"aIdf","./br.js":"aIdf","./bs":"JVSJ","./bs.js":"JVSJ","./ca":"1xZ4","./ca.js":"1xZ4","./cs":"PA2r","./cs.js":"PA2r","./cv":"A+xa","./cv.js":"A+xa","./cy":"l5ep","./cy.js":"l5ep","./da":"DxQv","./da.js":"DxQv","./de":"tGlX","./de-at":"s+uk","./de-at.js":"s+uk","./de-ch":"u3GI","./de-ch.js":"u3GI","./de.js":"tGlX","./dv":"WYrj","./dv.js":"WYrj","./el":"jUeY","./el.js":"jUeY","./en-au":"Dmvi","./en-au.js":"Dmvi","./en-ca":"OIYi","./en-ca.js":"OIYi","./en-gb":"Oaa7","./en-gb.js":"Oaa7","./en-ie":"4dOw","./en-ie.js":"4dOw","./en-il":"czMo","./en-il.js":"czMo","./en-in":"7C5Q","./en-in.js":"7C5Q","./en-nz":"b1Dy","./en-nz.js":"b1Dy","./en-sg":"t+mt","./en-sg.js":"t+mt","./eo":"Zduo","./eo.js":"Zduo","./es":"iYuL","./es-do":"CjzT","./es-do.js":"CjzT","./es-us":"Vclq","./es-us.js":"Vclq","./es.js":"iYuL","./et":"7BjC","./et.js":"7BjC","./eu":"D/JM","./eu.js":"D/JM","./fa":"jfSC","./fa.js":"jfSC","./fi":"gekB","./fi.js":"gekB","./fil":"1ppg","./fil.js":"1ppg","./fo":"ByF4","./fo.js":"ByF4","./fr":"nyYc","./fr-ca":"2fjn","./fr-ca.js":"2fjn","./fr-ch":"Dkky","./fr-ch.js":"Dkky","./fr.js":"nyYc","./fy":"cRix","./fy.js":"cRix","./ga":"USCx","./ga.js":"USCx","./gd":"9rRi","./gd.js":"9rRi","./gl":"iEDd","./gl.js":"iEDd","./gom-deva":"qvJo","./gom-deva.js":"qvJo","./gom-latn":"DKr+","./gom-latn.js":"DKr+","./gu":"4MV3","./gu.js":"4MV3","./he":"x6pH","./he.js":"x6pH","./hi":"3E1r","./hi.js":"3E1r","./hr":"S6ln","./hr.js":"S6ln","./hu":"WxRl","./hu.js":"WxRl","./hy-am":"1rYy","./hy-am.js":"1rYy","./id":"UDhR","./id.js":"UDhR","./is":"BVg3","./is.js":"BVg3","./it":"bpih","./it-ch":"bxKX","./it-ch.js":"bxKX","./it.js":"bpih","./ja":"B55N","./ja.js":"B55N","./jv":"tUCv","./jv.js":"tUCv","./ka":"IBtZ","./ka.js":"IBtZ","./kk":"bXm7","./kk.js":"bXm7","./km":"6B0Y","./km.js":"6B0Y","./kn":"PpIw","./kn.js":"PpIw","./ko":"Ivi+","./ko.js":"Ivi+","./ku":"JCF/","./ku.js":"JCF/","./ky":"lgnt","./ky.js":"lgnt","./lb":"RAwQ","./lb.js":"RAwQ","./lo":"sp3z","./lo.js":"sp3z","./lt":"JvlW","./lt.js":"JvlW","./lv":"uXwI","./lv.js":"uXwI","./me":"KTz0","./me.js":"KTz0","./mi":"aIsn","./mi.js":"aIsn","./mk":"aQkU","./mk.js":"aQkU","./ml":"AvvY","./ml.js":"AvvY","./mn":"lYtQ","./mn.js":"lYtQ","./mr":"Ob0Z","./mr.js":"Ob0Z","./ms":"6+QB","./ms-my":"ZAMP","./ms-my.js":"ZAMP","./ms.js":"6+QB","./mt":"G0Uy","./mt.js":"G0Uy","./my":"honF","./my.js":"honF","./nb":"bOMt","./nb.js":"bOMt","./ne":"OjkT","./ne.js":"OjkT","./nl":"+s0g","./nl-be":"2ykv","./nl-be.js":"2ykv","./nl.js":"+s0g","./nn":"uEye","./nn.js":"uEye","./oc-lnc":"Fnuy","./oc-lnc.js":"Fnuy","./pa-in":"8/+R","./pa-in.js":"8/+R","./pl":"jVdC","./pl.js":"jVdC","./pt":"8mBD","./pt-br":"0tRk","./pt-br.js":"0tRk","./pt.js":"8mBD","./ro":"lyxo","./ro.js":"lyxo","./ru":"lXzo","./ru.js":"lXzo","./sd":"Z4QM","./sd.js":"Z4QM","./se":"//9w","./se.js":"//9w","./si":"7aV9","./si.js":"7aV9","./sk":"e+ae","./sk.js":"e+ae","./sl":"gVVK","./sl.js":"gVVK","./sq":"yPMs","./sq.js":"yPMs","./sr":"zx6S","./sr-cyrl":"E+lV","./sr-cyrl.js":"E+lV","./sr.js":"zx6S","./ss":"Ur1D","./ss.js":"Ur1D","./sv":"X709","./sv.js":"X709","./sw":"dNwA","./sw.js":"dNwA","./ta":"PeUW","./ta.js":"PeUW","./te":"XLvN","./te.js":"XLvN","./tet":"V2x9","./tet.js":"V2x9","./tg":"Oxv6","./tg.js":"Oxv6","./th":"EOgW","./th.js":"EOgW","./tl-ph":"Dzi0","./tl-ph.js":"Dzi0","./tlh":"z3Vd","./tlh.js":"z3Vd","./tr":"DoHr","./tr.js":"DoHr","./tzl":"z1FC","./tzl.js":"z1FC","./tzm":"wQk9","./tzm-latn":"tT3J","./tzm-latn.js":"tT3J","./tzm.js":"wQk9","./ug-cn":"YRex","./ug-cn.js":"YRex","./uk":"raLr","./uk.js":"raLr","./ur":"UpQW","./ur.js":"UpQW","./uz":"Loxo","./uz-latn":"AQ68","./uz-latn.js":"AQ68","./uz.js":"Loxo","./vi":"KSF8","./vi.js":"KSF8","./x-pseudo":"/X5v","./x-pseudo.js":"/X5v","./yo":"fzPg","./yo.js":"fzPg","./zh-cn":"XDpg","./zh-cn.js":"XDpg","./zh-hk":"SatO","./zh-hk.js":"SatO","./zh-mo":"OmwH","./zh-mo.js":"OmwH","./zh-tw":"kOpN","./zh-tw.js":"kOpN"};function a(t){var e=o(t);return s(e)}function o(t){if(!s.o(n,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return n[t]}a.keys=function(){return Object.keys(n)},a.resolve=o,t.exports=a,a.id="RnhZ"},SErk:function(t,e,s){(t.exports=s("I1BE")(!1)).push([t.i,"\n.bookmark-story[data-v-a147e218] {\n  position: relative;\n  top: 2px;\n  text-decoration: none;\n}\n.loader-text[data-v-a147e218] {\n  background: #808080;\n  border-radius: 2px;\n}\n.loader-text--1x3[data-v-a147e218] {\n  width: 33%;\n}\n.loader-text-top[data-v-a147e218] {\n  height: 22px;\n  margin-bottom: 6px;\n}\n.loader-text-bottom[data-v-a147e218] {\n  height: 18px;\n}\n",""])},Ubvr:function(t,e,s){"use strict";var n=s("vDqi"),a=s.n(n),o={name:"MainNavigation",props:{route:{type:String,required:!1}},data:function(){return{menuCollapsed:!0,isNoteRoute:!1,isHackerNewsRoute:!1,isUsersRoute:!1,appRoutes:[]}},methods:{logout:function(t){t.preventDefault(),a.a.post("/logout",{}).then((function(){return window.location.href="/"}))}},created:function(){this.$router?(this.appRoutes=this.$router.options.routes.map((function(t){return t.name})),this.isNoteRoute=this.appRoutes.includes("Notes"),this.isHackerNewsRoute=this.appRoutes.includes("HackerNewsTop")):this.isUsersRoute="users"===this.route}},r=s("KHd+"),i=Object(r.a)(o,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("nav",{staticClass:"navbar navbar-expand-md navbar-light navbar-laravel",attrs:{id:"main-navigation"}},[s("div",{staticClass:"container"},[s("a",{staticClass:"navbar-brand",attrs:{href:"/"}},[t._v("Zetetic Elench")]),t._v(" "),s("button",{staticClass:"navbar-toggler",attrs:{type:"button"},on:{click:function(e){t.menuCollapsed=!t.menuCollapsed}}},[s("span",{staticClass:"navbar-toggler-icon"})]),t._v(" "),s("div",{staticClass:"navbar-collapse",class:{collapse:t.menuCollapsed}},[s("ul",{staticClass:"navbar-nav mr-auto"},[s("li",{staticClass:"nav-item"},[s("a",{staticClass:"nav-link text-right text-sm-left",class:{"text-primary":t.isNoteRoute},attrs:{href:"/notes"}},[t._v(t._s(t.$I18n.trans("notes.notes")))])]),t._v(" "),s("li",{staticClass:"nav-item"},[s("a",{staticClass:"nav-link text-right text-sm-left",class:{"text-primary":t.isHackerNewsRoute},attrs:{href:"/hn"}},[t._v(t._s(t.$I18n.trans("hackernews.hackernews")))])]),t._v(" "),s("li",{staticClass:"nav-item"},[s("a",{staticClass:"nav-link text-right text-sm-left",class:{"text-primary":t.isUsersRoute},attrs:{href:"/users"}},[t._v(t._s(t.$I18n.trans("users.users")))])])]),t._v(" "),s("ul",{staticClass:"navbar-nav ml-auto"},[s("li",{staticClass:"nav-item"},[s("a",{staticClass:"nav-link text-right text-sm-left",attrs:{href:"#"},on:{click:function(e){return t.logout(e)}}},[t._v(t._s(t.$I18n.trans("users.logout")))])])])])])])}),[],!1,null,null,null);e.a=i.exports},avtZ:function(t,e,s){var n=s("J82J");"string"==typeof n&&(n=[[t.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};s("aET+")(n,a);n.locals&&(t.exports=n.locals)},tSZF:function(t,e,s){"use strict";function n(t){return(n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function a(t,e){return function(t){if(Array.isArray(t))return t}(t)||function(t,e){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var s=[],n=!0,a=!1,o=void 0;try{for(var r,i=t[Symbol.iterator]();!(n=(r=i.next()).done)&&(s.push(r.value),!e||s.length!==e);n=!0);}catch(t){a=!0,o=t}finally{try{n||null==i.return||i.return()}finally{if(a)throw o}}return s}(t,e)||function(t,e){if(!t)return;if("string"==typeof t)return o(t,e);var s=Object.prototype.toString.call(t).slice(8,-1);"Object"===s&&t.constructor&&(s=t.constructor.name);if("Map"===s||"Set"===s)return Array.from(t);if("Arguments"===s||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(s))return o(t,e)}(t,e)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function o(t,e){(null==e||e>t.length)&&(e=t.length);for(var s=0,n=new Array(e);s<e;s++)n[s]=t[s];return n}function r(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function i(t,e){for(var s=0;s<e.length;s++){var n=e[s];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}s.d(e,"a",(function(){return l}));var l=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"translations";r(this,t),this.key=e}var e,s,o;return e=t,(s=[{key:"trans",value:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return this._replace(this._extract(t),e)}},{key:"trans_choice",value:function(t){var e,s=this,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1,a=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{},o=this._extract(t,"|").split("|");return o.some((function(t){return e=s._match(t,n)})),e=(e=e||(n>1?o[1]:o[0])).replace(/\[.*?\]|\{.*?\}/,""),this._replace(e,a)}},{key:"_match",value:function(t,e){var s=t.match(/^[\{\[]([^\[\]\{\}]*)[\}\]](.*)/);if(s){if(s[1].includes(",")){var n=a(s[1].split(",",2),2),o=n[0],r=n[1];if("*"===r&&e>=o)return s[2];if("*"===o&&e<=r)return s[2];if(e>=o&&e<=r)return s[2]}return s[1]==e?s[2]:null}}},{key:"_replace",value:function(t,e){if("object"===n(t))return t;for(var s in e)t=t.toString().replace(":".concat(s),e[s]).replace(":".concat(s.toUpperCase()),e[s].toString().toUpperCase()).replace(":".concat(s.charAt(0).toUpperCase()).concat(s.slice(1)),e[s].toString().charAt(0).toUpperCase()+e[s].toString().slice(1));return t.toString().trim()}},{key:"_extract",value:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,s=t.toString().split("::"),n=s.pop().toString().split(".");return s.length>0&&(s[0]+="::"),s.concat(n).reduce((function(s,n){return s[n]||e||t}),window[this.key])}}])&&i(e.prototype,s),o&&i(e,o),t}()},xK8D:function(t,e,s){(t.exports=s("I1BE")(!1)).push([t.i,"\n.bookmark-story[data-v-bd575fd4] {\n  position: relative;\n  top: 2px;\n  text-decoration: none;\n}\n.loader-text[data-v-bd575fd4] {\n  background: #808080;\n  border-radius: 2px;\n}\n.loader-text--1x3[data-v-bd575fd4] {\n  width: 33%;\n}\n.loader-text--2x3[data-v-bd575fd4] {\n  width: 66%;\n}\n",""])}},[[2,0,1]]]);