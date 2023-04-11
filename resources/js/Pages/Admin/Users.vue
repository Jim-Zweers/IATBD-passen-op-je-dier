<template>
  <div class="container">
    <Head title="Gebruikers overzicht" />
    <NavBarAdmin></NavBarAdmin>

    <!-- All current users -->
    <section class="users">
      <article
        v-for="(user, index) in users"
        :key="index"
        class="users__card"
        @click="
          this.block = true;
          this.block_id = user.id;
        ">
        <h3>Naam</h3>
        <p>{{ user.name }}</p>
        <h3>Email</h3>
        <p>{{ user.email }}</p>
        <h3>Status</h3>
        <p class="bold">{{ user.status }}</p>
      </article>
    </section>

    <section v-if="this.block == true" class="block">
      <button class="block__button" @click="block_user()">Blokkeren</button>
      <button class="block__cancel" @click="this.block = !this.block">Annuleren</button>
    </section>

    <div v-if="this.block == true" class="overlay"></div>
  </div>
</template>

<script>
  import { Head, Link } from "@inertiajs/vue3";
  import NavBarAdmin from "@/Components/NavBarAdmin.vue";

  export default {
    name: "Users_overview",
    components: {
      Head,
      Link,
      NavBarAdmin,
    },
    props: {
      users: Object,
    },
    data() {
      return {
        block: false,
        block_id: null,
      };
    },
    methods: {
      block_user() {
        this.$inertia.put(route("user.block", this.block_id));
        this.block = false;
      },
    },
  };
</script>

<style scoped lang="scss">
  .users {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
    margin-bottom: 130px;
  }

  .users__card {
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.25);
    border-radius: 4px;
  }

  .block {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 16px;
    background: #ffff;
    border-radius: 4px;
    display: flex;
    flex-direction: row;
    gap: 8px;
    z-index: 3;
    width: 90%;
    max-width: 380px;
  }

  .block__button {
    padding: 10px 12px;
    background: #e86868;
    color: #ffff;
    border-radius: 4px;
    font-weight: 600;
    width: 100%;
  }

  .block__cancel {
    padding: 10px 12px;
    background: #a663cc;
    color: #ffff;
    border-radius: 4px;
    font-weight: 600;
    width: 100%;
  }

  @media only screen and (min-width: 600px) {
    .container {
      margin: 0;
      max-width: none;
    }

    .users {
      grid-template-columns: 1fr 1fr;
    }
  }

  @media only screen and (min-width: 1100px) {
    .users {
      grid-template-columns: 1fr 1fr 1fr;
    }
  }
</style>
