<template>
    <div>
        <header />
        <h1>Welcome to MinSU Guidance Office!</h1>

        <form class="form">
            <h1 style="text-align: center">Login</h1>
            <input type="text" id="username" class="form-control" name="username" placeholder="Username"><br>
            <input type="text" id="password" class="form-control" name="passoword" placeholder="Password"><br>
        <button type="submit" class="btn">Login</button> 
        <h3>Don't have an account?
        <a href="create_account">Create Account</a></h3>
    </form>
    </div>
    <div>
        <table border="1">
            <tr>
                <th>USERNAME</th>
                <th>STATUS</th>
                <th>ROLE</th>
            </tr>
            <tr v-for="users in users">
                <td>{{ users.username }}</td>
                <td>{{ users.status }}</td>
                <td>{{ users.role }}</td>
            </tr>
        </table>
    </div>
</template>

<style scoped>
    h1{
        text-align: center;
    }
 </style>

    <script>
        import axios from 'axios'
        export default{
             data(){
                return{
                    info:[],
                }
             },
            
            created(){
                this.getInfo();
            },
            methods:{
                async getInfo(){
            try{
                const inf = await axios.get('getData');
                this.info = inf.data; 
            }
            catch (error) {
                console.log(error); 
            }
        }
    }
}
    </script>