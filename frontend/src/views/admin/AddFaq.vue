<template>
    <h1>Frequently Asked Questions</h1>
    <h3>Table</h3>

    <div>
        <table border="1">
            <tr>
                <th>Question</th>
                <th>Answer</th>
            </tr>
            <!-- <tr v-for="users in users">
                <td>{{ users.username }}</td>
                <td>{{ users.status }}</td>            
            </tr> -->
        </table>
    </div>
</template>

<style scoped>
h1, h3{
    text-align: center;
}
table, th, td {    
border: 1px solid black;  
margin-left: auto;  
margin-right: auto;  
border-collapse: collapse;    
width: 500px;  
text-align: center;  
font-size: 20px;  
}  
</style>