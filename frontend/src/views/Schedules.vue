<template>
  <div>
    <AdminLogo /><br>
    <AdminNav />
      <h1 class="page-title">Schedules Table</h1>
      <h3>Schedule Table</h3>
      <div class="container">
      <!-- Form for creating a new schedule -->
      <!-- Form for creating new FAQ -->
      <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content p-4 rounded m-4">
            <h5 class="card-title text-center mb-5 fw-light fs-5">{{ schedToEdit ? 'Edit FAQ' : 'Create FAQ' }}</h5>
            <form @submit.prevent="createOrUpdateSchedule" class="schedule-form">
              <label for="appointmentDate">Appointment Date:</label>
              <input v-model="appointmentDate" type="date" id="appointmentDate" name="appointmentDate" required>

              <label for="startTime">Start Time:</label>
              <input v-model="startTime" type="time" id="startTime" name="startTime" required>

              <label for="endTime">End Time:</label>
              <input v-model="endTime" type="time" id="endTime" name="endTime" required>

              <label for="status">Status:</label>
              <select v-model="status" id="status" name="status" required>
                <option value="available">Available</option>
                <option value="booked">Booked</option>
              </select>


              <button class="btn btn-success" type="submit">{{ schedToEdit ? 'Update Schedule' : 'Create Schedule'
              }}</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Table to display schedules -->
      <table class="schedule-table">
        <thead>
          <tr>
            <th>Appointment Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
            <th>Actions <a class="btn btn-primary me-2" @click="openModal()" data-bs-toggle="modal"
                data-bs-target="#editModal" data-bs-placement="top" title="Edit">
                <i class="fas fa-add"></i>
              </a></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="schedule in schedules" :key="schedule.id">
            <td>{{ schedule.appointment_date }}</td>
            <td>{{ schedule.start_time }}</td>
            <td>{{ schedule.end_time }}</td>
            <td>{{ schedule.status }}</td>
            <td><a class="btn btn-primary me-2" @click="openModal(schedule.id)" data-bs-toggle="modal" data-bs-target="#editModal" 
              data-bs-placement="top" title="Edit">
                <i class="fas fa-edit"></i></a>
              <a class="btn btn-danger ms-2" @click="staffDelete(schedule.id)" data-bs-toggle="tooltip" data-bs-placement="top" 
              title="Delete">
                <i class="fas fa-trash-alt"></i>
              </a>
            </td>

          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Modal for Confirmation -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this appointment?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" @click="deleteConfirmed">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AdminNav from '@/components/AdminNav.vue';
import AdminLogo from '@/components/AdminLogo.vue';
import axios from 'axios';

export default {
  name: 'Schedules',
  components: {
    AdminLogo,
    AdminNav,
  },
  data() {
    return {
      appointmentDate: '',
      startTime: '',
      endTime: '',
      status: 'available',
      schedules: [],
      editing: false,
      scheduleId: null, // Use this to store the ID of the schedule being edited
    };
  },
  created() {
    this.getSchedules();
  },
  methods: {
    async getSchedules() {
      try {
        const response = await axios.get('/getSchedule'); // Update the endpoint as needed
        this.schedules = response.data;
      } catch (error) {
        console.error('Error fetching schedules:', error);
      }
    },
    async openModal(id = null) {
      if (id) {
        try {
          const response = await axios.get(`fetchSched/${id}`);
          const sched = response.data;
          this.schedToEdit = sched;


          this.appointmentDate = sched.appointment_date;
          this.startTime = sched.start_time;
          this.endTime = sched.end_time;
          this.status = sched.status;
          this.$router.push({ name: 'sched', params: { id: id } });
        } catch (error) {
          console.error('Error fetching FAQ data:', error);
        }
      } else {
        this.newQuestion = '';
        this.newAnswer = '';
        this.faqToEdit = null;

        this.$router.push({ name: 'sched' });
      }
    },

    async createOrUpdateSchedule() {
      try {
        if (this.schedToEdit) {
          const response = await axios.put(`/updateSched/${this.schedToEdit.id}`, {
            appointment_date: this.appointmentDate,
            start_time: this.startTime,
            end_time: this.endTime,
            status: this.status,
          });

          if (response.data.msg === 'okay') {
            console.log('Schedule updated successfully');
            this.getSchedules();
          } else {
            console.error('Failed to update schedule');
          }
        } else {
          const response = await axios.post('/createSchedule', {
            appointment_date: this.appointmentDate,
            start_time: this.startTime,
            end_time: this.endTime,
            status: this.status,
          });

          if (response.data.msg === 'okay') {
            console.log('Schedule created successfully');
            this.getSchedules();
          } else {
            console.error('Failed to create schedule');
          }
        }

        $('#scheduleModal').modal('hide');

        this.appointmentDate = '';
        this.startTime = '';
        this.endTime = '';
        this.status = 'available';

        // Reset edit mode
        this.editing = false;
        this.scheduleId = null; // Reset the scheduleId if needed
      } catch (error) {
        console.error('Error creating or updating schedule:', error);
      }
      this.closeModal();
      this.getSchedules();

    },

    staffDelete(userId) {
      this.DeleteId = userId;

      $('#deleteModal').modal('show');
    },
    deleteConfirmed() {
      this.deleteStaff(this.DeleteId);

      $('#deleteModal').modal('hide');
    },

    async deleteFAQ(id) {
      try {
        const response = await axios.get('/deleteSched/' + id);

        if (response.data.msg === 'okay') {
          this.getSched();
        } else {
          console.error('Failed to delete FEEDBACK');
        }
      } catch (error) {
        console.error('Error deleting FEEDBACK:', error);
      }
    },
    async deleteStaff(userId) {
      try {
        await axios.delete(`deleteSched/${userId}`);
        this.$refs.notification.open("Deleted successfully.", 'success');
        this.getStaff();
      } catch (error) {
        console.log(error);
      }
      this.$router.push({ name: 'sched' });
      this.getSchedules();
      this.closeModal();
    },
    closeModal() {
      this.$router.push({ name: 'sched' });
      $('#editModal').modal('hide');
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: 0 auto;

}

.page-title {
  text-align: center;
}

.schedule-form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.schedule-form label {
  display: block;
  margin-bottom: 8px;
}

.schedule-form input,
.schedule-form select {
  width: 100%;
  padding: 8px;
  margin-bottom: 16px;
  box-sizing: border-box;
}

.schedule-form button {
  background-color: #4caf50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.schedule-form button:hover {
  background-color: #45a049;
}

.schedule-table {
  margin-top: 20px;
  width: 100%;
  border-collapse: collapse;
}

.schedule-table th,
.schedule-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.schedule-table th {
  background-color: #4caf50;
  color: white;
}

h3{
  text-align: center;
}

</style>