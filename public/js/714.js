(self.webpackChunk=self.webpackChunk||[]).push([[714],{9181:(t,a,s)=>{"use strict";s.r(a),s.d(a,{default:()=>n});var r=s(3645),e=s.n(r)()((function(t){return t[1]}));e.push([t.id,".ball-clip-rotate>div{margin:-4%!important;display:block!important}",""]);const n=e},6179:(t,a,s)=>{"use strict";s.r(a),s.d(a,{default:()=>n});var r=s(3645),e=s.n(r)()((function(t){return t[1]}));e.push([t.id,".fade-enter-active,.fade-leave-active{transition:opacity .3s}.fade-enter,.fade-leave-to{opacity:0}",""]);const n=e},714:(t,a,s)=>{"use strict";s.r(a),s.d(a,{default:()=>_});const r={data:function(){return{countLoading:!0,countData:{}}},methods:{getCount:function(){var t=this;this.countLoading=!0,axios.get("/dashboard/count").then((function(a){t.countData=a.data,t.countLoading=!1})).catch((function(t){console.log(t)}))}},mounted:function(){this.getCount()}};s(8626);var e=s(1900);const n=(0,e.Z)(r,(function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{staticClass:"row"},[s("div",{staticClass:"col-sm-12 col-md-6 col-xl-3"},[s("div",{staticClass:"card card-stats"},[s("div",{staticClass:"card-header card-header-warning card-header-icon"},[t._m(0),t._v(" "),s("p",{staticClass:"card-category"},[t._v(t._s(t.translate("admin.registrations")))]),t._v(" "),s("transition",{attrs:{name:"fade",mode:"out-in"}},[t.countLoading?s("vue-loaders-ball-clip-rotate",{staticClass:"py-0 my-0",attrs:{color:"#2B51C4",scale:"1"}}):s("h3",{staticClass:"card-title"},[t._v("+"+t._s(t.countData.usersCount))])],1)],1),t._v(" "),s("div",{staticClass:"card-footer"},[s("div",{staticClass:"stats"},[s("i",{staticClass:"material-icons mr-1 text-danger"},[t._v("warning")]),t._v("\n          "+t._s(t.translate("admin.promoteApp"))+"\n        ")])])])]),t._v(" "),s("div",{staticClass:"col-sm-12 col-md-6 col-xl-3"},[s("div",{staticClass:"card card-stats"},[s("div",{staticClass:"card-header card-header-success card-header-icon"},[t._m(1),t._v(" "),s("p",{staticClass:"card-category"},[t._v(t._s(t.translate("admin.revenue")))]),t._v(" "),s("transition",{attrs:{name:"fade",mode:"out-in"}},[t.countLoading?s("vue-loaders-ball-clip-rotate",{staticClass:"py-0 my-0",attrs:{color:"#2B51C4",scale:"1"}}):s("h3",{staticClass:"card-title"},[t._v("DHS "+t._s(t.countData.revenueCount))])],1)],1),t._v(" "),s("div",{staticClass:"card-footer"},[s("div",{staticClass:"stats"},[s("i",{staticClass:"material-icons"},[t._v("sell")]),t._v("\n          "+t._s(t.translate("admin.noRevenuHistory"))+"\n        ")])])])]),t._v(" "),s("div",{staticClass:"col-sm-12 col-md-6 col-xl-3"},[s("div",{staticClass:"card card-stats"},[s("div",{staticClass:"card-header card-header-danger card-header-icon"},[t._m(2),t._v(" "),s("p",{staticClass:"card-category"},[t._v(t._s(t.translate("admin.menus")))]),t._v(" "),s("transition",{attrs:{name:"fade",mode:"out-in"}},[t.countLoading?s("vue-loaders-ball-clip-rotate",{staticClass:"py-0 my-0",attrs:{color:"#2B51C4",scale:"1"}}):s("h3",{staticClass:"card-title"},[t._v(t._s(t.countData.mealsCount))])],1)],1),t._v(" "),s("div",{staticClass:"card-footer"},[s("div",{staticClass:"stats"},[s("i",{staticClass:"material-icons"},[t._v("content_copy")]),t._v(" "),s("router-link",{staticStyle:{color:"inherit"},attrs:{to:{name:"meals"}}},[t._v("\n            "+t._s(t.translate("admin.addMoreMenus"))+"\n          ")])],1)])])]),t._v(" "),s("div",{staticClass:"col-sm-12 col-md-6 col-xl-3"},[s("div",{staticClass:"card card-stats"},[s("div",{staticClass:"card-header card-header-dark card-header-icon"},[t._m(3),t._v(" "),s("p",{staticClass:"card-category"},[t._v(t._s(t.translate("admin.orders")))]),t._v(" "),s("transition",{attrs:{name:"fade",mode:"out-in"}},[t.countLoading?s("vue-loaders-ball-clip-rotate",{staticClass:"py-0 my-0",attrs:{color:"#2B51C4",scale:"1"}}):s("h3",{staticClass:"card-title"},[t._v("+"+t._s(t.countData.ordersCount))])],1)],1),t._v(" "),s("div",{staticClass:"card-footer"},[s("div",{staticClass:"stats"},[s("i",{staticClass:"material-icons"},[t._v("update")]),t._v(" "),s("router-link",{staticStyle:{color:"inherit"},attrs:{to:{name:"orders"}}},[t._v("\n            "+t._s(t.translate("admin.checkPendingOrders"))+"\n          ")])],1)])])])])}),[function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{staticClass:"card-icon"},[s("i",{staticClass:"material-icons"},[t._v("people")])])},function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{staticClass:"card-icon"},[s("i",{staticClass:"material-icons"},[t._v("store")])])},function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{staticClass:"card-icon"},[s("i",{staticClass:"material-icons"},[t._v("lunch_dining")])])},function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{staticClass:"card-icon"},[s("i",{staticClass:"material-icons"},[t._v("shopping_bag")])])}],!1,null,null,null).exports;function i(t){return function(t){if(Array.isArray(t))return o(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||function(t,a){if(!t)return;if("string"==typeof t)return o(t,a);var s=Object.prototype.toString.call(t).slice(8,-1);"Object"===s&&t.constructor&&(s=t.constructor.name);if("Map"===s||"Set"===s)return Array.from(t);if("Arguments"===s||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(s))return o(t,a)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function o(t,a){(null==a||a>t.length)&&(a=t.length);for(var s=0,r=new Array(a);s<a;s++)r[s]=t[s];return r}const c={props:["chartId","chartData","chartLoading"],watch:{chartLoading:function(t){t||(this.chartOptions.high=Math.max.apply(Math,i(this.chartData.series[0]))+5,this.initBarChart())}},data:function(){return{chartOptions:{axisX:{showGrid:!1},low:0,high:50,chartPadding:{top:0,right:5,bottom:0,left:0}},chartResponsiveOptions:[["screen and (max-width: 640px)",{seriesBarDistance:5,axisX:{labelInterpolationFnc:function(t){return t[0]}}}]]}},methods:{initBarChart:function(){var t=new Chartist.Bar("#".concat(this.chartId),this.chartData,this.chartOptions,this.chartResponsiveOptions);md.startAnimationForBarChart(t)}},mounted:function(){this.initBarChart()}};const l=(0,e.Z)(c,(function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{staticClass:"ct-chart",attrs:{id:t.chartId}},[s("transition",{attrs:{name:"fade"}},[t.chartLoading?s("div",{staticStyle:{position:"absolute",right:"10px"}},[s("vue-loaders-line-scale",{attrs:{color:"#fff",scale:"1"}})],1):t._e()])],1)}),[],!1,null,null,null).exports;function d(t){return function(t){if(Array.isArray(t))return h(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||function(t,a){if(!t)return;if("string"==typeof t)return h(t,a);var s=Object.prototype.toString.call(t).slice(8,-1);"Object"===s&&t.constructor&&(s=t.constructor.name);if("Map"===s||"Set"===s)return Array.from(t);if("Arguments"===s||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(s))return h(t,a)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function h(t,a){(null==a||a>t.length)&&(a=t.length);for(var s=0,r=new Array(a);s<a;s++)r[s]=t[s];return r}const u={props:["chartId","chartData","chartLoading"],data:function(){return{chartOptions:{lineSmooth:Chartist.Interpolation.cardinal({tension:0}),low:0,high:50,chartPadding:{top:0,right:0,bottom:0,left:0}}}},watch:{chartLoading:function(t){t||(this.chartOptions.high=Math.max.apply(Math,d(this.chartData.series[0]))+5,this.initLineChart())}},methods:{initLineChart:function(){var t=new Chartist.Line("#".concat(this.chartId),this.chartData,this.chartOptions);md.startAnimationForLineChart(t)}},mounted:function(){this.initLineChart()}};const v={components:{LineChart:(0,e.Z)(u,(function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{staticClass:"ct-chart",attrs:{id:t.chartId}},[s("transition",{attrs:{name:"fade"}},[t.chartLoading?s("div",{staticStyle:{position:"absolute",right:"10px"}},[s("vue-loaders-line-scale",{attrs:{color:"#fff",scale:"1"}})],1):t._e()])],1)}),[],!1,null,null,null).exports,BarChart:l},data:function(){return{ordersChartLoading:!0,usersChartLoading:!0,revenueChartLoading:!0,ordersByMonth:null,usersByMonth:null,revenueByMonth:null,latestOrderDate:"",latestUsers:[]}},methods:{getCharts:function(){var t=this,a=arguments.length>0&&void 0!==arguments[0]?arguments[0]:["orders","users","revenue"];a.includes("orders")&&(this.ordersChartLoading=!0),a.includes("users")&&(this.usersChartLoading=!0),a.includes("revenue")&&(this.revenueChartLoading=!0),axios.get("/dashboard/charts").then((function(s){a.includes("orders")&&(t.ordersByMonth={labels:[],series:[[]]},s.data.ordersByMonth.forEach((function(a){t.ordersByMonth.labels.push(a.month[0].toUpperCase()),t.ordersByMonth.series[0].push(a.total)})),t.latestOrderDate=s.data.latestOrderDate,t.ordersChartLoading=!1),a.includes("users")&&(t.usersByMonth={labels:[],series:[[]]},s.data.usersByMonth.forEach((function(a){t.usersByMonth.labels.push(a.month[0].toUpperCase()),t.usersByMonth.series[0].push(a.total)})),t.latestUsers=s.data.latestUsers,t.usersChartLoading=!1),a.includes("revenue")&&(t.revenueByMonth={labels:[],series:[[]]},s.data.revenueByMonth.forEach((function(a){t.revenueByMonth.labels.push(a.month[0].toUpperCase()),t.revenueByMonth.series[0].push(Number(a.total))})),t.revenueChartLoading=!1)})).catch((function(t){console.log(t)}))}},mounted:function(){this.getCharts()}};const m={components:{Cards:n,Charts:(0,e.Z)(v,(function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",[s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"card card-chart"},[s("div",{staticClass:"card-header card-header-success",attrs:{"data-header-animation":"true"}},[s("line-chart",{attrs:{"chart-id":"monthlyOrders","chart-data":t.ordersByMonth,"chart-loading":t.ordersChartLoading}})],1),t._v(" "),s("div",{staticClass:"card-body"},[s("div",{staticClass:"card-actions"},[s("button",{staticClass:"btn btn-info btn-link",attrs:{type:"button",rel:"tooltip","data-placement":"bottom",title:"","data-original-title":"Refresh"},on:{click:function(a){return t.getCharts(["orders"])}}},[s("i",{staticClass:"material-icons"},[t._v("refresh")])])]),t._v(" "),s("h4",{staticClass:"card-title"},[t._v(t._s(t.translate("admin.monthlySales")))]),t._v(" "),s("p",{staticClass:"card-category"},[t._v("\n            "+t._s(t.translate("admin.monthlySalesText"))+"\n          ")])]),t._v(" "),s("div",{staticClass:"card-footer"},[s("div",{staticClass:"stats"},[s("i",{staticClass:"material-icons"},[t._v("access_time")]),t._v(" "),t.latestOrderDate?s("span",{staticClass:"mr-1"},[t._v("\n              "+t._s(t._f("formateDateTimeago")(t.latestOrderDate))+"\n            ")]):t._e(),t._v("\n            "+t._s(t.translate("admin.latestOrder"))+"\n          ")])])])]),t._v(" "),s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"card card-chart"},[s("div",{staticClass:"card-header card-header-warning",attrs:{"data-header-animation":"true"}},[s("bar-chart",{attrs:{"chart-id":"monthlyRevenue","chart-data":t.revenueByMonth,"chart-loading":t.revenueChartLoading}})],1),t._v(" "),s("div",{staticClass:"card-body"},[s("div",{staticClass:"card-actions"},[s("button",{staticClass:"btn btn-info btn-link",attrs:{type:"button",rel:"tooltip","data-placement":"bottom",title:"","data-original-title":"Refresh"},on:{click:function(a){return t.getCharts(["revenue"])}}},[s("i",{staticClass:"material-icons"},[t._v("refresh")])])]),t._v(" "),s("h4",{staticClass:"card-title"},[t._v(t._s(t.translate("admin.monthlyRevenue")))]),t._v(" "),s("p",{staticClass:"card-category"},[t._v("\n            "+t._s(t.translate("admin.monthlyRevenueText"))+"\n          ")])]),t._v(" "),s("div",{staticClass:"card-footer"},[s("div",{staticClass:"stats"},[s("i",{staticClass:"material-icons"},[t._v("sell")]),t._v("\n            "+t._s(t.translate("admin.noRevenuHistory"))+"\n          ")])])])]),t._v(" "),s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"card card-chart"},[s("div",{staticClass:"card-header card-header-danger",attrs:{"data-header-animation":"true"}},[s("line-chart",{attrs:{"chart-id":"monthlyUsers","chart-data":t.usersByMonth,"chart-loading":t.usersChartLoading}})],1),t._v(" "),s("div",{staticClass:"card-body"},[s("div",{staticClass:"card-actions"},[s("button",{staticClass:"btn btn-info btn-link",attrs:{type:"button",rel:"tooltip","data-placement":"bottom",title:"","data-original-title":"Refresh"},on:{click:function(a){return t.getCharts(["users"])}}},[s("i",{staticClass:"material-icons"},[t._v("refresh")])])]),t._v(" "),s("h4",{staticClass:"card-title"},[t._v(t._s(t.translate("admin.monthlyUsers")))]),t._v(" "),s("p",{staticClass:"card-category"},[t._v("\n            "+t._s(t.translate("admin.monthlyUsersText"))+"\n          ")])]),t._v(" "),s("div",{staticClass:"card-footer"},[s("div",{staticClass:"stats"},[s("i",{staticClass:"material-icons"},[t._v("access_time")]),t._v(" "),t.latestUsers[0]?s("span",{staticClass:"mr-1"},[t._v("\n              "+t._s(t._f("formateDateTimeago")(t.latestUsers[0].created_at))+"\n            ")]):t._e(),t._v("\n            "+t._s(t.translate("admin.latestUser"))+"\n          ")])])])])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-12 col-md-12"},[s("div",{staticClass:"card"},[s("div",{staticClass:"card-header card-header-warning"},[s("h4",{staticClass:"card-title"},[t._v(t._s(t.translate("admin.latestUsers")))]),t._v(" "),s("p",{staticClass:"card-category"},[s("router-link",{attrs:{to:{name:"users"}}},[t._v(t._s(t.translate("admin.manageTheirData"))+"\n            ")])],1)]),t._v(" "),s("div",{staticClass:"card-body table-responsive"},[s("table",{staticClass:"table table-hover"},[s("thead",{staticClass:"text-warning"},[s("th",[t._v("ID")]),t._v(" "),s("th",[t._v(t._s(t.translate("admin.name")))]),t._v(" "),s("th",[t._v("Email")]),t._v(" "),s("th",[t._v(t._s(t.translate("admin.phone")))])]),t._v(" "),s("tbody",[t.usersChartLoading?s("tr",[s("td",{staticClass:"text-center py-5",attrs:{colspan:"4"}},[s("vue-loaders-ball-scale-ripple-multiple",{attrs:{color:"#2B51C4",scale:"1"}})],1)]):t._l(t.latestUsers,(function(a){return s("tr",{key:a.id},[s("td",[t._v(t._s(a.id))]),t._v(" "),s("td",[t._v(t._s(a.name))]),t._v(" "),s("td",[t._v(t._s(a.email))]),t._v(" "),s("td",[t._v(t._s(a.phone))])])}))],2)])])])])])])}),[],!1,null,null,null).exports}};s(3943);const _=(0,e.Z)(m,(function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{staticClass:"container-fluid"},[s("the-breadcrumb"),t._v(" "),s("cards"),t._v(" "),s("charts")],1)}),[],!1,null,null,null).exports},8626:(t,a,s)=>{var r=s(9181);r.__esModule&&(r=r.default),"string"==typeof r&&(r=[[t.id,r,""]]),r.locals&&(t.exports=r.locals);(0,s(5346).Z)("1e141f88",r,!0,{})},3943:(t,a,s)=>{var r=s(6179);r.__esModule&&(r=r.default),"string"==typeof r&&(r=[[t.id,r,""]]),r.locals&&(t.exports=r.locals);(0,s(5346).Z)("62cc0da8",r,!0,{})}}]);