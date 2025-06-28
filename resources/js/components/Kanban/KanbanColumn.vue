<template>
  <v-col cols="12" md="4">
    <v-card class="pa-2" outlined>
      <v-card-title>{{ title }}</v-card-title>
      <draggable
        v-model="internalTasks"
        group="tasks"
        item-key="task"
        @end="onDragEnd"
      >
        <template #item="{ element }">
          <KanbanCard :task="element" />
        </template>
      </draggable>
    </v-card>
  </v-col>
</template>

<script setup>
import { ref, watch } from 'vue'
import draggable from 'vuedraggable'
import KanbanCard from './KanbanCard.vue'

const props = defineProps({
  title: String,
  tasks: Array
})
const emit = defineEmits(['update-tasks'])

const internalTasks = ref([...props.tasks])

watch(() => props.tasks, (newTasks) => {
  internalTasks.value = [...newTasks]
})

function onDragEnd() {
  emit('update-tasks', internalTasks.value)
}
</script>

<style scoped>
.draggable-container {
  min-height: 100px;
}
</style>
