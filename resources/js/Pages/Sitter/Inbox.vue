<template>
  <div class="container">
    <Head title="Inbox" />
    <NavBarSitter></NavBarSitter>

    <!-- Current requests of user -->
    <section class="requests">
      <article v-for="(request, index) in requests" :key="index" class="requests__card">
        <img class="card__image" :src="request.image" />
        <section>
          <h3 class="card__heading">{{ request.name }}</h3>

          <p class="bold">Oppas datum</p>
          <p>{{ request.from + " tot " + request.till }}</p>

          <p class="bold">status</p>
          <p v-if="request.status">Geaccepteerd</p>
          <p v-else-if="request.status == false">Geweigerd</p>
          <p v-else>In afwachting</p>
        </section>
      </article>
    </section>
  </div>
</template>

<script>
  import { Head, Link } from "@inertiajs/vue3";
  import NavBarSitter from "@/Components/NavBarSitter.vue";

  export default {
    name: "Overview",
    components: {
      Head,
      Link,
      NavBarSitter,
    },
    props: {
      requests: Object,
    },
  };
</script>

<style scoped lang="scss">
  .requests {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
  }

  .requests__card {
    padding: 16px;
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 32px;
    box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.25);
    border-radius: 4px;
  }

  @media only screen and (min-width: 600px) {
    .container {
      margin: 0;
      max-width: none;
    }

    .requests {
      grid-template-columns: 1fr 1fr;
    }
  }

  @media only screen and (min-width: 1100px) {
    .requests {
      grid-template-columns: 1fr 1fr 1fr;
    }
  }
</style>
