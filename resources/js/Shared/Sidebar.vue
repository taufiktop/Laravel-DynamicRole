<template>
  <transition
    name="custom-classes-transition"
    enter-active-class="animated fadeInLeft faster"
    leave-active-class="animated fadeOutLeft"
  >
    <div
      id="mysidebar"
      class="fixed inset-y-0 left-0 z-50 md:max-w-sidebar w-full max-h-screen bg-white transform transition-all duration-300 ease-in-out sidebar"
      v-show="show"
    >
      <brand :to="route('home')" label="CMS LMS" />

      <GroupMenu>
        <Menu label="Dashboard">
          <Lists
            v-if="can('view.overview')"
            label="Overview"
            tag="overview"
          >
            <template #svg>
              <svg
              class="fill-current flex-shrink-0 w-4 h-4 text-gray-700"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              >
                <path
                  d="M17.431,2.156h-3.715c-0.228,0-0.413,0.186-0.413,0.413v6.973h-2.89V6.687c0-0.229-0.186-0.413-0.413-0.413H6.285c-0.228,0-0.413,0.184-0.413,0.413v6.388H2.569c-0.227,0-0.413,0.187-0.413,0.413v3.942c0,0.228,0.186,0.413,0.413,0.413h14.862c0.228,0,0.413-0.186,0.413-0.413V2.569C17.844,2.342,17.658,2.156,17.431,2.156 M5.872,17.019h-2.89v-3.117h2.89V17.019zM9.587,17.019h-2.89V7.1h2.89V17.019z M13.303,17.019h-2.89v-6.651h2.89V17.019z M17.019,17.019h-2.891V2.982h2.891V17.019z"
                />
              </svg>
            </template>
            <SubLink
              v-if="can('view.overview')"
              :to="route('overview.home')"
              label="Home"
            ></SubLink>
            <SubLink
              v-if="can('view.overview')"
              :to="route('overview.product')"
              label="Product"
            ></SubLink>
            <SubLink
              v-if="can('view.overview')"
              :to="route('overview.source')"
              label="Source"
            ></SubLink>
            <SubLink
              v-if="can('view.overview')"
              :to="route('overview.followup')"
              label="Follow Up"
            ></SubLink>
          </Lists>

          <Link :to="route('monitoring.data.leads')" label="Monitoring">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-display-fill" viewBox="0 0 16 16">
              <path d="M6 12c0 .667-.083 1.167-.25 1.5H5a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1h-.75c-.167-.333-.25-.833-.25-1.5h4c2 0 2-2 2-2V4c0-2-2-2-2-2H2C0 2 0 4 0 4v6c0 2 2 2 2 2h4z"/>
            </svg>
          </Link>

        </Menu>
        <Menu label="Main Navigation">
          <!-- <Link v-if="can('view.report')" :to="route('report')" label="Report">
            <svg
              class="fill-current flex-shrink-0 w-4 h-4 text-gray-700"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
            >
              <path
                d="M6 22v-16h16v7.543c0 4.107-6 2.457-6 2.457s1.518 6-2.638 6h-7.362zm18-7.614v-10.386h-20v20h10.189c3.163 0 9.811-7.223 9.811-9.614zm-10 1.614h-5v-1h5v1zm5-4h-10v1h10v-1zm0-3h-10v1h10v-1zm2-7h-19v19h-2v-21h21v2z"
              />
            </svg>
          </Link> -->
          <Lists
            v-if="can('view.source product', 'view.jumlah cut off data')"
            label="Data Master"
            tag="master"
          >
            <template #svg>
              <IconDatabase size="h-4 w-4" color="text-gray-700" />
            </template>
            <SubLink
              v-if="can('view.source product')"
              :to="route('master.sourceproduct')"
              label="Source Product"
            ></SubLink>
            <SubLink
              v-if="can('view.jumlah cut off data')"
              :to="route('master.jumlahcutoffdata')"
              label="Jumlah Cut Off Data"
            ></SubLink>
            <SubLink
              v-if="can('view.filterisasi databank')"
              :to="route('master.ruleslicing')"
              label="Filterisasi Databank"
            ></SubLink>
            <SubLink
              v-if="can('view.master cluster dealer')"
              :to="route('cluster.masterclusterdealer')"
              label="Master Cluster Dealer"
            />
            <SubLink
              v-if="can('view.master cluster b2b')"
              :to="route('cluster.masterclusterb2b')"
              label="Master Cluster B2B"
            />
          </Lists>
          <Lists
            label="ACC Partner"
            tag="accpartner"
            v-if="can('view.jumlah cut off data accpartner')"
          >
            <template #svg>
              <svg
                width="20"
                height="16"
                viewBox="0 0 20 16"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="fill-current flex-shrink-0 w-4 h-4 text-gray-700"
              >
                <path
                  d="M15.25 6H10.5V7.75C10.5 8.99063 9.49064 10 8.25001 10C7.00939 10 6.00001 8.99063 6.00001 7.75V3.95L3.97189 5.16875C3.36876 5.52813 3.00001 6.18125 3.00001 6.88125V8.35938L0.500011 9.80313C0.0218858 10.0781 -0.143739 10.6906 0.134386 11.1688L2.63439 15.5C2.90939 15.9781 3.52189 16.1406 4.00001 15.8656L7.23126 14H11.5C12.6031 14 13.5 13.1031 13.5 12H14C14.5531 12 15 11.5531 15 11V9H15.25C15.6656 9 16 8.66563 16 8.25V6.75C16 6.33438 15.6656 6 15.25 6ZM19.8656 4.83125L17.3656 0.500003C17.0906 0.021878 16.4781 -0.140622 16 0.134378L12.7688 2H9.57501C9.20001 2 8.83439 2.10625 8.51564 2.30313L7.46876 2.95625C7.17501 3.1375 7.00001 3.45938 7.00001 3.80313V7.75C7.00001 8.44063 7.55939 9 8.25001 9C8.94064 9 9.50001 8.44063 9.50001 7.75V5H15.25C16.2156 5 17 5.78438 17 6.75V7.64063L19.5 6.19688C19.9781 5.91875 20.1406 5.30938 19.8656 4.83125V4.83125Z"
                />
              </svg>
            </template>
            <SubLink
              label="Jumlah Cut Off Data"
              :to="route('master.accpartner.jumlahcutoffdata')"
              v-if="can('view.jumlah cut off data accpartner')"
            />
          </Lists>
          <!-- <Link :to="route('inputruleslicing')" label="Input Rule Slicing">
            <svg
              class="fill-current flex-shrink-0 w-4 h-4 text-gray-700"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
            >
              <path
                d="M10 13h-4v-1h4v1zm2.318-4.288l3.301 3.299-4.369.989 1.068-4.288zm11.682-5.062l-7.268 7.353-3.401-3.402 7.267-7.352 3.402 3.401zm-6 8.916v.977c0 4.107-6 2.457-6 2.457s1.518 6-2.638 6h-7.362v-20h14.056l1.977-2h-18.033v24h10.189c3.163 0 9.811-7.223 9.811-9.614v-3.843l-2 2.023z"
              />
            </svg>
          </Link> -->
          
         <!-- Broadcast Menu -->
          <Lists
            v-if="can('view.rule broadcast', 'view.template broadcast', 'view.template broadcast')"
            label="Broadcast Channel"
            tag="/broadcast/"
          >
            <template #svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                class="fill-current flex-shrink-0 w-4 h-4 text-gray-700"
              >
                <path
                  d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-11zm-1 .724c-2.067.95-4.539 1.481-7 1.656v6.237a25.222 25.222 0 0 1 1.088.085c2.053.204 4.038.668 5.912 1.56V3.224zm-8 7.841V4.934c-.68.027-1.399.043-2.008.053A2.02 2.02 0 0 0 0 7v2c0 1.106.896 1.996 1.994 2.009a68.14 68.14 0 0 1 .496.008 64 64 0 0 1 1.51.048zm1.39 1.081c.285.021.569.047.85.078l.253 1.69a1 1 0 0 1-.983 1.187h-.548a1 1 0 0 1-.916-.599l-1.314-2.48a65.81 65.81 0 0 1 1.692.064c.327.017.65.037.966.06z"
                />
              </svg>
            </template>
            <SubLink
              v-if="can('view.rule broadcast')"
              :to="route('broadcast.rulebroadcast')"
              label="Rule Broadcast"
            />
            <SubLink
              v-if="can('view.template broadcast')"
              :to="route('broadcast.templatebroadcast')"
              label="Template Broadcast"
            />
            <SubLink
              v-if="can('view.download list bucket')"
              :to="route('broadcast.downloadlistbucket')"
              label="Download List Bucket"
            />
          </Lists>
         <!-- Broadcast Menu -->

         <Lists
            v-if="can('view.users', 'view.roles')"
            label="Manage"
            tag="/manage/"
          >
            <template #svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                class="fill-current flex-shrink-0 w-4 h-4 text-gray-700"
              >
                <path
                  d="M17 10.645v-2.29c-1.17-.417-1.907-.533-2.28-1.431-.373-.9.07-1.512.6-2.625l-1.618-1.619c-1.105.525-1.723.974-2.626.6-.9-.373-1.017-1.116-1.431-2.28h-2.29c-.412 1.158-.53 1.907-1.431 2.28h-.001c-.9.374-1.51-.07-2.625-.6l-1.617 1.619c.527 1.11.973 1.724.6 2.625-.375.901-1.123 1.019-2.281 1.431v2.289c1.155.412 1.907.531 2.28 1.431.376.908-.081 1.534-.6 2.625l1.618 1.619c1.107-.525 1.724-.974 2.625-.6h.001c.9.373 1.018 1.118 1.431 2.28h2.289c.412-1.158.53-1.905 1.437-2.282h.001c.894-.372 1.501.071 2.619.602l1.618-1.619c-.525-1.107-.974-1.723-.601-2.625.374-.899 1.126-1.019 2.282-1.43zm-8.5 1.689c-1.564 0-2.833-1.269-2.833-2.834s1.269-2.834 2.833-2.834 2.833 1.269 2.833 2.834-1.269 2.834-2.833 2.834zm15.5 4.205v-1.077c-.55-.196-.897-.251-1.073-.673-.176-.424.033-.711.282-1.236l-.762-.762c-.52.248-.811.458-1.235.283-.424-.175-.479-.525-.674-1.073h-1.076c-.194.545-.25.897-.674 1.073-.424.176-.711-.033-1.235-.283l-.762.762c.248.523.458.812.282 1.236-.176.424-.528.479-1.073.673v1.077c.544.193.897.25 1.073.673.177.427-.038.722-.282 1.236l.762.762c.521-.248.812-.458 1.235-.283.424.175.479.526.674 1.073h1.076c.194-.545.25-.897.676-1.074h.001c.421-.175.706.034 1.232.284l.762-.762c-.247-.521-.458-.812-.282-1.235s.529-.481 1.073-.674zm-4 .794c-.736 0-1.333-.597-1.333-1.333s.597-1.333 1.333-1.333 1.333.597 1.333 1.333-.597 1.333-1.333 1.333zm-4 3.071v-.808c-.412-.147-.673-.188-.805-.505s.024-.533.212-.927l-.572-.571c-.389.186-.607.344-.926.212s-.359-.394-.506-.805h-.807c-.146.409-.188.673-.506.805-.317.132-.533-.024-.926-.212l-.572.571c.187.393.344.609.212.927-.132.318-.396.359-.805.505v.808c.408.145.673.188.805.505.133.32-.028.542-.212.927l.572.571c.39-.186.608-.344.926-.212.318.132.359.395.506.805h.807c.146-.409.188-.673.507-.805h.001c.315-.131.529.025.924.213l.572-.571c-.186-.391-.344-.609-.212-.927s.397-.361.805-.506zm-3 .596c-.552 0-1-.447-1-1s.448-1 1-1 1 .447 1 1-.448 1-1 1z"
                />
              </svg>
            </template>
            <SubLink
              v-if="can('view.users')"
              :to="route('manage.users')"
              label="Users"
            />
            <SubLink
              v-if="can('view.roles')"
              :to="route('manage.roles')"
              label="Roles"
            />
            <SubLink
              v-if="can('view.user activity')"
              :to="route('manage.useractivity')"
              label="User Activity"
            />
          </Lists>
          
        </Menu>
      </GroupMenu>

      <Logout label="Logout" :to="route('logout')" />
    </div>
  </transition>
</template>

<script>
import Brand from "@/Shared/Brand";
import Profile from "@/Shared/Profile";
import GroupMenu from "@/Shared/GroupMenu";
import Menu from "@/Shared/Menu";
import Link from "@/Shared/Link";
import Lists from "@/Shared/Lists";
import SubLink from "@/Shared/SubLink";
import Logout from "@/Shared/Logout";
import IconDatabase from "@/Shared/Icons/Database";
import { EventBus } from "@/eventBus.js";

export default {
  components: {
    Brand,
    Profile,
    GroupMenu,
    Menu,
    Link,
    Lists,
    SubLink,
    Logout,
    IconDatabase,
  },
  methods: {
    url() {
      return location.href;
    },
    toggleSidebar() {
      this.show = screen.width >= 768 ? true : false;
    },
  },
  data() {
    return {
      show: screen.width >= 768 ? true : false,
    };
  },
  created() {
    EventBus.$on("toggleSidebar", val => {
      this.show = val == this.show ? !val : val;
    });
  },
  mounted() {
    this.$nextTick(function() {
      window.addEventListener("resize", this.toggleSidebar);
    });
  },
};
</script>
