(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_admin_components_users_UsersList_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/users/UsersList.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/users/UsersList.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _mixins__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../mixins */ "./resources/js/admin/mixins.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../helpers */ "./resources/js/admin/helpers.js");
/* harmony import */ var _addresses_AddressList_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../addresses/AddressList.vue */ "./resources/js/admin/components/addresses/AddressList.vue");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  mixins: [_mixins__WEBPACK_IMPORTED_MODULE_1__.dataTableMixin],
  components: {
    AddressList: _addresses_AddressList_vue__WEBPACK_IMPORTED_MODULE_4__.default
  },
  data: function data() {
    return {
      selectedItems: [],
      allSelected: false,
      clickedUserId: null
    };
  },
  watch: {
    selectedItems: function selectedItems() {
      this.allSelected = this.selectedItems.length === this.allUsers.length ? true : false;
    }
  },
  computed: _objectSpread({
    getIsLoading: function getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading: function postIsLoading() {
      return this.isLoading["post"];
    }
  }, (0,vuex__WEBPACK_IMPORTED_MODULE_2__.mapGetters)("users", ["allUsers", "isLoading"])),
  methods: _objectSpread({
    handleClickAddressBtn: function handleClickAddressBtn(userId) {
      this.clickedUserId = userId;
    },
    selectOrUnSelectAll: function selectOrUnSelectAll() {
      var _this = this;

      if (this.allSelected) {
        this.selectedItems = [];
      } else {
        this.allUsers.forEach(function (user) {
          _this.selectedItems.push(user.id);
        });
      }
    },
    prepareBulkDeleteUsers: function prepareBulkDeleteUsers() {
      var _this2 = this;

      if (!this.selectedItems.length) {
        return;
      }

      (0,_helpers__WEBPACK_IMPORTED_MODULE_3__.fireConfirm)( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this2.bulkDeleteUsers(_this2.selectedItems);

              case 2:
                _this2.selectedItems = [];

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      })));
    }
  }, (0,vuex__WEBPACK_IMPORTED_MODULE_2__.mapActions)("users", ["fetchUsers", "deleteUser", "bulkDeleteUsers"])),
  created: function created() {
    this.fetchUsers();
  }
});

/***/ }),

/***/ "./resources/js/admin/mixins.js":
/*!**************************************!*\
  !*** ./resources/js/admin/mixins.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "dataTableMixin": () => (/* binding */ dataTableMixin),
/* harmony export */   "orderStatusMixin": () => (/* binding */ orderStatusMixin)
/* harmony export */ });

var dataTableMixin = {
  data: function data() {
    return {
      dtTable: null
    };
  },
  beforeUpdate: function beforeUpdate() {
    if (this.dtTable) {
      this.dtTable.destroy();
    }
  },
  updated: function updated() {
    this.dtTable = $("#dataTable").DataTable({
      order: [[0, "desc"]]
    });
  }
};
var orderStatusMixin = {
  data: function data() {
    return {
      statuses: ["pending", "processing", "out_for_delivery", "delivered", "cancelled", "failed"]
    };
  },
  methods: {
    customMultiselectLabel: function customMultiselectLabel(option) {
      return translate("admin." + option);
    },
    bindStatusClass: function bindStatusClass(status, element) {
      switch (true) {
        case ["pending", "processing", "out_for_delivery"].includes(status):
          if (element == "badge" && status == "pending") {
            return "badge-secondary";
          }

          return element == "icon" ? "fa-clock" : "badge-info";

        case ["cancelled", "failed"].includes(status):
          return element == "icon" ? "fa-times" : "badge-danger";

        case ["delivered"].includes(status):
          return element == "icon" ? "fa-check" : "badge-success";
      }
    }
  }
};

/***/ }),

/***/ "./resources/js/admin/components/users/UsersList.vue":
/*!***********************************************************!*\
  !*** ./resources/js/admin/components/users/UsersList.vue ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _UsersList_vue_vue_type_template_id_5ce2b2b8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./UsersList.vue?vue&type=template&id=5ce2b2b8& */ "./resources/js/admin/components/users/UsersList.vue?vue&type=template&id=5ce2b2b8&");
/* harmony import */ var _UsersList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./UsersList.vue?vue&type=script&lang=js& */ "./resources/js/admin/components/users/UsersList.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _UsersList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _UsersList_vue_vue_type_template_id_5ce2b2b8___WEBPACK_IMPORTED_MODULE_0__.render,
  _UsersList_vue_vue_type_template_id_5ce2b2b8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/admin/components/users/UsersList.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/admin/components/users/UsersList.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/admin/components/users/UsersList.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./UsersList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/users/UsersList.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/admin/components/users/UsersList.vue?vue&type=template&id=5ce2b2b8&":
/*!******************************************************************************************!*\
  !*** ./resources/js/admin/components/users/UsersList.vue?vue&type=template&id=5ce2b2b8& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersList_vue_vue_type_template_id_5ce2b2b8___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersList_vue_vue_type_template_id_5ce2b2b8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersList_vue_vue_type_template_id_5ce2b2b8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./UsersList.vue?vue&type=template&id=5ce2b2b8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/users/UsersList.vue?vue&type=template&id=5ce2b2b8&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/users/UsersList.vue?vue&type=template&id=5ce2b2b8&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/users/UsersList.vue?vue&type=template&id=5ce2b2b8& ***!
  \*********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "container-fluid" },
    [
      _vm.clickedUserId
        ? _c("address-list", {
            attrs: { "user-id": _vm.clickedUserId, "apply-front-theme": false }
          })
        : _vm._e(),
      _vm._v(" "),
      _c("the-breadcrumb", [
        _c("li", { staticClass: "breadcrumb-item active" }, [
          _vm._v(_vm._s(_vm.translate("admin.users")))
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-12" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "d-flex" }, [
              _c(
                "div",
                {
                  staticClass:
                    "card-header card-header-icon card-header-warning",
                  staticStyle: { "flex-grow": "1 !important" }
                },
                [
                  _vm._m(0),
                  _vm._v(" "),
                  _c("h4", { staticClass: "card-title" }, [
                    _vm._v(
                      "\n              " +
                        _vm._s(_vm.translate("admin.users") + " Table") +
                        "\n            "
                    )
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "mt-2" },
                [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-danger",
                      attrs: { disabled: _vm.postIsLoading },
                      on: { click: _vm.prepareBulkDeleteUsers }
                    },
                    [
                      _c("span", [
                        _vm.postIsLoading
                          ? _c("i", {
                              staticClass: "fa fa-circle-notch fa-spin"
                            })
                          : _c("i", { staticClass: "fa fa-dumpster" }),
                        _vm._v(
                          "\n                " +
                            _vm._s(_vm.translate("admin.delete")) +
                            "\n              "
                        )
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "router-link",
                    { attrs: { to: { name: "users.create" } } },
                    [
                      _c(
                        "button",
                        { staticClass: "btn btn-outline-success mr-2" },
                        [
                          _c("i", { staticClass: "fa fa-plus-circle" }),
                          _vm._v(" "),
                          _c("span", [
                            _vm._v(
                              "\n                  " +
                                _vm._s(
                                  _vm.translate("admin.add") +
                                    " " +
                                    _vm.translate("admin.user")
                                )
                            )
                          ])
                        ]
                      )
                    ]
                  )
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "card-body" }, [
              _c("div", { staticClass: "table-responsive" }, [
                _c(
                  "table",
                  {
                    staticClass: "table table-striped table-hover",
                    attrs: { id: "dataTable" }
                  },
                  [
                    _c("thead", [
                      _c("tr", [
                        !_vm.getIsLoading
                          ? _c("th", [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.allSelected,
                                    expression: "allSelected"
                                  }
                                ],
                                attrs: { type: "checkbox" },
                                domProps: {
                                  checked: Array.isArray(_vm.allSelected)
                                    ? _vm._i(_vm.allSelected, null) > -1
                                    : _vm.allSelected
                                },
                                on: {
                                  click: _vm.selectOrUnSelectAll,
                                  change: function($event) {
                                    var $$a = _vm.allSelected,
                                      $$el = $event.target,
                                      $$c = $$el.checked ? true : false
                                    if (Array.isArray($$a)) {
                                      var $$v = null,
                                        $$i = _vm._i($$a, $$v)
                                      if ($$el.checked) {
                                        $$i < 0 &&
                                          (_vm.allSelected = $$a.concat([$$v]))
                                      } else {
                                        $$i > -1 &&
                                          (_vm.allSelected = $$a
                                            .slice(0, $$i)
                                            .concat($$a.slice($$i + 1)))
                                      }
                                    } else {
                                      _vm.allSelected = $$c
                                    }
                                  }
                                }
                              })
                            ])
                          : _vm._e(),
                        _vm._v(" "),
                        _c("th", [_vm._v("ID")]),
                        _vm._v(" "),
                        _c("th", [_vm._v(_vm._s(_vm.translate("admin.name")))]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Email")]),
                        _vm._v(" "),
                        _c("th", [
                          _vm._v(_vm._s(_vm.translate("admin.phone")))
                        ]),
                        _vm._v(" "),
                        _c("th", [
                          _vm._v(_vm._s(_vm.translate("admin.roles")))
                        ]),
                        _vm._v(" "),
                        _c("th", [
                          _vm._v(_vm._s(_vm.translate("admin.joinedAt")))
                        ]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Actions")])
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      [
                        _vm.getIsLoading
                          ? _c("tr", [
                              _c(
                                "td",
                                {
                                  staticClass: "text-center",
                                  attrs: { colspan: "8" }
                                },
                                [
                                  _c("loading", {
                                    attrs: {
                                      loader: "dots",
                                      color: "#2B51C4",
                                      active: _vm.getIsLoading,
                                      "is-full-page": false,
                                      width: 80,
                                      height: 200
                                    },
                                    on: {
                                      "update:active": function($event) {
                                        _vm.getIsLoading = $event
                                      }
                                    }
                                  })
                                ],
                                1
                              )
                            ])
                          : _vm._l(_vm.allUsers, function(user) {
                              return _c("tr", { key: user.id }, [
                                _c("td", [
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: _vm.selectedItems,
                                        expression: "selectedItems"
                                      }
                                    ],
                                    attrs: { type: "checkbox" },
                                    domProps: {
                                      value: user.id,
                                      checked: Array.isArray(_vm.selectedItems)
                                        ? _vm._i(_vm.selectedItems, user.id) >
                                          -1
                                        : _vm.selectedItems
                                    },
                                    on: {
                                      change: function($event) {
                                        var $$a = _vm.selectedItems,
                                          $$el = $event.target,
                                          $$c = $$el.checked ? true : false
                                        if (Array.isArray($$a)) {
                                          var $$v = user.id,
                                            $$i = _vm._i($$a, $$v)
                                          if ($$el.checked) {
                                            $$i < 0 &&
                                              (_vm.selectedItems = $$a.concat([
                                                $$v
                                              ]))
                                          } else {
                                            $$i > -1 &&
                                              (_vm.selectedItems = $$a
                                                .slice(0, $$i)
                                                .concat($$a.slice($$i + 1)))
                                          }
                                        } else {
                                          _vm.selectedItems = $$c
                                        }
                                      }
                                    }
                                  })
                                ]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(user.id))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(user.name))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(user.email))]),
                                _vm._v(" "),
                                _c("td", [
                                  _c("h4", [
                                    _c(
                                      "span",
                                      { staticClass: "badge badge-info" },
                                      [_vm._v(" " + _vm._s(user.phone))]
                                    )
                                  ])
                                ]),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  _vm._l(user.roles, function(role) {
                                    return _c(
                                      "span",
                                      {
                                        key: role.id,
                                        staticClass: "badge badge-success"
                                      },
                                      [
                                        _vm._v(
                                          _vm._s(
                                            _vm.translate("admin." + role.name)
                                          )
                                        )
                                      ]
                                    )
                                  }),
                                  0
                                ),
                                _vm._v(" "),
                                _c("td", [
                                  _vm._v(
                                    _vm._s(
                                      _vm._f("formatDate")(user.created_at)
                                    )
                                  )
                                ]),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  [
                                    _c(
                                      "a",
                                      {
                                        staticClass: "mr-4",
                                        attrs: {
                                          href: "#",
                                          "data-toggle": "modal",
                                          "data-target": "#addressListModal"
                                        },
                                        on: {
                                          click: function($event) {
                                            $event.preventDefault()
                                            return _vm.handleClickAddressBtn(
                                              user.id
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass:
                                            "fa fa-map-marker-alt text-info"
                                        })
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "router-link",
                                      {
                                        staticClass: "mr-4",
                                        attrs: {
                                          to: {
                                            name: "users.edit",
                                            params: { id: user.id }
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass: "fa fa-pen text-success"
                                        })
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "a",
                                      {
                                        attrs: { href: "#" },
                                        on: {
                                          click: function($event) {
                                            $event.preventDefault()
                                            return _vm.deleteUser(user.id)
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass: "fa fa-trash text-danger"
                                        })
                                      ]
                                    )
                                  ],
                                  1
                                )
                              ])
                            })
                      ],
                      2
                    )
                  ]
                )
              ])
            ])
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
    return _c("div", { staticClass: "card-icon card-icon-custom" }, [
      _c("i", { staticClass: "material-icons" }, [_vm._v("people")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);