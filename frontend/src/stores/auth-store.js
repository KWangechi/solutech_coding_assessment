import { defineStore } from "pinia";
import { Notify } from "quasar";
import { api } from "src/boot/axios";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: {},
    users: [],
    loading: false,
  }),

  getters: {
    getUser(state) {
      return state.user;
    },
    getUsers(state) {
      return state.users;
    },
  },

  actions: {
    async login(user) {
      this.loading = true;
      try {
        const res = await api.post("/login", user);

        if (res.status === 200) {
          if (res.data.status) {
            this.loading = false;
            Notify.create({
              message: res.data.message,
              type: "positive",
              icon: "check",
              timeout: 3000,
              position: "top-right",
            });

            this.user = res.data.user;
            this.router.replace("/");
          } else {
            this.loading = false;
            Notify.create({
              message: res.data.message,
              type: "negative",
              icon: "close",
              timeout: 3000,
              position: "top-right",
            });
          }
        }
      } catch (error) {
        this.loading = false;

        console.error(error);
        Notify.create({
          message: error.message,
          type: "negative",
          icon: "close",
          timeout: 3000,
          position: "top-right",
        });
      }
    },

    async register(user) {
      api
        .post("/register", user)
        .then((response) => {
          this.user = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    fetchUsers() {
      api
        .get("/users")
        .then((response) => {
          this.users = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchUser() {
      api
        .get("/user")
        .then((response) => {
          this.user = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
});
