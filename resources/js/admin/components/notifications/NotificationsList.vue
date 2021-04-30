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
          <router-link
            :class="{ 'bg-grey': !notification.read_at }"
            v-for="notification in notifications"
            :key="notification.id"
            class="dropdown-item py-3 d-flex align-items-center mb-2"
            :to="notification.data.url"
          >
            <span
              class="fa fa-lg mr-2"
              style="border-radius: 100%; padding: 14px 13px"
              :class="bindIcon(notification.data.message)"
            ></span>
            <span>
              <p class="small text-muted mb-0 pb-0">
                {{ notification.created_at | formateDateTimeago }}
              </p>
              {{
                translate("admin." + notification.data.message) +
                " ID :" +
                notification.data.order.id
              }}
            </span>
          </router-link>
        </div>
        <div v-else class="dropdown-item py-3">
          {{ translate("admin.noNotifications") }}
        </div>
      </div>
    </div>
  </li>
</template>

<script>
import { mapGetters } from "vuex";
import { fireToast } from "../../helpers";

export default {
  data() {
    return {
      appLogo: this.$store.state.appLogo,
      appName: this.$store.state.appName,
      notifications: [],
      unreadNotificationsLength: [],
      loading: false,
    };
  },
  computed: {
    ...mapGetters("auth", ["authUser"]),
  },
  methods: {
    bindIcon(notificationMessage) {
      switch (notificationMessage) {
        case "orderCreated":
          return "fa-shopping-bag bg-success text-light";
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
    deleteNotifications() {
      this.loading = true;
      axios
        .delete("/api/notifications")
        .then((res) => {
          this.notifications = [];
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
          document.title = this.$route.meta.title;
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
          message: notification.message,
          url: notification.url,
        },
        read_at: null,
      };
      this.notifications.unshift(newNotification);
      this.unreadNotificationsLength++;
      document.title = `(${this.unreadNotificationsLength}) ${document.title}`;
      if (notification.message == "orderCreated") {
        this.$store.commit("orders/addOrder", notification.order);
      }
      new Audio("/storage/notification.mp3").play();
      if ("Notification" in window) {
        const permission = await Notification.requestPermission();
        if (permission === "granted") {
          new Notification(appName, {
            body: translate("admin." + notification.message),
            icon: appLogo,
            silent: true,
          });
          return;
        }
      }
      fireToast("info", translate("admin." + notification.message));
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
}
.bg-grey {
  background-color: #eeeeee;
}
</style>
