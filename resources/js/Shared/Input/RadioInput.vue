<template>
  <ValidationProvider
    tag="div"
    :rules="rules"
    :name="name"
    :vid="vid"
    mode="eager"
    v-slot="{ errors }"
  >
    <div class="block">
      <span class="text-gray-700 text-sm" v-if="label">{{ label }}</span>
      <div class="flex space-x-2 text-sm">
        <label
          class="inline-flex items-center"
          v-for="(opt, index) in options"
          :key="index"
        >
          <input
            type="radio"
            class="form-radio text-teal-600 h-4 w-4"
            v-model="checkedData"
            v-bind="$attrs"
            :class="[{ error: errors[0] }, injectClass]"
            :value="getCheckboxLabel(opt, labelValue)"
          />
          <span class="ml-1 cursor-pointer select-none">{{
            getCheckboxLabel(opt, labelText)
          }}</span>
        </label>
      </div>
      <span class="form-error">{{ errors[0] }}</span>
    </div>
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from "vee-validate";

export default {
  name: "RadioInput",
  components: {
    ValidationProvider,
  },
  props: {
    value: {
      type: String,
      default:"",
    },
    rules: {
      type: [String, Object],
      default: "",
    },
    name: {
      type: String,
      default: "",
    },
    vid: {
      type: String,
      default: undefined,
    },
    type: {
      type: String,
      default: "text",
    },
    label: String,
    injectClass: {
      required: false,
      type: String,
    },
    options: {
      type: Array,
      default: () => [],
    },
    labelValue: {
      type: String,
    },
    labelText: {
      type: String,
    },
  },
  data() {
    return {
      checkedData:"",
    };
  },
  computed:{
    // checkedData2 () {
    //   return {...this.value}
    // }
    // if(this.value != ""){
    //   this.checkedData = this.value;
    // }
  },
  methods: {
    getCheckboxLabel(opt, label) {
      // console.log(opt,label)
      return label ? opt[label] : opt;
    },
  },
  
  watch: {

    checkedData() {
      if(JSON.stringify(this.value) !== "" && this.checkedData==""){
        this.checkedData = this.value;
      }
      return this.$emit("input", this.checkedData);
    },
  },
};
</script>
