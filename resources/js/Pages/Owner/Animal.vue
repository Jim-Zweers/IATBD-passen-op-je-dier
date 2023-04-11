<template>
  <div class="container">
    <Head :title="animal.name" />

    <NavBarOwner></NavBarOwner>

    <!-- Edit animal -->
    <form class="edit_form" @submit.prevent="form.put('/dieren/bewerk/' + animal.id)">
      <img :src="animal.image" />

      <!-- Name -->
      <div class="form__input">
        <label for="name">Naam</label>
        <input type="text" name="name" id="name" v-model="form.name" />
        <p v-if="errors.name">{{ errors.name }}</p>
      </div>

      <!-- Description -->
      <div class="form__input">
        <label for="description">Beschrijving</label>
        <textarea name="description" id="description" cols="40" rows="5" v-model="form.description"></textarea>
        <p v-if="errors.description">{{ errors.description }}</p>
      </div>

      <div class="form__buttons">
        <button class="form__submit" type="submit">Bijwerken</button>
        <button class="form__delete" type="button" @click="destroy(animal.id)">Verwijderen</button>
      </div>
    </form>
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
      animal: Object,
      errors: Object,
    },
    setup(props) {
      const form = useForm({
        name: props.animal.name,
        description: props.animal.description,
      });

      return { form };
    },
    methods: {
      destroy(id) {
        this.$inertia.delete(route("animal.destroy", id));
      },
    },
  };
</script>

<style scoped lang="scss">
  .edit_form {
    display: flex;
    flex-direction: column;

    .form__input {
      display: flex;
      flex-direction: column;
    }
  }

  .edit_form > img {
    width: 100%;
    height: 15rem;
    object-fit: cover;
    border-radius: 4px;
  }

  .form__buttons {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-top: 32px;
  }

  .form__submit {
    margin: 0;
  }

  .form__delete {
    padding: 10px 12px;
    background: #e86868;
    color: #ffff;
    border-radius: 4px;
    font-weight: 600;
  }

  @media only screen and (min-width: 768px) {
    .edit_form > img {
      height: 25rem;
    }
  }

  @media only screen and (min-width: 1000px) {
    .edit_form {
      display: grid;
      grid-template-columns: 1fr 2fr;
      column-gap: 32px;
      row-gap: 16px;

      > img {
        grid-column: 1;
        grid-row: 1 / 8;
      }

      label {
        margin-top: 0;
      }

      input,
      textarea {
        max-width: 40rem;
      }

      .form__buttons {
        grid-column: 2;
      }
    }
  }
</style>
