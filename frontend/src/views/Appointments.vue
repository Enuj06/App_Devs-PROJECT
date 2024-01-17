<template>
  <div class="appointment-container">
    <Logo /><br>
    <NavBar />
    <div class="appointment-content">
      <h1>Book an Appointment</h1><br>
      <h3>Do you have problems you need to talk with a professional with personally?</h3>
      <p>Select an appointment for personal guidance counseling.</p><br>

      <!-- Bootstrap Alert for No Appointment Selected -->
      <div v-if="showNoAppointmentAlert" class="alert alert-warning mt-3" role="alert">
        Please select an appointment before booking.
      </div>

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
        
        <v-btn type="submit" block class="mt-2">Book Appointment</v-btn>
      </form>

      <!-- Bootstrap Alert for Successful Booking -->
      <div v-if="bookingSuccess" class="alert alert-success mt-3" role="alert">
        Appointment booked successfully!<br>
        <strong>Selected Appointment ID:</strong> {{ selectedAppointment }}<br>
        <strong>Selected Appointment Details:</strong><br>
        <span v-if="selectedAppointmentDetails">
          Date: {{ selectedAppointmentDetails.appointment_date }}<br>
          Start Time: {{ selectedAppointmentDetails.start_time }}<br>
          End Time: {{ selectedAppointmentDetails.end_time }}
        </span>
      </div>
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
      bookingSuccess: false,
      selectedAppointmentDetails: null,
      showNoAppointmentAlert: false,
    };
  },
  mounted() {
    this.fetchAvailableAppointments();
  },
  methods: {
    async fetchAvailableAppointments() {
      try {
        const response = await axios.get('/schedule/getAvailableAppointments');
        this.availableAppointments = response.data.filter(appointment => appointment.status === 'Available');
        
      } catch (error) {
        console.error('Error fetching available appointments:', error);
      }
    },
    async submitForm() {
  if (this.selectedAppointment) {
    try {
      const response = await axios.post('/schedule/bookAppointment', {
        appointment: this.selectedAppointment,
    }, { withCredentials: true });

      if (response.data && response.data.success) {
        console.log('Appointment booked successfully!');
        this.bookingSuccess = true;
        this.selectedAppointmentDetails = this.availableAppointments.find(appointment => appointment.id === this.selectedAppointment);

        // Log selected appointment details to console
        console.log('Selected Appointment Details:', this.selectedAppointmentDetails);

        this.showNoAppointmentAlert = false; // Reset the alert state
      } else {
        console.error('Error booking appointment:', response.data.error);
      }
    } catch (error) {
      console.error('Error submitting form:', error);

      console.log('Full error response:', error.response);
      // Display a user-friendly error message to the user
  if (error.response && error.response.data && error.response.data.messages) {
    alert(error.response.data.messages.error);
  } else {
    alert('Failed to book appointment. Please try again or contact support.');
  }
    }
  } else {
    // Display the alert for no appointment selected
    this.showNoAppointmentAlert = true;
    // Optionally, you can also use a timeout to hide the alert after a few seconds
    setTimeout(() => {
      this.showNoAppointmentAlert = false;
    }, 5000); // Hide the alert after 5 seconds
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
  margin-top: 20px; /* Adjusted margin for separation */
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

/* Bootstrap Alert Styling */
.alert {
  padding: 15px;
  margin-bottom: 20px;
  border: 1px solid transparent;
  border-radius: 4px;
}

.alert-success {
  color: #3c763d;
  background-color: #dff0d8;
  border-color: #d6e9c6;
}

/* Add more styling as needed */
</style>
