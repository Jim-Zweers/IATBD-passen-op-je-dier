<template>
  <div class="container">
    <Head :title="'Aanvraag ' + animal.name" />

    <NavBarSitter></NavBarSitter>
    <h1 class="request__name">{{ animal.name }}</h1>

    <section class="request__grid">
      <img :src="animal.image" class="request__image" />

      <div>
        <h3>Beschrijving</h3>
        <p class="request__info">{{ animal.description }}</p>
      </div>
      <div>
        <h3>Oppas datum</h3>
        <p class="request__info">{{ request.from + " tot " + request.till }}</p>
      </div>
      <div>
        <h3>Uurtarief</h3>
        <p class="request__info">{{ "€" + request.hourly_rate }}</p>
      </div>

      <button class="request__button" @click="sign_up()">Aanmelden</button>
    </section>
  </div>
</template>

<script>
  import { Head, Link, router } from "@inertiajs/vue3";
  import NavBarSitter from "@/Components/NavBarSitter.vue";

  export default {
    name: "Request",
    components: {
      Head,
      Link,
      NavBarSitter,
    },
    props: {
      request: Object,
      animal: Object,
    },
    methods: {
      sign_up() {
        router.put("/aanvraag/sign-up/" + this.request.id);
      },
    },
  };
</script>

<style scoped lang="scss">
  .request__name {
    margin-bottom: 32px;
  }

  .request__image {
    width: 100%;
    max-height: 250px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 16px;
  }

  .request__info {
    margin-bottom: 16px;
  }

  .request__button {
    margin-top: 16px;
    width: 100%;
    max-width: 400px;
  }

  @media only screen and (min-width: 768px) {
    .request__image {
      max-height: 400px;
    }

    .request__grid {
      display: grid;
      grid-template-columns: 0.5fr 1.5fr;
      column-gap: 32px;
      row-gap: 8px;

      .request__image {
        grid-row: 1/ 4;
        margin: 0;
      }

      > div {
        grid-column: 2;
      }

      .request__button {
        grid-column: 2;
        max-width: 10rem;
      }
    }
  }

  @media only screen and (min-width: 1200px) {
    .request__grid {
      grid-template-columns: 0.75fr 1.5fr;
    }
  }
</style>
