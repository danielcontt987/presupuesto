<template>
    <v-container fluid class="pa-6 mb-6">
        <!-- Header -->
        <v-row>
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome()"></vc-back-button>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <h1 class="text-h4 font-weight-bold mb-2">Project Board</h1>
                <p class="text-body-2 text-medium-emphasis">
                    Manage your tasks and track progress across different stages
                </p>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12" md="5">
                <v-btn color="success" class="mr-5" flat>Agregar Tarea</v-btn>
                <v-btn color="greenLight" flat>Agregar colaborador</v-btn>
            </v-col>
        </v-row>


        <!-- Kanban Columns -->
        <v-row class="flex-nowrap" style="overflow-x: auto;">
            <v-col v-for="col in columns" :key="col.id" cols="12" sm="4" md="3">
                <v-card class="pa-4 bg-background" flat
                    :class="dragOverColumn === col.id ? 'border-dashed border-primary' : ''"
                    @dragover.prevent="dragOverColumn = col.id" @dragleave="dragOverColumn = null"
                    @drop="onDropCard($event, col.id)">
                    <!-- Column Header -->
                    <div class="d-flex justify-space-between align-center mb-3">
                        <div class="d-flex align-center">
                            <span class="font-weight-medium">{{ col.title }}</span>
                            <v-chip size="small" class="ml-2">{{ col.cards.length }}</v-chip>
                        </div>
                        <v-menu>
                            <template #activator="{ props }">
                                <v-btn icon="mdi-dots-vertical" v-bind="props" size="small" variant="text"></v-btn>
                            </template>
                            <v-list>
                                <v-list-item @click="openColumnDialog(col)">
                                    <v-icon start icon="mdi-pencil"></v-icon> Edit Column
                                </v-list-item>
                                <v-list-item @click="deleteColumn(col.id)" class="text-error">
                                    <v-icon start icon="mdi-delete"></v-icon> Delete Column
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </div>

                    <!-- Cards -->
                    <div>
                        <v-card v-for="card in col.cards" flat :key="card.id" class="mb-3 pa-3" outlined
                            draggable="true" @dragstart="onDragStart($event, card.id)">
                            <div class="d-flex justify-space-between align-start mb-2">
                                <span class="font-weight-medium">{{ card.title }}</span>
                                <v-menu>
                                    <template #activator="{ props }">
                                        <v-btn icon="mdi-dots-horizontal" v-bind="props" size="x-small"
                                            variant="text"></v-btn>
                                    </template>
                                    <v-list>
                                        <v-list-item @click="openCardDialog(card, col.id)">
                                            <v-icon start icon="mdi-pencil"></v-icon> Edit
                                        </v-list-item>
                                        <v-list-item @click="deleteCard(card.id)" class="text-error">
                                            <v-icon start icon="mdi-delete"></v-icon> Delete
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </div>
                            <p v-if="card.description" class="text-caption mb-2">{{ card.description }}</p>
                            <!-- Avatares encimados -->
                            <div class="d-flex avatar-stack" v-if="card.assignees && card.assignees.length">
                                <!-- Mostramos solo los 3 primeros -->
                                <v-avatar v-for="(user, index) in card.assignees.slice(0, 3)" :key="index" size="24"
                                    :color="getColor(index)" class="stacked-avatar">
                                    <span class="text-caption">{{ getInitials(user) }}</span>
                                </v-avatar>

                                <!-- Si hay más de 3, mostrar +N -->
                                <v-avatar v-if="card.assignees.length > 3" size="24" color="grey-darken-1"
                                    class="stacked-avatar">
                                    <span class="text-caption">+{{ card.assignees.length - 3 }}</span>
                                </v-avatar>
                            </div>
                        </v-card>
                    </div>

                    <!-- Add Card Btn -->
                    <!-- <v-btn block variant="tonal" prepend-icon="mdi-plus" @click="openCardDialog(null, col.id)">
                        Añadir
                    </v-btn> -->
                </v-card>
            </v-col>

            <!-- Add Column -->
            <v-col class="flex-shrink-0" cols="12" sm="4" md="3">
                <v-btn block class="h-100 dashed-btn" variant="outlined" prepend-icon="mdi-plus"
                    @click="openColumnDialog()">
                    Agregar columna
                </v-btn>
            </v-col>
        </v-row>

        <!-- Card Dialog -->
        <v-dialog v-model="cardDialog" max-width="500">
            <v-card>
                <v-card-title>{{ editingCard ? "Edit Card" : "Create Card" }}</v-card-title>
                <v-card-text>
                    <v-text-field v-model="cardForm.title" label="Title"></v-text-field>
                    <v-textarea v-model="cardForm.description" label="Description"></v-textarea>
                    <v-select v-model="cardForm.priority" :items="['low', 'medium', 'high']"
                        label="Priority"></v-select>
                    <v-text-field v-model="cardForm.assignee" label="Assignee"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn text @click="closeCardDialog">Cancel</v-btn>
                    <v-btn color="primary" @click="saveCard">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Column Dialog -->
        <v-dialog v-model="columnDialog" max-width="400">
            <v-card>
                <v-card-title>{{ editingColumn ? "Edit Column" : "Create Column" }}</v-card-title>
                <v-card-text>
                    <v-text-field v-model="columnForm.title" label="Column Title"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn text @click="closeColumnDialog">Cancel</v-btn>
                    <v-btn color="primary" @click="saveColumn">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script setup>

import { ref, watch, onMounted } from "vue"
import VcBackButton from "@/components/global/BackButton.vue"
import { useRouter } from "vue-router"
const router = useRouter();

const STORAGE_KEY = "kanban-board-data"

// Colores predefinidos de Vuetify
const colors = ["red", "blue", "green", "purple", "indigo", "teal", "orange"];

// Función para obtener color basado en el índice
const getColor = (index) => colors[index % colors.length];

const initialData = [
    {
        id: "todo",
        title: "Pendiente",
        cards: [
            { id: "1", title: "Design landing page", description: "Wireframes and mockups", priority: "high", assignee: "Sarah Chen" },
            { id: "2", title: "Set up analytics", description: "Google Analytics setup", priority: "medium", assignee: "Mike Johnson" }
        ]
    },
    {
        id: "En",
        title: "En espera",
        cards: [
            {
                id: "3", title: "API Integration", description: "Connect with payment API", priority: "high", assignees: ["Juan Pérez", "María López", "Carlos Sánchez", "Ana Torres", "Luis Gómez"]
            }
        ]
    },
    {
        id: "En2",
        title: "En progreso",
        cards: [
            { id: "3", title: "API Integration", description: "Connect with payment API", priority: "high", assignee: "Alex Rodriguez" }
        ]
    },
    {
        id: "En3",
        title: "En revisión",
        cards: [
            { id: "3", title: "API Integration", description: "Connect with payment API", priority: "high", assignee: "Alex Rodriguez" }
        ]
    },
    {
        id: "En4",
        title: "Completado",
        cards: [
            { id: "3", title: "API Integration", description: "Connect with payment API", priority: "high", assignee: "Alex Rodriguez" }
        ]
    }
]

const columns = ref([])
const dragOverColumn = ref(null)

// Load data
onMounted(() => {
    const saved = localStorage.getItem(STORAGE_KEY)
    columns.value = saved ? JSON.parse(saved) : initialData
})

// Save data
watch(columns, (val) => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(val))
}, { deep: true })

// Helpers

const getInitials = (name) => name.split(" ").map(n => n[0]).join("")

// Drag & Drop
const draggedCardId = ref(null)

const onDragStart = (e, cardId) => {
    draggedCardId.value = cardId
}

const onDropCard = (e, targetColId) => {
    const cardId = draggedCardId.value
    if (!cardId) return

    let draggedCard = null
    let sourceColId = null

    columns.value.forEach(col => {
        const idx = col.cards.findIndex(c => c.id === cardId)
        if (idx !== -1) {
            draggedCard = col.cards[idx]
            sourceColId = col.id
            col.cards.splice(idx, 1)
        }
    })

    if (draggedCard && sourceColId !== targetColId) {
        const targetCol = columns.value.find(c => c.id === targetColId)
        targetCol.cards.push(draggedCard)
    }

    dragOverColumn.value = null
    draggedCardId.value = null
}

// -------------------
// Card Dialog
// -------------------
const cardDialog = ref(false)
const editingCard = ref(null)
const activeColumnId = ref(null)

const cardForm = ref({ title: "", description: "", priority: "medium", assignee: "" })

const openCardDialog = (card, columnId) => {
    editingCard.value = card
    activeColumnId.value = columnId
    cardForm.value = card ? { ...card } : { title: "", description: "", priority: "medium", assignee: "" }
    cardDialog.value = true
}

const closeCardDialog = () => {
    cardDialog.value = false
    editingCard.value = null
    activeColumnId.value = null
}

const saveCard = () => {
    if (!cardForm.value.title) return

    if (editingCard.value) {
        // Update
        columns.value.forEach(col => {
            const idx = col.cards.findIndex(c => c.id === editingCard.value.id)
            if (idx !== -1) col.cards[idx] = { ...editingCard.value, ...cardForm.value }
        })
    } else {
        // New
        const newCard = { ...cardForm.value, id: Date.now().toString() }
        const col = columns.value.find(c => c.id === activeColumnId.value)
        col.cards.push(newCard)
    }

    closeCardDialog()
}

const deleteCard = (cardId) => {
    columns.value.forEach(col => {
        col.cards = col.cards.filter(c => c.id !== cardId)
    })
}

// -------------------
// Column Dialog
// -------------------
const columnDialog = ref(false)
const editingColumn = ref(null)
const columnForm = ref({ title: "" })

const openColumnDialog = (col = null) => {
    editingColumn.value = col
    columnForm.value.title = col ? col.title : ""
    columnDialog.value = true
}

const closeColumnDialog = () => {
    columnDialog.value = false
    editingColumn.value = null
}

const saveColumn = () => {
    if (!columnForm.value.title) return
    if (editingColumn.value) {
        editingColumn.value.title = columnForm.value.title
    } else {
        columns.value.push({ id: Date.now().toString(), title: columnForm.value.title, cards: [] })
    }
    closeColumnDialog()
}

const deleteColumn = (colId) => {
    columns.value = columns.value.filter(c => c.id !== colId)
}

const navigateToHome = () => {
    router.push({ name: 'Planificador' });
}

</script>

<style scoped>
.dashed-btn {
    border: 2px dashed rgba(0, 0, 0, 0.12);
    height: 100%;
    min-height: 150px;
    color: rgba(0, 0, 0, 0.54);
}

.avatar-stack {
    display: flex;
}

.stacked-avatar {
    margin-left: -8px;
    /* se enciman */
    border: 2px solid white;
    /* borde para distinguirlos */
    z-index: 1;
}

.stacked-avatar:first-child {
    margin-left: 0;
}
</style>