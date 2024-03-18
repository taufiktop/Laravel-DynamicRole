<template> </template>

<script>
export default {
  watch: {
    "$page.props.flash": {
      handler() {
        this.$page.props.flash.success
          ? this.$toast.success(this.$page.props.flash.success)
          : null;
        this.$page.props.flash.error
          ? this.$toast.error(this.$page.props.flash.error)
          : null;
      },
      deep: true,
    },
    "$page.props.errors": {
      handler() {
        let obj = Object.keys(this.$page.props.errors);

        obj.length > 0
          ? this.$toast.error(this.$page.props.errors[obj[0]][0])
          : null;
      },
      deep: true,
    },
  },
};
</script>
