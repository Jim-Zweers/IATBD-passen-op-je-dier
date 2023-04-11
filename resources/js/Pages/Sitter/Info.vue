<template>
  <div class="container">
    <Head title="Mijn info" />
    <NavBarSitter></NavBarSitter>

    <h1 class="info_title">Mijn info</h1>

    <!-- Edit User -->
    <form class="user_edit_form" @submit.prevent="form.post('/mijn-info')">
      <!-- Description -->
      <div>
        <label for="description">Beschrijving</label>
        <textarea name="description" id="description" cols="40" rows="5" v-model="form.description"></textarea>
        <p v-if="errors.description">{{ errors.description }}</p>
      </div>

      <div>
        <label for="images">Huis foto's</label>
        <input type="file" name="images" id="images" @input="images($event.target.files)" multiple />
        <p v-if="errors.image">{{ errors.image }}</p>
      </div>

      <div class="form__image_grid">
        <img v-for="(image, index) in user.image_paths" :key="index" :src="image" />
      </div>

      <button class="form__submit" type="submit">Bijwerken</button>
    </form>
  </div>
</template>

<script>
  import { Head, useForm } from "@inertiajs/vue3";
  import NavBarSitter from "@/Components/NavBarSitter.vue";

  export default {
    name: "Info",
    components: {
      Head,
      NavBarSitter,
    },
    props: {
      user: Object,
      images: Object,
      errors: Object,
    },
    setup(props) {
      const form = useForm({
        description: props.user.description,
        images: [],
      });

      return { form };
    },
    methods: {
      images(files) {
        for (let image of files) {
          this.form.images.push(image);
        }
      },
    },
  };
</script>

<style scoped lang="scss">
  .info_title {
    margin-bottom: 32px;
  }

  .user_edit_form {
    label {
      font-size: 1.5rem;
      font-weight: 600;
    }

    textarea {
      margin-bottom: 32px;
      width: 100%;
    }

    input[type="file"] {
      margin-top: 8px;
      width: 100%;
    }

    margin-bottom: 130px;
  }

  .form__image_grid {
    display: grid;
    margin-top: 16px;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
      backdrop-filter: blur(2px);
      border-radius: 2px;
    }
  }

  @media only screen and (min-width: 768px) {
    textarea {
      height: 220px;
    }
  }

  @media only screen and (min-width: 1024px) {
    .user_edit_form {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 16px;
    }

    .form__submit {
      grid-column: 1/3;
      max-width: 160px;
    }

    .form__image_grid {
      grid-column: 1/3;
      grid-template-columns: repeat(5, 1fr);
    }
  }
</style>
