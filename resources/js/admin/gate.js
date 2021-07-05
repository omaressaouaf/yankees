import dayjs from "dayjs";

class Gate {
    constructor(user) {
        this.user = user;
    }
    validateAbilityName(abilityName) {
        if (
            typeof abilityName !== "string" &&
            !(abilityName instanceof String)
        ) {
            throw new Error("ability name should be a string");
        }
    }
    validateCallbackFn(callbackFn) {
        if (typeof callbackFn !== "function") {
            throw new Error("callback should be a function");
        }
    }
    define(abilityName, callbackFn) {
        this.validateAbilityName(abilityName);
        this.validateCallbackFn(callbackFn);
        this.abilities = { ...this.abilities, [abilityName]: callbackFn };
    }
    can(abilityName, payload = null) {
        this.validateAbilityName(abilityName);
        return this.abilities[abilityName](payload);
    }
    hasRole(role) {
        return this.user.roles.includes(role) ? true : false;
    }
    hasAnyRole(roles) {
        if (Array.isArray(roles)) {
            for (const role of roles) {
                if (this.hasRole(role)) {
                    return true;
                }
            }
        } else {
            if (this.hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

}

const gate = new Gate(window.authUser);
// For admins/managers/deliverymen
gate.define("manage-partially", () => {
    return gate.hasAnyRole(["admin", "manager"]);
});
gate.define("manage-fully", () => {
    return gate.hasRole("admin");
});
gate.define("charge", order => {
    return (
        gate.can("manage-partially") &&
        !order.user_charged &&
        !order.payment_confirmation_required &&
        order.payment_mode == "stripe" &&
        order.status != "cancelled" &&
        order.status != "failed"
    );
});
gate.define("refund", order => {
    return (
        gate.can("manage-partially") &&
        order.payment_mode == "stripe" &&
        order.user_charged &&
        !order.user_refunded &&
        order.status == "cancelled"
    );
});
gate.define("update-order", order => {
    return order.status != "failed" && order.status != "cancelled";
});

// For Clients
gate.define("checkout", ({ cartObject, minOrderPrice }) => {
    return cartObject.total >= parseInt(minOrderPrice) && cartObject.count > 0;
});
gate.define("cancel_order", order => {
    const todayDate = dayjs();
    const orderDate = dayjs(order.created_at);
    return order.status == "pending" && todayDate.diff(orderDate, "m") > 5;
});
gate.define("shop", () => {
    return window.canShop;
});

gate.define("checkout-with-stripe", () => {
    return window.canCheckoutWithStripe;
});

export default gate;
