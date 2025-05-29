<template>
  <div v-if="show" class="modal-overlay" @click.self="close">
    <div :class="['modal-box', type]">
      <span class="close-btn" @click="close">&times;</span>
      <h2>{{ title }}</h2>
      <p>{{ message }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: Boolean,
    type: String,
    title: String,
    message: String,
  },
  methods: {
    close() {
      this.$emit('close');
    },
  },
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
  animation: fadeIn 0.3s;
}

.modal-box {
  background: #fff;
  padding: 25px 30px;
  border-radius: 8px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
  position: relative;
  max-width: 400px;
  width: 90%;
  text-align: center;
  animation: slideIn 0.3s;
}

.modal-box.success {
  background-color: #ff69b4;
  color: white;
}

.modal-box.error {
  background-color: #dc3545;
    color: white;
}

.modal-box h2 {
  margin: 0 0 10px;
  font-size: 22px;
}

.modal-box p {
  margin: 0;
  font-size: 16px;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 14px;
  font-size: 22px;
  cursor: pointer;
  color: white;
}

@keyframes fadeIn {
  from { opacity: 0; } 
  to { opacity: 1; }
}

@keyframes slideIn {
  from { transform: translateY(-20px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}
</style>
