<template>
  <div class="container">
    <Head title="Mijn aanvragen" />

    <NavBarOwner></NavBarOwner>

    <section class="add">
      <button class="add__button" @click="create = true">Toevoegen</button>
    </section>

    <div v-if="$page.props.flash.message" class="success_message">{{ $page.props.flash.message }}</div>

    <!-- Current requests of user -->
    <section class="requests">
      <article
        v-for="(request, index) in requests"
        :key="index"
        class="requests__card"
        @click="
          delete_id = request.id;
          this.delete = true;
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

    <!-- Delete request -->
    <article v-if="this.delete" class="delete">
      <button class="delete__delete" @click="destroy()">Verwijderen</button>
      <button class="delete__cancel" @click="this.delete = !this.delete">Annuleren</button>
    </article>

    <!-- Create new request -->
    <form v-if="create == true" class="add_form" @submit.prevent="form.post('/mijn-aanvragen', { onSuccess: () => (create = !create) })">
      <button type="button" class="form__close" @click="create = !create">Sluiten</button>

      <!-- Animal -->
      <label for="animal">Dier</label>
      <select name="animal" id="animal" v-model="form.pet_id">
        <option v-for="(animal, index) in animals" :key="index" :value="animal.id">{{ animal.name }}</option>
      </select>
      <p v-if="errors.pet_id">{{ errors.pet_id }}</p>

      <!-- From -->
      <label for="from">Van</label>
      <input type="date" id="from" name="from" min="2023-01-01" v-model="form.from" />
      <p v-if="errors.from">{{ errors.from }}</p>

      <!-- Till -->
      <label for="till">Tot</label>
      <input type="date" id="till" name="till" min="2023-01-01" v-model="form.till" />
      <p v-if="errors.till">{{ errors.till }}</p>

      <!-- Hourly rate -->
      <label for="rate">Uurtarief</label>
      <input type="number" step="0.01" id="rate" name="rate" v-model="form.hourly_rate" />
      <p v-if="errors.hourly_rate">{{ errors.hourly_rate }}</p>

      <button class="form__submit" type="submit">Aanmaken</button>
    </form>

    <div v-if="create == true || this.delete == true" class="overlay"></div>
  </div>
</template>

<script>
  import { Head, Link, useForm } from "@inertiajs/vue3";
  import NavBarOwner from "@/Components/NavBarOwner.vue";

  export default {
    name: "Animals",
    components: {
      Head,
      Link,
      NavBarOwner,
    },
    props: {
      requests: Object,
      animals: Object,
      errors: Object,
    },
    data() {
      return {
        create: false,
        delete: false,
        delete_id: null,
      };
    },
    setup() {
      const form = useForm({
        pet_id: null,
        from: null,
        till: null,
        hourly_rate: null,
      });

      return { form };
    },
    methods: {
      destroy() {
        this.$inertia.delete(route("requests.destroy", this.delete_id));
        this.delete = false;
      },
    },
  };
</script>

<style lang="scss">
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

  @media only screen and (min-width: 768px) {
    .requests {
      grid-template-columns: 1fr 1fr;
    }
  }

  @media only screen and (min-width: 1150px) {
    .requests {
      grid-template-columns: repeat(3, 1fr);
    }
  }
</style>
