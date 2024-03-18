<template>
  <ValidationObserver v-slot="{ handleSubmit }">
    <form @submit.prevent="handleSubmit(submit)" @keydown.enter.prevent="">
      <SlideOver @close="$emit('close')" :show="show">
        <template #title>
          Change Password
        </template>

        <template #content>
          <TextInput
            v-model="form.name"
            name="Name"
            rules="required|max:50|alpha_spaces"
            injectClass="w-full mt-1 bg-gray-200 text-gray-600"
            label="Name"
            
            disabled
          />
          <TextInput
            v-model="form.currentPassword"
            name="Current Password"
            rules="required|min:8|max:50"
            injectClass="w-full mt-1"
            label="Current Password"
            type="password"
            class="mt-3"
          />
          <TextInput
            v-model="form.newPassword"
            name="New Password"
            rules="required|min:8|max:50|regex:^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]"
            injectClass="w-full mt-1"
            label="New Password"
            type="password"
            class="mt-3"
          />
          <TextInput
            v-model="form.newConfirmPassword"
            name="Confirm New Password"
            rules="required|min:8|max:50|regex:^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]"
            injectClass="w-full mt-1"
            label="Confirm New Password"
            type="password"
            class="mt-3"
          />
        </template>

        <template #footer>
          <div class="flex justify-end space-x-3">
            <span class="shadow-sm">
              <Button
                type="button"
                @clicked="$emit('close')"
                class="bg-white text-gray-700 hover:text-gray-500 border border-gray-300 font-medium shadow-sm focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:leading-5"
                >Cancel</Button
              >
            </span>
            <span class="shadow-md">
              <LoadingButton
                class="bg-teal-600 text-white hover:bg-teal-500 focus:outline-none focus:border-teal-700 focus:shadow-outline-teal border border-transparent shadow-sm transition ease-in-out duration-150 sm:leading-5"
                type="submit"
                :loading="sending"
                >Save Changes</LoadingButton
              >
            </span>
          </div>
        </template>
      </SlideOver>
    </form>
  </ValidationObserver>
</template>

<script>
import SlideOver from "@/Shared/Slide/SlideOver";
import Button from "@/Shared/Buttons/Button";
import LoadingButton from "@/Shared/Buttons/LoadingButton";
import TextInput from "@/Shared/Input/TextInput";
import SelectInput from "@/Shared/Input/SelectInput";
import CryptoAes from "@/Utils/cryptojs-aes";
import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
import {
  required,
  max,
  min,
  regex,
  alpha_spaces,
} from "vee-validate/dist/rules";

extend("required", {
  ...required,
  message: "The {_field_} field is required",
});

extend("min", {
  ...min,
  message: "The {_field_} field must be at least {length} characters",
});

extend("max", {
  ...max,
  message: "The {_field_} field may not be greater than {length} characters",
});

extend("regex", {
  ...regex,
  message:
    "The {_field_} field must contain uppercase, lowercase, number, and special characters as well",
});

extend("alpha_spaces", {
  ...alpha_spaces,
  message:
    "The {_field_} field may only contain alphabetic characters as well as spaces",
});


export default {
  props: {
    show: Boolean,
    user: {
      type: Object,
      default: {},
    },
  },
  components: {
    SlideOver,
    Button,
    LoadingButton,
    TextInput,
    SelectInput,
    ValidationObserver,
    ValidationProvider,
  },
  data() {
    return {
      sending: false,
      form: {
        id: "",
        name: "",
        currentPassword: "",
        newPassword: "",
        newConfirmPassword: ""
      },
    };
  },
  methods: {
    async submit() {
      // this.form._token = this.$page.props.csrf_token;
      let request ={
        id: this.form.id,
        name: this.form.name,
        currentPassword: CryptoAes.encrypt(this.form.currentPassword),
        newPassword: CryptoAes.encrypt(this.form.newPassword),
        newConfirmPassword: CryptoAes.encrypt(this.form.newConfirmPassword),
        _token : this.$page.props.csrf_token
      }


      this.$inertia.post(route("users.change.password"), request, {
        onStart: () => (this.sending = true),
        onFinish: () => {
          this.$page.props.flash.success ? this.$emit("close") : null;
          this.sending = false;
        },
      });
    },
  },
  mounted(){
    this.form = this.user
  },
  watch: {
    user() {
      if (JSON.stringify(this.user) !== "{}") {
        // console.log(' masuk')

        this.form = {
          id: this.user.id,
          name: this.user.name,
        };
      }else{
        // console.log('kaga masuk')
      }
    },
  },
};
</script>
