<template>
  <div>
  <form v-if="!forgotMode" @submit.prevent="submit">
    <div
      class="flex items-center sm:justify-center justify-between md:space-x-5 p-5 h-screen"
    >
      <!-- <div class="hidden md:block md:w-1/2 lg:w-1/2">
        <img :src="$page.props.svg.login" />
      </div> -->
      <div
 
        class="flex flex-col space-y-5 w-full sm:w-2/3 md:w-1/3 -mt-16"
        style="max-height: 350px"
      >
        <div class="flex justify-center space-x-2">
          <div
            class="text-3xl font-semibold text-orange-600"
            style="text-shadow: 0px 5px 5px rgba(56, 178, 172, .3);"
          >
            CMS Sushy Yay
          </div>
          <div
            class="text-3xl font-semibold opacity-75 text-orange-600"
            style="text-shadow: 0px 5px 5px rgba(56, 178, 172, .3);"
          >
            Altech
          </div>
        </div>
        <div  class="flex justify-center text-lg mb-5">
          <div class="border-b-2 border-gray-700">W</div>
          <div class="">elcome Back</div>
        </div>

        <div class="flex flex-col space-y-2">
          <label>Username</label>
          <input
            v-model="form.username"
            :error="errors.username"
            type="text"
            spellcheck="false"
            name="username"
            class="transition ease-in duration-200 w-full py-2 bg-gray-200 rounded outline-none border-l-4 border-transparent focus:border-l-4 focus:border-orange-600 px-3"
            autofocus
            required
            value=""
            autocomplete="off"
          />
        </div>
        <div class="flex flex-col space-y-2">
          <label>Password</label>
          <div class="relative">
            <input
              v-model="form.password"
              :error="errors.password"
              ref="pass"
              type="password"
              spellcheck="false"
              name="password"
              class="transition ease-in duration-200 w-full py-2 bg-gray-200 rounded outline-none border-l-4 border-transparent focus:border-l-4 focus:border-orange-600 px-3"
              required
              autocomplete="off"
            />
            <div
              class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
              @click="
                show = !show;
                show
                  ? ($refs.pass.type = 'text')
                  : ($refs.pass.type = 'password');
              "
            >
              <span class="text-gray-700 sm:text-sm sm:leading-5">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="flex flex-shrink-0 fill-current w-4 h-4 text-gray-700"
                  v-show="!show"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M19.604 2.562l-3.346 3.137c-1.27-.428-2.686-.699-4.243-.699-7.569 0-12.015 6.551-12.015 6.551s1.928 2.951 5.146 5.138l-2.911 2.909 1.414 1.414 17.37-17.035-1.415-1.415zm-6.016 5.779c-3.288-1.453-6.681 1.908-5.265 5.206l-1.726 1.707c-1.814-1.16-3.225-2.65-4.06-3.66 1.493-1.648 4.817-4.594 9.478-4.594.927 0 1.796.119 2.61.315l-1.037 1.026zm-2.883 7.431l5.09-4.993c1.017 3.111-2.003 6.067-5.09 4.993zm13.295-4.221s-4.252 7.449-11.985 7.449c-1.379 0-2.662-.291-3.851-.737l1.614-1.583c.715.193 1.458.32 2.237.32 4.791 0 8.104-3.527 9.504-5.364-.729-.822-1.956-1.99-3.587-2.952l1.489-1.46c2.982 1.9 4.579 4.327 4.579 4.327z"
                  />
                </svg>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="flex flex-shrink-0 fill-current w-4 h-4 text-gray-700"
                  v-show="show"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M12.015 7c4.751 0 8.063 3.012 9.504 4.636-1.401 1.837-4.713 5.364-9.504 5.364-4.42 0-7.93-3.536-9.478-5.407 1.493-1.647 4.817-4.593 9.478-4.593zm0-2c-7.569 0-12.015 6.551-12.015 6.551s4.835 7.449 12.015 7.449c7.733 0 11.985-7.449 11.985-7.449s-4.291-6.551-11.985-6.551zm-.015 3c-2.209 0-4 1.792-4 4 0 2.209 1.791 4 4 4s4-1.791 4-4c0-2.208-1.791-4-4-4z"
                  />
                </svg>
              </span>
            </div>
          </div>
        </div>
        <div class="flex justify-center">

          <vue-recaptcha
            v-if="login_attempt>=3"
            sitekey="6Lfpc7weAAAAAKWTsyJo6lFHhnCpgrR9_iXydxgM"
            :loadRecaptchaScript="true"
            ref="recaptcha"
            type="invisible"
            @verify="onCaptchaVerified"
            @expired="onCaptchaExpired"
          >
          </vue-recaptcha>

        </div>
        <div>

          <button
            v-if="login_attempt>=3 && !validateCaptcha"
            class="cursor-not-allowed opacity-50 mt-4 w-full p-2 bg-orange-600 font-semibold text-white focus:outline-none focus:border-orange-700 focus:shadow-outline-orange border border-transparent shadow-sm transition ease-in-out duration-150 sm:leading-5 h-12"
            >SIGN IN
          </button>

          <loading-button
            v-if="login_attempt<3 || validateCaptcha"
            :loading="sending"
            class="mt-4 w-full p-2 bg-orange-600 font-semibold text-white hover:bg-orange-500 focus:outline-none focus:border-orange-700 focus:shadow-outline-orange border border-transparent shadow-sm transition ease-in-out duration-150 sm:leading-5 h-12"
            type="submit"
            >SIGN IN
          </loading-button>
          <span @click="forgotMode=!forgotMode" class="mt-2 cursor-pointer text-sm font-semibold underline">Forgot Your Password ? </span>
        </div>
        
      </div>


    </div>
    
  </form>
  <form  v-if="forgotMode" @submit.prevent="submitForgotPass">
    <div
      class="flex items-center sm:justify-center justify-between md:space-x-5 p-5 h-screen"
    >
      <div class="hidden md:block md:w-1/2 lg:w-1/2">
        <img :src="$page.props.svg.login" />
      </div>

      <div
       
        class="flex flex-col space-y-5 w-full sm:w-2/3 md:w-1/3 -mt-16"
        style="max-height: 350px"
      >
        <div class="flex justify-center space-x-2">
          <div
            class="text-3xl font-semibold text-orange-600"
            style="text-shadow: 0px 5px 5px rgba(56, 178, 172, .3);"
          >
            CMS LMS
          </div>
          <div
            class="text-3xl font-semibold opacity-75 text-orange-600"
            style="text-shadow: 0px 5px 5px rgba(56, 178, 172, .3);"
          >
            ACC
          </div>
        </div>
        <div  class="flex justify-center text-lg mb-5">
          <div class="border-b-2 border-gray-700">F</div>
          <div class="">orgot Password</div>
        </div>

        <div class="flex flex-col space-y-2">
          <label>Email</label>
          <input
            v-model="form.email"
            :error="errors.email"
            type="email"
            spellcheck="false"
            name="email"
            class="transition ease-in duration-200 w-full py-2 bg-gray-200 rounded outline-none border-l-4 border-transparent focus:border-l-4 focus:border-orange-600 px-3"
            autofocus
            required
            value=""
            autocomplete="off"
          />
        </div>

        <div class="flex justify-center">

          <vue-recaptcha
            
            sitekey="6Lfpc7weAAAAAKWTsyJo6lFHhnCpgrR9_iXydxgM"
            :loadRecaptchaScript="true"
            ref="recaptcha"
            type="invisible"
            @verify="onCaptchaVerified"
            @expired="onCaptchaExpired"
          >
          </vue-recaptcha>

        </div>
        <div>

          <button
            v-if=" !validateCaptcha"
            class="cursor-not-allowed opacity-50 mt-4 w-full p-2 bg-orange-600 font-semibold text-white focus:outline-none focus:border-orange-700 focus:shadow-outline-orange border border-transparent shadow-sm transition ease-in-out duration-150 sm:leading-5 h-12"
            >FORGOT PASSWORD 
          </button>

          <loading-button
            v-if=" validateCaptcha"
            :loading="sending"
            class="mt-4 w-full p-2 bg-orange-600 font-semibold text-white hover:bg-orange-500 focus:outline-none focus:border-orange-700 focus:shadow-outline-orange border border-transparent shadow-sm transition ease-in-out duration-150 sm:leading-5 h-12"
            type="submit"
            >FORGOT PASSWORD 
          </loading-button>
          <span @click="forgotMode=!forgotMode" class="mt-2 cursor-pointer text-sm font-semibold underline">Already Have Account? Login Here </span>
        </div>
        
      </div>
    </div>
    
  </form>
  <FlashToast />
  </div>
</template>

<script>
import LoadingButton from "@/Shared/Buttons/LoadingButton";
import TextInput from "@/Shared/TextInput";
import FlashToast from "@/Shared/Toast/Toast";
import CryptoAes from "@/Utils/cryptojs-aes";
import { VueRecaptcha } from 'vue-recaptcha';
import { ref, reactive, defineComponent } from 'vue-demi'

export default {
  props: {
    errors: {
      type: Object,
      default: () => {
        return {
          username: "",
          password: "",
          email:"",
        };
      },
    },
    login_attempt: {
      required: false,
      type: Number,
      default: 0,
    },
  },
  components: {
    LoadingButton,
    TextInput,
    FlashToast,
    VueRecaptcha,
    ref, 
    reactive, 
    defineComponent, 
  },
  data() {
    return {
      sending: false,
      form: {
        username: "",
        password: "",
        recaptcha:"",
      },
      validateCaptcha:false,
      forgotMode:false,
      show: false,
    };
  },
  methods: {
    submit() {
      if((this.login_attempt>=3 && this.validateCaptcha) || ((this.login_attempt<3))){
        // console.log('masuk')
      
      // let encKey = "YollowAJAH"; 
      // let iv = this.$CryptoJS.enc.Hex.parse("AEZAKMI123");
      // let iv = "YEEE";

      // var encryptedText = this.$CryptoJS.AES.encrypt(this.form.username, encKey, { iv: iv }).toString();
      // let app_key = (document.querySelector('meta[name="app_key"]').content).split(":")[1];

      // console.log(app_key)
      // let request ={
      //   _token : this.$page.props.csrf_token,
      //   username : this.$CryptoJS.AES.encrypt(this.form.username, app_key).toString(),
      //   password : this.$CryptoJS.AES.encrypt(this.form.password, app_key).toString(),
      // }
      let request ={
        _token : this.$page.props.csrf_token,
        username : CryptoAes.encrypt(this.form.username),
        password : CryptoAes.encrypt(this.form.password),

        
        // password : this.$CryptoJS.AES.decrypt(request.password, app_key),
      }


      // let request ={
      //   _token : this.$page.props.csrf_token,
      //   username : this.form.username,
      //   password : this.form.password
      // }


      // console.log(request)
      this.$inertia.post(route("login"), request, {
        onStart: () => (this.sending = true,this.login_attempt>=3?this.$refs.recaptcha.reset():''),
        onFinish: () => (this.sending = false,this.validateCaptcha=false),
      });
      }
    },
    submitForgotPass(){
      if(this.validateCaptcha){
        let request ={
          _token : this.$page.props.csrf_token,
          email : CryptoAes.encrypt(this.form.email),

        }
        this.$inertia.post(route("forget.pass"), request, {
          onStart: () => (this.sending = true),
          onFinish: () => (this.sending = false,this.validateCaptcha=false,this.$refs.recaptcha.reset(),this.form.email='',this.forgotMode=false),
        });
      }
      // console.log('Masuk')
    },
    onCaptchaVerified(recaptchaToken) {
      this.form.recaptcha = recaptchaToken
      this.validateCaptcha = true
    },
    onCaptchaExpired() {
      this.$refs.recaptcha.reset();
    },
  },
  mounted() {
    
  },
};
</script>
