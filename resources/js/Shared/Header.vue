<template>
  <div
    id="myheader"
    class="fixed inset-y-0 md:ml-64 z-50 bg-teal-500 w-full md:w-side h-16 transform transition-all duration-300 ease-in-out header"
  >
    <div class="flex justify-between md:justify-end items-center h-full px-5">
    <!-- <div class="flex justify-between items-center h-full px-5"> -->
      <button
        class="md:hidden px-4 py-3 bg-teal-400 hover:bg-teal-300 transition duration-300 focus:outline-none rounded"
        @click="toggleSidebar()"
      >
        <svg
          class="fill-current flex-shrink-0 w-4 h-4 text-gray-100"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
        >
          <path d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z" />
        </svg>
      </button>
      <div class=" px-2 md:inline-block text-left">

        <div @click="early_warning=false;sub_profile=!sub_profile;" class="cursor-pointer flex items-center space-x-2">
        <!-- <div @click="sub_profile=!sub_profile" class=" flex items-center space-x-2"> -->
          
          <img :src="imgurl" class="rounded-full h-10 w-10" />
          <span class="text-gray-50">{{ $page.props.auth.user.name }}</span>
            <!-- <img :src="imgurl" class="rounded-full h-10 w-10" />
            <span class="text-gray-50">{{ $page.props.auth.user.name }}</span> -->
            <!-- <button class="mt-1 capitalize inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 focus:outline-none bg-white text-sm text-gray-700 " id="menu-button2" aria-expanded="true" aria-haspopup="true">test</button> -->
            
          <!-- </div> -->
        </div>
        <div v-show="sub_profile" class=" origin-top-right absolute  z-10 right-0 mt-3 w-auto border-3 rounded-md shadow-lg bg-white focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
          <div class="py-2 px-4 min-w-full ">
            <div @click="showSlideUserChangePass=!showSlideUserChangePass;sub_profile=!sub_profile" class="p-2 flex space-x-2 text-sm font-semibold cursor-pointer rounded text-gray-600 hover:text-gray-800 hover:bg-gray-300">
            <IconKey
              size="h4 w-4"
              class="text-gray-800 hover:text-gray-800"
            />
            <span class="">Change Password</span>
            </div>
          </div>
        </div>
        <div v-show="early_warning" class=" origin-top-right absolute  z-10 right-0 mt-3 w-auto border-3 rounded-md shadow-lg bg-yellow-300 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
          <div class="py-2 px-4 min-w-full ">
            <div  class="p-2 flex space-x-2 text-sm font-semibold rounded text-gray-800 ">
           
              <span class="">Please change your gernerated password immediately !!</span>
              <!-- <div
                class="absolute right-0 flex items-center p-2 cursor-pointer"
                @click="early_warning=!early_warning"
              >
                  <vx-cross size="h-4 w-4"></vx-cross>
              </div> -->
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <div v-if="showSlideUserChangePass" class="absolute top-0 right-0 w-screen h-screen">
     <SlideChangePass
  
      :user="currentUser"
      :show="showSlideUserChangePass"
      @close="showSlideUserChangePass = false"
    />
    </div>
    <!-- <FlashToast /> -->

  </div>
  
</template>
<script>
import { EventBus } from "@/eventBus.js";
import IconKey from "@/Shared/Icons/Key";
import SlideChangePass from "@/Shared/Slide/Data/Users/ChangePass";
import FlashToast from "@/Shared/Toast/Toast";
import VxCross from "@/Shared/Icons/Cross";
export default {
   data() {
    return {
      sub_profile:false,
      showSlideUserChangePass:false,
      currentUser:{
        id:this.$page.props.auth.user.id,
        name:this.$page.props.auth.user.name,
        status : this.$page.props.auth.user.status,
      },
      early_warning:false,
      // currentUser2:{
      //   id:3,
      //   name:'vianhandika',
      // }
    }
  },
  components: {
    IconKey,
    SlideChangePass,
    FlashToast,
    VxCross
  },
  mounted(){
    if(this.$page.props.auth.user.status=='Generated'){
      this.early_warning=true
    }
  },
  methods: {
    toggleSidebar() {
      EventBus.$emit("toggleSidebar", true);
    },
  },
  created: function () {},
  computed: {
    imgurl() {
      return `https://ui-avatars.com/api/?name=${this.$page.props.auth.user.name.replace(
        " ",
        "+"
      )}&length=2&background=319795&color=fff`;
    },
  },
};
</script>

<style>

</style>
