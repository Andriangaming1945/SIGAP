<template>
    <div class="sidebar-wrapper">
      <sidebar-menu
        :menu="currentMenu"
        :collapsed="collapsed"
        theme="custom-theme"
        :show-one-child="true"
        @toggle-collapse="onToggleCollapse"
        @item-click="onItemClick"
      >
        <template #header>
          <div class="logo-container">
            <img src="/lego.svg" alt="BMKG" class="logo" />
          </div>
        </template>
      </sidebar-menu>
    </div>
  </template>
  
  <script>
  import { SidebarMenu } from "vue-sidebar-menu";
  import "vue-sidebar-menu/dist/vue-sidebar-menu.css";
  
  export default {
    name: "SikermaSidebar",
    components: {
      SidebarMenu,
    },
  
    props: {
      id_role: {
        type: String,
        default: "",
      },
    },
    data() {
      return {
        collapsed: false,
        activeMenu: "",
        menuItems: [
          {
            title: "Dashboard",
            icon: {
              element: "img",
              attributes: { src: "/Barcode.svg" },
            },
            href: "/admin/repository",
          },
          {
            title: "Master",
            icon: {
              element: "img",
              attributes: { src: "/database.svg" },
            },
            child: [
              {
                title: "Management penyakit",
                href: "/admin/master/upt",
                class: "child-item",
              },
              {
                title: "History penyakit user",
                href: "/admin/master/role",
                class: "child-item",
              },
            ],
          },
          {
            title: "Form Dokter",
            icon: {
              element: "img",
              attributes: { src: "/repository.svg" },
            },
            href: "/admin/repository",
          },
  
          {
            title: "Entrees Scanner",
            icon: {
              element: "img",
              attributes: { src: "/laporan.svg" },
            },
            href: "/admin/laporan",
          },
          {
            title: "Prediksi Penyakit",
            icon: {
              element: "img",
              attributes: { src: "/Berita.png" },
            },
            href: "/admin/berita",
          },
          {
            title: "Profil",
            icon: {
              element: "img",
              attributes: { src: "/user.svg" },
            },
            href: "/admin/user",
          },
          {
            title: "User Management",
            icon: {
              element: "img",
              attributes: { src: "/people.svg" },
            },
            href: "/admin/user-management",
          },
          {
            title: "Logout",
            icon: {
              element: "img",
              attributes: { src: "/logout.svg" },
            },
            href: "/login",
            class: "logout-item",
          },
        ],
      };
    },
    computed: {
      currentMenu() {
        return this.menuItems;
      },
    },
    methods: {
      onToggleCollapse(collapsed) {
        this.collapsed = collapsed;
      },
     
       
      findParentItem(childItem) {
        for (const item of this.currentMenu) {
          if (item.child && item.child.includes(childItem)) {
            return item;
          }
        }
        return null;
      },
    },
    watch: {
      $route: {
        immediate: true,
        handler(to) {
          const currentPath = to.path;
          for (const item of this.currentMenu) {
            if (item.child) {
              const matchingChild = item.child.find(
                (child) => child.href === currentPath
              );
              if (matchingChild) {
                this.activeMenu = item.title;
                return;
              }
            }
          }
          this.activeMenu = "";
        },
      },
    },
  };
  </script>
  
  <style>
  .v-sidebar-menu {
    position: sticky;
    top: 0;
    left: 0;
    height: 100vh;
  }
  
  .v-sidebar-menu.vsm_custom-theme {
    background-color: #1e2a5e;
    color: white;
    width: 270px;
  }
  
  .v-sidebar-menu.vsm_custom-theme .vsm--link {
    color: white;
    padding-left: 20px;
    padding-bottom: 7px;
    margin-right: 20px;
  }
  
  .v-sidebar-menu .vsm--badge_default {
    background-color: #130645;
  }
  
  .v-sidebar-menu.vsm_custom-theme .vsm--link:hover,
  .v-sidebar-menu.vsm_custom-theme .vsm--link:active {
    border-radius: 10px;
  }
  
  .v-sidebar-menu.vsm_custom-theme .vsm--dropdown {
    background-color: #1e2a5e !important;
  }
  
  .v-sidebar-menu.vsm_custom-theme .vsm--link_level-2,
  .v-sidebar-menu.vsm_custom-theme .vsm--link_level-3 {
    background-color: #1e2a5e !important;
    color: white !important;
    padding-left: 66px;
    padding: 6px 20px 6px 66px;
    line-height: 24px;
  }
  
  .v-sidebar-menu.vsm_custom-theme .vsm--link_level-2:hover,
  .v-sidebar-menu.vsm_custom-theme .vsm--link_level-3:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: #fff !important;
  }
  
  .v-sidebar-menu.vsm_custom-theme .vsm--link_active {
    box-shadow: none !important;
    font-weight: normal;
  }
  
  .v-sidebar-menu.vsm_custom-theme .vsm--link:hover,
  .v-sidebar-menu.vsm_custom-theme .vsm--link.vsm--active {
    color: #fff;
    background-color: rgba(255, 255, 255, 0.1);
  }
  
  .v-sidebar-menu.vsm_custom-theme .vsm--icon {
    background-color: transparent !important;
    color: white;
    width: 20px;
    height: 20px;
  }
  
  .v-sidebar-menu.vsm_custom-theme .vsm--arrow {
    position: absolute !important;
    left: 225px !important;
    right: auto !important;
  }
  
  .logo-container {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 18px;
    text-align: center;
  }
  
  .logo {
    width: 100%;
    max-width: 130px;
    height: auto;
  }
  
  .v-sidebar-menu.vsm_custom-theme .vsm--link_level-1 .vsm--arrow {
    height: 40px !important;
    line-height: 40px !important;
  }
  
  .v-sidebar-menu .vsm--toggle-btn {
    background-color: #1e2a5e;
  }
  
  .logout-item {
    margin-top: 40px;
  }
  </style>
  