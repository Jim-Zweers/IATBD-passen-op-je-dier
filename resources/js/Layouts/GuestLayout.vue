<script setup>
  import ApplicationLogo from "@/Components/ApplicationLogo.vue";
  import { Link } from "@inertiajs/vue3";
</script>

<template>
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div>
      <Link href="/">
        <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
      </Link>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dropshadow overflow-hidden sm:rounded-lg">
      <slot />
    </div>
  </div>
</template>

<style lang="scss" scoped>
  .dropshadow {
    border-radius: 4px;
    box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.25);
  }
</style>
