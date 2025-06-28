<!-- <template>
    <v-card class="mb-3 pa-3 rounded-sm">
        <v-img v-if="item.image" :src="`/images/${item.image}`" height="120" class="mb-2 rounded" cover />
        <div class="d-flex flex-wrap mb-2">
            <v-chip v-for="(label, i) in item.labels" :key="i" class="ma-1" color="grey lighten-3" small>
                {{ label }}
            </v-chip>
        </div>
        <div class="text-subtitle-1 font-weight-medium mb-1">{{ item.title }}</div>
        <div class="d-flex justify-space-between align-center mt-2">
            <div>
                <v-icon size="15" color="grey">mdi-format-list-bulleted</v-icon>
                {{ item.tasks }}
                <v-icon size="15" color="grey">mdi-comment</v-icon>
                {{ item.comments }}
            </div>
            <div class="d-flex">
                <v-avatar v-for="(user, i) in item.users" :key="i" size="24" class="ml-1" color="chipCard">
                    A
                </v-avatar>
            </div>
        </div>
    </v-card>
     <v-navigation-drawer v-model="open" temporary>
        <v-list-item prepend-avatar="https://randomuser.me/api/portraits/men/78.jpg" title="John Leider"></v-list-item>

        <v-divider></v-divider>

        <v-list density="compact" nav>
            <v-list-item prepend-icon="mdi-view-dashboard" title="Home" value="home"></v-list-item>
            <v-list-item prepend-icon="mdi-forum" title="About" value="about"></v-list-item>
        </v-list>
    </v-navigation-drawer> 
</template>

<script setup>
import { ref } from 'vue';


const open = ref(false);


defineProps({
    item: Object
})

// const openMenu = (() => {
//     if (open.value == true) {
//         return;
//     }

//     open.value = true;
// })

</script>

<style scoped>
.v-card {
    cursor: crosshair;
}
</style> -->


<template>
  <v-card class="mb-2">
    <v-card-text>{{ task }}</v-card-text>
  </v-card>
</template>

<script setup>
defineProps({
  task: String
})
</script>
