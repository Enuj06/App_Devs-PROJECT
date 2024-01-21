<template>
    <div>
      <table class="appointment-table appoint-form">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Appointment ID</th>
            <th>Status</th>
            <th>Reason</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="appointment in appointments" :key="appointment.id">
            <td>{{ appointment.userid }}</td>
            <td>{{ appointment.appointmentid }}</td>
            <td>{{ appointment.status }}</td>
            <td>{{ appointment.reason }}</td>
            <td>{{ appointment.created_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'Appointments',
    data() {
      return {
        appointments: [],
      };
    },
    created() {
      this.getAppointments();
    },
    methods: {
      async getAppointments() {
        try {
          const response = await axios.get('/getAppoint'); // Replace with your actual API endpoint
          this.appointments = response.data;
        } catch (error) {
          console.error('Error fetching appointments:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .appointment-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  
  .appointment-table th,
  .appointment-table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
  }
  
  .appointment-table th {
    background-color: #f2f2f2;
  }

  .appoint-form {
  max-width: 775px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
  </style>
  