(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_admin_components_extras_ExtrasList_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/extras/ExtrasList.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/extras/ExtrasList.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************/
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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  mixins: [_mixins__WEBPACK_IMPORTED_MODULE_1__.dataTableMixin],
  data: function data() {
    return {
      selectedItems: [],
      allSelected: false
    };
  },
  watch: {
    selectedItems: function selectedItems() {
      this.allSelected = this.selectedItems.length === this.allExtras.length ? true : false;
    }
  },
  computed: _objectSpread({
    getIsLoading: function getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading: function postIsLoading() {
      return this.isLoading["post"];
    }
  }, (0,vuex__WEBPACK_IMPORTED_MODULE_2__.mapGetters)("extras", ["allExtras", "isLoading"])),
  methods: _objectSpread({
    selectOrUnSelectAll: function selectOrUnSelectAll() {
      var _this = this;

      if (this.allSelected) {
        this.selectedItems = [];
      } else {
        this.allExtras.forEach(function (extra) {
          _this.selectedItems.push(extra.id);
        });
      }
    },
    prepareBulkDeleteExtras: function prepareBulkDeleteExtras() {
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
                return _this2.bulkDeleteExtras(_this2.selectedItems);

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
  }, (0,vuex__WEBPACK_IMPORTED_MODULE_2__.mapActions)("extras", ["fetchExtras", "deleteExtra", "bulkDeleteExtras"])),
  created: function created() {
    this.fetchExtras();
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

/***/ "./resources/js/admin/components/extras/ExtrasList.vue":
/*!*************************************************************!*\
  !*** ./resources/js/admin/components/extras/ExtrasList.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ExtrasList_vue_vue_type_template_id_23b0fdf2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ExtrasList.vue?vue&type=template&id=23b0fdf2& */ "./resources/js/admin/components/extras/ExtrasList.vue?vue&type=template&id=23b0fdf2&");
/* harmony import */ var _ExtrasList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ExtrasList.vue?vue&type=script&lang=js& */ "./resources/js/admin/components/extras/ExtrasList.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ExtrasList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ExtrasList_vue_vue_type_template_id_23b0fdf2___WEBPACK_IMPORTED_MODULE_0__.render,
  _ExtrasList_vue_vue_type_template_id_23b0fdf2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/admin/components/extras/ExtrasList.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/admin/components/extras/ExtrasList.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/admin/components/extras/ExtrasList.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ExtrasList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ExtrasList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/extras/ExtrasList.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ExtrasList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/admin/components/extras/ExtrasList.vue?vue&type=template&id=23b0fdf2&":
/*!********************************************************************************************!*\
  !*** ./resources/js/admin/components/extras/ExtrasList.vue?vue&type=template&id=23b0fdf2& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ExtrasList_vue_vue_type_template_id_23b0fdf2___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ExtrasList_vue_vue_type_template_id_23b0fdf2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ExtrasList_vue_vue_type_template_id_23b0fdf2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ExtrasList.vue?vue&type=template&id=23b0fdf2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/extras/ExtrasList.vue?vue&type=template&id=23b0fdf2&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/extras/ExtrasList.vue?vue&type=template&id=23b0fdf2&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/components/extras/ExtrasList.vue?vue&type=template&id=23b0fdf2& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
      _c("the-breadcrumb", [
        _c("li", { staticClass: "breadcrumb-item active" }, [
          _vm._v(_vm._s(_vm.translate("admin.extras")))
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
                        _vm._s(_vm.translate("admin.extras") + " Table") +
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
                      on: { click: _vm.prepareBulkDeleteExtras }
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
                    { attrs: { to: { name: "extras.create" } } },
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
                                    _vm.translate("admin.extra")
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
                        _c("th", [_vm._v("Label")]),
                        _vm._v(" "),
                        _c("th", [
                          _vm._v(_vm._s(_vm.translate("admin.title")))
                        ]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Options")]),
                        _vm._v(" "),
                        _c("th", [
                          _vm._v(_vm._s(_vm.translate("admin.createdAt")))
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
                          : _vm._l(_vm.allExtras, function(extra) {
                              return _c("tr", { key: extra.id }, [
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
                                      value: extra.id,
                                      checked: Array.isArray(_vm.selectedItems)
                                        ? _vm._i(_vm.selectedItems, extra.id) >
                                          -1
                                        : _vm.selectedItems
                                    },
                                    on: {
                                      change: function($event) {
                                        var $$a = _vm.selectedItems,
                                          $$el = $event.target,
                                          $$c = $$el.checked ? true : false
                                        if (Array.isArray($$a)) {
                                          var $$v = extra.id,
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
                                _c("td", [_vm._v(_vm._s(extra.id))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(extra.name))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(extra.label))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(extra.title))]),
                                _vm._v(" "),
                                _c("td", [
                                  _c("h5", [
                                    _c(
                                      "span",
                                      { staticClass: "badge badge-primary" },
                                      [_vm._v(_vm._s(extra.options_count))]
                                    )
                                  ])
                                ]),
                                _vm._v(" "),
                                _c("td", [
                                  _vm._v(
                                    _vm._s(
                                      _vm._f("formatDate")(extra.created_at)
                                    )
                                  )
                                ]),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  [
                                    _c(
                                      "router-link",
                                      {
                                        staticClass: "mr-4",
                                        attrs: {
                                          to: {
                                            name: "extras.edit",
                                            params: { id: extra.id }
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
                                            return _vm.deleteExtra(extra.id)
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
      _c("i", { staticClass: "material-icons" }, [_vm._v("local_cafe")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);