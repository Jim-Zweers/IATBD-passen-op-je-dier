<template>
  <nav class="nav_bar">
    <ul class="nav_bar__list">
      <li class="nav_bar__list_item">
        <Link :href="route('requests.index', 'Alle')">Aanvragen</Link>
      </li>
      <li class="nav_bar__list_item">
        <Link :href="route('users.index')">Gebruikers</Link>
      </li>
      <li class="nav_bar__list_item">
        <Link :href="route('user.logout')">Uitloggen</Link>
      </li>
    </ul>
  </nav>
</template>

<script>
  import { Link } from "@inertiajs/vue3";

  export default {
    name: "NavBarAdmin",
    components: {
      Link,
    },
  };
</script>

<style lang="scss">
  .nav_bar {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100vw;
    height: 10vh;
    background: rgba(176, 116, 210, 0.75);
    display: flex;
  }

  .nav_bar__list {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    background: rgba(176, 116, 210, 1);
    height: 75%;
    padding: 16px;
    align-self: flex-end;
  }

  .nav_bar__list_item {
    width: 100%;
    height: 100%;
    display: flex;
  }

  .nav_bar__list_item > a {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    font-size: 1.125rem;
    font-weight: 600;
  }

  @media only screen and (min-width: 1024px) {
    .nav_bar {
      position: relative;
      margin: -16px -16px 16px -16px;
    }

    .nav_bar__list {
      justify-content: flex-start;
      gap: 3rem;
      align-self: flex-start;
    }

    .nav_bar__list_item {
      width: fit-content;
    }
  }
</style>
