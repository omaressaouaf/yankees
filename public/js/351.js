(self.webpackChunk=self.webpackChunk||[]).push([[351],{1893:(e,t,a)=>{"use strict";a.d(t,{P:()=>s,_:()=>r});var s={data:function(){return{dtTable:null}},beforeUpdate:function(){this.dtTable&&this.dtTable.destroy()},updated:function(){this.dtTable=$("#dataTable").DataTable({order:[[0,"desc"]]})}},r={data:function(){return{statuses:["pending","processing","out_for_delivery","delivered","cancelled","failed"]}},methods:{customMultiselectLabel:function(e){return translate("admin."+e)},bindStatusClass:function(e,t){switch(!0){case["pending","processing","out_for_delivery"].includes(e):return"badge"==t&&"pending"==e?"badge-secondary":"icon"==t?"fa-clock":"badge-info";case["cancelled","failed"].includes(e):return"icon"==t?"fa-times":"badge-danger";case["delivered"].includes(e):return"icon"==t?"fa-check":"badge-success"}}}}},3351:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>f});var s=a(7757),r=a.n(s),n=a(1893),c=a(629),l=a(3299);function i(e,t,a,s,r,n,c){try{var l=e[n](c),i=l.value}catch(e){return void a(e)}l.done?t(i):Promise.resolve(i).then(s,r)}function d(e){return function(){var t=this,a=arguments;return new Promise((function(s,r){var n=e.apply(t,a);function c(e){i(n,s,r,c,l,"next",e)}function l(e){i(n,s,r,c,l,"throw",e)}c(void 0)}))}}function o(e,t){var a=Object.keys(e);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(e);t&&(s=s.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),a.push.apply(a,s)}return a}function u(e){for(var t=1;t<arguments.length;t++){var a=null!=arguments[t]?arguments[t]:{};t%2?o(Object(a),!0).forEach((function(t){v(e,t,a[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(a)):o(Object(a)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(a,t))}))}return e}function v(e,t,a){return t in e?Object.defineProperty(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}const p={components:{ProgressesList:a(3446).Z},mixins:[n.P],data:function(){return{selectedItems:[],allSelected:!1}},watch:{selectedItems:function(){this.allSelected=this.selectedItems.length===this.allMeals.length}},computed:u({getIsLoading:function(){return this.isLoading.get},postIsLoading:function(){return this.isLoading.post}},(0,c.Se)("meals",["allMeals","isLoading"])),methods:u({selectOrUnSelectAll:function(){var e=this;this.allSelected?this.selectedItems=[]:this.allMeals.forEach((function(t){e.selectedItems.push(t.id)}))},prepareBulkDeleteMeals:function(){var e=this;this.selectedItems.length&&(0,l.AB)(d(r().mark((function t(){return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.bulkDeleteMeals(e.selectedItems);case 2:e.selectedItems=[];case 3:case"end":return t.stop()}}),t)}))))}},(0,c.nv)("meals",["fetchMeals","deleteMeal","bulkDeleteMeals"])),created:function(){this.fetchMeals()}};const f=(0,a(1900).Z)(p,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"container-fluid"},[a("the-breadcrumb",[a("li",{staticClass:"breadcrumb-item active"},[e._v(e._s(e.translate("admin.menus")))])]),e._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("div",{staticClass:"card"},[a("div",{staticClass:"d-flex"},[a("div",{staticClass:"card-header card-header-icon card-header-warning",staticStyle:{"flex-grow":"1 !important"}},[e._m(0),e._v(" "),a("h4",{staticClass:"card-title"},[e._v("\n              "+e._s(e.translate("admin.menus")+" Table")+"\n            ")])]),e._v(" "),a("div",{staticClass:"mt-2"},[a("button",{staticClass:"btn btn-danger",attrs:{disabled:e.postIsLoading},on:{click:e.prepareBulkDeleteMeals}},[a("span",[e.postIsLoading?a("i",{staticClass:"fa fa-circle-notch fa-spin"}):a("i",{staticClass:"fa fa-dumpster"}),e._v("\n                "+e._s(e.translate("admin.delete"))+"\n              ")])]),e._v(" "),a("router-link",{attrs:{to:{name:"meals.create"}}},[a("button",{staticClass:"btn btn-outline-success mr-2"},[a("i",{staticClass:"fa fa-plus-circle"}),e._v(" "),a("span",[e._v("\n                  "+e._s(e.translate("admin.add")+" "+e.translate("admin.menu")))])])])],1)]),e._v(" "),a("div",{staticClass:"card-body"},[a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table table-striped table-hover",attrs:{id:"dataTable"}},[a("thead",[a("tr",[a("th",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.allSelected,expression:"allSelected"}],attrs:{disabled:e.getIsLoading,type:"checkbox"},domProps:{checked:Array.isArray(e.allSelected)?e._i(e.allSelected,null)>-1:e.allSelected},on:{click:e.selectOrUnSelectAll,change:function(t){var a=e.allSelected,s=t.target,r=!!s.checked;if(Array.isArray(a)){var n=e._i(a,null);s.checked?n<0&&(e.allSelected=a.concat([null])):n>-1&&(e.allSelected=a.slice(0,n).concat(a.slice(n+1)))}else e.allSelected=r}}})]),e._v(" "),a("th",[e._v("ID")]),e._v(" "),a("th",[e._v(e._s(e.translate("admin.title")))]),e._v(" "),a("th",[e._v(e._s(e.translate("admin.price")))]),e._v(" "),a("th",[e._v(e._s(e.translate("admin.active")))]),e._v(" "),a("th",[e._v(e._s(e.translate("admin.category")))]),e._v(" "),a("th",[e._v("Image")]),e._v(" "),a("th",[e._v("Extras")]),e._v(" "),a("th",[e._v(e._s(e.translate("admin.createdAt")))]),e._v(" "),a("th",[e._v("Actions")])])]),e._v(" "),a("tbody",[e.getIsLoading?a("tr",[a("td",{staticClass:"text-center py-5",attrs:{colspan:"10"}},[a("vue-loaders-ball-scale-ripple-multiple",{attrs:{color:"#2B51C4",scale:"1"}})],1)]):e._l(e.allMeals,(function(t){return a("tr",{key:t.id},[a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.selectedItems,expression:"selectedItems"}],attrs:{type:"checkbox"},domProps:{value:t.id,checked:Array.isArray(e.selectedItems)?e._i(e.selectedItems,t.id)>-1:e.selectedItems},on:{change:function(a){var s=e.selectedItems,r=a.target,n=!!r.checked;if(Array.isArray(s)){var c=t.id,l=e._i(s,c);r.checked?l<0&&(e.selectedItems=s.concat([c])):l>-1&&(e.selectedItems=s.slice(0,l).concat(s.slice(l+1)))}else e.selectedItems=n}}})]),e._v(" "),a("td",[e._v(e._s(t.id))]),e._v(" "),a("td",[e._v(e._s(t.title))]),e._v(" "),a("td",[e._v(e._s(t.price)+" DH")]),e._v(" "),a("td",[a("i",{class:[t.active?"fa fa-check text-success":"fa fa-times text-danger"]})]),e._v(" "),a("td",{class:{"text-danger":!t.category.id}},[t.category.id?e._e():a("i",{staticClass:"fa fa-info-circle"}),e._v("\n                    "+e._s(t.category.name)+"\n                  ")]),e._v(" "),a("td",[a("img",{staticClass:"img-fluid rounded",attrs:{width:"80",height:"80",src:t.resized_image}})]),e._v(" "),a("td",{staticClass:"text-center"},[a("h5",[a("span",{staticClass:"badge",class:[t.extras_count?"badge-primary":"badge-danger"]},[e._v(e._s(t.extras_count))])])]),e._v(" "),a("td",[e._v(e._s(e._f("formatDate")(t.created_at)))]),e._v(" "),a("td",[a("router-link",{staticClass:"mr-4",attrs:{to:{name:"meals.edit",params:{id:t.id}}}},[a("i",{staticClass:"fa fa-pen text-success"})]),e._v(" "),a("a",{attrs:{href:"#"},on:{click:function(a){return a.preventDefault(),e.deleteMeal(t.id)}}},[a("i",{staticClass:"fa fa-trash text-danger"})])],1)])}))],2)])]),e._v(" "),a("div",{staticClass:"mt-5"},[a("progresses-list")],1)])])])])],1)}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"card-icon card-icon-custom"},[a("i",{staticClass:"material-icons"},[e._v("lunch_dining")])])}],!1,null,null,null).exports},3446:(e,t,a)=>{"use strict";a.d(t,{Z:()=>o});var s=a(629);const r={props:["percentage"]};var n=a(1900);function c(e,t){var a=Object.keys(e);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(e);t&&(s=s.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),a.push.apply(a,s)}return a}function l(e){for(var t=1;t<arguments.length;t++){var a=null!=arguments[t]?arguments[t]:{};t%2?c(Object(a),!0).forEach((function(t){i(e,t,a[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(a)):c(Object(a)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(a,t))}))}return e}function i(e,t,a){return t in e?Object.defineProperty(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}const d={components:{ProgressBar:(0,n.Z)(r,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"progress"},[a("div",{staticClass:"progress-bar bg-success progress-bar-striped progress-bar-animated",style:{width:e.percentage+"%"},attrs:{role:"progressbar","aria-valuenow":e.percentage,"aria-valuemin":"0","aria-valuemax":"100"}},[e._v("\n    "+e._s(e.percentage)+"%\n  ")])])}),[],!1,null,null,null).exports},computed:l({},(0,s.Se)("meals",["uploadProgresses"])),methods:l({},(0,s.nv)("meals",["cancelUpload"]))};const o=(0,n.Z)(d,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return e.uploadProgresses.length?a("div",{staticClass:"px-5"},[a("h2",{attrs:{className:"text-info"}},[e._v("\n    "+e._s(e.translate("admin.uploading"))+" "+e._s(e.uploadProgresses.length)+"\n    "+e._s(e.translate("admin.image"))+"(s)\n  ")]),e._v(" "),e._l(e.uploadProgresses,(function(t){return a("div",{key:t.identifier},[a("h4",[e._v(e._s(t.title))]),e._v(" "),a("progress-bar",{attrs:{percentage:t.percentage}}),e._v(" "),a("button",{staticClass:"btn btn-danger btn-sm mt-2",attrs:{disabled:100===t.percentage},on:{click:function(a){return e.cancelUpload(t.source)}}},[e._v("\n      "+e._s(e.translate("admin.cancel"))+"\n    ")])],1)}))],2):e._e()}),[],!1,null,null,null).exports}}]);