<template>
  <li class="nav-item dropdown" id="notificationsDropdown">
    <a
      class="nav-link"
      href="#"
      id="notificationsDropdownLink"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      <i class="fa fa-bell fa-lg"></i>
      <span class="notification" v-if="unreadNotificationsLength">{{
        unreadNotificationsLength
      }}</span>
      <!-- <p class="d-lg-none d-md-block">Notifications</p> -->
    </a>
    <div
      class="dropdown-menu dropdown-menu-right"
      aria-labelledby="notificationsDropdownLink"
    >
      <h6 class="dropdown-header py-3 w-100">
        {{ translate("admin.notificationsCenter") }}
        <span
          v-if="notifications.length"
          class="float-right text-danger"
          @click="deleteNotifications"
          style="cursor: pointer"
        >
          <u>
            {{ translate("admin.delete") }}
          </u>
        </span>
      </h6>
      <div class="text-center w-100 py-5" v-if="loading">
        <vue-loaders-ball-scale-ripple-multiple
          color="#2B51C4"
          scale="1"
        ></vue-loaders-ball-scale-ripple-multiple>
      </div>
      <div v-else class="noti-wrapper has-cool-scrollbar">
        <div v-if="notifications.length">
          <div
            style="cursor: pointer"
            :class="{ 'bg-grey': !notification.read_at }"
            v-for="notification in notifications"
            :key="notification.id"
            class="dropdown-item py-3 d-flex align-items-center mb-2"
            @click="
              navigate(notification.data.url, notification.data.event_name)
            "
          >
            <span
              class="material-icons mr-2 text-light"
              :class="getNotificationPresentation(notification.data)['bg']"
              style="border-radius: 100%; padding: 11px 11px"
            >
              {{ getNotificationPresentation(notification.data)["icon"] }}
            </span>
            <span>
              <p class="small text-muted mb-0 pb-0">
                {{ notification.created_at | formateDateTimeago }}
              </p>
              {{ getNotificationPresentation(notification.data)["msg"] }}
            </span>
          </div>
        </div>
        <div v-else class="dropdown-item py-3">
          {{ translate("admin.noNotifications") }}
        </div>
      </div>
    </div>
  </li>
</template>

<script>
import { fireToast } from "../../helpers";

export default {
  data() {
    return {
      appLogo: this.$store.state.appLogo,
      appName: this.$store.state.appName,
      notifications: [],
      unreadNotificationsLength: 0,
      loading: false,
      authUser: window.authUser,
    };
  },

  methods: {
    revertToDefaultDocumentTitle() {
      const oldNotificationsTemplate = `(${this.unreadNotificationsLength})`;
      if (document.title.indexOf(oldNotificationsTemplate) != -1) {
        document.title = document.title.replace(oldNotificationsTemplate, "");
      }
    },
    increaseDocumentTileCount() {
      this.revertToDefaultDocumentTitle();
      document.title = `(${this.unreadNotificationsLength + 1}) ${
        document.title
      }`;
    },
    navigate(url, event_name) {
      if (this.$route.path.indexOf("/admin") != -1) {
        if (
          event_name == "orderStatusChanged" ||
          event_name == "paymentConfirmationRequired" ||
          event_name == "userRefunded" ||
          event_name == "userCharged"
        ) {
          window.location.href = url;
        }
        this.$router.push(url).catch((err) => {});
      } else {
        window.location.href = url;
      }
    },
    getNotificationPresentation({ event_name, order }) {
      const translateParams = { orderId: order.id };
      switch (event_name) {
        case "orderCreated":
          return {
            icon: "shopping_bag",
            bg: "bg-success",
            msg: translate("admin." + event_name, translateParams),
          };
        case "deliverymanSelected":
          return {
            icon: "delivery_dining",
            bg: "bg-info",
            msg: translate("admin." + event_name, translateParams),
          };
        case "orderStatusChanged":
          return {
            icon: "history",
            bg: "bg-danger",
            msg: translate("admin." + event_name, {
              ...translateParams,
              orderStatus: translate("admin." + order.status),
            }),
          };
        case "paymentConfirmationRequired":
          return {
            icon: "help_center",
            bg: "bg-danger",
            msg: translate("admin." + event_name, translateParams),
          };
        case "userCharged":
          return {
            icon: "credit_card_off",
            bg: "bg-success",
            msg: translate("admin." + event_name, {
              ...translateParams,
              orderTotal: order.total,
            }),
          };
        case "userRefunded":
          return {
            icon: "credit_score",
            bg: "bg-info",
            msg: translate("admin." + event_name, {
              ...translateParams,
              orderTotal: order.total,
            }),
          };
        case "paymentConfirmationObtained":
          return {
            icon: "verified_user",
            bg: "bg-primary",
            msg: translate("admin." + event_name, translateParams),
          };
        case "clientCancelledOrder":
          return {
            icon: "close",
            bg: "bg-danger",
            msg: translate("admin." + event_name, translateParams),
          };
      }
    },
    getNotifications() {
      this.loading = true;
      axios
        .get("/api/notifications")
        .then((res) => {
          this.notifications = res.data.notifications;
          const unreadNotifications = this.notifications.filter(
            (notification) => {
              return notification.read_at == null;
            }
          );
          this.unreadNotificationsLength = unreadNotifications.length;
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    deleteNotifications(e) {
      e.stopPropagation();
      this.loading = true;
      axios
        .delete("/api/notifications")
        .then((res) => {
          this.notifications = [];
          this.revertToDefaultDocumentTitle();
          this.unreadNotificationsLength = 0;
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    markNotifications() {
      axios
        .put("/api/notifications")
        .then((res) => {
          this.getNotifications();
          this.revertToDefaultDocumentTitle();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async handleBroadcast(notification) {
      const newNotification = {
        id: notification.id,
        data: {
          order: notification.order,
          event_name: notification.event_name,
          url: notification.url,
        },
        read_at: null,
      };
      this.notifications.unshift(newNotification);
      this.increaseDocumentTileCount();
      this.unreadNotificationsLength++;
      if (notification.event_name == "orderCreated") {
        this.$store.commit("orders/addOrder", notification.order);
      }
      new Audio("/storage/notification.mp3").play();
      if ("Notification" in window) {
        const permission = await Notification.requestPermission();
        if (permission === "granted") {
          new Notification(this.appName, {
            body: this.getNotificationPresentation(notification)["msg"],
            icon: this.appLogo,
            silent: true,
          });
          return;
        }
      }
      fireToast("info", this.getNotificationPresentation(notification)["msg"]);
    },
  },
  mounted() {
    //   listening for dropdown close event
    $("#notificationsDropdown").on("hide.bs.dropdown", () => {
      if (this.unreadNotificationsLength) {
        this.markNotifications();
      }
    });
    // monitor any broadcast notifications using echo
    Echo.private(`App.Models.User.${this.authUser.id}`).notification(
      this.handleBroadcast
    );
    this.getNotifications();
  },
};
</script>

<style scoped>
.noti-wrapper {
  max-height: 450px !important;
  overflow-y: auto !important;
  min-width: 100% !important;
}
.bg-grey {
  background-color: #eeeeee;
}
.dropdown-item {
  white-space: normal !important;
}
.dropdown-menu {
  position: absolute;
  margin-left: -10px;
  background-color: white !important ;
}
@media (min-width: 1124px) {
  .dropdown-menu {
    min-width: 449px;
  }
}
@media (max-width: 500px) {
  .dropdown-menu {
    min-width: 300px;
  }
}
</style>
