<template>
  <div class="account-setting-container">
    <feedback :message="message" :type="type" :title="title" :show="show" @close="close" v-show="show_feedback"/>
    <h1>ACCOUNT SETTING</h1>
    <form @submit.prevent="updateAccount" class="account-form">
      <div class="form-group">
        <label for="name">Name:</label>
        <input
          type="text"
          id="name"
          v-model="form.name"
          placeholder="Your full name"
          required
        />
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input
          type="email"
          id="email"
          v-model="form.email"
          placeholder="Your email address"
          required
        />
      </div>

      <label style="color: red; font-size: 14px;" >{{ label_status_1 }}</label>
      <div class="form-group">
        <label for="password">New Password:</label>
        <input
          type="password"
          id="password"
          v-model="form.password"
          placeholder="Leave blank to keep current"
        />
      </div>
        <label style="color: red; font-size: 14px;" >{{ label_status_2 }}</label>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password:</label>
        <input
          type="password"
          id="password_confirmation"
          v-model="password_confirmation"
          placeholder="Confirm new password"
        />
      </div>

      <button type="submit" :class="['submit-btn', not_valid ? 'invalid' : 'valid']" :disabled="not_valid">Update Account</button>
    </form>

    <p v-if="message" :class="{'success-msg': success, 'error-msg': !success}">
      {{ message }}
    </p>
  </div>
</template>

<script>
import axios from 'axios';
import feedback from '../modal_feedback/feedback.vue';

export default {
    components: {
        feedback
    },
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
      },
                  show_feedback: false,
    type: "",
    message: "",
    title: "",
    show: false,
      not_valid: true,
      one_valid: false,
      two_valid: false,
      password_confirmation: '',
      message: '',
      success: false,
      label_status_1: '',
      label_status_2: '',
    };
  },

  watch: {
    'form.password'(newVal, oldVal) {
        const strongregex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

        if(strongregex.test(newVal)){
            this.label_status_1 = "";
            this.one_valid = true;
        }
        else{
            this.label_status_1 = "Password should be strong. Must combination of 1 special character, number and capital letter";
            this.not_valid = true;
            this.one_valid = false;
        }

        if(this.one_valid && this.two_valid){
            this.not_valid = false;
        }
        else{
            this.not_valid = true;
        }
    },

    'password_confirmation' (newVal, oldVal){
        if(this.form.password === newVal){
            this.label_status_2 = "";
            this.not_valid = false;
            this.two_valid = true;
        }else{
            this.not_valid = true;
            this.label_status_2 = "Password not matched";
            this.two_valid = false;
        }

        if(this.one_valid && this.two_valid){
            this.not_valid = false;
        }
        else{
            this.not_valid = true;
        }
    }
  },

  async created() {
    await this.loadAdminInfo();
  },
  methods: {
    close(){
        this.show_feedback = false;
    },
    async loadAdminInfo() {
      const res = await axios.get('/admin/return-info');

      this.form = res.data.message;
      console.log(res.data.message);
    },
    async updateAccount() {

        try{
            const data = new FormData();
            data.append('form', JSON.stringify(this.form));
            data.append('pass_confirm', this.password_confirmation);

            const res = await axios.post('/admin/update-info', data);

            if(res.data.message === "success"){
                this.title = "UPDATE ACCOUNT INFORMATION";
                this.message = "You have successfully updated your account.";
                this.type = "success";
                this.show = true;
                this.show_feedback = true;
            }
            else{
                this.title = "UPDATE ACCOUNT INFORMATION";
                this.message = "Update account failed";
                this.type = "error";
                this.show = true;
                this.show_feedback = true;
            }
        }
        catch(error){
            this.title = "UPDATE ACCOUNT INFORMATION";
            this.message = "Something went wrong! Please reload the page";
            this.type = "error";
            this.show = true;
            this.show_feedback = true;
        }
    },
  },
};
</script>

<style scoped>
.account-setting-container {
  max-width: 450px;
  margin: 40px auto;
  background: #fff;
  padding: 30px 25px;
  border-radius: 8px;
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

h1 {
  text-align: center;
  margin-bottom: 30px;
  color: #2c3e50;
  font-weight: 700;
  letter-spacing: 1px;
}

.account-form .form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  font-weight: 600;
  margin-bottom: 6px;
  color: #34495e;
}

input[type='text'],
input[type='email'],
input[type='password'] {
  width: 100%;
  padding: 10px 12px;
  font-size: 15px;
  border: 1.8px solid #ddd;
  border-radius: 6px;
  transition: border-color 0.3s ease;
}

input[type='text']:focus,
input[type='email']:focus,
input[type='password']:focus {
  outline: none;
  border-color: #3498db;
  box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
}

.submit-btn {
  width: 100%;
  padding: 12px;
  background-color: #ff69b4;
  border: none;
  color: white;
  font-weight: 600;
  font-size: 16px;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.25s ease;
}

.invalid{
  background-color: gray;
}
.invalid:hover:disabled {
    background-color: gray;
    cursor: default;
}

.submit-btn:hover {
  background-color: #2980b9;
}

.success-msg {
  margin-top: 20px;
  color: #27ae60;
  font-weight: 600;
  text-align: center;
}

.error-msg {
  margin-top: 20px;
  color: #27ae60;
  font-weight: 600;
  text-align: center;
}
</style>

