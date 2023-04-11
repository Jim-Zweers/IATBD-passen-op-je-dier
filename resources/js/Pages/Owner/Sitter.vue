<template>
  <div class="container">
    <Head :title="sitter.name" />
    <NavBarOwnerVue></NavBarOwnerVue>

    <h1 class="info_title">{{ sitter.name }}</h1>

    <section class="info">
      <div class="info__first">
        <h3>Beschrijving</h3>
        <p>{{ sitter.description }}</p>
      </div>

      <div class="info__middle">
        <h3>Huis foto's</h3>
        <div class="image_grid">
          <img v-for="(image, index) in sitter.image_paths" :key="index" :src="image" />
        </div>
      </div>

      <div class="info__last">
        <h3>Reviews</h3>
        <section class="reviews">
          <article class="reviews__card" v-for="(review, index) in sitter.reviews" :key="index">
            <p class="bold">{{ review.rating }} uit 5</p>
            <p>{{ review.comment }}</p>
          </article>
        </section>
      </div>
    </section>
  </div>
</template>

<script>
  import { Head } from "@inertiajs/vue3";
  import NavBarOwnerVue from "@/Components/NavBarOwner.vue";

  export default {
    name: "Info",
    components: {
      Head,
      NavBarOwnerVue,
    },
    props: {
      sitter: Object,
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
  }

  h3 {
    margin-top: 16px;
  }

  .image_grid {
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

  .reviews {
    margin-top: 8px;
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .reviews__card {
    box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.25);
    border-radius: 4px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  @media only screen and (min-width: 768px) {
    .reviews {
      grid-template-columns: 1fr 1fr;
    }
  }

  @media only screen and (min-width: 1024px) {
    .info {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 32px;
    }

    .info__middle {
      grid-row: 2;
      grid-column: 1/3;
    }

    .reviews {
      grid-template-columns: 1fr;
    }

    .image_grid {
      grid-template-columns: repeat(4, 1fr);
    }
  }

  @media only screen and (min-width: 1150px) {
    .reviews {
      grid-template-columns: 1fr 1fr;
    }

    .image_grid {
      grid-template-columns: repeat(5, 1fr);
    }
  }
</style>
