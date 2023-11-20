<template>
    <v-card>
        <v-tabs
            v-model="tab"
            bg-color="secondary"
        >
         <v-tab value="one">Home</v-tab>
         <v-tab value="two">Events</v-tab>
         <v-tab value="three">Consultation</v-tab>
        </v-tabs>

        <v-card-text>
            <v-window v-model="tab">
                <v-window-item>Tahanan</v-window-item>
                <v-window-item>Pangyayari</v-window-item>
                <v-window-item>UsapTayo</v-window-item>
            </v-window>
        </v-card-text>
    </v-card>
    <form>
        <v-sheet width="300" class="mx-auto">
            <h2 style="text-align: center;
                color: rgb(36, 36, 65);">
                Hello sa'yo!</h2>
            <h3 style="text-align: center;">
                How can I help you? :)
            </h3><br>
            <textarea name="" id="thoughts" cols="30" rows="10" placeholder="Input your thoughts here..."
            style="
            background-color: rgb(175, 189, 201);
            width: 100%;
            padding: 12px;
            border: 1px solid #f58be7;
            box-sizing: border-box;
            margin-top: px;
            margin-bottom: 16px;
            resize: vertical;
            "></textarea>
             <v-btn type="submit" block class="mt-2">Submit</v-btn>
        </v-sheet>
    </form>
    
</template>

<script>
    export default{
        data: () => ({
            tab: null,
        }),
    }
</script>