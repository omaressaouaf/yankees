<template>
  <li class="nav-item dropdown" id="notificationsDropdown">
    <a
      class="nav-link"
      href="#"
      id="navbarDropdownMenuLink"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      <i class="material-icons">notifications</i>
      <span class="notification">{{ unreadNotificationsLength }}</span>
      <p class="d-lg-none d-md-block">Notifications</p>
    </a>
    <div
      class="dropdown-menu dropdown-menu-right"
      style="min-width: 449px"
      aria-labelledby="navbarDropdownMenuLink"
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
      <div class="text-center w-100" v-if="loading">
        <loading
          loader="dots"
          color="#2B51C4"
          :active.sync="loading"
          :is-full-page="false"
          :width="80"
          :height="200"
        />
      </div>
      <div v-else class="noti-wrapper has-cool-scrollbar">
        <div v-if="notifications.length">
          <div
            style="cursor: pointer"
            :class="{ 'bg-grey': !notification.read_at }"
            v-for="notification in notifications"
            :key="notification.id"
            class="dropdown-item py-3 d-flex align-items-center mb-2"
            @click="navigate(notification.data.url)"
          >
            <span
              class="material-icons mr-2 text-light"
              :class="determineIconAndBG(notification.data.event_name)['bg']"
              style="border-radius: 100%; padding: 11px 11px"
            >
              {{ determineIconAndBG(notification.data.event_name)["icon"] }}
            </span>
            <span>
              <p class="small text-muted mb-0 pb-0">
                {{ notification.created_at | formateDateTimeago }}
              </p>
              {{
                translate("admin." + notification.data.event_name) +
                " ID :" +
                notification.data.order.id
              }}
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
      unreadNotificationsLength: [],
      loading: false,
      authUser: window.authUser,
    };
  },

  methods: {
    revertToDefaultDocumentTitle() {
      document.title = `${this.$route.meta.title} - ${this.appName}`;
    },
    navigate(url) {
      if (this.$route.path.indexOf("/admin") != -1) {
        this.$router.push(url).catch((err) => {});
      } else {
        window.location.href = url;
      }
    },
    determineIconAndBG(event_name) {
      switch (event_name) {
        case "orderCreated":
          return {
            icon: "shopping_bag",
            bg: "bg-success",
          };
        case "deliverymanSelected":
          return {
            icon: "delivery_dining",
            bg: "bg-info",
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
          this.unreadNotificationsLength = 0;
          this.revertToDefaultDocumentTitle()
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
          this.revertToDefaultDocumentTitle()
        })
        .catch((err) => {
          console.log(err);
        });
    },
    increaseDocumentTileCount() {
      const oldNotificationsTemplate = `(${
        this.unreadNotificationsLength - 1
      })`;
      if (document.title.indexOf(oldNotificationsTemplate) != -1) {
        document.title = document.title.replace(oldNotificationsTemplate, "");
      }
      document.title = `(${this.unreadNotificationsLength}) ${document.title}`;
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
      this.unreadNotificationsLength++;
      this.increaseDocumentTileCount();
      if (notification.event_name == "orderCreated") {
        this.$store.commit("orders/addOrder", notification.order);
      }
      new Audio("/storage/notification.mp3").play();
      if ("Notification" in window) {
        const permission = await Notification.requestPermission();
        if (permission === "granted") {
          new Notification(appName, {
            body: translate("admin." + notification.event_name),
            icon: appLogo,
            silent: true,
          });
          return;
        }
      }
      fireToast("info", translate("admin." + notification.event_name));
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
  overflow: auto !important;
  min-width: 449px;
}
.bg-grey {
  background-color: #eeeeee;
}
</style>
