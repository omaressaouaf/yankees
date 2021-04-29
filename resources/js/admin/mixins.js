import Vue from "vue";

export const dataTableMixin = {
    data() {
        return {
            dtTable: null
        };
    },
    beforeUpdate() {
        if (this.dtTable) {
            this.dtTable.destroy();
        }
    },
    updated() {
        this.dtTable = $("#dataTable").DataTable({
            order: [[0, "desc"]]
        });
    }
};
export const orderStatusMixin = {
    data() {
        return {
            statuses: [
                "pending",
                "processing",
                "out_for_delivery",
                "delivered",
                "cancelled",
                "failed"
            ]
        };
    },
    methods: {
        customMultiselectLabel(option) {
            return translate("admin." + option);
            
        },
        bindStatusClass(status, element) {
            switch (true) {
                case ["pending", "processing", "out_for_delivery"].includes(
                    status
                ):
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
