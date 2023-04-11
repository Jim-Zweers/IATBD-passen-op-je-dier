<template>
  <div class="container">
    <Head title="Dieren" />

    <NavBarOwner></NavBarOwner>

    <section class="add">
      <button class="add__button" @click="create = true">Toevoegen</button>
    </section>

    <div v-if="$page.props.flash.message" class="success_message">{{ $page.props.flash.message }}</div>

    <!-- Animals of current user -->
    <section class="animals">
      <Link v-for="(animal, index) in animals" :key="index" :href="route('animal.edit', animal.id)">
        <article class="animals__card">
          <img class="card__image" :src="animal.image" />
          <section>
            <h3 class="card__heading">{{ animal.name }}</h3>
            <p class="bold">Beschrijving</p>
            <p>{{ animal.description.slice(0, 75) + "..." }}</p>
          </section>
        </article>
      </Link>
    </section>

    <!-- Adding animals to user -->
    <form v-if="create == true" class="add_form" @submit.prevent="form.post('/dieren', { onSuccess: () => (create = !create) })">
      <button type="button" class="form__close" @click="create = !create">Sluiten</button>

      <!-- Name -->
      <label for="name">Naam</label>
      <input type="text" name="name" id="name" v-model="form.name" />
      <p v-if="errors.name">{{ errors.name }}</p>

      <!-- Description -->
      <label for="description">Beschrijving</label>
      <textarea name="description" id="description" cols="40" rows="5" v-model="form.description"></textarea>
      <p v-if="errors.description">{{ errors.description }}</p>

      <!-- Type -->
      <label for="type">Type</label>
      <select name="type" id="type" v-model="form.type">
        <option v-for="(type, index) in types" :key="index">{{ type }}</option>
      </select>
      <p v-if="errors.type">{{ errors.type }}</p>

      <!-- Image -->
      <label for="image">Afbeelding</label>
      <input type="file" name="image" id="image" @input="form.image = $event.target.files[0]" />
      <p v-if="errors.image">{{ errors.image }}</p>

      <button class="form__submit" type="submit">Aanmaken</button>
    </form>

    <div v-if="create == true" class="overlay"></div>
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
      animals: Object,
      types: Object,
      errors: Object,
    },
    data() {
      return {
        create: false,
        edit: false,
      };
    },
    setup() {
      const form = useForm({
        name: null,
        description: null,
        type: "Hond",
        image: null,
      });

      return { form };
    },
  };
</script>

<style scoped lang="scss">
  .container {
    max-width: none;
  }

  .add {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    margin-bottom: 2rem;
  }

  .animals {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
  }

  .animals__card {
    height: 100%;
    padding: 16px;
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 32px;
    box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.25);
    border-radius: 4px;
  }

  .card__heading {
    margin-bottom: 1rem;
  }

  .card__image {
    width: 100%;
    height: 142px;
    border-radius: 4;
    object-fit: cover;
  }

  @media only screen and (min-width: 768px) {
    .animals {
      grid-template-columns: 1fr 1fr;
    }
  }

  @media only screen and (min-width: 1150px) {
    .animals {
      grid-template-columns: repeat(3, 1fr);
    }
  }
</style>
