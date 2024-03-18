<template>

    <div class="block text-sm">
      <span class="text-gray-700 text-sm" v-if="label">{{ label }}</span>
      <vue-editor 
        v-model="editorContent"
      ></vue-editor>

    </div>
</template>

<script>
import { VueEditor } from 'vue2-editor';

export default {
  name: "TextEditor",
  components: {
    VueEditor,
  },
  props: {
    content: String,
    label: String,
    name: {
      type: String,
      default: "",
    },
  },
  computed: {
    editorContent: {
      get() { return this.content},
      set(updatedContent) { this.$emit('update:content', updatedContent) }
    },
  },
};
</script>
