(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/hn/app"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnComment.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/components/HnComment.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "HnComment",
  props: {
    comment: {
      type: Object,
      required: true
    },
    handleCollapseToggle: {
      type: Function,
      required: true
    }
  },
  data: function data() {
    return {
      isShow: true
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnPosts.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/components/HnPosts.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _mixins_bookmarkPost__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../mixins/bookmarkPost */ "./resources/js/hn/mixins/bookmarkPost.js");
/* harmony import */ var _service_HnDB__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../service/HnDB */ "./resources/js/hn/service/HnDB.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash.get */ "./node_modules/lodash.get/index.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_5__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//





/* harmony default export */ __webpack_exports__["default"] = ({
  name: "HNPosts",
  mixins: [_mixins_bookmarkPost__WEBPACK_IMPORTED_MODULE_1__["bookmarkPost"]],
  props: {
    idList: {
      type: Array,
      "default": [],
      required: true
    }
  },
  data: function data() {
    return {
      loading: true,
      posts: [],
      nBookmarks: null,
      firstBatchPosition: 10
    };
  },
  methods: {
    /**
     * Loads the items in two batches to show something to the user earlier
     * insted of waiting for the entire list to load.
     * @param idList
     */
    fetchItems: function fetchItems(idList) {
      var _this = this;

      var firstBatchPosition = this.firstBatchPosition;

      if (idList.length < firstBatchPosition) {
        firstBatchPosition = Math.floor(idList.length / 2);
      }

      var firstBatch = idList.slice(0, firstBatchPosition);
      var secondBatch = idList.slice(firstBatchPosition);
      Promise.all(firstBatch.map(function (id) {
        return _this.fetchItem(id);
      })).then(function (stories) {
        _this.posts = stories;

        _this.attachBookmarked();

        _this.loading = false;
      });
      this.$nextTick(function () {
        Promise.all(secondBatch.map(function (id) {
          return _this.fetchItem(id);
        })).then(function (stories) {
          var _this$posts;

          (_this$posts = _this.posts).push.apply(_this$posts, _toConsumableArray(stories));

          _this.attachBookmarked();
        });
      });
    },
    fetchItem: function fetchItem(id) {
      return new Promise(function (resolve, reject) {
        _service_HnDB__WEBPACK_IMPORTED_MODULE_2__["HnDB"].child("item/".concat(id)).on('value', function (snapshot) {
          var postData = snapshot.val();
          var item = {
            id: lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(postData, 'id'),
            title: lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(postData, 'title'),
            score: lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(postData, 'score'),
            time: moment__WEBPACK_IMPORTED_MODULE_4___default.a.unix(lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(postData, 'time', 0)).format('YYYY-MM-DD HH:mm:ss'),
            url: lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(postData, 'url'),
            type: lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(postData, 'type'),
            nComments: lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(postData, 'descendants'),
            kids: lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(postData, 'kids', []),
            status: {
              bookmarked: false,
              saving: false
            }
          };
          resolve(item);
        });
        _service_HnDB__WEBPACK_IMPORTED_MODULE_2__["HnDB"].onDisconnect(function (a, b) {
          this.$alert('Firebase connection lost', 'Lost connection', {
            confirmButtonText: 'OK'
          });
          console.log(a, b);
        });
      });
    },
    attachBookmarked: function attachBookmarked() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var response, ids;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_5___default.a.get("/api/bookmarks");

              case 2:
                response = _context.sent;
                ids = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(response, 'data.data', []);
                _this2.nBookmarks = ids.length;
                _this2.posts = _this2.posts.map(function (post) {
                  post.status.bookmarked = ids.includes(post.id);
                  return post;
                });

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  },
  watch: {
    idList: function idList(newIdList, oldIdList) {
      var _this3 = this;

      this.loading = true;
      setTimeout(function () {
        return _this3.fetchItems(newIdList);
      }, 400);
    },
    nBookmarks: function nBookmarks(newValue, oldValue) {
      this.$emit("nBookmarksChangedEvent", newValue);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/Navigation.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/components/Navigation.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Navigation",
  props: {
    numberOfBookmarks: {
      type: Number | null,
      required: true
    }
  },
  methods: {
    activeSubmenu: function activeSubmenu(routeName) {
      return this.$route.name === routeName ? 'btn-primary' : 'btn-secondary';
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNews.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/views/HackerNews.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_Navigation__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/Navigation */ "./resources/js/hn/components/Navigation.vue");
/* harmony import */ var _components_HnPosts__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/HnPosts */ "./resources/js/hn/components/HnPosts.vue");
/* harmony import */ var _service_HnDB__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../service/HnDB */ "./resources/js/hn/service/HnDB.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! lodash.get */ "./node_modules/lodash.get/index.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_5__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//





/* harmony default export */ __webpack_exports__["default"] = ({
  name: "HackerNews",
  components: {
    Navigation: _components_Navigation__WEBPACK_IMPORTED_MODULE_1__["default"],
    HnPosts: _components_HnPosts__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  data: function data() {
    return {
      idList: [],
      limit: 100,
      routesMap: {
        HackerNewsTop: 'top',
        HackerNewsBest: 'best',
        HackerNewsBookmarks: 'bookmarks'
      },
      numberOfBookmarks: null
    };
  },
  methods: {
    fetchStories: function fetchStories(routeName) {
      var type = lodash_get__WEBPACK_IMPORTED_MODULE_4___default()(this.routesMap, routeName, 'top');

      if (type === this.routesMap.HackerNewsBookmarks) {
        this.fetchIdsBookmarkedFromBackend();
      } else {
        this.fetchIdsFromFirebase(type);
      }
    },
    fetchIdsFromFirebase: function fetchIdsFromFirebase(type) {
      var _this = this;

      _service_HnDB__WEBPACK_IMPORTED_MODULE_3__["HnDB"].child("".concat(type, "stories")).limitToFirst(this.limit).once('value', function (snapshot, b) {
        var val = snapshot.val();
        _this.idList = Array.isArray(val) ? val : [];
      });
    },
    fetchIdsBookmarkedFromBackend: function fetchIdsBookmarkedFromBackend() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_5___default.a.get("/api/bookmarks");

              case 2:
                response = _context.sent;
                _this2.idList = lodash_get__WEBPACK_IMPORTED_MODULE_4___default()(response, 'data.data', []);

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    updateNumberOfBookmarks: function updateNumberOfBookmarks(value) {
      this.numberOfBookmarks = value;
    }
  },
  created: function created() {
    this.fetchStories(this.$route.name);
  },
  watch: {
    $route: function $route(to, from) {
      this.fetchStories(to.name);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNewsPost.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/views/HackerNewsPost.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_Navigation__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/Navigation */ "./resources/js/hn/components/Navigation.vue");
/* harmony import */ var _components_HnComment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/HnComment */ "./resources/js/hn/components/HnComment.vue");
/* harmony import */ var _mixins_bookmarkPost__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../mixins/bookmarkPost */ "./resources/js/hn/mixins/bookmarkPost.js");
/* harmony import */ var _service_HnDB__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../service/HnDB */ "./resources/js/hn/service/HnDB.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! lodash.get */ "./node_modules/lodash.get/index.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _sentry_browser__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @sentry/browser */ "./node_modules/@sentry/browser/esm/index.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//








/* harmony default export */ __webpack_exports__["default"] = ({
  name: "HackerNewsPost",
  mixins: [_mixins_bookmarkPost__WEBPACK_IMPORTED_MODULE_3__["bookmarkPost"]],
  components: {
    Navigation: _components_Navigation__WEBPACK_IMPORTED_MODULE_1__["default"],
    HnComment: _components_HnComment__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data: function data() {
    return {
      loading: true,
      loadingComments: true,
      collapsedCommentsKey: 'collapsedCommentsHackerNewsPost',
      collapsedComments: [],
      post: {
        id: null,
        by: null,
        title: null,
        text: null,
        score: null,
        time: null,
        url: null,
        type: null,
        nComments: null,
        status: {
          bookmarked: null,
          saving: null
        },
        // array of first level comment ids
        kids: [],
        // array of objects with each item with structure equal to parent
        comments: [{
          id: null,
          by: null,
          kids: [],
          parent: null,
          text: null,
          time: null,
          comments: []
        }]
      },
      numberOfBookmarks: null
    };
  },
  methods: {
    fetchPost: function fetchPost(id) {
      var _this = this;

      if (!id) {
        return;
      }

      this.fetchCollapsedComments();
      _service_HnDB__WEBPACK_IMPORTED_MODULE_4__["HnDB"].child("item/".concat(id)).once('value', function (snapshot) {
        var postData = snapshot.val();
        _this.post.id = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(postData, 'id');
        _this.post.by = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(postData, 'by');
        _this.post.title = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(postData, 'title');
        _this.post.text = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(postData, 'text');
        _this.post.score = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(postData, 'score');
        _this.post.time = moment__WEBPACK_IMPORTED_MODULE_6___default.a.unix(lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(postData, 'time', 0)).format('YYYY-MM-DD HH:mm:ss');
        _this.post.url = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(postData, 'url');
        _this.post.type = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(postData, 'type');
        _this.post.nComments = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(postData, 'descendants');
        _this.post.bookmarked = null;
        _this.post.kids = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(postData, 'kids', []);
        _this.post.comments = [];

        _this.setBookmarkStatus(_this.post);

        _this.fetchComments(_this.post);

        _this.loading = false;
      });
    },
    fetchComments: function fetchComments(parent) {
      var _this2 = this;

      if (parent.kids.length) {
        parent.kids.map(function (id) {
          _this2.fetchComment(id).then(function (commentData) {
            var kids = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(commentData, 'kids', []);

            var id = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(commentData, 'id');

            var comment = {
              id: id,
              deleted: lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(commentData, 'deleted'),
              by: lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(commentData, 'by'),
              kids: kids,
              text: lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(commentData, 'text'),
              time: moment__WEBPACK_IMPORTED_MODULE_6___default.a.unix(lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(commentData, 'time', 0)).format('YYYY-MM-DD HH:mm:ss'),
              comments: [],
              collapsed: _this2.collapsedComments.includes(id)
            };

            _this2.fetchComments(comment);

            parent.comments.push(comment);
            _this2.loadingComments = false;
          });
        });
      }
    },
    fetchComment: function fetchComment(id) {
      return new Promise(function (resolve, reject) {
        _service_HnDB__WEBPACK_IMPORTED_MODULE_4__["HnDB"].child("item/".concat(id)).once('value', function (snapshot) {
          var commentData = snapshot.val();
          resolve(commentData);
        });
      });
    },
    setBookmarkStatus: function setBookmarkStatus(post) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var response, ids;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_7___default.a.get("/api/bookmarks");

              case 2:
                response = _context.sent;
                ids = lodash_get__WEBPACK_IMPORTED_MODULE_5___default()(response, 'data.data', []);
                _this3.numberOfBookmarks = ids.length;
                post.status.bookmarked = ids.includes(post.id);

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },

    /**
     * Fetches the list of item ids that are collapsed from localStorage
     */
    fetchCollapsedComments: function fetchCollapsedComments() {
      var json = localStorage.getItem(this.collapsedCommentsKey);
      var commentIds;

      try {
        commentIds = JSON.parse(json);
      } catch (e) {
        _sentry_browser__WEBPACK_IMPORTED_MODULE_8__["captureMessage"](e);
      }

      commentIds = Array.isArray(commentIds) ? commentIds : [];
      this.collapsedComments = commentIds;
    },

    /**
     * Stores list of item ids of collapsed element to localStorage
     */
    setCollapsedComments: function setCollapsedComments() {
      var json = JSON.stringify(this.collapsedComments);
      localStorage.setItem(this.collapsedCommentsKey, json);
    },

    /**
     * Toggles the collapse property of the comment and
     * adds/removes from list of collapsedComments
     *
     * @param comment The comment item object
     */
    handleCollapseToggle: function handleCollapseToggle(comment) {
      comment.collapsed = !comment.collapsed;

      if (comment.collapsed) {
        // add to collapsed comments list
        this.collapsedComments.push(comment.id);
      } else {
        // remove from collapsed comments list
        this.collapsedComments = this.collapsedComments.filter(function (id) {
          return id !== comment.id;
        });
      }

      this.setCollapsedComments();
    }
  },
  created: function created() {
    this.fetchPost(this.id);
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/components/HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.slide-enter-active[data-v-6cdb657b] {\n  transition-duration: 0.3s;\n  transition-timing-function: ease-in;\n}\n.slide-leave-active[data-v-6cdb657b] {\n  transition-duration: 0.3s;\n  transition-timing-function: cubic-bezier(0, 1, 0.5, 1);\n}\n.slide-enter-to[data-v-6cdb657b], .slide-leave[data-v-6cdb657b] {\n  max-height: 1000px;\n  overflow: hidden;\n}\n.slide-enter[data-v-6cdb657b], .slide-leave-to[data-v-6cdb657b] {\n  overflow: hidden;\n  max-height: 0;\n}\n.text-line-through[data-v-6cdb657b] {\n  text-decoration: line-through;\n}\n.btn-collapse[data-v-6cdb657b] {\n  font-family: 'Inconsolata', monospace;\n  padding: 0;\n  height: 23px;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/components/HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.bookmark-story[data-v-4ef96c22] {\n  position: relative;\n  top: 2px;\n  text-decoration: none;\n}\n.loader-text[data-v-4ef96c22] {\n  background: #808080;\n  border-radius: 2px;\n}\n.loader-text--1x3[data-v-4ef96c22] {\n  width: 33%;\n}\n.loader-text-top[data-v-4ef96c22] {\n  height: 22px;\n  margin-bottom: 6px;\n}\n.loader-text-bottom[data-v-4ef96c22] {\n  height: 18px;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/views/HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.bookmark-story[data-v-6a14e77d] {\n  position: relative;\n  top: 2px;\n  text-decoration: none;\n}\n.loader-text[data-v-6a14e77d] {\n  background: #808080;\n  border-radius: 2px;\n}\n.loader-text--1x3[data-v-6a14e77d] {\n  width: 33%;\n}\n.loader-text--2x3[data-v-6a14e77d] {\n  width: 66%;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/components/HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/components/HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/views/HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnComment.vue?vue&type=template&id=6cdb657b&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/components/HnComment.vue?vue&type=template&id=6cdb657b&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "hn-comment card mt-3" }, [
    _c(
      "div",
      { staticClass: "card-body px-2 px-md-3 shadow" },
      [
        _c(
          "h6",
          {
            staticClass:
              "card-subtitle bg-light text-muted d-flex justify-content-between align-items-center",
            class: { "opacity-5 text-line-through": _vm.comment.deleted }
          },
          [
            _vm.comment.id
              ? _c("span", { staticClass: "align-middle" }, [
                  _vm._v(
                    _vm._s(
                      _vm.$I18n.trans("hackernews.by", {
                        by: _vm.comment.by || ""
                      })
                    )
                  )
                ])
              : _vm._e(),
            _vm._v(" "),
            _c(
              "small",
              { staticClass: "text-muted", attrs: { title: _vm.comment.time } },
              [_vm._v(_vm._s(_vm._f("diffForHumans")(_vm.comment.time)))]
            ),
            _vm._v(" "),
            _vm.comment.id
              ? _c(
                  "a",
                  {
                    staticClass: "btn btn-sm pointer btn-collapse",
                    attrs: { role: "button", "data-toggle": "collapse" },
                    on: {
                      click: function($event) {
                        return _vm.handleCollapseToggle(_vm.comment)
                      }
                    }
                  },
                  [
                    _c("b", [
                      _vm._v("["),
                      _vm.comment.collapsed
                        ? _c("span", [_vm._v(_vm._s(_vm.comment.kids.length))])
                        : _c("span", [_vm._v("-")]),
                      _vm._v("]\n        ")
                    ])
                  ]
                )
              : _vm._e()
          ]
        ),
        _vm._v(" "),
        _c("transition", { attrs: { name: "slide" } }, [
          !_vm.comment.collapsed
            ? _c(
                "div",
                { staticClass: "mt-2" },
                [
                  _c("p", {
                    domProps: { innerHTML: _vm._s(_vm.comment.text) }
                  }),
                  _vm._v(" "),
                  _vm._l(_vm.comment.comments, function(com) {
                    return _vm.comment.comments.length
                      ? _c("hn-comment", {
                          key: com.id,
                          attrs: {
                            comment: com,
                            "handle-collapse-toggle": _vm.handleCollapseToggle
                          }
                        })
                      : _vm._e()
                  })
                ],
                2
              )
            : _vm._e()
        ])
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnPosts.vue?vue&type=template&id=4ef96c22&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/components/HnPosts.vue?vue&type=template&id=4ef96c22&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "ul",
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading,
          expression: "loading"
        }
      ],
      staticClass: "list-group",
      attrs: { id: "hn-posts" }
    },
    [
      _vm._l(Array(_vm.firstBatchPosition).fill(null), function(dummy) {
        return _vm.loading
          ? _c(
              "li",
              {
                staticClass:
                  "list-group-item list-group-item-action flex-column align-items-start"
              },
              [_vm._m(0, true), _vm._v(" "), _vm._m(1, true)]
            )
          : _vm._e()
      }),
      _vm._v(" "),
      _vm._l(_vm.posts, function(post, index) {
        return _c(
          "li",
          {
            key: post.id,
            staticClass:
              "list-group-item list-group-item-action flex-column align-items-start",
            attrs: { "data-index": index + 1 }
          },
          [
            _c("div", { staticClass: "d-flex w-100 justify-content-between" }, [
              _c(
                "span",
                [
                  _c(
                    "router-link",
                    {
                      staticClass: "text-body",
                      attrs: { to: "/post/" + post.id }
                    },
                    [_vm._v(_vm._s(post.title))]
                  ),
                  _vm._v(" "),
                  post.url
                    ? _c(
                        "a",
                        {
                          staticClass: "text-body",
                          attrs: { href: post.url, target: "_blank" }
                        },
                        [
                          _c("small", { staticClass: "text-muted" }, [
                            _vm._v(
                              "(" +
                                _vm._s(_vm._f("domainFromUrl")(post.url)) +
                                ")"
                            )
                          ])
                        ]
                      )
                    : _vm._e()
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "span",
                {
                  directives: [
                    {
                      name: "loading",
                      rawName: "v-loading",
                      value: post.status.saving,
                      expression: "post.status.saving"
                    }
                  ],
                  staticClass: "d-block d-md-none"
                },
                [
                  _c(
                    "span",
                    {
                      staticClass: "bookmark-story pointer text-primary",
                      on: {
                        click: function($event) {
                          return _vm.bookmarkPost(post)
                        }
                      }
                    },
                    [
                      _vm._v(
                        _vm._s(post.status.bookmarked ? "⚫" : "⚪️") + "️"
                      )
                    ]
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "span",
                {
                  staticClass: "badge d-none d-md-block",
                  attrs: { title: post.time }
                },
                [_vm._v(_vm._s(_vm._f("diffForHumans")(post.time)))]
              )
            ]),
            _vm._v(" "),
            _c(
              "div",
              {
                directives: [
                  {
                    name: "loading",
                    rawName: "v-loading",
                    value: post.status.saving,
                    expression: "post.status.saving"
                  }
                ],
                staticClass: "d-none d-md-block"
              },
              [
                _c("small", { staticClass: "text-muted" }, [
                  _vm._v(
                    _vm._s(
                      _vm.$I18n.trans("hackernews.points", {
                        points: post.score || ""
                      })
                    )
                  )
                ]),
                _vm._v("\n      |\n      "),
                _c("small", [
                  _vm._v(
                    _vm._s(
                      _vm.$I18n.trans("hackernews.comments", {
                        comments: post.nComments || ""
                      })
                    )
                  )
                ]),
                _vm._v("\n      |\n      "),
                _c(
                  "span",
                  {
                    staticClass: "bookmark-story pointer text-primary",
                    on: {
                      click: function($event) {
                        return _vm.bookmarkPost(post)
                      }
                    }
                  },
                  [_vm._v(_vm._s(post.status.bookmarked ? "⚫" : "⚪️"))]
                )
              ]
            )
          ]
        )
      })
    ],
    2
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "d-flex w-100 justify-content-between" }, [
      _c("span", { staticClass: "loader-text loader-text-top d-block w-100" }, [
        _vm._v(" ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "d-none d-md-block" }, [
      _c(
        "span",
        {
          staticClass:
            "loader-text loader-text-bottom loader-text--1x3 d-inline-block"
        },
        [_c("small", [_vm._v(" ")])]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/Navigation.vue?vue&type=template&id=787401fc&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/components/Navigation.vue?vue&type=template&id=787401fc& ***!
  \****************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { attrs: { id: "navigation" } }, [
    _c("div", { staticClass: "row justify-content-center top-submenu" }, [
      _c("div", { staticClass: "col-12 no-gutter-xs" }, [
        _c(
          "div",
          { staticClass: "btn-group d-flex mb-2" },
          [
            _c(
              "router-link",
              {
                staticClass: "btn btn-group-sm w-100",
                class: _vm.activeSubmenu("HackerNewsTop"),
                attrs: { to: "/" }
              },
              [_vm._v(_vm._s(_vm.$I18n.trans("hackernews.top")))]
            ),
            _vm._v(" "),
            _c(
              "router-link",
              {
                staticClass: "btn btn-group-sm w-100",
                class: _vm.activeSubmenu("HackerNewsBest"),
                attrs: { to: "/best" }
              },
              [_vm._v(_vm._s(_vm.$I18n.trans("hackernews.best")))]
            ),
            _vm._v(" "),
            _c(
              "router-link",
              {
                staticClass: "btn btn-group-sm w-100",
                class: _vm.activeSubmenu("HackerNewsBookmarks"),
                attrs: { to: "/bookmark" }
              },
              [
                _vm._v(_vm._s(_vm.$I18n.trans("hackernews.bookmarks")) + " "),
                _c("span", { staticClass: "badge badge-light" }, [
                  _vm._v(_vm._s(_vm.numberOfBookmarks))
                ])
              ]
            )
          ],
          1
        )
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNews.vue?vue&type=template&id=172f153d&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/views/HackerNews.vue?vue&type=template&id=172f153d& ***!
  \***********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { attrs: { id: "hacker-news" } },
    [
      _c("navigation", {
        attrs: { "number-of-bookmarks": _vm.numberOfBookmarks }
      }),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-12 no-gutter-xs" },
          [
            _c("hn-posts", {
              attrs: { "id-list": _vm.idList },
              on: { nBookmarksChangedEvent: _vm.updateNumberOfBookmarks }
            })
          ],
          1
        )
      ])
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNewsPost.vue?vue&type=template&id=6a14e77d&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/hn/views/HackerNewsPost.vue?vue&type=template&id=6a14e77d&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { attrs: { id: "hacker-news-post" } },
    [
      _c("navigation", {
        attrs: { "number-of-bookmarks": _vm.numberOfBookmarks }
      }),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-12 no-gutter-xs" }, [
          _c(
            "div",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading,
                  expression: "loading"
                }
              ]
            },
            [
              _vm.loading
                ? _c(
                    "p",
                    {
                      staticClass: "lead loader-text d-block loader-text--2x3"
                    },
                    [_vm._v(" ")]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.post.title
                ? _c("p", { staticClass: "lead" }, [
                    _vm._v(
                      "\n          " + _vm._s(_vm.post.title) + "\n          "
                    ),
                    _vm.post.url
                      ? _c(
                          "a",
                          {
                            staticClass: "text-body",
                            attrs: { href: _vm.post.url, target: "_blank" }
                          },
                          [
                            _c("small", { staticClass: "text-muted" }, [
                              _vm._v(
                                "(" +
                                  _vm._s(
                                    _vm._f("domainFromUrl")(_vm.post.url)
                                  ) +
                                  ") [↗]"
                              )
                            ])
                          ]
                        )
                      : _vm._e()
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm.post.text
                ? _c("p", { domProps: { innerHTML: _vm._s(_vm.post.text) } })
                : _vm._e(),
              _vm._v(" "),
              _vm.loading
                ? _c(
                    "div",
                    { staticClass: "loader-text d-block loader-text--1x3" },
                    [_vm._v(" ")]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.post.title
                ? _c(
                    "div",
                    {
                      directives: [
                        {
                          name: "loading",
                          rawName: "v-loading",
                          value: _vm.post.status.saving,
                          expression: "post.status.saving"
                        }
                      ]
                    },
                    [
                      _c("small", { staticClass: "text-muted" }, [
                        _vm._v(
                          _vm._s(
                            _vm.$I18n.trans("hackernews.points", {
                              points: _vm.post.score
                            })
                          )
                        )
                      ]),
                      _vm._v(" "),
                      _c("span", { staticClass: "text-muted" }, [_vm._v("|")]),
                      _vm._v(" "),
                      _c("small", { staticClass: "text-muted" }, [
                        _vm._v(
                          _vm._s(
                            _vm.$I18n.trans("hackernews.comments", {
                              comments: _vm.post.nComments
                            })
                          )
                        )
                      ]),
                      _vm._v(" "),
                      _c("span", { staticClass: "text-muted" }, [_vm._v("|")]),
                      _vm._v(" "),
                      _c(
                        "small",
                        {
                          staticClass: "text-muted",
                          attrs: { title: _vm.post.time }
                        },
                        [_vm._v(_vm._s(_vm._f("diffForHumans")(_vm.post.time)))]
                      ),
                      _vm._v(" "),
                      _c("span", { staticClass: "text-muted" }, [_vm._v("|")]),
                      _vm._v(" "),
                      _c("small", { staticClass: "text-muted" }, [
                        _vm._v(
                          _vm._s(
                            _vm.$I18n.trans("hackernews.by", {
                              by: _vm.post.by
                            })
                          )
                        )
                      ]),
                      _vm._v(" "),
                      _c("span", { staticClass: "text-muted" }, [_vm._v("|")]),
                      _vm._v(" "),
                      _c(
                        "span",
                        {
                          staticClass: "bookmark-story pointer text-primary",
                          on: {
                            click: function($event) {
                              return _vm.bookmarkPost(_vm.post)
                            }
                          }
                        },
                        [
                          _vm._v(
                            _vm._s(_vm.post.status.bookmarked ? "⚫" : "⚪️") +
                              "️"
                          )
                        ]
                      )
                    ]
                  )
                : _vm._e()
            ]
          )
        ])
      ]),
      _vm._v(" "),
      _vm.post.comments.length
        ? _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-12 no-gutter-xs" }, [
              !_vm.loadingComments
                ? _c(
                    "div",
                    _vm._l(_vm.post.comments, function(com) {
                      return _c("hn-comment", {
                        key: com.id,
                        attrs: {
                          comment: com,
                          "handle-collapse-toggle": _vm.handleCollapseToggle
                        }
                      })
                    }),
                    1
                  )
                : _vm._e()
            ])
          ])
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/hn/app.js":
/*!********************************!*\
  !*** ./resources/js/hn/app.js ***!
  \********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _bootstrap__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../bootstrap */ "./resources/js/bootstrap.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./router */ "./resources/js/hn/router.js");
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! element-ui */ "./node_modules/element-ui/lib/element-ui.common.js");
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(element_ui__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! element-ui/lib/theme-chalk/index.css */ "./node_modules/element-ui/lib/theme-chalk/index.css");
/* harmony import */ var element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _filters__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../filters */ "./resources/js/filters.js");
/* harmony import */ var vuefire__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! vuefire */ "./node_modules/vuefire/dist/vuefire.esm.js");
/* harmony import */ var _vendor_I18n__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../vendor/I18n */ "./resources/js/vendor/I18n.js");
/* harmony import */ var _components_MainNavigation__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../components/MainNavigation */ "./resources/js/components/MainNavigation.vue");









/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
// You only need to register components that are injected into a Blade template

vue__WEBPACK_IMPORTED_MODULE_1___default.a.component('main-navigation', _components_MainNavigation__WEBPACK_IMPORTED_MODULE_8__["default"]);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

vue__WEBPACK_IMPORTED_MODULE_1___default.a.use(element_ui__WEBPACK_IMPORTED_MODULE_3___default.a);
vue__WEBPACK_IMPORTED_MODULE_1___default.a.use(vuefire__WEBPACK_IMPORTED_MODULE_6__["rtdbPlugin"]);
vue__WEBPACK_IMPORTED_MODULE_1___default.a.prototype.$I18n = new _vendor_I18n__WEBPACK_IMPORTED_MODULE_7__["default"]();
new vue__WEBPACK_IMPORTED_MODULE_1___default.a({
  router: _router__WEBPACK_IMPORTED_MODULE_2__["default"],
  el: '#app'
});

/***/ }),

/***/ "./resources/js/hn/components/HnComment.vue":
/*!**************************************************!*\
  !*** ./resources/js/hn/components/HnComment.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HnComment_vue_vue_type_template_id_6cdb657b_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HnComment.vue?vue&type=template&id=6cdb657b&scoped=true& */ "./resources/js/hn/components/HnComment.vue?vue&type=template&id=6cdb657b&scoped=true&");
/* harmony import */ var _HnComment_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HnComment.vue?vue&type=script&lang=js& */ "./resources/js/hn/components/HnComment.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _HnComment_vue_vue_type_style_index_0_id_6cdb657b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css& */ "./resources/js/hn/components/HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _HnComment_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _HnComment_vue_vue_type_template_id_6cdb657b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _HnComment_vue_vue_type_template_id_6cdb657b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "6cdb657b",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/hn/components/HnComment.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/hn/components/HnComment.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/hn/components/HnComment.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HnComment_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./HnComment.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnComment.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HnComment_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/hn/components/HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/hn/components/HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css& ***!
  \***********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnComment_vue_vue_type_style_index_0_id_6cdb657b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnComment.vue?vue&type=style&index=0&id=6cdb657b&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnComment_vue_vue_type_style_index_0_id_6cdb657b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnComment_vue_vue_type_style_index_0_id_6cdb657b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnComment_vue_vue_type_style_index_0_id_6cdb657b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnComment_vue_vue_type_style_index_0_id_6cdb657b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnComment_vue_vue_type_style_index_0_id_6cdb657b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/hn/components/HnComment.vue?vue&type=template&id=6cdb657b&scoped=true&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/hn/components/HnComment.vue?vue&type=template&id=6cdb657b&scoped=true& ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HnComment_vue_vue_type_template_id_6cdb657b_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./HnComment.vue?vue&type=template&id=6cdb657b&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnComment.vue?vue&type=template&id=6cdb657b&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HnComment_vue_vue_type_template_id_6cdb657b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HnComment_vue_vue_type_template_id_6cdb657b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/hn/components/HnPosts.vue":
/*!************************************************!*\
  !*** ./resources/js/hn/components/HnPosts.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HnPosts_vue_vue_type_template_id_4ef96c22_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HnPosts.vue?vue&type=template&id=4ef96c22&scoped=true& */ "./resources/js/hn/components/HnPosts.vue?vue&type=template&id=4ef96c22&scoped=true&");
/* harmony import */ var _HnPosts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HnPosts.vue?vue&type=script&lang=js& */ "./resources/js/hn/components/HnPosts.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _HnPosts_vue_vue_type_style_index_0_id_4ef96c22_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css& */ "./resources/js/hn/components/HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _HnPosts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _HnPosts_vue_vue_type_template_id_4ef96c22_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _HnPosts_vue_vue_type_template_id_4ef96c22_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "4ef96c22",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/hn/components/HnPosts.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/hn/components/HnPosts.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/hn/components/HnPosts.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HnPosts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./HnPosts.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnPosts.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HnPosts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/hn/components/HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/hn/components/HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css& ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnPosts_vue_vue_type_style_index_0_id_4ef96c22_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnPosts.vue?vue&type=style&index=0&id=4ef96c22&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnPosts_vue_vue_type_style_index_0_id_4ef96c22_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnPosts_vue_vue_type_style_index_0_id_4ef96c22_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnPosts_vue_vue_type_style_index_0_id_4ef96c22_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnPosts_vue_vue_type_style_index_0_id_4ef96c22_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HnPosts_vue_vue_type_style_index_0_id_4ef96c22_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/hn/components/HnPosts.vue?vue&type=template&id=4ef96c22&scoped=true&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/hn/components/HnPosts.vue?vue&type=template&id=4ef96c22&scoped=true& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HnPosts_vue_vue_type_template_id_4ef96c22_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./HnPosts.vue?vue&type=template&id=4ef96c22&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/HnPosts.vue?vue&type=template&id=4ef96c22&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HnPosts_vue_vue_type_template_id_4ef96c22_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HnPosts_vue_vue_type_template_id_4ef96c22_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/hn/components/Navigation.vue":
/*!***************************************************!*\
  !*** ./resources/js/hn/components/Navigation.vue ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Navigation_vue_vue_type_template_id_787401fc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Navigation.vue?vue&type=template&id=787401fc& */ "./resources/js/hn/components/Navigation.vue?vue&type=template&id=787401fc&");
/* harmony import */ var _Navigation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Navigation.vue?vue&type=script&lang=js& */ "./resources/js/hn/components/Navigation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Navigation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Navigation_vue_vue_type_template_id_787401fc___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Navigation_vue_vue_type_template_id_787401fc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/hn/components/Navigation.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/hn/components/Navigation.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/hn/components/Navigation.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Navigation.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/Navigation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/hn/components/Navigation.vue?vue&type=template&id=787401fc&":
/*!**********************************************************************************!*\
  !*** ./resources/js/hn/components/Navigation.vue?vue&type=template&id=787401fc& ***!
  \**********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_template_id_787401fc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Navigation.vue?vue&type=template&id=787401fc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/components/Navigation.vue?vue&type=template&id=787401fc&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_template_id_787401fc___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_template_id_787401fc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/hn/mixins/bookmarkPost.js":
/*!************************************************!*\
  !*** ./resources/js/hn/mixins/bookmarkPost.js ***!
  \************************************************/
/*! exports provided: bookmarkPost */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "bookmarkPost", function() { return bookmarkPost; });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash.get */ "./node_modules/lodash.get/index.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_2__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }



var bookmarkPost = {
  data: function data() {
    return {
      nBookmarks: null,
      notification: null
    };
  },
  methods: {
    bookmarkPost: function bookmarkPost(post) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var requestData, addBookmark, response, success;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                post.status.saving = true;
                requestData = {
                  'postId': post.id
                };
                addBookmark = !post.status.bookmarked;

                if (!addBookmark) {
                  requestData._method = 'delete';
                }

                _context.next = 6;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.post('/api/bookmarks', requestData);

              case 6:
                response = _context.sent;
                success = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data.success', false);

                if (success) {
                  post.status.bookmarked = !post.status.bookmarked;
                  _this.nBookmarks += addBookmark ? 1 : -1;
                }

                _this.notifyUserOfBookmarkStatusChange(success, addBookmark, post);

              case 10:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    notifyUserOfBookmarkStatusChange: function notifyUserOfBookmarkStatusChange(success, addedBookmark, post) {
      var messageOptions = {
        message: this.$I18n.trans('hackernews.add_failure'),
        type: 'error'
      };

      if (success) {
        if (addedBookmark) {
          messageOptions = {
            message: this.$I18n.trans('hackernews.added_to_bookmarks', {
              title: post.title
            }),
            type: 'success'
          };
        } else {
          messageOptions = {
            message: this.$I18n.trans('hackernews.remove_from_bookmarks', {
              title: post.title
            }),
            type: 'warning'
          };
        }
      }

      if (this.notification && !this.notification.closed) {
        this.notification.close();
      }

      this.notification = this.$message(messageOptions);
      setTimeout(function () {
        return post.status.saving = false;
      }, 400);
    }
  }
};

/***/ }),

/***/ "./resources/js/hn/router.js":
/*!***********************************!*\
  !*** ./resources/js/hn/router.js ***!
  \***********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-router */ "./node_modules/vue-router/dist/vue-router.esm.js");
/* harmony import */ var _views_HackerNews__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./views/HackerNews */ "./resources/js/hn/views/HackerNews.vue");
/* harmony import */ var _views_HackerNewsPost__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./views/HackerNewsPost */ "./resources/js/hn/views/HackerNewsPost.vue");




vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vue_router__WEBPACK_IMPORTED_MODULE_1__["default"]);
/* harmony default export */ __webpack_exports__["default"] = (new vue_router__WEBPACK_IMPORTED_MODULE_1__["default"]({
  routes: [{
    path: '/',
    name: 'HackerNewsTop',
    component: _views_HackerNews__WEBPACK_IMPORTED_MODULE_2__["default"]
  }, {
    path: '/best',
    name: 'HackerNewsBest',
    component: _views_HackerNews__WEBPACK_IMPORTED_MODULE_2__["default"]
  }, {
    path: '/bookmark',
    name: 'HackerNewsBookmarks',
    component: _views_HackerNews__WEBPACK_IMPORTED_MODULE_2__["default"]
  }, {
    path: '/post/:id',
    name: 'HackerNewsPost',
    component: _views_HackerNewsPost__WEBPACK_IMPORTED_MODULE_3__["default"],
    props: true
  }]
}));

/***/ }),

/***/ "./resources/js/hn/service/HnDB.js":
/*!*****************************************!*\
  !*** ./resources/js/hn/service/HnDB.js ***!
  \*****************************************/
/*! exports provided: HnDB */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "HnDB", function() { return HnDB; });
/* harmony import */ var firebase_app__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! firebase/app */ "./node_modules/firebase/app/dist/index.cjs.js");
/* harmony import */ var firebase_app__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(firebase_app__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var firebase_database__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! firebase/database */ "./node_modules/firebase/database/dist/index.esm.js");
// Get a RTDB instance


var HnDB = firebase_app__WEBPACK_IMPORTED_MODULE_0___default.a.initializeApp({
  databaseURL: 'hacker-news.firebaseio.com'
}).database().ref('/v0');

/***/ }),

/***/ "./resources/js/hn/views/HackerNews.vue":
/*!**********************************************!*\
  !*** ./resources/js/hn/views/HackerNews.vue ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HackerNews_vue_vue_type_template_id_172f153d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HackerNews.vue?vue&type=template&id=172f153d& */ "./resources/js/hn/views/HackerNews.vue?vue&type=template&id=172f153d&");
/* harmony import */ var _HackerNews_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HackerNews.vue?vue&type=script&lang=js& */ "./resources/js/hn/views/HackerNews.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _HackerNews_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _HackerNews_vue_vue_type_template_id_172f153d___WEBPACK_IMPORTED_MODULE_0__["render"],
  _HackerNews_vue_vue_type_template_id_172f153d___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/hn/views/HackerNews.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/hn/views/HackerNews.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/hn/views/HackerNews.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNews_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./HackerNews.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNews.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNews_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/hn/views/HackerNews.vue?vue&type=template&id=172f153d&":
/*!*****************************************************************************!*\
  !*** ./resources/js/hn/views/HackerNews.vue?vue&type=template&id=172f153d& ***!
  \*****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNews_vue_vue_type_template_id_172f153d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./HackerNews.vue?vue&type=template&id=172f153d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNews.vue?vue&type=template&id=172f153d&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNews_vue_vue_type_template_id_172f153d___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNews_vue_vue_type_template_id_172f153d___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/hn/views/HackerNewsPost.vue":
/*!**************************************************!*\
  !*** ./resources/js/hn/views/HackerNewsPost.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HackerNewsPost_vue_vue_type_template_id_6a14e77d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HackerNewsPost.vue?vue&type=template&id=6a14e77d&scoped=true& */ "./resources/js/hn/views/HackerNewsPost.vue?vue&type=template&id=6a14e77d&scoped=true&");
/* harmony import */ var _HackerNewsPost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HackerNewsPost.vue?vue&type=script&lang=js& */ "./resources/js/hn/views/HackerNewsPost.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _HackerNewsPost_vue_vue_type_style_index_0_id_6a14e77d_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css& */ "./resources/js/hn/views/HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _HackerNewsPost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _HackerNewsPost_vue_vue_type_template_id_6a14e77d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _HackerNewsPost_vue_vue_type_template_id_6a14e77d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "6a14e77d",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/hn/views/HackerNewsPost.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/hn/views/HackerNewsPost.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/hn/views/HackerNewsPost.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNewsPost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./HackerNewsPost.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNewsPost.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNewsPost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/hn/views/HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/hn/views/HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css& ***!
  \***********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNewsPost_vue_vue_type_style_index_0_id_6a14e77d_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNewsPost.vue?vue&type=style&index=0&id=6a14e77d&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNewsPost_vue_vue_type_style_index_0_id_6a14e77d_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNewsPost_vue_vue_type_style_index_0_id_6a14e77d_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNewsPost_vue_vue_type_style_index_0_id_6a14e77d_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNewsPost_vue_vue_type_style_index_0_id_6a14e77d_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNewsPost_vue_vue_type_style_index_0_id_6a14e77d_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/hn/views/HackerNewsPost.vue?vue&type=template&id=6a14e77d&scoped=true&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/hn/views/HackerNewsPost.vue?vue&type=template&id=6a14e77d&scoped=true& ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNewsPost_vue_vue_type_template_id_6a14e77d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./HackerNewsPost.vue?vue&type=template&id=6a14e77d&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/hn/views/HackerNewsPost.vue?vue&type=template&id=6a14e77d&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNewsPost_vue_vue_type_template_id_6a14e77d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HackerNewsPost_vue_vue_type_template_id_6a14e77d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ 2:
/*!**************************************!*\
  !*** multi ./resources/js/hn/app.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/resources/js/hn/app.js */"./resources/js/hn/app.js");


/***/ })

},[[2,"/js/manifest","/js/vendor"]]]);