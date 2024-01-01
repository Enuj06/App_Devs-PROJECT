<template>
  <div class="appointment-container">
    <Logo /><br>
    <NavBar />
    <div class="appointment-content">
      <h1>Book an Appointment</h1><br>
      <h3>Do you have problems you need to talk with a professional with personally?</h3>
      <p>Select an appointment for personal guidance counseling.</p><br>
      <form @submit.prevent="submitForm" class="appointment-form">
        <table>
          <thead>
            <tr>
              <th>Appointment Date</th>
              <th>Start Time</th>
              <th>End Time</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="appointment in availableAppointments" :key="appointment.id">
              <td>{{ appointment.appointment_date }}</td>
              <td>{{ appointment.start_time }}</td>
              <td>{{ appointment.end_time }}</td>
              <td>
                <input
                  type="radio"
                  :id="'appointment-' + appointment.id"
                  :value="appointment.id"
                  v-model="selectedAppointment"
                />
              </td>
            </tr>
          </tbody>
        </table>
        
        <input type="hidden" name="status" value="Available">
        
        <v-btn type="submit" block class="mt-2">Book Appointment</v-btn>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Logo from '@/components/Logo.vue';
import NavBar from '@/components/NavBar.vue';

export default {
  name: 'Appointments',
  components: {
    Logo,
    NavBar,
  },
  data() {
    return {
      selectedAppointment: null,
      availableAppointments: [],
    };
  },
  mounted() {
    this.fetchAvailableAppointments();
  },
  methods: {
    async fetchAvailableAppointments() {
      try {
        const response = await axios.get('/schedule/getAvailableAppointments');

        // Filter out already booked appointments
        this.availableAppointments = response.data.filter(appointment => appointment.hasOwnProperty('status') && appointment.status === 'Available');
      } catch (error) {
        console.error('Error fetching available appointments:', error);
      }
    },
    async submitForm() {
      try {
        const response = await axios.post('/schedule/bookAppointment', {
          appointment: this.selectedAppointment,
          status: 'Available', // Include the status in the form data
        });

        if (response.data && response.data.success) {
          console.log('Appointment booked successfully!');
        } else {
          console.error('Error booking appointment:', response.data.error);
        }
      } catch (error) {
        console.error('Error submitting form:', error);
      }
    },
  },
};
</script>

<style scoped>
.appointment-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.appointment-content {
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.appointment-form {
  max-width: 600px;
  margin: 0 auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 16px;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

/* Add more styling as needed */
</style>
  