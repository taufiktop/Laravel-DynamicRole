<template>
  <layout>
    <!-- <Card>Welcome, {{ $page.props.auth.user.name }}</Card> -->
    <Card>Welcome, Taufik</Card>
    <FlashToast />

  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";
import Card from "@/Shared/Card";
import FlashToast from "@/Shared/Toast/Toast";

export default {
  components: {
    Layout,
    Card,
    FlashToast
  },
};
</script>
