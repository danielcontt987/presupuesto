<template>
    <v-card class="rounded-lg" flat>
        <v-card-text class="text-center"> 
           <v-avatar variant="tonal" color="primary" size="80">
                <v-icon size="40">
                   {{icon}}
                </v-icon>
           </v-avatar>
        </v-card-text>
        <v-card-text class="text-center"> 
          <h3>{{title}}</h3>
        </v-card-text>
        <v-card-text class="text-center"> 
          <p class="break">{{text}}</p>
        </v-card-text>
    </v-card>
</template>

<script setup>
defineProps({
    icon:{
        type: String,
    },
    title:{
        type: String,
    },
    text:{
        type: String,
    }
})
</script>

<style>
.break{
    word-break: break-word;
}
</style>
