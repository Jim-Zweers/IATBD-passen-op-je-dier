<script setup>
  import GuestLayout from "@/Layouts/GuestLayout.vue";
  import InputError from "@/Components/InputError.vue";
  import InputLabel from "@/Components/InputLabel.vue";
  import PrimaryButton from "@/Components/PrimaryButton.vue";
  import TextInput from "@/Components/TextInput.vue";
  import { Head, Link, useForm } from "@inertiajs/vue3";

  const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "Sitter",
    terms: false,
  });

  const submit = () => {
    form.post(route("register"), {
      onFinish: () => form.reset("password", "password_confirmation"),
    });
  };
</script>

<template>
  <GuestLayout>
    <Head title="Register" />

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="name" value="Naam" />

        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />

        <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="mt-4">
        <InputLabel for="role" value="Wat wil je doen?" />

        <select name="role" id="role" v-model="form.role" required>
          <option value="Sitter">Oppassen</option>
          <option value="Owner">Mijn dier aanbieden</option>
        </select>

        <InputError class="mt-2" :message="form.errors.role" />
      </div>

      <div class="mt-4">
        <InputLabel for="email" value="Email" />

        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Wachtwoord" />

        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4">
        <InputLabel for="password_confirmation" value="Herhaal wachtwoord" />

        <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />

        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> Al een account? </Link>

        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Registreer </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>

<style lang="scss" scoped>
  input {
    border: 3px solid #a663cc;
    padding: 10px 12px;
    font-size: 1rem;
    color: #1c0f13;
    border-radius: 4px;
  }

  button {
    padding: 10px 12px;
    background: #a663cc;
    color: #ffff;
    border-radius: 4px;
    font-weight: 600;
  }

  select {
    width: 100%;
  }
</style>
