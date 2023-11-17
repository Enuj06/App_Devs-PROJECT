<template>
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