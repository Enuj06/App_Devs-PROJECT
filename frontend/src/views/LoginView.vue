<template>
    <v-sheet width="300" class="mx-auto">
      <v-form fast-fail @submit.prevent ="login">
        <v-text-field
          v-model="username"
          label="username"
        ></v-text-field>
  
        <v-text-field
          v-model="password"
          label="password"
        ></v-text-field>
  
        <v-btn type="submit" block class="mt-2">Submit</v-btn>
      </v-form>
    </v-sheet>
  </template>
  <script>
  import axios from 'axios'
    export default {
        data(){
            return{
                username:"",
                password:"",
                errorMsg:"",  
            }
        },
        methods:{
            async login(){
                console.log("CLARISH")
            }
        },
    }
  </script>