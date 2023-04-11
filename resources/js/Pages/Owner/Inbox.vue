<template>
  <div class="container">
    <Head title="Inbox" />

    <NavBarOwner></NavBarOwner>

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
        <Link :href="route('sitter.show', request.sitter_id)">
          <img class="card__image" :src="request.image" />
        </Link>
        <section>
          <h3 class="card__heading">{{ request.sitter_name }}</h3>

          <p class="bold">Voor</p>
          <p>{{ request.pet_name }}</p>

          <div
            v-if="request.accepted && request.reviewable"
            class="card__review"
            @click="
              review = true;
              form.request_id = request.id;
            ">
            Review
          </div>

          <div v-else-if="request.reviewed" class="card__accepted">Afgerond</div>
          <div v-else-if="request.accepted" class="card__accepted">Geaccepteerd</div>

          <div v-else class="card__buttons">
            <button class="card__accept" @click="accept(request.id)">Accepteren</button>
            <button class="card__reject" @click="reject(request.id)">Weigeren</button>
          </div>
        </section>
      </article>

      <form
        v-if="review == true"
        class="review_form"
        @submit.prevent="
          form.post('/aanvraag/review', { onSuccess: () => form.reset });
          this.review = false;
        ">
        <button type="button" class="form__close" @click="review = !review">Sluiten</button>

        <!-- Rating -->
        <label for="rating">Score</label>
        <input type="number" min="1" max="5" name="rating" id="rating" v-model="form.rating" />
        <p v-if="errors.rating">{{ errors.rating }}</p>

        <!-- Comment -->
        <label for="comment">Commentaar</label>
        <textarea name="comment" id="comment" cols="40" rows="5" v-model="form.comment"></textarea>
        <p v-if="errors.comment">{{ errors.comment }}</p>

        <p v-if="errors.request_id">{{ errors.request_id }}</p>

        <button class="form__submit" type="submit">Aanmaken</button>
      </form>

      <div v-if="review == true" class="overlay"></div>
    </section>
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
      errors: Object,
    },
    data() {
      return {
        review: false,
        request_id: null,
      };
    },
    setup() {
      const form = useForm({
        request_id: null,
        rating: null,
        comment: null,
      });

      return { form };
    },
    methods: {
      accept(id) {
        this.$inertia.put(route("requests.accept", id));
      },
      reject(id) {
        this.$inertia.put(route("requests.reject", id));
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

  .card__accepted {
    text-align: center;
    width: 100%;
    margin-top: 16px;
    padding: 10px 12px;
    color: #ffff;
    border-radius: 4px;
    font-weight: 600;
    background: #58bc82;
  }

  .card__buttons {
    margin-top: 16px;
    display: flex;
    gap: 4px;
  }

  .card__accept,
  .card__reject,
  .card__review {
    padding: 10px 12px;
    color: #ffff;
    border-radius: 4px;
    font-weight: 600;
  }

  .card__accept {
    background: #58bc82;
  }

  .card__reject {
    background: #e86868;
  }

  .card__review {
    margin-top: 8px;
    background: #a663cc;
    text-align: center;
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
