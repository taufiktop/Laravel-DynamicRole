import Vue from "vue";
import VueMeta from "vue-meta";
import { app, plugin } from "@inertiajs/inertia-vue";
import { InertiaProgress } from "@inertiajs/progress/src";
import Toast from "vue-toastification";

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en';
import CryptoJsAES from "@/Utils/cryptojs-aes";



window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

import "vue-toastification/dist/index.css";

Vue.config.productionTip = false;
Vue.mixin({
  methods: {
    route: window.route,
    can: function(...permissions) {
      return permissions.some(p => this.$page.props.user.can[p]);
    },
  },
});
Vue.use(plugin);
Vue.use(VueMeta);

Vue.use(ElementUI, { locale })

const options = {
  transition: "Vue-Toastification__bounce",
  maxToasts: 5,
  newestOnTop: true,
  hideProgressBar: true,
  closeButton: "span",
};

Vue.use(Toast, options);

InertiaProgress.init({
  // The delay after which the progress bar will
  // appear during navigation, in milliseconds.
  delay: 250,

  // The color of the progress bar.
  // color: "#61DAFB",
  color: "#b2f5ea",

  // Whether to include the default NProgress styles.
  includeCSS: true,

  // Whether the NProgress spinner will be shown.
  showSpinner: false,
});

let el = document.getElementById("app");

new Vue({
  metaInfo: {
    titleTemplate: title => (title ? `${title} - Sushy Yay` : "Sushi Yay"),
  },
  render: h =>
    h(app, {
      props: {
        initialPage: JSON.parse(el.dataset.page),
        resolveComponent: name =>
          import(`@/Pages/${name}`).then(module => module.default),
      },
    }),
}).$mount(el);
