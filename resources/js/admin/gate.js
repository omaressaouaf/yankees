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
}

const gate = new Gate(window.authUser);

// For admins and deliverymen
gate.define("charge", order => {
    return (
        gate.user.role == "admin" &&
        !order.user_charged &&
        !order.payment_confirmation_required &&
        order.payment_mode == "stripe" &&
        order.status != "cancelled" &&
        order.status != "failed"
    );
});
gate.define("refund", order => {
    return (
        gate.user.role == "admin" &&
        order.payment_mode == "stripe" &&
        order.user_charged &&
        !order.user_refunded &&
        order.status == "cancelled"
    );
});
gate.define("update-order", order => {

    return order.status != "failed" && order.status != "cancelled";
});
gate.define("manage", () => {
    return gate.user.role == "admin";
});
// For Clients
gate.define("checkout", ({ cartObject, minOrderPrice }) => {
    return cartObject.total >= parseInt(minOrderPrice) && cartObject.count > 0;
});
export default gate;
