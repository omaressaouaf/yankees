import VueRouter from "vue-router";
import Vue from "vue";
import nProgress from "nprogress";
import store from './store'


Vue.use(VueRouter);
const routes = [
    {
        path: "/admin/dashboard",
        name: "dashboard",
        component: () => import("./components/dashboard/Dashboard.vue"),
        meta: {
            title: "Dashboard"
        },
    },
    {
        path: "/admin/users",
        name: "users",
        component: () => import("./components/users/UsersList.vue"),
        meta: {
            title: "Users"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/users/create",
        name: "users.create",
        component: () => import("./components/users/UsersForm.vue"),
        meta: {
            title: "Create User"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/users/:id/edit",
        name: "users.edit",
        component: () => import("./components/users/UsersForm.vue"),
        meta: {
            title: "Edit User"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/categories",
        name: "categories",
        component: () => import("./components/categories/CategoriesList.vue"),
        meta: {
            title: "Categories"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/categories/create",
        name: "categories.create",
        component: () => import("./components/categories/CategoriesForm.vue"),
        meta: {
            title: "Create Category"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/categories/:id/edit",
        name: "categories.edit",
        component: () => import("./components/categories/CategoriesForm.vue"),
        meta: {
            title: "Edit Category"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/extras",
        name: "extras",
        component: () => import("./components/extras/ExtrasList.vue"),
        meta: {
            title: "Extras"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/extras/create",
        name: "extras.create",
        component: () => import("./components/extras/ExtrasForm.vue"),
        meta: {
            title: "Create Extra"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/extras/:id/edit",
        name: "extras.edit",
        component: () => import("./components/extras/ExtrasForm.vue"),
        meta: {
            title: "Edit Extra"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/meals",
        name: "meals",
        component: () => import("./components/meals/MealsList.vue"),
        meta: {
            title: "Menus"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/meals/create",
        name: "meals.create",
        component: () => import("./components/meals/MealsForm.vue"),
        meta: {
            title: "Create Menu"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/meals/:id/edit",
        name: "meals.edit",
        component: () => import("./components/meals/MealsForm.vue"),
        meta: {
            title: "Edit Menu"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/orders",
        name: "orders",
        component: () => import("./components/orders/OrdersList.vue"),
        meta: {
            title: "Orders"
        }
    },
    {
        path: "/admin/orders/:id",
        name: "orders.show",
        component: () => import("./components/orders/OrdersSingle.vue"),
        meta: {
            title: "Order Details"
        }
    },
    {
        path: "/admin/sections",
        name: "sections",
        component: () => import("./components/sections/SectionsForm.vue"),
        meta: {
            title: "CMS"
        }
    },
    {
        path: "/admin/settings",
        name: "settings",
        component: () => import("./components/settings/SettingsIndex.vue"),
        meta: {
            title: "Settings"
        },
        beforeEnter: checkManageGate
    },
    {
        path: "/admin/profile",
        name: "profile",
        component: () => import("./components/profile/Profile.vue"),
        meta: {
            title: "Profile"
        }
    }

];
const router = new VueRouter({
    routes,
    mode: "history"
});

nProgress.configure({ easing: "ease", speed: 300 });
router.beforeEach((to, from, next) => {
    nProgress.start();
    next();
});
router.afterEach((to, from) => {
    const newTitle = `${to.meta.title} - ${store.state.appName}`;
    document.title = newTitle;
    nProgress.done();
});

function checkManageGate(to, from, next) {
    if (!window.gate.can('manage')) {
        router.push("/admin/403").catch(err => {});
        nProgress.done();
    } else {
        next();
    }
}

export default router;
