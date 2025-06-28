<template>
  <v-container fluid>
    <v-row>
      <KanbanColumn
        v-for="(column, index) in columns"
        :key="index"
        :title="column.title"
        :tasks="column.tasks"
        @update-tasks="updateTasks(index, $event)"
      />
    </v-row>
  </v-container>
</template>

<script setup>
import { reactive } from 'vue'
import KanbanColumn from './KanbanColumn.vue'

const columns = reactive([
  { title: 'Por hacer', tasks: ['Tarea 1', 'Tarea 2'] },
  { title: 'En progreso', tasks: ['Tarea 3'] },
  { title: 'Hecho', tasks: ['Tarea 4'] }
])

function updateTasks(index, tasks) {
  columns[index].tasks = tasks
}
</script>
