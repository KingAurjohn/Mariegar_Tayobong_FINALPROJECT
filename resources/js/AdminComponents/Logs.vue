<template>
  <div class="logs-container">
    <h2>Activity Logs</h2>
    <table class="logs-table">
      <thead>
        <tr>
          <th>Note</th>
          <th>Action</th>
          <th>Status</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody v-if="logs.length > 0">
        <tr v-for="(log, index) in logs" :key="index">
          <td>{{ log.note }}</td>
          <td>{{ log.action }}</td>
          <td>
            <span :class="['status', log.status.toLowerCase()]">{{ log.status }}</span>
          </td>
          <td>{{ returnFormatDatetime(log.created_at) }}</td>
        </tr>
        <tr v-if="logs.length === 0">
          <td colspan="4" class="no-logs">No logs available</td>
        </tr>
      </tbody>

      <tbody v-else>
        <tr><label style="color: red;">NO LOGS HAVE BEEN CREATED</label></tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
    data() {
  return {
    logs: [],
  };
},

  methods: {
    returnFormatDatetime(date){
              const d = new Date(date);

              const options = {
                timeZone: 'Asia/Manila',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
              };

              const formatted = new Intl.DateTimeFormat('en-PH', options).format(d);

          return formatted;
      },

    async returnLogs(){
        const res = await axios.get('/admin/return-logs');
        this.logs = res.data.message;
    }

  },

  async mounted(){
    await this.returnLogs();
  }
};
</script>

<style scoped>
.logs-container {
  background: #f9f9f9;
  padding: 20px 30px;
  border-radius: 8px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

h2 {
  margin-bottom: 15px;
  font-size: 24px;
  color: #333;
}

.logs-table {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
}

.logs-table th,
.logs-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
  font-size: 14px;
}

.logs-table th {
  background-color: #f0f0f0;
  color: #555;
}

.logs-table tr:nth-child(even) {
  background-color: #fafafa;
}

.status {
  padding: 4px 8px;
  border-radius: 5px;
  font-weight: bold;
  font-size: 13px;
  text-transform: capitalize;
}

.status.successful {
  background-color: #d4edda;
  color: #155724;
}

.status.error {
  background-color: #f8d7da;
  color: #721c24;
}

.status.pending {
  background-color: #fff3cd;
  color: #856404;
}

.no-logs {
  text-align: center;
  color: #888;
  font-style: italic;
}
</style>
