<template>
  <div class="container">
    <Head title="Overview" />
    <NavBarSitter></NavBarSitter>

    <section class="filter">
      <select name="type" id="type" v-model="filter_selected" @change="use_filter()">
        <option>Alle</option>
        <option v-for="(type, index) in types" :key="index">{{ type }}</option>
      </select>
    </section>

    <!-- Current requests of user -->
    <section class="requests">
      <Link v-for="(request, index) in requests" :key="index" :href="route('requests.show', request.id)">
        <article class="requests__card">
          <img class="card__image" :src="request.image" />
          <section>
            <h3 class="card__heading">{{ request.name }}</h3>

            <p class="bold">Oppas datum</p>
            <p>{{ request.from + " tot " + request.till }}</p>

            <p class="bold">Uurtarief</p>
            <p>{{ "€" + request.rate }}</p>
          </section>
        </article>
      </Link>
    </section>
  </div>
</template>

<script>
  import { Head, Link, router } from "@inertiajs/vue3";
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
      types: Object,
      filter: String,
    },
    data() {
      return {
        react: false,
        filter_selected: this.filter,
      };
    },
    methods: {
      use_filter() {
        router.get("/aanvragen/" + this.filter_selected);
      },
    },
  };
</script>

<style scoped lang="scss">
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

  .card__image {
    height: 150px;
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

  .delete__delete {
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
