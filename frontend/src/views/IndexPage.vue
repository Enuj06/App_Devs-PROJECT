<template>
    <div>
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
                <th>LAST NAME</th>
                <th>FIRST NAME</th>
                <th>GENDER</th>
                <th>AGE</th>
            </tr>
            <tr v-for="info in info">
                <td>{{ info.lastname }}</td>
                <td>{{ info.firstname }}</td>
                <td>{{ info. gender }}</td>
                <td>{{ info.age }}</td>
            </tr>
        </table>
    </div>
</template>

<style scoped>

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