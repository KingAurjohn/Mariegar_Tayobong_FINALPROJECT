<template>
  <div class="main-container">
    <!-- Sidebar -->
    <div class="left" :class="{ collapsed: isCollapsed }">
      <div class="hamburger" @click="toggleSidebar">
        &#9776;
      </div>
      <div v-if="!isCollapsed" class="nav-links">
        <router-link to="/home" class="nav-link">🏠 Home</router-link>
        <router-link to="/add-product" class="nav-link">➕ Add Product</router-link>
        <router-link to="/logs" class="nav-link">📝Logs</router-link>
        <router-link to="/account-setting" class="nav-link">👤 Account Setting</router-link>
        <button class="nav-link logout" @click="logout" style="margin-top: 50px;">🚪 Logout</button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="right">
      <router-view/>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isCollapsed: false,
    };
  },
  methods: {
    toggleSidebar() {
      this.isCollapsed = !this.isCollapsed;
    },
    async logout() {
      // Just a placeholder
      window.location.href="/logout";
    },
    goHome(){
        this.$router.push('/home');
    }
  },
  mounted(){
    this.goHome();
  }
};
</script>

<style scoped>
.main-container {
  display: flex;
  height: 100vh;
  width: 100%;
}

/* Sidebar */
.left {
  width: 250px;
  background-color: #2c3e50;
  color: white;
  padding: 20px;
  transition: width 0.3s ease;
  position: relative;
}

.left.collapsed {
  width: 60px;
  overflow: hidden;
}

.hamburger {
  font-size: 24px;
  cursor: pointer;
  margin-bottom: 20px;
}

.nav-links {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.nav-link {
  color: white;
  text-decoration: none;
  padding: 10px 15px;
  border-radius: 4px;
  background-color: #34495e;
  transition: background 0.2s;
}

.nav-link.router-link-active {
background-color: #5d6d7e;

}

.nav-link:hover {
  background-color: #3d566e;
}

.logout {
  background-color: #e74c3c;
  border: none;
}

.logout:hover {
  background-color: #c0392b;
}

/* Main content */
.right {
  flex: 1;
  padding: 10px;
  overflow: auto;
  background: linear-gradient(to right, #ff69b4, #ffc0cb);

}
</style>
