<template>
  <div class="bg-light min-h-screen">
    <Sidebar />
    <Header />
    <Main>
      <template #content>
        <slot />
      </template>
    </Main>
  </div>
</template>

<script>
import Sidebar from "@/Shared/Sidebar";
import Header from "@/Shared/Header";
import Main from "@/Shared/Main";

export default {
  components: {
    Sidebar,
    Header,
    Main,
  },
};
</script>
