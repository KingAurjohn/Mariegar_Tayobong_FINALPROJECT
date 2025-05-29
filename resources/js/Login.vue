<template>
  <div class="login-wrapper">
    <div class="login-box">
      <div class="header">
        <h2>Welcome Back</h2>
        <p>Log in to manage your products</p>
      </div>
      <label style="color: red;" v-if="is_failed">USER HAVE NOT FOUND</label>
      <form @submit.prevent="login">
        <div class="form-group">
          <label>Email</label>
          <input type="email" v-model="email" required placeholder="Enter your email" />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" v-model="password" required placeholder="Enter your password" />
        </div>
        <button type="submit" class="login-btn">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      is_failed: false,
    };
  },
  methods: {
    async login() {
      // Replace this with real authentication logic
      console.log("Logging in with", this.email, this.password);

      const data = new FormData();
      data.append('email', this.email);
      data.append('password', this.password);

      const res = await axios.post('/admin/log-in', data);

      if(res.data.message === "success"){
        window.location.href = "/home";
      }
      else{
        this.is_failed = true;
      }
    },
  },
};
</script>

<style scoped>
.login-wrapper {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(to right, #ff69b4, #ffc0cb);
  font-family: "Segoe UI", sans-serif;
}

.login-box {
  background: #ffffff;
  padding: 40px;
  border-radius: 10px;
  width: 100%;
  max-width: 400px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.header {
  text-align: center;
  margin-bottom: 30px;
}

.header h2 {
  margin: 0;
  color: #2c3e50;
}

.header p {
  margin-top: 5px;
  color: #7f8c8d;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  font-weight: 600;
  margin-bottom: 6px;
  color: #34495e;
}

input {
  width: 100%;
  padding: 10px;
  font-size: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.login-btn {
  width: 100%;
  padding: 12px;
  font-size: 16px;
  background-color: #ff69b4;
  color: #fff;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.login-btn:hover {
  background-color: #219150;
}
</style>