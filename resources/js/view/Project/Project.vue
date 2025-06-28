<script setup >
    import { useRouter } from 'vue-router';
    import KanbanBoard from '../../components/Kanban/KanbanBoard.vue';
    import VcBackButton from '../../components/global/BackButton.vue'
    const router = useRouter()


    const navigateToHome = (() => {
        router.push('/inicio')
    })
</script>

<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>
            <v-col cols="12" md="2" class="text-right">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>
        </v-row>
        <KanbanBoard></KanbanBoard>
    </v-container>
</template>