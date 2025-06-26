<template>
    <v-navigation-drawer :width="280" permanent style="box-shadow: 1px 0px 12px 3px rgba(0,0,0,0.08);" color="drawerColor">
        <v-list density="compact" nav>

            <h2 class="ml-3 mb-6 mt-3">CRM</h2>

            <v-list-item link title="Dashboard" prepend-icon="mdi-view-dashboard"></v-list-item>

            <v-list-item link title="Analytics" prepend-icon="mdi-chart-line"></v-list-item>

            <!-- ✅ List Group con toggle -->
            <v-list-group v-model="groupOpen" value="crm" prepend-icon="mdi-folder" title="CRM">
                <template #activator="{ props }">
                    <v-list-item v-bind="props" />
                </template>

                <v-list-item link title="Clientes"/>
                <v-list-item link title="Ventas" />
            </v-list-group>

        </v-list>
    </v-navigation-drawer>
</template>

<script setup>
import { ref } from 'vue'
const groupOpen = ref(false)

</script>
