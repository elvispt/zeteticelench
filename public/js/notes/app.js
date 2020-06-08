(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/notes/app"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var lodash_debounce__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash.debounce */ "./node_modules/lodash.debounce/index.js");
/* harmony import */ var lodash_debounce__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash_debounce__WEBPACK_IMPORTED_MODULE_0__);
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
  name: "AlgoliaSearch",
  data: function data() {
    return {
      searchQuery: ''
    };
  },
  watch: {
    searchQuery: function searchQuery() {
      if (this.searchQuery.length === 0 || this.searchQuery.length > 1) {
        this.submit();
      }
    }
  },
  methods: {
    submit: lodash_debounce__WEBPACK_IMPORTED_MODULE_0___default()(function () {
      this.$emit("inputData", this.searchQuery);
    }, 400),
    clearSearch: function clearSearch() {
      this.searchQuery = '';
      this.submit();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/Navigation.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/components/Navigation.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Navigation",
  methods: {
    activeSubmenu: function activeSubmenu(routeName) {
      return this.$route.name === routeName ? 'btn-primary' : 'btn-secondary';
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/NotesList.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/components/NotesList.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash.get */ "./node_modules/lodash.get/index.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_2__);


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


/* harmony default export */ __webpack_exports__["default"] = ({
  name: "NotesList",
  props: ["searchQuery"],
  data: function data() {
    return {
      loading: true,
      notes: []
    };
  },
  created: function created() {
    var _this = this;

    this.fetchNotes(this.searchQuery).then(function (result) {
      _this.loading = false;
    });
  },
  watch: {
    searchQuery: function searchQuery() {
      var _this2 = this;

      this.loading = true;
      this.fetchNotes(this.searchQuery).then(function (result) {
        _this2.loading = false;
      });
    }
  },
  methods: {
    fetchNotes: function fetchNotes(searchQuery) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get("/api/notes?query=".concat(searchQuery));

              case 2:
                response = _context.sent;
                _this3.notes = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data', []);
                return _context.abrupt("return", true);

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    close: function close() {
      this.$emit("inputData", '');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Note.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/Note.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash.get */ "./node_modules/lodash.get/index.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var highlight_js_styles_darkula_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! highlight.js/styles/darkula.css */ "./node_modules/highlight.js/styles/darkula.css");
/* harmony import */ var highlight_js_styles_darkula_css__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(highlight_js_styles_darkula_css__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _components_Navigation__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/Navigation */ "./resources/js/notes/components/Navigation.vue");


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




/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Note",
  components: {
    Navigation: _components_Navigation__WEBPACK_IMPORTED_MODULE_4__["default"]
  },
  props: ["id"],
  data: function data() {
    return {
      loading: true,
      note: {}
    };
  },
  created: function created() {
    this.fetchNote(this.id);
  },
  methods: {
    fetchNote: function fetchNote(id) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (id) {
                  _context.next = 2;
                  break;
                }

                return _context.abrupt("return", false);

              case 2:
                _context.next = 4;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get("/api/notes/".concat(id, "?html=1"));

              case 4:
                response = _context.sent;
                _this.note = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data');
                setTimeout(function () {
                  return _this.loading = false;
                }, 400);

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    confirmDelete: function confirmDelete(noteId) {
      var _this2 = this;

      var askConfirmation = this.$I18n.trans('notes.confirmation_ask_delete', {
        id: noteId
      });
      var confirmationDeleteSuccess = this.$I18n.trans('notes.confirmation_success_deleted', {
        id: noteId
      });
      var confirmButtonText = this.$I18n.trans('notes.delete');
      var cancelButtonText = this.$I18n.trans('notes.cancel');
      this.$confirm(askConfirmation, 'Warning', {
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        type: "warning",
        center: true
      }).then(function () {
        _this2.deleteNote(noteId).then(function (result) {
          if (result) {
            _this2.$message({
              type: 'success',
              message: confirmationDeleteSuccess,
              center: true
            });

            setTimeout(function () {
              return _this2.$router.push({
                name: 'Notes'
              });
            }, 400);
          }
        })["catch"](function (err) {
          _this2.$message({
            type: 'warning',
            message: _this2.$I18n.trans('notes.failed_delete', {
              id: noteId
            }),
            center: true
          });
        });
      })["catch"](function () {
        _this2.$message({
          type: 'info',
          message: _this2.$I18n.trans('notes.delete_canceled', {
            id: noteId
          }),
          center: true
        });
      });
    },
    deleteNote: function deleteNote(noteId) {
      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var response, success;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a["delete"]("/api/notedestroy/".concat(noteId), {
                  _method: 'delete'
                });

              case 2:
                response = _context2.sent;
                success = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data.success', false);

                if (!success) {
                  _context2.next = 6;
                  break;
                }

                return _context2.abrupt("return", success);

              case 6:
                throw "Delete failed";

              case 7:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteCreate.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/NoteCreate.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash.get */ "./node_modules/lodash.get/index.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _components_Navigation__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/Navigation */ "./resources/js/notes/components/Navigation.vue");
/* harmony import */ var _mixins_textareaCharInserter__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../mixins/textareaCharInserter */ "./resources/js/notes/mixins/textareaCharInserter.js");


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
  name: "NoteCreate",
  components: {
    Navigation: _components_Navigation__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  mixins: [_mixins_textareaCharInserter__WEBPACK_IMPORTED_MODULE_4__["TextareaCharInserter"]],
  data: function data() {
    return {
      newTagInputVisible: false,
      newTag: '',
      errors: [],
      note: {
        body: ''
      },
      tags: [],
      selectedTags: [],
      inputEl: null
    };
  },
  methods: {
    insertCodeBlockBackTicks: function insertCodeBlockBackTicks() {
      var textToInsert = "```";

      if (!this.inputEl) {
        this.inputEl = document.querySelector('#note-create textarea');
      }

      var inserted = document.execCommand("insertText", false, textToInsert); // Firefox fails with execCommand

      if (!inserted && typeof this.inputEl.setRangeText === "function") {
        var start = this.inputEl.selectionStart;
        this.inputEl.setRangeText(textToInsert);
        this.inputEl.selectionStart = this.inputEl.selectionEnd = start + textToInsert.length; // notify any listeners of change

        var event = document.createEvent("UIEvent");
        event.initEvent("input", true, false);
        this.inputEl.dispatchEvent(event);
      }
    },
    addNewTag: function addNewTag() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var response, success, id, msg;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this.newTag) {
                  _context.next = 15;
                  break;
                }

                _this.errors = [];
                _context.prev = 2;
                _context.next = 5;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.post('/api/notetagcreate', {
                  tag: _this.newTag
                });

              case 5:
                response = _context.sent;
                success = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data.success');
                id = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data.id');

                if (success && id) {
                  _this.tags.push({
                    id: id,
                    name: _this.newTag
                  });

                  _this.newTagInputVisible = false;
                  _this.newTag = '';
                }

                _context.next = 15;
                break;

              case 11:
                _context.prev = 11;
                _context.t0 = _context["catch"](2);
                msg = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(_context.t0, 'response.data.errors.tag[0]');

                _this.errors.push({
                  field: 'tagCreate',
                  text: msg
                });

              case 15:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[2, 11]]);
      }))();
    },
    showInput: function showInput() {
      var _this2 = this;

      this.newTagInputVisible = true;
      this.$nextTick(function (_) {
        _this2.$refs.saveTagInput.$refs.input.focus();
      });
    },
    fetchTags: function fetchTags() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get('/api/notes/tags');

              case 2:
                response = _context2.sent;
                _this3.tags = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data', []);

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    submitForm: function submitForm(event) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee3() {
        var response, id, success;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                event.preventDefault();

                if (!_this4.newTagInputVisible) {
                  _context3.next = 3;
                  break;
                }

                return _context3.abrupt("return", false);

              case 3:
                _this4.errors = [];

                if (_this4.note.body) {
                  _context3.next = 8;
                  break;
                }

                _this4.errors.push({
                  field: 'body',
                  text: "Note text is empty."
                });

                _this4.note.body = null;
                return _context3.abrupt("return");

              case 8:
                _context3.prev = 8;
                _context3.next = 11;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.post('/api/notecreate', {
                  body: _this4.note.body,
                  tags: _this4.selectedTags
                });

              case 11:
                response = _context3.sent;
                id = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data.id');
                success = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data.success');

                if (id && success) {
                  _this4.note.body = '';
                  _this4.selectedTags = [];

                  _this4.$message({
                    type: 'success',
                    message: _this4.$I18n.trans('notes.confirmation_success_note_create'),
                    center: true
                  });

                  setTimeout(function () {
                    return _this4.$router.push({
                      name: 'Note',
                      params: {
                        id: id
                      }
                    });
                  }, 400);
                } else {
                  _this4.errors.push({
                    field: 'na',
                    text: "Failed to create the note."
                  });
                }

                _context3.next = 20;
                break;

              case 17:
                _context3.prev = 17;
                _context3.t0 = _context3["catch"](8);

                _this4.errors.push({
                  field: 'submit',
                  text: _context3.t0.message
                });

              case 20:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[8, 17]]);
      }))();
    }
  },
  created: function created() {
    this.fetchTags();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteUpdate.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/NoteUpdate.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash.get */ "./node_modules/lodash.get/index.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _components_Navigation__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/Navigation */ "./resources/js/notes/components/Navigation.vue");
/* harmony import */ var _mixins_textareaCharInserter__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../mixins/textareaCharInserter */ "./resources/js/notes/mixins/textareaCharInserter.js");


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
  name: "NoteUpdate",
  components: {
    Navigation: _components_Navigation__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  mixins: [_mixins_textareaCharInserter__WEBPACK_IMPORTED_MODULE_4__["TextareaCharInserter"]],
  props: ['id'],
  data: function data() {
    return {
      loading: true,
      newTagInputVisible: false,
      newTag: '',
      errors: [],
      note: {},
      tags: [{
        id: 1,
        name: 'x'
      }],
      selectedTags: [],
      inputEl: null
    };
  },
  methods: {
    insertCodeBlockBackTicks: function insertCodeBlockBackTicks() {
      var textToInsert = "```";

      if (!this.inputEl) {
        this.inputEl = document.querySelector('#note-update textarea');
      }

      var inserted = document.execCommand("insertText", false, textToInsert); // Firefox fails with execCommand

      if (!inserted && typeof this.inputEl.setRangeText === "function") {
        var start = this.inputEl.selectionStart;
        this.inputEl.setRangeText(textToInsert);
        this.inputEl.selectionStart = this.inputEl.selectionEnd = start + textToInsert.length; // notify any listeners of change

        var event = document.createEvent("UIEvent");
        event.initEvent("input", true, false);
        this.inputEl.dispatchEvent(event);
      }
    },
    addNewTag: function addNewTag() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var response, success, id, msg;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this.newTag) {
                  _context.next = 15;
                  break;
                }

                _this.errors = [];
                _context.prev = 2;
                _context.next = 5;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.post('/api/notetagcreate', {
                  tag: _this.newTag
                });

              case 5:
                response = _context.sent;
                success = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data.success');
                id = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data.id');

                if (success && id) {
                  _this.tags.push({
                    id: id,
                    'name': _this.newTag
                  });

                  _this.newTagInputVisible = false;
                  _this.newTag = '';
                }

                _context.next = 15;
                break;

              case 11:
                _context.prev = 11;
                _context.t0 = _context["catch"](2);
                msg = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(_context.t0, 'response.data.errors.tag[0]');

                _this.errors.push({
                  field: 'tagCreate',
                  text: msg
                });

              case 15:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[2, 11]]);
      }))();
    },
    showInput: function showInput() {
      var _this2 = this;

      this.newTagInputVisible = true;
      this.$nextTick(function (_) {
        _this2.$refs.saveTagInput.$refs.input.focus();
      });
    },
    fetchNote: function fetchNote(id) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (id) {
                  _context2.next = 2;
                  break;
                }

                return _context2.abrupt("return", false);

              case 2:
                _context2.next = 4;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get("/api/notes/".concat(id, "?html=0"));

              case 4:
                response = _context2.sent;
                _this3.note = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data', []);
                _this3.selectedTags = _this3.note.tags.map(function (tag) {
                  return tag.id;
                });
                setTimeout(function () {
                  return _this3.loading = false;
                }, 400);

              case 8:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    fetchTags: function fetchTags() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee3() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get('/api/notes/tags');

              case 2:
                response = _context3.sent;
                _this4.tags = lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data', []);

              case 4:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    submitForm: function submitForm(event) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee4() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                event.preventDefault();

                if (!_this5.newTagInputVisible) {
                  _context4.next = 3;
                  break;
                }

                return _context4.abrupt("return", false);

              case 3:
                _this5.errors = [];

                if (_this5.note.body) {
                  _context4.next = 7;
                  break;
                }

                _this5.errors.push({
                  field: 'body',
                  text: "Note text is empty."
                });

                return _context4.abrupt("return");

              case 7:
                _context4.prev = 7;
                _context4.next = 10;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.put("/api/noteupdate/".concat(_this5.note.id), {
                  body: _this5.note.body,
                  tags: _this5.selectedTags,
                  _method: 'put'
                });

              case 10:
                response = _context4.sent;

                if (lodash_get__WEBPACK_IMPORTED_MODULE_2___default()(response, 'data.data.success')) {
                  _this5.selectedTags = [];

                  _this5.$message({
                    type: 'success',
                    message: _this5.$I18n.trans('notes.confirmation_success_note_updated'),
                    center: true
                  });

                  setTimeout(function () {
                    return _this5.$router.push({
                      name: 'Note',
                      params: {
                        id: _this5.note.id
                      }
                    });
                  }, 400);
                } else {
                  _this5.errors.push({
                    field: 'na',
                    text: "Failed to update note."
                  });
                }

                _context4.next = 17;
                break;

              case 14:
                _context4.prev = 14;
                _context4.t0 = _context4["catch"](7);

                _this5.errors.push({
                  field: 'submit',
                  text: _context4.t0.message
                });

              case 17:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, null, [[7, 14]]);
      }))();
    }
  },
  created: function created() {
    var _this6 = this;

    this.fetchTags().then(function () {
      _this6.fetchNote(_this6.id);
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Notes.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/Notes.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_Navigation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/Navigation */ "./resources/js/notes/components/Navigation.vue");
/* harmony import */ var _components_AlgoliaSearch__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/AlgoliaSearch */ "./resources/js/notes/components/AlgoliaSearch.vue");
/* harmony import */ var _components_NotesList__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/NotesList */ "./resources/js/notes/components/NotesList.vue");
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
  name: "Notes",
  data: function data() {
    return {
      searchQuery: ''
    };
  },
  components: {
    Navigation: _components_Navigation__WEBPACK_IMPORTED_MODULE_0__["default"],
    AlgoliaSearch: _components_AlgoliaSearch__WEBPACK_IMPORTED_MODULE_1__["default"],
    NotesList: _components_NotesList__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  methods: {
    updateMessage: function updateMessage(value) {
      this.searchQuery = value;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.form-control[data-v-a48d80e8] {\n  width: auto;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.loader-text[data-v-56521b1f] {\n  background: #808080;\n  border-radius: 2px;\n}\n.loader-text--1x3[data-v-56521b1f] {\n  width: 33%;\n}\n.note[data-v-56521b1f] .footnotes {\n  font-size: 0.8rem;\n}\n.note[data-v-56521b1f] .footnotes p {\n  margin-bottom: 0.5rem;\n}\n.note[data-v-56521b1f] table.table th[align=\"left\"] {\n  text-align: left;\n}\n.note[data-v-56521b1f] table.table th[align=\"center\"] {\n  text-align: center;\n}\n.note[data-v-56521b1f] table.table th[align=\"right\"] {\n  text-align: right;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\ntextarea[data-v-98580e0a] {\n  outline: 0;\n  background: #f4f4f4;\n  box-shadow: 1px 1px 0 #ccc;\n  border-color: transparent;\n  border-radius: 0;\n  font-family: 'Inconsolata', monospace;\n}\ntextarea[data-v-98580e0a]:focus {\n  box-shadow: 1px 1px 0 #ccc;\n  outline: 0;\n  background: #f4f4f4;\n  border-color: transparent;\n}\n.new-tag-group[data-v-98580e0a] {\n  font-size: 0;\n}\n.new-tag-group .input-new-tag[data-v-98580e0a], .new-tag-group .button-new-tag[data-v-98580e0a] {\n  vertical-align: middle;\n  width: 120px;\n}\n#note-create[data-v-98580e0a] .el-checkbox-button--small .el-checkbox-button__inner {\n  border-radius: 4px;\n  border: 1px solid #DCDFE6;\n}\n#note-create[data-v-98580e0a] .el-checkbox-button.is-checked .el-checkbox-button__inner {\n  border-color: #409EFF;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\ntextarea[data-v-5093e248] {\n  outline: 0;\n  background: #f4f4f4;\n  box-shadow: 1px 1px 0 #ccc;\n  border-color: transparent;\n  border-radius: 0;\n  font-family: 'Inconsolata', monospace;\n}\ntextarea[data-v-5093e248]:focus {\n  box-shadow: 1px 1px 0 #ccc;\n  outline: 0;\n  background: #f4f4f4;\n  border-color: transparent;\n}\n.new-tag-group[data-v-5093e248] {\n  font-size: 0;\n}\n.new-tag-group .input-new-tag[data-v-5093e248], .new-tag-group .button-new-tag[data-v-5093e248] {\n  vertical-align: middle;\n  width: 120px;\n}\n#note-update[data-v-5093e248] .el-checkbox-button--small .el-checkbox-button__inner {\n  border-radius: 4px;\n  border: 1px solid #DCDFE6;\n}\n#note-update[data-v-5093e248] .el-checkbox-button.is-checked .el-checkbox-button__inner {\n  border-color: #409EFF;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css&");

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

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css&");

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

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css&");

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

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css&");

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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=template&id=a48d80e8&scoped=true&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=template&id=a48d80e8&scoped=true& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "col-12 no-gutter-xs", attrs: { id: "algolia-search" } },
    [
      _c("div", { staticClass: "justify-content-center form-inline d-flex" }, [
        _c("label", { staticClass: "sr-only", attrs: { for: "query" } }, [
          _vm._v(_vm._s(_vm.$I18n.trans("notes.search")))
        ]),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.searchQuery,
              expression: "searchQuery"
            }
          ],
          staticClass: "form-control flex-grow-1",
          attrs: {
            type: "text",
            id: "query",
            name: "query",
            placeholder: _vm.$I18n.trans("notes.min_2_chars")
          },
          domProps: { value: _vm.searchQuery },
          on: {
            keyup: function($event) {
              if (
                !$event.type.indexOf("key") &&
                _vm._k($event.keyCode, "esc", 27, $event.key, ["Esc", "Escape"])
              ) {
                return null
              }
              return _vm.clearSearch($event)
            },
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.searchQuery = $event.target.value
            }
          }
        }),
        _vm._v("\n     \n    "),
        _vm._m(0)
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("picture", [
      _c("source", {
        attrs: { srcset: "search-by-algolia.svg", media: "(min-width: 800px)" }
      }),
      _vm._v(" "),
      _c("img", {
        staticStyle: { "max-height": "30px" },
        attrs: { src: "algolia-blue-mark.svg", alt: "search by algolia" }
      })
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/Navigation.vue?vue&type=template&id=24f1f371&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/components/Navigation.vue?vue&type=template&id=24f1f371& ***!
  \*******************************************************************************************************************************************************************************************************************/
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
                class: _vm.activeSubmenu("Notes"),
                attrs: { to: "/" }
              },
              [_vm._v(_vm._s(_vm.$I18n.trans("notes.notes")))]
            ),
            _vm._v(" "),
            _c(
              "router-link",
              {
                staticClass: "btn btn-group-sm w-100",
                class: _vm.activeSubmenu("NoteCreate"),
                attrs: { to: "/new" }
              },
              [_vm._v(_vm._s(_vm.$I18n.trans("notes.new_note")))]
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/NotesList.vue?vue&type=template&id=46cf8e9c&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/components/NotesList.vue?vue&type=template&id=46cf8e9c& ***!
  \******************************************************************************************************************************************************************************************************************/
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
  return _c("div", { attrs: { id: "notes-list" } }, [
    _c(
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
        staticClass: "list-group list-group-flush"
      },
      [
        !_vm.notes.length
          ? _c("el-alert", {
              attrs: {
                title: _vm.$I18n.trans("notes.alert_failed_to_find_records"),
                type: "info",
                center: "",
                "close-text": _vm.$I18n.trans("notes.alert_close_text")
              },
              on: { close: _vm.close }
            })
          : _vm._e(),
        _vm._v(" "),
        _vm._l(_vm.notes, function(note) {
          return _c(
            "li",
            {
              staticClass: "list-group-item list-group-item-action p-2 p-sm-3"
            },
            [
              _c(
                "router-link",
                { staticClass: "text-secondary", attrs: { to: "/" + note.id } },
                [
                  _c(
                    "div",
                    { staticClass: "d-flex w-100 justify-content-between" },
                    [
                      _c("h5", { staticClass: "mb-1" }, [
                        _vm._v(_vm._s(note.title))
                      ]),
                      _vm._v(" "),
                      _c("small", { staticClass: "d-none d-sm-block" }, [
                        _vm._v(_vm._s(_vm._f("diffForHumans")(note.updated_at)))
                      ])
                    ]
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                _vm._l(note.tags, function(tag) {
                  return _c(
                    "el-tag",
                    {
                      key: tag.id,
                      staticClass: "mr-1 mb-1",
                      attrs: { size: "small" }
                    },
                    [_vm._v(_vm._s(tag.name))]
                  )
                }),
                1
              )
            ],
            1
          )
        })
      ],
      2
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Note.vue?vue&type=template&id=56521b1f&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/Note.vue?vue&type=template&id=56521b1f&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************/
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
    { staticClass: "note" },
    [
      _c("navigation"),
      _vm._v(" "),
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
          ],
          staticClass: "row justify-content-center"
        },
        [
          _c("div", { staticClass: "col-12 no-gutter-xs" }, [
            !_vm.note.id
              ? _c("div", { staticClass: "mt-3 " }, [
                  _c("p", { staticClass: "loader-text pb-2 pt-3" }, [
                    _vm._v(" ")
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "loader-text" }, [_vm._v(" ")]),
                  _vm._v(" "),
                  _c("p", { staticClass: "loader-text" }, [_vm._v(" ")]),
                  _vm._v(" "),
                  _c(
                    "p",
                    {
                      staticClass: "loader-text loader-text--1x3 d-inline-block"
                    },
                    [_vm._v("   ")]
                  )
                ])
              : _vm._e(),
            _vm._v(" "),
            _c("div", {
              staticClass: "mt-3",
              domProps: { innerHTML: _vm._s(_vm.note.body) }
            }),
            _vm._v(" "),
            _c(
              "div",
              _vm._l(_vm.note.tags, function(tag) {
                return _c(
                  "el-tag",
                  {
                    key: tag.id,
                    staticClass: "mr-1 mb-1",
                    attrs: { size: "big" }
                  },
                  [_vm._v(_vm._s(tag.name))]
                )
              }),
              1
            )
          ])
        ]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-12" }, [
          _c(
            "div",
            { staticClass: "mt-3" },
            [
              _c(
                "router-link",
                {
                  staticClass: "btn btn-primary",
                  attrs: { to: "/edit/" + _vm.note.id }
                },
                [_vm._v(_vm._s(_vm.$I18n.trans("notes.edit")))]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-danger ml-3",
                  on: {
                    click: function($event) {
                      return _vm.confirmDelete(_vm.note.id)
                    }
                  }
                },
                [_vm._v(_vm._s(_vm.$I18n.trans("notes.delete")))]
              )
            ],
            1
          )
        ])
      ])
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteCreate.vue?vue&type=template&id=98580e0a&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/NoteCreate.vue?vue&type=template&id=98580e0a&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************/
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
    { attrs: { id: "note-create" } },
    [
      _c("navigation"),
      _vm._v(" "),
      _c("div", { staticClass: "row justify-content-center" }, [
        _c("div", { staticClass: "col-sm no-gutter-xs" }, [
          _c("div", { staticClass: "card shadow" }, [
            _vm.errors.length
              ? _c(
                  "div",
                  { staticClass: "p-1" },
                  _vm._l(_vm.errors, function(error) {
                    return _c("el-alert", {
                      key: error.field,
                      attrs: { title: error.text, type: "error" }
                    })
                  }),
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            _c(
              "form",
              { attrs: { method: "post" }, on: { submit: _vm.submitForm } },
              [
                _c("div", { staticClass: "textarea-container" }, [
                  _c("textarea", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.note.body,
                        expression: "note.body"
                      }
                    ],
                    staticClass: "form-control form-text m-0",
                    attrs: {
                      placeholder: _vm.$I18n.trans(
                        "notes.placeholder_note_title"
                      ),
                      name: "body",
                      cols: "100",
                      rows: "15"
                    },
                    domProps: { value: _vm.note.body },
                    on: {
                      keydown: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k($event.keyCode, "tab", 9, $event.key, "Tab")
                        ) {
                          return null
                        }
                        $event.preventDefault()
                        return _vm.textareaCharInserter($event)
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.note, "body", $event.target.value)
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "d-flex justify-content-between" },
                  [
                    _c("small", { staticClass: "form-text text-muted ml-3" }, [
                      _vm._m(0)
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-button",
                      {
                        attrs: { circle: "", size: "small", type: "info" },
                        on: { click: _vm.insertCodeBlockBackTicks }
                      },
                      [_vm._v("```")]
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "mt-3 ml-3" },
                  [
                    _c("p", [
                      _vm._v(_vm._s(_vm.$I18n.trans("notes.tags")) + ":")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-checkbox-group",
                      {
                        staticClass: "d-inline-block",
                        attrs: { size: "small" },
                        model: {
                          value: _vm.selectedTags,
                          callback: function($$v) {
                            _vm.selectedTags = $$v
                          },
                          expression: "selectedTags"
                        }
                      },
                      _vm._l(_vm.tags, function(tag) {
                        return _c(
                          "el-checkbox-button",
                          {
                            key: tag.id,
                            staticClass: "mr-1",
                            attrs: { label: tag.id }
                          },
                          [_vm._v(_vm._s(tag.name))]
                        )
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "d-inline-block new-tag-group" },
                      [
                        _vm.newTagInputVisible
                          ? _c("el-input", {
                              ref: "saveTagInput",
                              staticClass: "input-new-tag",
                              attrs: { size: "small" },
                              on: { blur: _vm.addNewTag },
                              nativeOn: {
                                keyup: function($event) {
                                  if (
                                    !$event.type.indexOf("key") &&
                                    _vm._k(
                                      $event.keyCode,
                                      "enter",
                                      13,
                                      $event.key,
                                      "Enter"
                                    )
                                  ) {
                                    return null
                                  }
                                  return _vm.addNewTag($event)
                                }
                              },
                              model: {
                                value: _vm.newTag,
                                callback: function($$v) {
                                  _vm.newTag = $$v
                                },
                                expression: "newTag"
                              }
                            })
                          : _c(
                              "el-button",
                              {
                                staticClass: "button-new-tag",
                                attrs: {
                                  type: "info",
                                  plain: "",
                                  size: "small"
                                },
                                on: { click: _vm.showInput }
                              },
                              [_vm._v(_vm._s(_vm.$I18n.trans("notes.new_tag")))]
                            )
                      ],
                      1
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c("div", { staticClass: "px-3 pb-3 pt-3" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-primary",
                      attrs: { type: "submit" }
                    },
                    [_vm._v(_vm._s(_vm.$I18n.trans("common.add")))]
                  )
                ])
              ]
            )
          ])
        ])
      ])
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "a",
      {
        staticClass: "text-muted",
        attrs: {
          href: "https://commonmark.org/help/",
          tabindex: "-1",
          target: "_CommonMark"
        }
      },
      [_vm._v(_vm._s(_vm.$I18n.trans("notes.commonmark")))]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteUpdate.vue?vue&type=template&id=5093e248&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/NoteUpdate.vue?vue&type=template&id=5093e248&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************/
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
    { attrs: { id: "note-update" } },
    [
      _c("navigation"),
      _vm._v(" "),
      _c("div", { staticClass: "row justify-content-center" }, [
        _c("div", { staticClass: "col-sm no-gutter-xs" }, [
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
              ],
              staticClass: "card shadow"
            },
            [
              _vm.errors.length
                ? _c(
                    "div",
                    { staticClass: "p-1" },
                    _vm._l(_vm.errors, function(error) {
                      return _c("el-alert", {
                        key: error.field,
                        attrs: { title: error.text, type: "error" }
                      })
                    }),
                    1
                  )
                : _vm._e(),
              _vm._v(" "),
              _c(
                "form",
                { attrs: { method: "post" }, on: { submit: _vm.submitForm } },
                [
                  _c("div", { staticClass: "textarea-container" }, [
                    _c("textarea", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.note.body,
                          expression: "note.body"
                        }
                      ],
                      staticClass: "form-control form-text m-0",
                      attrs: {
                        placeholder: _vm.$I18n.trans(
                          "notes.placeholder_note_title"
                        ),
                        name: "body",
                        cols: "100",
                        rows: "15"
                      },
                      domProps: { value: _vm.note.body },
                      on: {
                        keydown: function($event) {
                          if (
                            !$event.type.indexOf("key") &&
                            _vm._k($event.keyCode, "tab", 9, $event.key, "Tab")
                          ) {
                            return null
                          }
                          $event.preventDefault()
                          return _vm.textareaCharInserter($event)
                        },
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.note, "body", $event.target.value)
                        }
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "d-flex justify-content-between" },
                    [
                      _c(
                        "small",
                        { staticClass: "form-text text-muted ml-3" },
                        [_vm._m(0)]
                      ),
                      _vm._v(" "),
                      _c(
                        "el-button",
                        {
                          attrs: { circle: "", size: "small", type: "info" },
                          on: { click: _vm.insertCodeBlockBackTicks }
                        },
                        [_vm._v("```")]
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "mt-3 ml-3" },
                    [
                      _c("p", [_vm._v("Tags:")]),
                      _vm._v(" "),
                      _c(
                        "el-checkbox-group",
                        {
                          staticClass: "d-inline-block",
                          attrs: { size: "small" },
                          model: {
                            value: _vm.selectedTags,
                            callback: function($$v) {
                              _vm.selectedTags = $$v
                            },
                            expression: "selectedTags"
                          }
                        },
                        _vm._l(_vm.tags, function(tag) {
                          return _c(
                            "el-checkbox-button",
                            {
                              key: tag.id,
                              staticClass: "mr-1",
                              attrs: { label: tag.id }
                            },
                            [_vm._v(_vm._s(tag.name))]
                          )
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "d-inline-block new-tag-group" },
                        [
                          _vm.newTagInputVisible
                            ? _c("el-input", {
                                ref: "saveTagInput",
                                staticClass: "input-new-tag",
                                attrs: { size: "small" },
                                on: { blur: _vm.addNewTag },
                                nativeOn: {
                                  keyup: function($event) {
                                    if (
                                      !$event.type.indexOf("key") &&
                                      _vm._k(
                                        $event.keyCode,
                                        "enter",
                                        13,
                                        $event.key,
                                        "Enter"
                                      )
                                    ) {
                                      return null
                                    }
                                    return _vm.addNewTag($event)
                                  }
                                },
                                model: {
                                  value: _vm.newTag,
                                  callback: function($$v) {
                                    _vm.newTag = $$v
                                  },
                                  expression: "newTag"
                                }
                              })
                            : _c(
                                "el-button",
                                {
                                  staticClass: "button-new-tag",
                                  attrs: {
                                    type: "info",
                                    plain: "",
                                    size: "small"
                                  },
                                  on: { click: _vm.showInput }
                                },
                                [
                                  _vm._v(
                                    _vm._s(_vm.$I18n.trans("notes.new_tag"))
                                  )
                                ]
                              )
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "px-3 pb-3 pt-3" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-primary",
                        attrs: { type: "submit" }
                      },
                      [_vm._v(_vm._s(_vm.$I18n.trans("common.add")))]
                    )
                  ])
                ]
              )
            ]
          )
        ])
      ])
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "a",
      {
        staticClass: "text-muted",
        attrs: {
          href: "https://commonmark.org/help/",
          tabindex: "-1",
          target: "_CommonMark"
        }
      },
      [_vm._v(_vm._s(_vm.$I18n.trans("notes.commonmark")))]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Notes.vue?vue&type=template&id=779ce9e4&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/notes/views/Notes.vue?vue&type=template&id=779ce9e4& ***!
  \*********************************************************************************************************************************************************************************************************/
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
    { attrs: { id: "notes" } },
    [
      _c("navigation"),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "row justify-content-center" },
        [_c("algolia-search", { on: { inputData: _vm.updateMessage } })],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-12 mt-3 no-gutter-xs" },
          [
            _c("notes-list", {
              attrs: { "search-query": _vm.searchQuery },
              on: { inputData: _vm.updateMessage }
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

/***/ "./resources/js/notes/app.js":
/*!***********************************!*\
  !*** ./resources/js/notes/app.js ***!
  \***********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _bootstrap__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../bootstrap */ "./resources/js/bootstrap.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./router */ "./resources/js/notes/router.js");
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! element-ui */ "./node_modules/element-ui/lib/element-ui.common.js");
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(element_ui__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! element-ui/lib/theme-chalk/index.css */ "./node_modules/element-ui/lib/theme-chalk/index.css");
/* harmony import */ var element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _filters__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../filters */ "./resources/js/filters.js");
/* harmony import */ var _vendor_I18n__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../vendor/I18n */ "./resources/js/vendor/I18n.js");
/* harmony import */ var _components_MainNavigation__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../components/MainNavigation */ "./resources/js/components/MainNavigation.vue");








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

vue__WEBPACK_IMPORTED_MODULE_1___default.a.component('main-navigation', _components_MainNavigation__WEBPACK_IMPORTED_MODULE_7__["default"]);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

vue__WEBPACK_IMPORTED_MODULE_1___default.a.use(element_ui__WEBPACK_IMPORTED_MODULE_3___default.a);
vue__WEBPACK_IMPORTED_MODULE_1___default.a.prototype.$I18n = new _vendor_I18n__WEBPACK_IMPORTED_MODULE_6__["default"]();
new vue__WEBPACK_IMPORTED_MODULE_1___default.a({
  router: _router__WEBPACK_IMPORTED_MODULE_2__["default"],
  el: '#app'
});

/***/ }),

/***/ "./resources/js/notes/components/AlgoliaSearch.vue":
/*!*********************************************************!*\
  !*** ./resources/js/notes/components/AlgoliaSearch.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AlgoliaSearch_vue_vue_type_template_id_a48d80e8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AlgoliaSearch.vue?vue&type=template&id=a48d80e8&scoped=true& */ "./resources/js/notes/components/AlgoliaSearch.vue?vue&type=template&id=a48d80e8&scoped=true&");
/* harmony import */ var _AlgoliaSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AlgoliaSearch.vue?vue&type=script&lang=js& */ "./resources/js/notes/components/AlgoliaSearch.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _AlgoliaSearch_vue_vue_type_style_index_0_id_a48d80e8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css& */ "./resources/js/notes/components/AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _AlgoliaSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AlgoliaSearch_vue_vue_type_template_id_a48d80e8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _AlgoliaSearch_vue_vue_type_template_id_a48d80e8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "a48d80e8",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/notes/components/AlgoliaSearch.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/notes/components/AlgoliaSearch.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/notes/components/AlgoliaSearch.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AlgoliaSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./AlgoliaSearch.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AlgoliaSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/notes/components/AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/notes/components/AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css& ***!
  \******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AlgoliaSearch_vue_vue_type_style_index_0_id_a48d80e8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=style&index=0&id=a48d80e8&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AlgoliaSearch_vue_vue_type_style_index_0_id_a48d80e8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AlgoliaSearch_vue_vue_type_style_index_0_id_a48d80e8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AlgoliaSearch_vue_vue_type_style_index_0_id_a48d80e8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AlgoliaSearch_vue_vue_type_style_index_0_id_a48d80e8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AlgoliaSearch_vue_vue_type_style_index_0_id_a48d80e8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/notes/components/AlgoliaSearch.vue?vue&type=template&id=a48d80e8&scoped=true&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/notes/components/AlgoliaSearch.vue?vue&type=template&id=a48d80e8&scoped=true& ***!
  \****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AlgoliaSearch_vue_vue_type_template_id_a48d80e8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./AlgoliaSearch.vue?vue&type=template&id=a48d80e8&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/AlgoliaSearch.vue?vue&type=template&id=a48d80e8&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AlgoliaSearch_vue_vue_type_template_id_a48d80e8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AlgoliaSearch_vue_vue_type_template_id_a48d80e8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/notes/components/Navigation.vue":
/*!******************************************************!*\
  !*** ./resources/js/notes/components/Navigation.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Navigation_vue_vue_type_template_id_24f1f371___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Navigation.vue?vue&type=template&id=24f1f371& */ "./resources/js/notes/components/Navigation.vue?vue&type=template&id=24f1f371&");
/* harmony import */ var _Navigation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Navigation.vue?vue&type=script&lang=js& */ "./resources/js/notes/components/Navigation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Navigation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Navigation_vue_vue_type_template_id_24f1f371___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Navigation_vue_vue_type_template_id_24f1f371___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/notes/components/Navigation.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/notes/components/Navigation.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/notes/components/Navigation.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Navigation.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/Navigation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/notes/components/Navigation.vue?vue&type=template&id=24f1f371&":
/*!*************************************************************************************!*\
  !*** ./resources/js/notes/components/Navigation.vue?vue&type=template&id=24f1f371& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_template_id_24f1f371___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Navigation.vue?vue&type=template&id=24f1f371& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/Navigation.vue?vue&type=template&id=24f1f371&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_template_id_24f1f371___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navigation_vue_vue_type_template_id_24f1f371___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/notes/components/NotesList.vue":
/*!*****************************************************!*\
  !*** ./resources/js/notes/components/NotesList.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _NotesList_vue_vue_type_template_id_46cf8e9c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NotesList.vue?vue&type=template&id=46cf8e9c& */ "./resources/js/notes/components/NotesList.vue?vue&type=template&id=46cf8e9c&");
/* harmony import */ var _NotesList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NotesList.vue?vue&type=script&lang=js& */ "./resources/js/notes/components/NotesList.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _NotesList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _NotesList_vue_vue_type_template_id_46cf8e9c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _NotesList_vue_vue_type_template_id_46cf8e9c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/notes/components/NotesList.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/notes/components/NotesList.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/notes/components/NotesList.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NotesList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./NotesList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/NotesList.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NotesList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/notes/components/NotesList.vue?vue&type=template&id=46cf8e9c&":
/*!************************************************************************************!*\
  !*** ./resources/js/notes/components/NotesList.vue?vue&type=template&id=46cf8e9c& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NotesList_vue_vue_type_template_id_46cf8e9c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./NotesList.vue?vue&type=template&id=46cf8e9c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/components/NotesList.vue?vue&type=template&id=46cf8e9c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NotesList_vue_vue_type_template_id_46cf8e9c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NotesList_vue_vue_type_template_id_46cf8e9c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/notes/mixins/textareaCharInserter.js":
/*!***********************************************************!*\
  !*** ./resources/js/notes/mixins/textareaCharInserter.js ***!
  \***********************************************************/
/*! exports provided: TextareaCharInserter */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TextareaCharInserter", function() { return TextareaCharInserter; });
var TextareaCharInserter = {
  methods: {
    textareaCharInserter: function textareaCharInserter(event) {
      var tabChar = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '  ';
      event.preventDefault();
      var text = this.note.body;
      var originalPosition = event.target.selectionStart;
      var textStart = text.slice(0, originalPosition);
      var textEnd = text.slice(originalPosition);
      this.note.body = "".concat(textStart).concat(tabChar).concat(textEnd);
      event.target.value = this.note.body;
      event.target.selectionEnd = event.target.selectionStart = originalPosition + 1;
    }
  }
};

/***/ }),

/***/ "./resources/js/notes/router.js":
/*!**************************************!*\
  !*** ./resources/js/notes/router.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-router */ "./node_modules/vue-router/dist/vue-router.esm.js");
/* harmony import */ var _views_Notes__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./views/Notes */ "./resources/js/notes/views/Notes.vue");
/* harmony import */ var _views_Note__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./views/Note */ "./resources/js/notes/views/Note.vue");
/* harmony import */ var _views_NoteCreate__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./views/NoteCreate */ "./resources/js/notes/views/NoteCreate.vue");
/* harmony import */ var _views_NoteUpdate__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./views/NoteUpdate */ "./resources/js/notes/views/NoteUpdate.vue");






vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vue_router__WEBPACK_IMPORTED_MODULE_1__["default"]);
/* harmony default export */ __webpack_exports__["default"] = (new vue_router__WEBPACK_IMPORTED_MODULE_1__["default"]({
  routes: [{
    path: '/',
    name: 'Notes',
    component: _views_Notes__WEBPACK_IMPORTED_MODULE_2__["default"]
  }, {
    path: '/new',
    name: 'NoteCreate',
    component: _views_NoteCreate__WEBPACK_IMPORTED_MODULE_4__["default"]
  }, {
    path: '/edit/:id',
    name: 'NoteUpdate',
    component: _views_NoteUpdate__WEBPACK_IMPORTED_MODULE_5__["default"],
    props: true
  }, {
    path: '/:id',
    name: 'Note',
    component: _views_Note__WEBPACK_IMPORTED_MODULE_3__["default"],
    props: true
  }]
}));

/***/ }),

/***/ "./resources/js/notes/views/Note.vue":
/*!*******************************************!*\
  !*** ./resources/js/notes/views/Note.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Note_vue_vue_type_template_id_56521b1f_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Note.vue?vue&type=template&id=56521b1f&scoped=true& */ "./resources/js/notes/views/Note.vue?vue&type=template&id=56521b1f&scoped=true&");
/* harmony import */ var _Note_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Note.vue?vue&type=script&lang=js& */ "./resources/js/notes/views/Note.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _Note_vue_vue_type_style_index_0_id_56521b1f_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css& */ "./resources/js/notes/views/Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Note_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Note_vue_vue_type_template_id_56521b1f_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Note_vue_vue_type_template_id_56521b1f_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "56521b1f",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/notes/views/Note.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/notes/views/Note.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/notes/views/Note.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Note_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Note.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Note.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Note_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/notes/views/Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/notes/views/Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css& ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Note_vue_vue_type_style_index_0_id_56521b1f_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Note.vue?vue&type=style&index=0&id=56521b1f&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Note_vue_vue_type_style_index_0_id_56521b1f_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Note_vue_vue_type_style_index_0_id_56521b1f_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Note_vue_vue_type_style_index_0_id_56521b1f_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Note_vue_vue_type_style_index_0_id_56521b1f_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Note_vue_vue_type_style_index_0_id_56521b1f_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/notes/views/Note.vue?vue&type=template&id=56521b1f&scoped=true&":
/*!**************************************************************************************!*\
  !*** ./resources/js/notes/views/Note.vue?vue&type=template&id=56521b1f&scoped=true& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Note_vue_vue_type_template_id_56521b1f_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Note.vue?vue&type=template&id=56521b1f&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Note.vue?vue&type=template&id=56521b1f&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Note_vue_vue_type_template_id_56521b1f_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Note_vue_vue_type_template_id_56521b1f_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/notes/views/NoteCreate.vue":
/*!*************************************************!*\
  !*** ./resources/js/notes/views/NoteCreate.vue ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _NoteCreate_vue_vue_type_template_id_98580e0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NoteCreate.vue?vue&type=template&id=98580e0a&scoped=true& */ "./resources/js/notes/views/NoteCreate.vue?vue&type=template&id=98580e0a&scoped=true&");
/* harmony import */ var _NoteCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NoteCreate.vue?vue&type=script&lang=js& */ "./resources/js/notes/views/NoteCreate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _NoteCreate_vue_vue_type_style_index_0_id_98580e0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css& */ "./resources/js/notes/views/NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _NoteCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _NoteCreate_vue_vue_type_template_id_98580e0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _NoteCreate_vue_vue_type_template_id_98580e0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "98580e0a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/notes/views/NoteCreate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/notes/views/NoteCreate.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/notes/views/NoteCreate.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./NoteCreate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteCreate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/notes/views/NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/notes/views/NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css& ***!
  \**********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteCreate_vue_vue_type_style_index_0_id_98580e0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteCreate.vue?vue&type=style&index=0&id=98580e0a&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteCreate_vue_vue_type_style_index_0_id_98580e0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteCreate_vue_vue_type_style_index_0_id_98580e0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteCreate_vue_vue_type_style_index_0_id_98580e0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteCreate_vue_vue_type_style_index_0_id_98580e0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteCreate_vue_vue_type_style_index_0_id_98580e0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/notes/views/NoteCreate.vue?vue&type=template&id=98580e0a&scoped=true&":
/*!********************************************************************************************!*\
  !*** ./resources/js/notes/views/NoteCreate.vue?vue&type=template&id=98580e0a&scoped=true& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteCreate_vue_vue_type_template_id_98580e0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./NoteCreate.vue?vue&type=template&id=98580e0a&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteCreate.vue?vue&type=template&id=98580e0a&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteCreate_vue_vue_type_template_id_98580e0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteCreate_vue_vue_type_template_id_98580e0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/notes/views/NoteUpdate.vue":
/*!*************************************************!*\
  !*** ./resources/js/notes/views/NoteUpdate.vue ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _NoteUpdate_vue_vue_type_template_id_5093e248_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NoteUpdate.vue?vue&type=template&id=5093e248&scoped=true& */ "./resources/js/notes/views/NoteUpdate.vue?vue&type=template&id=5093e248&scoped=true&");
/* harmony import */ var _NoteUpdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NoteUpdate.vue?vue&type=script&lang=js& */ "./resources/js/notes/views/NoteUpdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _NoteUpdate_vue_vue_type_style_index_0_id_5093e248_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css& */ "./resources/js/notes/views/NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _NoteUpdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _NoteUpdate_vue_vue_type_template_id_5093e248_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _NoteUpdate_vue_vue_type_template_id_5093e248_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "5093e248",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/notes/views/NoteUpdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/notes/views/NoteUpdate.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/notes/views/NoteUpdate.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteUpdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./NoteUpdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteUpdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteUpdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/notes/views/NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/notes/views/NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css& ***!
  \**********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteUpdate_vue_vue_type_style_index_0_id_5093e248_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteUpdate.vue?vue&type=style&index=0&id=5093e248&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteUpdate_vue_vue_type_style_index_0_id_5093e248_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteUpdate_vue_vue_type_style_index_0_id_5093e248_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteUpdate_vue_vue_type_style_index_0_id_5093e248_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteUpdate_vue_vue_type_style_index_0_id_5093e248_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteUpdate_vue_vue_type_style_index_0_id_5093e248_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/notes/views/NoteUpdate.vue?vue&type=template&id=5093e248&scoped=true&":
/*!********************************************************************************************!*\
  !*** ./resources/js/notes/views/NoteUpdate.vue?vue&type=template&id=5093e248&scoped=true& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteUpdate_vue_vue_type_template_id_5093e248_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./NoteUpdate.vue?vue&type=template&id=5093e248&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/NoteUpdate.vue?vue&type=template&id=5093e248&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteUpdate_vue_vue_type_template_id_5093e248_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NoteUpdate_vue_vue_type_template_id_5093e248_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/notes/views/Notes.vue":
/*!********************************************!*\
  !*** ./resources/js/notes/views/Notes.vue ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Notes_vue_vue_type_template_id_779ce9e4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Notes.vue?vue&type=template&id=779ce9e4& */ "./resources/js/notes/views/Notes.vue?vue&type=template&id=779ce9e4&");
/* harmony import */ var _Notes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Notes.vue?vue&type=script&lang=js& */ "./resources/js/notes/views/Notes.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Notes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Notes_vue_vue_type_template_id_779ce9e4___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Notes_vue_vue_type_template_id_779ce9e4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/notes/views/Notes.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/notes/views/Notes.vue?vue&type=script&lang=js&":
/*!*********************************************************************!*\
  !*** ./resources/js/notes/views/Notes.vue?vue&type=script&lang=js& ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Notes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Notes.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Notes.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Notes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/notes/views/Notes.vue?vue&type=template&id=779ce9e4&":
/*!***************************************************************************!*\
  !*** ./resources/js/notes/views/Notes.vue?vue&type=template&id=779ce9e4& ***!
  \***************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Notes_vue_vue_type_template_id_779ce9e4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Notes.vue?vue&type=template&id=779ce9e4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/notes/views/Notes.vue?vue&type=template&id=779ce9e4&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Notes_vue_vue_type_template_id_779ce9e4___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Notes_vue_vue_type_template_id_779ce9e4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ 1:
/*!*****************************************!*\
  !*** multi ./resources/js/notes/app.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/resources/js/notes/app.js */"./resources/js/notes/app.js");


/***/ })

},[[1,"/js/manifest","/js/vendor"]]]);