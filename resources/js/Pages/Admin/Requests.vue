<template>
  <div class="container">
    <Head title="Aanvragen overzicht" />
    <NavBarAdmin></NavBarAdmin>

    <section class="filter">
      <select name="type" id="type" v-model="filter_selected" @change="use_filter()">
        <option>Alle</option>
        <option v-for="(type, index) in types" :key="index">{{ type }}</option>
      </select>
    </section>

    <!-- All current requests -->
    <section class="requests">
      <article
        v-for="(request, index) in requests"
        :key="index"
        class="requests__card"
        @click="
          this.delete = true;
          this.delete_id = request.id;
        ">
        <img class="card__image" :src="request.image" />
        <section>
          <h3 class="card__heading">{{ request.name }}</h3>

          <p class="bold">Oppas datum</p>
          <p>{{ request.from + " tot " + request.till }}</p>

          <p class="bold">Uurtarief</p>
          <p>{{ "€" + request.rate }}</p>
        </section>
      </article>
    </section>

    <section v-if="this.delete == true" class="delete">
      <button class="delete__button" @click="destroy()">Verwijderen</button>
      <button class="delete__cancel" @click="this.delete = !this.delete">Annuleren</button>
    </section>

    <div v-if="this.delete == true" class="overlay"></div>
  </div>
</template>

<script>
  import { Head, Link, router } from "@inertiajs/vue3";
  import NavBarAdmin from "@/Components/NavBarAdmin.vue";

  export default {
    name: "Request_overview",
    components: {
      Head,
      Link,
      NavBarAdmin,
    },
    props: {
      requests: Object,
      types: Object,
      filter: String,
    },
    data() {
      return {
        delete: false,
        delete_id: null,
        filter_selected: this.filter,
      };
    },
    methods: {
      use_filter() {
        router.get("/aanvragen/" + this.filter_selected);
      },
      destroy() {
        this.$inertia.delete(route("requests.destroy", this.delete_id));
        this.delete = false;
      },
    },
  };
</script>

<style lang="scss">
  .filter {
    select {
      font-weight: 600;
      width: 130px;
    }

    margin-bottom: 32px;
  }

  .requests {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
    margin-bottom: 130px;
  }

  .requests__card {
    padding: 16px;
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 32px;
    box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.25);
    border-radius: 4px;
  }

  .delete {
    position: absolute;
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

  .delete__button {
    padding: 10px 12px;
    background: #e86868;
    color: #ffff;
    border-radius: 4px;
    font-weight: 600;
    width: 100%;
  }

  .delete__cancel {
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
