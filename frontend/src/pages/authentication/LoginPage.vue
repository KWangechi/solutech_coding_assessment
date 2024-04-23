<template>
  <q-layout>
    <q-page-container>
      <q-page padding>
        <q-card class="text-center">
          <div class="text-h6">Login with Your Email</div>
          <div class="errors q-mt-lg text-red bg-red-1">This should be an error</div>
          <q-card-section>
            <q-form class="q-gutter-lg">
              <q-input
                v-model="user.email"
                type="email"
                outlined
                label="Email Address"
                clearable
              ></q-input>
              <q-input
                v-model="user.password"
                :type="isPasswd ? 'password' : 'text'"
                label="Password"
                outlined
                clearable
              >
                <template #append>
                  <q-icon
                    @click="isPasswd = !isPasswd"
                    :name="isPasswd ? 'visibility_off' : 'visibility_on'"
                    style="cursor: pointer"
                  ></q-icon>
                </template>
              </q-input>
              <q-btn
                :label="!loading ? 'Continue' : ''"
                class="bg-primary text-white"
                @click="login"
              >
                <q-spinner class="text-center" v-if="loading"></q-spinner
              ></q-btn>
            </q-form>
            <div class="text-center text-bold q-mt-lg">Don't have an account? <router-link to="/register">Register Here</router-link></div>
          </q-card-section>
        </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "src/stores/auth-store";
import { ref } from "vue";

const user = ref({});
const isPasswd = ref(true);
const authStore = useAuthStore();

const { loading } = storeToRefs(authStore);

function login() {
  // console.log()
  authStore.login(user.value);
}
</script>

<style scoped>
.q-card {
  width: 40%;
  margin: auto;
}
</style>
